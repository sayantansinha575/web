<?php namespace App\Models\Student;

use CodeIgniter\Model;

class AdmissionModel extends Model
{
	protected $db;

	public function __construct($db){
		$this->db =& $db;
		$this->builder = $this->db->table('admission');
		$this->pay = $this->db->table('payment');
		$this->csm = $this->db->table('course_study_materials');
	}


	function getadmissionList($registrationNumber = ''){
		$this->builder->select("admission.*, branch.branch_name as branchName, course.course_name as courseName, course_type.course_type as courseTypeName");
		$this->builder->join('branch', 'branch.id=admission.branch_id', 'left');
		$this->builder->join('course', 'course.id=admission.course_name', 'left');
		$this->builder->join('course_type', 'course_type.id=admission.course_type', 'left');
		$this->builder->where('admission.registration_number', $registrationNumber);
		$this->builder->where('admission.is_deleted', 0);
		$data = $this->builder->get()->getResult();
		if (!empty($data)) {
			return $data;
		}
	}

	function getadmissionListById($id = '', $registrationNumber = ''){
		$this->builder->select("admission.*, branch.branch_name as branchName, branch.branch_code as branchCode, course.course_name as courseName, course.has_marksheet, course_type.course_type as courseTypeName, certificates.certificate_file, marksheets.marksheet_file");
		$this->builder->join('branch', 'branch.id=admission.branch_id', 'left');
		$this->builder->join('course', 'course.id=admission.course_name', 'left');
		$this->builder->join('course_type', 'course_type.id=admission.course_type', 'left');
		$this->builder->join('certificates', 'certificates.enrollment_number=admission.enrollment_number', 'left');
		$this->builder->join('marksheets', 'marksheets.enrollment_number=admission.enrollment_number', 'left');
		$this->builder->where('admission.id', $id);
		$this->builder->where('admission.registration_number', $registrationNumber);
		$this->builder->where('admission.is_deleted', 0);
		$data = $this->builder->get()->getRow();
		if (!empty($data)) {
			return $data;
		}
	}

	function getPaymentListByEnrNo($enrollmentNumber = ''){
		$this->pay->select('payment.*, adm.student_name, adm.registration_number');
		$this->pay->join('admission adm', 'adm.id=payment.admission_id');
		$this->pay->where('adm.enrollment_number', $enrollmentNumber);
		$this->pay->orderBy('payment.id', 'desc');
		$this->pay->groupBy('payment.id');
		$data = $this->pay->get()->getResult();
		if (!empty($data)) {
			return $data;
		}else {
			return false;
		}
	}

	function getStudyMaterialsByCourseId($courseId = 0, $registrationNumber = 0, $branchId=0){
		$this->csm->select('course_study_materials.*, course.course_name, course.short_name, course.course_code, media.id meddiaId, media.documents, media.description');
		$this->csm->join('media', 'media.parent_id=course_study_materials.id','left');
		$this->csm->join('course', 'course.id=course_study_materials.course_id', 'left');
		$this->csm->join('admission', 'admission.course_name=course.id', 'left');
		if (!empty($courseId)) {
			$this->csm->where('course_study_materials.course_id', $courseId);
		}
		$this->csm->where('admission.registration_number', $registrationNumber);

        $this->csm->groupStart();
        $this->csm->where('course_study_materials.added_by', 1);
        $this->csm->orWhere("course_study_materials.added_by=2 AND course_study_materials.created_by=$branchId");
        $this->csm->groupEnd();

		$this->csm->where('media.type', 1);
		$this->csm->orderBy('media.id', 'desc');
		$data = $this->csm->get()->getResult();
		if (!empty($data)) {
			return $data;
		}else {
			return false;
		}
	}

}
 