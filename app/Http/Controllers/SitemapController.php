<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function index(){
        $products = Product::where('active', 1)->get();
        $categories = Category::where('active', 1)->get();

        return response()->view('pages.sitemap', [
            'products' => $products,
            'categories' => $categories
        ])->header('Content-Type', 'text/xml');
    }

}
