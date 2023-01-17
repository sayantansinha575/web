<?php
namespace App\Controllers\Headoffice;

use App\Models\Crud_model;
use App\Models\Datatable_model;
use App\Models\Headoffice\Document_model;
use App\Models\Notification_model;


use Config\Services;

class Document extends BaseController
{

    public function __construct()
    {
        $db = db_connect();
        $this->request = \Config\Services::request();
        $this->session = \Config\Services::session();

        $this->crud = new Crud_model($db);
        $this->dt = new Datatable_model($db);
        $this->doc = new Document_model($db);
        $this->notification = new Notification_model($db);

        //load helper
        helper('custom');
    }

    public function index()
    {
        if(($this->request->getMethod() == "get") && !$this->request->isAjax()){
            $this->data['title'] = 'Study Materials';
            return view('headoffice/document/manage-study-materials', $this->data);
        }
    }

    public function branch_document()
    {
        if(($this->request->getMethod() == "get") && !$this->request->isAjax()){
            $this->data['title'] = 'Branch Document';
            $this->data['branches'] = $this->crud->select('branch', 'branch_name, id, branch_code', array('status' => 1));
            return view('headoffice/document/manage-branch-document', $this->data);
        }
    }

    public function add_branch_document($id = 0)
    {
        $active_branch_details = $this->crud->select('branch', '*', array('status' => 1));
        if(($this->request->getMethod() == "get") && !$this->request->isAjax()){
            $this->data['title'] = ($id)?'Update Branch Document':' Add Branch Documents';
            if (!empty($id) && is_numeric($id)) {
                $this->data['details'] = $this->crud->select('media', '', ['id' => $id], '', true);
            }     
            return view('headoffice/document/save-branch-documents', $this->data);  

        }else {
            if (($this->request->getMethod() == "post") && $this->request->isAjax()) {                     
                $this->data['success'] = false;
                $this->data['hash'] = csrf_hash();
                $fileNameArr = array();
                if (strlen($this->request->getPost('description')) == 0) {
                    $this->data['message'] = 'Enter description';
                    echo json_encode($this->data); die;
                }
                if (strlen($_FILES['documents']['tmp_name'][0]) == 0) {
                    $this->data['message'] = 'Select documents to upload.';
                    echo json_encode($this->data); die;
                }

               
                $desc = $this->request->getPost('description');
               
                if (strlen($_FILES['documents']['tmp_name'][0]) != 0) {
                    $fileNameArr = uploadFileMultiple('upload/files/branch/branch-documents', 'documents', '', "-HO");
                }
                $docArr = array(
                    'type' => 2,
                    'documents' => serialize($fileNameArr),
                    'description' => $desc,
                );
                if (!empty($id) && is_numeric($id)) {
                    unset($docArr['type'], $docArr['documents']);
                    if (!empty($fileNameArr)) {
                        $existingFiles = fieldValue('media', 'documents', array('id' => $id));
                        $existingFiles = unserialize($existingFiles);
                        $docArr['documents'] = serialize(array_merge($existingFiles, $fileNameArr)); 
                    }
                   
                    if ($this->crud->updateData('media', array('id' => $id, 'type' => 2), $docArr)) {

                        foreach( $active_branch_details as $abd ){
                            $branch_id = $abd->id;
                            $notiArr = array(
                                'from_id' => $this->session->userData['id'],
                                'form_id_type' => 1,
                                'to_id' => $branch_id,
                                'to_id_type' => 2,
                                'type' => 8,
                                'slug' => 'update-branch-document',
                                'date' => strtotime('now'),
                            );
                            $this->notification->addNotification('notifications', $notiArr);
                        }

                       $this->data['success'] = true;
                       $this->data['message'] = 'Docuements for branch has been successfully updated.';
                       echo json_encode($this->data); die;
                    }else {
                        $this->data['message'] = 'Something went wrong';
                        error($this->data);
                    }
                } else {
                    if ($this->crud->add('media', $docArr)) {

                        foreach( $active_branch_details as $abd ){
                            $branch_id = $abd->id;
                            $notiArr = array(
                                'from_id' => $this->session->userData['id'],
                                'form_id_type' => 1,
                                'to_id' => $branch_id,
                                'to_id_type' => 2,
                                'type' => 7,
                                'slug' => 'new-branch-document',
                                'date' => strtotime('now'),
                            );
                            $this->notification->addNotification('notifications', $notiArr);
                        }

                        $this->data['success'] = true;
                        $this->data['message'] = 'Docuements for branch has been successfully uploaded.';
                        echo json_encode($this->data); die;
                    }
                }
                
            }
        }
    }

