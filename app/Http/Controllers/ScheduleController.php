<?php 
namespace App\Http\Controllers;

use Validator, Input, Redirect, Session, View, Auth; 

class ScheduleController extends Controller {

	public function __construct()
	{
		$this->middleware('guest');
	}

	public function index()
	{
		//check apakah ada session mengenai data user
		if(Session::has('user_login_data')){
			if(Session::get('user_login_data')->Jabatan_ID != 1 && Session::get('user_login_data')->Jabatan_ID != 3 && Session::get('user_login_data')->Jabatan_ID != 4 && Session::get('user_login_data')->Jabatan_ID != 5){
				Session::put('error_home', "You dont have access !");
				return Redirect::to("home");
			}
			else{
				//create object project
				$project_object = new \App\Model\Project();
				$karyawan_object = new \App\Model\Karyawan();
				$header_jadwal_object = new \App\Model\Header_jadwal();
				$data = array(
									'data_project' 	=> $project_object::orderBy('Tanggal_mulai', 'desc')->get(),
									'data_karyawan' => $karyawan_object::all(),
									'data_jadwal'	=> $header_jadwal_object::orderBy('Tanggal_jadwal', 'desc')->get(),
									'count_all_jadwal'	=> $header_jadwal_object::orderBy('Tanggal_jadwal', 'desc')->count(),
									'data_complete_jadwal'	=> $header_jadwal_object->complete()->get(),
									'count_complete_jadwal'	=> $header_jadwal_object->complete()->count(),
									'data_no_report_jadwal'	=> $header_jadwal_object->no_report()->get(),
									'count_no_report_jadwal'	=> $header_jadwal_object->no_report()->count(),
									'data_upcoming_jadwal'	=> $header_jadwal_object->upcoming()->get(),
									'count_upcoming_jadwal'	=> $header_jadwal_object->upcoming()->count(),
								);
				return View::make('pages.schedule', $data);
			}
		}
		else{
			Session::put('error_login', "You must login !");
			return Redirect::to("login");
		}
	}
	
	public function add_schedule(){
		//set validation
		$validator = Validator::make(
		Input::all(),
		array(
		    "subject_text"			=> "required|min:3",
		    "schedule_date_text"	=> "required|min:10|max:10",
		    "schedule_time_text"	=> "required|min:8:max:8",
		    "description_text"		=> "required|min:5",
		)
		);
		
		//check checkbox daftar karyawan
		$input = Input::all();
		for($i=1;$i<$input['no'];$i++){
			if(isset($input["karyawan_id$i"])){
				$data_checked[$i] = 1;
			}
			else{
				$data_checked[$i] = 0;
			}
		}
		
		if($validator->passes())
		{
			$header_jadwal_object = new \App\Model\Header_jadwal();
			$header_jadwal_object->Project_ID = $input['project_name_text'];
			$header_jadwal_object->Subjek = $input['subject_text'];
			$header_jadwal_object->Nama_pembuat = Session::get('user_login_data')->Nama_karyawan;
			$header_jadwal_object->Tanggal_jadwal = $input['schedule_date_text'];
			$header_jadwal_object->Waktu_jadwal = $input['schedule_time_text'];
			$header_jadwal_object->Keterangan = $input['description_text'];
			$header_jadwal_object->Laporan_selesai = 0;
			$header_jadwal_object->Jenis_laporan = $input['schedule_type_text'];
			$header_jadwal_object->ID_laporan = 0;
			$header_jadwal_object->save();
			$lastid = $header_jadwal_object->Jadwal_ID;
			
			
			for($i=1;$i<$input['no'];$i++){
				if(isset($input["karyawan_id$i"])){
					$detail_jadwal_object = new \App\Model\Detail_jadwal();
					$detail_jadwal_object->Jadwal_ID = $lastid;
					$detail_jadwal_object->Karyawan_ID = $input["karyawan_id$i"];
					$detail_jadwal_object->save();
				}
			}
			
			Session::put('error_schedule', "Success add schedule !");
			return Redirect::to('schedule');
		}
		else{
			Session::put('error_schedule', "Failed to add schedule !");
			Session::put('data_checked', $data_checked);
			return Redirect::to('schedule')->withErrors($validator)->withInput();
		}
	}
	
	public function delete_schedule($id){
		$detail_jadwal_object = new \App\Model\Detail_jadwal();
		$detail_jadwal_object::where('Jadwal_ID','=',$id)->delete();
		
		$header_jadwal_object = new \App\Model\Header_jadwal();
		$header_jadwal_object::where('Jadwal_ID','=',$id)->delete();
		
		Session::put('error_schedule', "Success delete schedule !");
		return Redirect::to('schedule');
	}
	
