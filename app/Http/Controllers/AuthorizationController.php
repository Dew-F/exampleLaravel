<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Rules\ReCaptchaRule;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;

use function PHPUnit\Framework\isNull;

class AuthorizationController extends Controller
{
    public function Auth(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials  = $request->only(['email', 'password']);

        $user = User::where('email', $request->email)->first();

        $carts = Cart::where('session_id', session()->getId())->get();

        if (isset($user)){
            if ($user->salt == "" && Auth::attempt($credentials)) {
                foreach($carts as $cart) {
                    $cart->update([
                        'user_id' => $user->id,
                    ]);
                }
                return redirect()->route('home');
            } else {
                if (hash("sha512", $request->password.$user->salt) == $user->password && Auth::loginUsingId($user->id, true)) {
                    foreach($carts as $cart) {
                        $cart->update([
                            'user_id' => $user->id,
                        ]);
                    }
                    return redirect()->route('home');
                }
            }
        }

        return back()->withErrors('Неверный логин или пароль');
    }

    public function ChangePass(Request $request)
    {
        $request->validate([
            'password' => 'required|string|confirmed',
            'password_confirmation' => 'required|string',
            'g-recaptcha-response' => 'required|captcha'
        ], [
            'password.confirmed' => 'Пароли не совпадают',
            'password.min' => 'Пароль должен содержать как минимум 8 символов',
            'g-recaptcha-response' => 'Введите капчу'
        ]);

        User::all()->where('id', Auth::id())->first()->update(
            [
                'password' => $request->password,
                'salt' => Null
            ]
        );

        return back()->with('success', 'Пароль изменен!');
    }

    function PasswordRequest(Request $request) {
        $request->validate([
            'email' => 'required|string|email',
            'g-recaptcha-response' => 'required|captcha'
        ], [
            'g-recaptcha-response' => 'Введите капчу',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status), 'success' => 'Запрос изменения пароля выслан на вашу почту!'])
                    : back()->withErrors(['email' => __($status)]);
    }

    function PasswordReset(Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'g-recaptcha-response' => 'required|captcha'
        ], [
            'g-recaptcha-response' => 'Введите капчу'
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'salt' => Null
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login.show')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }

    public function Logout() {
        Auth::logout();
        return redirect()->route('home');
    }
}
