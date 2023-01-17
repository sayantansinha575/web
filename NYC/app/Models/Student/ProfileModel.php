<?php namespace App\Models\Student;

use CodeIgniter\Model;

class ProfileModel extends Model
{
	protected $db;

	public function __construct($db){
		$this->db =& $db;
		$this->builder = $this->db->table('student');		
	}


	function getProfileDetails ($id = 0){
		$this->builder->select("student.*, branch.branch_name, branch.branch_code, branch.branch_email, branch.academy_address, branch.academy_phone");
		$this->builder->join('branch', 'branch.id=student.branch_id', 'left');
		$this->builder->where('student.id', $id);
		$this->builder->where('student.status', 1);
		$this->builder->where('student.is_deleted', 0);
		$data = $this->builder->get()->getRow();
		if (!empty($data)) {
			return $data;
		}
	}

	function addPhoto($data){
		return $this->builder->insert($data);
	}


}
