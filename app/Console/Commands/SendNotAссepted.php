<?php

namespace App\Console\Commands;

use App\Models\Custom;
use App\Models\Manager;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Notifications\Telegram;
use Illuminate\Console\Command;

class SendNotAссepted extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-not-aссepted';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send not accepted orders, customs and callbacks';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //Рассылка заказов
        $orders = Order::where('order_status', 0)->get();
        $tgview = 'telegram.notapplyorder';
        foreach ($orders as $order) {
            $orderproducts = OrderProduct::where('order_id', $order->id)->get();
            $data = ['sum' => $order->sum, 'order' => $order, 'carts' => $orderproducts, 'manager' => $order->manager];
            //Письмо менеджеру
            if (isset($order->manager)) {
                //Если выбран менеджер
                $order->manager->notify(new Telegram($data, $tgview, 'Принять', 'order|'.$order->id));
            } else {
                //Если выбран любой менеджер
                $managers = Manager::where('active', 1)->where('is_admin', 0)->get();
                foreach ($managers as $manager) {
                    $manager->notify(new Telegram($data, $tgview, 'Принять', 'order|'.$order->id));
                }
            }
        }
        //Рассылка заявок на звонки
        $callbacks = Custom::whereNull('manager_id')->whereNull('email')->get();
        $tgview = 'telegram.notapplycallback';
        foreach ($callbacks as $callback) {
            $data = ['custom' => $callback];
            //Письмо менеджерам
            $managers = Manager::where('active', 1)->where('is_admin', 0)->get();
            foreach ($managers as $manager) {
                $manager->notify(new Telegram($data, $tgview, 'Принять', 'callback|'.$callback->id));
            }
        }
        //Рассылка заявок на кастомы
        $customs = Custom::whereNull('manager_id')->whereNotNull('email')->get();
        $tgview = 'telegram.notapplycustom';
        foreach ($customs as $custom) {
            $data = ['custom' => $custom];
            //Письмо менеджерам
            $managers = Manager::where('active', 1)->where('is_admin', 0)->get();
            foreach ($managers as $manager) {
                $manager->notify(new Telegram($data, $tgview, 'Принять', 'custom|'.$custom->id));
            }
        }
        //Рассылка админам
        if ($customs->count() > 0 || $orders->count() > 0|| $callbacks->count() > 0){
            $tgview = 'telegram.notapplied';
            $data = ['customs' => $customs, 'orders' => $orders, 'callbacks' => $callbacks];
            $managers = Manager::where('active', 1)->where('is_admin', 1)->get();
            foreach ($managers as $manager) {
                $manager->notify(new Telegram($data, $tgview));
            }
        }

    }
}
