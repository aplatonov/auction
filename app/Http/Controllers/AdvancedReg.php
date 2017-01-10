<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Users;

class AdvancedReg extends Controller
{

    /**
     * Confirm user in DB by confirmation code
     * from parameter
     *
     * @param  integer $confirmation_code
     * @return view
     */
	public function confirm($confirmation_code)
	{
		$user=Users::where('confirmation_code','=',$confirmation_code)->firstOrFail(); 
		if ($user) {
			$user->confirmed = 1;
			$user->confirmation_code = '';
			$user->save();
			return redirect('/home');
		} else {
			return back()->with('message','не подтвержден email');
		}
	}
}
