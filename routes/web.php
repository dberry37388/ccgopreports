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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('districts', 'Exports\DistrictListController@index')->name('districtsIndex');

Route::group(['prefix' => 'exports', 'namespace' => 'Exports'], function() {
    Route::get('2018-master-walk-list', 'MasterWalkListController@export')->name('exportMasterWalkList');
    Route::get('2018-master-republican-hit-list', 'MasterRepublicanHitListController@export')->name('exportMasterRepublicanHitList');
    Route::get('2018-crossover-list', 'CrossoverListController@export')->name('exportCrossoverList');
    
    Route::group(['prefix' => 'first-time-voters'], function() {
        Route::get('/', 'FirstTimeVoterListController@exportAll')->name('exportFirstTimeVoterList');
        Route::get('democrat', 'FirstTimeVoterListController@exportDemocrat')->name('exportFirstTimeDemocratList');
        Route::get('republican', 'FirstTimeVoterListController@exportRepublican')->name('exportFirstTimeRepublicanList');
    });
    
    Route::group(['prefix' => 'districts'], function() {
        Route::get('{district}', 'DistrictListController@show')->name('showDistrict');
        Route::get('{district}/export', 'DistrictListController@export')->name('exportDistrict');
        Route::get('{district}/hitlist', 'DistrictListController@hitlist')->name('exportDistrictHitlist');
    });
});

Route::group(['prefix' => 'charts'], function() {
    Route::get('/', 'ChartController@index')->name('chartsIndex');
});
