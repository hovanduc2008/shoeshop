<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;



class ArticleController extends Controller
{

    


    public function index(Request $request) {
        
        return view('user.article-list');
    }

    public function detail(Request $request) {
        return view('user.article-detail');
    }
}
