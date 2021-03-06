<?php 
namespace App\Http\Controllers;

use Validator, Input, Redirect, Session, View, Auth, File; 

class TroubleshootController extends Controller {

	public function __construct()
	{
		$this->middleware('guest');
	}

	public function index()
	{
		//check apakah ada session mengenai data user
		if(Session::has('user_login_data')){
			$header_report_troubleshoot_object = new \App\Model\Header_report_troubleshoot();
			$data = array(
							'all_troubleshoots' => $header_report_troubleshoot_object::orderBy('Tanggal_pekerjaan', 'desc')->get(),
							'count_all_troubleshoots' => $header_report_troubleshoot_object::orderBy('Tanggal_pekerjaan', 'desc')->count(),
							'approve_troubleshoots' => $header_report_troubleshoot_object->approve()->get(),
							'count_approve_troubleshoots' => $header_report_troubleshoot_object->approve()->count(),
							'need_approval_troubleshoots' => $header_report_troubleshoot_object->need_approval()->get(),
							'count_need_approval_troubleshoots' => $header_report_troubleshoot_object->need_approval()->count(),
						);
			return View::make('pages.troubleshoot',$data);
		}
		else{
			Session::put('error_login', "You must login !");
			return Redirect::to("login");
		}
		
	}
	
	public function add_report_troubleshoot_form($Jadwal_ID){
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
				return View::make('pages.add_report_troubleshoot',$data);
			}
		}
		else{
			Session::put('error_login', "You must login !");
			return Redirect::to("login");
		}
	}
	
	public function add_troubleshoot_report(){
		//set validation
		$validator = Validator::make(
		Input::all(),
		array(
		    "Subject_text"				=> "required|min:3",
		    "Problem_text"				=> "required|min:3",
		    "Troubleshoot_date"			=> "required|min:10|max:10",
		    "Start_time"				=> "required|min:5:max:5",
		    "End_time"					=> "required|min:5:max:5",
		    "First_condition"			=> "required|min:5",
		    "Result_text"				=> "required|min:5",
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
			
			$header_report_troubleshoot_object = new \App\Model\Header_report_troubleshoot();
			$header_report_troubleshoot_object->Karyawan_ID = $input['Karyawan_ID'];
			$header_report_troubleshoot_object->Project_ID = $input['Project_ID'];
			$header_report_troubleshoot_object->Subject = $input['Subject_text'];
			$header_report_troubleshoot_object->Tanggal_pekerjaan = $input['Troubleshoot_date'];
			$header_report_troubleshoot_object->Gangguan = $input['Problem_text'];
			$header_report_troubleshoot_object->Nama_teknisi = $nama_teknisi;
			$header_report_troubleshoot_object->Waktu_mulai = $input['Start_time'];
			$header_report_troubleshoot_object->Waktu_selesai = $input['End_time'];		
			$header_report_troubleshoot_object->Kondisi_awal = $input['First_condition'];
			$header_report_troubleshoot_object->Hasil_pekerjaan = $input['Result_text'];
			$header_report_troubleshoot_object->Kondisi_akhir = $input['Last_condition'];
			$header_report_troubleshoot_object->Nama_user = $input['User_text'];
			$header_report_troubleshoot_object->Status_troubleshoot = 1;
			$header_report_troubleshoot_object->Approval = 0;
			$header_report_troubleshoot_object->save();
			$Report_troubleshoot_ID = $header_report_troubleshoot_object->Report_troubleshoot_ID;
			
			$header_jadwal_object = new \App\Model\Header_jadwal();
			$my_schedule = $header_jadwal_object::find($input['Jadwal_ID']);
			$my_schedule->Laporan_selesai = 1;
			$my_schedule->ID_laporan = $Report_troubleshoot_ID;
			$my_schedule->save();
			
			Session::put('error_troubleshoot', "Success add troubleshoot report !");
			return Redirect::to('update_troubleshoot_report/'.$Report_troubleshoot_ID);
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
			Session::put('error_troubleshoot', "Failed to insert troubleshoot report !");
			return Redirect::to('troubleshoot_report/'.$input['Jadwal_ID'])->withErrors($validator)->withInput();
		}
		
	}
	
	public function update_report_troubleshoot_form($Report_troubleshoot_ID){
		//check apakah ada session mengenai data user
		if(Session::has('user_login_data')){
			if($Report_troubleshoot_ID == ""){
				Session::put('error_home', "You dont have Report Troubleshoot ID !");
				return Redirect::to("home");
			}
			else{
				$header_report_troubleshoot_object = new \App\Model\Header_report_troubleshoot();
				$detail_report_troubleshoot_object = new \App\Model\Detail_report_troubleshoot();
				$karyawan_object = new \App\Model\Karyawan();
				$project_object = new \App\Model\Project();
				
				if(empty($header_report_troubleshoot_object::find($Report_troubleshoot_ID)->Karyawan_ID)){
					Session::put('error_home', "Report Troubleshoot ID not found!");
					return Redirect::to("home");
				}
				else{
					$data = array(
					'troubleshoots' => $header_report_troubleshoot_object::find($Report_troubleshoot_ID),
					'karyawans' => $karyawan_object::all(),
					'report_maker' => $karyawan_object::find($header_report_troubleshoot_object::find($Report_troubleshoot_ID)->Karyawan_ID)->Nama_karyawan,
					'projects' => $project_object::orderBy('Tanggal_mulai', 'desc')->get(),
					'details' => $detail_report_troubleshoot_object::where('Report_troubleshoot_ID','=',$Report_troubleshoot_ID)->get(),
				);
					return View::make('pages.update_report_troubleshoot',$data);
				}
				
			}
		}
		else{
			Session::put('error_login', "You must login !");
			return Redirect::to("login");
		}
	}
	
	public function update_troubleshoot_report(){
		//set validation
		$validator = Validator::make(
		Input::all(),
		array(
		    "Subject_text"				=> "required|min:3",
		    "Problem_text"				=> "required|min:3",
		    "Troubleshoot_date"			=> "required|min:10|max:10",
		    "Start_time"				=> "required|min:5:max:5",
		    "End_time"					=> "required|min:5:max:5",
		    "First_condition"			=> "required|min:5",
		    "Result_text"				=> "required|min:5",
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
			
			$header_report_troubleshoot_object = new \App\Model\Header_report_troubleshoot();
			$update_report_troubleshoot = $header_report_troubleshoot_object::find($input['Report_troubleshoot_ID']);
			$update_report_troubleshoot->Project_ID = $input['Project_ID'];
			$update_report_troubleshoot->Subject = $input['Subject_text'];
			$update_report_troubleshoot->Tanggal_pekerjaan = $input['Troubleshoot_date'];
			$update_report_troubleshoot->Gangguan = $input['Problem_text'];
			$update_report_troubleshoot->Nama_teknisi = $nama_teknisi;
			$update_report_troubleshoot->Waktu_mulai = $input['Start_time'];
			$update_report_troubleshoot->Waktu_selesai = $input['End_time'];		
			$update_report_troubleshoot->Kondisi_awal = $input['First_condition'];
			$update_report_troubleshoot->Hasil_pekerjaan = $input['Result_text'];
			$update_report_troubleshoot->Kondisi_akhir = $input['Last_condition'];
			$update_report_troubleshoot->Nama_user = $input['User_text'];
			$update_report_troubleshoot->save();
			
			Session::put('error_troubleshoot', "Success update troubleshoot report !");
			return Redirect::to('update_troubleshoot_report/'.$input['Report_troubleshoot_ID']);
		}
		else{
			Session::put('error_troubleshoot', "Failed to update troubleshoot report !");
			return Redirect::to('update_troubleshoot_report/'.$input['Report_troubleshoot_ID']);
		}
	}
	
	public function detail_report_troubleshoot_form($Report_troubleshoot_ID){
		//check apakah ada session mengenai data user
		if(Session::has('user_login_data')){
			if($Report_troubleshoot_ID == ""){
				Session::put('error_home', "You dont have Report Troubleshoot ID !");
				return Redirect::to("home");
			}
			else{
				$header_report_troubleshoot_object = new \App\Model\Header_report_troubleshoot();
				$detail_report_troubleshoot_object = new \App\Model\Detail_report_troubleshoot();
				$karyawan_object = new \App\Model\Karyawan();
				$project_object = new \App\Model\Project();
				
				if(empty($header_report_troubleshoot_object::find($Report_troubleshoot_ID)->Karyawan_ID)){
					Session::put('error_home', "Report Troubleshoot ID not found!");
					return Redirect::to("home");
				}
				else{
					$data = array(
					'troubleshoots' => $header_report_troubleshoot_object::find($Report_troubleshoot_ID),
					'karyawans' => $karyawan_object::all(),
					'report_maker' => $karyawan_object::find($header_report_troubleshoot_object::find($Report_troubleshoot_ID)->Karyawan_ID)->Nama_karyawan,
					'projects' => $project_object::orderBy('Tanggal_mulai', 'desc')->get(),
					'details' => $detail_report_troubleshoot_object::where('Report_troubleshoot_ID','=',$Report_troubleshoot_ID)->get(),
				);
					return View::make('pages.detail_report_troubleshoot',$data);
				}
				
			}
		}
		else{
			Session::put('error_login', "You must login !");
			return Redirect::to("login");
		}
	}
	
	public function approve_report_troubleshoot($Report_troubleshoot_ID){
		//check apakah ada session mengenai data user
		if(Session::has('user_login_data')){
			if($Report_troubleshoot_ID == ""){
				Session::put('error_home', "You dont have Report Troubleshoot ID !");
				return Redirect::to("home");
			}
			else{
				$header_report_troubleshoot_object = new \App\Model\Header_report_troubleshoot();
				
				if(empty($header_report_troubleshoot_object::find($Report_troubleshoot_ID)->Karyawan_ID)){
					Session::put('error_home', "Report Troubleshoot ID not found!");
					return Redirect::to("home");
				}
				else{
					$header_report_troubleshoot = $header_report_troubleshoot_object::find($Report_troubleshoot_ID);
					$header_report_troubleshoot->Approval = 1;
					$header_report_troubleshoot->save();
					
					Session::put('error_troubleshoot', "Success approve troubleshoot report !");
					return Redirect::to("troubleshoot");
				}
			}
		}
		else{
			Session::put('error_login', "You must login !");
			return Redirect::to("login");
		}
	}
	
	public function delete_report_troubleshoot($Report_troubleshoot_ID){
		//check apakah ada session mengenai data user
		if(Session::has('user_login_data')){
			if($Report_troubleshoot_ID == ""){
				Session::put('error_home', "You dont have Report Troubleshoot ID !");
				return Redirect::to("home");
			}
			else{
				$header_report_troubleshoot_object = new \App\Model\Header_report_troubleshoot();
				$detail_report_troubleshoot_object = new \App\Model\Detail_report_troubleshoot();
				$troubleshoot_image_object = new \App\Model\Troubleshoot_image();
				
				if(empty($header_report_troubleshoot_object::find($Report_troubleshoot_ID)->Karyawan_ID)){
					Session::put('error_home', "Report Troubleshoot ID not found!");
					return Redirect::to("home");
				}
				else{
					//untuk menghapus gambar yang ada
					$delete_detail = $detail_report_troubleshoot_object::where('Report_troubleshoot_ID','=',$Report_troubleshoot_ID)->get();
					$jumlah_data=0;
					$temp_id;
					foreach($delete_detail as $row){
						$delete_image = $troubleshoot_image_object::find($row->Troubleshoot_image_ID);
						$location = '/home/miland/public_html/asset/images/project/'.$delete_image->Nama_gambar_troubleshoot; 
						File::delete($location);
						$temp_id[$jumlah_data] = $row->Troubleshoot_image_ID;
						$jumlah_data++;
					}
					
					$delete_detail = $detail_report_troubleshoot_object::where('Report_troubleshoot_ID','=',$Report_troubleshoot_ID);
					$delete_detail->delete();
					
					foreach($temp_id as $row){
						$delete_image = $troubleshoot_image_object::find($row);
						$delete_image->delete();
					}
					
					$delete_header = $header_report_troubleshoot_object::where('Report_troubleshoot_ID','=',$Report_troubleshoot_ID);
					$delete_header->delete();
					
					Session::put('error_troubleshoot', "Success delete troubleshoot report !");
					return Redirect::to("troubleshoot");
				}
				
			}
		}
		else{
			Session::put('error_login', "You must login !");
			return Redirect::to("login");
		}
	}
	
	public function get_detail_member_report_troubleshoot($Report_troubleshoot_ID){
		if(Session::has('user_login_data')){
			if($Report_troubleshoot_ID == ""){
				return "You don't report Troubleshoot ID";
			}
			else{
				$header_report_troubleshoot_object = new \App\Model\Header_report_troubleshoot();
				
				if(empty($header_report_troubleshoot_object::find($Report_troubleshoot_ID)->Karyawan_ID)){
					return "Report Troubleshoot ID not found!";
				}
				else{
					$data = array(
										'header_report_troubleshoot' => $header_report_troubleshoot_object::find($Report_troubleshoot_ID),
									);
					return View::make('pages.response.detail_member_report_troubleshoot',$data);
				}
				
			}
		}
		else{
			Session::put('error_login', "You must login !");
			return Redirect::to("login");
		}
	}
	
	public function upload_image_troubleshoot_report(){
		$input = Input::all();
		//set validation
		$file = array('image' => Input::file('file'));
		$rules = array('image' => 'required|mimes:jpeg,bmp,png');
		
		$validator = Validator::make($file, $rules);
		if ($validator->fails()) {
			Session::flash('error_troubleshoot', 'File not support!');
			return Redirect::to('update_troubleshoot_report/'.$input['Report_troubleshoot_ID']);
		}
		else {
			// checking file is valid.
			if (Input::file('file')->isValid()) {
				$destinationpath = '/home/miland/public_html/asset/images/project/';
				$extension = Input::file('file')->getClientOriginalExtension();
				$filename = "v2_troubleshoot_image_".$input['Report_troubleshoot_ID']."_".rand(1,99999).'.'.$extension;
				Input::file('file')->move($destinationpath, $filename);
				
				$troubleshoot_image_object = new \App\Model\Troubleshoot_image();
				$troubleshoot_image_object->Nama_gambar_troubleshoot = $filename;
				$troubleshoot_image_object->Status_gambar_troubleshoot = 1;
				$troubleshoot_image_object->save();
				
				$detail_report_troubleshoot_object = new \App\Model\Detail_report_troubleshoot();
				$detail_report_troubleshoot_object->Report_troubleshoot_ID = $input['Report_troubleshoot_ID'];
				$detail_report_troubleshoot_object->Troubleshoot_image_ID = $troubleshoot_image_object->Troubleshoot_image_ID;
				$detail_report_troubleshoot_object->save();
				
				Session::flash('error_troubleshoot', 'Upload successfully'); 
				return Redirect::to('update_troubleshoot_report/'.$input['Report_troubleshoot_ID']);
			}
			else {
				Session::flash('error_troubleshoot', 'uploaded file is not valid');
				return Redirect::to('update_troubleshoot_report/'.$input['Report_troubleshoot_ID']);
			}
		}
	}
}