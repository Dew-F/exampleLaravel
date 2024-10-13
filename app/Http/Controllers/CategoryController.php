<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Price;
use App\Models\Product;
use App\Models\ProductPrice;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function Show($slugurl){
        $tree = explode('/',$slugurl);
        $slug = $tree[count($tree)-1];

        $category = Category::where('slug', $slug)->first();

        $categories = $category->parenttree();
        $categories = array_reverse($categories);
        array_pop($categories);

        $categoriesuids = $category->childrentree()->pluck('uid')->toArray();
        $categoriesuids[] = $category->uid;
        $products = Product::whereIn('category_uid', $categoriesuids)->where('active', true)->paginate(32);

        $productsuid = $products->pluck('uid')->toArray();
        $productprice = ProductPrice::whereIn('product_uid', $productsuid)->get();
        $cart = Cart::where('session_id', session()->getId())->get();

        $fcategories = new Collection([$category]);
        $fcategories = $fcategories->merge($category->childrentree());
        $fattributes = Attribute::all();
        $fattributevalues = AttributeValue::all();

        $categorytype = $category->category_type_id;

        if ($category){
            return view('pages.category')->with(compact('category'))->with(compact('slug'))
            ->with(compact('products'))->with(compact('categories'))->with(compact('categoriesuids'))
            ->with(compact('productprice'))->with(compact('cart'))
            ->with(compact('fcategories'))->with(compact('fattributes'))->with(compact('fattributevalues'))
            ->with(compact('categorytype'));
        } else {
            return abort(404);
        }
    }

    public function ShowProduction(){
        $productCategory = Category::orderBy('sort', 'asc')->where('category_type_id', 1)->where('parent_uid', null)->with('children')->get();

        $fcategories = Category::all();
        $fattributes = Attribute::all();
        $fattributevalues = AttributeValue::all();

        $home = $this;

        return view('pages.production')
        ->with(compact('productCategory'))->with(compact('home'))
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
}
