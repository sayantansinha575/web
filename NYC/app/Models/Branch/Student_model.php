<?php namespace App\Models\Branch;

use CodeIgniter\Model;

class Student_model extends Model
{
	protected $db;

	public function __construct($db){
		$this->db =& $db;
		$this->builder = $this->db->table('student');		
		$this->course = $this->db->table('course');		
		$this->adm = $this->db->table('admission');		
	}


	function GetCoursesByType($type = 0, $branchId = 0){
		$this->course->select("course.*");
		$this->course->join('course_type ct', 'ct.id=course.course_type', 'left');
		$this->course->join('branch_to_course ctb', 'ctb.course_id=course.id', 'left');
		$this->course->where('course.course_type', $type);
		$this->course->where('ctb.branch_id', $branchId);
		$this->course->where('ctb.status', 1);
		$this->course->where('course.status', 1);
		$this->course->orderBy('course.id','desc');
		$data = $this->course->get()->getResult();
		if (!empty($data)) {
			return $data;
		}
	}

	function GetCoursesByID($id = 0, $branchId = 0){
		$this->course->select("course.course_code, course.course_duration, course.course_eligibility, course.created_at, ctb.course_fees as modCourseFees");
		$this->course->join('course_type ct', 'ct.id=course.course_type', 'left');
		$this->course->join('branch_to_course ctb', 'ctb.course_id=course.id', 'left');
		$this->course->where('course.id', $id);
		$this->course->where('ctb.branch_id', $branchId);
		$this->course->where('ctb.status', 1);
		$this->course->where('course.status', 1);
		$this->course->orderBy('course.id','desc');
		$data = $this->course->get()->getRow();
		if (!empty($data)) {
			return $data;
		}
	}

	public function getAdmissionDetailsById($id = 0, $branchId = 0)
	{
		if ($id && is_numeric($id)) {
			$this->adm->select('admission.*, pay.course_fees, pay.discount, pay.amount');
			$this->adm->join('payment pay', 'pay.admission_id=admission.id', 'left');
			$this->adm->where('admission.id', $id);
			if (!empty($branchId)) {
				$this->adm->where('admission.branch_id', $branchId);
			}
			$data = $this->adm->get()->getRow();
			return $data;
		}else {
			return false;
		}
	}

	public function getAdmissionDetails($id = 0, $branchId = 0)
	{
		if ($id && is_numeric($id)) {
			$this->adm->select("admission.*, branch.branch_name as branchName, branch.branch_code as branchCode, course.course_name as courseName, course.has_marksheet, course_type.course_type as courseTypeName, certificates.certificate_file, marksheets.marksheet_file");
			$this->adm->join('branch', 'branch.id=admission.branch_id', 'left');
			$this->adm->join('course', 'course.id=admission.course_name', 'left');
			$this->adm->join('course_type', 'course_type.id=admission.course_type', 'left');
			$this->adm->join('certificates', 'certificates.enrollment_number=admission.enrollment_number', 'left');
			$this->adm->join('marksheets', 'marksheets.enrollment_number=admission.enrollment_number', 'left');
			$this->adm->where('admission.id', $id);
			$this->adm->where('admission.is_deleted', 0);
			if (!empty($branchId)) {
				$this->adm->where('admission.branch_id', $branchId);
			}
			$data = $this->adm->get()->getRow();
			return $data;
		}else {
			return false;
		}
	}

	public function isPartOfAnyActiveCourse($regNo = '', $branchId = 0)
	{
		$this->adm->select('status');
		$this->adm->where('registration_number', $regNo);
		$this->adm->where('branch_id', $branchId);
		$this->adm->where('is_deleted', 0);
		$this->adm->where('status', 1);
		$count = $this->adm->countAllResults();
		if ($count == 0) {
			return true;
		}else {
			return false;
		}
	}
}
