<?php 
namespace App\Http\Controllers;

use Validator, Input, Redirect, Session, View, Auth, File; 

class InstalationController extends Controller {

	public function __construct()
	{
		$this->middleware('guest');
	}

	public function index()
	{
		//check apakah ada session mengenai data user
		if(Session::has('user_login_data')){
			$header_report_instalation_object = new \App\Model\Header_report_instalation();
			$data = array(
							'all_instalations' => $header_report_instalation_object::orderBy('Tanggal_pekerjaan', 'desc')->get(),
							'count_all_instalations' => $header_report_instalation_object::orderBy('Tanggal_pekerjaan', 'desc')->count(),
							'approve_instalations' => $header_report_instalation_object->approve()->get(),
							'count_approve_instalations' => $header_report_instalation_object->approve()->count(),
							'need_approval_instalations' => $header_report_instalation_object->need_approval()->get(),
							'count_need_approval_instalations' => $header_report_instalation_object->need_approval()->count(),
						);
			return View::make('pages.instalation',$data);
		}
		else{
			Session::put('error_login', "You must login !");
			return Redirect::to("login");
		}	
	}
	
	public function add_report_instalation_form($Jadwal_ID){
		//check apakah ada session mengenai data user
		if(Session::has('user_login_data')){
			if($Jadwal_ID == ""){
				Session::put('error_home', "You are not from schedule !");
				return Redirect::to("home");
			}
			else{
				$header_jadwal_object = new \App\Model\Header_jadwal();
				$karyawan_object = new \App\Model\Karyawan();
				$project_object = new \App\Model\Project();
				$data = array(
					'jadwals' => $header_jadwal_object::find($Jadwal_ID),
					'karyawans' => $karyawan_object::all(),
					'projects' => $project_object::orderBy('Tanggal_mulai', 'desc')->get(),
				);
				return View::make('pages.add_report_instalation',$data);
			}
		}
		else{
			Session::put('error_login', "You must login !");
			return Redirect::to("login");
		}
	}
	
