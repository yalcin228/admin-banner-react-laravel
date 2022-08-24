<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\LogController;
use App\Http\Controllers\Api\SiteCategoryController;
use App\Http\Controllers\Api\SiteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix' => 'v1', 'as' => 'v1'], function () {
    Route::get('/site/{id}', [ApiController::class, 'index']);
});

Route::post('login', [AdminController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum', 'auth']], function () {
    Route::apiResource('admin', AdminController::class);
    Route::apiResource('site', SiteController::class);
    Route::apiResource('site-category', SiteCategoryController::class);
    Route::apiResource('banner', BannerController::class);
    Route::apiResource('site-category', SiteCategoryController::class);
    Route::apiResource('log', LogController::class)->except(['store', 'update', 'destroy']);
    Route::get('logout', [AdminController::class, 'logout']);
    Route::get('banner-places/{id}', [BannerController::class, 'getCategories']);
    Route::get('sites-without-paginate', [SiteController::class, 'getSitesWithoutPaginate']);
    Route::get('image/{id}', [BannerController::class, 'getImageByCategoryId']);
    Route::get('admins-without-paginate',[AdminController::class,'getAdminsWithoutPaginate']);
    Route::post('search', [LogController::class, 'search']);
});
