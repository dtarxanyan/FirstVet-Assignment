<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use JsonCollectionParser\Parser;

class JsonCollectionParserServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Parser::class, function ($app) {
            return new Parser();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
