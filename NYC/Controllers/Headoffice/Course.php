<?php namespace App\Controllers\Headoffice;
use App\Models\Crud_model;
use App\Models\Headoffice\Course_model;


class Course extends BaseController
{


	public function __construct()
	{
		$db = db_connect();
		$this->request = \Config\Services::request();
		$this->session = \Config\Services::session();

		$this->crud = new Crud_model($db);
		$this->course = new Course_model($db);

		//load helper
		helper('custom');
	}

	public function index($type = 0)
	{
		if ($this->request->getMethod() == 'get') {
			$this->data['title'] = 'Course';
			$this->data['courses'] = $this->course->getCourses();
			return view('headoffice/course/course-list', $this->data);
		}
	}	

	public function set_marksheet_fields($id = 0)
	{
		if ($this->request->getMethod() == 'get' && !$this->request->isAjax()) {
			$this->data['title'] = 'Course';
			$this->data['course'] = $course = $this->course->getCourses($id)[0];
			if ($course->has_marksheet == 'No') {
				$this->session->setFlashdata('message', 'This course doesn\'t required a marksheet');
				$this->session->setFlashdata('message_type', 'error');
				return redirect()->to('/head-office/course'); die;
			}
			$this->data['fieldsData'] = $this->crud->select('marksheet_field_management', '', array('course_id' => $id), '', true);
			// pr($this->data['fieldsData']);
			return view('headoffice/course/set-marksheet-fields', $this->data);
		}elseif($this->request->getMethod() == "post"){
			if ($this->request->isAjax() && is_headoffice()) {
				$this->data['success'] = false;
				$this->data['hash'] = csrf_hash();
				$fullmarks = fieldValue('course', 'total_marks', array('id' => $id));
				$totalNumbers = 0;
				if (!empty($this->request->getPost('label_name'))) {
					foreach ($this->request->getPost('label_name') as $key => $label) {
						if (strlen($label) == 0) {
							$this->data['message'] = 'Enter label name';
							error($this->data);
						}else {
							$iden = $this->request->getPost('identifier')[$key];
							if (!empty($this->request->getPost($iden.'subject_name'))) {
								foreach ($this->request->getPost($iden.'subject_name') as $key1 => $sub) {
									if (strlen($sub) == 0) {
										$this->data['message'] = 'Enter subject name';
										error($this->data);
									}
									if (strlen($this->request->getPost($iden.'full_marks')[$key1]) == 0) {
										$this->data['message'] = 'Enter full marks';
										error($this->data);
									}
									if ($this->request->getPost($iden.'full_marks')[$key1] <= 0) {
										$this->data['message'] = 'Please enter valid marks.';
										error($this->data);
									}
									$totalNumbers += $this->request->getPost($iden.'full_marks')[$key1];
								}
							}else {
								$this->data['message'] = "Add fileds under '$label' label";
								error($this->data);
							}
							
							$data['subjects'][$key] = $this->request->getPost($iden.'subject_name');
							$data['marks'][$key] = $this->request->getPost($iden.'full_marks');
						}
					}
					$data['labels'] = $this->request->getPost('label_name');
				}

				if (!empty($this->request->getPost('subject_name'))) {
					foreach ($this->request->getPost('subject_name') as $key => $sub) {
						if (strlen($sub) == 0) {
							$this->data['message'] = 'Enter subject name';
							error($this->data);
						}
						if (strlen($this->request->getPost('full_marks')[$key]) == 0) {
							$this->data['message'] = 'Enter full marks';
							error($this->data);
						}
						if ($this->request->getPost('full_marks')[$key] <= 0) {
							$this->data['message'] = 'Please enter valid marks.';
							error($this->data);
						}
					}
					$totalNumbers += array_sum($this->request->getPost('full_marks'));
					$data['subjects']['subject_name'] = $this->request->getPost('subject_name');
					$data['marks']['full_marks'] = $this->request->getPost('full_marks');
				}
				

				
				if ($totalNumbers > $fullmarks) {
					$this->data['message'] = 'Total of full marks is '.$totalNumbers.', it can\'t be greater than '.$fullmarks;
					error($this->data);
				}
				if ($totalNumbers < $fullmarks) {
					$this->data['message'] = 'Total of full marks is '.$totalNumbers.', it can\'t be less than '.$fullmarks;
					error($this->data);
				}

				$dataArr = array(
					'course_id' => $id,
					'labels' => ((empty($data['labels']))?'':serialize($data['labels'])),
					'subjects' => serialize($data['subjects']),
					'marks' => serialize($data['marks'])
				);
				if (!empty($this->crud->select('marksheet_field_management', '', array('course_id' => $id), '', true))) {
					$dataArr['updated_at'] = strtotime('now');
					if ($this->crud->updateData('marksheet_field_management', array('course_id' => $id), $dataArr)) {
						$this->data['success'] = true;
						$this->data['message'] = 'Marksheet field details has been successfully updated';
						echo json_encode($this->data); die;
					}else{
						$this->data['message'] = 'Something went wrong!';
						echo json_encode($this->data); die;
					}
				}else {
					$dataArr['created_at'] = strtotime('now');

					if ($last_id = $this->crud->add('marksheet_field_management', $dataArr)) {
						$this->data['success'] = true;
						$this->data['message'] = 'Marksheet field details has been successfully added';
						echo json_encode($this->data); die;
					}else{
						$this->data['message'] = 'Something went wrong!';
						echo json_encode($this->data); die;
					}
				}
			}
		}
	}

