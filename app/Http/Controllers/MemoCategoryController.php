<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

// load model
use App\Model\MemoCategory;

use Illuminate\Http\Request;

use Session;

class MemoCategoryController extends Controller
{
	function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
	}

	public function create()
	{
	}

	public function store(Request $request)
	{
	}

	public function show(MemoCategory $memoCat)
	{
	}

	public function edit(MemoCategory $memoCat)
	{
	}

	public function update(Request $request, MemoCategory $memoCat)
	{
	//
	}

	public function destroy(MemoCategory $memoCat)
	{
	}
}
