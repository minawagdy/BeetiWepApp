<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdvertisingController;
use App\Http\Controllers\Admin\ProductiveFamilyController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Front\IndexController;
use App\Http\Controllers\TwilioSMSController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('front.index');
// });

Route::get('/', [IndexController::class, 'index'])->name('index');

Route::get('/send-message', [TwilioSMSController::class, 'index']);

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::get('/login', [AdminAuthController::class, 'getLogin'])->name('adminLogin');
    Route::post('/login', [AdminAuthController::class, 'postLogin'])->name('adminLoginPost');

    Route::group(['middleware' => 'adminauth'], function () {
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('adminDashboard');
    Route::get('categories', [CategoryController::class, 'index'])->name('categories');
    Route::get('category', [CategoryController::class, 'create']);
    Route::post('category', [CategoryController::class, 'store']);
    Route::get('category/edit/{id}', [CategoryController::class, 'edit']);
    Route::post('category/edit/{id}', [CategoryController::class, 'update'])->name('form.update');
    Route::put('/category/{id}', 'FormController@update')->name('form.update');
    Route::delete('category/{id}', [CategoryController::class, 'delete']);
    Route::get('dropdown1', [\App\Http\Controllers\Admin\DashboardController::class,'getDropdown1']);
    Route::get('dropdown2/{id}', [\App\Http\Controllers\Admin\DashboardController::class,'getDropdown2']);
    Route::get('dropdown3/{id}', [\App\Http\Controllers\Admin\DashboardController::class,'getDropdown3']);
    Route::get('/checkbox/update', [CategoryController::class,'updateCheckbox'])->name('checkbox.update');
    Route::get('advertising', [AdvertisingController::class, 'index'])->name('advertising');
    Route::get('advertising/create',    [AdvertisingController::class, 'create']);
    Route::post('advertising/create',   [AdvertisingController::class, 'store'])->name('advertising.store');
    Route::get('advertising/edit/{id}', [AdvertisingController::class, 'edit']);
    Route::put('advertising/edit/{id}', [AdvertisingController::class, 'update'])->name('advertising.update');
    Route::get('productive-families', [ProductiveFamilyController::class, 'index'])->name('productive-families');
    Route::get('orders', [OrderController::class, 'index'])->name('orders');
    });
});
