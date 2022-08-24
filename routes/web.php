<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Site\SiteController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\SiteCategoryController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use UniSharp\LaravelFilemanager\Lfm;

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

Route::view('/{path?}/{path2?}/{path3?}', 'app');
// Dashboard
// Auth::routes(['register' => false]);

// Route::group(['middleware' => ['auth']], function () {
//     Route::resource('/admins', AdminController::class);
//     Route::get('/', [HomeController::class, 'index'])->name('home');
//     Route::resource('sites', SiteController::class);
//     Route::get('change-status', [SiteController::class, 'changeStatus']);
//     Route::resource('site-category', SiteCategoryController::class);
//     Route::resource('banner', BannerController::class);

//     Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
//         Lfm::routes();
//     });

//     Route::get('get-categories', [BannerController::class, 'getCategories'])->name('getCategories');
//     Route::get('get-category-image', [BannerController::class, 'getCategoryImage'])->name('getCategoryImage');

//     Route::resource('/logs', LogController::class)->only(['index']);
//     Route::post('logs', [LogController::class, 'postLog'])->name('postLog');
//     Route::get('/module/search/{module}/{path}/{viewFile}/{mainPath?}', [LogController::class, 'getModuleSearch'])->name('getModuleSearch');

// });

// Route::get('test', function () {
//     $banner = \App\Models\BannerAds::find(16);
//     return view('test', compact('banner'));
// });


