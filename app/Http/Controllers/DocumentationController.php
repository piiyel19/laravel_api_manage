<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use DB;
use App\Documentation;

class DocumentationController extends Controller
{
    //
    function create(Request $request)
    {
        

        header('Access-Control-Allow-Headers: origin, x-requested-with, accept');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Expose-Headers: X-Mashery-Error-Code, X-Mashery-Responder');
        header('Access-Control-Max-Age: 3628800');

        ini_set('upload_max_filesize', '500M');
        ini_set("max_execution_time", "-1");
        ini_set("memory_limit", "-1");
        ignore_user_abort(true);
        set_time_limit(0);
        

        $rules  = [
            "file" => "required|mimes:pdf|max:10000 ",
            'project_id' => 'required',
			'topic' => 'required',
			'category' => 'required',
			'uid' => 'required'
        ];

        

        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails())
        {
            // The given data did not pass validation
            return response()->json(['response'=>'Error']);
            //return $validator->errors()->first('name');
            //return dd($validator->fails());
        } else {

            #$data = $_FILES['file']['error'];
            $file = $request->file('file');
            $filename = time() . '.' . $request->file('file')->extension();
            $filePath = public_path() . '/files/uploads/';
            $file->move($filePath, $filename);
            $file_user = 'http://188.166.187.2:8082/files/uploads/'.$filename;

            $project_id = $request->project_id;
            $topic = $request->topic;
            $category = $request->category;
            $uid = $request->uid;

            $project = new Documentation;
            $project->topic = $topic;
            $project->project_id = $project_id;
            $project->category = $category;
            $project->uid = $uid;
            $project->file = $file_user;
            $project->save();
            
            return response()->json(['response'=>'Success']);

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
			'project_id' => 'required',
			'uid' => 'required',
			'id' => 'required'
		];
        
        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails())
        {
            return response()->json(['response'=>'Error']);
        } else {

            $id = $request->id;
            $project_id = $request->project_id;
            $uid = $request->uid;


            $user = DB::table('documentations')->where('id', $id)->first();
            if(empty($user)){

            } else {    
                DB::update('update documentations set achieve = ? where id=?',[1,$id]);
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


            $users = DB::table('documentations')
            ->select('*')
            ->where('project_id','=',$project_id)
            ->where('uid','=',$uid)
            ->where('achieve','=','0')
            ->get();

            $users = json_decode($users);


            return response()->json($users);
        
        }
    }
}
