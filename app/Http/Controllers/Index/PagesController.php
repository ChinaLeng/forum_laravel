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
    /**
     * 无权限页面
     * @return [type] [description]
     */
    public function permissionDenied()
    {
        // 如果当前用户有权限访问后台，直接跳转访问
        if (config('administrator.permission')()) {
            return redirect(url(config('administrator.uri')), 302);
        }
        // 否则使用视图
        return view('index.pages.permission_denied');
    }
}
