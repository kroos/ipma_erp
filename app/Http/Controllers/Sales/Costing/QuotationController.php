<?php

namespace App\Http\Controllers\Sales\Costing;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuotationController extends Controller
{
	function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		return view('marketingAndBusinessDevelopment.costing.quotation.index');
	}

	public function create()
	{
		return view('marketingAndBusinessDevelopment.costing.quotation.create');
	}

	public function store(Request $request)
	{
		//
	}

	public function show($id)
	{
		//
	}

	public function edit($id)
	{
		//
	}

	public function update(Request $request, $id)
	{
		//
	}

	public function destroy($id)
	{
		//
	}
}
