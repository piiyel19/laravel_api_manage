<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use DB;
use App\Teammember;

class TeammemberController extends Controller
{
    //
    function create(Request $request)
    {
        header('Access-Control-Allow-Headers: origin, x-requested-with, accept');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Expose-Headers: X-Mashery-Error-Code, X-Mashery-Responder');
        header('Access-Control-Max-Age: 3628800');
        //echo '123';
        //return $request->post();
        $rules = [
			'email' => 'required',
			'project_id' => 'required'
		];
        
        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails())
        {
            // The given data did not pass validation
            return response()->json(['response'=>'Error']);
        } else {

            $project_id = $request->project_id;
            $email = $request->email;
            

            $user = DB::table('users')->where('email', $email)->first();
            if(empty($user)){
                return response()->json(['response'=>'User Not Valid']);
            } else {    
                $user1 = DB::table('teammembers')->where('email', $email)->where('project_id', $project_id)->first();
                if(empty($user1)){

                    $uid = $user->uid;

                    $team = new Teammember;
                    $team->project_id = $project_id;
                    $team->uid = $uid;
                    $team->email = $email;
                    $team->role_project = 'Member';
                    $team->save();

                    return response()->json(['response'=>'Success']);

                } else {
                    return response()->json(['response'=>'User Existing']);
                }
            }

        }

    }


    function view(Request $request)
    {
        header('Access-Control-Allow-Headers: origin, x-requested-with, accept');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Expose-Headers: X-Mashery-Error-Code, X-Mashery-Responder');
        header('Access-Control-Max-Age: 3628800');
        //echo '123';
        //return $request->post();
        $rules = [
			'project_id' => 'required'
		];
        
        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails())
        {
            // The given data did not pass validation
            return response()->json(['response'=>'Error']);
        } else {
            $project_id = $request->project_id;
            $data_users = DB::table('teammembers')
                ->select('uid','email')
                ->where('project_id', $project_id)
                ->where('role_project', 'Member')
                ->get();

            $data_users = json_decode($data_users);
            return response()->json($data_users);
        }
    }


    function delete(Request $request)
    {
        header('Access-Control-Allow-Headers: origin, x-requested-with, accept');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Expose-Headers: X-Mashery-Error-Code, X-Mashery-Responder');
        header('Access-Control-Max-Age: 3628800');
        //echo '123';
        //return $request->post();
        $rules = [
			'project_id' => 'required',
			'uid' => 'required',
		];
        
        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails())
        {
            // The given data did not pass validation
            return response()->json(['response'=>'Error']);
        } else {
            $project_id = $request->project_id;
            $uid = $request->uid;
            $data_users = DB::table('teammembers')
                ->where('project_id', $project_id)
                ->where('uid', $uid)
                ->delete();

            return response()->json(['response'=>'Success']);
        }
    }
}
