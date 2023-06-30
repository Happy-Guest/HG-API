<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $request = $this->app->request;

        if ($request->hasHeader('Accept-Language')) {
            $preferredLanguage = $request->getPreferredLanguage(['en', 'pt']);

            // Set the application locale based on the user's preferred language
            App::setLocale($preferredLanguage);

            // Store the language preference in the session
            Session::put('locale', $preferredLanguage);
        }
    }
}
