<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MarketingAndBusinessDevelopmentController extends Controller
{
	function __construct()
	{
		$this->middleware('auth');
		// $this->middleware('admin', ['except' => ['create', 'store']]);
	}

	public function index()
	{
		return view('marketingAndBusinessDevelopment.index');
	}
}
