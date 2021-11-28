<?php

namespace App\Http\Middleware;

use Closure;

class Localization
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
        if(\Auth::check()){
            \Session::put('locale', \Auth::user()->lang == 'mm' ? 'mm':'en');
        }
        if(\Session::has('locale')){
            \App::setLocale(\Session::get('locale'));
        }
        return $next($request);
    }
}
