<?php
namespace App\Controllers\Branch;



class Branch extends BaseController
{

    public function __construct()
    {
        $db = db_connect();
    } 


    public function branch_details()
    {
        if (($this->request->getMethod() == 'get') && (!$this->request->isAjax())) {
            $this->data['title'] = 'Branch Details';
            $this->data['details'] = $this->crud->select('branch', '', array('id' => $this->session->branchData['id']), '', true);
            return  view('branch/branch/details', $this->data);
        }

    }

    public function get_count_down()
    {
          return getCountdownTime();

    }
  

    public function ammend_branch_details()
    {
        if (($this->request->getMethod() == 'post') && ($this->request->isAjax())) {
            $id = $this->session->branchData['id'];
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
            $data = $this->request->getPost();
            unset($data['csrf_token_name']);
            if ($id && is_numeric($id)) {
                $data['updated_at'] = strtotime('now');
                if ($this->crud->updateData('branch', array('id' => $id), $data)) {
                    $this->data['success'] = true;
                    $this->data['message'] = 'Branch details has been successfully updated';
                    echo json_encode($this->data); die;
                }else{
                    $this->data['message'] = 'Something went wrong!';
                    echo json_encode($this->data); die;
                }
            }else{
               $this->data['message'] = 'Something went wrong!';
               echo json_encode($this->data); die;
            }

        }else if (($this->request->getMethod() == 'get') && (!$this->request->isAjax())) {
            $this->data['title'] = 'Branch Details';
            $this->data['details'] = $this->crud->select('branch', '', array('id' => $this->session->branchData['id']), '', true);
            return  view('branch/branch/edit-branch', $this->data);
        }
    }
}
