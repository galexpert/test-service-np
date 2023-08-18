<?php

namespace App\Services;

use Illuminate\Support\Facades\App;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


use Illuminate\Http\Request;


class  LocalizationService extends Service
{


    public function checkLocale () {

        $defaultLocale = app('laravellocalization')->getDefaultLocale();
        $currentLocale = LaravelLocalization::getCurrentLocale();
        $checkLocale =  app('laravellocalization')->checkLocaleInSupportedLocales($currentLocale);
        $sessLocale = session('locale');

        if($currentLocale && $checkLocale){
            if($currentLocale !== $defaultLocale){
                // текущая локаль существует и она не ровна дефолтной локали сайта (админке)
                return $currentLocale;
            }
            if($sessLocale  === $defaultLocale ) {
                // текущая локаль Несуществует и Сессионная локаль существует и  она ровна дефолтной локали сайта (админке)
                return $sessLocale;
            }
        }
        // Ни одного варианта локали не существует отдаем дефолтную локаль для выборки where переводов  из БД которая гарантированно существует
        return $sessLocale;
    }



}
