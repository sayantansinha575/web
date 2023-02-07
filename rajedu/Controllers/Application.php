<?php
namespace App\Controllers;
use App\Controllers\BaseController;

class Application extends BaseController
{

    public function __construct()
    {
        $db = db_connect();
    }


    function searchStudent()
    {
       if (session()->isLoggedIn && $this->request->getMethod() == 'get' && ! $this->request->isAJAX()) {
            $this->data['title'] = 'Search Student';
            return view('application/search-student', $this->data); 
        } else {
            return redirect()->route('dashboard');
        }
    }


    function newApplication( $step = 'information')
    {
       if (session()->isLoggedIn && $this->request->getMethod() == 'get' && ! $this->request->isAJAX()) {

            $this->data['title'] = 'New Application';
            $this->data['component'] =  view('application/'.$step); 
            return view('application/new-application', $this->data); 
            
        } else {
            return redirect()->route('dashboard');
        }
    }


    function selectCourse()
    {
       if (session()->isLoggedIn && $this->request->getMethod() == 'get' && ! $this->request->isAJAX()) {
            $this->data['title'] = 'Search Course';
            return view('application/select-course', $this->data); 
        } else {
            return redirect()->route('dashboard');
        }
    }

    function saveStudentInfo()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            $rules = [
                'name'                    => ['label' => 'Student Name ', 'rules' => 'required'],
                'email'                   => ['label' => 'Student Email', 'rules' => 'required|is_unique[users.email]'],
                'phone'                   => ['label' => 'Student Phone ', 'rules' => 'required'],
               
            ];

            $errors = [];
            if ($this->validate($rules, $errors)) {

                $Userdata = [
                            
                    'email'                   => trim($this->request->getPost('email')),
                    'group_id' => 3,
                    'created_at'              => time(),
                   
                ];

                $Detailsdata = [

                    'name'                        => trim($this->request->getPost('name')),
                    'phone'                       => trim($this->request->getPost('phone')),

                ];


                if ($lastId = $this->crud->add('users', $Userdata)){
                    $Detailsdata['parent_id'] = $lastId;
                    $this->crud->add('user_details', $Detailsdata);
                    $this->data['success'] = true;
                    $this->data['message'] = 'Application Student has been successfully added.';
                    return $this->response->setJSON($this->data);
                } else {
                    $this->data['message'] = 'Something went wrong.';
                    return $this->response->setJSON($this->data);
                }

            } else {
                $this->data['errors'] = $this->validation->getErrors();
                return $this->response->setJSON($this->data);
            }
        } else {
            $this->data['message'] = 'Access Denied.';
            return $this->response->setJSON($this->data);
        }
    }



}