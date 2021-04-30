<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use DB;
use App\ToDo;

class ToDoController extends Controller
{
    //
    function master_create(Request $request)
    {
        header('Access-Control-Allow-Headers: origin, x-requested-with, accept');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Expose-Headers: X-Mashery-Error-Code, X-Mashery-Responder');
        header('Access-Control-Max-Age: 3628800');
        //echo '123';
        //return $request->post();
        $rules = [
			'title' => 'required',
			'about' => 'required',
			'project_id' => 'required',
			'uid' => 'required'
		];
        
        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails())
        {
            return response()->json(['response'=>'Error']);
        } else {

            $title = $request->title;
            $about = $request->about;
            $project_id = $request->project_id;
            $uid = $request->uid;
            $todo_pid = $request->todo_pid;
            if(empty($todo_pid)){
                $todo_pid = 'AP'.rand();
            }


            $user = DB::table('todos_masters')->where('todo_pid', $todo_pid)->first();
            if(empty($user)){


                DB::table('todos_masters')->insert(
                    array(
                           'title'     =>   $title, 
                           'about'   =>   $about, 
                           'project_id'   =>   $project_id, 
                           'uid'   =>   $uid, 
                           'todo_pid'   =>   $todo_pid
                    )
               );

            } else {    

                DB::update('update todos_masters set title = ?,about=? where todo_pid=?',[$title,$about,$todo_pid]);

            }

        

            return response()->json(['response'=>'Success']);
        }
    }


    // ui setup 
    function ui_create(Request $request)
    {
        header('Access-Control-Allow-Headers: origin, x-requested-with, accept');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Expose-Headers: X-Mashery-Error-Code, X-Mashery-Responder');
        header('Access-Control-Max-Age: 3628800');
        //echo '123';
        //return $request->post();
        $rules = [
			'ui_code' => 'required',
			'todo_pid' => 'required'
		];
        
        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails())
        {
            return response()->json(['response'=>'Error']);
        } else {

            $ui_code = $request->ui_code;
            $todo_pid = $request->todo_pid;


            $user = DB::table('todos_uis')->where('todo_pid', $todo_pid)->first();
            if(empty($user)){


                DB::table('todos_uis')->insert(
                    array(
                           'ui_code'   =>   $ui_code, 
                           'todo_pid'   =>   $todo_pid
                    )
               );

            } else {    

                DB::update('update todos_uis set ui_code = ? where todo_pid=?',[$ui_code,$todo_pid]);

            }

        

            return response()->json(['response'=>'Success']);
        }
    }


    function ui_view(Request $request)
    {
        header('Access-Control-Allow-Headers: origin, x-requested-with, accept');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Expose-Headers: X-Mashery-Error-Code, X-Mashery-Responder');
        header('Access-Control-Max-Age: 3628800');
        //echo '123';
        //return $request->post();
        $rules = [
			'todo_pid' => 'required'
		];
        
        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails())
        {
            return response()->json(['response'=>'Error']);
        } else {

            $todo_pid = $request->todo_pid;


            $users = DB::table('todos_uis')
            ->select('*')
            ->where('todo_pid','=',$todo_pid)
            ->get();

            $users = json_decode($users);


            return response()->json($users);
        
        }
    }



    function master_archieve(Request $request)
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
			'todo_pid' => 'required'
		];
        
        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails())
        {
            return response()->json(['response'=>'Error']);
        } else {

            $project_id = $request->project_id;
            $uid = $request->uid;
            $todo_pid = $request->todo_pid;


            $user = DB::table('todos_masters')->where('todo_pid', $todo_pid)->first();
            if(empty($user)){

            } else {    
                DB::update('update todos_masters set achieve = ? where todo_pid=?',['1',$todo_pid]);
            }

        

            return response()->json(['response'=>'Success']);
        }
    }


    function master_view(Request $request)
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
			'uid' => 'required|string|min:3|max:255'
		];
        
        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails())
        {
            return response()->json(['response'=>'Error']);
        } else {

            $project_id = $request->project_id;
            $uid = $request->uid;


            $users = DB::table('todos_masters')
            ->select('*')
            ->where('project_id','=',$project_id)
            ->where('uid','=',$uid)
            ->where('achieve','=','0')
            ->get();

            $users = json_decode($users);


            return response()->json($users);
        
        }
    }


    function master_details(Request $request)
    {
        header('Access-Control-Allow-Headers: origin, x-requested-with, accept');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Expose-Headers: X-Mashery-Error-Code, X-Mashery-Responder');
        header('Access-Control-Max-Age: 3628800');
        //echo '123';
        //return $request->post();
        $rules = [
			'todo_pid' => 'required|string|min:3|max:255',
			'project_id' => 'required|string|min:3|max:255',
			'uid' => 'required|string|min:3|max:255'
		];
        
        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails())
        {
            return response()->json(['response'=>'Error']);
        } else {

            $project_id = $request->project_id;
            $uid = $request->uid;
            $todo_pid = $request->todo_pid;


            $users = DB::table('todos_masters')
            ->select('*')
            ->where('project_id','=',$project_id)
            ->where('uid','=',$uid)
            ->where('todo_pid','=',$todo_pid)
            ->limit(1)
            ->get();

            $users = json_decode($users);


            return response()->json($users);
        
        }
    }



    function child_create(Request $request)
    {
        header('Access-Control-Allow-Headers: origin, x-requested-with, accept');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Expose-Headers: X-Mashery-Error-Code, X-Mashery-Responder');
        header('Access-Control-Max-Age: 3628800');
        //echo '123';
        //return $request->post();
        $rules = [
			'subject' => 'required',
			'project_id' => 'required',
			'uid' => 'required',
			'todo_pid' => 'required'
		];
        
        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails())
        {
            return response()->json(['response'=>'Error']);
        } else {

            $project_id = $request->project_id;
            $uid = $request->uid;
            $todo_pid = $request->todo_pid;
            $subject = $request->subject;
            $cid = rand();

            //return $cid;

            DB::table('todos_childs')->insert(
                array(
                       'project_id' => $project_id,
                       'uid'   =>   $uid, 
                       'todo_pid'   =>   $todo_pid,
                       'subject' => $subject,
                       'cid' => $cid
                )
           );
        

            return response()->json(['response'=>'Success']);
        }
    }


    function child_view(Request $request)
    {
        header('Access-Control-Allow-Headers: origin, x-requested-with, accept');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Expose-Headers: X-Mashery-Error-Code, X-Mashery-Responder');
        header('Access-Control-Max-Age: 3628800');
        //echo '123';
        //return $request->post();
        $rules = [
			'todo_pid' => 'required',
			'project_id' => 'required',
			'uid' => 'required'
		];
        
        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails())
        {
            return response()->json(['response'=>'Error']);
        } else {

            $project_id = $request->project_id;
            $uid = $request->uid;
            $todo_pid = $request->todo_pid;


            $users = DB::table('todos_childs')
            ->select('*')
            ->where('project_id','=',$project_id)
            ->where('uid','=',$uid)
            ->where('todo_pid','=',$todo_pid)
            ->where('status','=',0)
            ->get();

            $users = json_decode($users);


            return response()->json($users);
        
        }
    }



    function child_archieve(Request $request)
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
			'todo_pid' => 'required',
			'cid' => 'required',
		];
        
        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails())
        {
            return response()->json(['response'=>'Error']);
        } else {

            $cid = $request->cid;
            $project_id = $request->project_id;
            $uid = $request->uid;
            $todo_pid = $request->todo_pid;


            $user = DB::table('todos_childs')->where('cid', $cid)->first();
            if(empty($user)){

            } else {    
                DB::update('update todos_childs set status = ? where cid=?',['1',$cid]);
            }

        

            return response()->json(['response'=>'Success']);
        }
    }

    
}
