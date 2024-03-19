<?php

use App\Http\Controllers\UserController;
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

Route::group(['middleware' => ['auth:web']], function () {
    Route::resource('users', UserController::class);
    Route::get('users/trashed', [UserController::class, 'trashed'])->name('users.trashed');
    Route::post('users/restore/{id}', [UserController::class, 'restore'])->name('users.restore');
    Route::delete('users/force-delete/{id}', [UserController::class, 'forceDelete'])->name('users.force-delete');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
