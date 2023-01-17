<?php
namespace App\Controllers\Branch;
use App\Models\Notification_model;

class Course extends BaseController
{

    public function __construct()
    {
        $db = db_connect();
        $this->notification = new Notification_model($db);
    }

    public function manage_course()
    {
         if(($this->request->getMethod() == "get") && !$this->request->isAjax()){
            $this->data['title'] = 'Manage Course';
            $branchId = $this->session->branchData['id'];
            $this->data['courseType'] = $this->crud->select('course_type');
            $this->data['courses'] = $this->crud->select('course', 'id, course_name, course_code, course_type', array('status' => 1));
            $this->data['modCourseType'] = $this->crud->select('branch_to_course', 'course_type', array('branch_id' => $branchId, 'status' => 1), '', false, 'course_type');
            $exisitingCourseId = $this->crud->select('branch_to_course', 'course_id', array('branch_id' => $branchId, 'status' => 1), '', false, 'course_id');
            $this->data['modCourses'] = $this->crud->select('branch_to_course', '', array('branch_id' => $branchId, 'status' => 1));
            $courseId = array(0);
           if (!empty($exisitingCourseId)) {
               foreach ($exisitingCourseId as $eci) {
                   array_push($courseId, $eci->course_id) ;
               }
           }
           $this->data['courseId'] = $courseId;
            return view('branch/course/manage-course', $this->data);
         }
    }

    public function save_course_details()
    {
        if($this->request->getMethod() == "post"){
            if ($this->request->isAjax()) {

                $this->data['success'] = false;
                $this->data['hash'] = csrf_hash();
                $branchId = $this->session->branchData['id'];
                if (empty($this->request->getPost())) {
                    $this->crud->updateData('branch_to_course',array('branch_id' => $branchId), array('status' => 0), 'id');
                    $this->data['success'] = true;
                    $this->data['message'] = 'Course details has been successfully updated';
                    echo json_encode($this->data); die;
                }
                foreach ($this->request->getPost('course_fees') as $value) {
                    if (strlen($value) == 0) {
                        $this->data['message'] = 'Enter course fees';
                        error($this->data);
                    }
                }
                $dataCount = count($this->request->getPost('course_fees'));
                $idArr = array();
                $id = 0;
                for ($i = 0; $i < $dataCount; $i++) {
                    $courseID = decrypt($this->request->getPost('course_id')[$i]);
                    $data = array(
                        'branch_id' => $this->session->branchData['id'],
                        'course_id' => $courseID,
                        'course_type' => $this->request->getPost('course_type')[$i],
                        'course_fees' => $this->request->getPost('course_fees')[$i],
                    );
                    if (!empty($this->request->getPost('id')[$i])) {
                        $id = decrypt($this->request->getPost('id')[$i]);
                    }
                    if ($id) {
                        $data['updated_at'] = strtotime('now');
                        if ($this->crud->updateData('branch_to_course', array('id' => $id, 'branch_id' => $branchId), $data)) {
                           array_push($idArr, $id); 
                        }
                    }else {
                        $data['created_at'] = strtotime('now');
                        if (!empty($checkExisting = $this->crud->select('branch_to_course', 'id', array('course_id' => $courseID, 'branch_id' => $branchId), '', true))) {
                            $data['status'] = 1;
                            if ($this->crud->updateData('branch_to_course', array('id' => $checkExisting->id, 'branch_id' => $branchId), $data)) {
                                array_push($idArr, $checkExisting->id); 
                            }
                        }else {
                            if ($lastId = $this->crud->add('branch_to_course', $data)) {
                                array_push($idArr, $lastId); 
                            }
                        }
                    }
                }
                if (!empty($idArr)) {
                    $this->crud->updateData('branch_to_course',array('branch_id' => $branchId), array('status' => 0), 'id', $idArr);
                }
               
                $notiArr = array(
                    'from_id' => $this->session->branchData['id'],
                    'form_id_type' => 2,
                    'to_id' => 1,
                    'to_id_type' => 1,
                    'type' => 'branch_course',
                    'slug' => 'branch-course',
                    'date' => strtotime('now'),
                );
                $this->notification->addNotification('notifications', $notiArr);

                $this->data['success'] = true;
                $this->data['message'] = 'Course details has been successfully updated';
                echo json_encode($this->data); die;
            }
        }
    }   
}