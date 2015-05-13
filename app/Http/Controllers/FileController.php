<?php 
namespace App\Http\Controllers;

use Validator, Input, Redirect, Session, View, Auth; 

class FileController extends Controller {

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
	
	public function pdf_list_view(){
		$file_object = new \App\Model\File();
		$file_pdf = $file_object::where('File_type', '=', "pdf")->get();
		$data = array(
						'pdfs' => $file_pdf,
					);
		return View::make('pages.pdf_view',$data);
	}
	
	public function view_detail_pdf($id){
		$file_object = new \App\Model\File();
		$file_pdf = $file_object::where('File_ID', '=', $id)->first();
		$data = array(
						'pdfs' => $file_pdf,
					);
		return View::make('pages.detail_pdf',$data);
	}
	
	public function image_list_view(){
		$file_object = new \App\Model\File();
		$file_image = $file_object::where('File_type', '=', "image")->get();
		$data = array(
						'images' => $file_image,
					);
		return View::make('pages.image_view',$data);
	}
	
	
}
