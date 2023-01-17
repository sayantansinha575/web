<?php

namespace App\Controllers;
use Config\Email;
use Config\Services;
use App\Models\Crud_model;

class Result extends BaseController
{
    /**
     * Access to current session.
     *
     * @var \CodeIgniter\Session\Session
     */
    protected $session;

    /**
     * Authentication settings.
     */
    protected $config;

    public function __construct()
    {
        $this->session = Services::session();
        $db = db_connect();
        $this->crud = new Crud_model($db);
    }

    public function index()
    {
      
        $this->data['title'] = 'Branch Details';
        $this->data['details'] = 'BAC';
        return  view('front/result/index', $this->data);
    }
    public function certificate_details()
    {
        $data = array();

        $rules = [
            'cno' => ['rules' => 'required'],
            'eno' => ['rules' => 'required'],
            'fname' => ['rules' => 'required'],
        ];
        $errors = [
            'cno' => [
                'required' => 'The certificate number field can\'t be blank.',
            ],
            'eno' => [
                'required' => 'The enrollment number field can\'t be blank.',
            ],
            'fname' => [
                'required' => 'The father\'s name field can\'t be blank.',
            ],
        ];
        if (!$this->validate($rules, $errors)) {
            return redirect()->back()->withInput();
        }


        $data = $_REQUEST;  
        $cno = $this->request->getGet('cno');
        $eno = $this->request->getGet('eno');
        $fname = $this->request->getGet('fname');
        $beforeJune = $this->request->getGet('before_june');
        if( (strlen($cno) > 0)  &&  (strlen($eno) > 0) && (strlen($fname) > 0) ){            
            if ($beforeJune) {
                $details = $this->crud->select('old_certificates', '', ['cno' => $cno, 'enroll' => $eno, 'f_name' => $fname], '', true);
                if (!empty($details)) {
                    $data['details'] = array(
                        'image' => $details->image,
                        'candidate_name' => $details->std_name,
                        'father_name' => $details->f_name,
                        'certificate_no' => $details->cno,
                        'course_name' => $details->course,
                    );
                    $data['m_details'] = array(
                        'total_marks' => $details->t_marks,
                        'total_marks_obtained' => $details->ob_marks,
                        'overall_percentage' => $details->percentage,
                        'overall_grade' => $details->grade,
                    );
                }
            } else {
                $certificate_details = $this->crud->select('certificates', '', array('enrollment_number' => $eno, 
                    'certificate_no' => $cno,'father_name'=> strtoupper($fname) ,'status'=>4), '', true);
                if(!empty($certificate_details)){
                    $marksheet_details = $this->crud->select('marksheets', '', array('admission_id' => $certificate_details->admission_id,'status'=>4), '', true);  
                    $course_details = $this->crud->select('course', '', array('id' => $certificate_details->course_id), '', true);  
                    $data['details'] = array(
                        'dp' => $certificate_details->student_photo,
                        'candidate_name' => $certificate_details->candidate_name,
                        'father_name' => $certificate_details->father_name,
                        'certificate_no' => $certificate_details->certificate_no,
                        'course_name' => $course_details->course_name,
                    );
                    if (!empty($marksheet_details)) {
                        $data['m_details'] = array(
                            'total_marks' => $marksheet_details->total_marks,
                            'total_marks_obtained' => $marksheet_details->total_marks_obtained,
                            'overall_percentage' => $marksheet_details->overall_percentage,
                            'overall_grade' => $marksheet_details->overall_grade,
                        );
                    }
                }
            }
        }
        return  view('front/result/certificate-details', $data);
    }
}