	public function change_status($id,$val)
	{
		if ($this->request->getMethod() == 'get') {
			if (is_headoffice()) {
				if ($this->crud->updateData('course', array('id' => $id), array('status' => $val))) {
					$this->session->setFlashdata('message', 'Course status has been changed');
					$this->session->setFlashdata('message_type', 'success');
					return redirect()->to('/head-office/course'); die;
				}else {
					$this->session->setFlashdata('message', 'Something went wrong!');
					$this->session->setFlashdata('message_type', 'error');
					return redirect()->to('/head-office/course'); die;
				}
			}
		}else{
			$this->session->setFlashdata('message', 'Something went wrong!');
			$this->session->setFlashdata('message_type', 'error');
			return redirect()->to('/head-office/course'); die;
		}
	}

	function add_course($id = 0)
	{
		if($this->request->getMethod() == "post"){
			if ($this->request->isAjax() && is_headoffice()) {

				$this->data['success'] = false;
				$this->data['hash'] = csrf_hash();
				if (empty($id)) {
					if (strlen($this->request->getPost('course_type')) == 0) {
						$this->data['id'] = '#course_type';
						$this->data['message'] = 'Select course type';
						error($this->data);
					}
				}
				if(strlen($this->request->getPost('course_type')) == 0){
					$this->data['id'] = '#course_type';
					$this->data['message'] = 'Select course type.';
					error($this->data);
				}elseif(strlen($this->request->getPost('course_name')) == 0) {
					$this->data['id'] = '#course_name';
					$this->data['message'] = 'Enter course name';
					error($this->data);
				}elseif (is_duplicate('course', 'course_name', array('course_name' => $this->request->getPost('course_name'), 'id<>' => $id))) {
					$this->data['id'] = '#course_name';
					$this->data['message'] = 'Duplicate course name found';
					error($this->data);
				}
				if (strlen($this->request->getPost('short_name')) == 0) {
					$this->data['id'] = '#short_name';
					$this->data['message'] = 'Enter course short name';
					error($this->data);
				}
				if (empty($this->request->getPost('has_marksheet'))) {
					$this->data['id'] = '#has_marksheet';
					$this->data['message'] = 'Select it has marksheet or not';
					error($this->data);
				}
				if ($this->request->getPost('has_marksheet') == 1) {
					if (strlen($this->request->getPost('total_marks')) == 0) {
						$this->data['id'] = '#total_marks';
						$this->data['message'] = 'Enter total marks';
						error($this->data);
					}
				}
				if (strlen($this->request->getPost('course_code')) == 0) {
					$this->data['id'] = '#course_code';
					$this->data['message'] = 'Enter course code';
					error($this->data);
				}elseif (is_duplicate('course', 'course_code', array('course_code' => $this->request->getPost('course_code'), 'id<>' => $id))) {
					$this->data['id'] = '#course_code';
					$this->data['message'] = 'Duplicate course code found';
					error($this->data);
				}
				if (strlen($this->request->getPost('course_duration')) == 0) {
					$this->data['id'] = '#course_duration';
					$this->data['message'] = 'Enter course duration';
					error($this->data);
				}
				if (strlen($this->request->getPost('course_eligibility')) == 0) {
					$this->data['id'] = '#course_eligibility';
					$this->data['message'] = 'Enter course eligibility';
					error($this->data);
				}
				if (strlen($this->request->getPost('course_details')) == 0) {
					$this->data['id'] = '#course_details';
					$this->data['message'] = 'Enter course details';
					error($this->data);
				}
				$data = $this->request->getPost();
				unset($data['csrf_token_name']);

				if ($id && is_numeric($id)) {

					$data['updated_at'] = strtotime('now');
					//unset($data['course_type']);

					if(!isset($data['typing_test'])){
						$data['typing_test'] = 0;
					}
					
					if ($this->crud->updateData('course', array('id' => $id), $data)) {
						$this->data['success'] = true;
						$this->data['message'] = 'Course details has been successfully updated';
						echo json_encode($this->data); die;
					}else{
						$this->data['message'] = 'Something went wrong!';
						echo json_encode($this->data); die;
					}
				}else{
					$data['added_by'] = $this->session->userData['id'];
					$data['created_at'] = strtotime('now');

					if ($last_id = $this->crud->add('course', $data)) {
						$this->data['success'] = true;
						$this->data['message'] = 'Course details has been successfully added';
						echo json_encode($this->data); die;
					}else{
						$this->data['message'] = 'Something went wrong!';
						echo json_encode($this->data); die;
					}
				}
			}
		}else if($this->request->getMethod() == "get"){
			$this->data['title'] = ($id)?'Edit Course':'Add Course';
			$this->data['courseType'] = $this->crud->select('course_type');
			$this->data['details'] = array();
			$this->data['id'] = ($id)?'/'.$id:'';
			if ($id && is_numeric($id)) {
				$this->data['details'] = $details = $this->crud->select('course', '*', array('id' =>$id), '', true);
				if (empty($details)) {
					$this->session->setFlashdata('message', 'Something went wrong!');
					$this->session->setFlashdata('message_type', 'error');
					return redirect()->to('/head-office/course'); die;
				}
			}
			return view('headoffice/course/add-course', $this->data);
		}
	}
}
