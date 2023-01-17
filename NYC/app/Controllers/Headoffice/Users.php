<?php namespace App\Controllers\Headoffice;

use App\Models\Headoffice\Users_model;

class Users extends BaseController
{


	public function __construct()
	{
		$db = db_connect();
		$this->user = new Users_model($db);
		$this->request = \Config\Services::request();
		$this->session = \Config\Services::session();

		//load helper
		helper('custom');
	}

	public function get_user_by_id($id = 0)
	{
		if ($id != 0 && is_numeric($id)) {
			$this->data['title'] = 'Edit User';
			$this->data['details'] = $details = $this->user->getUserById($id);
			if (!empty($details)) {
				if ($details->group_id == 1) {

				}elseif ($details->group_id == 2) {
					$this->data['rms'] = $this->user->getAllRm();
					$this->data['introducers'] = $this->user->getActiveUserByGroup(3);
					return view('users/edit-investor', $this->data);
				}elseif ($details->group_id == 3) {
					$this->data['rms'] = $this->user->getAllRm();
					return view('users/edit-introducer', $this->data);
				}
			}
		}else{
			$this->session->setFlashdata('message', 'Something went wrong!');
			$this->session->setFlashdata('message_type', 'error');
			return redirect()->to($this->request->getUserAgent()->getReferrer());
		}
	}

	public function change_status($value = '', $id = 0)
	{
		if (($value >= 0 && $value <= 1 ) && (is_numeric($id))) {
			if (is_bookFairy($id)) {
				if (totalSchoolCount($id) != 0) {
					$this->session->setFlashdata('message', 'In order to inactive Book Fairy, you have to unassign all the schools first.');
					$this->session->setFlashdata('message_type', 'error');
					return redirect()->to($this->request->getUserAgent()->getReferrer());
				}
			}
			$data = array(
				'active' => $value,
				'updated_at' => strtotime('now')
			);
			if ($this->user->updatePersonalDetails($id, $data)) {
				$this->session->setFlashdata('message', 'Status changed.');
				$this->session->setFlashdata('message_type', 'error');
				return redirect()->to($this->request->getUserAgent()->getReferrer());
			}else {
				$this->session->setFlashdata('message', 'Something went wrong!');
				$this->session->setFlashdata('message_type', 'error');
				return redirect()->to($this->request->getUserAgent()->getReferrer());
			}
		}else {
			$this->session->setFlashdata('message', 'Something went wrong!');
			$this->session->setFlashdata('message_type', 'error');
			return redirect()->to($this->request->getUserAgent()->getReferrer());
		}
	}

	public function ajax_get_user_by_id($id = '')
	{
		$this->data['success'] = false;
		$this->data['hash'] = csrf_hash();
		if ($this->request->isAjax()) {
			if (isset($id) && is_numeric($id)) {
				$details = $this->user->getUserById($id);
				if (!empty($details)) {
					$this->data['success'] = true;
					$this->data['details'] = $details;
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

	public function delete_user_by_id()
	{
		$id = $this->request->getPost('id');
		$this->data['success'] = false;
		$this->data['hash'] = csrf_hash();
		if ($this->request->isAjax()) {
			if ($id && is_numeric($id) ) {
				if (is_bookFairy($id)) {
					if (totalSchoolCount($id) != 0) {
						$this->data['message'] = 'In order to delete Book Fairy, you have to unassign all the schools first.';
						echo json_encode($this->data); die;
					}
				}
				$data = array(
					'active' => 0,
					'is_deleted' => 0
				);
				if ($this->user->updatePersonalDetails($id, $data)) {
					$this->data['success'] = true;
					$this->data['message'] = 'Deleted successfully';
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

	function getUsersListDd()
	{
		if ($this->request->isAjax()) {
			$users = $this->user->getUsersListDd($this->request->getPost('type'), $this->request->getPost('searchTerm'));
			$data = array();
			if (!empty($users)) {
				foreach ($users as $user) {
					$data[] = array("id"=>$user->id, "text"=>$user->name.'('.$user->email.')');
				}
			}
			echo json_encode($data); exit;
		}
	}

	public function change_password($id = 0)
	{
		$this->data['success'] = false;
		$this->data['hash'] = csrf_hash();
		if ($this->request->isAjax()) {
			if (isset($id) && is_numeric($id) && is_headoffice()) {
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
					'password_hash' => password_hash($this->request->getPost('confirm_pwd'), PASSWORD_DEFAULT),
				);
				if ($this->user->updatePersonalDetails($id, $data)) {
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
}
