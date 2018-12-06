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
	'staffAnnualMCLeave' => 'Administrative\HumanResource\LeaveEditing\StaffAnnualMCLeaveController',
	'staffLeave' => 'Profile\StaffLeaveController',
	'staffLeaveBackup' => 'Profile\StaffLeaveBackupController',
	'staffLeaveApproval' => 'Profile\StaffLeaveApprovalController',
	'workingHour' => 'Administrative\HumanResource\HRSettings\WorkingHourController',
	'holidayCalendar' => 'Administrative\HumanResource\HRSettings\HolidayCalendarController',
	'staffHR' => 'Administrative\HumanResource\StaffManagement\StaffHRController',
	'staffLeaveHR' => 'Administrative\HumanResource\LeaveEditing\StaffLeaveHRController',
	'staffLeaveReplacement' => 'Administrative\HumanResource\LeaveEditing\NRL\StaffLeaveReplacementController',
	'staffTCMS' => 'Administrative\HumanResource\TCMS\StaffTCMSController',
	'staffOvertime' => 'Administrative\HumanResource\StaffManagement\StaffOvertimeController',
	'staffAvailability' => 'Administrative\HumanResource\StaffManagement\StaffAvailabilityController',

// sales
	'serviceReport' => 'Sales\CustomerService\ServiceReportController',
	'srSerial' => 'Sales\CustomerService\ServiceReportSerialController',
	'srAttend' => 'Sales\CustomerService\ServiceReportAttendeesController',
	'srModel' => 'Sales\CustomerService\ServiceReportModelController',
	'srPart' => 'Sales\CustomerService\ServiceReportPartAccessoryController',
	'srJob' => 'Sales\CustomerService\ServiceReportJobController',
	'srFeedProb' => 'Sales\CustomerService\ServiceReportFeedbackProblemController',
	'srFeedReq' => 'Sales\CustomerService\ServiceReportFeedbackRequestController',
	'srLogistic' => 'Sales\CustomerService\ServiceReportLogisticController',
	'srAddCharge' => 'Sales\CustomerService\ServiceReportAdditionalChargesController',
	'srDiscount' => 'Sales\CustomerService\ServiceReportDiscountController',
]);
// received hardcopy
Route::post('/staffTCMS/storeODBC', [
	'as' => 'staffTCMS.storeODBC',
	'uses' => 'Administrative\HumanResource\TCMS\StaffTCMSController@storeODBC'
]);
// staffHR Report
Route::get('/staffHR/{staffHR}/showReport', [
	'as' => 'staffHR.showReport',
	'uses' => 'Administrative\HumanResource\StaffManagement\StaffHRController@showReport',
]);
// staffHR discipline1
Route::get('/staffHR/{staffHR}/merit', [
	'as' => 'staffHR.merit',
	'uses' => 'Administrative\HumanResource\StaffManagement\StaffHRController@merit',
]);
// staffHR discipline2
Route::post('/staffHR/{staffHR}', [
	'as' => 'staffHR.meritstore',
	'uses' => 'Administrative\HumanResource\StaffManagement\StaffHRController@meritstore',
]);
// staffHR discipline2 delete
Route::delete('/staffHRdiscipline/{staffHR}', [
	'as' => 'staffHR.ddestroy',
	'uses' => 'Administrative\HumanResource\StaffManagement\StaffHRController@ddestroy',
]);
// received hardcopy
Route::post('/staffTCMS/storeCSV', [
	'as' => 'staffTCMS.storeCSV',
	'uses' => 'Administrative\HumanResource\TCMS\StaffTCMSController@storeCSV'
]);
Route::post('/staffLeaveHR/updateRHC', [
	'as' => 'staffLeaveHR.updateRHC',
	'uses' => 'Administrative\HumanResource\LeaveEditing\StaffLeaveHRController@updateRHC'
]);
// createHR for staff
Route::get('/createHR/{staffHR}', [
		'as' => 'staffHR.createHR',
		'uses' => 'Administrative\HumanResource\StaffManagement\StaffHRController@createHR'
	]);
