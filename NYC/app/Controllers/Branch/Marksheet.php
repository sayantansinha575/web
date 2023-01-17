<?php
namespace App\Controllers\Branch;
use App\Models\Branch\Marksheet_model;
use App\Models\Notification_model;




class Marksheet extends BaseController
{

    public function __construct()
    {
        $db = db_connect();
        $this->marksheet = new Marksheet_model($db);
        $this->notification = new Notification_model($db);
    }

    public function index()
    {
         if(($this->request->getMethod() == "get") && !$this->request->isAjax()){
            $this->data['title'] = 'Marksheet';
            return view('branch/marksheet/manage-marksheet', $this->data);
         }
    }

    public function apply_new_marksheet()
    {
        if(($this->request->getMethod() == "get") && !$this->request->isAjax()){
            $this->data['title'] = 'New Marksheet';
            if (!empty($_REQUEST['enrollNo'])) {
                $enrollNo = $_REQUEST['enrollNo'];

                $existingData = $this->crud->select('marksheets', '', array('enrollment_number' => $enrollNo, 'branch_id' => $this->session->branchData['id']), '', true);
                if (!empty($existingData)) {
                    return redirect()->to(site_url('branch/marksheet/marksheet-details/'.encrypt($existingData->id)));  die;
                }
                if (!empty($this->crud->select('admission', 'id', array('enrollment_number' => $enrollNo, 'branch_id' => $this->session->branchData['id']), '', true))) {
                    if (get_count('admits', array('enrollment_number' => $enrollNo)) > 0) {

                        $courseId = fieldValue('admission', 'course_name', array('enrollment_number' => $enrollNo, 'branch_id' => $this->session->branchData['id']));
                        $this->data['has_marksheet'] = $isMarksheetRequired = fieldValue('course', 'has_marksheet', array('id' => $courseId));
                        if ($isMarksheetRequired == 'Yes') {
                            $this->data['details'] = $details = $this->marksheet->getDetailsToApply($enrollNo, $this->session->branchData['id']);
     
                            if (empty($details)) {
                                $this->session->setFlashData('message', 'No data found');
                                $this->session->setFlashData('message_type', 'error');
                                return redirect()->to('branch/marksheet/apply-new-marksheet'); die;
                            }
                        }else {
                            $this->session->setFlashData('message', 'No marksheet is required for this course');
                            $this->session->setFlashData('message_type', 'error');
                            return redirect()->to('branch/marksheet/apply-new-marksheet'); die;
                        }
                    }else {
                        $this->session->setFlashData('message', 'Generate an admit card first, to proceed with the same.');
                        $this->session->setFlashData('message_type', 'error');
                        return redirect()->to('branch/marksheet/apply-new-marksheet'); die;
                    }
                }else {
                    $this->session->setFlashData('message', 'No data found');
                    $this->session->setFlashData('message_type', 'error');
                    return redirect()->to('branch/marksheet/apply-new-marksheet'); die;
                }
            }
            return view('branch/marksheet/apply', $this->data);
        }else {
            // pr($_POST);
            if (($this->request->getMethod() == "post") && $this->request->isAjax()) {                    
                $this->data['success'] = false;
                $this->data['hash'] = csrf_hash();
                $totalMarksObtained = 0;

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
                if (strlen($this->request->getPost('typing_speed')) == 0) {
                    $this->data['id'] = '#typing_speed';
                    $this->data['message'] = 'Select typing speed';
                    error($this->data);
                }

                if (!empty($this->request->getPost('marks_obtained'))) {
                    foreach ($this->request->getPost('marks_obtained') as $key => $sub) {
                        if (strlen($sub) == 0) {
                            $this->data['message'] = 'Enter obtained marks';
                            error($this->data);
                        }
                    }

                    $totalMarksObtained += array_sum($this->request->getPost('marks_obtained'));
                    $mData['subjects']['subject'] = $this->request->getPost('subject');
                    $mData['marks']['marks'] = $this->request->getPost('marks');
                    $mData['marksObtained']['marks_obtained'] = $this->request->getPost('marks_obtained');
                    $mData['grade']['grade'] = $this->request->getPost('grade');
                }

                if (!empty($this->request->getPost('label_name'))) {
                    foreach ($this->request->getPost('label_name') as $key => $label) {
                        $iden = $this->request->getPost('identifier')[$key];

                        if (!empty($this->request->getPost($iden.'subject'))) {
                            foreach ($this->request->getPost($iden.'subject') as $key1 => $sub) {

                                if ($this->request->getPost($iden.'marks_obtained')[$key1] <= 0) {
                                    $this->data['message'] = 'Enter obtained marks';
                                    error($this->data);
                                }else {
                                    $totalMarksObtained += $this->request->getPost($iden.'marks_obtained')[$key1];
                                }
                            }
                        }

                        $mData['subjects'][$key] = $this->request->getPost($iden.'subject');
                        $mData['marks'][$key] = $this->request->getPost($iden.'marks');
                        $mData['marksObtained'][$key] = $this->request->getPost($iden.'marks_obtained');
                        $mData['grade'][$key] = $this->request->getPost($iden.'grade');
                        
                    }
                    $mData['labels'] = $this->request->getPost('label_name');
                }


                $totalMarks = $this->request->getPost('totalMarks');
                $overallGrade = getGradeNPercentage($totalMarks, $totalMarksObtained);
                $overallPercentage = getGradeNPercentage($totalMarks, $totalMarksObtained, 'p');
                $data = $this->request->getPost();

                //Marksheet Number Generate
                $marksheetPrefix = fieldValue('branch', 'marksheet_prefix', array('id' => $this->session->branchData['id']));
                $courseShortName = strtoupper(clean($this->request->getPost('short_name')));
                $marksheet_no = str_replace('[COURSE]', $courseShortName, $marksheetPrefix).leadingZero($data['admission_id'], 4);
                //End

                $dataArr = array(
                    'branch_id' => $this->session->branchData['id'],
                    'admission_id' => $data['admission_id'],
                    'course_id' => $data['course_id'],
                    'typing_speed' => $data['typing_speed'],
                    'enrollment_number' => $data['enrollment_number'],
                    'marksheet_no' => $marksheet_no,
                    'candidate_name' => $data['candidate_name'],
                    'father_name' => $data['father_name'],
                    'from_session' => strtotime($data['from_session']),
                    'to_session' => strtotime($data['to_session']),
                    'atp_name' => $data['atp_name'],
                    'labels' => ((empty($mData['labels']))?'':serialize($mData['labels'])),
                    'subjects' => serialize($mData['subjects']),
                    'marks' => serialize($mData['marks']),
                    'marks_obtained' => serialize($mData['marksObtained']),
                    'grade' => serialize($mData['grade']),
                    'total_marks' => $totalMarks,
                    'total_marks_obtained' => $totalMarksObtained,
                    'overall_grade' => $overallGrade,
                    'overall_percentage' => $overallPercentage,
                    'student_photo' => $data['student_photo'],
                    'created_at' => strtotime('now'),
                );

                if ($lastId = $this->crud->add('marksheets', $dataArr)) {
                    $marksheetPrefix = fieldValue('branch', 'marksheet_prefix', array('id' => $this->session->branchData['id']));
                    $courseShortName = strtoupper(clean($this->request->getPost('short_name')));
                    //$marksheetArr['marksheet_no'] = str_replace('[COURSE]', $courseShortName, $marksheetPrefix).leadingZero($lastId, 4);
                   // $this->crud->updateData('marksheets', array('id' => $lastId), $marksheetArr);


                    $notiArr = array(
                        'from_id' => $this->session->branchData['id'],
                        'form_id_type' => 2,
                        'to_id' => 1,
                        'to_id_type' => 1,
                        'type' => 'marksheet_apply',
                        'slug' => 'marksheet-apply',
                        'date' => strtotime('now'),
                    );
                    $this->notification->addNotification('notifications', $notiArr);


                    $this->data['success'] = true;
                    $this->data['redirect'] = site_url('branch/marksheet/marksheet-details/'.encrypt($lastId));
                    $this->data['message'] = 'Admission data has been submitted for marsheets';
                    echo json_encode($this->data);
                }
            }
        }
    }

