<?php
namespace App\Controllers\Employer;



class Employer extends BaseController
{

    public function __construct()
    {
        $db = db_connect();
        
    } 


    public function student_lists()
    {

        //print_r($_SESSION);die;
        if (($this->request->getMethod() == 'get') && (!$this->request->isAjax())) {
            $this->data['title'] = 'Student List';

            return  view('employer/student-list', $this->data);
        }

    }

    public function ajax_dt_get_student_list()
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
        $gender = $dtpostData['gender'];

        ## Total number of records without filtering
        $totalRecords = $this->dt->getStudListCount(array('is_deleted' => 0));
        ## Total number of records with filtering
        $totalRecordwithFilter = $totalRecords;
        if (!empty($status)) {
            $where .= "`student.status`=$status";
        }
        if (!empty($gender)) {
            $where .= empty($where)?"`student.gender`='$gender'":" AND `student.gender`='$gender'";
        }
        if (!empty($keyword)) {
            $where .= empty($where)?"`br.branch_name` LIKE '%$keyword%' ESCAPE '!' OR `student.registration_number` LIKE '%$keyword%' ESCAPE '!' OR `student.student_name` LIKE '%$keyword%' ESCAPE '!' OR `student.mobile` LIKE '%$keyword%' ESCAPE '!'":" AND `br.branch_name` LIKE '%$keyword%' ESCAPE '!' OR `student.registration_number` LIKE '%$keyword%' ESCAPE '!' OR `student.student_name` LIKE '%$keyword%' ESCAPE '!' OR `student.mobile` LIKE '%$keyword%' ESCAPE '!'";
        }
        if (!empty($where)) {
            $totalRecordwithFilter = $this->dt->getStudListCount($where);
        }


        ## Fetch records
        $records = $this->dt->getAjaxDatatableStudentList($status, $keyword, $gender, $columnSortOrder, $rowperpage, $start);
        $data = array();
        $i = $start+1;
        foreach($records as $record ){
            if ($record->status == 1) {
                $statusHtml = '<a href="javascript:void(0)" data-toggle="tooltip" title="Click to inactive" class="changeStudentStatus" data-id="'.$record->id.'" data-val="2"><span class="badge badge-success-lighten">Active</span></a>';
            }else {
                $statusHtml = '<a href="javascript:void(0)" data-toggle="tooltip" title="Click to active" class="changeStudentStatus" data-id="'.$record->id.'" data-val="1"><span class="badge badge-danger-lighten">Inactive</span></a>';
            }

            $actions = '<a href="'.site_url('head-office/student/student-details/').$record->id.'" class="btn btn-info btn-sm btn-icon" data-toggle="tooltip" title="Details"><i class="fa-solid fa-eye"></i></a>';
            $actions .= '<a data-id="'.$record->id.'" href="javascript:void(0)" class="btn btn-danger btn-sm btn-icon deleteStud" data-toggle="tooltip" title="Details"><i class="fa-solid fa-trash"></i></a>';

            $data[] = array( 
                "slNo" => $i++,
                "registration_number" => $record->registration_number,
                "student_name" => $record->student_name,
                "gender" => $record->gender,
                "mobile" => $record->mobile,
                "branch_name" => $record->branch_name,
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

  

}
