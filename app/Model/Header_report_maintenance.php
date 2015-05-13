<?php 
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Header_report_maintenance extends model{
	protected $table = 'header_report_maintenance';
	protected $primaryKey = 'Report_maintenance_ID';

	public function approve(){
		return $this->where('Approval', '=', 1)
					->orderBy('Tanggal_pekerjaan', 'desc');
	}

	public function need_approval(){
		return $this->where('Approval', '=', 0)
					->orderBy('Tanggal_pekerjaan', 'desc');
	}

}
