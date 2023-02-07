<?php
namespace App\Controllers\Branch;

use App\Models\Branch\Student_model;
use App\Models\Branch\Document_model;
use App\Models\Notification_model;





use Config\Services;

class Document extends BaseController
{

    public function __construct()
    {
        $db = db_connect();
        $this->stud = new Student_model($db);
        $this->doc = new Document_model($db);
        $this->db = $db;
        $this->notification = new Notification_model($db);
    }

    public function manage_study_materials()//done
    {
        if(($this->request->getMethod() == "get") && !$this->request->isAjax()){
            $this->data['title'] = 'Study Materials';
            return view('branch/document/manage-study-materials', $this->data);
        }
    }

    public function docs_from_head_office()
    {
        if(($this->request->getMethod() == "get") && !$this->request->isAjax()){
            $this->data['title'] = 'Docuemnts From Head Office';
            return view('branch/document/manage-ho-docs', $this->data);
        }
    }

    public function view_study_material($parentId = 0, $id = 0)
    {
        $parentId = decrypt($parentId);
        $id = decrypt($id);
        if(($this->request->getMethod() == "get") && !$this->request->isAjax()){
            $this->data['title'] = 'View Study Materials';

            if (!empty($id) && is_numeric($id)) {
                if (!empty($details = $this->doc->getDocDetailsForView($id, $this->session->branchData['id'])))
                {
                    $this->data['details'] = $details;
                }else {
                    $this->session->setFlashData('message', 'No data found');
                    $this->session->setFlashData('message_type', 'error');
                    return redirect()->to("/branch/document/details/".encrypt($parentId));
                }
            }
            return view('branch/document/view-study-materials', $this->data);
        }
    }

    public function details($id = 0)//done
    {
        if(($this->request->getMethod() == "get") && !$this->request->isAjax()){
            $this->data['title'] = 'Document Details';
            $id = decrypt($id);
            if (!empty($id) && is_numeric($id)) {
                $branchId = $this->session->branchData['id'];
                $parentIds = array();

                if (!empty($details = $this->crud->select('course_study_materials', '', "course_id=$id AND ((added_by=1) OR (added_by=2 AND created_by=$branchId))", '')))
                {
                    foreach ($details as $det) {
                        $parentIds[] = $det->id;
                    }
                    $this->data['documents'] = $this->doc->getMedias($parentIds);
                    $this->data['details'] = $details[0];
                }else {
                    $this->session->setFlashData('message', 'No data found');
                    $this->session->setFlashData('message_type', 'error');
                    return redirect()->to('/branch/document/manage-study-materials');
                }
            }
            return view('branch/document/details-study-mats', $this->data);
        }
    }

    public function ho_doc_details($id = 0)//done
    {
        if(($this->request->getMethod() == "get") && !$this->request->isAjax()){
            $this->data['title'] = 'Document Details';
            $id = decrypt($id);
            if (!empty($id) && is_numeric($id)) {
                if (!empty($details = $this->crud->select('media', '', array('id' => $id, 'type' => 2), '', true)))
                {
                    $this->data['details'] = $details;
                }else {
                    $this->session->setFlashData('message', 'No data found');
                    $this->session->setFlashData('message_type', 'error');
                    return redirect()->to('/branch/document/docs-from-head-office');
                }
            }
            return view('branch/document/ho-doc-details', $this->data);
        }
    }

