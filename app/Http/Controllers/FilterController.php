<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttributeValue;
use App\Models\ProductPrice;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function ApplyCategoryFilter(Request $request){
        $attributes = Attribute::where('category_uid', $request->uid)->get();
        $attrvalues = AttributeValue::whereIn('attribute_uid',$attributes->pluck('uid')->toArray())->get();

        return response()->json([
            'attributes' => $attributes,
            'attrvalues' => $attrvalues
        ], 200);
    }

    public function ApplyFilter(Request $request){

        if ($request->attrvalues == null) {
            $products = Product::where('active', true)->WhereIn('category_uid', $request->categories)->paginate(32);
        } else {
            $productattributevalues = ProductAttributeValue::whereIn('attribute_value_uid', $request->attrvalues)->get();
            $productattributevaluesuids = $productattributevalues->pluck('product_uid')->toArray();
            $categoriesuids = $request->categories;
            $products = Product::where('active', true)->WhereIn('category_uid', $request->categories)->WhereIn('uid', $productattributevalues->pluck('product_uid')->toArray())->paginate(32);
        }

        $productsuid = $products->pluck('uid')->toArray();
        $productprice = ProductPrice::whereIn('product_uid', $productsuid)->get();
        $cart = Cart::where('session_id', session()->getId())->get();

        $fcategories = Category::whereIn('uid', $request->categories)->get();
        foreach ($fcategories as $category) {
            $fcategories = $fcategories->merge($category->children);
        }
        $fattributes = Attribute::all();
        $fattributevalues = AttributeValue::all();

        $filter = $request;

        $categorytype = 1;

        return view('pages.category')->with(compact('products'))->with(compact('productprice'))->with(compact('cart'))
        ->with(compact('fcategories'))->with(compact('fattributes'))->with(compact('fattributevalues'))
        ->with(compact('filter'))->with(compact('categorytype'));
    }
}
