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

    // Projectcalls
    Route::name('projectcall.')->prefix('projectcall')->group(function(){
        Route::middleware('role:admin')->group(function(){
            Route::get('/', 'ProjectCallController@index')->name('index');
            Route::get('create', 'ProjectCallController@create')->name('create');
            Route::post('create', 'ProjectCallController@store')->name('store');
            Route::get('{projectcall}/edit', 'ProjectCallController@edit')->name('edit');
            Route::put('{projectcall}', 'ProjectCallController@update')->name('update');
            Route::delete('{projectcall}', 'ProjectCallController@destroy')->name('destroy');
            Route::get('{projectcall}/applications', 'ProjectCallController@applications')->name('applications');
            Route::get('{projectcall}/evaluations', 'EvaluationController@indexForProjectCall')->name('evaluations');
        });

        Route::get('{projectcall}', 'ProjectCallController@show')->name('show')->middleware('role:candidate,admin');
        // Generates application object and redirect to application.edit form
        Route::get('{projectcall}/apply', 'ProjectCallController@apply')->name('apply')->middleware('role:candidate');
    });

    // Applications
    Route::name('application.')->prefix('application')->group(function(){
        Route::get('{application}', 'ApplicationController@show')->name('show');

        Route::middleware('role:candidate')->group(function(){
            Route::get('{application}/edit', 'ApplicationController@edit')->name('edit');
            Route::put('{application}', 'ApplicationController@update')->name('update');
            Route::put('{application}/submit', 'ApplicationController@submit')->name('submit');
        });

        Route::middleware('role:admin')->group(function(){
            Route::get('{application}/assignations', 'ApplicationController@assignations')->name('assignations');
            Route::get('{application}/evaluations', 'EvaluationController@indexForApplication')->name('evaluations');
        });

    });

    // Evaluation Offers
    Route::name('offer.')->prefix('offer')->group(function(){
        Route::middleware('role:admin')->group(function(){
            Route::post('create/{application}', 'EvaluationOfferController@store')->name('store');
            Route::delete('{offer}', 'EvaluationOfferController@destroy')->name('destroy');
            Route::get('{offer}/retry', 'EvaluationOfferController@retry')->name('retry');
        });

        Route::middleware('role:expert')->group(function(){
            Route::get('{offer}/accept/', 'EvaluationOfferController@accept')->name('accept');
            Route::post('{offer}/decline/', 'EvaluationOfferController@decline')->name('decline');
        });
    });

    // Evaluations
    Route::name('evaluation.')->prefix('evaluation')->group(function(){
        Route::middleware('role:expert')->group(function(){
            Route::get('create/{offer}', 'EvaluationController@create')->name('create');
            Route::post('create/{offer}', 'EvaluationController@store')->name('store');
        });

        Route::get('{evaluation}', 'EvaluationController@show')->name('show')->middleware('role:admin,expert');
    });

    // Admin routes
    Route::prefix('admin')->middleware('role:admin')->group(function () {
        Route::get('settings', 'SettingsController@edit')->name('settings');
        Route::post('settings', 'SettingsController@update')->name('settings.update');
    });
});

Route::get('error', function(){
    abort(500);
});