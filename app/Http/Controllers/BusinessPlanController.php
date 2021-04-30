<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use DB;
use App\BusinessPlan;



class BusinessPlanController extends Controller
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
			'topic' => 'required',
			'start_date' => 'required',
			'end_date' => 'required',
			'project_id' => 'required',
			'uid' => 'required',
			'type' => 'required'
		];
        
        $validator = Validator::make($request->all(),$rules);

        #dd($validator);


        if ($validator->fails())
        {
            // The given data did not pass validation
            return response()->json(['response'=>'Error']);
        } else {

            $bp = new BusinessPlan;
            $bp->topic = $request->topic;
            $bp->start_date = $request->start_date;
            $bp->end_date = $request->end_date;
            $bp->topic_pid = rand();
            $bp->project_id = $request->project_id;
            $bp->uid = $request->uid;
            $bp->type = $request->type;
            $bp->save();

            return response()->json(['response'=>'Success']);
        }
    }


    function view(Request $request)
    {
        header('Access-Control-Allow-Headers: origin, x-requested-with, accept');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Expose-Headers: X-Mashery-Error-Code, X-Mashery-Responder');
        header('Access-Control-Max-Age: 3628800');

        $rules = [
			'project_id' => 'required',
			'uid' => 'required'
		];
        
        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails())
        {
            // The given data did not pass validation
            return response()->json(['response'=>'Error']);
        } else {

            $project_id = $request->project_id;
            $uid = $request->uid;
   
            $users = DB::table('business_plans')
            ->select('*')
            ->where('project_id','=',$project_id)
            ->where('uid','=',$uid)
            ->get();

            $users = json_decode($users);


            return response()->json($users);

        }

    }


    function update(Request $request)
    {
        header('Access-Control-Allow-Headers: origin, x-requested-with, accept');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Expose-Headers: X-Mashery-Error-Code, X-Mashery-Responder');
        header('Access-Control-Max-Age: 3628800');
        //echo '123';
        //return $request->post();
        $rules = [
			'topic' => 'required|string|min:3|max:255',
			'start_date' => 'required|string|min:3|max:255',
			'end_date' => 'required|string|string|max:255',
			'topic_pid' => 'required|string|string|max:255',
			'project_id' => 'required|string|string|max:255',
			'uid' => 'required|string|string|max:255',
			'type' => 'required|string|string|max:255'
		];
        
        $validator = Validator::make($request->all(),$rules);

        #dd($validator);


        if ($validator->fails())
        {
            // The given data did not pass validation
            return response()->json(['response'=>'Error']);
        } else {

            $topic = $request->topic;
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $topic_pid = $request->topic_pid;
            $project_id = $request->project_id;
            $uid = $request->uid;
            $type = $request->type;


            DB::table('business_plans')
            ->where('topic_pid', $topic_pid)
            ->where('project_id', $project_id)  // find your user by their email
            ->limit(1)  // optional - to ensure only one record is updated.
            ->update(array('topic' => $topic,'start_date' => $start_date,
            'end_date' => $end_date,'type' => $type
            ));  // update the record in the DB. 

            return response()->json(['response'=>'Success']);
        }



    }

    function delete(Request $request)
    {
        header('Access-Control-Allow-Headers: origin, x-requested-with, accept');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Expose-Headers: X-Mashery-Error-Code, X-Mashery-Responder');
        header('Access-Control-Max-Age: 3628800');

        $rules = [
			'topic_pid' => 'required|string|string|max:255',
			'project_id' => 'required|string|string|max:255',
			'uid' => 'required|string|string|max:255'
		];
        
        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails())
        {
            // The given data did not pass validation
            return response()->json(['response'=>'Error']);
        } else {
            $topic_pid = $request->topic_pid;
            $project_id = $request->project_id;
            $uid = $request->uid;

            $deletedRows = BusinessPlan::
            where('topic_pid', $topic_pid)
            ->where('project_id', $project_id)
            ->where('uid', $uid)
            ->delete();

            return response()->json(['response'=>'Success']);
        }
    }
}
