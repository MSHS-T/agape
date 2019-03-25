<?php

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
Auth::routes(['verify' => true]);

Route::redirect('/', '/home');


Route::middleware(['auth', 'verified'])->group(function(){
    Route::get('home', 'HomeController@index')->name('home');
    Route::get('profile', 'HomeController@profile')->name('profile');
    Route::post('profile', 'HomeController@saveProfile')->name('profile.save');

    Route::get('download/template/{form}/{type}/{year}', 'DownloadController@template')
         ->where([
            'form' => '(Candidature|Financier)',
            'type' => '(Region|Exploratoire|Workshop)',
            'year' => '[\d]{4}'
         ])
         ->name('download.template');
    Route::get('download/attachment/{application_id}/{index}', 'DownloadController@attachment')
         ->name('download.attachment');

    Route::get('projectcall/{id}/apply', 'ProjectCallController@apply')->name('projectcall.apply');
    Route::get('projectcall/{id}/applications', 'ProjectCallController@applications')->name('projectcall.applications');
    Route::resource('projectcall', 'ProjectCallController');

    //Application Submission
    Route::put('application/submit/{id}', 'ApplicationController@submit')->name('application.submit');

    // Application > Assignations & Evaluations
    Route::get('application/{id}/assignations', 'ApplicationController@assignations')->name('application.assignations');
    Route::get('application/{id}/evaluations', 'ApplicationController@evaluations')->name('application.evaluations');

    // Manage expert assignation to application
    Route::post('application/{application_id}/assign/', 'ApplicationController@assign')->name('application.assign');
    Route::delete('application/unassign/{offer_id}', 'ApplicationController@unassign')->name('application.unassign');

    // Application Resource controller
    Route::resource('application', 'ApplicationController')->only(['index', 'show', 'edit', 'update']);

    // Accept or decline offer
    Route::get('evaluation/offer/{offer_id}/accept/', 'EvaluationController@acceptOffer')->name('offer.accept');
    Route::post('evaluation/offer/{offer_id}/decline/', 'EvaluationController@declineOffer')->name('offer.decline');
    Route::get('evaluation/offer/{offer_id}/retry', 'EvaluationController@retryOffer')->name('offer.retry');

    // Evaluations
    Route::get('evaluation/offer/{offer_id}', 'EvaluationController@create')->name('evaluation.create');
    Route::post('evaluation/offer/{offer_id}', 'EvaluationController@store')->name('evaluation.store');
    Route::get('evaluation/{id}', 'EvaluationController@show')->name('evaluation.show');

    // Admin routes
    Route::prefix('admin')->group(function () {
        Route::get('settings', 'SettingsController@edit')->name('settings');
        Route::post('settings', 'SettingsController@update')->name('settings.update');
    });
});

Route::get('error', function(){
    abort(500);
});