    public function marksheet_details($id = '')
    {
        if ($this->request->getMethod('get') && !$this->request->isAJAX()) {
            $id = decrypt($id);
            if (!empty($id) && is_numeric($id)) {
               $this->data['details'] = $details = $this->crud->select('marksheets', '', array('id' => $id, 'branch_id' => $this->session->branchData['id']), '', true);
               if (!empty($details)) {
                // pr($details);
                   $this->data['title'] = 'Marksheet Details';
                   return view('branch/marksheet/marksheet-details', $this->data);
               }else {
                   $this->session->setFlashData('message', 'Access Denied');
                   $this->session->setFlashData('message_type', 'error');
                   return redirect()->to('/branch/marksheet'); die;
               }
            }
        }
    }


    public function ajax_dt_get_marksheet_list()
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
        $totalRecords = get_count('marksheets', array('branch_id' => $branchId));
        ## Total number of records with filtering
        $totalRecordwithFilter = $totalRecords;
        $where .= "`marksheets.branch_id`=$branchId";
        if (!empty($keyword)) {
            $where .= empty($where)?"`marksheets.marksheet_no` LIKE '%$keyword%' ESCAPE '!' OR `marksheets.enrollment_number` LIKE '%$keyword%' ESCAPE '!' OR `marksheets.candidate_name` LIKE '%$keyword%' ESCAPE '!' OR `course.short_name` LIKE '%$keyword%' ESCAPE '!'":" AND `marksheets.marksheet_no` LIKE '%$keyword%' ESCAPE '!' OR `marksheets.enrollment_number` LIKE '%$keyword%' ESCAPE '!' OR `marksheets.candidate_name` LIKE '%$keyword%' ESCAPE '!' OR `course.short_name` LIKE '%$keyword%' ESCAPE '!'";
        }
        if (!empty($status)) {
            $where .= empty($where)?"`marksheets.status`=$status":" AND `marksheets.status`=$status";
        }
        if (!empty($where)) {
            $totalRecordwithFilter = $this->dt->getMarksheetListCount($where);
        }

