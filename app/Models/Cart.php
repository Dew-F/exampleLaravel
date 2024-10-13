<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Cart extends Model
{
    use HasFactory;

    public $table = 'cart';

    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = [
        'product_uid',
        'session_id',
        'count',
        'user_id'
    ];

    protected $guarded = [
        'id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getCart(){
        if (Auth::check()){
            $carts = Cart::where('user_id', Auth::id())->get();
            foreach($carts as $cart) {
                $cart->update([
                    'session_id' => session()->getId(),
                ]);
            }
            session(['cartcount' => $carts->count()]);
        } else {
            $carts = Cart::where('session_id', session()->getId())->get();
        }

        return $carts;
    }

    public function getSum(){
        $sum = 0;
        foreach ($this->getCart() as $cart) {
            $sum += $cart->product->getPrice() * $cart->count;
        }
        return $sum;
    }

    public function getPriceType(){
        $carts = $this->getCart();
        $sumPrice = 0;
        if (isset($carts)) {
            foreach($carts as $cartproduct) {
                $sumPrice += $cartproduct->product->retailPrice() * $cartproduct->count;
            }
        }
        if ($sumPrice >= 60000) {
            $pricetype = 3;
        } else if ($sumPrice >= 30000) {
            $pricetype = 2;
        } else {
            $pricetype = 1;
        }

        return $pricetype;
    }

    public function canPay(){
        $carts = $this->getCart();
        $canPay = true;
        foreach ($carts as $cart){
            if ($cart->product->getPrice() == 0) {
                $canPay = false;
            }
        }
        return $canPay;
    }
}