    public function edit_files($parentId = 0, $id = 0)//done
    {
        $parentId = decrypt($parentId);
        $id = decrypt($id);
        if(($this->request->getMethod() == "get") && !$this->request->isAjax()){
            $this->data['title'] = 'Edit Files';

            if (!empty($id) && is_numeric($id)) {
                if (!empty($details = $this->doc->getDocDetails($id, $this->session->branchData['id'])))
                {
                    $this->data['details'] = $details;
                }else {
                    $this->session->setFlashData('message', 'No data found');
                    $this->session->setFlashData('message_type', 'error');
                    return redirect()->to("/branch/document/details".encrypt($parentId));
                }
            }
            return view('branch/document/edit-files', $this->data);

        }else {
            if (($this->request->getMethod() == "post") && $this->request->isAjax()) {
                $this->data['success'] = false;
                $this->data['hash'] = csrf_hash();
                $fileNameArr = array();

                if (strlen($this->request->getPost('description')) == 0) {
                    $this->data['message'] = 'Enter description';
                    error($this->data);
                }
                $branchId = $this->session->branchData['id'];
                $courseId = $this->request->getPost('course_id');
                $desc = $this->request->getPost('description');

                $dataArr = array(
                   'description' => $desc,
                );

                if (strlen($_FILES['documents']['tmp_name'][0]) != 0) {
                    $fileNameArr = uploadFileMultiple('upload/files/branch/course-documents/'.$courseId.'/'.$branchId, 'documents', '', "-$courseId-$branchId");
                }

                if ($id && $parentId) {
                    if (!empty($fileNameArr)) {
                        $existingFiles = fieldValue('media', 'documents', array('id' => $id));
                        $existingFiles = unserialize($existingFiles);
                        $dataArr['documents'] = serialize(array_merge($existingFiles, $fileNameArr)); 
                    }
                   
                    if ($this->crud->updateData('media', array('id' => $id), $dataArr)) {

                        $notiArr = array(
                            'from_id' => $this->session->branchData['id'],
                            'form_id_type' => 2,
                            'to_id' => 1,
                            'to_id_type' => 1,
                            'type' => 'update_study_material',
                            'slug' => 'study-material-updated',
                            'date' => strtotime('now'),
                        );
                        $this->notification->addNotification('notifications', $notiArr);

                       $this->data['success'] = true;
                       $this->data['message'] = 'Files has been successfully updated.';
                       echo json_encode($this->data); die;
                    }else {
                        $this->data['message'] = 'Something went wrong';
                        error($this->data);
                    }
                }else {
                    $this->data['message'] = 'Something went wrong';
                    error($this->data);
                }
            }
        }
    }

    public function add_files($parentId = 0)//done
    {
        $parentId = decrypt($parentId);
        if(($this->request->getMethod() == "get") && !$this->request->isAjax()){
            $this->data['title'] = 'Add Files';

            if (!empty($parentId) && is_numeric($parentId)) {
                if (!empty($details = $this->doc->getDocDetailsbyParentId($parentId, $this->session->branchData['id'])))
                {
                    $this->data['details'] = $details;
                }else {
                    $this->session->setFlashData('message', 'No data found');
                    $this->session->setFlashData('message_type', 'error');
                    return redirect()->to("/branch/document/details/".encrypt($parentId));
                }
            }
            return view('branch/document/add-files', $this->data);

        }else {
            if (($this->request->getMethod() == "post") && $this->request->isAjax()) {
                $this->data['success'] = false;
                $this->data['hash'] = csrf_hash();
                $fileNameArr = array();

                if (strlen($this->request->getPost('description')) == 0) {
                    $this->data['message'] = 'Enter description';
                    error($this->data);
                }
                if (strlen($_FILES['documents']['tmp_name'][0]) == 0) {
                    $this->data['message'] = 'Select documents to upload.';
                    echo json_encode($this->data); die;
                }
                $branchId = $this->session->branchData['id'];
                $courseId = $this->request->getPost('course_id');
                $desc = $this->request->getPost('description');

                if ($branchParentData = $this->crud->select('course_study_materials', '', ['added_by' => 2, 'created_by' => $branchId, 'course_id' => $courseId], '', true)) {
                    $parentId = $branchParentData->id;
                }else {
                    $parentArr = array(
                        'added_by' => 2,
                        'branch_id' => $branchId,
                        'course_type' => fieldValue('course', 'course_type', ['id' => $courseId]),
                        'course_id' => $courseId,
                        'created_at' =>  strtotime('now'),
                        'created_by' => $branchId
                    );
                    $parentId = $this->crud->add('course_study_materials', $parentArr);
                }
                $dataArr = array(
                    'type' => 1,
                    'parent_id' => $parentId,
                    'description' => $desc,
                );

                if (strlen($_FILES['documents']['tmp_name'][0]) != 0) {
                    $fileNameArr = uploadFileMultiple('upload/files/branch/course-documents/'.$courseId.'/'.$branchId, 'documents', '', "-$courseId-$branchId");
                }

                if ($parentId) {
                    if (!empty($fileNameArr)) {
                        $dataArr['documents'] = serialize($fileNameArr); 
                    }
                   
                    if ($lastId = $this->crud->add('media', $dataArr)) {
                       $this->data['success'] = true;
                       $this->data['redirect'] = site_url('branch/document/edit-files/'.encrypt($parentId).'/'.encrypt($lastId));
                       $this->data['message'] = 'Files has been successfully added.';
                       echo json_encode($this->data); die;
                    }else {
                        $this->data['message'] = 'Something went wrong';
                        error($this->data);
                    }
                }else {
                    $this->data['message'] = 'Something went wrong';
                    error($this->data);
                }
            }
        }
    }

