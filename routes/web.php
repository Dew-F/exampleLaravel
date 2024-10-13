<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::group(['namespace' => 'App\Http\Controllers'], function()
{
    //Все
    Route::group([], function() {
        Route::get('/', 'HomeController@ShowHome')->name('home');

        Route::get('production', 'CategoryController@ShowProduction')->name('production');

        Route::get('contacts', function () {
            return view('pages.contacts');
        });

        Route::get('payments', function () {
            return view('pages.payments');
        });

        Route::match(array('GET', 'POST'), 'order/complete', 'CartController@CompleteShow')->name('order.complete');
        Route::match(array('GET', 'POST'), 'order/fail', 'CartController@FailShow')->name('order.fail');

        Route::get('about', 'AboutController@Show');

        Route::get('product/{slug}', 'ProductController@Show')->name('product.show');

        Route::get('category/{slug}', 'CategoryController@Show')->where('slug', '.+')->name('category.show');

        //Новости
        Route::get('news', 'NewsController@ShowNews')->name('news.show');
        Route::get('news/{id}', 'NewsController@ShowNew')->where('id', '.+')->name('new.show');

        //Поиск
        Route::get('search', 'HomeController@Search')->name('search');

        //Заказ кастома
        Route::get('custom', function () {
            return view('pages.custom');
        })->name('custom');
        Route::post('custom/send', 'CustomController@Send')->name('custom.send');

        //Заказ звонка
        Route::get('callback', function () {
            return view('pages.callback');
        });
        Route::post('callback/send', 'CallbackController@Send')->name('callback.send');

        //Корзина
        Route::get('cart', 'CartController@Show')->name('cart');
        Route::post('cart/add', 'CartController@AddToCart')->name('addtocart');
        Route::post('cart/del', 'CartController@DelToCart')->name('deltocart');
        Route::post('cart/update', 'CartController@UpdateToCart')->name('updatetocart');
        Route::post('cart/clear', 'CartController@ClearCart')->name('clearcart');
        Route::post('cart/order', 'CartController@OrderSend')->name('order.send');
        Route::post('cart/updatesum', 'CartController@UpdateSum')->name('order.sum');

        //Оплата
        Route::get('payment', 'PaymentController@InitPayment')->name('order.payment');
        Route::post('paymentapi', 'PaymentController@GetPayment')->name('paymentapi');

        //Телеграм
        Route::post('webhook', 'WebhookController@index');

        //Фильтр
        Route::post('filter/category', 'FilterController@ApplyCategoryFilter')->name('applycategoryfilter');
        Route::get('filter/apply', 'FilterController@ApplyFilter')->name('applyfilter');

        //Сайтмапа
        Route::get('sitemap.xml', 'SitemapController@index');
    });

    //Гость
    Route::group(['middleware' => ['guest']], function () {
        //Авторизация
        Route::get('login', function () {
            return view('pages.login');
        })->name('login.show');

        Route::post('auth/login', 'AuthorizationController@Auth')->name('auth.login');

        //Регистрация
        Route::get('registration', function () {
            return view('pages.registration');
        });

        Route::post('registration/create', 'RegistrationController@Create')->name('registration.create');

        //Восстановление пароля
        Route::get('forget', function () {
            return view('pages.forget');
        })->name('password.request');

        Route::post('forget', 'AuthorizationController@PasswordRequest')->name('password.email');

        Route::get('/reset-password/{token}', function (string $token) {
            return view('pages.reset-password', ['token' => $token]);
        })->name('password.reset');

        Route::post('/reset-password', 'AuthorizationController@PasswordReset')->name('password.update');
    });

    //Авторизованный
    Route::group(['middleware' => ['auth']], function () {

        Route::get('auth/logout', 'AuthorizationController@Logout')->name('auth.logout');

        //Изменение пароля
        Route::get('changepassword', function () {
            return view('pages.changepassword');
        })->name('changepass.show');

        Route::post('auth/changepass', 'AuthorizationController@ChangePass')->name('auth.changepass');
    });
});