    public function doc_details($id = 0)
    {
        if(($this->request->getMethod() == "get") && !$this->request->isAjax()){
            $this->data['title'] = 'Document Details';

            if (!empty($id) && is_numeric($id)) {
                if (!empty($details = $this->crud->select('course_study_materials', '', array('id' => $id), '', true)))
                {
                    $this->data['documents'] = $this->crud->select('media', '', array('parent_id' => $id, 'type' => 1));
                    $this->data['details'] = $details;
                }else {
                    $this->session->setFlashData('message', 'No data found');
                    $this->session->setFlashData('message_type', 'error');
                    return redirect()->to('/head-office/document/study-materials');
                }
            }
            return view('headoffice/document/details-study-mats', $this->data);
        }
    }

    public function edit_files($parentId = 0, $id = 0)
    {
        if(($this->request->getMethod() == "get") && !$this->request->isAjax()){
            $this->data['title'] = 'Edit Files';

            if (!empty($id) && is_numeric($id)) {
                if (!empty($details = $this->doc->getDocDetails($id)))
                {
                    $this->data['details'] = $details;
                }else {
                    $this->session->setFlashData('message', 'No data found');
                    $this->session->setFlashData('message_type', 'error');
                    return redirect()->to("/head-office/document/details/$parentId");
                }
            }
            return view('headoffice/document/edit-files', $this->data);

        }else {

            if (($this->request->getMethod() == "post") && $this->request->isAjax()) {
                $this->data['success'] = false;
                $this->data['hash'] = csrf_hash();
                $fileNameArr = array();

                if (strlen($this->request->getPost('description')) == 0) {
                    $this->data['message'] = 'Enter description';
                    error($this->data);
                }
                $courseId = $this->request->getPost('course_id');
                $desc = $this->request->getPost('description');

                $dataArr = array(
                   'description' => $desc,
                );

                if (strlen($_FILES['documents']['tmp_name'][0]) != 0) {
                    $fileNameArr = uploadFileMultiple('upload/files/branch/course-documents/'.$courseId, 'documents', '', "-$courseId");
                }

                if ($id && $parentId) {
                    if (!empty($fileNameArr)) {
                        $existingFiles = fieldValue('media', 'documents', array('id' => $id));
                        $existingFiles = unserialize($existingFiles);
                        $dataArr['documents'] = serialize(array_merge($existingFiles, $fileNameArr)); 
                    }
                   
                    if ($this->crud->updateData('media', array('id' => $id), $dataArr)) {

                        $active_branch_details = $this->crud->select('branch', '*', array('status' => 1));
                        foreach( $active_branch_details as $abd ){
                            $branch_id = $abd->id;
                            $notiArr = array(
                                'from_id' => $this->session->userData['id'],
                                'form_id_type' => 1,
                                'to_id' => $branch_id,
                                'to_id_type' => 2,
                                'type' => 6,
                                'slug' => 'study-material-updated',
                                'date' => strtotime('now'),
                            );
                            $this->notification->addNotification('notifications', $notiArr);
                        }


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

    public function add_files($parentId = 0)
    {
        if(($this->request->getMethod() == "get") && !$this->request->isAjax()){
            $this->data['title'] = 'Add Files';

            if (!empty($parentId) && is_numeric($parentId)) {
                if (!empty($details = $this->doc->getDocDetailsbyParentId($parentId)))
                {
                    $this->data['details'] = $details;
                }else {
                    $this->session->setFlashData('message', 'No data found');
                    $this->session->setFlashData('message_type', 'error');
                    return redirect()->to("/head-office/document/details/$parentId");
                }
            }
            return view('headoffice/document/add-files', $this->data);

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
                $courseId = $this->request->getPost('course_id');
                $desc = $this->request->getPost('description');

                $dataArr = array(
                    'type' => 1,
                    'parent_id' => $parentId,
                    'description' => $desc,
                );

                if (strlen($_FILES['documents']['tmp_name'][0]) != 0) {
                    $fileNameArr = uploadFileMultiple('upload/files/branch/course-documents/'.$courseId, 'documents', '', "-$courseId");
                }

                if ($parentId) {
                    if (!empty($fileNameArr)) {
                        $dataArr['documents'] = serialize($fileNameArr); 
                    }
                   
                    if ($lastId = $this->crud->add('media', $dataArr)) {
                       $this->data['success'] = true;
                       $this->data['redirect'] = site_url('head-office/document/edit-files/'.$parentId.'/'.$lastId);
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

    public function add_study_material()
    {
        if(($this->request->getMethod() == "get") && !$this->request->isAjax()){
            $this->data['title'] = 'Study Materials';
            $this->data['courseType'] = $this->crud->select('course_type');
            return view('headoffice/document/save-study-mats', $this->data);
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
                $courseId = $this->request->getPost('course_name');
                $desc = $this->request->getPost('notes');
                $data = $this->request->getPost();
                $dataArr = array(
                    'course_type' => $data['course_type'],
                    'course_id' => $courseId,
                    'added_by' => 1,
                    'created_by' => $this->session->userData['id'],
                );
                if (strlen($_FILES['documents']['tmp_name'][0]) != 0) {
                    $fileNameArr = uploadFileMultiple('upload/files/branch/course-documents/'.$courseId, 'documents', '', "-$courseId");
                }
                $dataArr['created_at'] = strtotime('now');
                if ($lastId = $this->crud->add('course_study_materials', $dataArr)) {
                    

                    $active_branch_details = $this->crud->select('branch', '*', array('status' => 1));
                    foreach( $active_branch_details as $abd ){
                        $branch_id = $abd->id;
                        $notiArr = array(
                            'from_id' => $this->session->userData['id'],
                            'form_id_type' => 1,
                            'to_id' => $branch_id,
                            'to_id_type' => 2,
                            'type' => 5,
                            'slug' => 'new-study-material-creation',
                            'date' => strtotime('now'),
                        );
                        $this->notification->addNotification('notifications', $notiArr);
                    }


                    $docArr = array(
                        'parent_id' => $lastId,
                        'type' => 1,
                        'documents' => serialize($fileNameArr),
                        'description' => $desc,
                    );
                    if ($this->crud->add('media', $docArr)) {
                        $this->data['success'] = true;
                        $this->data['redirect'] = site_url('head-office/document/details/'.$lastId);
                        $this->data['message'] = 'Study materials has been successfully uploaded.';
                        echo json_encode($this->data); die;
                    }
                }
            }
        }
    }

    public function ajax_dt_get_study_material_list()
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

        ## Total number of records without filtering
        $totalRecords = get_count('course_study_materials', ['added_by' => 1]);
        ## Total number of records with filtering
        $totalRecordwithFilter = $totalRecords;
    
        if (!empty($keyword)) {
            $where .= empty($where)?"`course.short_name` LIKE '%$keyword%' ESCAPE '!' OR `course.course_name` LIKE '%$keyword%' ESCAPE '!' OR `course_type.course_type` LIKE '%$keyword%' ESCAPE '!'":" AND `course.short_name` LIKE '%$keyword%' ESCAPE '!' OR `course.course_name` LIKE '%$keyword%' ESCAPE '!' OR `course_type.course_type` LIKE '%$keyword%' ESCAPE '!'";
        }

        if (!empty($where)) {
            $totalRecordwithFilter = $this->dt->getStudyMatsListCount($where);
        }


        ## Fetch records
        $records = $this->dt->getAjaxDatatableHoStudyMatsList($keyword, $columnSortOrder, $rowperpage, $start);
        $data = array();
        $i = $start+1;
        foreach($records as $record ){
            $actions = '';

            $actions .= '<a href="'.site_url('head-office/document/details/').$record->id.'" class="btn btn-info btn-sm btn-icon" data-toggle="tooltip" title="Details"><i class="fa-solid fa-eye"></i></a>';


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

    public function ajax_dt_get_branch_doc_list()
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

        ## Total number of records without filtering
        $totalRecords = get_count('media', ['type' => 2]);
        ## Total number of records with filtering
        $totalRecordwithFilter = $totalRecords;

        ## Fetch records
        $records = $this->dt->getAjaxDatatableBranchDocsListByHo($columnSortOrder, $rowperpage, $start);
        $data = array();
        $i = $start+1;
        foreach($records as $record ){
            $actions = '';

            $actions .= '<a href="'.site_url('head-office/document/add-branch-document/').$record->id.'" class="btn btn-dark btn-sm btn-icon" data-toggle="tooltip" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>';
            $actions .= '<a href="javascript:void(0)" data-id="'.$record->id.'" class="btn btn-danger btn-sm btn-icon deleteAllBranchDoc" data-toggle="tooltip" title="Delete"><i class="fa-solid fa-trash"></i></a>';


            $data[] = array( 
                "slNo" => $i++,
                "title" => limitString($record->description, 15),
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

    public function ajax_get_course_by_type()
    {   
        if ($this->request->isAjax()) {
            $type =  $this->request->getPost('type');
            $record = $this->crud->select('course', '', ['course_type' => $type], 'id DESC');
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

    public function ajax_get_document_details_course()
    {   
        if ($this->request->isAjax()) {
            $this->data['success'] = false;
            $this->data['hash'] = csrf_hash();
            $html = '';
            $courseId =  $this->request->getPost('courseId');
            $courseTypeID =  $this->request->getPost('courseTypeID');

            $details = $this->crud->select('course_study_materials', '', array('added_by' => 1, 'course_type' => $courseTypeID, 'course_id' => $courseId), '', true);

            if (!empty($details)) {
                $this->data['redirect'] = site_url('head-office/document/details/'.$details->id);
                $this->data['success'] = true;
                $this->data['details'] = $details;
                echo json_encode($this->data); die;
            }else {
                error($this->data);
            } 
        }
    }

    public function delete_study_material()
    {   
        if ($this->request->isAjax()) {
            $this->data['success'] = false;
            $this->data['hash'] = csrf_hash();
            $data =  $this->request->getPost('data');
            $dataArr = explode('||', $data);
            $fileNAme = $dataArr[0];
            $courseId = $dataArr[1];
            $parentId = $dataArr[2];
            $mediaId = $dataArr[3];
            $type = end($dataArr);

            if ($type == 2) {
                $existingFiles = fieldValue('media', 'documents', array('id' => $mediaId, 'type' => 2));
                define('PATH', 'upload/files/branch/branch-documents/');
            } else {
                $existingFiles = fieldValue('media', 'documents', array('id' => $mediaId, 'parent_id' => $parentId, 'type' => 1));
                define('PATH', 'upload/files/branch/course-documents/'.$courseId.'/');
            }

            $existingFiles = unserialize($existingFiles);

            if (!empty($existingFiles)) {
                if (($key = array_search($fileNAme, $existingFiles)) !== false) {
                    unset($existingFiles[$key]);
                }
                $updDataArr['documents'] = serialize($existingFiles);
            }
            if ($type == 2) {
                $whereArr = array('id' => $mediaId, 'type' => 2);
            } else {
                $whereArr = array('id' => $mediaId, 'parent_id' => $parentId, 'type' => 1);
            }

            if ($this->crud->updateData('media', $whereArr, $updDataArr)) {
                if (file_exists(PATH.$fileNAme)) {
                    if (unlink(PATH.$fileNAme)) {

                    }else {
                        $this->data['message'] = 'Something went wrong!';
                        error($this->data);
                    }
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

    public function delete_study_material_section()
    {   
        if ($this->request->isAjax()) {
            $this->data['success'] = false;
            $this->data['hash'] = csrf_hash();
            $data =  $this->request->getPost('data');
            $dataArr = explode('||', $data);
            $id = $dataArr[0];
            $courseId = end($dataArr);

            define('PATH', 'upload/files/branch/course-documents/'.$courseId.'/');
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
                    $this->data['success'] = true;
                    $this->data['redirect'] = site_url('head-office/document/details/'.$details->parent_id);
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

    public function delete_bulk_branch_docs()
    {   
        if ($this->request->isAjax()) {
            $this->data['success'] = false;
            $this->data['hash'] = csrf_hash();
            $id =  $this->request->getPost('id');

            define('PATH', 'upload/files/branch/branch-documents/');
            $details = $this->crud->select('media', '', array('id' => $id, 'type' => 2), '', true);
            if (!empty($details)) {
                $files = unserialize($details->documents);
                foreach ($files as $key => $file) {
                    $path = PATH.$file;
                    if (!file_exists("public/$path")) {
                        unlink($path);
                    }
                }
                if ($this->crud->deleteData('media', array('id' => $id, 'type' => 2))) {
                    $this->data['success'] = true;
                    $this->data['message'] = 'Title and files has been successfully deleted';
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
