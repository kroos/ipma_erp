<?php

namespace App\Http\Controllers\Division;

// to link back from controller original
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class MarketingAndBusinessDevelopmentController extends Controller
{
	function __construct()
	{
		$this->middleware('auth');
		$this->middleware('diviaccess');
	}

	public function index()
	{
		return view('marketingAndBusinessDevelopment.index');
	}
}
