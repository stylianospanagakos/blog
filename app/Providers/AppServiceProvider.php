<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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

        // inject common data in views
        view()->composer('partials.sections.top_tags', function($view) {

            $view->with('popular', \App\Tag::getTagsByMostPopular(\App\Tag::POPULAR_TAG_COUNT))->with('top_count', \App\Tag::POPULAR_TAG_COUNT);

        });

    }
}
