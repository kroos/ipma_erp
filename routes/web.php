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

Route::get('/', [
		'as' => 'main.index',
		'uses' => 'MainController@index',
	]);

Auth::routes();

Route::get('/home', [
		'as' => 'home',
		'uses' => 'HomeController@index'
	]);

############################################################################
// StaffProfile Controller
Route::resource('staff', 'StaffProfileController');
//remote
Route::post('/staffSearch', [
		'as' => 'staffSearch.search',
		'uses' => 'StaffProfileController@search'
	]);

############################################################################
// StaffSpouse Controller
Route::resource('staffSpouse', 'StaffSpouseController');

############################################################################
// StaffSpouse Controller
Route::resource('staffSibling', 'StaffSiblingController');

############################################################################
// StaffChildren Controller
Route::resource('staffChildren', 'StaffChildrenController');

############################################################################
// StaffEmergencyPerson Controller
Route::resource('staffEmergencyPerson', 'StaffEmergencyPersonController');

############################################################################
// StaffEmergencyPersonPhone Controller
Route::resource('staffEmergencyPersonPhone', 'StaffEmergencyPersonPhoneController');

//remote
Route::post('/staffEmergencyPersonPhonesearch', [
		'as' => 'staffEmergencyPersonPhone.search',
		'uses' => 'StaffEmergencyPersonPhoneController@search'
	]);

// ############################################################################
// // StaffEmergencyPersonPhone Controller
// Route::resource('staffEmergencyPersonPhone', 'StaffEmergencyPersonPhoneController');

// //remote
// Route::post('/staffEmergencyPersonPhonesearch', [
// 		'as' => 'staffEmergencyPersonPhone.search',
// 		'uses' => 'StaffEmergencyPersonPhoneController@search'
// 	]);









