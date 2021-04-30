<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Mail\AppkuEmail;
use Illuminate\Support\Facades\Mail;

class AppkuEmailController extends Controller
{
    //
    public function index(){
 
		Mail::to("sufianmohdhassan19@gmail.com")->send(new AppkuEmail());
 
		return "Email telah dikirim";
 
	}
}
