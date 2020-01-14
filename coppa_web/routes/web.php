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

/**
 * Route for Admin page
 */
Route::group(['middleware' => 'auth'], function() {
    // Home
    Route::get('/', 'HomeController@getIndex')->name('home');

    // Captain
    Route::get('/captains', 'CaptainController@getList')->name('list-captain');
    Route::get('/captains/{id}', 'CaptainController@getDetail')->name('detail-captain');
    Route::get('/captains/download/{id}', 'CaptainController@downloadExcel')->name('download-captain');
    Route::get('/captains/delete/{id}', 'CaptainController@getDelete')->name('delete-captain');

    // Trip
    Route::get('/trips', 'TripController@getList')->name('list-trip');
    Route::get('/trips/{id}', 'TripController@getDetail')->name('detail-trip');
    Route::get('/trips/delete/{id}', 'TripController@getDelete')->name('delete-trip');

    // User
    Route::get('/users', 'UserController@getList')->name('list-user');
    Route::get('/users/add', 'UserController@getAdd')->name('add-user');
    Route::post('/users/add', 'UserController@postAdd')->name('post-add-user');
    Route::get('/users/edit/{id}', 'UserController@getEdit')->name('edit-user');
    Route::post('/users/edit/{id}', 'UserController@postEdit')->name('post-edit-user');
    Route::get('/users/delete/{id}', 'UserController@getDelete')->name('delete-user');

    // Family and fish
    Route::get('/families', 'FamilyController@getList')->name('list-family');
    Route::get('/families/{id}', 'FamilyController@getDetail')->name('detail-family');

    // Statistic
    Route::get('/statistics', 'StatisticController@getList')->name('list-statistic');
    Route::get('/statistics/download', 'StatisticController@downloadExcel')->name('download-statistic');

    // Record
    Route::get('/records/edit/{id}', 'RecordController@getEdit')->name('edit-record');
    Route::post('/records/edit/{id}', 'RecordController@postEdit')->name('post-edit-record');
    Route::get('/records/delete/{id}', 'RecordController@getDelete')->name('delete-record');

    // Logout
    Route::get('/logout', 'UserController@getLogout')->name('logout');
});


// Authentication
Route::get('/login', 'UserController@getLogin')->name('login');
Route::post('/login', 'UserController@postLogin')->name('post-login');

// Test route
// Route::get('/test', 'HomeController@getTest');
Route::get('/download', 'HomeController@getApp');