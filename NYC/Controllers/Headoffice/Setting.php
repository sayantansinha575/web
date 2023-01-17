<?php namespace App\Controllers\Headoffice;
use App\Models\Crud_model;


class Setting extends BaseController
{


	public function __construct()
	{
		$db = db_connect();
		$this->request = \Config\Services::request();
		$this->session = \Config\Services::session();

		$this->crud = new Crud_model($db);

		//load helper
		helper('custom');
	}

	/*
	* TAKE THESE NOTES BEFORE CHANGING ANYTHING IN THIS FILE
	* IF YOU WANT TO ADD ANOTHER SETTNG TYPE FIRST ADD IT IN DATABASE 'SETTING TABLE'
	* THEN JUST CALL YOUR DESIRE FUNCTION LIKE "index"
	* USE ROUTES TO HIT YOUR FUNCTION/METHOD
	* CALL THE SAME VIEW FILE AND YOU ARE ALL DONE.
	* DO NOT TOUCH "update_setting" IF YOU DON'T KNOW WHAT YOU ARE DOING
	* HAVE A GOOD DAY AHEAD! 
	*/

	public function index()
	{
		if ($this->request->getMethod() == 'get' && !$this->request->isAJAX()) {
			$this->data['title'] = 'General Settings';
			$this->data['url'] = site_url('headoffice/setting/update-setting/general');
			$this->data['settings'] = $settings = $this->crud->select('setting', '', array('setting_type' => 1), 'serial_number ASC');
			if (empty($settings)) {
				$this->session->setFlashdata('message', "There's nothig to change in this setting");
				$this->session->setFlashdata('message_type', 'error');
				return redirect()->to('head-office/dashboard'); die;
			}
			return view('headoffice/setting/setting', $this->data);
		}
	}

	public function certificate_marksheet_setting()
	{
		if ($this->request->getMethod() == 'get' && !$this->request->isAJAX()) {
			$this->data['title'] = 'Certificate & Marksheet Settings';
			$this->data['url'] = site_url('headoffice/setting/update-setting/certificate_n_marksheet');
			$this->data['settings'] = $settings = $this->crud->select('setting', '', array('setting_type' => 2), 'serial_number ASC');
			if (empty($settings)) {
				$this->session->setFlashdata('message', "There's nothig to change in this setting");
				$this->session->setFlashdata('message_type', 'error');
				return redirect()->to('/head-office/dashboard'); die;
			}
			return view('headoffice/setting/setting', $this->data);
		}
	}

	public function meta_tags_setting()
	{
		if ($this->request->getMethod() == 'get' && !$this->request->isAJAX()) {
			$this->data['title'] = 'Meta Tags Settings';
			$this->data['url'] = site_url('headoffice/setting/update-setting/meta');
			$this->data['settings'] = $settings = $this->crud->select('setting', '', array('setting_type' => 4), 'serial_number ASC');
			if (empty($settings)) {
				$this->session->setFlashdata('message', "There's nothig to change in this setting");
				$this->session->setFlashdata('message_type', 'error');
				return redirect()->to('/head-office/dashboard'); die;
			}
			return view('headoffice/setting/setting', $this->data);
		}
	}

	public function media_setting()
	{
		if ($this->request->getMethod() == 'get' && !$this->request->isAJAX()) {
			$this->data['title'] = 'Media Settings';
			$this->data['url'] = site_url('headoffice/setting/update-setting/media');
			$this->data['settings'] = $settings = $this->crud->select('setting', '', array('setting_type' => 3), 'serial_number ASC');
			if (empty($settings)) {
				$this->session->setFlashdata('message', "There's nothig to change in this setting");
				$this->session->setFlashdata('message_type', 'error');
				return redirect()->to('/head-office/dashboard'); die;
			}
			return view('headoffice/setting/setting', $this->data);
		}
	}

	public function update_setting($type = 0)
	{
		if ($this->request->getMethod() == 'post' && $this->request->isAJAX() && is_headoffice()) {
			
			foreach($_POST as $key=>$val){
				$this->crud->updateData('setting', array('name' => $key, 'setting_type' => $type), array('value' => $val));
			}
			$path = 'upload/settings';
			if (!file_exists($path)) {
				mkdir($path, 0777, true);
			}
			foreach($_FILES as $key=>$val1){
				if( $val1['error'] == 0 ) {
					$image_name = $val1['name'];
					$image_array = array();
					$image_array = explode('.',$image_name);
					$ext = end($image_array);
					$name = md5(uniqid(mt_rand())).'.'.$ext;
					if (move_uploaded_file($val1['tmp_name'], $path.'/'.$name)) {
						$this->crud->updateData('setting', array('name' => $key, 'setting_type' => $type), array('value' => $name));
					}
				}
			}

			$this->data['success']= true;
			$this->data['message']='Settings has been updated successfully.';
			echo json_encode($this->data); die;
		}
	}
	
}
