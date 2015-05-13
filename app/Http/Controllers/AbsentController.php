<?php
namespace App\Http\Controllers;

use Validator, Input, Redirect, Session, View, Auth, Request, DB, Excel, Str; 
use Carbon\Carbon;

class AbsentController extends Controller {

	public function __construct()
	{
		$this->middleware('guest');
	}

	public function index()
	{
		//check apakah ada session mengenai data user
		if(Session::has('user_login_data')){
			//create object Project
			$project_object = new \App\Model\Project();
			$absent_object = new \App\Model\Absent();
			$exploded_date = explode('-',Carbon::now('Asia/Jakarta')->toDateString());
			$array = array($exploded_date[2],$exploded_date[1],$exploded_date[0]);
			$today_date = implode('-',$array);

			$data = array(
								'data_project' => $project_object::orderBy('Tanggal_mulai', 'desc')->get(),
								'data_absent_json' => $absent_object::where('Tanggal_absen','=',Carbon::now('Asia/Jakarta')->toDateString())->where('Karyawan_ID','=',Session::get('user_login_data')->Karyawan_ID)->get()->toJson(),
								'today_date' => $today_date,
							);
			return View::make('pages.absent', $data);
		}
		else{
			Session::put('error_login', "You must login !");
			return Redirect::to("login");
		}
	}
	
	public function add_absent_manual(){
		//set validation
		$validator = Validator::make(
		Input::all(),
		array(
		    "Waktu_datang_text"	=> "required|min:3",
		)
		);
		
		if($validator->passes())
		{
			$input = Input::all();
			//check lokasi
			if($input['location_text'] == "other"){
				$location = $input['other_location'];
			}
			else{
				$location = $input['location_text'];
			}

			//check keterangan
			if($input['keterangan_text'] == ""){
				$keterangan = "-";
			}
			else{
				$keterangan = $input['keterangan_text'];
			}
			
			//check keterangan pulang
			if($input['keterangan_pulang_text'] == ""){
				$keterangan_pulang = "-";
			}
			else{
				$keterangan_pulang = $input['keterangan_pulang_text'];
			}
			
			//check waktu pulang
			if($input['Waktu_pulang_text'] == ""){
				$waktu_pulang = "00:00:00";
			}
			else{
				$waktu_pulang = $input['Waktu_pulang_text'];
			}
			$absent = new \App\Model\Absent();
			$absent->Karyawan_ID = $input['karyawan_id_text'];
			$absent->Tipe_absen = $input['absen_type_text'];
			$absent->Lokasi = $location;
			$absent->Tanggal_absen = $input['tanggal_jadwal_text'];
			$absent->Waktu_masuk = $input['Waktu_datang_text'];
			$absent->Waktu_pulang = $waktu_pulang;
			$absent->Keterangan = $keterangan;
			$absent->Keterangan_pulang = $keterangan_pulang;
			$absent->Insert_by = "Web";
			$absent->Approve = 1;
			$absent->Data_absensi = 1;
			$absent->save();

			Session::put('error_absent', "Success add absent !");
			return Redirect::to('data_absent');
		}
		else{
			Session::put('error_absent', "Waktu datang must be filled !");
			return Redirect::to('data_absent');
		}
	}

	public function data_absent()
	{
		//check apakah ada session mengenai data user
		if(Session::has('user_login_data')){
			if(Session::get('user_login_data')->Jabatan_ID != 1 && Session::get('user_login_data')->Jabatan_ID != 4 && Session::get('user_login_data')->Jabatan_ID != 5){
				Session::put('error_home', "You dont have access !");
				return Redirect::to("home");
			}
			else{
				$absent_object = new \App\Model\Absent();
				$karyawan_object = new \App\Model\Karyawan();
				$project_object = new \App\Model\Project();
				$absents = $absent_object::where('Data_absensi','=','1')->orderBy('Tanggal_absen', 'desc')->get();
				$karyawans = $karyawan_object::all();
				$projects = $project_object::orderBy('Tanggal_mulai', 'desc')->get();
				$data = array(
									'absents' => $absents,
									'karyawans' => $karyawans,
									'projects' => $projects,
								);
				return View::make('pages.data_absent',$data);
			}
			
			
		}
		else{
			Session::put('error_login', "You must login !");
			return Redirect::to("login");
		}
	}
	
	public function get_edit_absent($id){
		if(Session::has('user_login_data')){
				$absent_object = new \App\Model\Absent();
				$project_object = new \App\Model\Project();
				$data = array(
									'absents' => $absent_object::find($id),
									'data_project' => $project_object::orderBy('Tanggal_mulai', 'desc')->get(),
								);
				return View::make('pages.response.edit_absent',$data);
		}
		else{
			Session::put('error_login', "You must login !");
			return Redirect::to("login");
		}
	}

