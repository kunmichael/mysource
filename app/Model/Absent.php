<?php 
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Absent extends model{
	protected $table = 'absensi';
	protected $primaryKey = 'Absensi_ID';
	public function get_rekap_absent()
		return $this->groupBy('Karyawan_ID','Tanggal_absen')
	}
	}
}