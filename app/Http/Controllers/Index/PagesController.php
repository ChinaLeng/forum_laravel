<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{
    /**
     * 首页
     * @return [type] [description]
     */
    public function root()
    {
        return view('index.pages.root');
    }
}
