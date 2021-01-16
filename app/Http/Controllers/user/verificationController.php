<?php

namespace App\Http\Controllers\user;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Session;

class verificationController extends Controller
{
    public function verify($token)
    {
    	$user = User::where('remember_token',$token)->first();

    	if (!is_null($user)) 
    	{ 
	    	$user->status = 1;	    	 
	    	$user->save();

	    	Session::flash('success', 'You are register successfully !!!!');
	        return redirect('login');
    	}
    	else
    	{
    		Session::flash('success', 'Sorry your token is not match !');
	        return redirect('/');

    	}

    		

    }
}
