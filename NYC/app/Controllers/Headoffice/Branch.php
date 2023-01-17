<?php namespace App\Controllers\Headoffice;
use App\Models\Crud_model;
use App\Models\Datatable_model;
use App\Models\Notification_model;


class Branch extends BaseController
{


	public function __construct()
	{
		$db = db_connect();
		$this->request = \Config\Services::request();
		$this->session = \Config\Services::session();
		$this->agent = $this->request->getUserAgent();

		$this->crud = new Crud_model($db);
		$this->dt = new Datatable_model($db);
		$this->notification = new Notification_model($db);

		//load helper
		helper('custom');
	}

	public function index($type = 0)
	{
		if ($this->request->getMethod() == 'get') {
			$this->data['title'] = 'Branches';
			// $this->data['branches'] = $this->crud->select('branch', '', '', 'id DESC');
			return view('headoffice/branch/branch-list', $this->data);
		}
	}

	public function details($id = 0)
	{
		if ($this->request->getMethod() == 'get') {
			if ($id && is_numeric($id)) {
				$this->data['title'] = 'Branch Details';
				$this->data['details'] = $this->crud->select('branch', '', array('id' => $id), '', true);
				// pr($this->data);
				return view('headoffice/branch/branch-details', $this->data);
			}else{
				$this->session->setFlashdata('message', 'Something went wrong!');
				$this->session->setFlashdata('message_type', 'error');
				return redirect()->to('/head-office/branch'); die;
			}
			
		}
	}

