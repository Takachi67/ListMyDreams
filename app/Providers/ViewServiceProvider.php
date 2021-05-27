<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer([
            'dashboard',
            'friends.index',
            'users.profile',
            'wishlists.create',
            'wishlists.edit',
            'wishlists.index',
            'wishlists.show'
        ], function ($view) {
            if (Auth::user()) {
                $view->with('notifications', Auth::user()->getNotifications());
            }
        });
    }
}
