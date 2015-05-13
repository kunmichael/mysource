<?php 
namespace App\Http\Controllers;

use Validator, Input, Redirect, Session, View, Auth, Excel, Str;
use Carbon\Carbon; 

class LoginController extends Controller {

	public function __construct()
	{
		$this->middleware('guest');
	}

	public function index()
	{
		if(Session::has('user_login_data')){
			return Redirect::to("home");
		}
		else{
			return view('login');
		}
	}
	
	public function login()
	{
		//set validation
		$validator = Validator::make(
		Input::all(),
		array(
		    "username_text"	=> "required|min:3",
		    "password_text"	=> "required|min:3",
		)
		);
		
		if($validator->passes())
		{			
			//create object karyawan
			$karyawan = new \App\Model\Karyawan();
			$user_login = $karyawan::where('Username', '=', Input::get('username_text'))->where('Password', '=', md5(Input::get('password_text')))->get();
			
			if(!$user_login->isEmpty()){
				//menyimpan data login ke dalam session
				Session::put('user_login_data', $user_login->first());
				return Redirect::to("home");
			}
			else{
				Session::put('error_login', "Wrong Username or Password !");
				return Redirect::to('login')->withErrors($validator)->withInput();
			}
		}
		else
		{
			return Redirect::to('login')->withErrors($validator)->withInput();
		}
	}
	
	public function signout(){
		Session::flush();
		return Redirect::to('login');
	}
}
