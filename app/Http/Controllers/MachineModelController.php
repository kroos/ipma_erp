<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

// load model
use App\Model\ICSMachineModel;

use Illuminate\Http\Request;

use Session;

class MachineModelController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		return view('machine_model.index');
	}

	public function create()
	{
		return view('machine_model.create');
	}

	public function store(Request $request)
	{
		// var_dump($request->all());
		ICSMachineModel::create($request->only('model'));
		Session::flash('flash_message', 'Data successfully stored!');
		return redirect( route('machine_model.index') );
	}

	public function show(ICSMachineModel $machine_model)
	{
	}

	public function edit(ICSMachineModel $machine_model)
	{
		return view('machine_model.edit', compact(['machine_model']));
	}

	public function update(Request $request, ICSMachineModel $machine_model)
	{
		ICSMachineModel::find($machine_model->id)->update($request->only('model'));
		Session::flash('flash_message', 'Data successfully updated!');
		return redirect( route('machine_model.index') );
	}

	public function destroy(ICSMachineModel $machine_model)
	{
		$machine_model->destroy($machine_model->id);
		return response()->json([
			'message' => 'Data deleted',
			'status' => 'success'
		]);
	}
}
