<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocaleChangeController;
use App\Livewire\ProjectCallApplication;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/locale/{locale}', LocaleChangeController::class)->name('locale-change');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'redirect_admins'
])->group(function () {
    Route::get('/', HomeController::class)->name('home');
});
