<?php 
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Header_report_trainning extends model{
	protected $table = 'header_report_training';
	protected $primaryKey = 'Report_training_ID';

	public function approve(){
		return $this->where('Approval', '=', 1)
					->orderBy('Tanggal_training', 'desc');
	}

	public function need_approval(){
		return $this->where('Approval', '=', 0)
					->orderBy('Tanggal_training', 'desc');
	}
}
