<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Mcamara\LaravelLocalization\LanguageNegotiator;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationMiddlewareBase;
class LocaleSessionRedirect301 extends LaravelLocalizationMiddlewareBase
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // If the URL of the request is in exceptions.


/*        dump(LaravelLocalization::getURLFromRouteNameTranslated('ru'));*/
        if ($this->shouldIgnore($request)) {
            return $next($request);
        }

        $params = explode('/', $request->path());
        $locale = session('locale', false);

        if (\count($params) > 0 && !app('laravellocalization')->checkLocaleInSupportedLocales($params[0])) {
            // шаг 3 после редиректа если из  url уже вырезан дефолтный язык, то записываем его в сессию
            $defaultlocale = app('laravellocalization')->getDefaultLocale();
            session(['locale' => $defaultlocale]);
        }
        if (\count($params) > 0 && app('laravellocalization')->checkLocaleInSupportedLocales($params[0])) {
            // шаг 1 До редиректа если язык не дефолтный то записываем в сессию и не редиректим

            session(['locale' => $params[0]]);
            $locale = app('laravellocalization')->getCurrentLocale();


            if (app('laravellocalization')->isHiddenDefault($locale)) {

                // шаг 2 До редиректа если язык дефолтный то  редиректим и вырезаем дефолт язык из url и попадаем в шаг 3
                $redirection = app('laravellocalization')->getNonLocalizedURL();

               // app('session')->reflash();
               // session(['locale' => $locale]);

                return new RedirectResponse($redirection, 301, ['Vary' => 'Accept-Language']);

            }
            return $next($request);
        }

        if (empty($locale) && app('laravellocalization')->hideUrlAndAcceptHeader()){
            // When default locale is hidden and accept language header is true,
            // then compute browser language when no session has been set.
            // Once the session has been set, there is no need
            // to negotiate language from browser again.
            $negotiator = new LanguageNegotiator(
                app('laravellocalization')->getDefaultLocale(),
                app('laravellocalization')->getSupportedLocales(),
                $request
            );
            //$locale = $negotiator->negotiateLanguage();
            $locale = app('laravellocalization')->getCurrentLocale();

            session(['locale' => $locale]);
        }
        if ($locale === false){
            $locale = app('laravellocalization')->getCurrentLocale();

        }

        $locale = app('laravellocalization')->getCurrentLocale();
        if (
            $locale &&
            app('laravellocalization')->checkLocaleInSupportedLocales($locale) &&
            !(app('laravellocalization')->isHiddenDefault($locale))
        ) {


            $locale = app('laravellocalization')->getCurrentLocale();

            app('session')->reflash();
            $redirection = app('laravellocalization')->getLocalizedURL($locale);

            return new RedirectResponse($redirection, 301, ['Vary' => 'Accept-Language']);
        }

        return $next($request);
    }
}