        ## Fetch records
        $records = $this->dt->getAjaxDatatableMarksheetList($keyword, $columnSortOrder, $rowperpage, $start, $branchId, $status);
        $data = array();
        $i = $start+1;
        foreach($records as $record ){
            $actions = ''; $subAction = '';
            if (!empty($record->marksheet_file && $record->status == 4)) {
                $subAction .= '<a class="dropdown-item" href="'.site_url('public/upload/branch-files/student/marksheet/'.$record->marksheet_file).'" download="'.$record->marksheet_file.'">Download Marksheet</a>';
            }
            
            $actions .= '<div class="dropdown show">
            <a  href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-ellipsis-h"></i>
            </a>
            <div class="drp-select dropdown-menu">
            <a class="dropdown-item" href="'.site_url('branch/marksheet/marksheet-details/'.encrypt($record->id)).'" >Details</a>
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
                $req = 'Marksheet: <b class="text-muted">Urgent</b>';
            }else {
                $req = 'Marksheet: <b class="text-muted">Regular</b>';
            }

            $data[] = array( 
                "slNo" => $i++,
                "student" => $record->candidate_name.'<br>'.$record->enrollment_number.'</br>'.$req,
                "marksheet_number" => $record->marksheet_no,
                "course" => $record->short_name,
                "session" => date('M y', $record->from_session).'-'.date('M y', $record->to_session),
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
