<?php

namespace App\Http\Controllers;

use App\Models\Manager;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function Show(){
        $managers = Manager::where('display', true)->where('active', true)->get();
        return view('pages.about')->with(compact('managers'));
    }
}
