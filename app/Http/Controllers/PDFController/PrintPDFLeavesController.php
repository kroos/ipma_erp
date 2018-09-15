<?php

namespace App\Http\Controllers\PDFController;

// to link back from controller original
use App\Http\Controllers\Controller;

// load model
use \App\Model\Staff;
use \App\Model\StaffLeave;
use \App\Model\StaffAnnualMCLeave;
use \App\Model\StaffLeaveBackup;
use \App\Model\StaffLeaveReplacement;
use \App\Model\StaffLeaveApproval;

use Illuminate\Http\Request;

class PrintPDFLeavesController extends Controller
{
	function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		return view('production.index');
	}
}
