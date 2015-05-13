<?php 
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends model{

	protected $table = 'jabatan';
	protected $primaryKey = 'Jabatan_ID';
	
	public function karyawan()
    {
        return $this->hasMany('App\Model\Karyawan', 'Jabatan_ID');
    }
}
