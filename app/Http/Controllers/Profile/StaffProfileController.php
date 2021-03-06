<?php

namespace App\Http\Controllers\Profile;

// to link back from controller original
use App\Http\Controllers\Controller;

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
        $this->middleware('userown', ['only' => ['show', 'edit', 'update']]);
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
        // dd($request->drivelicense);
        // $request->file('image') == $request->image

        if(!empty($request->file('image'))) {
            $filename = $request->file('image')->store('public/images/profiles');

            $ass1 = explode('/', $filename);
            $ass2 = array_except($ass1, ['0']);
            $image = implode('/', $ass2);

            // dd($image);

            $imag = Image::make(storage_path('app/'.$filename));

            // resize the image to a height of 400 and constrain aspect ratio (auto width)
            $imag->resize(null, 400, function ($constraint) {
                $constraint->aspectRatio();
            });

            $imag->save();
            // dd( array_add($request->except(['image']), 'image', $filename) );

            $res = \App\Model\Staff::updateOrCreate(['id' => $staff->id], array_add($request->except(['image', 'drivelicense']), 'image', $image));
        } else {
            $res = \App\Model\Staff::updateOrCreate(['id' => $staff->id], $request->except(['image', 'drivelicense']));
        }

        //////////////////////////////////////////////////////////////////////////////////////
        // driving license part
        if (!empty($request->drivelicense)) {
            \App\Model\StaffDrivingLicense::where(['staff_id' => $staff->id])->delete();
            foreach ($request->drivelicense as $y) {
                $invoice = \App\Model\StaffDrivingLicense::create([
                        'staff_id' => $staff->id,
                        'driving_license_id' => $y,
                    ]);
            }
        } else {
            \App\Model\StaffDrivingLicense::where(['staff_id' => $staff->id])->delete();
        }

        Session::flash('flash_message', 'Data successfully edited!');
        return redirect( route('staff.show', $staff->id) );
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

    public function search()
    {
        $valid = TRUE;
        $phone = StaffEmergencyPersonPhone::where('phone', $value['phone'])->count();

        if ($phone == 1) 
        {
            $valid = FALSE;
        }
        return response()->json(['valid' => $valid]);
    }
}
