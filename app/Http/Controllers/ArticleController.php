<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use DB;
use App\Article;


class ArticleController extends Controller
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
			'category' => 'required',
			'project_id' => 'required',
			'uid' => 'required',
			'article' => 'required'
		];
        
        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails())
        {
            return response()->json(['response'=>'Error']);
        } else {

            $topic = $request->topic;
            $category = $request->category;
            $project_id = $request->project_id;
            $uid = $request->uid;
            $article = $request->article;
            $article_id = $request->article_id;
            if(empty($article_id)){
                $article_id = rand();
            } 
            

            $user = DB::table('articles')->where('article_id', $article_id)->first();
            if(empty($user)){

                date_default_timezone_set("Asia/Kuala_Lumpur");
                $created_at = date('Y-m-d');

                DB::table('articles')->insert(
                    array(
                           'topic'     =>   $topic, 
                           'category'   =>   $category, 
                           'project_id'   =>   $project_id, 
                           'uid'   =>   $uid, 
                           'article'   =>   $article, 
                           'article_id'   =>   $article_id,
                           'created_at' => $created_at
                    )
               );

            } else {    

                date_default_timezone_set("Asia/Kuala_Lumpur");
                $created_at = date('Y-m-d');
                DB::update('update articles set topic = ?,category=?,article=?,created_at=? where article_id=?',[$topic,$category,$article,$created_at,$article_id]);

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
   
            $users = DB::table('articles')
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

    function details_view(Request $request)
    {
        header('Access-Control-Allow-Headers: origin, x-requested-with, accept');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Expose-Headers: X-Mashery-Error-Code, X-Mashery-Responder');
        header('Access-Control-Max-Age: 3628800');

        $rules = [
			'article_id' => 'required',
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
            $article_id = $request->article_id;
   
            $users = DB::table('articles')
            ->select('*')
            ->where('project_id','=',$project_id)
            ->where('uid','=',$uid)
            ->where('article_id','=',$article_id)
            ->limit(1)
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
			'project_id' => 'required',
			'article_id' => 'required',
			'uid' => 'required'
		];
        
        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails())
        {
            return response()->json(['response'=>'Error']);
        } else {

            $project_id = $request->project_id;
            $uid = $request->uid;
            $article_id = $request->article_id;
            

            $user = DB::table('articles')->where('article_id', $article_id)->first();
            if(empty($user)){

            } else {    

                DB::update('update articles set achieve = ? where article_id=?',[1,$article_id]);

            }

        

            return response()->json(['response'=>'Success']);
        }
    }


    function category_count(Request $request)
    {
        header('Access-Control-Allow-Headers: origin, x-requested-with, accept');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Expose-Headers: X-Mashery-Error-Code, X-Mashery-Responder');
        header('Access-Control-Max-Age: 3628800');

        $rules = [
			'project_id' => 'required|string|string|max:255',
			'uid' => 'required|string|string|max:255'
		];
        
        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails())
        {
            // The given data did not pass validation
            return response()->json(['response'=>'Error']);
        } else {

            $project_id = $request->project_id;
            $uid = $request->uid;
   
            $users = DB::table('articles')
            ->select('category', DB::raw('count(*) as total'))
            ->where('project_id','=',$project_id)
            ->where('uid','=',$uid)
            ->where('achieve','=','0')
            ->groupBy('category')
            ->get();

            $users = json_decode($users);


            return response()->json($users);

        }
    }


    function category_view(Request $request)
    {
        header('Access-Control-Allow-Headers: origin, x-requested-with, accept');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Expose-Headers: X-Mashery-Error-Code, X-Mashery-Responder');
        header('Access-Control-Max-Age: 3628800');

        $rules = [
			'project_id' => 'required|string|string|max:255',
			'uid' => 'required|string|string|max:255'
		];
        
        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails())
        {
            // The given data did not pass validation
            return response()->json(['response'=>'Error']);
        } else {

            $project_id = $request->project_id;
            $uid = $request->uid;
   
            $users = DB::table('articles')
            ->select('category')
            ->where('project_id','=',$project_id)
            ->where('uid','=',$uid)
            ->where('achieve','=','0')
            ->groupBy('category')
            ->get();

            $users = json_decode($users);


            return response()->json($users);

        }
    }
}
