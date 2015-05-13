<?php 
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Absent extends model{
	protected $table = 'absensi';
	protected $primaryKey = 'Absensi_ID';
	public function get_rekap_absent()	{
		return $this->groupBy('Karyawan_ID','Tanggal_absen')					->select(array('Karyawan_ID', DB::raw('MIN(Waktu_masuk) as Waktu_masuk'), DB::raw('MAX(Waktu_pulang) as Waktu_pulang'), 'Tanggal_absen'))					->orderBy('Tanggal_absen', 'DESC');			
	}		public function download_excel_absent(){		return $this->groupBy('Karyawan_ID','Tanggal_absen')					->select(array('Karyawan_ID', DB::raw('MIN(Waktu_masuk) as Waktu_masuk'), DB::raw('MAX(Waktu_pulang) as Waktu_pulang'), DB::raw('DAY(Tanggal_absen) as Tanggal_absent')))					->orderBy('Karyawan_ID', 'ASC');	
	}
}
