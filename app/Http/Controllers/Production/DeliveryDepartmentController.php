<?php

namespace App\Http\Controllers\Production;

// to link back from controller original
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class DeliveryDepartmentController extends Controller
{
	// must always refer to php artisan route:list
	function __construct()
	{
		$this->middleware('auth');
		// $this->middleware('admin', ['except' => ['create', 'store']]);
	}

	public function index()
	{
		return view('production.delivery.index');
	}
}