	public function get_detail_schedule($id){
		if(Session::has('user_login_data')){
				$header_object = new \App\Model\Header_jadwal();
				$detail_object = new \App\Model\Detail_jadwal();
				$project_object = new \App\Model\Project();
				$karyawan_object = new \App\Model\Karyawan();
				$data = array(
									'projects' 	=> $project_object::orderBy('Tanggal_mulai', 'desc')->get(),
									'karyawans' => $karyawan_object::all(),
									'headers' => $header_object::find($id),
									'details' => $detail_object::where('Jadwal_ID','=',$id),
								);
				return View::make('pages.response.detail_schedule',$data);
		}
		else{
			Session::put('error_login', "You must login !");
			return Redirect::to("login");
		}
	}
	
	public function get_edit_schedule($id){
		if(Session::has('user_login_data')){
				$header_object = new \App\Model\Header_jadwal();
				$detail_object = new \App\Model\Detail_jadwal();
				$project_object = new \App\Model\Project();
				$karyawan_object = new \App\Model\Karyawan();
				$data = array(
									'projects' 	=> $project_object::orderBy('Tanggal_mulai', 'desc')->get(),
									'karyawans' => $karyawan_object::all(),
									'headers' => $header_object::find($id),
									'details' => $detail_object::where('Jadwal_ID','=',$id),
								);
				return View::make('pages.response.edit_schedule',$data);
		}
		else{
			Session::put('error_login', "You must login !");
			return Redirect::to("login");
		}
	}
	
	public function edit_schedule(){
		//set validation
		$validator = Validator::make(
		Input::all(),
		array(
		    "subject_text"			=> "required|min:3",
		    "schedule_date_text"	=> "required|min:10|max:10",
		    "schedule_time_text"	=> "required|min:8:max:8",
		    "description_text"		=> "required|min:5",
		)
		);
		
		//check checkbox daftar karyawan
		$input = Input::all();
		for($i=1;$i<$input['no'];$i++){
			if(isset($input["karyawan_id$i"])){
				$data_checked[$i] = 1;
			}
			else{
				$data_checked[$i] = 0;
			}
		}
		
		if($validator->passes())
		{
			$header_schedule_object = new \App\Model\Header_jadwal();
			$update_schedule = $header_schedule_object::find($input['Jadwal_ID']);
			$update_schedule->Project_ID = $input['project_name_text'];
			$update_schedule->Subjek = $input['subject_text'];
			$update_schedule->Tanggal_jadwal = $input['schedule_date_text'];
			$update_schedule->Waktu_jadwal = $input['schedule_time_text'];
			$update_schedule->Keterangan = $input['description_text'];
			$update_schedule->Jenis_laporan = $input['schedule_type_text'];
			$update_schedule->save();
			
			$detail_schedule_object = new \App\Model\Detail_jadwal();
			$detail_schedule_object::where('Jadwal_ID','=',$input['Jadwal_ID'])->delete();
			
			//add member to schedule
			for($i=1;$i<$input['no'];$i++){
				if(isset($input["karyawan_id$i"])){
					$detail_jadwal_object = new \App\Model\Detail_jadwal();
					$detail_jadwal_object->Jadwal_ID = $input['Jadwal_ID'];
					$detail_jadwal_object->Karyawan_ID = $input["karyawan_id$i"];
					$detail_jadwal_object->save();
				}
			}
			
			Session::put('error_schedule', "Success edit schedule !");
			return Redirect::to('schedule');
		}
		else{
			Session::put('error_schedule', "Failed to add schedule !");
			return Redirect::to('schedule');
		}
	}
	
	public function get_detail_member_schedule($Jadwal_ID){
		if(Session::has('user_login_data')){
			if($Jadwal_ID == ""){
				return "You don't have Schedule ID";
			}
			else{
				$detail_jadwal_object = new \App\Model\Detail_jadwal();
				
				if(empty($detail_jadwal_object::where('Jadwal_ID','=',$Jadwal_ID))){
					return "Schedule ID not found!";
				}
				else{
					$data = array(
										'detail_schedules' => $detail_jadwal_object::where('Jadwal_ID','=',$Jadwal_ID)->get(),
									);
					
					return View::make('pages.response.detail_member_schedule',$data);
				}
				
			}
		}
		else{
			Session::put('error_login', "You must login !");
			return Redirect::to("login");
		}
	}
}
