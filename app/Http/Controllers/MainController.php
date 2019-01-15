<?php

namespace App\Http\Controllers;

// load emailer
use App\Mail\TestMail;

// load notifications
use App\Notifications\TestNotification;


use Session;

// facades for mail
use Illuminate\Support\Facades\Mail;

use Illuminate\Http\Request;

class MainController extends Controller
{
	function __construct()
	{
		$this->middleware('guest');
	}

	public function index()
	{
		return view('welcome');
	}

// 	public function test()
// 	{
// 		$staff = \App\Model\Staff::where('active', 1)->get();
// 		$s = [];
// 		foreach ($staff as $st) {
// 			$s[] = ['id' => $st->id, 'name' => $st->name];
// 		}
// 		return response()->json($s);
// 	}

	public function mailer()
	{
		Mail::to('it@ipmaindustry.com', 'faiz')->send(new TestMail());
		Session::flash('flash_message', 'Email Sent!');
		return redirect( route('main.index') );
	}

	public function notifi()
	{
		$toUser = \App\Model\Staff::find(186);
		$fromUser = \App\Model\Staff::find(48);
		$toUser->notify(new TestNotification($fromUser));

		$user = \App\Model\Staff::find(186);
		// foreach (\Auth::user()->notifications as $notification) {
		foreach ($user->notifications as $notification) {
			echo $notification->type.'<br />';
		}
	}

	public function create()
	{
		//
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