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

Route::get('/phpinfo', function() {
	echo phpinfo();
});

// EMAILER
Route::get('/mailer', [
		'as' => 'main.mailer',
		'uses' => 'MainController@mailer'
	]);

// notify
Route::get('/notify', [
		'as' => 'main.notifi',
		'uses' => 'MainController@notifi'
	]);


############################################################################

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
	'staffDis' => 'Administrative\HumanResource\StaffManagement\StaffDisciplineController',
	'staffResign' => 'Administrative\HumanResource\StaffManagement\StaffResignController',
// staff warning & verbal warning
	'staffMemo' => 'Administrative\HumanResource\StaffManagement\StaffMemoController',
	'staffDisciplinaryAct' => 'Administrative\HumanResource\StaffManagement\StaffDisciplinaryActionController',

// setting double date in HR
	'settingDoubleDate' => 'Administrative\HumanResource\HRSettings\SettingDoubleDateController',

// setting 3 days checking in HR
	'setting3DaysChecking' => 'Administrative\HumanResource\HRSettings\Setting3DaysCheckingController',

// sales
	'serviceReport' => 'Sales\CustomerService\ServiceReportController',
	'srSerial' => 'Sales\CustomerService\ServiceReportSerialController',
	'srAttend' => 'Sales\CustomerService\ServiceReportAttendeesController',
	'srAttendPhone' => 'Sales\CustomerService\ServiceReportPhoneAttendeesController',
	'srModel' => 'Sales\CustomerService\ServiceReportModelController',
	'srPart' => 'Sales\CustomerService\ServiceReportPartAccessoryController',
	'srJob' => 'Sales\CustomerService\ServiceReportJobController',
	'srFeedProb' => 'Sales\CustomerService\ServiceReportFeedbackProblemController',
	'srFeedReq' => 'Sales\CustomerService\ServiceReportFeedbackRequestController',
	'srFeedItem' => 'Sales\CustomerService\ServiceReportFeedbackItemController',
	'srLogistic' => 'Sales\CustomerService\ServiceReportLogisticController',
	'srAddCharge' => 'Sales\CustomerService\ServiceReportAdditionalChargesController',
	'srDiscount' => 'Sales\CustomerService\ServiceReportDiscountController',
	'srCCall' => 'Sales\CustomerService\ServiceReportFeedbackCallController',

	'srConstant' => 'Sales\CustomerService\ServiceReportFLOATTHConstantController',

// cs order
	'csOrder' => 'Sales\CustomerService\CSOrderController',
	'csOrderItem' => 'Sales\CustomerService\CSOrderItemController',

// customer
	'customer' => 'CustomerController',

// ics machine model
	'machine_model' => 'MachineModelController',

// memo category
	'MemoCategoryController' => 'MemoCategoryController',

// todo schedule
	'todoSchedule' => 'Admin\ToDoScheduleController',
	'todoList' => 'Admin\ToDoListController',

// quotation
	'quot' => 'Sales\Costing\QuotationController',

	'quotRevision' => 'Sales\Costing\QuotationRevisionController',
	'quotSection' => 'Sales\Costing\QuotationSectionController',
	'quotSectionItem' => 'Sales\Costing\QuotationSectionItemController',
	'quotSectionItemAttrib' => 'Sales\Costing\QuotationSectionItemAttributeController',

	'quotTerm' => 'Sales\Costing\QuotQuotationTermOfPaymentController',
	'quotExclusion' => 'Sales\Costing\QuotQuotationExclusionController',
	'quotRemark' => 'Sales\Costing\QuotQuotationRemarkController',

	'quotdd' => 'Sales\Costing\QuotationDeliveryDateController',
	'quotItem' => 'Sales\Costing\QuotationItemController',
	'quotItemAttrib' => 'Sales\Costing\QuotationItemAttributeController',
	'quotRem' => 'Sales\Costing\QuotationRemarkController',
	'quotExcl' => 'Sales\Costing\QuotationExclusionController',
	'quotUOM' => 'Sales\Costing\QuotationUOMController',
]);
//////////////////////////////////////////////////////////////////////////////////////////////////
// change password
Route::get('/login/{login}', [
	'as' => 'login.edit',
	'uses' => 'Profile\LoginController@edit'
]);
Route::patch('/login/{login}', [
	'as' => 'login.update',
	'uses' => 'Profile\LoginController@update'
]);
//////////////////////////////////////////////////////////////////////////////////////////////////
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
// disable staff
Route::delete('disableHR/{staffHR}', [
		'as' => 'staffHR.disableHR',
		'uses' => 'Administrative\HumanResource\StaffManagement\StaffHRController@disableHR'
]);
// generate ALMCML
Route::post('/staffAnnualMCLeave/storeALMCML', [
	'as' => 'staffAnnualMCLeave.storeALMCML',
	'uses' => 'Administrative\HumanResource\LeaveEditing\StaffAnnualMCLeaveController@storeALMCML'
]);

