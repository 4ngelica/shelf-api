<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShelfController;

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

Route::get('handle/{item?}', [ShelfController::class, 'handleRequest'])->name('handle');
Route::get('product', [ShelfController::class, 'index'])->name('product.index');
Route::get('product/{item}', [ShelfController::class, 'show'])->name('product.show');
