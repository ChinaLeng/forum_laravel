<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\Topic;
use App\Observers\TopicObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);
         // 为 Topic 模型注册观察者
        \App\Models\Topic::observe(\App\Observers\TopicObserver::class);
        \App\Models\Replie::observe(\App\Observers\ReplieObserver::class);
    }
}
