<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Users;

class AdvancedReg extends Controller
{
	public function confirm($confirmation_code)
	{
		$user=Users::where('confirmation_code','=',$confirmation_code)->firstOrFail(); 
		$user->confirmed = 1;
		$user->confirmation_code = '';
		$user->save();
		return view('/home');
	}
}
