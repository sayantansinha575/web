<?php namespace App\Models\Branch;

use CodeIgniter\Model;

class Certificate_model extends Model
{
	protected $db;

	public function __construct($db){
		$this->db =& $db;
		$this->builder = $this->db->table('student');		
		$this->course = $this->db->table('course');		
		$this->adm = $this->db->table('admission');		
	}


	function getDetailsToApply($enrollNo = 0, $branchId = 0){
		$this->adm->select('admission.*, pay.course_fees, pay.discount, pay.amount, mfm.subjects, mfm.marks, course.short_name, course.course_name as courseName, course.total_marks as totalMarks, branch.branch_name, course.typing_test');
		$this->adm->join('payment pay', 'pay.admission_id=admission.id', 'left');
		$this->adm->join('marksheet_field_management mfm', 'mfm.course_id=admission.course_name', 'left');
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
