<?php

namespace App\Http\Controllers\Sales\CustomerService;

use App\Http\Controllers\Controller;

// load model
use App\Model\ICSServiceReport;

use Illuminate\Http\Request;

class ServiceReportController extends Controller
{
	function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		return view('marketingAndBusinessDevelopment.customerservice.ics.index');
	}

	public function create()
	{
		return view('marketingAndBusinessDevelopment.customerservice.ics.create');
	}

	public function store(Request $request)
	{
	//
	}

	public function show(Leave $leave)
	{
	//
	}

	public function edit(Leave $leave)
	{
	//
	}

	public function update(Request $request, Leave $leave)
	{
	//
	}

	public function destroy(Leave $leave)
	{
	//
	}
}
