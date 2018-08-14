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
Route::resource('staff', 'Profile\StaffProfileController');
//remote
Route::post('/staffSearch', [
		'as' => 'staffSearch.search',
		'uses' => 'Profile\StaffProfileController@search'
	]);

############################################################################
// StaffSpouse Controller
Route::resource('staffSpouse', 'Profile\StaffSpouseController');

############################################################################
// StaffSpouse Controller
Route::resource('staffSibling', 'Profile\StaffSiblingController');

############################################################################
// StaffChildren Controller
Route::resource('staffChildren', 'Profile\StaffChildrenController');

############################################################################
// StaffEmergencyPerson Controller
Route::resource('staffEmergencyPerson', 'Profile\StaffEmergencyPersonController');

############################################################################
// StaffEmergencyPersonPhone Controller
Route::resource('staffEmergencyPersonPhone', 'Profile\StaffEmergencyPersonPhoneController');

//remote
Route::post('/staffEmergencyPersonPhonesearch', [
		'as' => 'staffEmergencyPersonPhone.search',
		'uses' => 'Profile\StaffEmergencyPersonPhoneController@search'
	]);

############################################################################
// StaffEducation Controller
Route::resource('staffEducation', 'Profile\StaffEducationController');

############################################################################
// GeneralAndAdministrative Controller
Route::get('/generalandadministrative', [
		'as' => 'generalandadministrative.index',
		'uses' => 'Division\GeneralAndAdministrativeController@index'
	]);

############################################################################
// StaffEducation Controller
Route::get('/production', [
		'as' => 'production.index',
		'uses' => 'Division\ProductionController@index'
	]);

############################################################################
// StaffEducation Controller
Route::get('/marketingandbusinessdevelopment', [
		'as' => 'marketingandbusinessdevelopment.index',
		'uses' => 'Division\MarketingAndBusinessDevelopmentController@index'
	]);

############################################################################
// AccountDepartment Controller
Route::get('/account', [
		'as' => 'account.index',
		'uses' => 'Administrative\AccountDepartmentController@index'
	]);

############################################################################
// PurchasingDepartment Controller
Route::get('/purchasing', [
		'as' => 'purchasing.index',
		'uses' => 'Administrative\PurchasingDepartmentController@index'
	]);

############################################################################
// PurchasingDepartment Controller
Route::get('/humanresource', [
		'as' => 'humanresource.index',
		'uses' => 'Administrative\HumanResourceDepartmentController@index'
	]);

############################################################################
// PurchasingDepartment Controller
Route::get('/it', [
		'as' => 'it.index',
		'uses' => 'Administrative\InformationTechnologyDepartmentController@index'
	]);

############################################################################
// CuttingDepartment Controller
Route::get('/cutting', [
		'as' => 'cutting.index',
		'uses' => 'Production\CuttingDepartmentController@index'
	]);

############################################################################
// MachiningDepartment Controller
Route::get('/machining', [
		'as' => 'machining.index',
		'uses' => 'Production\MachiningDepartmentController@index'
	]);

############################################################################
// BendingDepartment Controller
Route::get('/bending', [
		'as' => 'bending.index',
		'uses' => 'Production\BendingDepartmentController@index'
	]);

############################################################################
// WeldingDepartment Controller
Route::get('/welding', [
		'as' => 'welding.index',
		'uses' => 'Production\WeldingDepartmentController@index'
	]);

############################################################################
// PaintingDepartment Controller
Route::get('/painting', [
		'as' => 'painting.index',
		'uses' => 'Production\PaintingDepartmentController@index'
	]);

############################################################################
// AutomationDepartment Controller
Route::get('/automation', [
		'as' => 'automation.index',
		'uses' => 'Production\AutomationDepartmentController@index'
	]);

############################################################################
// QualityControlDepartment Controller
Route::get('/qualitycontrol', [
		'as' => 'qualitycontrol.index',
		'uses' => 'Production\QualityControlDepartmentController@index'
	]);

############################################################################
// AssemblyDepartment Controller
Route::get('/assembly', [
		'as' => 'assembly.index',
		'uses' => 'Production\AssemblyDepartmentController@index'
	]);

############################################################################
// DeliveryDepartment Controller
Route::get('/delivery', [
		'as' => 'delivery.index',
		'uses' => 'Production\DeliveryDepartmentController@index'
	]);

############################################################################
// MaintenanceDepartment Controller
Route::get('/maintenance', [
		'as' => 'maintenance.index',
		'uses' => 'Production\MaintenanceDepartmentController@index'
	]);

############################################################################
// InventoryDepartment Controller
Route::get('/inventory', [
		'as' => 'inventory.index',
		'uses' => 'Production\InventoryDepartmentController@index'
	]);

############################################################################
// SalesMarketingDepartment Controller
Route::get('/salesmarketing', [
		'as' => 'salesmarketing.index',
		'uses' => 'Sales\SalesMarketingDepartmentController@index'
	]);

############################################################################
// CostingDepartment Controller
Route::get('/costing', [
		'as' => 'costing.index',
		'uses' => 'Sales\CostingDepartmentController@index'
	]);

############################################################################
// EngineeringDepartment Controller
Route::get('/engineering', [
		'as' => 'engineering.index',
		'uses' => 'Sales\EngineeringDepartmentController@index'
	]);

############################################################################
// CustomerServiceDepartment Controller
Route::get('/custservice', [
		'as' => 'custservice.index',
		'uses' => 'Sales\CustomerServiceDepartmentController@index'
	]);

############################################################################
// human resource dept
// StaffAnnualMCLeave Controller
Route::resource('staffAnnualMCLeave', 'Administrative\HumanResource\StaffAnnualMCLeaveController');








