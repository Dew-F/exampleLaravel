<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RegistrationController extends Controller
{
    public function Create(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'city' => 'required|string|max:50',
            'address' => 'nullable|string|max:255',
            'password' => 'required|string|confirmed',
            'password_confirmation' => 'required|string',
        ], [
            'email.unique' => 'Пользователь с таким email уже зарегистрирован',
            'email.email' => 'Адрес электронный почты указан в неверном формате ',
            'password.confirmed' => 'Пароли не совпадают',
            'password.min' => 'Пароль должен содержать как минимум 8 символов',
        ]);

        User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'city' => $request->city,
            'address' => $request->address,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        return redirect()->route('login.show')->with('success', 'Вы успешно зарегистрировались');
    }
}
