<?php namespace App\Models\Headoffice;

use CodeIgniter\Model;

class Document_model extends Model
{
	protected $db;

	public function __construct($db){
		$this->db =& $db;
		$this->builder = $this->db->table('course_study_materials');		
		$this->media = $this->db->table('media');		
	}


	function getDocDetails($id = 0){
		$this->media->select('media.*, course_study_materials.course_id, course_study_materials.branch_id, course.course_name, course.short_name, branch.branch_name, course_type.course_type as courseTypeName');
        $this->media->join('course_study_materials', 'course_study_materials.id=media.parent_id', 'left');
        $this->media->join('branch', 'branch.id=course_study_materials.branch_id', 'left');
        $this->media->join('course', 'course.id=course_study_materials.course_id', 'left');
        $this->media->join('course_type', 'course_type.id=course_study_materials.course_type', 'left');
		if ($id) {
			$this->media->where('media.id', $id);
		}
		$data = $this->media->get()->getRow();
		if (!empty($data)) {
			return $data;
		}
	}


	function getDocDetailsbyParentId($parentId = 0){
		$this->builder->select('course_study_materials.*, course.course_name, course.short_name, branch.branch_name, course_type.course_type as courseTypeName');
        $this->builder->join('branch', 'branch.id=course_study_materials.branch_id', 'left');
        $this->builder->join('course', 'course.id=course_study_materials.course_id', 'left');
        $this->builder->join('course_type', 'course_type.id=course_study_materials.course_type', 'left');
		if ($parentId) {
			$this->builder->where('course_study_materials.id', $parentId);
		}
		$data = $this->builder->get()->getRow();
		if (!empty($data)) {
			return $data;
		}
	}
}
