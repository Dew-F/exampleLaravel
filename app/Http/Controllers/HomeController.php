<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttributeValue;
use App\Models\ProductPrice;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function ShowHome(){
        $home = $this;

        $carouselProducts = Product::orderBy('availability', 'desc')->where('active', true)->where('category_type_id', 1)->take(20)->get();

        $productCategory = Category::where('active', 1)->where('category_type_id', 1)->where('parent_uid', null)->orderBy('sort')->get();
        $serviceCategory = Category::where('active', 1)->where('category_type_id', 2)->where('parent_uid', null)->orderBy('sort')->get();
        $customCategory = Category::where('active', 1)->where('category_type_id', 3)->where('parent_uid', null)->orderBy('sort')->get();

        $productsuid = $carouselProducts->pluck('uid')->toArray();
        $productprice = ProductPrice::whereIn('product_uid', $productsuid)->get();

        $fcategories = Category::where('active', true)->get();
        $fattributes = Attribute::where('active', true)->get();
        $fattributevalues = AttributeValue::where('active', true)->get();

        return view('pages.index')->with(compact('home'))->with(compact('carouselProducts'))->
        with(compact('productCategory'))->with(compact('serviceCategory'))->with(compact('customCategory'))->with(compact('productprice'))
        ->with(compact('fcategories'))->with(compact('fattributes'))->with(compact('fattributevalues'));
    }

    public function CategoryTree($category, $counter = 0){
        if (count($category->children) > 0) {
            echo '<ul>';
            $counter++;
            foreach ($category->children as $child){
                echo '<li><a style="font-size: '.(1.2 - $counter / 10).'rem" href="'.$child->route.'">'.$child->name.' ('.count($child->products()).')</a>';
                $this->CategoryTree($child, $counter);
            }
            echo '</ul>';
        } else {
            echo nl2br("</li>");
        }
    }

    public function search(Request $request)
    {
        $categories = Category::where('name','LIKE', '%'.$request->search.'%')->get();
        $attributevalues = AttributeValue::where('name', 'LIKE', '%'.$request->search.'%')->get();
        $categories_uids = $categories->pluck('uid')->toArray();
        $attributevalues_uids = $attributevalues->pluck('uid')->toArray();
        $products_with_attributes = ProductAttributeValue::whereIn('attribute_value_uid', $attributevalues_uids)->get()->pluck('product_uid')->toArray();
        $products = Product::where('name','LIKE', '%'.$request->search.'%')->orWhere('article','LIKE', '%'.$request->search.'%')
        ->orWhere('description','LIKE', '%'.$request->search.'%')->orWhere('article','LIKE', '%'.$request->search.'%')
        ->orWhereIn('category_uid', $categories_uids)->orWhereIn('uid', $products_with_attributes)->get();
        $search = $request->search;
        return view('pages.search')->with(compact('products'))->with(compact('categories'))->with(compact('search'));
    }

}