	public function add_absent(){
		//check apakah ada session mengenai data user
		$input = Input::all();

		//check lokasi
		if($input['location_text'] == "other"){
			$location = $input['other_location'];
		}
		else{
			$location = $input['location_text'];
		}

		//check keterangan
		if($input['keterangan_text'] == ""){
			$keterangan = "-";
		}
		else{
			$keterangan = $input['keterangan_text'];
		}
		$absent = new \App\Model\Absent();
		$absent->Karyawan_ID = Session::get('user_login_data')->Karyawan_ID;
		$absent->Tipe_absen = input::get('absen_type_text');
		$absent->Lokasi = $location;
		if(!empty($input['latitude_text'])){
			$absent->Geo_location = $input['latitude_text']."=".$input['longitude_text'];
		}
		$absent->Tanggal_absen = Carbon::now('Asia/Jakarta')->toDateString();
		$absent->Waktu_masuk = Carbon::now('Asia/Jakarta')->toTimeString();
		$absent->Waktu_pulang = "00:00:00";
		$absent->Keterangan = $keterangan;
		$absent->Keterangan_pulang = "-";
		$absent->Insert_by = "Web";
		$absent->Approve = 1;
		$absent->Data_absensi = 1;
		$absent->save();

		Session::put('error_absen', "Success Absen !");
		return Redirect::to('absent');
	}
	
	public function edit_absent(){
		//set validation
		$validator = Validator::make(
		Input::all(),
		array(
		    "lokasi_text"	=> "required|min:3",
		    "Waktu_datang_text"	=> "required|min:3",
		    "Waktu_pulang_text"	=> "required|min:3",
		)
		);
		
		if($validator->passes())
		{			
			$input = Input::all();
			$absent = new \App\Model\Absent();
			if($input['keterangan_text'] == "" || $input['keterangan_text'] == "-"){
				$keterangan = "-";
			}
			else{
				$keterangan = $input['keterangan_text'];
			}
			
			if($input['keterangan_pulang_text'] == "" || $input['keterangan_pulang_text'] == "-"){
				$keterangan_pulang = "-";
			}
			else{
				$keterangan_pulang = $input['keterangan_pulang_text'];
			}
			
			$update_absent = $absent::find($input['Absensi_ID']);
			$update_absent->Lokasi = $input['lokasi_text'];
			$update_absent->Tipe_absen = $input['absen_type_text'];
			$update_absent->Waktu_masuk = $input['Waktu_datang_text'];
			$update_absent->Waktu_pulang = $input['Waktu_pulang_text'];
			$update_absent->Keterangan = $keterangan;
			$update_absent->Keterangan_pulang = $keterangan_pulang;
			$update_absent->save();
			Session::put('error_absent', "Success update absen !");
			return Redirect::to('data_absent');
		}
		else
		{
			Session::put('error_absent', "Failed update absen !");
			return Redirect::to('data_absent');
		}
	}

	public function update_absent($id){
		$absent = new \App\Model\Absent();
		$update_absent = $absent::find($id);
		$update_absent->Waktu_pulang = Carbon::now('Asia/Jakarta')->toTimeString();
		$update_absent->save();
		Session::put('error_absen', "Success Absen Pulang !");
		return Redirect::to('absent');
	}
	
	public function delete_absent($id){
		$absent = new \App\Model\Absent();
		$delete_absent = $absent::find($id);
		$delete_absent->delete();
		Session::put('error_absent', "Success delete absent !");
		return Redirect::to('data_absent');
	}

	public function rekap_absent(){
		//check apakah ada session mengenai data user
		if(Session::has('user_login_data')){
			if(Session::get('user_login_data')->Jabatan_ID != 1 && Session::get('user_login_data')->Jabatan_ID != 4 && Session::get('user_login_data')->Jabatan_ID != 5){
				Session::put('error_home', "You dont have access !");
				return Redirect::to("home");
			}
			else{
				$absent_object = new \App\Model\Absent();
				$input = Input::all();
				$datetime_now = Carbon::now('Asia/Jakarta');
				if(empty($input['month_text']))
				{
					$year = $datetime_now->year;
					$month = $datetime_now->month;
					$absents = $absent_object->get_rekap_absent()->whereRaw('YEAR(Tanggal_absen) = ? AND MONTH(Tanggal_absen) = ?', array($datetime_now->year,$datetime_now->month))->get();
				}
				else{
					$year = $input['year_text'];
					$month = $input['month_text'];
					$absents = $absent_object->get_rekap_absent()->whereRaw('YEAR(Tanggal_absen) = ? AND MONTH(Tanggal_absen) = ?', array($input['year_text'],$input['month_text']))->get();
				}

				$data = array(
								'years' 	=> $year,
								'months' 	=> $month,
								'absents' 	=> $absents,
							);
				return View::make('pages.rekap_absent',$data);
			}
		}
		else{
			Session::put('error_login', "You must login !");
			return Redirect::to("login");
		}
	}
	
