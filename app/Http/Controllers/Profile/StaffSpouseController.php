<?php

namespace App\Http\Controllers\Profile;

// to link back from controller original
use App\Http\Controllers\Controller;

use App\Model\StaffSpouse;
use Illuminate\Http\Request;

// load validation
use App\Http\Requests\StaffSpouseRequest;
use App\Http\Requests\StaffSpouseEditRequest;


use Session;

class StaffSpouseController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('userspouse', ['except' => ['create', 'store']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('staffSpouse.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StaffSpouseRequest $request)
    {
        // dd(auth()->user()->belongtostaff->id);
        // dd( array_add($request->staff, 'staff_id', auth()->user()->belongtostaff->id) );


        // \App\Model\StaffSpouse::create( $request->all() );

        foreach ($request->staff as $key => $val) {

            // print_r ($val);
            // $staffspouse = new StaffSpouse($val);

            // auth()->user()->belongtostaff->save($staffspouse);

            StaffSpouse::create( array_add($val, 'staff_id', auth()->user()->belongtostaff->id) );

            // $serialtrack = StaffSpouse::create([
            //         'id_sales' => $inv->id,
            //         'tracking_number' => $val['tracking_number'],
            //     ]);
        }



        Session::flash('flash_message', 'Data successfully edited!');
        return redirect( route('staff.show', auth()->user()->belongtostaff->id) );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\StaffSpouse  $staffSpouse
     * @return \Illuminate\Http\Response
     */
    public function show(StaffSpouse $staffSpouse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StaffSpouse  $staffSpouse
     * @return \Illuminate\Http\Response
     */
    public function edit(StaffSpouse $staffSpouse)
    {
        return view('staffSpouse.edit', compact(['staffSpouse']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StaffSpouse  $staffSpouse
     * @return \Illuminate\Http\Response
     */
    public function update(StaffSpouseEditRequest $request, StaffSpouse $staffSpouse)
    {
        StaffSpouse::where('id', $staffSpouse->id)->update($request->except(['_method', '_token']) );

        // info when update success
        Session::flash('flash_message', 'Data successfully edited!');

        return redirect( route('staff.show', auth()->user()->belongtostaff->id) );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StaffSpouse  $staffSpouse
     * @return \Illuminate\Http\Response
     */
    public function destroy(StaffSpouse $staffSpouse)
    {
        StaffSpouse::destroy($staffSpouse->id);
        return response()->json([
                                    'message' => 'Data deleted',
                                    'status' => 'success'
                                ]);
    }
}
