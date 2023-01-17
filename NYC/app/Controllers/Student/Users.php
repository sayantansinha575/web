<?php namespace App\Controllers\Student;

use App\Models\Headoffice\Users_model;
use App\Models\Student\ProfileModel;

class Users extends BaseController
{


	public function __construct()
	{
		$db = db_connect();
		$this->user = new Users_model($db);
		$this->student = new ProfileModel($db);
	}

	public function change_password($id = 0)
	{
		$this->data['success'] = false;
		$this->data['hash'] = csrf_hash();
		$id =  decrypt($id);
		if ($this->request->isAjax()) {
			if (isset($id) && is_numeric($id) && is_student()) {
				if (strlen($this->request->getPost('password')) == 0 ) {
					$this->data['message'] = 'Enter Password';
					echo json_encode($this->data); die;
				}
				if (strlen($this->request->getPost('confirm_pwd')) == 0 ) {
					$this->data['message'] = 'Enter Confirm Password';
					echo json_encode($this->data); die;
				}
				if ($this->request->getPost('password') != $this->request->getPost('confirm_pwd')) {
					$this->data['message'] = "Password confirmation doesn't match Password";
					echo json_encode($this->data); die;
				}

				$data = array(
					'password' => password_hash($this->request->getPost('confirm_pwd'), PASSWORD_DEFAULT),
				);
				if ($this->crud->updateData('student', array('id' => $id), $data)) {
					$this->data['success'] = true;
					$this->data['message'] = 'Password has been changed successfully';
					echo json_encode($this->data); die;
				}else{
					$this->data['message'] = 'Something went wrong!';
					echo json_encode($this->data); die;
				}
			}else{
				$this->data['message'] = 'Something went wrong!';
				echo json_encode($this->data); die;
			}
		}else{
			$this->data['message'] = 'Something went wrong!';
			echo json_encode($this->data); die;
		}
	}

	function save_cv()
	{
		
		if ($this->request->getMethod() === 'post'){

			$rules = [
				
				'file'           => ['label' => 'User image', 'rules' => 'ext_in[file,png,jpg,jpeg]|max_size[file,2048]'],
			];
			if ($this->validate($rules)) {
				$insert_data = array();
				$img = $this->request->getFile('file');
				$img->move('upload/cv');
				$insert_data['cv'] = base64_encode($img->getName());				
				if($this->student->addPhoto($insert_data)){
				   $this->session->setFlashdata('success', 'Photo added successfully.');
				}
				
			}else{
			
			}
		}
		return view('student/include/sidebar',$insert_data);
	} 
}
