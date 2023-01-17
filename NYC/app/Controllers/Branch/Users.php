<?php namespace App\Controllers\Branch;


class Users extends BaseController
{


	public function change_password($id = 0)
	{
		$this->data['success'] = false;
		$this->data['hash'] = csrf_hash();
		$id =  decrypt($id);
		if ($this->request->isAjax()) {
			if (is_numeric($id) && is_branch()) {
				if (strlen($this->request->getPost('password')) == 0 ) {
					$this->data['message'] = 'Enter Password';
					echo json_encode($this->data); die;
				} elseif (!checkPwdStrength($this->request->getPost('password'))) {
					$this->data['id'] = '#password';
					$this->data['message'] = 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
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
					'visible_pwd' => $this->request->getPost('confirm_pwd'),
				);
				if ($this->crud->updateData('branch', array('id' => $id), $data)) {
					$this->data['success'] = true;
					$this->data['message'] = 'Password has been changed successfully';
					echo json_encode($this->data); die;
				}else{
					$this->data['message'] = 'Something went wrong_1!';
					echo json_encode($this->data); die;
				}
			}else{
				$this->data['message'] = 'Something went wrong-1!';
				echo json_encode($this->data); die;
			}
		}else{
			$this->data['message'] = 'Something went wrong1!';
			echo json_encode($this->data); die;
		}
	}
}
