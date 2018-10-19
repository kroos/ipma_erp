<?php

namespace App\Http\Controllers\PDFController;

// to link back from controller original
use App\Http\Controllers\Controller;

// load model
use App\Model\Staff;
use App\Model\StaffLeave;
use App\Model\StaffAnnualMCLeave;
use App\Model\StaffLeaveBackup;
use App\Model\StaffLeaveReplacement;
use App\Model\StaffLeaveApproval;

use Illuminate\Http\Request;

class PrintPDFLeavesController extends Controller
{
	function __construct()
	{
		$this->middleware('auth');
		// $this->middleware('leaveaccess');
	}

	public function show(StaffLeave $staffLeave)
	{
		echo view('pdfleave.show', compact(['staffLeave']) );
	}

	public function tcmsstore(Request $request)
	{
		$dts = $request->date_start;
		$dte = $request->date_end;
		echo view('pdfleave.staffTCMS', compact(['dts', 'dte']));
	}
}
