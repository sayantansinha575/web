<?php
namespace App\Controllers\Branch;
use App\Models\Branch\Certificate_model;
use App\Models\Notification_model;




class Certificate extends BaseController
{

    public function __construct()
    {
        $db = db_connect();
        $this->certificate = new Certificate_model($db);
        $this->notification = new Notification_model($db);
    }

    public function index()
    {
         if(($this->request->getMethod() == "get") && !$this->request->isAjax()){
            $this->data['title'] = 'Certificate';
            return view('branch/certificate/manage-certificate', $this->data);
         }
    }

    public function apply_new_certificate()
    {
        if(($this->request->getMethod() == "get") && !$this->request->isAjax()){
            $this->data['title'] = 'New Certificate';
            if (!empty($_REQUEST['enrollNo'])) {
                $enrollNo = $_REQUEST['enrollNo'];
                $existingData = $this->crud->select('certificates', '', array('enrollment_number' => $enrollNo, 'branch_id' => $this->session->branchData['id']), '', true);
                if (!empty($existingData)) {
                   return redirect()->to(site_url('branch/certificate/certificate-details/'.encrypt($existingData->id)));  die;
                }
                if (!empty($this->crud->select('admission', 'id', array('enrollment_number' => $enrollNo, 'branch_id' => $this->session->branchData['id'])))) {
                    $courseId = fieldValue('admission', 'course_name', array('enrollment_number' => $enrollNo, 'branch_id' => $this->session->branchData['id']));
                    $this->data['has_marksheet'] = $isMarksheetRequired = fieldValue('course', 'has_marksheet', array('id' => $courseId));
                    if ($isMarksheetRequired == 'Yes') {
                        $this->data['msheetData'] = $msheetData = $this->crud->select('marksheets', 'from_session, to_session, overall_grade, status', array('enrollment_number' => $enrollNo, 'branch_id' => $this->session->branchData['id']), '', true);
                        if (empty($msheetData) || $msheetData->status != 4) {
                            $this->session->setFlashData('message', "Please apply for marksheet first or it's not approved yet");
                            $this->session->setFlashData('message_type', 'error');
                            return redirect()->to('branch/certificate/apply-new-certificate'); die;
                        }
                    }else {
                        if (get_count('admits', array('enrollment_number' => $enrollNo)) <= 0) {
                            $this->session->setFlashData('message', 'Generate an admit card first, to proceed with the same.');
                            $this->session->setFlashData('message_type', 'error');
                            return redirect()->to('branch/certificate/apply-new-certificate'); die;
                        }
                    }

                    $this->data['details'] = $details = $this->certificate->getDetailsToApply($enrollNo, $this->session->branchData['id']);
                }else {
                    $this->session->setFlashData('message', 'No data found');
                    $this->session->setFlashData('message_type', 'error');
                    return redirect()->to('branch/certificate/apply-new-certificate'); die;
                }
            }
            return view('branch/certificate/apply', $this->data);
        }else {
            if (($this->request->getMethod() == "post") && $this->request->isAjax()) {   
                $this->data['success'] = false;
                $this->data['hash'] = csrf_hash();
                if (strlen($this->request->getPost('from_session')) == 0) {
                    $this->data['id'] = '#from_session';
                    $this->data['message'] = 'Select form session';
                    error($this->data);
                }
                if (strlen($this->request->getPost('to_session')) == 0) {
                    $this->data['id'] = '#to_session';
                    $this->data['message'] = 'Select to session';
                    error($this->data);
                }
                if (strlen($this->request->getPost('duration')) == 0) {
                    $this->data['id'] = '#duration';
                    $this->data['message'] = 'Enter Duration';
                    error($this->data);
                }

                if (strlen($this->request->getPost('grade')) == 0) {
                    $this->data['id'] = '#grade';
                    $this->data['message'] = 'Enter grade';
                    error($this->data);
                }

                if ($this->request->getPost('typing_test') == 1) {
                   foreach ($this->request->getPost('type_lang') as $key => $val) {
                        if (strlen($val) == 0) {
                            $this->data['message'] = 'Enter typing languauge';
                            error($this->data);
                        }
                        if (strlen($this->request->getPost('type_speed')[$key]) == 0) {
                            $this->data['message'] = 'Enter typing speed';
                            error($this->data);
                        }
                        if (strlen($this->request->getPost('type_accuracy')[$key]) == 0) {
                            $this->data['message'] = 'Enter typing accuracy';
                            error($this->data);
                        }
                        if (strlen($this->request->getPost('type_time')[$key]) == 0) {
                            $this->data['message'] = 'Enter typing time';
                            error($this->data);
                        }
                    }
                }

                $data = $this->request->getPost();

                //Marksheet Number Generate
                $certificatePrefix = fieldValue('branch', 'certificate_prefix', array('id' => $this->session->branchData['id']));
                $courseShortName = strtoupper(clean($this->request->getPost('short_name')));
                $certificate_no = str_replace('[COURSE]', $courseShortName, $certificatePrefix).leadingZero($data['admission_id'], 4);
                //End

                $dataArr = array(
                    'branch_id' => $this->session->branchData['id'],
                    'admission_id' => $data['admission_id'],
                    'course_id' => $data['course_id'],
                    'certificate_no' => $certificate_no,
                    'enrollment_number' => $data['enrollment_number'],
                    'candidate_name' => $data['candidate_name'],
                    'father_name' => $data['father_name'],
                    'from_session' => strtotime($data['from_session']),
                    'to_session' => strtotime($data['to_session']),
                    'duration' => $data['duration'],
                    'typing_test' => $data['typing_test'],
                    'grade' => $data['grade'],
                    'student_photo' => $data['student_photo'],
                    'created_at' => strtotime('now'),
                );
                if ($this->request->getPost('typing_test') == 1) {
                    $dataArr['language'] = serialize($this->request->getPost('type_lang'));
                    $dataArr['speed'] = serialize($this->request->getPost('type_speed'));
                    $dataArr['accuracy'] = serialize($this->request->getPost('type_accuracy'));
                    $dataArr['time'] = serialize($this->request->getPost('type_time'));
                }
                if ($lastId = $this->crud->add('certificates', $dataArr)) {

                    $notiArr = array(
                        'from_id' => $this->session->branchData['id'],
                        'form_id_type' => 2,
                        'to_id' => 1,
                        'to_id_type' => 1,
                        'type' => 'certificate_apply',
                        'slug' => 'certificate-apply',
                        'date' => strtotime('now'),
                    );
                    $this->notification->addNotification('notifications', $notiArr);

                    $this->data['success'] = true;
                    $this->data['redirect'] = site_url('branch/certificate/certificate-details/'.encrypt($lastId));
                    $this->data['message'] = 'Data has been submitted for certificate';
                    echo json_encode($this->data);
                }
            }
        }
    }

