<?php

namespace App\Http\Controllers\Modules\Student;

use Session;
use Auth;
use App\User; 
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
    *   Method      : dashboard.
    *   Description : This is use to display student dashboard.
    *   Author      : Partha.
    *   Date        : 13-jan-2021.
    **/

    public function dashboard() 
    {
    	// dd('test');
    	$data['user'] = User::where('id', Auth::user()->id)->first();
    	// dd($data);
        $data['project'] = Project::where('user_id',Auth::user()->id)->orderBy('created_at','DESC')->paginate(5);
         
    	return view('modules.student.std_dashboard')->with(@$data);
    }
}
