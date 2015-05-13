<?php 
namespace App\Http\Controllers;

use Validator, Input, Redirect, Session, View, Auth, File; 

class MaintenanceController extends Controller {

	public function __construct()
	{
		$this->middleware('guest');
	}

	public function index()
	{
		//check apakah ada session mengenai data user
		if(Session::has('user_login_data')){
			$header_report_maintenance_object = new \App\Model\Header_report_maintenance();
			$data = array(
							'all_maintenances' => $header_report_maintenance_object::orderBy('Tanggal_pekerjaan', 'desc')->get(),
							'count_all_maintenances' => $header_report_maintenance_object::orderBy('Tanggal_pekerjaan', 'desc')->count(),
							'approve_maintenances' => $header_report_maintenance_object->approve()->get(),
							'count_approve_maintenances' => $header_report_maintenance_object->approve()->count(),
							'need_approval_maintenances' => $header_report_maintenance_object->need_approval()->get(),
							'count_need_approval_maintenances' => $header_report_maintenance_object->need_approval()->count(),
						);
			return View::make('pages.maintenance',$data);
		}
		else{
			Session::put('error_login', "You must login !");
			return Redirect::to("login");
		}
	}
	
	public function add_report_maintenance_form($Jadwal_ID){
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
				return View::make('pages.add_report_maintenance',$data);
			}
		}
		else{
			Session::put('error_login', "You must login !");
			return Redirect::to("login");
		}
	}
	
	public function add_maintenance_report(){
		//set validation
		$validator = Validator::make(
		Input::all(),
		array(
		    "Subject_text"				=> "required|min:3",
		    "Maintenance_date"			=> "required|min:10|max:10",
		    "Start_time"				=> "required|min:5:max:5",
		    "End_time"					=> "required|min:5:max:5",
		    "First_condition"			=> "required|min:5",
		    "Last_condition"			=> "required|min:5",
		    "User_text"					=> "required|min:3",
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
			
			$header_report_maintenance_object = new \App\Model\Header_report_maintenance();
			$header_report_maintenance_object->Karyawan_ID = $input['Karyawan_ID'];
			$header_report_maintenance_object->Project_ID = $input['Project_ID'];
			$header_report_maintenance_object->Subject = $input['Subject_text'];
			$header_report_maintenance_object->Tanggal_pekerjaan = $input['Maintenance_date'];
			$header_report_maintenance_object->Nama_teknisi = $nama_teknisi;
			$header_report_maintenance_object->Waktu_mulai = $input['Start_time'];
			$header_report_maintenance_object->Waktu_selesai = $input['End_time'];		
			$header_report_maintenance_object->Kondisi_awal = $input['First_condition'];
			$header_report_maintenance_object->Kondisi_akhir = $input['Last_condition'];
			$header_report_maintenance_object->Nama_user = $input['User_text'];
			$header_report_maintenance_object->Status_maintenance = 1;
			$header_report_maintenance_object->Approval = 0;
			$header_report_maintenance_object->save();
			$Report_maintenance_ID = $header_report_maintenance_object->Report_maintenance_ID;
			
			$header_jadwal_object = new \App\Model\Header_jadwal();
			$my_schedule = $header_jadwal_object::find($input['Jadwal_ID']);
			$my_schedule->Laporan_selesai = 1;
			$my_schedule->ID_laporan = $Report_maintenance_ID;
			$my_schedule->save();
			
			Session::put('error_maintenance', "Success add maintenance report !");
			return Redirect::to('update_maintenance_report/'.$Report_maintenance_ID);
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
			Session::put('error_maintenance', "Failed to insert maintenance report !");
			return Redirect::to('maintenance_report/'.$input['Jadwal_ID'])->withErrors($validator)->withInput();
		}
		
	}
	
	public function update_report_maintenance_form($Report_maintenance_ID){
		//check apakah ada session mengenai data user
		if(Session::has('user_login_data')){
			if($Report_maintenance_ID == ""){
				Session::put('error_home', "You dont have Report Maintenance ID !");
				return Redirect::to("home");
			}
			else{
				$header_report_maintenance_object = new \App\Model\Header_report_maintenance();
				$detail_report_maintenance_object = new \App\Model\Detail_report_maintenance();
				$karyawan_object = new \App\Model\Karyawan();
				$project_object = new \App\Model\Project();
				
				if(empty($header_report_maintenance_object::find($Report_maintenance_ID)->Karyawan_ID)){
					Session::put('error_home', "Report Maintenance ID not found!");
					return Redirect::to("home");
				}
				else{
					$data = array(
					'maintenances' => $header_report_maintenance_object::find($Report_maintenance_ID),
					'karyawans' => $karyawan_object::all(),
					'report_maker' => $karyawan_object::find($header_report_maintenance_object::find($Report_maintenance_ID)->Karyawan_ID)->Nama_karyawan,
					'projects' => $project_object::orderBy('Tanggal_mulai', 'desc')->get(),				
					'details' => $detail_report_maintenance_object::where('Report_maintenance_ID','=',$Report_maintenance_ID)->get(),
				);
					return View::make('pages.update_report_maintenance',$data);
				}
				
			}
		}
		else{
			Session::put('error_login', "You must login !");
			return Redirect::to("login");
		}
	}
	
	public function update_maintenance_report(){
		//set validation
		$validator = Validator::make(
		Input::all(),
		array(
		    "Subject_text"				=> "required|min:3",
		    "Maintenance_date"			=> "required|min:10|max:10",
		    "Start_time"				=> "required|min:5:max:5",
		    "End_time"					=> "required|min:5:max:5",
		    "First_condition"			=> "required|min:5",
		    "Last_condition"			=> "required|min:5",
		    "User_text"					=> "required|min:3",
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
			
			$header_report_maintenance_object = new \App\Model\Header_report_maintenance();
			$update_report_maintenance = $header_report_maintenance_object::find($input['Report_maintenance_ID']);			
			$update_report_maintenance->Project_ID = $input['Project_ID'];
			$update_report_maintenance->Subject = $input['Subject_text'];
			$update_report_maintenance->Tanggal_pekerjaan = $input['Maintenance_date'];
			$update_report_maintenance->Nama_teknisi = $nama_teknisi;
			$update_report_maintenance->Waktu_mulai = $input['Start_time'];
			$update_report_maintenance->Waktu_selesai = $input['End_time'];		
			$update_report_maintenance->Kondisi_awal = $input['First_condition'];
			$update_report_maintenance->Kondisi_akhir = $input['Last_condition'];
			$update_report_maintenance->Nama_user = $input['User_text'];
			$update_report_maintenance->save();
			
			Session::put('error_maintenance', "Success update maintenance report !");
			return Redirect::to('update_maintenance_report/'.$input['Report_maintenance_ID']);
		}
		else{
			Session::put('error_maintenance', "Failed to update maintenance report !");
			return Redirect::to('update_maintenance_report/'.$input['Report_maintenance_ID']);
		}
	}
	
	public function detail_report_maintenance_form($Report_maintenance_ID){
		//check apakah ada session mengenai data user
		//check apakah ada session mengenai data user
		if(Session::has('user_login_data')){
			if($Report_maintenance_ID == ""){
				Session::put('error_home', "You dont have Report Maintenance ID !");
				return Redirect::to("home");
			}
			else{
				$header_report_maintenance_object = new \App\Model\Header_report_maintenance();
				$detail_report_maintenance_object = new \App\Model\Detail_report_maintenance();
				$karyawan_object = new \App\Model\Karyawan();
				$project_object = new \App\Model\Project();
				
				if(empty($header_report_maintenance_object::find($Report_maintenance_ID)->Karyawan_ID)){
					Session::put('error_home', "Report Maintenance ID not found!");
					return Redirect::to("home");
				}
				else{
					$data = array(
					'maintenances' => $header_report_maintenance_object::find($Report_maintenance_ID),
					'karyawans' => $karyawan_object::all(),
					'report_maker' => $karyawan_object::find($header_report_maintenance_object::find($Report_maintenance_ID)->Karyawan_ID)->Nama_karyawan,
					'projects' => $project_object::orderBy('Tanggal_mulai', 'desc')->get(),
					'details' => $detail_report_maintenance_object::where('Report_maintenance_ID','=',$Report_maintenance_ID)->get(),
				);
					return View::make('pages.detail_report_maintenance',$data);
				}
				
			}
		}
		else{
			Session::put('error_login', "You must login !");
			return Redirect::to("login");
		}
	}
	
	public function approve_report_maintenance($Report_maintenance_ID){
		//check apakah ada session mengenai data user
		if(Session::has('user_login_data')){
			if($Report_maintenance_ID == ""){
				Session::put('error_home', "You dont have Report Maintenance ID !");
				return Redirect::to("home");
			}
			else{
				$header_report_maintenance_object = new \App\Model\Header_report_maintenance();
				
				if(empty($header_report_maintenance_object::find($Report_maintenance_ID)->Karyawan_ID)){
					Session::put('error_home', "Report Maintenance ID not found!");
					return Redirect::to("home");
				}
				else{
					$header_report_maintenance = $header_report_maintenance_object::find($Report_maintenance_ID);
					$header_report_maintenance->Approval = 1;
					$header_report_maintenance->save();
					
					Session::put('error_maintenance', "Success approve maintenance report !");
					return Redirect::to("maintenance");
				}
				
			}
		}
		else{
			Session::put('error_login', "You must login !");
			return Redirect::to("login");
		}
	}
	
	public function delete_report_maintenance($Report_maintenance_ID){
		//check apakah ada session mengenai data user
		if(Session::has('user_login_data')){
			if($Report_maintenance_ID == ""){
				Session::put('error_home', "You dont have Report Maintenance ID !");
				return Redirect::to("home");
			}
			else{
				$header_report_maintenance_object = new \App\Model\Header_report_maintenance();
				$detail_report_maintenance_object = new \App\Model\Detail_report_maintenance();
				$maintenance_image_object = new \App\Model\Maintenance_image();
				
				if(empty($header_report_maintenance_object::find($Report_maintenance_ID)->Karyawan_ID)){
					Session::put('error_home', "Report Maintenance ID not found!");
					return Redirect::to("home");
				}
				else{
					//untuk menghapus gambar yang ada
					$delete_detail = $detail_report_maintenance_object::where('Report_maintenance_ID','=',$Report_maintenance_ID)->get();
					$jumlah_data=0;
					$temp_id;
					foreach($delete_detail as $row){
						$delete_image = $maintenance_image_object::find($row->Maintenance_image_ID);
						$location = '/home/miland/public_html/asset/images/project/'.$delete_image->Nama_gambar_maintenance; 
						File::delete($location);
						$temp_id[$jumlah_data] = $row->Maintenance_image_ID;
						$jumlah_data++;
					}
					
					$delete_detail = $detail_report_maintenance_object::where('Report_maintenance_ID','=',$Report_maintenance_ID);
					$delete_detail->delete();
					
					foreach($temp_id as $row){
						$delete_image = $maintenance_image_object::find($row);
						$delete_image->delete();
					}
					
					$delete_header = $header_report_maintenance_object::where('Report_maintenance_ID','=',$Report_maintenance_ID);
					$delete_header->delete();
					
					Session::put('error_maintenance', "Success delete maintenance report !");
					return Redirect::to("maintenance");
				}
				
			}
		}
		else{
			Session::put('error_login', "You must login !");
			return Redirect::to("login");
		}
	}
	
	public function get_detail_member_report_maintenance($Report_maintenance_ID){
		if(Session::has('user_login_data')){
			if($Report_maintenance_ID == ""){
				return "You don't report Maintenance ID";
			}
			else{
				$header_report_maintenance_object = new \App\Model\Header_report_maintenance();
				
				if(empty($header_report_maintenance_object::find($Report_maintenance_ID)->Karyawan_ID)){
					return "Report Maintenance ID not found!";
				}
				else{
					$data = array(
										'header_report_maintenance' => $header_report_maintenance_object::find($Report_maintenance_ID),
									);
					return View::make('pages.response.detail_member_report_maintenance',$data);
				}
				
			}
		}
		else{
			Session::put('error_login', "You must login !");
			return Redirect::to("login");
		}
	}
	
	public function upload_image_maintenance_report(){
		$input = Input::all();
		//set validation
		$file = array('image' => Input::file('file'));
		$rules = array('image' => 'required|mimes:jpeg,bmp,png');
		
		$validator = Validator::make($file, $rules);
		if ($validator->fails()) {
			Session::flash('error_maintenance', 'File not support!');
			return Redirect::to('update_maintenance_report/'.$input['Report_maintenance_ID']);
		}
		else {
			// checking file is valid.
			if (Input::file('file')->isValid()) {
				$destinationpath = '/home/miland/public_html/asset/images/project/';
				$extension = Input::file('file')->getClientOriginalExtension();
				$filename = "v2_maintenance_image_".$input['Report_maintenance_ID']."_".rand(1,99999).'.'.$extension;
				Input::file('file')->move($destinationpath, $filename);
				
				$maintenance_image_object = new \App\Model\Maintenance_image();
				$maintenance_image_object->Nama_gambar_maintenance = $filename;
				$maintenance_image_object->Status_gambar_maintenance = 1;
				$maintenance_image_object->save();
				
				$detail_report_maintenance_object = new \App\Model\Detail_report_maintenance();
				$detail_report_maintenance_object->Report_maintenance_ID = $input['Report_maintenance_ID'];
				$detail_report_maintenance_object->Maintenance_image_ID = $maintenance_image_object->Maintenance_image_ID;
				$detail_report_maintenance_object->save();
				
				Session::flash('error_maintenance', 'Upload successfully'); 
				return Redirect::to('update_maintenance_report/'.$input['Report_maintenance_ID']);
			}
			else {
				Session::flash('error_maintenance', 'uploaded file is not valid');
				return Redirect::to('update_maintenance_report/'.$input['Report_maintenance_ID']);
			}
		}
	}
}