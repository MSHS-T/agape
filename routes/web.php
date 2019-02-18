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
Auth::routes();//['verify' => true]);

Route::redirect('/', '/home');


// Route::middleware(['auth', 'verified'])->group(function(){
Route::middleware(['auth'])->group(function(){
    Route::get('home', 'HomeController@index')->name('home');
    Route::get('profile', 'HomeController@profile')->name('profile');

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

    Route::put('application/submit/{id}', 'ApplicationController@submit')->name('application.submit');
    Route::get('application/{id}/assignations', 'ApplicationController@assignations')->name('application.assignations');
    Route::post('application/{application_id}/assign/', 'ApplicationController@assign')->name('application.assign');
    Route::delete('application/unassign/{offer_id}', 'ApplicationController@unassign')->name('application.unassign');
    Route::resource('application', 'ApplicationController')->only(['index', 'show', 'edit', 'update']);
});

Route::get('error', function(){
    abort(500);
});