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
Route::get('/diary/delete', [App\Http\Controllers\DiaryController::class, 'deleteDiary'])->name('diary.delete');

Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin');

Route::get('/company', [App\Http\Controllers\CompanyController::class, 'index'])->name('company');
Route::post('/company/upload', [App\Http\Controllers\CompanyController::class, 'uploadFile']);
Route::post('/company/get', [App\Http\Controllers\CompanyController::class, 'getCompanies']);
Route::get('/company/search', [App\Http\Controllers\CompanyController::class, 'searchCompanies'])->name('company.search');
Route::get('/company/getname', [App\Http\Controllers\CompanyController::class, 'getName'])->name('company.getname');

Route::get('/favorite', [App\Http\Controllers\FavoriteController::class, 'index'])->name('favorite');
Route::get('/favorite/get', [App\Http\Controllers\FavoriteController::class, 'getFavorites'])->name('favorite.get');
Route::get('/favorite/check', [App\Http\Controllers\FavoriteController::class, 'checkState'])->name('favorite.check');
Route::get('/favorite/toggle', [App\Http\Controllers\FavoriteController::class, 'toggleState'])->name('favorite.toggle');

Route::get('/companydiary', [App\Http\Controllers\CompanyDiaryController::class, 'index'])->name('companydiary');
Route::get('/companydiary/get', [App\Http\Controllers\CompanyDiaryController::class, 'getCompanyDiary'])->name('companydiary.get');
Route::get('/companydiary/gets', [App\Http\Controllers\CompanyDiaryController::class, 'getCompanyDiaries'])->name('companydiary.gets');
Route::post('/companydiary/save', [App\Http\Controllers\CompanyDiaryController::class, 'saveCompanyDiary'])->name('companydiary.save');
Route::get('/companydiary/delete', [App\Http\Controllers\CompanyDiaryController::class, 'deleteCompanyDiary'])->name('companydiary.delete');

Route::get('/search', [App\Http\Controllers\SearchController::class, 'index'])->name('search');
Route::get('/search/diary', [App\Http\Controllers\SearchController::class, 'searchDiaries'])->name('search.diary');
Route::get('/search/companydiary', [App\Http\Controllers\SearchController::class, 'searchCompanyDiaries'])->name('search.companydiary');

Route::get('/report', [App\Http\Controllers\ReportConroller::class, 'index'])->name('report');
Route::get('/report/diary', [App\Http\Controllers\ReportConroller::class, 'reportDiaries'])->name('report.diary');
Route::get('/report/companydiary', [App\Http\Controllers\ReportConroller::class, 'reportCompanyDiaries'])->name('report.companydiary');

