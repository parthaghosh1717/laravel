<?php

namespace App\Http\Controllers\Modules\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Project; 
use App\User; 
use Auth;
use Storage;

class ProjectController extends Controller
{
     /**
    *   Method      : storeProject.
    *   Description : This is use store new project details.
    *   Author      : Partha.
    *   Date        : 15-01-2021.
    **/

    public function storeProject(Request $request) 
    {
    	 
        // dd($request);

    	// $this->validate($request, [ 
     //        'project_title'  =>'required',             
     //        'description'    =>'required', 
     //        'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'          
     //    ]);

        $response = [
            'jsonrpc' => '2.0'
        ];

        $input['user_id']       = Auth::id();
        $input['project_title'] = $request->project_title;
        $input['description']   = $request->description;
         

        if(@$request->hasFile('file')){

            if($request['project_id'])
            {
               $get_old_image =Project::where('id',$request['project_id'])->first();
                if($get_old_image->file){
                    if($get_old_image->file && file_exists("storage/app/public/images/projectimg/".$get_old_image->file)){
                        
                        unlink("storage/app/public/images/projectimg/".$get_old_image->file);
                    }
                } 
            }
            
              
          $file = $request->file;
          $filename = time().'-'.rand(1000,9999).'.'.$file->getClientOriginalExtension();
          Storage::putFileAs('public/images/projectimg/', $file, $filename);
          // $user->govt_id_filename = $filename;
          $input['file'] =  $filename;
          $response['file'] = $filename;
        }

         

        if($request['project_id'])
        {
            Project::where('id',$request['project_id'])->update($input);
            $response['project'] = Project::where('id',$request['project_id'])->first();
            $response['status'] = 1;
            // $response['file'] = $filename;
            $response['id'] = $request['project_id'];
             // dd($response);
            return response()->json($response);
        }

        // dd($input);
        $response['status'] = 0;
        // $response['file'] = $filename;
        $response['project'] = Project::create($input);

         // dd($response);

        return response()->json($response);
        // return redirect()->back()->with('success', 'Project data insterted successfully');
    }

     /**
    *   Method      : updateProject.
    *   Description : This is use updayte project details.
    *   Author      : Partha.
    *   Date        : 15-01-2021.
    **/

    public function updateProject(Request $request) 
    {
        // dd($request->data['id']);
        $response = [
            'jsonrpc' => '2.0'
        ];

        $response['projectdet'] = Project::where('id',$request->data['id'])->first();
        return response()->json($response);
    }

    /**
    * Method: deleteProject
    * Desc: This method is used to delete project
    * Date:16--0-2021
    * Author: Partha
    */
    public function deleteProject(Request $request)
    {
        $response['jsonrpc'] = '2.0';
        $id = $request->data['id'];

        $get_old_image =Project::where('id',$id)->first();
        if($get_old_image->file){
            if($get_old_image->file && file_exists("storage/app/public/images/projectimg/".$get_old_image->file)){
                
                unlink("storage/app/public/images/projectimg/".$get_old_image->file);
            }
        }

         
        $exp = Project::where('id',$id)->delete();
        if($exp){
            $response['status'] = 1;
        }else{
            $response['status'] = 0;
        }
        return response()->json($response);
    }
}
