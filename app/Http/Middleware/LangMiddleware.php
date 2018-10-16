<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class LangMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
       /* if(\Session::get('locale')) {
            \App::setLocale(\Session::get('locale'));
        }*/
        if (Session::has('applocale') AND array_key_exists(Session::get('applocale'), Config::get('app.locales'))) {
            \App::setLocale(Session::get('applocale'));
        }
        else { // This is optional as Laravel will automatically set the fallback language if there is none specified
            \App::setLocale(Config::get('app.fallback_locale'));
        }

        return $next($request);
    }
}
