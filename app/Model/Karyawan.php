<?php 
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends model{

	protected $table = 'karyawan';
	protected $primaryKey = 'Karyawan_ID';
	
	public function jabatan()
	{
		return $this->belongsTo('App\Model\Jabatan', 'Jabatan_ID');
	}	
}
