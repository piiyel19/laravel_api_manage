<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use DB;
use App\Register;

use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
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
			'name' => 'required',
			'email' => 'required|string|email|max:255|unique:users',
			'password' => 'required'
		];
        
        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails())
        {
            return response()->json(['response'=>'Error']);
        } else {

            $name = $request->name;
            $email = $request->email;
            $password = $request->password;


            $user = DB::table('users')->where('email', $email)->first();
            if(empty($user)){


                $uid = 'AP'.rand();
                $this->send_email($request,$uid);

                DB::table('users')->insert(
                    array(
                           'name'     =>   $name, 
                           'email'   =>   $email, 
                           'password'   =>   Hash::make($password), 
                           'role'   => '3',
                           'status_id'  => '1',
                           'uid' => $uid
                    )
               );

               return response()->json(['response'=>'Success']);

            } else {    

                //DB::update('update users set name = ? where email=?',[$name,$email]);

                return response()->json(['response'=>'Failed']);
            }

        
        }
    }

    function send_email($data,$uid)
    {
        Mail::to("sufianmohdhassan19@gmail.com")->send(new WelcomeEmail($data,$uid));
    }

    function forgot_password(Request $request)
    {

    }
}
