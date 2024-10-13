<?php

namespace App\Http\Controllers;

use App\Jobs\DeleteOrderTable;
use App\Jobs\GenerateOrderTable;
use App\Jobs\SendMailQueue;
use App\Mail\SendMail;
use App\Models\Cart;
use App\Models\Manager;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Price;
use App\Models\Product;
use App\Models\Transaction;
use App\Notifications\Telegram;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Mail;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class CartController extends Controller
{
    public function Show(){
        $cart = new Cart;
        $carts = $cart->getCart();
        $sum = $cart->getSum();
        $productsuid = $carts->pluck('product_uid')->toArray();

        $managers = Manager::where('active', true)->where('display', true)->get();

        return view('pages.cart')->with(compact('carts'))->with(compact('sum'))->with(compact('managers'));
    }

    public function AddToCart(Request $request)
    {
        Product::findOrFail($request->product_uid);

        if (Auth::check()){
            Cart::create([
                'product_uid' => $request->product_uid,
                'session_id' => session()->getId(),
                'user_id' => Auth::id(),
                'count' => $request->count
            ]);
        } else {
            Cart::create([
                'product_uid' => $request->product_uid,
                'session_id' => session()->getId(),
                'count' => $request->count
            ]);
        }


        session(['cartcount' => session('cartcount')+1]);

        return response()->json([
            'product_uid' => $request->product_uid,
            'count' => $request->count
        ], 200);
    }

    public function UpdateToCart(Request $request)
    {
        Product::findOrFail($request->product_uid);

        $countedit = $request->count - Cart::where('session_id', session()->getId())->where('product_uid', $request->product_uid)->first()->count;

        Cart::where('session_id', session()->getId())->where('product_uid', $request->product_uid)->first()->update([
            'product_uid' => $request->product_uid,
            'session_id' => session()->getId(),
            'count' => $request->count
        ]);

        $cart_model = (new Cart);

        $carts = $cart_model->getCart();

        $sum = $cart_model->getSum();

        $product = $carts->where('product_uid', $request->product_uid)->first()->product;

        return response()->json([
            'product_uid' => $request->product_uid,
            'count' => $request->count,
            'countedit' => $countedit,
            'price' => $product->getPrice(),
            'sum' => $sum,
            'retail_price' => $product->retailPrice()
        ], 200);
    }

    public function DelToCart(Request $request){
        Product::findOrFail($request->product_uid);

        Cart::where('session_id', session()->getId())->where('product_uid', $request->product_uid)->first()->delete();

        session(['cartcount' => session('cartcount')-1]);

        $cart_model = (new Cart);

        $carts = $cart_model->getCart();

        $sum = $cart_model->getSum();

        return response()->json([
            'product_uid' => $request->product_uid,
            'count' => $request->count,
            'sum' => $sum
        ], 200);
    }

    public function ClearCart(){
        Cart::where('session_id', session()->getId())->delete();

        session(['cartcount' => 0]);

        return response()->json([], 200);
    }

    public function OrderSend(Request $request){
        $request->validate([
            'email' => 'required|string|email|max:255',
            'fullname' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'g-recaptcha-response' => 'required|captcha'
        ], [
            'email.email' => 'Адрес электронный почты указан в неверном формате ',
            'g-recaptcha-response' => 'Введите капчу'
        ]);

        $cart_model = (new Cart);

        $carts = $cart_model->getCart();

        $sum = $cart_model->getSum();

        switch($cart_model->getPriceType()){
            case 1:
                $price_type = 'dc73e5d2-de64-11e7-8e27-00505601212a';
                break;
            case 2:
                $price_type = 'e48d7a97-0f8b-11eb-811e-0050569b2c8d';
                break;
            case 3:
                $price_type = 'e2a9586c-ffca-11e7-8d82-00505601212a';
                break;
        }

        $order = Order::create([
            'full_name' => $request->fullname,
            'telephone' => $request->phone,
            'manager_id' => $request->manager,
            'email' => $request->email,
            'total' => $sum,
            'order_status' => 0,
            'price_uid' => $price_type
        ]);

        foreach ($carts as $cart) {
            OrderProduct::create([
                'order_id' => $order->id,
                'product_uid' => $cart->product->uid,
                'count' => $cart->count
            ]);
        }

        //Письмо покупателю
        $data = ['sum' => $sum, 'order' => $order, 'carts' => $carts, 'manager' => $order->manager, 'priceType' => $cart_model->getPriceType()];
        $toemail = $order->email;
        $subject = 'Заказ №'.$order->id.' на сайте LOCALHOST.RU';
        $view = 'mail.ordermail';

        Mail::to($toemail)->queue(new SendMail($data, $subject, $view));

        //Генерация xsls
        GenerateOrderTable::dispatch(OrderProduct::where('order_id', $order->id)->get(), $order->id, $cart_model->getPriceType());

        //Письмо админам
        $subject = 'Новый заказ №'.$order->id;
        $view = 'mail.orderinfomail';
        $tgview = 'telegram.orderinfo';
        $admins = Manager::where('active', 1)->where('is_admin', 1)->get();
        $file = storage_path('app/public/tmp/report'.$order->id.'.xlsx');

        foreach ($admins as $admin) {
            $toemail = $admin->mail;
            Mail::to($toemail)->queue(new SendMail($data, $subject, $view, $file));
            $admin->notify(new Telegram($data, $tgview));
        }

        //Письмо менеджеру
        if (isset($order->manager)) {
            //Если выбран менеджер
            $toemail = $order->manager->mail;
            Mail::to($toemail)->queue(new SendMail($data, $subject, $view, $file));
            $order->manager->notify(new Telegram($data, $tgview, 'Принять', 'order|'.$order->id));
        } else {
            //Если выбран любой менеджер
            $managers = Manager::where('active', 1)->where('is_admin', 0)->get();
            foreach ($managers as $manager) {
                $toemail = $manager->mail;
                Mail::to($toemail)->queue(new SendMail($data, $subject, $view, $file));
                $manager->notify(new Telegram($data, $tgview, 'Принять', 'order|'.$order->id));
            }
        }

        //Удаление временной таблицы
        DeleteOrderTable::dispatch($order->id);

        $canPay = $cart_model->canPay();

        //Очистка корзины
        Cart::where('session_id', session()->getId())->delete();

        session(['cartcount' => 0]);

        //Оплата
        if($request->payonline) {
            if ($canPay) {
                $transaction = Transaction::firstOrCreate([
                    'order_id' => $order->id,
                    'amount_invoiced' => $order->total,
                    'description' => 'Оплата заказа №'.$order->id.' от '.date("d.m.Y"),
                ]);
                if ($transaction->amount_paid == $transaction->amount_invoiced) return redirect(route('order.complete'))->with('text', 'Этот заказ уже оплачен');
                if ($transaction->amount_paid > 0) return redirect(route('order.complete'))->with('text', 'Похоже, этот заказ оплачен только частично. Пожалуйста, свяжитесь с менеджером.');
                return redirect(route('order.payment').'?orderId='.$order->id.'&sum='.$order->total);
            } else {
                return redirect(route('order.complete'))->with('text', 'Заказ содержит товары с нулевой ценой, поэтому оплатить его онлайн нельзя. С вами свяжется менеджер для обсуждения деталей.<br>Приносим извинения за неудобства. <br><br>Заказ №'.$order->id.' зарегистрирован.<br>Проверьте вашу почту');
            }
        } else {
            return redirect(route('order.complete'))->with('text', 'Готово!<br> Заказ №'.$order->id.' зарегистрирован.<br> Проверьте вашу почту');
        }
    }

    public function CompleteShow(Request $request){
        $text = "";
        if ($request->LMI_PAYMENT_NO != '') {
            $text = 'Готово!<br> Заказ №'.$request->LMI_PAYMENT_NO.' зарегистрирован и оплачен.<br> Проверьте вашу почту';
        }
        return view('pages.order-complete')->with(compact('text'));
    }

    public function FailShow(Request $request){
        $text = "";
        if ($request->LMI_PAYMENT_NO != '') $text = 'Заказ №'.$request->LMI_PAYMENT_NO.' был зарегистрирован, но его не удалось оплатить.<br>Проверьте вашу почту.';
        return view('pages.order-complete')->with(compact('text'));
    }
}
