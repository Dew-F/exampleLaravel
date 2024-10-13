<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Custom;
use App\Models\Manager;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Notifications\Telegram;
use Illuminate\Support\Facades\Http;
use NotificationChannels\Telegram\TelegramUpdates;

class WebhookController extends Controller
{
    public function index(Request $request) {
        //API
        $url = "https://api.telegram.org/bot".config('services.telegram-bot-api.token');

        //Если ответ от кнопки
        if ($request->callback_query && $request->callback_query['data']) {

            $type = explode('|', $request->callback_query['data'])[0];
            $number = explode('|', $request->callback_query['data'])[1];
            $applymanager = Manager::where('telegram_id', $request->callback_query['from']['id'])->first();

            //Если тип order
            if ($type == 'order') {
                $order = Order::where('id', $number)->first();
                if (!$order) {
                    //Отправляю сообщение о том что заказ был удален
                    Http::post($url.'/sendMessage', [
                        'chat_id' => $request->callback_query['from']['id'],
                        'text' => "Этот заказ удален администратором!",
                        'parse_mode' => 'html',
                    ]);
                    return true;
                }
                //Проверяю не приняли ли еще заказ
                if ($order->order_status == 0) {
                    $carts = OrderProduct::where('order_id', $order->id)->get();
                    $managers = Manager::where('active', 1)->get();
                    //Обновляю в бд менеджера
                    $order->update([
                        'manager_id' => $applymanager->id,
                        'order_status' => 1
                    ]);
                    //Убираю кнопку
                    Http::post($url.'/editMessageText', [
                        'chat_id' => $request->callback_query['from']['id'],
                        'text' => (string) view('telegram.orderinfo', ['manager' => $applymanager, 'order' => $order, 'carts' => $carts]),
                        'parse_mode' => 'html',
                        'message_id' => $request->callback_query['message']['message_id']
                    ]);
                    //Рассылаю сообщение
                    foreach ($managers as $manager) {
                        Http::post($url.'/sendMessage', [
                            'chat_id' => $manager->telegram_id,
                            'text' => $applymanager->name.' принял(а) заказ №'.$order->id,
                            'parse_mode' => 'html',
                        ]);
                    }
                } else {
                    //Отправляю сообщение о том что заказ уже принят
                    Http::post($url.'/sendMessage', [
                        'chat_id' => $request->callback_query['from']['id'],
                        'text' => "Этот заказ уже принял(а) другой менеджер!",
                        'parse_mode' => 'html',
                    ]);
                }
            } else if ($type == 'callback') {
                $callback = Custom::where('id', $number)->first();
                if (!$callback) {
                    //Отправляю сообщение о том что заказ был удален
                    Http::post($url.'/sendMessage', [
                        'chat_id' => $request->callback_query['from']['id'],
                        'text' => "Этот заказ удален администратором!",
                        'parse_mode' => 'html',
                    ]);
                    return true;
                }
                //Проверяю не приняли ли еще заказ
                if ($callback->manager_id == NULL) {
                    $managers = Manager::where('active', 1)->get();
                    //Обновляю в бд менеджера
                    $callback->update([
                        'manager_id' => $applymanager->id,
                    ]);
                    //Убираю кнопку
                    Http::post($url.'/editMessageText', [
                        'chat_id' => $request->callback_query['from']['id'],
                        'text' => (string) view('telegram.callbackinfo', ['custom' => $callback]),
                        'parse_mode' => 'html',
                        'message_id' => $request->callback_query['message']['message_id']
                    ]);
                    //Рассылаю сообщение
                    foreach ($managers as $manager) {
                        Http::post($url.'/sendMessage', [
                            'chat_id' => $manager->telegram_id,
                            'text' => $applymanager->name.' принял(а) заявку на обратный звонок №'.$callback->id,
                            'parse_mode' => 'html',
                        ]);
                    }
                } else {
                    //Отправляю сообщение о том что заказ уже принят
                    Http::post($url.'/sendMessage', [
                        'chat_id' => $request->callback_query['from']['id'],
                        'text' => "Эту заявку уже принял(а) другой менеджер!",
                        'parse_mode' => 'html',
                    ]);
                }
            } else if ($type == 'custom') {
                $custom = Custom::where('id', $number)->first();
                if (!$custom) {
                    //Отправляю сообщение о том что заказ был удален
                    Http::post($url.'/sendMessage', [
                        'chat_id' => $request->callback_query['from']['id'],
                        'text' => "Этот заказ удален администратором!",
                        'parse_mode' => 'html',
                    ]);
                    return true;
                }
                //Проверяю не приняли ли еще заказ
                if ($custom->manager_id == NULL) {
                    $managers = Manager::where('active', 1)->get();
                    //Обновляю в бд менеджера
                    $custom->update([
                        'manager_id' => $applymanager->id,
                    ]);
                    //Убираю кнопку
                    Http::post($url.'/editMessageText', [
                        'chat_id' => $request->callback_query['from']['id'],
                        'text' => (string) view('telegram.custominfo', ['custom' => $custom]),
                        'parse_mode' => 'html',
                        'message_id' => $request->callback_query['message']['message_id']
                    ]);
                    //Рассылаю сообщение
                    foreach ($managers as $manager) {
                        Http::post($url.'/sendMessage', [
                            'chat_id' => $manager->telegram_id,
                            'text' => $applymanager->name.' принял(а) заявку на индивидуальный заказ №'.$custom->id,
                            'parse_mode' => 'html',
                        ]);
                    }
                } else {
                    //Отправляю сообщение о том что заказ уже принят
                    Http::post($url.'/sendMessage', [
                        'chat_id' => $request->callback_query['from']['id'],
                        'text' => "Эту заявку уже принял(а) другой менеджер!",
                        'parse_mode' => 'html',
                    ]);
                }
            } else {
                //Отправляю сообщение о ошибке
                Http::post($url.'/sendMessage', [
                    'chat_id' => $request->callback_query['from']['id'],
                    'text' => "Ошибка, обратитесь к администратору!",
                    'parse_mode' => 'html',
                ]);
            }
        }
        return true;
    }
}