//////////////////////////////////////////////////////////////////////////////////////////////////
## service report section
// index costing service report
Route::get('/ics/costing', [
	'as' => 'ics.costing',
	'uses' => 'Sales\CustomerService\ServiceReportController@costing'
]);
// index costing service report
Route::get('/ics/account', [
	'as' => 'ics.account',
	'uses' => 'Sales\CustomerService\ServiceReportController@account'
]);
// edit update invoice sr
Route::get('/serviceReport/{serviceReport}/editinvoiceSR', [
		'as' => 'serviceReport.editinvoiceSR',
		'uses' => 'Sales\CustomerService\ServiceReportController@editinvoiceSR'
	]);
// edit update invoice sr
Route::patch('/serviceReport/{serviceReport}/updateinvoiceSR', [
		'as' => 'serviceReport.updateinvoiceSR',
		'uses' => 'Sales\CustomerService\ServiceReportController@updateinvoiceSR'
	]);
// approve sr
Route::patch('/serviceReport/{serviceReport}/updateApproveSR', [
		'as' => 'serviceReport.updateApproveSR',
		'uses' => 'Sales\CustomerService\ServiceReportController@updateApproveSR'
	]);
// edit kiv service report
Route::get('/serviceReport/{serviceReport}/editkiv', [
	'as' => 'serviceReport.editkiv',
	'uses' => 'Sales\CustomerService\ServiceReportController@editkiv'
]);
// show float-th
Route::get('/serviceReport/{serviceReport}/float-th', [
	'as' => 'serviceReport.floatth',
	'uses' => 'Sales\CustomerService\ServiceReportController@floatth'
]);
// print parts of float-th
Route::post('/serviceReport/{serviceReport}/floatthstore', [
	'as' => 'serviceReport.floatthstore',
	'uses' => 'Sales\CustomerService\ServiceReportController@floatthstore'
]);
// update kiv service report
Route::patch('/serviceReport/{serviceReport}/updatekiv', [
	'as' => 'serviceReport.updatekiv',
	'uses' => 'Sales\CustomerService\ServiceReportController@updatekiv'
]);
// update unapproved service report
Route::post('/serviceReport/updateunapprove', [
	'as' => 'serviceReport.updateunapprove',
	'uses' => 'Sales\CustomerService\ServiceReportController@updateunapprove'
]);
// update send SR service report
Route::patch('/serviceReport/{serviceReport}/sendSR', [
	'as' => 'serviceReport.sendSR',
	'uses' => 'Sales\CustomerService\ServiceReportController@updatesendSR'
]);

// update send SR service report
Route::patch('/serviceReport/{serviceReport}/checkSR', [
	'as' => 'serviceReport.checkSR',
	'uses' => 'Sales\CustomerService\ServiceReportController@updatecheckbySR'
]);

// update deactivate SR service report
Route::patch('/serviceReport/{serviceReport}/updateDeactivate', [
	'as' => 'serviceReport.updateDeactivate',
	'uses' => 'Sales\CustomerService\ServiceReportController@updateDeactivate'
]);

//////////////////////////////////////////////////////////////////////////////////////////////////
## To do list
// toggle task schedule
Route::patch('/todoSchedule/{todoSchedule}/updatetoggle', [
		'as' => 'todoSchedule.updatetoggle',
		'uses' => 'Admin\ToDoScheduleController@updatetoggle'
	]);
// update task list from user
Route::patch('/todoList/{todoList}/updatetask', [
		'as' => 'todoList.updatetask',
		'uses' => 'Admin\ToDoListController@updatetask'
	]);

//////////////////////////////////////////////////////////////////////////////////////////////////
// CS Order item/Part
Route::post('csOrder/delivery', [
		'as' => 'csOrder.delivery',
		'uses' => 'Sales\CustomerService\CSOrderController@delivery'
	]);

Route::get('csOrder/deliverymethod', [
		'as' => 'csOrder.deliverymethod',
		'uses' => 'Sales\CustomerService\CSOrderController@deliverymethod'
	]);

Route::post('csOrder/deliverymethodstore', [
		'as' => 'csOrder.deliverymethodstore',
		'uses' => 'Sales\CustomerService\CSOrderController@deliverymethodstore'
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
// WorkingHour Ajax Controller
Route::post('/serialnumberoverlapped', [
		'as' => 'workinghour.serialnooverlapped',
		'uses' => 'AjaxRemote\WorkingHourAjaxController@srserialoverlapped'
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
Route::get('printpdfsr/{sr}/srprintprev', [
		'as' => 'printpdfsr.show',
		'uses' => 'PDFController\PrintPDFLeavesController@srprintprev'
	]);

############################################################################
// Ajax Controller
Route::apiResources([
	'ajax' => 'API\AjaxController'
]);














