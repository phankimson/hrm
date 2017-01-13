<?php

namespace App\Providers;


use App\Http\Models\Menu;
use App\Http\Models\Options;
use App\Http\Models\HistoryAction;
use App\Http\Middleware\Language;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
     view()->share('options',Options::get_all());
     view()->share('menu',Menu::get_menu_admin_index());
     view()->share('language',Language::$locales);
     view()->share('history_action', HistoryAction::get_index());
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
