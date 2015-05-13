<?php 
namespace App\Http\Controllers;

use Validator, Input, Redirect, Session, View, Auth, File; 

class TrainningController extends Controller {

	public function __construct()
	{
		$this->middleware('guest');
	}

	public function index()
	{
		//check apakah ada session mengenai data user
		if(Session::has('user_login_data')){
			$header_report_trainning_object = new \App\Model\Header_report_trainning();
			$data = array(
							'all_trainnings' => $header_report_trainning_object::orderBy('Tanggal_training', 'desc')->get(),
							'count_all_trainnings' => $header_report_trainning_object::orderBy('Tanggal_training', 'desc')->count(),
							'approve_trainnings' => $header_report_trainning_object->approve()->get(),
							'count_approve_trainnings' => $header_report_trainning_object->approve()->count(),
							'need_approval_trainnings' => $header_report_trainning_object->need_approval()->get(),
							'count_need_approval_trainnings' => $header_report_trainning_object->need_approval()->count(),
						);
			return View::make('pages.trainning',$data);
		}
		else{
			Session::put('error_login', "You must login !");
			return Redirect::to("login");
		}
		
	}
	
	public function add_trainning_report(){
		//set validation
		$validator = Validator::make(
		Input::all(),
		array(
		    "Subject_text"			=> "required|min:3",
		    "Location_text"			=> "required|min:3",
		    "Trainning_date"		=> "required|min:10|max:10",
		    "Start_time"			=> "required|min:5:max:5",
		    "End_time"				=> "required|min:5:max:5",
		    "Trainning_result_text"	=> "required|min:5",
		)
		);
		
		$input = Input::all();
		$nama_teknisi = "";
		if($validator->passes())
		{
			//check checkbox daftar karyawan
			for($i=1;$i<$input['no'];$i++){
				if(isset($input["karyawan_id$i"])){
					$nama_teknisi .= $input["karyawan_id$i"].", ";
				}
			}
			
			$header_report_trainning_object = new \App\Model\Header_report_trainning();
			$header_report_trainning_object->Karyawan_ID = $input['Karyawan_ID'];
			$header_report_trainning_object->Subject = $input['Subject_text'];
			$header_report_trainning_object->Lokasi = $input['Location_text'];
			$header_report_trainning_object->Tanggal_training = $input['Trainning_date'];
			$header_report_trainning_object->Waktu_mulai = $input['Start_time'];
			$header_report_trainning_object->Waktu_selesai = $input['End_time'];
			$header_report_trainning_object->Hasil_training = $input['Trainning_result_text'];
			$header_report_trainning_object->Nama_teknisi = $nama_teknisi;
			$header_report_trainning_object->Status_training = 1;
			$header_report_trainning_object->Approval = 0;
			$header_report_trainning_object->save();
			$Report_training_ID = $header_report_trainning_object->Report_training_ID;
			
			$header_jadwal_object = new \App\Model\Header_jadwal();
			$my_schedule = $header_jadwal_object::find($input['Jadwal_ID']);
			$my_schedule->Laporan_selesai = 1;
			$my_schedule->ID_laporan = $Report_training_ID;
			$my_schedule->save();
			
			Session::put('error_trainning', "Success add trainning report !");
			return Redirect::to('update_trainning_report/'.$Report_training_ID);
		}
		else{
			//check checkbox daftar karyawan
			for($i=1;$i<$input['no'];$i++){
				if(isset($input["karyawan_id$i"])){
					$data_checked[$i] = 1;
				}
				else{
					$data_checked[$i] = 0;
				}
			}
			Session::put('data_checked', $data_checked);
			Session::put('error_trainning', "Failed to insert trainning report !");
			return Redirect::to('trainning_report/'.$input['Jadwal_ID'])->withErrors($validator)->withInput();
		}
		
	}
	
	public function update_trainning_report(){
		//set validation
		$validator = Validator::make(
		Input::all(),
		array(
		    "Subject_text"			=> "required|min:3",
		    "Location_text"			=> "required|min:3",
		    "Trainning_date"		=> "required|min:10|max:10",
		    "Start_time"			=> "required|min:5:max:5",
		    "End_time"				=> "required|min:5:max:5",
		    "Trainning_result_text"	=> "required|min:5",
		)
		);
		
		$input = Input::all();
		$nama_teknisi = "";
		if($validator->passes())
		{
			//check checkbox daftar karyawan
			for($i=1;$i<$input['no'];$i++){
				if(isset($input["karyawan_id$i"])){
					$nama_teknisi .= $input["karyawan_id$i"].", ";
				}
			}
			
			$header_report_trainning_object = new \App\Model\Header_report_trainning();
			$update_report_trainning = $header_report_trainning_object::find($input['Report_trainning_ID']);
			$update_report_trainning->Subject = $input['Subject_text'];
			$update_report_trainning->Lokasi = $input['Location_text'];
			$update_report_trainning->Tanggal_training = $input['Trainning_date'];
			$update_report_trainning->Waktu_mulai = $input['Start_time'];
			$update_report_trainning->Waktu_selesai = $input['End_time'];
			$update_report_trainning->Hasil_training = $input['Trainning_result_text'];
			$update_report_trainning->Nama_teknisi = $nama_teknisi;
			$update_report_trainning->Status_training = 1;
			$update_report_trainning->save();
			
			Session::put('error_trainning', "Success update trainning report !");
			return Redirect::to('update_trainning_report/'.$input['Report_trainning_ID']);
		}
		else{
			Session::put('error_trainning', "Failed to update trainning report !");
			return Redirect::to('update_trainning_report/'.$input['Report_trainning_ID']);
		}
		
	}
	
