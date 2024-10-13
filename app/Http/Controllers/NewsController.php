<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Post;

class NewsController extends Controller
{
    public function ShowNews(){
        $news = Post::where('active', 1)->where('post_type_id', 1)->orderBy('date','desc')->get();
        return view('pages.news')->with(compact('news'));
    }

    public function ShowNew(Request $request){
        $news = Post::where('id', $request->id)->first();
        return view('modules.news')->with(compact('news'));
    }
}