    public function certificate_details($id = '')
    {
        if ($this->request->getMethod('get') && !$this->request->isAJAX()) {
            $id = decrypt($id);
            if (!empty($id) && is_numeric($id)) {
               $this->data['details'] = $details = $this->crud->select('certificates', '', array('id' => $id, 'branch_id' => $this->session->branchData['id']), '', true);
               if (!empty($details)) {
                   $this->data['title'] = 'Certificate Details';
                   return view('branch/certificate/certificate-details', $this->data);
               }else {
                   $this->session->setFlashData('message', 'Access Denied');
                   $this->session->setFlashData('message_type', 'error');
                   return redirect()->to('/branch/certificate'); die;
               }
            }
        }
    }


    public function ajax_dt_get_certificate_list()
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
        $keyword = $dtpostData['keyword'];
        $status = $dtpostData['status'];
        $branchId = $this->session->branchData['id'];

        ## Total number of records without filtering
        $totalRecords = get_count('certificates', array('branch_id' => $branchId));
        ## Total number of records with filtering
        $totalRecordwithFilter = $totalRecords;
        $where .= "`certificates.branch_id`=$branchId";
        if (!empty($keyword)) {
            $where .= empty($where)?"`certificates.certificate_no` LIKE '%$keyword%' ESCAPE '!' OR `certificates.enrollment_number` LIKE '%$keyword%' ESCAPE '!' OR `certificates.candidate_name` LIKE '%$keyword%' ESCAPE '!' OR `course.short_name` LIKE '%$keyword%' ESCAPE '!' OR `certificates.grade` LIKE '%$keyword%' ESCAPE '!'":" AND `certificates.certificate_no` LIKE '%$keyword%' ESCAPE '!' OR `certificates.enrollment_number` LIKE '%$keyword%' ESCAPE '!' OR `certificates.candidate_name` LIKE '%$keyword%' ESCAPE '!' OR `course.short_name` LIKE '%$keyword%' ESCAPE '!' OR `certificates.grade` LIKE '%$keyword%' ESCAPE '!'";
        }
        if (!empty($status)) {
            $where .= empty($where)?"`certificates.status`=$status":" AND `certificates.status`=$status";
        }
        if (!empty($where)) {
            $totalRecordwithFilter = $this->dt->getCertificateListCount($where);
        }

        ## Fetch records
        $records = $this->dt->getAjaxDatatableCertificateList($keyword, $columnSortOrder, $rowperpage, $start, $branchId, $status);
        $data = array();
        $i = $start+1;
        foreach($records as $record ){
            $actions = ''; $subAction = '';
            if (!empty($record->certificate_file && $record->status == 4)) {
                $subAction .= '<a class="dropdown-item" href="'.site_url('public/upload/branch-files/student/certificate/'.$record->certificate_file).'" download="'.$record->certificate_file.'">Download Certificate</a>';
            }
            
            $actions .= '<div class="dropdown show">
            <a  href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-ellipsis-h"></i>
            </a>
            <div class="drp-select dropdown-menu">
            <a class="dropdown-item" href="'.site_url('branch/certificate/certificate-details/'.encrypt($record->id)).'" >Details</a>
            '.$subAction.'
            </div>
            </div>';
            if ($record->status == 1) {
                $status = '<span class="trip text-warning bg-light-warning">Processing</span>';
            }elseif ($record->status == 2) {
                $status = '<span class="trip gray">Under Preview</span>';
            }elseif ($record->status == 4) {
                $status = '<span class="trip theme-cl theme-bg-light">Published</span>';
            }else {
                $status = '<span class="trip text-danger bg-light-danger">Rejected</span>';
            }

            if ($record->is_urgent_certificate_required == 'Yes') {
                $req = 'Certificate: <b class="text-muted">Urgent</b>';
            }else {
                $req = 'Certificate: <b class="text-muted">Regular</b>';
            }

            $data[] = array( 
                "slNo" => $i++,
                "student" => $record->candidate_name.'<br>'.$record->enrollment_number.'</br>'.$req,
                "certificate_no" => $record->certificate_no,
                "course" => $record->short_name,
                "grade" => $record->grade,
                "status" => $status,
                'action' => $actions,
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
}
