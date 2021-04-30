<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use DB;
use App\Calendar;

class CalendarController extends Controller
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
			'uid' => 'required'
		];
        
        $validator = Validator::make($request->all(),$rules);

        #dd($validator);


        if ($validator->fails())
        {
            // The given data did not pass validation
            return response()->json(['response'=>'Error']);
        } else {
            
            //return $request;

            $topic = $request->topic;
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $project_id = $request->project_id;
            $uid = $request->uid;
            $id = $request->id;
            $sd = $request->sd;
            $st = $request->st;

            $user = DB::table('calendars')->where('id', $id)->first();
            if(empty($user)){

                $project = new Calendar;
                $project->topic = $request->topic;
                $project->start_date = $request->start_date;
                $project->end_date = $request->end_date;
                $project->project_id = $request->project_id;
                $project->uid = $request->uid;
                $project->sd = $request->sd;
                $project->st = $request->st;
                $project->save();

            } else {    

                DB::update('update calendars set 
                topic = ?,
                start_date=?,
                end_date=? ,
                sd=? ,
                st=? 
                where id=? AND uid=? AND project_id=?',[$topic,$start_date,$end_date,$sd,$st,$id,$uid,$project_id]);

                //return $sd;
            }

            

            return response()->json(['response'=>'Success']);
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
			'end_date' => 'required|string|min:3|max:255',
			'project_id' => 'required|string|min:3|max:255',
			'id' => 'required',
			'uid' => 'required|string|string|max:255'
		];
        
        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails())
        {
            return response()->json(['response'=>'Error']);
        } else {

            $topic = $request->topic;
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $project_id = $request->project_id;
            $uid = $request->uid;
            $id = $request->id;

            $user = DB::table('calendars')->where('id', $id)->first();
            if(empty($user)){

            } else {    

                DB::update('update calendars set 
                topic = ?,
                start_date=?,
                end_date=? 
                where id=? AND uid=? AND project_id=?',[$topic,$start_date,$end_date,$id,$uid,$project_id]);

            }

        

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
   
            $users = DB::table('calendars')
            ->select('*')
            ->where('project_id','=',$project_id)
            ->where('achieve','=',0)
            ->where('uid','=',$uid)
            ->orderBy('id','desc')
            ->get();

            $users = json_decode($users);


            return response()->json($users);

        }
    }



    function archieve(Request $request)
    {
        header('Access-Control-Allow-Headers: origin, x-requested-with, accept');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Expose-Headers: X-Mashery-Error-Code, X-Mashery-Responder');
        header('Access-Control-Max-Age: 3628800');
        //echo '123';
        //return $request->post();
        $rules = [
			'project_id' => 'required|string|min:3|max:255',
			'id' => 'required',
			'uid' => 'required|string|string|max:255'
		];
        
        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails())
        {
            return response()->json(['response'=>'Error']);
        } else {

            $project_id = $request->project_id;
            $uid = $request->uid;
            $id = $request->id;

            $user = DB::table('calendars')->where('id', $id)->first();
            if(empty($user)){

            } else {    

                DB::update('update calendars set 
                achieve = ?
                where id=? AND uid=? AND project_id=?',['1',$id,$uid,$project_id]);

            }

        

            return response()->json(['response'=>'Success']);
        }
    }


    function all_calendar(Request $request)
    {
        header('Access-Control-Allow-Headers: origin, x-requested-with, accept');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Expose-Headers: X-Mashery-Error-Code, X-Mashery-Responder');
        header('Access-Control-Max-Age: 3628800');

        $rules = [
			'uid' => 'required'
		];
        
        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails())
        {
            // The given data did not pass validation
            return response()->json(['response'=>'Error']);
        } else {

            $uid = $request->uid;
   
            $users = DB::table('calendars')
            ->join('projects', 'calendars.project_id', '=', 'projects.project_id')
            ->select(DB::raw('CONCAT(projects.title, \' - \', calendars.topic) as title'),'calendars.sd as start','calendars.st as end')
            ->where('calendars.achieve','=',0)
            ->where('calendars.uid','=',$uid)
            ->get();

            

            $users = json_decode($users);


            return response()->json($users);

        }
    }


    function data_calendar(Request $request)
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
   
            $users = DB::table('calendars')
            ->select('topic as title','sd as start','st as end')
            ->where('achieve','=',0)
            ->where('uid','=',$uid)
            ->where('project_id','=',$project_id)
            ->get();

            $users = json_decode($users);


            return response()->json($users);

        }
    }
}
