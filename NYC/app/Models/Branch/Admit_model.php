<?php namespace App\Models\Branch;

use CodeIgniter\Model;

class Admit_model extends Model
{
	protected $db;

	public function __construct($db){
		$this->db =& $db;
		$this->builder = $this->db->table('admits');		
		$this->adm = $this->db->table('admission');		
	}


	function getDetailsToApply($enrollNo = 0, $branchId = 0){
		$this->adm->select('admission.id, admission.enrollment_number, admission.registration_number, admission.student_name, admission.course_name as courseId, admission.course_code, admission.student_photo, course.short_name, course.course_name as courseName, branch.branch_code');
		$this->adm->join('course', 'course.id=admission.course_name', 'left');
		$this->adm->join('branch', 'branch.id=admission.branch_id', 'left');
		$this->adm->where('admission.enrollment_number', $enrollNo);
		if (!empty($branchId)) {
			$this->adm->where('admission.branch_id', $branchId);
		}
		$this->adm->where('admission.is_deleted', 0);
		$this->adm->groupBy('admission.id');
		$data = $this->adm->get()->getRow();
		if (!empty($data)) {
			return $data;
		}
	}
}
