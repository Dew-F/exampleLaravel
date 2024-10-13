<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Post;

class ArticlesController extends Controller
{
    public function ShowArticles(){
        $articles = Post::where('active', 1)->where('post_type_id', 2)->orderBy('date','desc')->get();
        return view('pages.articles')->with(compact('articles'));
    }

    public function ShowArticle(Request $request){
        $article = Post::where('id', $request->id)->first();
        return view('modules.article')->with(compact('article'));
    }
}