    public function add_study_materials()
    {
        if(($this->request->getMethod() == "get") && !$this->request->isAjax()){
            $this->data['title'] = 'Study Materials';
            $this->data['courseType'] = $this->crud->select('course_type');
            return view('branch/document/save-study-mats', $this->data);
        }else {
            if (($this->request->getMethod() == "post") && $this->request->isAjax()) {                     
                $this->data['success'] = false;
                $this->data['hash'] = csrf_hash();
                $fileNameArr = array();
                if (strlen($this->request->getPost('course_type')) == 0) {
                    $this->data['id'] = '#course_typeDD';
                    $this->data['message'] = 'Select course type.';
                    error($this->data);
                }
                if (strlen($this->request->getPost('course_name')) == 0) {
                    $this->data['id'] = '#course_nameDD';
                    $this->data['message'] = 'Select course.';
                    error($this->data);
                }
                if (strlen($this->request->getPost('notes')) == 0) {
                    $this->data['message'] = 'Enter description';
                    echo json_encode($this->data); die;
                }
                if (strlen($_FILES['documents']['tmp_name'][0]) == 0) {
                    $this->data['message'] = 'Select documents to upload.';
                    echo json_encode($this->data); die;
                }
                $branchId = $this->session->branchData['id'];
                $courseId = $this->request->getPost('course_name');
                $desc = $this->request->getPost('notes');
                $data = $this->request->getPost();
                $dataArr = array(
                    'course_type' => $data['course_type'],
                    'added_by' => 2,
                    'branch_id' => $branchId,
                    'course_id' => $courseId,
                    'created_by' => $branchId,
                );
                if (strlen($_FILES['documents']['tmp_name'][0]) != 0) {
                    $fileNameArr = uploadFileMultiple('upload/files/branch/course-documents/'.$courseId.'/'.$branchId, 'documents', '', "-$courseId-$branchId");
                }
                $dataArr['created_at'] = strtotime('now');
                if ($lastId = $this->crud->add('course_study_materials', $dataArr)) {
                  
                    $notiArr = array(
                        'from_id' => $this->session->branchData['id'],
                        'form_id_type' => 2,
                        'to_id' => 1,
                        'to_id_type' => 1,
                        'type' => 'new_study_material',
                        'slug' => 'new-study-material-creation',
                        'date' => strtotime('now'),
                    );
                    $this->notification->addNotification('notifications', $notiArr);

                    $docArr = array(
                        'parent_id' => $lastId,
                        'type' => 1,
                        'documents' => serialize($fileNameArr),
                        'description' => $desc,
                    );
                    if ($this->crud->add('media', $docArr)) {
                        $this->data['success'] = true;
                        $this->data['redirect'] = site_url('branch/document/details/'.encrypt($lastId));
                        $this->data['message'] = 'Study materials has been successfully uploaded.';
                        echo json_encode($this->data); die;
                    }
                }
            }
        }
    }

    public function ajax_dt_get_study_materials_list() //done
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
        $branchId = $this->session->branchData['id'];
        $courseIds = $this->doc->getActiveCourseIdOfBranch($branchId);
        ## Total number of records without filtering
        $totalRecords = (empty($courseIds))?0:$this->dt->getStudyMatsListCountBranch('', $courseIds);

