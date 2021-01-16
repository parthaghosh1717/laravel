<?php

namespace App\Http\Controllers\Modules\Teacher;


use Session;
use Auth;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TeacherDashboardController extends Controller
{
    /**
    *   Method      : dashboard.
    *   Description : This is use to display teacher dashboard.
    *   Author      : Partha.
    *   Date        : 13-jan-2021.
    **/

    public function dashboard() 
    {
    	// dd('test');
    	$data['user'] = User::where('id', Auth::user()->id)->first();
    	// dd($data);
    	return view('modules.teacher.teacher_dashboard')->with(@$data);
    }
}
