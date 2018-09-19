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

############################################################################
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
// ProductionController Controller
Route::get('/production', [
		'as' => 'production.index',
		'uses' => 'Division\ProductionController@index'
	]);

############################################################################
// MarketingAndBusinessDevelopmentController Controller
Route::get('/marketingandbusinessdevelopment', [
		'as' => 'marketingandbusinessdevelopment.index',
		'uses' => 'Division\MarketingAndBusinessDevelopmentController@index'
	]);

############################################################################
// AccountDepartmentController Controller
Route::get('/account', [
		'as' => 'account.index',
		'uses' => 'Administrative\AccountDepartmentController@index'
	]);

############################################################################
// PurchasingDepartmentController Controller
Route::get('/purchasing', [
		'as' => 'purchasing.index',
		'uses' => 'Administrative\PurchasingDepartmentController@index'
	]);

############################################################################
// HumanResourceDepartmentController Controller
Route::get('/humanresource', [
		'as' => 'humanresource.index',
		'uses' => 'Administrative\HumanResourceDepartmentController@index'
	]);

############################################################################
// InformationTechnologyDepartmentController Controller
Route::get('/it', [
		'as' => 'it.index',
		'uses' => 'Administrative\InformationTechnologyDepartmentController@index'
	]);

############################################################################
// CuttingDepartmentController Controller
Route::get('/cutting', [
		'as' => 'cutting.index',
		'uses' => 'Production\CuttingDepartmentController@index'
	]);

############################################################################
// MachiningDepartmentController Controller
Route::get('/machining', [
		'as' => 'machining.index',
		'uses' => 'Production\MachiningDepartmentController@index'
	]);

############################################################################
// BendingDepartmentController Controller
Route::get('/bending', [
		'as' => 'bending.index',
		'uses' => 'Production\BendingDepartmentController@index'
	]);

############################################################################
// WeldingDepartmentController Controller
Route::get('/welding', [
		'as' => 'welding.index',
		'uses' => 'Production\WeldingDepartmentController@index'
	]);

############################################################################
// PaintingDepartmentController Controller
Route::get('/painting', [
		'as' => 'painting.index',
		'uses' => 'Production\PaintingDepartmentController@index'
	]);

############################################################################
// AutomationDepartmentController Controller
Route::get('/automation', [
		'as' => 'automation.index',
		'uses' => 'Production\AutomationDepartmentController@index'
	]);

############################################################################
// QualityControlDepartmentController Controller
Route::get('/qualitycontrol', [
		'as' => 'qualitycontrol.index',
		'uses' => 'Production\QualityControlDepartmentController@index'
	]);

############################################################################
// AssemblyDepartmentController Controller
Route::get('/assembly', [
		'as' => 'assembly.index',
		'uses' => 'Production\AssemblyDepartmentController@index'
	]);

############################################################################
// DeliveryDepartmentController Controller
Route::get('/delivery', [
		'as' => 'delivery.index',
		'uses' => 'Production\DeliveryDepartmentController@index'
	]);

############################################################################
// MaintenanceDepartmentController Controller
Route::get('/maintenance', [
		'as' => 'maintenance.index',
		'uses' => 'Production\MaintenanceDepartmentController@index'
	]);

############################################################################
// InventoryDepartmentController Controller
Route::get('/inventory', [
		'as' => 'inventory.index',
		'uses' => 'Production\InventoryDepartmentController@index'
	]);

############################################################################
// SalesMarketingDepartmentController Controller
Route::get('/salesmarketing', [
		'as' => 'salesmarketing.index',
		'uses' => 'Sales\SalesMarketingDepartmentController@index'
	]);

############################################################################
// CostingDepartmentController Controller
Route::get('/costing', [
		'as' => 'costing.index',
		'uses' => 'Sales\CostingDepartmentController@index'
	]);

############################################################################
// EngineeringDepartmentController Controller
Route::get('/engineering', [
		'as' => 'engineering.index',
		'uses' => 'Sales\EngineeringDepartmentController@index'
	]);

############################################################################
// CustomerServiceDepartmentController Controller
Route::get('/custservice', [
		'as' => 'custservice.index',
		'uses' => 'Sales\CustomerServiceDepartmentController@index'
	]);

############################################################################
// human resource dept
// StaffAnnualMCLeave Controller
Route::resource('staffAnnualMCLeave', 'Administrative\HumanResource\StaffAnnualMCLeaveController');

############################################################################
// human resource dept
// StaffLeave Controller
Route::resource('staffLeave', 'Profile\StaffLeaveController');

############################################################################
// WorkingHour Ajax Controller
Route::post('/workinghour', [
		'as' => 'workinghour.workingtime',
		'uses' => 'AjaxRemote\WorkingHourAjaxController@workingtime'
	]);

############################################################################
// leaveType Ajax Controller
Route::post('/leaveType', [
		'as' => 'workinghour.leaveType',
		'uses' => 'AjaxRemote\WorkingHourAjaxController@leaveType'
	]);

############################################################################
// blockholidaysandleave Ajax Controller
Route::post('/blockholidaysandleave', [
		'as' => 'workinghour.blockholidaysandleave',
		'uses' => 'AjaxRemote\WorkingHourAjaxController@blockholidaysandleave'
	]);

############################################################################
// StaffLeaveBackup Controller
Route::resource('staffLeaveBackup', 'Profile\StaffLeaveBackupController');

############################################################################
// StaffLeaveApproval Controller
Route::resource('staffLeaveApproval', 'Profile\StaffLeaveApprovalController');

############################################################################
// PrintPDFLeaves Controller
Route::get('printpdfleaves/{staffLeave}', [
		'as' => 'printpdfleave.show',
		'uses' => 'PDFController\PrintPDFLeavesController@show'
	]);

############################################################################
// same as above but dont have to be that much
Route::resources([
   'leaveEditing' => 'LeaveEditingController',
   'posts' => 'PostController'
]);


















