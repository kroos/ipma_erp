<?php

namespace App\Http\Controllers\Profile;

// to link back from controller original
use App\Http\Controllers\Controller;

// load model
use App\Model\Login;

use Illuminate\Http\Request;

// load validation
use App\Http\Requests\ChangePasswordRequest;


use Session;

class LoginController extends Controller
{
	function __construct()
	{
		$this->middleware(['auth', 'ownerchangepassword']);
	}

	public function index()
	{
		//
	}

	public function create()
	{

	}

	public function store(ChangePasswordRequest $request)
	{
		Session::flash('flash_message', 'Data successfully edited!');
		return redirect( route('staff.show', auth()->user()->belongtostaff->id) );
	}

	public function show(Login $login)
	{
		//
	}

	public function edit(Login $login)
	{
		return view('changepass.edit', compact(['login']));
	}

	public function update(ChangePasswordRequest $request, Login $login)
	{
		var_dump($request->except(['_token', '_method']));
		$login->update($request->except(['_token', '_method']));
		Session::flash('flash_message', 'Data successfully edited!');
		return redirect( route('home') );
	}

	public function destroy(Login $login)
	{

	}
}
