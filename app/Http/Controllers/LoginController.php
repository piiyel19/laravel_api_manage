<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Foundation\Auth\AuthenticatesUsers;


use DB;
use App\Login;

use App\User;


class LoginController extends Controller
{
    use AuthenticatesUsers;
    
    function create(Request $request)
    {
        header('Access-Control-Allow-Headers: origin, x-requested-with, accept');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Expose-Headers: X-Mashery-Error-Code, X-Mashery-Responder');
        header('Access-Control-Max-Age: 3628800');

        $rules = [
			'email' => 'required|string|email|max:255',
			'password' => 'required|string|min:8|max:255'
		];

        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails())
        {
            return response()->json(['response'=>'Error']);
        } else {

            $email = $request->email;
            $password = $request->password;
            //$password = Hash::check($password);
            
            $fieldType = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'password';
             if(auth()->attempt(array($fieldType => $email, 'password' => $password)))
            {
                
                $users = DB::table('users')
                ->select('name','uid')
                ->where('email','=',$email)
                ->where('uid','!=','')
                ->get();


                if($users=='[]'){
                    return response()->json(['response'=>'False']);
                } else {
                    $users = json_decode($users);
                    return response()->json($users);
                }
              
            } else {
                return response()->json(['response'=>'Not_Valid']);
            }
        }
    }


    function activation(Request $request, $id)
    {
        if(!empty($id)){
            //check id 
            $user = User::where('uid', '=', $id)->first();
            if ($user === null) {
                return redirect('/login')->with(['error' => 'Invalid activation information !']);
            } else {
                DB::table('users')
                ->where('uid', $id)
                ->limit(1)  // optional - to ensure only one record is updated.
                ->update(array('status_id' => 1
                ));  // update the record in the DB. 
                
                $request->session()->flash('status', 'Task was successful!');
                return redirect('/login')->with(['success' => 'Your account has been activated !']);
            }
        } else {
            echo 'No Data';
        }
    }


    function test()
    {
        return view('test');
    }
}
