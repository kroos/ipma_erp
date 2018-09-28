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
Route::resources([
	'staff' => 'Profile\StaffProfileController',
	'staffSpouse' => 'Profile\StaffSpouseController',
	'staffSibling' => 'Profile\StaffSiblingController',
	'staffChildren' => 'Profile\StaffChildrenController',
	'staffEmergencyPerson' => 'Profile\StaffEmergencyPersonController',
	'staffEmergencyPersonPhone' => 'Profile\StaffEmergencyPersonPhoneController',
	'staffEducation' => 'Profile\StaffEducationController',
	'staffAnnualMCLeave' => 'Administrative\HumanResource\StaffAnnualMCLeaveController',
	'staffLeave' => 'Profile\StaffLeaveController',
	'staffLeaveBackup' => 'Profile\StaffLeaveBackupController',
	'staffLeaveApproval' => 'Profile\StaffLeaveApprovalController',
	'workingHour' => 'Administrative\HumanResource\HRSettings\WorkingHourController',
	'holidayCalendar' => 'Administrative\HumanResource\HRSettings\HolidayCalendarController',
	'staffHR' => 'Administrative\HumanResource\StaffManagement\StaffHRController',
	
]);

// editHR for staff
Route::get('/staffHR/{staffHR}/editHR', [
		'as' => 'staffHR.editHR',
		'uses' => 'Administrative\HumanResource\StaffManagement\StaffHRController@editHR'
	]);

Route::patch('/staffHR/{staffHR}/HR', [
		'as' => 'staffHR.updateHR',
		'uses' => 'Administrative\HumanResource\StaffManagement\StaffHRController@updateHR'
	]);

############################################################################
// Division Page Controller
Route::resources([
	'generalandadministrative' => 'Division\GeneralAndAdministrativeController',
	'production' => 'Division\ProductionController',
	'marketingandbusinessdevelopment' => 'Division\MarketingAndBusinessDevelopmentController'
]);

// Administrative page Controller
Route::resources([
	'account' => 'Administrative\AccountDepartmentController',
	'purchasing' => 'Administrative\PurchasingDepartmentController',
	'humanresource' => 'Administrative\HumanResourceDepartmentController',
	'it' => 'Administrative\InformationTechnologyDepartmentController',
]);

// Production page controller
Route::resources([
	'cutting' => 'Production\CuttingDepartmentController',
	'machining' => 'Production\MachiningDepartmentController',
	'bending' => 'Production\BendingDepartmentController',
	'welding' => 'Production\WeldingDepartmentController',
	'painting' => 'Production\PaintingDepartmentController',
	'automation' => 'Production\AutomationDepartmentController',
	'qualitycontrol' => 'Production\QualityControlDepartmentController',
	'assembly' => 'Production\AssemblyDepartmentController',
	'delivery' => 'Production\DeliveryDepartmentController',
	'maintenance' => 'Production\MaintenanceDepartmentController',
	'inventory' => 'Production\InventoryDepartmentController',
]);

// SAles & Marketing Page Controller
Route::resources([
	'salesmarketing' => 'Sales\SalesMarketingDepartmentController',
	'costing' => 'Sales\CostingDepartmentController',
	'engineering' => 'Sales\EngineeringDepartmentController',
	'custservice' => 'Sales\CustomerServiceDepartmentController',
]);

// human resources management
Route::resources([
   'leaveEditing' => 'Administrative\HumanResource\LeaveEditing\LeaveEditingController',		// this is for page
   'tcms' => 'Administrative\HumanResource\TCMS\TCMSController',		// this is for page
   'staffManagement' => 'Administrative\HumanResource\StaffManagement\StaffManagementController',		// this is for page
   'hrSettings' => 'Administrative\HumanResource\HRSettings\HRSettingsController',		// this is for page
]);

############################################################################
//remote
Route::post('/staffSearch', [
		'as' => 'staffSearch.search',
		'uses' => 'Profile\StaffProfileController@search'
	]);

############################################################################
//remote
Route::post('/staffEmergencyPersonPhonesearch', [
		'as' => 'staffEmergencyPersonPhone.search',
		'uses' => 'Profile\StaffEmergencyPersonPhoneController@search'
	]);

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
// yearworkinghour Ajax Controller
Route::post('/yearworkinghour1', [
		'as' => 'workinghour.yearworkinghour1',
		'uses' => 'AjaxRemote\WorkingHourAjaxController@yearworkinghour1'
	]);

############################################################################
// yearworkinghour Ajax Controller
Route::post('/yearworkinghour2', [
		'as' => 'workinghour.yearworkinghour2',
		'uses' => 'AjaxRemote\WorkingHourAjaxController@yearworkinghour2'
	]);

############################################################################
// yearworkinghour Ajax Controller
Route::post('/hcaldstart', [
		'as' => 'workinghour.hcaldstart',
		'uses' => 'AjaxRemote\WorkingHourAjaxController@hcaldstart'
	]);

############################################################################
// yearworkinghour Ajax Controller
Route::post('/hcaldend', [
		'as' => 'workinghour.hcaldend',
		'uses' => 'AjaxRemote\WorkingHourAjaxController@hcaldend'
	]);

############################################################################
// gender Ajax Controller
Route::post('/gender', [
		'as' => 'workinghour.gender',
		'uses' => 'AjaxRemote\WorkingHourAjaxController@gender'
	]);

############################################################################
// statusstaff Ajax Controller
Route::post('/statusstaff', [
		'as' => 'workinghour.statusstaff',
		'uses' => 'AjaxRemote\WorkingHourAjaxController@statusstaff'
	]);

############################################################################
// location Ajax Controller
Route::post('/location', [
		'as' => 'workinghour.location',
		'uses' => 'AjaxRemote\WorkingHourAjaxController@location'
	]);

############################################################################
// division Ajax Controller
Route::post('/division', [
		'as' => 'workinghour.division',
		'uses' => 'AjaxRemote\WorkingHourAjaxController@division'
	]);

############################################################################
// division Ajax Controller
Route::get('/department', [
		'as' => 'workinghour.department',
		'uses' => 'AjaxRemote\WorkingHourAjaxController@department'
	]);

############################################################################
// division Ajax Controller
Route::get('/position', [
		'as' => 'workinghour.position',
		'uses' => 'AjaxRemote\WorkingHourAjaxController@position'
	]);

############################################################################
// loginuser Ajax Controller
Route::post('/loginuser', [
		'as' => 'workinghour.loginuser',
		'uses' => 'AjaxRemote\WorkingHourAjaxController@loginuser'
	]);

############################################################################
// PrintPDFLeaves Controller
Route::get('printpdfleaves/{staffLeave}', [
		'as' => 'printpdfleave.show',
		'uses' => 'PDFController\PrintPDFLeavesController@show'
	]);

############################################################################
// Ajax Controller
Route::apiResources([
	'ajax' => 'API\AjaxController'
]);














