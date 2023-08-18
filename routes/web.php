<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


/*Route::get('currency/{currencyCode}', [App\Http\Controllers\MainController::class, 'changeCurrency'])->name('currency');*/
Route::get('posts/{id}', [App\Http\Controllers\MainController::class, 'getPosts'])->name('get.posts');
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [  'localeSessionRedirect301',  'localeViewPath' ]
], function() {
    Route::get('/', [App\Http\Controllers\MainController::class, 'index'])->name('index');
});

