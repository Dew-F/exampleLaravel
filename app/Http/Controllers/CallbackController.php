<?php

namespace App\Http\Controllers;

use App\Models\Custom;
use App\Models\Manager;
use App\Notifications\Telegram;
use Illuminate\Http\Request;

class CallbackController extends Controller
{
    public function Send(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'g-recaptcha-response' => 'required|captcha'
        ],
        [
            'email.email' => 'Адрес электронный почты указан в неверном формате ',
            'g-recaptcha-response' => 'Введите капчу'
        ]);

        $custom = Custom::create([
            'fullname' => $request->name,
            'phone' => $request->phone,
            'text' => 'Заказ звонка'
        ]);

        //Письмо админам
        $tgview = 'telegram.callbackinfo';
        $admins = Manager::where('active', 1)->where('is_admin', 1)->get();
        $data = ['custom' => $custom];

        foreach ($admins as $admin) {
            $admin->notify(new Telegram($data, $tgview));
        }

        //Письмо менеджерам
        $managers = Manager::where('active', 1)->where('is_admin', 0)->get();
        foreach ($managers as $manager) {
            $manager->notify(new Telegram($data, $tgview, 'Принять', 'callback|'.$custom->id));
        }

        return back()->with('success', 'Заявка отправлена!');
    }
}
