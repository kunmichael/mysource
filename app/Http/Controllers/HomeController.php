<?php 
namespace App\Http\Controllers;

use Validator, Input, Redirect, Session, View, Auth; 

class HomeController extends Controller {

	public function __construct()
	{
		$this->middleware('guest');
	}

	public function index()
	{
		//check apakah ada session mengenai data user
		if(Session::has('user_login_data')){
			$header_jadwal_object = new \App\Model\Header_jadwal();
			$data = array(
							'jadwals'	=> $header_jadwal_object::where('Laporan_selesai','=',0)->orderBy('Tanggal_jadwal', 'desc')->get(),
						);
			return View::make('pages.home',$data);
		}
		else{
			Session::put('error_login', "You must login !");
			return Redirect::to("login");
		}
		
	}
}