// storeHR for staff
Route::patch('/storeHR/{staffHR}', [
		'as' => 'staffHR.storeHR',
		'uses' => 'Administrative\HumanResource\StaffManagement\StaffHRController@storeHR'
	]);
// editHR for staff
Route::get('/staffHR/{staffHR}/editHR', [
		'as' => 'staffHR.editHR',
		'uses' => 'Administrative\HumanResource\StaffManagement\StaffHRController@editHR'
	]);
// updateHR for staff
Route::patch('/staffHR/{staffHR}/HR', [
		'as' => 'staffHR.updateHR',
		'uses' => 'Administrative\HumanResource\StaffManagement\StaffHRController@updateHR'
	]);

// promoteHR for staff
Route::get('/staffHR/{staffHR}/promoteHR', [
		'as' => 'staffHR.promoteHR',
		'uses' => 'Administrative\HumanResource\StaffManagement\StaffHRController@promoteHR'
	]);
// promoteupdateHR for staff
Route::patch('/staffHR/{staffHR}/promoteupdateHR', [
		'as' => 'staffHR.promoteupdateHR',
		'uses' => 'Administrative\HumanResource\StaffManagement\StaffHRController@promoteupdateHR'
	]);

Route::delete('disableHR/{staffHR}', [
		'as' => 'staffHR.disableHR',
		'uses' => 'Administrative\HumanResource\StaffManagement\StaffHRController@disableHR'
]);
// generate ALMCML
Route::post('/staffAnnualMCLeave/storeALMCML', [
	'as' => 'staffAnnualMCLeave.storeALMCML',
	'uses' => 'Administrative\HumanResource\LeaveEditing\StaffAnnualMCLeaveController@storeALMCML'
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

// leave editing page controller
Route::resources([
	'leaveSetting' => 'Administrative\HumanResource\LeaveEditing\Settings\LeaveSettingController',
	'leaveNRL' => 'Administrative\HumanResource\LeaveEditing\NRL\LeaveNRLController',
	'leaveList' => 'Administrative\HumanResource\LeaveEditing\LeaveList\LeaveListController',
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
// discipline Ajax Controller
Route::get('/discipline', [
		'as' => 'workinghour.discipline',
		'uses' => 'AjaxRemote\WorkingHourAjaxController@discipline'
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
// dts Ajax Controller
Route::post('/dts', [
		'as' => 'workinghour.dts',
		'uses' => 'AjaxRemote\WorkingHourAjaxController@dts'
	]);

############################################################################
// dte Ajax Controller
Route::post('/dte', [
		'as' => 'workinghour.dte',
		'uses' => 'AjaxRemote\WorkingHourAjaxController@dte'
	]);

############################################################################
// dte Ajax Controller
Route::post('/tftimeperiod', [
		'as' => 'workinghour.tftimeperiod',
		'uses' => 'AjaxRemote\WorkingHourAjaxController@tftimeperiod'
	]);

############################################################################





















############################################################################
// PrintPDFLeaves Controller
Route::get('printpdfleaves/{staffLeave}', [
		'as' => 'printpdfleave.show',
		'uses' => 'PDFController\PrintPDFLeavesController@show'
	]);

Route::post('printpdftcms', [
		'as' => 'printpdftcms.store',
		'uses' => 'PDFController\PrintPDFLeavesController@tcmsstore'
	]);

############################################################################
Route::post('printpdfovertime', [
		'as' => 'printpdfovertime.store',
		'uses' => 'PDFController\PrintPDFLeavesController@overtime'
	]);

############################################################################
Route::post('printpdfavailability', [
		'as' => 'printpdfavailability.store',
		'uses' => 'PDFController\PrintPDFLeavesController@availability'
	]);

############################################################################
// Ajax Controller
Route::apiResources([
	'ajax' => 'API\AjaxController'
]);














