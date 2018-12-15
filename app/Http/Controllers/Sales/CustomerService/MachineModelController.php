<?php

namespace App\Http\Controllers\Sales\CustomerService;

use App\Http\Controllers\Controller;

// load model
use App\Model\ICSMachineModel;

use Illuminate\Http\Request;

use Session;

class MachineModelController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
	}

	public function create()
	{
		return view('marketingAndBusinessDevelopment.customerservice.machine_model.create');
	}

	public function store(Request $request)
	{
		// var_dump($request->all());
		ICSMachineModel::create($request->only('model'));
		Session::flash('flash_message', 'Data successfully stored!');
		return redirect( route('serviceReport.edit', $request->id) );
	}

	public function show(ICSServiceReport $serviceReport)
	{
	}

	public function edit(ICSServiceReport $serviceReport)
	{
	}

	public function update(Request $request, ICSServiceReport $serviceReport)
	{

	}

	public function destroy(ICSServiceReport $serviceReport)
	{

	}
}