        ## Total number of records with filtering
        $totalRecordwithFilter = $totalRecords;
        if (!empty($branchId)) {
            $where .= "`course_study_materials.branch_id`=$branchId";
        }
        if (!empty($keyword)) {
            $where .= empty($where)?"`course.short_name` LIKE '%$keyword%' ESCAPE '!' OR `course.course_name` LIKE '%$keyword%' ESCAPE '!' OR `course_type.course_type` LIKE '%$keyword%' ESCAPE '!' OR `branch.branch_code` LIKE '%$keyword%' ESCAPE '!'":" AND `course.short_name` LIKE '%$keyword%' ESCAPE '!' OR `course.course_name` LIKE '%$keyword%' ESCAPE '!' OR `course_type.course_type` LIKE '%$keyword%' ESCAPE '!' OR `branch.branch_code` LIKE '%$keyword%' ESCAPE '!'";
        }

        if (!empty($where)) {
            $totalRecordwithFilter = $this->dt->getStudyMatsListCountBranch($where, $courseIds);
        }


        ## Fetch records
        $records = $this->dt->getAjaxDatatableHoStudyMatsListBranch($keyword, $columnSortOrder, $rowperpage, $start, $branchId, $courseIds);
        $data = array();
        $i = $start+1;
        foreach($records as $record ){
            $actions = ''; $subAction = '';
            
            $actions .= '<div class="dropdown show">
            <a  href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-ellipsis-h"></i>
            </a>
            <div class="drp-select dropdown-menu">
            <a class="dropdown-item" href="'.site_url('branch/document/details/'.encrypt($record->course_id)).'" >Details</a>
            '.$subAction.'
            </div>
            </div>';

            $data[] = array( 
                "slNo" => $i++,
                "course_name" => $record->short_name.'<br>'.$record->course_name,
                "course_type" => $record->courseTypeName,
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

    public function ajax_dt_get_ho_docs_list() //done
    {
        $postData = $this->request->getPost();
        $dtpostData = $postData['data'];
        $response = array();
        ## Read value
        $draw = $dtpostData['draw'];
        $start = $dtpostData['start'];
        $rowperpage = $dtpostData['length'];
        $columnIndex = $dtpostData['order'][0]['column'];
        $columnName = $dtpostData['columns'][$columnIndex]['data'];
        $columnSortOrder = $dtpostData['order'][0]['dir'];
       

        ## Total number of records without filtering
        $totalRecords = get_count('media', array('type' => 2));
        ## Total number of records with filtering
        $totalRecordwithFilter = $totalRecords;

        ## Fetch records
        $records = $this->dt->getAjaxDatatableBranchDocsListByHo($columnSortOrder, $rowperpage, $start);

        $data = array();
        $i = $start+1;
        foreach($records as $record ){
            $actions = ''; $subAction = '';
            
            $actions .= '<div class="dropdown show">
            <a  href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-ellipsis-h"></i>
            </a>
            <div class="drp-select dropdown-menu">
            <a class="dropdown-item" href="'.site_url('branch/document/ho-doc-details/'.encrypt($record->id)).'" >Details</a>
            '.$subAction.'
            </div>
            </div>';

            $data[] = array( 
                "slNo" => $i++,
                "title" => limitString(strip_tags($record->description), 12),
                "doc_count" => count(unserialize($record->documents)),
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

    public function ajax_get_course_by_type()//done
    {   
        if ($this->request->isAjax()) {
            $this->data['hash'] = csrf_hash();
            $type =  $this->request->getPost('type');
            $branchId =  $this->session->branchData['id'];
            $record = $this->stud->GetCoursesByType($type, $branchId);
            $html = '<option></option>';
            if (!empty($record)) {
                foreach ($record as $rec) {
                    $html .= '<option value="'.$rec->id.'">'.$rec->course_name.'</option>';
                }
            }
            $this->data['success'] = true;
            $this->data['html'] = $html;
            echo json_encode($this->data); die;
        }
    }

    public function ajax_get_document_details_by_course()//done
    {   
        if ($this->request->isAjax()) {
            $this->data['success'] = false;
            $this->data['hash'] = csrf_hash();
            $html = '';
            $courseId =  $this->request->getPost('courseId');
            $branchId =  $this->session->branchData['id'];
            $courseTypeID =  $this->request->getPost('courseTypeID');

            $details = $this->crud->select('course_study_materials', '', array('branch_id' => $branchId, 'course_type' => $courseTypeID, 'course_id' => $courseId, 'added_by' => 2, 'created_by' => $branchId), '', true);

            if (!empty($details)) {
                $this->data['redirect'] = site_url('branch/document/details/'.encrypt($details->course_id));
                $this->data['success'] = true;
                $this->data['details'] = $details;
                echo json_encode($this->data); die;
            }else {
                error($this->data);
            }
            
        }
    }

    public function delete_study_material()//done
    {   
        if ($this->request->isAjax()) {
            $this->data['success'] = false;
            $this->data['hash'] = csrf_hash();
            $data =  $this->request->getPost('data');
            $dataArr = explode('||', $data);
            $fileNAme = $dataArr[0];
            $courseId = decrypt($dataArr[1]);
            $parentId = decrypt($dataArr[2]);
            $mediaId = decrypt(end($dataArr));
            $branchId = $this->session->branchData['id'];

            $existingFiles = fieldValue('media', 'documents', array('id' => $mediaId, 'parent_id' => $parentId, 'type' => 1));
            $existingFiles = unserialize($existingFiles);

            if (!empty($existingFiles)) {
                if (($key = array_search($fileNAme, $existingFiles)) !== false) {
                    unset($existingFiles[$key]);
                }
                $updDataArr['documents'] = serialize($existingFiles);
            }
            define('PATH', 'upload/files/branch/course-documents/'.$courseId.'/'.$branchId.'/');
            if ($this->crud->updateData('media', array('id' => $mediaId, 'parent_id' => $parentId, 'type' => 1), $updDataArr)) {
                if (file_exists(PATH.$fileNAme)) {
                    unlink(PATH.$fileNAme);
                }
                $this->data['success'] = true;
                $this->data['message'] = 'Document has been successfully deleted';
                echo json_encode($this->data); die;
            }else {
                $this->data['message'] = 'Something went wrong!';
                error($this->data);
            }
            

            $this->data['success'] = true;
            $this->data['html'] = $html;
            echo json_encode($this->data); die;
        }
    }

    public function delete_study_material_section() //done
    {
        if ($this->request->isAjax()) {
            $this->data['success'] = false;
            $this->data['hash'] = csrf_hash();
            $data =  $this->request->getPost('data');
            $dataArr = explode('||', $data);
            $id = decrypt($dataArr[0]);
            $courseId = decrypt(end($dataArr));
            $branchId = $this->session->branchData['id'];

            define('PATH', 'upload/files/branch/course-documents/'.$courseId.'/'.$branchId.'/');
            $details = $this->crud->select('media', '', array('id' => $id), '', true);
            if (!empty($details)) {
                $files = unserialize($details->documents);
                foreach ($files as $key => $file) {
                    $path = PATH.$file;
                    if (!file_exists("public/$path")) {
                        unlink($path);
                    }
                }
                if ($this->crud->deleteData('media', array('id' => $id, 'type' => 1))) {

                    $notiArr = array(
                        'from_id' => $this->session->branchData['id'],
                        'form_id_type' => 2,
                        'to_id' => 1,
                        'to_id_type' => 1,
                        'type' => 'delete_study_material',
                        'slug' => 'study-material-delete',
                        'date' => strtotime('now'),
                    );
                    $this->notification->addNotification('notifications', $notiArr);

                    $this->data['success'] = true;
                    $this->data['message'] = 'Description and file has been successfully deleted';
                    echo json_encode($this->data); die;
                }else {
                    $this->data['message'] = 'Something went wrong!';
                    error($this->data);
                }

            }else {
                $this->data['message'] = 'Something went wrong!';
                error($this->data);
            }
        }
    }


}