	public function change_status($id,$val)
	{
		if ($this->request->getMethod() == 'get') {
			if (is_headoffice()) {
				if ($this->crud->updateData('branch', array('id' => $id), array('status' => $val))) {
					$notiArr = array(
						'from_id' => $this->session->userData['id'],
						'form_id_type' => 1,
						'to_id' => $id,
						'to_id_type' => 2,
						'old_status' => $val,
						'type' => 3,
						'slug' => 'branch-status',
						'date' => strtotime('now'),
					);
					$this->notification->addNotification('notifications', $notiArr);



					$this->session->setFlashdata('message', 'Branch status has been changed');
					$this->session->setFlashdata('message_type', 'success');
					return redirect()->to('/head-office/branch'); die;
				}else {
					$this->session->setFlashdata('message', 'Something went wrong!');
					$this->session->setFlashdata('message_type', 'error');
					return redirect()->to('/head-office/branch'); die;
				}
			}
		}else{
			$this->session->setFlashdata('message', 'Something went wrong!');
			$this->session->setFlashdata('message_type', 'error');
			return redirect()->to('/head-office/branch'); die;
		}
	}
	  public function get_countdown($branch_id = 0)
    {
          return getCountdownTime($branch_id);

    }
	function add_branch($id = 0)
	{
		// pr($_POST);
		if($this->request->getMethod() == "post"){
			if ($this->request->isAjax()) {
				$this->data['success'] = false;
				$this->data['hash'] = csrf_hash();
				if (strlen($this->request->getPost('branch_name')) == 0) {
					$this->data['id'] = '#branch_name';
					$this->data['message'] = 'Enter branch name';
					error($this->data);
				}
				$this->data['id'] = '#branch_email';
				$this->data['message'] = 'Enter valid email';
				if (strlen($this->request->getPost('branch_email')) == 0) {
					error($this->data);
				}elseif (!isValidEmail($this->request->getPost('branch_email'))) {
					error($this->data);
				}elseif (is_duplicate('branch', 'branch_email', array('branch_email' => $this->request->getPost('branch_email'), 'id<>' => $id))) {
					error($this->data);
				}
				$this->data['id'] = '#branch_code';
				if (strlen($this->request->getPost('branch_code')) == 0) {
					$this->data['message'] = 'Enter branch code';
					error($this->data);
				}elseif (is_duplicate('branch', 'branch_code', array('branch_code' => $this->request->getPost('branch_code'), 'id<>' => $id))) {
					$this->data['message'] = 'Branch code should be unique, duplicate branch code found';
					error($this->data);
				}
				if (strlen($this->request->getPost('date_of_registration')) == 0) {
					$this->data['id'] = '#date_of_registration';
					$this->data['message'] = 'Select a registration date';
					error($this->data);
				}
				if (strlen($this->request->getPost('renewal_days_left')) == 0) {
					$this->data['id'] = '#renewal_days_left';
					$this->data['message'] = 'Enter how many days left for renewal';
					error($this->data);
				}
				if (strlen($this->request->getPost('academy_code')) == 0) {
					$this->data['id'] = '#academy_code';
					$this->data['message'] = 'Enter academy code';
					error($this->data);
				}
				if (strlen($this->request->getPost('academy_name')) == 0) {
					$this->data['id'] = '#academy_name';
					$this->data['message'] = 'Enter academy name';
					error($this->data);
				}
				if (strlen($this->request->getPost('academy_address')) == 0) {
					$this->data['id'] = '#academy_address';
					$this->data['message'] = 'Enter academy address';
					error($this->data);
				}
				if (strlen($this->request->getPost('academy_phone')) == 0) {
					$this->data['id'] = '#academy_phone';
					$this->data['message'] = 'Enter academy phone number';
					error($this->data);
				}
				if (strlen($this->request->getPost('username')) == 0) {
					$this->data['id'] = '#username';
					$this->data['message'] = 'Enter username';
					error($this->data);
				}elseif (is_duplicate('branch', 'username', array('username' => $this->request->getPost('username'), 'id<>' => $id))) {
					$this->data['id'] = '#username';
					$this->data['message'] = 'Duplicate username found';
					error($this->data);
				}
				if (strlen($this->request->getPost('password')) == 0 ) {
					$this->data['id'] = '#password';
					$this->data['message'] = 'Enter password';
					echo json_encode($this->data); die;
				} elseif (!checkPwdStrength($this->request->getPost('password'))) {
					$this->data['id'] = '#password';
					$this->data['message'] = 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
					echo json_encode($this->data); die;
				}
				if (strlen($this->request->getPost('confirm_password')) == 0 ) {
					$this->data['id'] = '#confirm_password';
					$this->data['message'] = 'Enter confirm Password';
					echo json_encode($this->data); die;
				} elseif (strlen($this->request->getPost('confirm_password')) < 8) {
					$this->data['id'] = '#confirm_password';
					$this->data['message'] = 'Password should be at least 8 characters in length';
					echo json_encode($this->data); die;
				}
				if ($this->request->getPost('password') != $this->request->getPost('confirm_password')) {
					$this->data['id'] = '#confirm_password';
					$this->data['message'] = "Password confirmation doesn't match password";
					echo json_encode($this->data); die;
				}
				if (strlen($this->request->getPost('invoice_prefix')) == 0 ) {
					$this->data['id'] = '#invoice_prefix';
					$this->data['message'] = 'Enter invoice prefix';
					echo json_encode($this->data); die;
				}
				if (strlen($this->request->getPost('student_enrollment_prefix')) == 0 ) {
					$this->data['id'] = '#student_enrollment_prefix';
					$this->data['message'] = 'Enter student enrollment prefix';
					echo json_encode($this->data); die;
				}elseif (is_duplicate('branch', 'student_enrollment_prefix', array('student_enrollment_prefix' => $this->request->getPost('student_enrollment_prefix'), 'id<>' => $id))) {
					$this->data['id'] = '#student_enrollment_prefix';
					$this->data['message'] = 'Duplicate enrollment prefix found, it should be unique';
					error($this->data);
				}
				if (strlen($this->request->getPost('marksheet_prefix')) == 0 ) {
					$this->data['id'] = '#marksheet_prefix';
					$this->data['message'] = 'Enter student marksheet prefix';
					echo json_encode($this->data); die;
				}elseif (is_duplicate('branch', 'marksheet_prefix', array('marksheet_prefix' => $this->request->getPost('marksheet_prefix'), 'id<>' => $id))) {
					$this->data['id'] = '#marksheet_prefix';
					$this->data['message'] = 'Duplicate marksheet prefix found, it should be unique';
					error($this->data);
				}
				if (strlen($this->request->getPost('certificate_prefix')) == 0 ) {
					$this->data['id'] = '#certificate_prefix';
					$this->data['message'] = 'Enter certificate prefix';
					echo json_encode($this->data); die;
				}
				if (strlen($this->request->getPost('invoice_prefix')) == 0 ) {
					$this->data['id'] = '#invoice_prefix';
					$this->data['message'] = 'Enter Confirm Password';
					echo json_encode($this->data); die;
				}
				
				if (strlen($_FILES['signature']['tmp_name']) == 0 && (empty($this->request->getPost('oldSignFile'))) ) {
					$this->data['message'] = 'Select signature to upload.';
					echo json_encode($this->data); die;
				}
				
				$this->data['id'] = $this->data['message'] = '';

				$data = $this->request->getPost();
				
				if (strlen($_FILES['signature']['tmp_name']) != 0) {
					$data['signature'] = uploadFile('upload/files/branch/signature', 'signature', $this->request->getPost('oldSignFile'));
				}
				if (strlen($_FILES['image']['tmp_name']) != 0) {
					$data['branch_image'] = uploadFile('upload/files/branch/branch-image', 'image', $this->request->getPost('oldBranchImageFile'));
				}

				if(!empty($this->request->getPost('date_of_registration'))) {
					$data['date_of_registration'] = strtotime($this->request->getPost('date_of_registration'));
				}

				if (!empty($this->request->getPost('confirm_password'))) {
					$data['visible_pwd'] = $this->request->getPost('confirm_password');
					$data['password'] = password_hash($this->request->getPost('confirm_password'), PASSWORD_DEFAULT);
				}

				unset( $data['oldSignFile'], $data['oldBranchImageFile'], $data['confirm_password'], $data['csrf_token_name']);


				if ($id && is_numeric($id)) {
					$data['updated_at'] = strtotime('now');
					if ($this->crud->updateData('branch', array('id' => $id), $data)) {
						$branch_table_details = $this->crud->select('branch', '', array('id' => $id), '', true);
						$status = $branch_table_details->status;
						$notiArr = array(
							'from_id' => $this->session->userData['id'],
							'form_id_type' => 1,
							'to_id' => $id,
							'to_id_type' => 2,
							'type' => 2,
							'slug' => 'update-branch',
							'date' => strtotime('now'),
						);
						$this->notification->addNotification('notifications', $notiArr);


						$this->data['success'] = true;
						$this->data['message'] = 'Branch details has been successfully updated';
						echo json_encode($this->data); die;
					}else{
						$this->data['message'] = 'Something went wrong!';
						echo json_encode($this->data); die;
					}
				}else{
					$data['added_by'] = $this->session->userData['id'];
					$data['created_at'] = strtotime('now');

					if ($last_id = $this->crud->add('branch', $data)) {
						$notiArr = array(
							'from_id' => $this->session->userData['id'],
							'form_id_type' => 1,
							'to_id' => $last_id,
							'to_id_type' => 2,
							'type' => 1,
							'slug' => 'new-branch-creation',
							'date' => strtotime('now'),
						);
						$this->notification->addNotification('notifications', $notiArr);

						$this->data['success'] = true;
						$this->data['message'] = 'Branch details has been successfully added';
						echo json_encode($this->data); die;
					}else{
						$this->data['message'] = 'Something went wrong!';
						echo json_encode($this->data); die;
					}
				}
			}
		}else if($this->request->getMethod() == "get"){
			$this->data['title'] = ($id)?'Edit Branch':'Add Branch';
			$this->data['details'] = array();
			$this->data['id'] = ($id)?'/'.$id:'';
			if ($id && is_numeric($id)) {
				$this->data['details'] = $this->crud->select('branch', '*', array('id' =>$id), '', true);
			}
			return view('headoffice/branch/add-branch', $this->data);
		}
	}



