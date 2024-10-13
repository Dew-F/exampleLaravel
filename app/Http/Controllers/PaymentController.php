<?php

namespace App\Http\Controllers;

use App\Models\Manager;
use App\Models\Order;
use App\Models\PaymentReceived;
use App\Models\Transaction;
use App\Notifications\Telegram;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function InitPayment(Request $request){
        $merchantid = config('services.paymaster.merchant');
        $description = 'Оплата заказа №'.$request->orderId.' от '.date("d.m.Y");
        $currency = 643;
        $amount = $request->sum;
        $orderid = $request->orderId;

        $url = 'https://paymaster.ru/payment/init?LMI_MERCHANT_ID='.$merchantid.'&LMI_PAYMENT_DESC='.$description.'&LMI_CURRENCY='.$currency.'&LMI_PAYMENT_AMOUNT='.$amount.'&LMI_PAYMENT_NO='.$orderid;
        return redirect($url);
    }

    public function GetPayment(Request $request){
        $text=date('d.m.y H:i:s').PHP_EOL.var_export($request->all(),true).PHP_EOL.PHP_EOL;

        //file_put_contents('payment_notification_post_log.txt',$text,FILE_APPEND);

        $paymentreceived = PaymentReceived::create([
            'merchant' => $request->LMI_MERCHANT_ID,
            'order_id' => $request->LMI_PAYMENT_NO,
            'amount_paid' => $request->LMI_PAID_AMOUNT,
            'description' => $request->LMI_PAYMENT_DESC,
            'payment_id' => $request->LMI_SYS_PAYMENT_ID,
            'date_paid' => $request->LMI_SYS_PAYMENT_DATE,
            'payer_id' => $request->LMI_PAYER_IDENTIFIER,
            'method' => $request->LMI_PAYMENT_METHOD,
            'payer_ip' => $request->LMI_PAYER_IP_ADDRESS,
            'hash' => $request->LMI_HASH,
        ]);

        $errors = '';
        $errorCount = 0;

        $transaction = Transaction::where('order_id', $request->LMI_PAYMENT_NO)->first();

        if (!isset($transaction)) {
            $errors .= '- Транзакции #'.$request->LMI_PAYMENT_NO.' не существует.'.PHP_EOL;
            $errorCount++;
        }
        if (isset($transaction) && $transaction->amount_paid > 0) {
            $errors .= '- Этот платеж уже был получен полностью или частично'.PHP_EOL;
            $errorCount++;
        }
        if ($request->LMI_MERCHANT_ID != config('services.paymaster.merchant')) {
            $errors .= '- Merchant ID не совпадает'.PHP_EOL;
            $errorCount++;
        }
        if ($request->LMI_HASH != $this->MakeHash($request)) {
            $errors .= '- Хэши не совпадают'.PHP_EOL;
            $errorCount++;
        }

        if ($errorCount > 0) {
            $text=date('d.m.y_H:i:s').' платеж не принят:'.$errors.PHP_EOL.PHP_EOL;
            //file_put_contents('payment_notification_error_log.txt',$text,FILE_APPEND);
            $paymentreceived->update([
                'errors' => $errors
            ]);
        } else {
            $transaction->update([
                'amount_paid' => $request->LMI_PAID_AMOUNT,
                'description' => $request->LMI_PAYMENT_DESC,
                'payment_id' => $request->LMI_SYS_PAYMENT_ID,
                'date_paid' => $request->LMI_SYS_PAYMENT_DATE,
                'payer_id' => $request->LMI_PAYER_IDENTIFIER,
                'method' => $request->LMI_PAYMENT_METHOD,
                'payer_ip' => $request->LMI_PAYER_IP_ADDRESS,
                'hash' => $request->LMI_HASH,
            ]);

            $this->PaymentSuccess($request->LMI_PAYMENT_NO);
        }
    }

    protected function MakeHash($request){
        //...NotForPublic
        return $hash;
    }

    public function PaymentSuccess($orderId){
        $order = Order::where('id', $orderId)->first();
        if (isset($order)) {
            $order->update([
                'pay_status' => 1
            ]);
            $managers = Manager::where('active', 1)->get();
            $tgview = 'telegram.paidorder';
            $data = ['orderId' => $order->id, 'sum' => $order->total];
            foreach ($managers as $manager) {
                $manager->notify(new Telegram($data, $tgview));
            }
        }
    }
}