	public function add_instalation_report(){
		//set validation
		$validator = Validator::make(
		Input::all(),
		array(
		    "Subject_text"				=> "required|min:3",
		    "Instalation_date"			=> "required|min:10|max:10",
		    "Start_time"				=> "required|min:5:max:5",
		    "End_time"					=> "required|min:5:max:5",
		    "Instalation_result_text"	=> "required|min:5",
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
			
			$header_report_instalation_object = new \App\Model\Header_report_instalation();
			$header_report_instalation_object->Karyawan_ID = $input['Karyawan_ID'];
			$header_report_instalation_object->Project_ID = $input['Project_ID'];
			$header_report_instalation_object->Subject = $input['Subject_text'];
			$header_report_instalation_object->Tanggal_pekerjaan = $input['Instalation_date'];
			$header_report_instalation_object->Nama_teknisi = $nama_teknisi;
			$header_report_instalation_object->Waktu_mulai = $input['Start_time'];
			$header_report_instalation_object->Waktu_selesai = $input['End_time'];		
			$header_report_instalation_object->Hasil_pekerjaan = $input['Instalation_result_text'];
			
			if($input['Problem_text']==""){
				$header_report_instalation_object->Kendala = "";
			}
			else{
				$header_report_instalation_object->Kendala = $input['Problem_text'];
			}
			
			if($input['Next_agenda_date']==""){
				$header_report_instalation_object->Tanggal_agenda = '0000-00-00';
			}
			else{
				$header_report_instalation_object->Tanggal_agenda = $input['Next_agenda_date'];
			}
			
			if($input['Next_agenda']==""){
				$header_report_instalation_object->Agenda = "";
			}
			else{
				$header_report_instalation_object->Agenda = $input['Next_agenda'];
			}
			
			$header_report_instalation_object->Status_instalasi = 1;
			$header_report_instalation_object->Approval = 0;
			$header_report_instalation_object->save();
			$Report_instalasi_ID = $header_report_instalation_object->Report_instalasi_ID;
			
			$header_jadwal_object = new \App\Model\Header_jadwal();
			$my_schedule = $header_jadwal_object::find($input['Jadwal_ID']);
			$my_schedule->Laporan_selesai = 1;
			$my_schedule->ID_laporan = $Report_instalasi_ID;
			$my_schedule->save();
			
			Session::put('error_trainning', "Success add trainning report !");
			return Redirect::to('update_instalation_report/'.$Report_instalasi_ID);
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
			Session::put('project_selected', $input['Project_ID']);
			Session::put('error_instalation', "Failed to insert trainning report !");
			return Redirect::to('instalation_report/'.$input['Jadwal_ID'])->withErrors($validator)->withInput();
		}
		
	}
	
	public function update_report_instalation_form($Report_instalation_ID){
		//check apakah ada session mengenai data user
		if(Session::has('user_login_data')){
			if($Report_instalation_ID == ""){
				Session::put('error_home', "You dont have Report Instalation ID !");
				return Redirect::to("home");
			}
			else{
				$header_report_instalation_object = new \App\Model\Header_report_instalation();
				$detail_report_instalation_object = new \App\Model\Detail_report_instalation();
				$karyawan_object = new \App\Model\Karyawan();
				$project_object = new \App\Model\Project();
				
				if(empty($header_report_instalation_object::find($Report_instalation_ID)->Karyawan_ID)){
					Session::put('error_home', "Report Instalation ID not found!");
					return Redirect::to("home");
				}
				else{
					$data = array(
					'instalations' => $header_report_instalation_object::find($Report_instalation_ID),
					'karyawans' => $karyawan_object::all(),
					'report_maker' => $karyawan_object::find($header_report_instalation_object::find($Report_instalation_ID)->Karyawan_ID)->Nama_karyawan,
					'projects' => $project_object::orderBy('Tanggal_mulai', 'desc')->get(),
					'details' => $detail_report_instalation_object::where('Report_instalasi_ID','=',$Report_instalation_ID)->get(),
				);
					return View::make('pages.update_report_instalation',$data);
				}
				
			}
		}
		else{
			Session::put('error_login', "You must login !");
			return Redirect::to("login");
		}
	}
	
	public function update_instalation_report(){
		//set validation
		$validator = Validator::make(
		Input::all(),
		array(
		    "Subject_text"				=> "required|min:3",
		    "Instalation_date"			=> "required|min:10|max:10",
		    "Start_time"				=> "required|min:5:max:5",
		    "End_time"					=> "required|min:5:max:5",
		    "Instalation_result_text"	=> "required|min:5",
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
			
			$header_report_instalation_object = new \App\Model\Header_report_instalation();
			$update_report_instalation = $header_report_instalation_object::find($input['Report_instalation_ID']);			
			$update_report_instalation->Project_ID = $input['Project_ID'];
			$update_report_instalation->Subject = $input['Subject_text'];
			$update_report_instalation->Tanggal_pekerjaan = $input['Instalation_date'];
			$update_report_instalation->Nama_teknisi = $nama_teknisi;
			$update_report_instalation->Waktu_mulai = $input['Start_time'];
			$update_report_instalation->Waktu_selesai = $input['End_time'];		
			$update_report_instalation->Hasil_pekerjaan = $input['Instalation_result_text'];
			
			if($input['Problem_text']==""){
				$update_report_instalation->Kendala = "";
			}
			else{
				$update_report_instalation->Kendala = $input['Problem_text'];
			}
			
			if($input['Next_agenda_date']==""){
				$update_report_instalation->Tanggal_agenda = '0000-00-00';
			}
			else{
				$update_report_instalation->Tanggal_agenda = $input['Next_agenda_date'];
			}
			
			if($input['Next_agenda']==""){
				$update_report_instalation->Agenda = "";
			}
			else{
				$update_report_instalation->Agenda = $input['Next_agenda'];
			}
			
			$update_report_instalation->save();
			
			Session::put('error_instalation', "Success update instalation report !");
			return Redirect::to('update_instalation_report/'.$input['Report_instalation_ID']);
		}
		else{
			Session::put('error_instalation', "Failed to update instalation report !");
			return Redirect::to('update_instalation_report/'.$input['Report_instalation_ID']);
		}
		
	}
	
	public function detail_report_instalation_form($Report_instalation_ID){
		//check apakah ada session mengenai data user
		if(Session::has('user_login_data')){
			if($Report_instalation_ID == ""){
				Session::put('error_home', "You dont have Report Instalation ID !");
				return Redirect::to("home");
			}
			else{
				$header_report_instalation_object = new \App\Model\Header_report_instalation();
				$detail_report_instalation_object = new \App\Model\Detail_report_instalation();
				$karyawan_object = new \App\Model\Karyawan();
				$project_object = new \App\Model\Project();
				
				if(empty($header_report_instalation_object::find($Report_instalation_ID)->Karyawan_ID)){
					Session::put('error_home', "Report Instalation ID not found!");
					return Redirect::to("home");
				}
				else{
					$data = array(
					'instalations' => $header_report_instalation_object::find($Report_instalation_ID),
					'karyawans' => $karyawan_object::all(),
					'report_maker' => $karyawan_object::find($header_report_instalation_object::find($Report_instalation_ID)->Karyawan_ID)->Nama_karyawan,
					'projects' => $project_object::orderBy('Tanggal_mulai', 'desc')->get(),
					'details' => $detail_report_instalation_object::where('Report_instalasi_ID','=',$Report_instalation_ID)->get(),
				);
					return View::make('pages.detail_report_instalation',$data);
				}
				
			}
		}
		else{
			Session::put('error_login', "You must login !");
			return Redirect::to("login");
		}
	}
	
	public function approve_report_instalation($Report_instalation_ID){
		//check apakah ada session mengenai data user
		if(Session::has('user_login_data')){
			if($Report_instalation_ID == ""){
				Session::put('error_home', "You dont have Report Instalation ID !");
				return Redirect::to("home");
			}
			else{
				$header_report_instalation_object = new \App\Model\Header_report_instalation();
				
				if(empty($header_report_instalation_object::find($Report_instalation_ID)->Karyawan_ID)){
					Session::put('error_home', "Report Instalation ID not found!");
					return Redirect::to("home");
				}
				else{
					$header_report_instalation = $header_report_instalation_object::find($Report_instalation_ID);
					$header_report_instalation->Approval = 1;
					$header_report_instalation->save();
					
					Session::put('error_instalation', "Success approve instalation report !");
					return Redirect::to("instalation");
				}
				
			}
		}
		else{
			Session::put('error_login', "You must login !");
			return Redirect::to("login");
		}
	}
	
	public function delete_report_instalation($Report_instalation_ID){
		//check apakah ada session mengenai data user
		if(Session::has('user_login_data')){
			if($Report_instalation_ID == ""){
				Session::put('error_home', "You dont have Report Instalation ID !");
				return Redirect::to("home");
			}
			else{
				$header_report_instalation_object = new \App\Model\Header_report_instalation();
				$detail_report_instalation_object = new \App\Model\Detail_report_instalation();
				$instalation_image_object = new \App\Model\Instalation_image();
				
				if(empty($header_report_instalation_object::find($Report_instalation_ID)->Karyawan_ID)){
					Session::put('error_home', "Report Instalation ID not found!");
					return Redirect::to("home");
				}
				else{
					//untuk menghapus gambar yang ada
					$delete_detail = $detail_report_instalation_object::where('Report_instalasi_ID','=',$Report_instalation_ID)->get();
					$jumlah_data=0;
					$temp_id;
					foreach($delete_detail as $row){
						$delete_image = $instalation_image_object::find($row->Instalasi_image_ID);
						$location = '/home/miland/public_html/asset/images/project/'.$delete_image->Nama_gambar_instalasi;
						File::delete($location);
						$temp_id[$jumlah_data] = $row->Instalasi_image_ID;
						$jumlah_data++;
					}
					
					$delete_detail = $detail_report_instalation_object::where('Report_instalasi_ID','=',$Report_instalation_ID);
					$delete_detail->delete();
					
					foreach($temp_id as $row){
						$delete_image = $instalation_image_object::find($row);
						$delete_image->delete();
					}
					
					$delete_header = $header_report_instalation_object::where('Report_instalasi_ID','=',$Report_instalation_ID);
					$delete_header->delete();
					
					Session::put('error_instalation', "Success delete instalation report !");
					return Redirect::to("instalation");
				}
				
			}
		}
		else{
			Session::put('error_login', "You must login !");
			return Redirect::to("login");
		}
	}
	
	public function get_detail_member_report_instalation($Report_instalation_ID){
		if(Session::has('user_login_data')){
			if($Report_instalation_ID == ""){
				return "You don't report instalation ID";
			}
			else{
				$header_report_instalation_object = new \App\Model\Header_report_instalation();
				
				if(empty($header_report_instalation_object::find($Report_instalation_ID)->Karyawan_ID)){
					return "Report Instalation ID not found!";
				}
				else{
					$data = array(
										'header_report_instalation' => $header_report_instalation_object::find($Report_instalation_ID),
									);
					return View::make('pages.response.detail_member_report_instalation',$data);
				}
				
			}
		}
		else{
			Session::put('error_login', "You must login !");
			return Redirect::to("login");
		}
	}
	
	public function upload_image_instalation_report(){
		$input = Input::all();
		//set validation
		$file = array('image' => Input::file('file'));
		$rules = array('image' => 'required|mimes:jpeg,bmp,png');
		
		$validator = Validator::make($file, $rules);
		if ($validator->fails()) {
			Session::flash('error_instalation', 'File not support!');
			return Redirect::to('update_instalation_report/'.$input['Report_instalation_ID']);
		}
		else {
			// checking file is valid.
			if (Input::file('file')->isValid()) {
				$destinationpath = '/home/miland/public_html/asset/images/project/';
				$extension = Input::file('file')->getClientOriginalExtension();
				$filename = "v2_instalation_image_".$input['Report_instalation_ID']."_".rand(1,99999).'.'.$extension;
				Input::file('file')->move($destinationpath, $filename);
				
				$instalation_image_object = new \App\Model\Instalation_image();
				$instalation_image_object->Nama_gambar_instalasi = $filename;
				$instalation_image_object->Status_gambar_intalasi = 1;
				$instalation_image_object->save();
				
				$detail_report_instalation_object = new \App\Model\Detail_report_instalation();
				$detail_report_instalation_object->Report_instalasi_ID = $input['Report_instalation_ID'];
				$detail_report_instalation_object->Instalasi_image_ID = $instalation_image_object->Instalasi_image_ID;
				$detail_report_instalation_object->save();
				
				Session::flash('error_instalation', 'Upload successfully'); 
				return Redirect::to('update_instalation_report/'.$input['Report_instalation_ID']);
			}
			else {
				Session::flash('error_instalation', 'uploaded file is not valid');
				return Redirect::to('update_instalation_report/'.$input['Report_instalation_ID']);
			}
		}
	}
}