	public function add_report_trainning_form($Jadwal_ID){
		//check apakah ada session mengenai data user
		if(Session::has('user_login_data')){
			if($Jadwal_ID == ""){
				Session::put('error_home', "You are not from schedule !");
				return Redirect::to("home");
			}
			else{
				$header_jadwal_object = new \App\Model\Header_jadwal();
				$karyawan_object = new \App\Model\Karyawan();
				$data = array(
					'jadwals' => $header_jadwal_object::find($Jadwal_ID),
					'karyawans' => $karyawan_object::all(),
				);
				return View::make('pages.add_report_trainning',$data);
			}
		}
		else{
			Session::put('error_login', "You must login !");
			return Redirect::to("login");
		}
	}
	
	public function update_report_trainning_form($Report_trainning_ID){
		//check apakah ada session mengenai data user
		if(Session::has('user_login_data')){
			if($Report_trainning_ID == ""){
				Session::put('error_home', "You dont have Report Trainning ID !");
				return Redirect::to("home");
			}
			else{
				$header_report_trainning_object = new \App\Model\Header_report_trainning();
				$karyawan_object = new \App\Model\Karyawan();
				$detail_report_trainning_object = new \App\Model\Detail_report_trainning();
				
				if(empty($header_report_trainning_object::find($Report_trainning_ID)->Report_training_ID)){
					Session::put('error_home', "Report Trainning ID not found!");
					return Redirect::to("home");
				}
				else{
					$data = array(
					'trainnings' => $header_report_trainning_object::find($Report_trainning_ID),
					'karyawans' => $karyawan_object::all(),
					'report_maker' => $karyawan_object::find($header_report_trainning_object::find($Report_trainning_ID)->Karyawan_ID)->Nama_karyawan,
					'details' => $detail_report_trainning_object::where('Report_training_ID','=',$Report_trainning_ID)->get(),
				);
					return View::make('pages.update_report_trainning',$data);
				}
				
			}
		}
		else{
			Session::put('error_login', "You must login !");
			return Redirect::to("login");
		}
	}
	
	public function detail_report_trainning_form($Report_trainning_ID){
		//check apakah ada session mengenai data user
		if(Session::has('user_login_data')){
			if($Report_trainning_ID == ""){
				Session::put('error_home', "You dont have Report Trainning ID !");
				return Redirect::to("home");
			}
			else{
				$header_report_trainning_object = new \App\Model\Header_report_trainning();
				$karyawan_object = new \App\Model\Karyawan();
				$detail_report_trainning_object = new \App\Model\Detail_report_trainning();
				
				if(empty($header_report_trainning_object::find($Report_trainning_ID)->Karyawan_ID)){
					Session::put('error_home', "Report Trainning ID not found!");
					return Redirect::to("home");
				}
				else{
					$data = array(
					'trainnings' => $header_report_trainning_object::find($Report_trainning_ID),
					'karyawans' => $karyawan_object::all(),
					'report_maker' => $karyawan_object::find($header_report_trainning_object::find($Report_trainning_ID)->Karyawan_ID)->Nama_karyawan,
					'details' => $detail_report_trainning_object::where('Report_training_ID','=',$Report_trainning_ID)->get(),
				);
					return View::make('pages.detail_report_trainning',$data);
				}
				
			}
		}
		else{
			Session::put('error_login', "You must login !");
			return Redirect::to("login");
		}
	}
	