	public function export_xls_absent(){
		$data = array(
					'month' 	=> Request::input('month_text'),
					'year'		=> Request::input('year_text') 
				);		
		Excel::create('import absen', function($excel) use($data){
			$excel->sheet('Absen', function($sheet) use($data){
				$absent_object = new \App\Model\Absent();
				$karyawan_object = new \App\Model\Karyawan();
				$absents = $absent_object->download_excel_absent()->whereRaw('YEAR(Tanggal_absen) = ? AND MONTH(Tanggal_absen) = ?', array($data['year'],$data['month']))->get();
				$column_name = array("D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "AA", "AB", "AC", "AD", "AE", "AF", "AG", "AH");
				$start_tanggal = 1;
				
				$sheet->setMergeColumn(array(
					'columns' => array('A','B','C'),
					'rows' => array(array(1,3))
				));
				
				$sheet->cell('A1','No');
				$sheet->setWidth('A', 5);
				$sheet->cell('B1','Nama');
				$sheet->setWidth('B', 40);
				$sheet->cell('C1','Keterangan');
				$sheet->setWidth('C', 20);
				$sheet->row(1, function($row) {
					// call cell manipulation methods
					$row->setFont(array(
						'family'     => 'Calibri',
						'size'       => '12',
						'bold'       =>  true
					));
					$row->setValignment('bottom');
					$row->setAlignment('center');
				});
				
				$sheet->mergeCells('D1:AH1');
				$sheet->mergeCells('D2:AH2');
				
				//membuat tanggal 1 - 31 pada excel
				foreach($column_name as $row){
					$sheet->cell($row."3",function($cell) use($start_tanggal){
						$cell->setValue($start_tanggal);
						$cell->setAlignment('center');
					});
					$start_tanggal++;
				}
				
				//untuk margin setiap row
				$merge_cell;
				for($i=2;$i<100;$i+=2){
					$merge_cell[$i-2] = array($i, $i+1);
				}
				
				$sheet->setMergeColumn(array(
					'columns' => array('A','B'),
					'rows' => $merge_cell
				));
				
				
				$sheet->cell('D1', function($cell) use($data){
					$month_MM = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
					$cell->setValue('ABSENSI BULAN '.Str::upper($month_MM[$data['month']-1])." ".$data['year']);
					$cell->setAlignment('center');
					$cell->setFont(array(
						'family'     => 'Calibri',
						'size'       => '12',
						'bold'       =>  true
					));
				});
				
				$sheet->cell('D2', function($cell) {
					$cell->setValue("Tanggal");
					$cell->setAlignment('center');
					$cell->setFont(array(
						'family'     => 'Calibri',
						'size'       => '12',
						'bold'       =>  true
					));
				});
				
				$nomor=1;
				$start_row =4;
				$next_start_row = $start_row+1;
				$karyawan_id_before = 0;
				foreach($absents as $row){
					if($karyawan_id_before == 0 ){
						$sheet->cell('A'.$start_row, $nomor);
						$sheet->cell('B'.$start_row, $karyawan_object::find($row->Karyawan_ID)->Nama_karyawan);
						$sheet->cell('C'.$start_row, "Waktu Masuk");
						$sheet->cell('C'.($start_row+1), "Waktu Pulang");
					}
					else{
						if($karyawan_id_before != $row->Karyawan_ID){
							$start_row += 2;
							$nomor++;
							$sheet->cell('A'.$start_row, $nomor);
							$sheet->cell('B'.$start_row, $karyawan_object::find($row->Karyawan_ID)->Nama_karyawan);
							$sheet->cell('C'.$start_row, "Waktu Masuk");
							$sheet->cell('C'.($start_row+1), "Waktu Pulang");
						}
					}

					$sheet->cell($column_name[$row->Tanggal_absent-1].$start_row, $row->Waktu_masuk);
					$sheet->cell($column_name[$row->Tanggal_absent-1].($start_row+1), $row->Waktu_pulang);
					$karyawan_id_before = $row->Karyawan_ID;
				}
				
			
			});
		})->export(Request::input('file_text'));
	}
}

