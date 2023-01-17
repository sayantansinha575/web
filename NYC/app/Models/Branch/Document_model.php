<?php namespace App\Models\Branch;

use CodeIgniter\Model;

class Document_model extends Model
{
	protected $db;

	public function __construct($db){
		$this->db =& $db;
		$this->builder = $this->db->table('course_study_materials');		
		$this->course = $this->db->table('course');		
		$this->media = $this->db->table('media');		
	}


	function getDocDetails($id = 0, $branchId){
		$this->media->select('media.*, course_study_materials.course_id, course_study_materials.branch_id, course.course_name, course.short_name, branch.branch_name, course_type.course_type as courseTypeName');
        $this->media->join('course_study_materials', 'course_study_materials.id=media.parent_id', 'left');
        $this->media->join('branch', 'branch.id=course_study_materials.branch_id', 'left');
        $this->media->join('course', 'course.id=course_study_materials.course_id', 'left');
        $this->media->join('course_type', 'course_type.id=course_study_materials.course_type', 'left');
		if ($id) {
			$this->media->where('media.id', $id);
		}
		$this->media->where('course_study_materials.added_by', 2);
		$this->media->where('course_study_materials.created_by', $branchId);
		$data = $this->media->get()->getRow();
		if (!empty($data)) {
			return $data;
		}
	}

	function getDocDetailsForView($id = 0, $branchId){
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

	function getActiveCourseIdOfBranch($branchId = 0)
	{
		$ids = array();
		$this->course->select("course.id");
		$this->course->join('course_type ct', 'ct.id=course.course_type', 'left');
		$this->course->join('branch_to_course ctb', 'ctb.course_id=course.id', 'left');
		$this->course->where('ctb.branch_id', $branchId);
		$this->course->where('ctb.status', 1);
		$this->course->where('course.status', 1);
		$this->course->orderBy('course.id','desc');
		$data = $this->course->get()->getResultArray();
		if (!empty($data)) {
			foreach ($data as $dt) {
				$ids[] = $dt['id'];
			}
		}
		return $ids;
	}

	function getMedias($parentIds = array())
	{
		$this->media->select('media.*, csm.added_by, csm.created_by');
		$this->media->join('course_study_materials csm', 'csm.id=media.parent_id', 'left');
		$this->media->whereIn('media.parent_id', $parentIds);
		$data = $this->media->get()->getResult();
		if (!empty($data)) {
			return $data;
		}

	}
}
