<?php 
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Header_report_instalation extends model{
	protected $table = 'header_report_instalasi';
	protected $primaryKey = 'Report_instalasi_ID';

	public function approve(){
		return $this->where('Approval', '=', 1)
					->orderBy('Tanggal_pekerjaan', 'desc');
	}

	public function need_approval(){
		return $this->where('Approval', '=', 0)
					->orderBy('Tanggal_pekerjaan', 'desc');
	}
}
