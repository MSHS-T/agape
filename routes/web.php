<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\ExportController;
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
Route::view('/contact', 'contact')->name('contact');
Route::post('/send-contact', ContactController::class)->name('send-contact');
Route::view('/legal', 'legal')->name('legal');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/', HomeController::class)->name('home');

    Route::middleware(['role:administrator|manager'])
        ->name('export_zip.')
        ->prefix('export_zip')
        ->group(function () {
            Route::get('application/{application}', [ExportController::class, 'zipApplicationExport'])->name('application');
            Route::get('projectcall/{projectCall}', [ExportController::class, 'zipProjectCallExport'])->name('project_call');
        });

    Route::middleware(['role:administrator|manager'])
        ->name('export_application.')
        ->prefix('export_application')
        ->group(function () {
            Route::get('application/{application}', [ExportController::class, 'applicationExport'])->name('application');
            Route::get('projectcall/{projectCall}', [ExportController::class, 'applicationExportForProjectCall'])->name('project_call');
        });

    Route::middleware(['role:administrator|manager'])
        ->name('export_evaluation.')
        ->prefix('export_evaluation')
        ->group(function () {
            Route::get('projectcall/{projectCall}', [ExportController::class, 'evaluationExportForProjectCall'])->name('project_call');
            Route::get('application/{application}', [ExportController::class, 'evaluationExportForApplication'])->name('application');
            Route::get('evaluation/{evaluation}', [ExportController::class, 'evaluationExport'])->name('evaluation');
        });
});
