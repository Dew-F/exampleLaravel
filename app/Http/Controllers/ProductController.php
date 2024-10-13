<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttributeValue;
use App\Models\ProductPrice;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function Show($slug){
        $product = Product::all()->where('slug', $slug)->first();
        $productAttributes = ProductAttributeValue::all()->where('product_uid', $product->uid);
        $attributes = Attribute::all();
        $attributeValues = AttributeValue::all();
        $category = Category::where('uid', $product->category_uid)->first();
        $categorytype = $category->category_type_id;
        $categories = $category->parenttree();
        $categories = array_reverse($categories);
        $carouselProducts = Product::orderBy('updated_at', 'desc')->where('active', true)->where('category_uid', $product->category_uid)->where('uid', '<>', $product->uid)->take(20)->get();
        $productsuid = $carouselProducts->pluck('uid')->toArray();
        $productprice = ProductPrice::whereIn('product_uid', $productsuid)->get();
        $cart = Cart::where('session_id', session()->getId());
        $sumPrice = 0;
        if (isset($cart)) {
            foreach($cart->get() as $cartproduct) {
                $sumPrice += $cartproduct->product->retailPrice() * $cartproduct->count;
            }
        }
        return view('modules.product')->with(compact('carouselProducts'))->with(compact('product'))
        ->with(compact('productAttributes'))->with(compact('attributes'))->with(compact('attributeValues'))
        ->with(compact('categories'))->with(compact('productprice'))->with(compact('cart'))->with(compact('categorytype'))->with(compact('sumPrice'));
    }

}
