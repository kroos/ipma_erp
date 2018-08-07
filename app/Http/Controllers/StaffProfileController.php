<?php

namespace App\Http\Controllers;

// load model
use App\Model\Staff;

use Illuminate\Http\Request;

// load validation
use App\Http\Requests\StaffProfileRequest;

// for manipulating image
// http://image.intervention.io/
// use Intervention\Image\Facades\Image as Image;       <-- ajaran sesat depa... hareeyyyyy!!
use Intervention\Image\ImageManagerStatic as Image;

use Session;

class StaffProfileController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('admin', ['except' => ['create', 'store']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StaffProfileRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Staff $staff)
    {
        return view('profile.show', compact(['staff']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Staff $staff)
    {
        return view('profile.edit', compact(['staff']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StaffProfileRequest $request, Staff $staff)
    {
        // dd($request->all());
        $filename = $request->file('image')->store('images/profiles');
        $imag = Image::make(public_path().'/images/profiles/'.$filename);

        // resize the image to a height of 400 and constrain aspect ratio (auto width)
        $imag->resize(null, 400, function ($constraint) {
            $constraint->aspectRatio();
        });

        $imag->save();

        $res = \App\Model\Staff::updateOrCreate(['id' => $staff->id], $request->only([
                                                                                        'id_card_passport', 'religion_id', 'gender_id', 'race_id', 'address', 'pob', 'country_id', 'marital_status_id', 'mobile', 'phone', 'dob', 'cimb_account', 'epf_no', 'income_tax_no', 'created_at', 'updated_at'
                                                                                    ])
                                                );

        // Session::flash('flash_message', 'Data successfully edited!');
        // return redirect( route('staff.show', $staff->id) );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Staff $staff)
    {
        //
    }
}
