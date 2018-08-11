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

############################################################################
// StaffEducation Controller
Route::resource('staffEducation', 'StaffEducationController');

############################################################################
// GeneralAndAdministrative Controller
Route::get('/general-and-administrative', [
		'as' => 'general-and-administrative.index',
		'uses' => 'GeneralAndAdministrativeController@index'
	]);

############################################################################
// StaffEducation Controller
Route::get('/production', [
		'as' => 'production.index',
		'uses' => 'ProductionController@index'
	]);

############################################################################
// StaffEducation Controller
Route::get('/marketing-and-business-development', [
		'as' => 'marketing-and-business-development.index',
		'uses' => 'MarketingAndBusinessDevelopmentController@index'
	]);

############################################################################
// AccountDepartment Controller
Route::get('/account', [
		'as' => 'account.index',
		'uses' => 'AccountDepartmentController@index'
	]);

############################################################################
// PurchasingDepartment Controller
Route::get('/purchasing', [
		'as' => 'purchasing.index',
		'uses' => 'PurchasingDepartmentController@index'
	]);

############################################################################
// PurchasingDepartment Controller
Route::get('/human-resource', [
		'as' => 'human-resource.index',
		'uses' => 'HumanResourceDepartmentController@index'
	]);

############################################################################
// PurchasingDepartment Controller
Route::get('/it', [
		'as' => 'it.index',
		'uses' => 'InformationTechnologyDepartmentController@index'
	]);

############################################################################
// CuttingDepartment Controller
Route::get('/cutting', [
		'as' => 'cutting.index',
		'uses' => 'CuttingDepartmentController@index'
	]);

############################################################################
// MachiningDepartment Controller
Route::get('/machining', [
		'as' => 'machining.index',
		'uses' => 'MachiningDepartmentController@index'
	]);

############################################################################
// BendingDepartment Controller
Route::get('/bending', [
		'as' => 'bending.index',
		'uses' => 'BendingDepartmentController@index'
	]);

############################################################################
// WeldingDepartment Controller
Route::get('/welding', [
		'as' => 'welding.index',
		'uses' => 'WeldingDepartmentController@index'
	]);

############################################################################
// PaintingDepartment Controller
Route::get('/painting', [
		'as' => 'painting.index',
		'uses' => 'PaintingDepartmentController@index'
	]);

############################################################################
// AutomationDepartment Controller
Route::get('/automation', [
		'as' => 'automation.index',
		'uses' => 'AutomationDepartmentController@index'
	]);

############################################################################
// QualityControlDepartment Controller
Route::get('/quality-control', [
		'as' => 'quality-control.index',
		'uses' => 'QualityControlDepartmentController@index'
	]);

############################################################################
// AssemblyDepartment Controller
Route::get('/assembly', [
		'as' => 'assembly.index',
		'uses' => 'AssemblyDepartmentController@index'
	]);

############################################################################
// DeliveryDepartment Controller
Route::get('/delivery', [
		'as' => 'delivery.index',
		'uses' => 'DeliveryDepartmentController@index'
	]);

############################################################################
// MaintenanceDepartment Controller
Route::get('/maintenance', [
		'as' => 'maintenance.index',
		'uses' => 'MaintenanceDepartmentController@index'
	]);

############################################################################
// InventoryDepartment Controller
Route::get('/inventory', [
		'as' => 'inventory.index',
		'uses' => 'InventoryDepartmentController@index'
	]);

############################################################################
// SalesMarketingDepartment Controller
Route::get('/sales-marketing', [
		'as' => 'sales-marketing.index',
		'uses' => 'SalesMarketingDepartmentController@index'
	]);

############################################################################
// CostingDepartment Controller
Route::get('/costing', [
		'as' => 'costing.index',
		'uses' => 'CostingDepartmentController@index'
	]);

############################################################################
// EngineeringDepartment Controller
Route::get('/engineering', [
		'as' => 'engineering.index',
		'uses' => 'EngineeringDepartmentController@index'
	]);

############################################################################
// CustomerServiceDepartment Controller
Route::get('/cust-service', [
		'as' => 'cust-service.index',
		'uses' => 'CustomerServiceDepartmentController@index'
	]);








