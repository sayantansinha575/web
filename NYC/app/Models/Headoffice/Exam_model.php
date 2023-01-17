<?php namespace App\Models\Headoffice;

use CodeIgniter\Model;

class Exam_model extends Model
{
	protected $db;

	public function __construct($db){
		$this->db =& $db;
		$this->builder = $this->db->table('course');		
		$this->exam = $this->db->table('exam_setup');		
	}


	function getCourses($id = 0){
		$this->builder->select("course.*, ct.course_type as course_type_name");
		$this->builder->join('course_type as ct', 'ct.id=course.course_type', 'left');
		$this->builder->orderBy('course.id','desc');
		if ($id) {
			$this->builder->where('course.id', $id);
		}
		$this->builder->orderBy('course.id', 'desc');
		$data = $this->builder->get()->getResultArray();
		if (!empty($data)) {
			return $data;
		}
	}
	public function getExamPaperList($id =0){
		$this->exam->select('*');
      $this->exam->where('course_id', $id);
		$data = $this->exam->get()->getResult();
		return $data;
	}
	public function getCoursePaperById($id =0){
		$this->exam->select('*');
      	$this->exam->where('id', $id);
		$data = $this->exam->get()->getRow();
		return $data;
	}
}