	public function delete_report_trainning($Report_trainning_ID){
		//check apakah ada session mengenai data user
		if(Session::has('user_login_data')){
			if($Report_trainning_ID == ""){
				Session::put('error_home', "You dont have Report Trainning ID !");
				return Redirect::to("home");
			}
			else{
				$header_report_trainning_object = new \App\Model\Header_report_trainning();
				$detail_report_trainning_object = new \App\Model\Detail_report_trainning();
				$trainning_image_object = new \App\Model\Trainning_image();
				
				if(empty($header_report_trainning_object::find($Report_trainning_ID)->Karyawan_ID)){
					Session::put('error_home', "Report Trainning ID not found!");
					return Redirect::to("home");
				}
				else{
					//untuk menghapus gambar yang ada
					$delete_detail = $detail_report_trainning_object::where('Report_training_ID','=',$Report_trainning_ID)->get();
					$jumlah_data=0;
					$temp_id;
					foreach($delete_detail as $row){
						$delete_image = $trainning_image_object::find($row->Training_image_ID);
						$location = '/home/miland/public_html/asset/images/project/'.$delete_image->Nama_gambar_training; 
						File::delete($location);
						$temp_id[$jumlah_data] = $row->Training_image_ID;
						$jumlah_data++;
					}
					
					$delete_detail = $detail_report_trainning_object::where('Report_training_ID','=',$Report_trainning_ID);
					$delete_detail->delete();
					
					foreach($temp_id as $row){
						$delete_image = $trainning_image_object::find($row);
						$delete_image->delete();
					}
					
					$delete_header = $header_report_trainning_object::where('Report_training_ID','=',$Report_trainning_ID);
					$delete_header->delete();
					
					Session::put('error_trainning', "Success delete trainning report !");
					return Redirect::to("trainning");
				}
				
			}
		}
		else{
			Session::put('error_login', "You must login !");
			return Redirect::to("login");
		}
	}
	
	public function approve_report_trainning($Report_trainning_ID){
		//check apakah ada session mengenai data user
		if(Session::has('user_login_data')){
			if($Report_trainning_ID == ""){
				Session::put('error_home', "You dont have Report Trainning ID !");
				return Redirect::to("home");
			}
			else{
				$header_report_trainning_object = new \App\Model\Header_report_trainning();
				
				if(empty($header_report_trainning_object::find($Report_trainning_ID)->Karyawan_ID)){
					Session::put('error_home', "Report Trainning ID not found!");
					return Redirect::to("home");
				}
				else{
					$header_report_trainning = $header_report_trainning_object::find($Report_trainning_ID);
					$header_report_trainning->Approval = 1;
					$header_report_trainning->save();
					
					Session::put('error_trainning', "Success approve trainning report !");
					return Redirect::to("trainning");
				}
				
			}
		}
		else{
			Session::put('error_login', "You must login !");
			return Redirect::to("login");
		}
	}
	
	public function get_detail_member_report_trainning($Report_trainning_ID){
		if(Session::has('user_login_data')){
			if($Report_trainning_ID == ""){
				return "You don't report trainning ID";
			}
			else{
				$header_report_trainning_object = new \App\Model\Header_report_trainning();
				
				if(empty($header_report_trainning_object::find($Report_trainning_ID)->Karyawan_ID)){
					return "Report Trainning ID not found!";
				}
				else{
					$data = array(
										'header_report_trainning' => $header_report_trainning_object::find($Report_trainning_ID),
									);
					return View::make('pages.response.detail_member_report_trainning',$data);
				}
				
			}
		}
		else{
			Session::put('error_login', "You must login !");
			return Redirect::to("login");
		}
	}
	
	public function upload_image_trainning_report(){
		$input = Input::all();
		//set validation
		$file = array('image' => Input::file('file'));
		$rules = array('image' => 'required|mimes:jpeg,bmp,png');
		
		$validator = Validator::make($file, $rules);
		if ($validator->fails()) {
			Session::flash('error_trainning', 'File not support!');
			return Redirect::to('update_trainning_report/'.$input['Report_trainning_ID']);
		}
		else {
			// checking file is valid.
			if (Input::file('file')->isValid()) {
				$destinationpath = '/home/miland/public_html/asset/images/project/';
				$extension = Input::file('file')->getClientOriginalExtension();
				$filename = "v2_trainning_image_".$input['Report_trainning_ID']."_".rand(1,99999).'.'.$extension;
				Input::file('file')->move($destinationpath, $filename);
				
				$trainning_image_object = new \App\Model\Trainning_image();
				$trainning_image_object->Nama_gambar_training = $filename;
				$trainning_image_object->Status_gambar_training = 1;
				$trainning_image_object->save();
				
				$detail_report_trainning_object = new \App\Model\Detail_report_trainning();
				$detail_report_trainning_object->Report_training_ID = $input['Report_trainning_ID'];
				$detail_report_trainning_object->Training_image_ID = $trainning_image_object->Training_image_ID;
				$detail_report_trainning_object->save();
				
				Session::flash('error_trainning', 'Upload successfully'); 
				return Redirect::to('update_trainning_report/'.$input['Report_trainning_ID']);
			}
			else {
				Session::flash('error_trainning', 'uploaded file is not valid');
				return Redirect::to('update_trainning_report/'.$input['Report_trainning_ID']);
			}
		}
	}
}