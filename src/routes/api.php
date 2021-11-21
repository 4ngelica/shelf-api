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
Route::get('shelf', [ShelfController::class, 'index'])->name('shelf.index');
Route::get('shelf/{item}', [ShelfController::class, 'show'])->name('shelf.item.show');
