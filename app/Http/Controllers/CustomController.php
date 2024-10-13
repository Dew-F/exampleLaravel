<?php

namespace App\Http\Controllers;

use App\Models\Custom;
use App\Models\Manager;
use App\Notifications\Telegram;
use Illuminate\Http\Request;

class CustomController extends Controller
{
    public function Send(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'email' => 'required|string|email|max:255',
            'description' => 'required|string|max:10000',
            'g-recaptcha-response' => 'required|captcha'
        ],
        [
            'email.email' => 'Адрес электронный почты указан в неверном формате ',
            'g-recaptcha-response' => 'Введите капчу'
        ]);

        $custom = Custom::create([
            'fullname' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'text' => $request->description,
            'product_uid' => $request->sample
        ]);

        //Письмо админам
        $tgview = 'telegram.custominfo';
        $admins = Manager::where('active', 1)->where('is_admin', 1)->get();
        $data = ['custom' => $custom];

        foreach ($admins as $admin) {
            $admin->notify(new Telegram($data, $tgview));
        }

        //Письмо менеджерам
        $managers = Manager::where('active', 1)->where('is_admin', 0)->get();
        foreach ($managers as $manager) {
            $manager->notify(new Telegram($data, $tgview, 'Принять', 'custom|'.$custom->id));
        }

        return back()->with('success', 'Заявка отправлена!');
    }
}
