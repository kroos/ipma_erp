<?php

namespace App\Http\Controllers;

use App\Model\Customer;
use Illuminate\Http\Request;

use Session;

class CustomerController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
	//
	}

	public function create(Request $request)
	{
		return view('customer.create');
	}

	public function store(Request $request)
	{
		// var_dump($request->all());
// die();
		Customer::create($request->only(['customer', 'pc', 'address1', 'address2', 'address3', 'address4', 'phone', 'fax']));
		Session::flash('flash_message', 'Data successfully save!');

		if($request->id == 0) {
			return redirect( route('serviceReport.create') );
		} elseif ($request->kiv == 00) {
			return redirect( route('serviceReport.editkiv', $request->id) );
		} else {
			return redirect( route('serviceReport.edit', $request->id) );
		}
	}

	public function show(Department $department)
	{
	//
	}

	public function edit(Department $department)
	{
	//
	}

	public function update(Request $request, Department $department)
	{
	//
	}

	public function destroy(Department $department)
	{
	//
	}
}
		// Session::flash('flash_message', 'Data successfully update!');
		// return redirect( route('tcms.index') );