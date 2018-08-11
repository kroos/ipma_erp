<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountDepartmentController extends Controller
{
	// must always refer to php artisan route:list
	function __construct()
	{
		$this->middleware('auth');
		// $this->middleware('admin', ['except' => ['create', 'store']]);
	}

	public function index()
	{
		return view('generalAndAdministrative.account.index');
	}
}
