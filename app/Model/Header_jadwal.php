<?php 
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Header_jadwal extends model{
	protected $table = 'header_jadwal';
	protected $primaryKey = 'Jadwal_ID';
	
	public function project()
	{
		return $this->belongsTo('App\Model\Project', 'Project_ID');
	}

	public function complete(){
		return $this->where('Laporan_selesai', '=', 1)
					->orderBy('Tanggal_jadwal', 'desc');
	}

	public function no_report(){
		return $this->whereRaw('Tanggal_jadwal < CURDATE()')
					->where('Laporan_selesai', '=', 0)
					->orderBy('Tanggal_jadwal', 'desc');
	}

	public function upcoming(){
		return $this->whereRaw('Tanggal_jadwal > CURDATE()')
					->orderBy('Tanggal_jadwal', 'desc');
	}
}
