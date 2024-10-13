<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'uid';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;


    protected $fillable = [
        'uid',
        'name',
        'slug',
        'price',
        'description',
        'article',
        'availability',
        'category_uid',
        'video',
        'category_type_id'
    ];

    public function getRouteAttribute()
    {
        return url('/').'/product/'.$this->slug;
    }

    public function retailPrice(){
        return $this->hasMany(ProductPrice::class)->where('price_uid', 'dc73e5d2-de64-11e7-8e27-00505601212a')->first()->price ?? 0;
    }

    public function wholesalePrice(){
        return $this->hasMany(ProductPrice::class)->where('price_uid', 'e2a9586c-ffca-11e7-8d82-00505601212a')->first()->price ?? 0;
    }

    public function smallWholesalePrice(){
        return $this->hasMany(ProductPrice::class)->where('price_uid', 'e48d7a97-0f8b-11eb-811e-0050569b2c8d')->first()->price ?? 0;
    }

    public function getPrice(){
        $pricetype = (new Cart)->getPriceType();
        if ($pricetype == 3 && $this->wholesalePrice() != 0) {
            $price = $this->wholesalePrice();
        } else if ($pricetype == 2 && $this->smallWholesalePrice() != 0) {
            $price = $this->smallWholesalePrice();
        } else {
            $price = $this->retailPrice();
        }

        return $price;
    }

    public function getPriceByType($pricetype){
        if ($pricetype == 3 && $this->wholesalePrice() != 0) {
            $price = $this->wholesalePrice();
        } else if ($pricetype == 2 && $this->smallWholesalePrice() != 0) {
            $price = $this->smallWholesalePrice();
        } else {
            $price = $this->retailPrice();
        }

        return $price;
    }

    public function category() {
        return $this->belongsTo(Category::class, 'category_uid');
    }

    public function photo() {
        return count(glob(public_path().'/storage/images/'.$this->uid.'*-1.*')) > 0 ? asset('/storage/images/'.basename(glob(public_path().'/storage/images/'.$this->uid.'*-1.*')[0])) : asset('/storage/images/structure/nophoto.png');
    }
}
