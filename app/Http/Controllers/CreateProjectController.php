<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use DB;
use App\Project;
use App\Teammember;

class CreateProjectController extends Controller
{
    public function index()
    {
        //return view('home');
        return '';
    }
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
			'title' => 'required',
			'uid' => 'required'
		];
        
        $validator = Validator::make($request->all(),$rules);

        #dd($validator);


        if ($validator->fails())
        {
            // The given data did not pass validation
            return response()->json(['response'=>'Error']);
        } else {

            $project_id = rand();
            $project = new Project;
            $project->title = $request->title;
            $project->project_id = $project_id;
            $project->uid = $request->uid;
            $project->save();
            

            //search email 
            $users = DB::table('users')
            ->select('email')
            ->where('uid','=',$request->uid)
            ->get();

            $email = '';
            foreach($users as $view) {
                $email = $view->email;
            }
            

            if(!empty($email)){
                $team = new Teammember;
                $team->project_id = $project_id;
                $team->uid = $request->uid;
                $team->email = $email;
                $team->role_project = 'Master';
                $team->save();
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


        $rules = [
			'title' => 'required|string|min:3|max:255',
			'project_id' => 'required|string|min:3|max:255',
			'uid' => 'required|string|string|max:255'
		];
        
        $validator = Validator::make($request->all(),$rules);

        #dd($validator);


        if ($validator->fails())
        {
            // The given data did not pass validation
            return response()->json(['response'=>'Error']);
        } else {

            $title = $request->title;
            $project_id = $request->project_id;
            $uid = $request->uid;   

            // $project = Project::find('project_id',$project_id);
            // $project->title = $title;
            // $project->save();


            DB::update('update projects set title = ? where project_id = ?',[$title,$project_id]);

            // dd($request);
            


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
			'uid' => 'required|string|string|max:255',
		];


        $validator = Validator::make($request->all(),$rules);

        #dd($validator);


        if ($validator->fails())
        {
            // The given data did not pass validation
            return response()->json(['response'=>'Error']);
        } else {
            $uid = $request->uid;
            $users = DB::table('projects')
                ->join('teammembers', 'projects.project_id', '=', 'teammembers.project_id')
                ->select('projects.id','projects.project_id','projects.title','projects.uid','projects.created_at','teammembers.role_project')
                ->where('teammembers.uid', $uid)
                ->where('projects.achieve', 0)
                ->get();

            $users = json_decode($users);
            return response()->json($users);
        }
    }
}
