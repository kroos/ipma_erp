<?php

namespace App\Http\Controllers\Admin;

// to link back from controller original
use App\Http\Controllers\Controller;

// load model
use App\Model\Division;

use Illuminate\Http\Request;

class AdminController extends Controller
{
	function __construct()
	{
		$this->middleware('auth');
		$this->middleware('diviaccess');
	}

	public function index()
	{
		return view('generalAndAdministrative.admin.index');
	}
}
