<?php

use App\Http\Controllers\ProfileController;
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
    return view('login');
})->name('login')->middleware('guest:profile');

Route::post('login', [ProfileController::class, 'login'])->name('user.login');
Route::post('store', [ProfileController::class, 'store'])->name('store');
Route::get('reg', [ProfileController::class, 'reg'])->name('reg');


Route::middleware(['auth:profile'])->group(function () {
    Route::get('dashboard', [ProfileController::class, 'dashboard'])->name('dashboard');
    Route::get('editProfile', [ProfileController::class, 'editProfile'])->name('editProfile');
    Route::post('updateProfile', [ProfileController::class, 'updateProfile'])->name('updateProfile');
    Route::post('logout', [ProfileController::class, 'logout']);
});

