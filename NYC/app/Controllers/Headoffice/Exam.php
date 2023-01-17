<?php namespace App\Controllers\Headoffice;
use App\Models\Crud_model;
use App\Models\Headoffice\Exam_model;


class Exam extends BaseController
{


	public function __construct()
	{
		$db = db_connect();
		$this->request = \Config\Services::request();
		$this->session = \Config\Services::session();

		$this->crud = new Crud_model($db);
		$this->course = new Exam_model($db);

		//load helper
		helper('custom');
	}


	public function set_exam_paper($id = 0, $id2 = 0)
	{

		if ($this->request->getMethod() == 'get') {
			$this->data['title'] = 'Exam Paper management';
			$this->data['course_id'] = $id;
			$this->data['courses'] =$courses= $this->course->getCourses();
			$this->data['courses'] = $courses;
			$this->data['examList'] = $this->course->getExamPaperList($id);
			$this->data['details'] = $this->course->getCoursePaperById($id2);
			return view('headoffice/exam/manage-exam-paper', $this->data);
		}
	}

	function save_exam($id=0,$id2 = 0)
	{
		if($this->request->getMethod() == "post"){
			if ($this->request->isAjax() && is_headoffice()) {

				$this->data['success'] = false;
				$this->data['hash'] = csrf_hash();
				if (empty($this->request->getPost('id'))) {
					if (strlen($this->request->getPost('paper_name')) == 0) {
						$this->data['id'] = '#paper_name';
						$this->data['message'] = 'Enter paper name';
						error($this->data);
					}
				}
				if(strlen($this->request->getPost('total_question')) == 0){
					$this->data['id'] = '#total_question';
					$this->data['message'] = 'Enter total question.';
					error($this->data);
				}
				elseif(strlen($this->request->getPost('mark_each_question')) == 0) {
					$this->data['id'] = '#mark_each_question';
					$this->data['message'] = 'Enter marks';
					error($this->data);
				}
				if (strlen($this->request->getPost('total_time')) == 0) {
					$this->data['id'] = '#total_time';
					$this->data['message'] = 'Enter time';
					error($this->data);
				}
				$data = $this->request->getPost();
				unset($data['csrf_token_name']);
				$data['ts']=time();

				if (!empty($this->request->getPost('id')) && is_numeric($this->request->getPost('id'))) {

					//$data['updated_at'] = strtotime('now');
					//unset($data['course_type']);				
					
					if ($this->crud->updateData('exam_setup', array('id' => $this->request->getPost('id')), $data)) {
						$this->data['success'] = true;
						$this->data['message'] = 'Exam details has been successfully updated';
						echo json_encode($this->data); die;
					}else{
						$this->data['message'] = 'Something went wrong!';
						echo json_encode($this->data); die;
					}
				}else{
					//$data['added_by'] = $this->session->userData['id'];
					//$data['created_at'] = strtotime('now');

					if ($last_id = $this->crud->add('exam_setup', $data)) {
						$this->data['success'] = true;
						$this->data['message'] = 'Exam details has been successfully added';
						echo json_encode($this->data); die;
					}else{
						$this->data['message'] = 'Something went wrong!';
						echo json_encode($this->data); die;
					}
				}
			}
		}else {
			
		
			return view('headoffice/exam/manage-exam-paper', $this->data);
		}
	}

	public function delete_exam_paper($id2='')
	{
		if (($this->request->getMethod() == "post") && $this->request->isAjax()) {

			$this->data['success'] = false;
			$this->data['hash'] = csrf_hash();			 

			if ($this->crud->deleteData('exam_setup', ['id' => $this->request->getPost('paper_id')])) {
				$this->data['success'] = true;
				$this->data['message'] = 'Exam paper has been succesfully deleted';
				echo json_encode($this->data);
			}
			else {
				$this->data['message'] = 'Something went wrong!';
				error($this->data);
			}                

		}
	}

	public function change_status($id,$val,$course_id='')
	{
		if ($this->request->getMethod() == 'get') {
			$this->data['course_id'] = $course_id;
			//print_r($course_id);die();
			if (is_headoffice()) {
				if ($this->crud->updateData('exam_setup', array('id' => $id), array('status' => $val))) {
					$this->session->setFlashdata('message', 'Paper status has been changed');
					$this->session->setFlashdata('message_type', 'success');
					return redirect()->to('/head-office/exam/'.$course_id); die;
				}else {
					$this->session->setFlashdata('message', 'Something went wrong!');
					$this->session->setFlashdata('message_type', 'error');
					return redirect()->to('/head-office/exam'); die;
				}
			}
		}else{
			$this->session->setFlashdata('message', 'Something went wrong!');
			$this->session->setFlashdata('message_type', 'error');
			return redirect()->to('/head-office/exam'); die;
		}
	}



	

	
}
