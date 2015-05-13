<?php 
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Project extends model{

	protected $table = 'project';
	protected $primaryKey = 'Project_ID';
	
	public function Header_jadwal()
    {
        return $this->hasMany('App\Model\Header_jadwal', 'Project_ID');
    }
}
