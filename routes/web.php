<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilterController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/filter', [FilterController::class, 'index'])->name('filter.index');
Route::post('/filter/search',[FilterController::class, 'search'])->name('filter.search');
