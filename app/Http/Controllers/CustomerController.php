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
		return view('customer.index');
	}

	public function create(Request $request)
	{
		return view('customer.create');
	}

	public function store(Request $request)
	{
		// var_dump($request->all());
// die();
		// Customer::create($request->only(['customer', 'pc', 'address1', 'address2', 'address3', 'address4', 'phone', 'fax']));
		Customer::create($request->except(['_method', '_token']));
		Session::flash('flash_message', 'Data successfully save!');
		return redirect( route('customer.index') );
	}

	public function show(Customer $customer)
	{

	}

	public function edit(Customer $customer)
	{
		return view('customer.edit', compact(['customer']));
	}

	public function update(Request $request, Customer $customer)
	{
		Customer::where('id', $customer->id)->update($request->only(['customer', 'pc', 'address1', 'address2', 'address3', 'address4', 'phone', 'fax']));
		Session::flash('flash_message', 'Data successfully save!');
		return redirect( route('customer.index') );
	}

	public function destroy(Customer $customer)
	{
		$customer->destroy($customer->id);
		return response()->json([
			'message' => 'Data deleted',
			'status' => 'success'
		]);
	}
}