	/*AJAX REQUESTS*/
	public function ajax_dt_get_branch_list()
	{
		$postData = $this->request->getPost();
		$dtpostData = $postData['data'];
		$response = array();
		$where = '';

     	## Read value
		$draw = $dtpostData['draw'];
		$start = $dtpostData['start'];
    	$rowperpage = $dtpostData['length'];
    	$columnIndex = $dtpostData['order'][0]['column'];
    	$columnName = $dtpostData['columns'][$columnIndex]['data'];
    	$columnSortOrder = $dtpostData['order'][0]['dir'];
    	$status = $dtpostData['status'];
    	$keyword = $dtpostData['keyword'];

     	## Total number of records without filtering
    	$totalRecords = get_count('branch', array('id<>' => 0));
     	## Total number of records with filtering
     	$totalRecordwithFilter = $totalRecords;
     	if (!empty($status)) {
     		$where .= "`status`=$status";
     	}
     	if (!empty($keyword)) {
     		$where .= empty($where)?"`branch_name` LIKE '%$keyword%' ESCAPE '!' OR `branch_email` LIKE '%$keyword%' ESCAPE '!'":" AND `branch_name` LIKE '%$keyword%' ESCAPE '!' OR `branch_email` LIKE '%$keyword%' ESCAPE '!'";
     	}
     	if (!empty($where)) {
     		$totalRecordwithFilter = get_count('branch', $where);
     	}

     	## Fetch records
    	$records = $this->dt->getAjaxDatatableBranchList($status, $keyword, $columnSortOrder, $rowperpage, $start);
    	$data = array();
    	$i = $start+1;
    	foreach($records as $record ){
    		if ($record->status == 1) {
    			$statusHtml = '<a href="javascript:void(0)" data-toggle="tooltip" title="Click to inactive" class="changeBranchStatus" data-id="'.$record->id.'" data-val="2"><span class="badge badge-success-lighten">Active</span></a>';
    		}else {
    			$statusHtml = '<a href="javascript:void(0)" data-toggle="tooltip" title="Click to active" class="changeBranchStatus" data-id="'.$record->id.'" data-val="1"><span class="badge badge-danger-lighten">Inactive</span></a>';
    		}
            $actions = '<a href="'.site_url('head-office/branch/edit-branch/').$record->id.'" class="btn btn-dark btn-sm btn-icon" data-toggle="tooltip" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>';
            $actions .= '<a href="'.site_url('head-office/branch/branch-details/').$record->id.'" class="btn btn-info btn-sm btn-icon" data-toggle="tooltip" title="Details"><i class="fa-solid fa-eye"></i></a>';

             $actions .= '<a href="Javascript:void(0)" data-delete="'.$record->id.'" class="btn btn-danger btn-sm btn-icon delete-branch" data-toggle="tooltip" title="Delete"><i class="fa-solid fa-trash"></i></a>';
        if($record->renewal_date > time()){
					$diff = $record->renewal_date - time();
					$text = '<br><strong>'.round($diff/(60*60*24)).' Days left for renewal</strong>.';
        }else{
        	$text = '<br><strong  class="text-danger">0 Days Days left for renewal</strong>';
        }
        
    		$data[] = array( 
    			"slNo" => $i++,
    			"branch_name" => $record->branch_name.'<br>'.$record->branch_code.$text,
    			"academy_name" => $record->academy_name,
    			"branch_email" => $record->branch_email,
    			"status" => $statusHtml,
    			"action" => $actions,
    		); 
    	}

     	## Response
    	$response = array(
    		"draw" => intval($draw),
    		"iTotalRecords" => $totalRecords,
    		"iTotalDisplayRecords" => $totalRecordwithFilter,
    		"aaData" => $data,
	        "hash" => csrf_hash() // New token hash
	    );

    	return $this->response->setJSON($response);
	}

	public function atteptToDeleteBranch($id)
	{
		if ($this->crud->deleteData('branch', ['id' => $id])) {
			$this->session->setFlashdata('message', 'Branch deleted successfully');
			$this->session->setFlashdata('message_type', 'success');
			return redirect()->back();die;
		}
	}
}
