<?php
namespace App\Controllers\Student;
use App\Models\Student\PaymentModel;

class Download extends BaseController
{

    public function __construct()
    {
        $db = db_connect();
        $this->paym = new PaymentModel($db);
    }


    public function index()
    {
        $this->data['title'] = 'Document List';
        $statusArr = array(
            0 => '<span class="label label-default">NA</span>',
            1 => '<span class="label label-info">In Process</span>',
            2 => '<span class="label label-primary">Under Process</span>',
            3 => '<span class="label label-danger">Rejected</span>',
            4 => '<span class="label label-success">Published</span>',
        );
        $data = array();
        $course = $this->paym->getEnlistedCourseList($this->session->studData['registrationNumber']);
        if (!empty($course)) {
            foreach ($course as $crs) {
                $admits = $this->crud->select('admits', '', ['enrollment_number' => $crs->enrollment_number, 'registration_number' => $this->session->studData['registrationNumber']]);
                if (!empty($admits)) {
                    foreach ($admits as $admit) {
                        $data[] = array(
                            'name' => 'Admit Card',
                            'courseCode' => $crs->course_code,
                            'enrollmentNo' => $admit->enrollment_number,
                            'status' => '<span class="label label-success">Available</span>',
                            'fileUrl' => '<a href="'. site_url('public/upload/branch-files/student/admit/').$admit->admit_file.'" download title="Download"><i class="zmdi zmdi-download"></i></a>',
                        );
                    }
                }

                $icards = $this->crud->select('admission', '', ['enrollment_number' => $crs->enrollment_number, 'registration_number' => $this->session->studData['registrationNumber']]);
                if (!empty($icards)) {
                    foreach ($icards as $icard) {
                        if (!empty($icard->nycta_icard)) {
                            $data[] = array(
                                'name' => 'I Card',
                                'courseCode' => $crs->course_code,
                                'enrollmentNo' => $icard->enrollment_number,
                                'status' => '<span class="label label-success">Available</span>',
                                'fileUrl' => '<a href="'. site_url('public/upload/branch-files/student/identity-card/').$icard->nycta_icard.'.pdf" download title="Download"><i class="zmdi zmdi-download"></i></a>',
                            );
                        }
                    }
                }

                if ($crs->has_marksheet == 'Yes') {
                    $marksheets = $this->crud->select('marksheets', '', ['enrollment_number' => $crs->enrollment_number]);
                    if (!empty($marksheets)) {
                        foreach ($marksheets as $msheet) {
                            if ((!empty($msheet->marksheet_file)) && ($msheet->status == 4)) {
                                $data[] = array(
                                    'name' => 'Marksheet',
                                    'status' => $statusArr[$msheet->status],
                                    'courseCode' => $crs->course_code,
                                    'enrollmentNo' => $msheet->enrollment_number,
                                    'fileUrl' => '<a href="'.site_url('public/upload/branch-files/student/marksheet/').$msheet->marksheet_file.'" download title="Download"><i class="zmdi zmdi-download"></i></a>',
                                );
                            }else {
                                $data[] = array(
                                    'name' => 'Marksheet',
                                    'status' => $statusArr[$msheet->status],
                                    'courseCode' => $crs->course_code,
                                    'enrollmentNo' => $msheet->enrollment_number,
                                    'fileUrl' => 'NA',
                                );
                            }
                        }
                    }else {
                        $data[] = array(
                            'name' => 'Marksheet',
                            'status' => $statusArr[0],
                            'courseCode' => $crs->course_code,
                            'enrollmentNo' => $crs->enrollment_number,
                            'fileUrl' => 'NA',
                        );
                    }
                }
                

                $certificates = $this->crud->select('certificates', '', ['enrollment_number' => $crs->enrollment_number]);
                if (!empty($certificates)) {
                    foreach ($certificates as $cert) {
                        if ((!empty($cert->certificate_file)) && ($cert->status == 4)) {
                            $data[] = array(
                                'name' => 'Certificate',
                                'status' => $statusArr[$cert->status],
                                'courseCode' => $crs->course_code,
                                'enrollmentNo' => $cert->enrollment_number,
                                'fileUrl' => '<a href="'.site_url('public/upload/branch-files/student/certificate/').$cert->certificate_file.'" download title="Download"><i class="zmdi zmdi-download"></i></a>',
                            );
                        }else {
                            $data[] = array(
                                'name' => 'Certificate',
                                'status' => $statusArr[$cert->status],
                                'courseCode' => $crs->course_code,
                                'enrollmentNo' => $cert->enrollment_number,
                                'fileUrl' => 'NA',
                            );
                        }
                    }
                }else {
                    $data[] = array(
                        'name' => 'Certificate',
                        'status' => $statusArr[0],
                        'courseCode' => $crs->course_code,
                        'enrollmentNo' => $crs->enrollment_number,
                        'fileUrl' => 'NA',
                    );
                }
            } 
        }
        $this->data['document'] = $data;
        return  view('student/document/list', $this->data);   
    }
}
