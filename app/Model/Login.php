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
	// all acl will be done here
	// only main position is counted, else, deny access
	public function isOwner( $id ) {
		if ( auth()->user()->belongtostaff->id == $id ) {
			return true;
		} else {
			$re = \Auth::user()->belongtostaff->belongtomanyposition;
			foreach ($re as $key) {
				if($key->pivot->main == 1) {
					if($key->group_id == 1 || $key->group_id == 2) {return true;} else {return false;}
				}
			}
		}
	}
	
	public function editStaffChildren( $id )
	{
	// dd( \Auth::user()->belongtostaff->hasmanychildren()->get() );
		foreach ( \Auth::user()->belongtostaff->hasmanychildren()->get() as $key) {
			if($key->staff_id == $id) {
				return true;
			} else {
				$rq = \Auth::user()->belongtostaff->belongtomanyposition;
				foreach ($rq as $val) {
					if($val->pivot->main == 1) {
						if($val->group_id == 1 || $val->group_id == 2) {return true;} else {return false;}
					}
				}
			}
		}
	}
	
	public function editStaffSpouse( $id )
	{
	// dd( \Auth::user()->belongtostaff->hasmanyspouse()->get() );
		foreach ( \Auth::user()->belongtostaff->hasmanyspouse()->get() as $key) {
			if($key->staff_id == $id) {
				return true;
			} else {
				$rq = \Auth::user()->belongtostaff->belongtomanyposition;
				foreach ($rq as $val) {
					if($val->pivot->main == 1) {
						if($val->group_id == 1 || $val->group_id == 2) {return true;} else {return false;}
					}
				}
			}
		}
	}
	
	public function editStaffSibling( $id )
	{
	// dd( \Auth::user()->belongtostaff->hasmanysibling()->get() );
		foreach ( \Auth::user()->belongtostaff->hasmanysibling()->get() as $key) {
			if($key->staff_id == $id) {
				return true;
			} else {
				$rq = \Auth::user()->belongtostaff->belongtomanyposition;
				foreach ($rq as $val) {
					if($val->pivot->main == 1) {
						if($val->group_id == 1 || $val->group_id == 2) {return true;} else {return false;}
					}
				}
			}
		}
	}
	
	public function editStaffEmergencyPerson( $id )
	{
	// dd( \Auth::user()->belongtostaff->hasmanyemergencyperson()->get() );
		foreach ( \Auth::user()->belongtostaff->hasmanyemergencyperson()->get() as $key) {
			if($key->staff_id == $id) {
				return true;
			} else {
				$rq = \Auth::user()->belongtostaff->belongtomanyposition;
				foreach ($rq as $val) {
					if($val->pivot->main == 1) {
						if($val->group_id == 1 || $val->group_id == 2) {return true;} else {return false;}
					}
				}
			}
		}
	}
	
	public function editStaffEmergencyPersonPhone( $id )
	{
		if ( \Auth::user()->belongtostaff()->first()->id == $id ) {
			return true;
		} else {
			$rq = \Auth::user()->belongtostaff->belongtomanyposition;
			foreach ($rq as $val) {
				if($key->pivot->main == 1) {
					if($key->group_id == 1 || $key->group_id == 2) {return true;} else {return false;}
				}
			}
		}
	
	}
	
	public function editStaffEducation( $id )
	{
		foreach ( \Auth::user()->belongtostaff->hasmanyeducation()->get() as $key) {
			if($key->staff_id == $id) {
				return true;
			} else {
				$rq = \Auth::user()->belongtostaff->belongtomanyposition;
				foreach ($rq as $val) {
					if($val->pivot->main == 1) {
						if($val->group_id == 1 || $val->group_id == 2) {return true;} else {return false;}
					}
				}
			}
		}
	}
	
	public function accessdivision( $id )
	{
		$rt = \Auth::user()->belongtostaff->belongtomanyposition()->get();
		foreach ($rt as $flo) {
			if($flo->belongtodivision->route == $id){
				return true;
			} else {
				// if user is in group director or HOD, then its true, otherwise its false
				if($flo->pivot->main == 1) {
					if($flo->group_id == 1 || $flo->group_id == 2) {
						return true;
					}
				}
			}
		}
	}
	
	public function accessdepartment( $id )
	{
		$rt = \Auth::user()->belongtostaff->belongtomanyposition()->get();
		foreach ($rt as $lok) {
			// some user got no depatment and they are in a higher status, so let them pass all the department
			if(empty($lok->belongtodepartment)) {
				return true;
			} else {
				if($lok->belongtodepartment->route == $id) {
					return true;
				} else {
					// check to see if its an administrtor
					if ($lok->pivot->main == 1) {
						if($lok->group_id == 1 || $lok->group_id == 2) {
							return true;
						}
					}
				}
			}
		}











		// if( empty(\Auth::user()->belongtostaff->belongtoposition->belongtodepartment) ) {
		// 	return true;
		// } else {
		// 	if( \Auth::user()->belongtostaff->belongtoposition->belongtogroup->id == '1'){
		// 		return true;
		// 	}else{
		// 		if (\Auth::user()->belongtostaff->belongtoposition->belongtodepartment->route == $id) {
		// 			return true;
		// 		} else {
		// 			return false;
		// 		}
		// 	}
		// }
	}

}
