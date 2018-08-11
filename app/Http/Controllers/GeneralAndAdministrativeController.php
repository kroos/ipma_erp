<?php

namespace App\Http\Controllers;

use App\Model\Division;

use Illuminate\Http\Request;

class GeneralAndAdministrativeController extends Controller
{
	function __construct()
	{
		$this->middleware('auth');
		// $this->middleware('admin', ['except' => ['create', 'store']]);
	}

	public function index()
	{
		return view('generalAndAdministrative.index');
	}
}
