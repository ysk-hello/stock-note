<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/diary', [App\Http\Controllers\DiaryController::class, 'index'])->name('diary');
Route::get('/diary/get', [App\Http\Controllers\DiaryController::class, 'getDiary'])->name('diary.get');
Route::post('/diary/save', [App\Http\Controllers\DiaryController::class, 'saveDiary'])->name('diary.save');

Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin');

Route::get('/company', [App\Http\Controllers\CompanyController::class, 'index'])->name('company');
Route::post('/company/upload', [App\Http\Controllers\CompanyController::class, 'uploadFile']);
Route::post('/company/data', [App\Http\Controllers\CompanyController::class, 'getData']);
Route::get('/company/search', [App\Http\Controllers\CompanyController::class, 'searchCompanies'])->name('company.search');

Route::get('/favorite', [App\Http\Controllers\FavoriteController::class, 'index'])->name('favorite');
Route::get('/favorite/get', [App\Http\Controllers\FavoriteController::class, 'getFavorites'])->name('favorite.get');
Route::get('/favorite/check', [App\Http\Controllers\FavoriteController::class, 'checkState'])->name('favorite.check');
Route::get('/favorite/toggle', [App\Http\Controllers\FavoriteController::class, 'toggleState'])->name('favorite.toggle');
