<?php namespace App\Models\Student;

use CodeIgniter\Model;

class PaymentModel extends Model
{
	protected $db;

	public function __construct($db){
		$this->db =& $db;
		$this->builder = $this->db->table('payment');		
		$this->adm = $this->db->table('admission');		
	}


	function getEnlistedCourseList ($regNo = 0){
		$this->adm->select("admission.course_name, admission.course_code, course.course_name as courseName, course.has_marksheet, admission.enrollment_number, admission.id as AdmissionId");
		$this->adm->join('course', 'course.id=admission.course_name', 'left');
		$this->adm->where('admission.registration_number', $regNo);
		$data = $this->adm->get()->getResult();
		if (!empty($data)) {
			return $data;
		}
	}
}
