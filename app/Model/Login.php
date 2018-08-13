<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Login extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'staff_id', 'username', 'password', 'active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function belongtostaff()
    {
       return $this->belongsTo('App\Model\Staff', 'staff_id');
    }

/////////////////////////////////////////////////////////////////////////////////////////////////////

    // staff profile can only be edited by its respective owner and Admin and HR or backup HR HOD ONLY
    public function isOwner( $id ) {
        // dd($id);
        if ( auth()->user()->belongtostaff->belongtoposition->id == 1 || auth()->user()->belongtostaff->belongtoposition->id == 2 || auth()->user()->belongtostaff->belongtoposition->id == 3 || auth()->user()->belongtostaff->id == $id /*|| auth()->user()->belongtostaff->id == 186*/   || auth()->user()->belongtostaff->belongtoposition->id == 12 || (auth()->user()->belongtostaff->belongtoposition->id == 13 && auth()->user()->belongtostaff->belongtoposition->head_backup == 1) ) {
            return true;
        } else {
            return false;
       }
    }

    public function editStaffChildren( $id )
    {
        // dd( \Auth::user()->belongtostaff->hasmanychildren()->get() );
        foreach ( \Auth::user()->belongtostaff->hasmanychildren()->get() as $key) {
            if(
                $key->staff_id == $id
            ) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function editStaffSpouse( $id )
    {
        // dd( \Auth::user()->belongtostaff->hasmanyspouse()->get() );
        foreach ( \Auth::user()->belongtostaff->hasmanyspouse()->get() as $key) {
            if(
                $key->staff_id == $id
            ) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function editStaffSibling( $id )
    {
        // dd( \Auth::user()->belongtostaff->hasmanysibling()->get() );
        foreach ( \Auth::user()->belongtostaff->hasmanysibling()->get() as $key) {
            if(
                $key->staff_id == $id
            ) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function editStaffEmergencyPerson( $id )
    {
        // dd( \Auth::user()->belongtostaff->hasmanyemergencyperson()->get() );
        foreach ( \Auth::user()->belongtostaff->hasmanyemergencyperson()->get() as $key) {
            // dd($id);
            if(
                $key->staff_id == $id
            ) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function editStaffEmergencyPersonPhone( $id )
    {
        dd( \Auth::user()->belongtostaff->hasmanyemergencyperson()->hasmanyemergencypersonphone()->get() );
        foreach ( \Auth::user()->belongtostaff->hasmanyemergencyperson()->hasmanyemergencypersonphone()->get() as $key) {
            // dd($id);
            if(
                $key->staff_id == $id
            ) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function editStaffEducation( $id )
    {
        // dd( \Auth::user()->belongtostaff->hasmanyemergencyperson()->get() );
        foreach ( \Auth::user()->belongtostaff->hasmanyeducation()->get() as $key) {
            // dd($id);
            if(
                $key->staff_id == $id
            ) {
                return true;
            } else {
                return false;
            }
        }
    }

}
