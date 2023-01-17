<?php
namespace App\Controllers\Branch;

use App\Models\Branch\Student_model;
use App\Models\Notification_model;


class Student extends BaseController
{

    public function __construct()
    {
        $db = db_connect();
        $this->stud = new Student_model($db);
        $this->notification = new Notification_model($db);
    }

    public function index()
    {
         if(($this->request->getMethod() == "get") && !$this->request->isAjax()){
            $this->data['title'] = 'Student';
            return view('branch/student/manage-student', $this->data);
         }
    }

    public function manage_admission()
    {
         if(($this->request->getMethod() == "get") && !$this->request->isAjax()){
            $this->data['title'] = 'Admissions';
            return view('branch/student/manage-admission', $this->data);
         }
    }

    public function admission_details($id = '')
    {
        if ($this->request->getMethod('get') && !$this->request->isAjax()) {
             if (!empty($id)) {
                $id = decrypt($id);
                if ($id && is_numeric($id)) {
                    $this->data['title'] = 'Admission Details';
                    $this->data['details'] = $details = $this->stud->getAdmissionDetails($id , $this->session->branchData['id']);
                    // pr($details);
                    return view('branch/student/admission-details', $this->data); die;
                }else{
                    $this->session->setFlashData('message', 'Something went wrong!');
                    $this->session->setFlashData('message_type', 'error');
                    return redirect()->to('branch/student/manage-admission'); die;
                }
            }else{
                $this->session->setFlashData('message', 'Something went wrong!');
                $this->session->setFlashData('message_type', 'error');
                return redirect()->to('branch/student/manage-admission'); die;
            } 
        }
    }

    public function delete_student($id)
    {
        if (!empty($id)) {
            if (is_numeric($id = decrypt($id))){
                if ($this->crud->updateData('student', array('id' => $id, 'branch_id' => $this->session->branchData['id']), array('is_deleted' => 1))) {

                    $notiArr = array(
                        'from_id' => $this->session->branchData['id'],
                        'form_id_type' => 2,
                        'to_id' => 1,
                        'to_id_type' => 1,
                        'type' => 'student_delete',
                        'slug' => 'student-delete',
                        'date' => strtotime('now'),
                    );
                    $this->notification->addNotification('notifications', $notiArr);

                    $this->session->setFlashData('message', 'Student has been deleted successfully');
                    $this->session->setFlashData('message_type', 'success');
                    return redirect()->to('/branch/student'); die;
                }
            }else{
                $this->session->setFlashData('message', 'Access Denied!');
                $this->session->setFlashData('message_type', 'error');
                return redirect()->to('/branch/student'); die;
            }
        }
    }

    public function delete_admission($id)
    {
        if (!empty($id)) {
            if (is_numeric($id = decrypt($id))){
                if ($this->crud->updateData('admission', array('id' => $id, 'branch_id' => $this->session->branchData['id']), array('is_deleted' => 1))) {

                    $notiArr = array(
                        'from_id' => $this->session->branchData['id'],
                        'form_id_type' => 2,
                        'to_id' => 1,
                        'to_id_type' => 1,
                        'type' => 'student_admission_delete',
                        'slug' => 'student-admission-delete',
                        'date' => strtotime('now'),
                    );
                    $this->notification->addNotification('notifications', $notiArr);

                    $this->session->setFlashData('message', 'Admission details has been deleted successfully');
                    $this->session->setFlashData('message_type', 'success');
                    return redirect()->to('/branch/student/manage-admission'); die;
                }
            }else{
                $this->session->setFlashData('message', 'Access Denied!');
                $this->session->setFlashData('message_type', 'error');
                return redirect()->to('/branch/student/manage-admission'); die;
            }
        }
    }

    public function change_status($id, $val)
    {
        if (!empty($id)) {
            if (is_numeric($id = decrypt($id))){
                $student_table_details = $this->crud->select('student', '', array('id' => $id), '', true);
                $student_status = $student_table_details->status;

                if ($this->crud->updateData('student', array('id' => $id, 'branch_id' => $this->session->branchData['id']), array('status' => $val))) {
                    $notiArr = array(
                        'from_id' => $this->session->branchData['id'],
                        'form_id_type' => 2,
                        'to_id' => 1,
                        'to_id_type' => 1,
                        'old_status' => $student_status,
                        'type' => 'student_status',
                        'slug' => 'student-status',
                        'date' => strtotime('now'),
                    );
                    $this->notification->addNotification('notifications', $notiArr);

                   $this->session->setFlashData('message', 'Student status has been changed successfully');
                   $this->session->setFlashData('message_type', 'success');
                   return redirect()->to('/branch/student'); die;
                }
            }else{
                $this->session->setFlashData('message', 'Access Denied!');
                $this->session->setFlashData('message_type', 'error');
                return redirect()->to('/branch/student'); die;
            }
        }
    }

    public function registration($id = 0)
    {
        if ($id) {
            $id = decrypt($id);
        }
        if($this->request->getMethod() == "post"){
           $is_continue = $this->request->getPost('is_continue');
            if ($this->request->isAjax()) {
                $this->data['success'] = false;
                $this->data['hash'] = csrf_hash();

               


                if (strlen($this->request->getPost('student_name')) == 0) {
                    $this->data['id'] = '#student_name';
                    $this->data['message'] = 'Enter student name';
                    error($this->data);
                }
                if (strlen($this->request->getPost('student_dob')) == 0) {
                    $this->data['id'] = '#student_dob';
                    $this->data['message'] = 'Enter date of birth of student';
                    error($this->data);
                }elseif (!validateDate($this->request->getPost('student_dob'))) {
                    $this->data['id'] = '#student_dob';
                    $this->data['message'] = 'Enter a valid date of brith';
                    error($this->data);
                }
                if (strlen($this->request->getPost('gender')) == 0) {
                    $this->data['id'] = '#gender';
                    $this->data['message'] = "Select student's gender";
                    error($this->data);
                }
                if (strlen($this->request->getPost('mobile')) == 0) {
                    $this->data['id'] = '#mobile';
                    $this->data['message'] = 'Enter mobile number';
                    error($this->data);
                }elseif (is_duplicate('student', 'mobile', array('mobile' => $this->request->getPost('mobile'), 'id<>' => $id))) {
                    $this->data['id'] = '#mobile';
                    $this->data['message'] = 'Duplicate mobile number found';
                    error($this->data);
                }
                if (strlen($this->request->getPost('residential_address')) == 0) {
                    $this->data['id'] = '#residential_address';
                    $this->data['message'] = "Enter residentials address";
                    error($this->data);
                }


                if($id){
                    if( strlen($this->request->getPost('password')) > 0 ){
                        if (!checkPwdStrength($this->request->getPost('password'))) {
                            $this->data['id'] = '#password';
                            $this->data['message'] = 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
                            echo json_encode($this->data); die;
                        }
                        if ($this->request->getPost('password') != $this->request->getPost('confirm_password')) {
                            $this->data['id'] = '#confirm_password';
                            $this->data['message'] = "Password confirmation doesn't match Password";
                            echo json_encode($this->data); die;
                        }
                    }
                }else{
                    if(strlen($this->request->getPost('password')) == 0){
                        $this->data['id'] = '#password';
                        $this->data['message'] = 'Enter Password';
                        echo json_encode($this->data); die; 
                    }
                    if (!checkPwdStrength($this->request->getPost('password'))) {
                        $this->data['id'] = '#password';
                        $this->data['message'] = 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
                        echo json_encode($this->data); die;
                    }
                    if ($this->request->getPost('password') != $this->request->getPost('confirm_password')) {
                        $this->data['id'] = '#confirm_password';
                        $this->data['message'] = "Password confirmation doesn't match Password";
                        echo json_encode($this->data); die;
                    }
                }   



                if (strlen($this->request->getPost('father_name')) == 0) {
                    $this->data['id'] = '#father_name';
                    $this->data['message'] = "Enter father's name";
                    error($this->data);
                }

                if (strlen($this->request->getPost('mother_name')) == 0) {
                    $this->data['id'] = '#mother_name';
                    $this->data['message'] = "Enter mother's name";
                    error($this->data);
                }
                if (strlen($_FILES['student_photo']['tmp_name']) == 0 && (empty($this->request->getPost('oldStudentFile'))) ) {
                    $this->data['message'] = 'Please upload student photographs to upload';
                    echo json_encode($this->data); die;
                }
                if (strlen($this->request->getPost('qualification_document_type')) == 0) {
                    $this->data['id'] = '#qualification_document_type';
                    $this->data['message'] = "Select qualification document type";
                    error($this->data);
                }
                if (strlen($_FILES['qualification_file']['tmp_name']) == 0 && (empty($this->request->getPost('oldQualificationFile'))) ) {
                    $this->data['message'] = 'Please upload educational qualification file to upload';
                    echo json_encode($this->data); die;
                }
                if (strlen($this->request->getPost('identity_card_type')) == 0) {
                    $this->data['id'] = '#identity_card_type';
                    $this->data['message'] = "Select identity card type";
                    error($this->data);
                }
                if (strlen($_FILES['identity_proof']['tmp_name']) == 0 && (empty($this->request->getPost('oldIdentityFile'))) ) {
                    $this->data['id'] = '#identity_proof';
                    $this->data['message'] = 'Please upload idenity file to upload';
                    error($this->data);
                }

                 if (strlen($_FILES['student_photo']['tmp_name']) == 0 && (empty($this->request->getPost('oldStudentFile'))) ) {
                    $this->data['id'] = '#student_photo';
                    $this->data['message'] = 'Please upload student photo.Dimention should be 150x150';
                     error($this->data);
                }elseif(strlen($_FILES['student_photo']['tmp_name']) > 0 ){

                    $image_dimention_validation = image_dimention_validation($_FILES['student_photo']['tmp_name'],150,150);
                    if( !$image_dimention_validation){
                        $this->data['id'] = '#student_photo';
                        $this->data['message'] = 'Image dimention should be 150x150';
                         error($this->data);
                    }
                
                }
                
                $data = $this->request->getPost();
                $data['student_dob'] = strtotime($this->request->getPost('student_dob'));
                if (strlen($_FILES['student_photo']['tmp_name']) != 0) {
                    $data['student_photo'] = uploadFile('upload/branch-files/student/student-image', 'student_photo', '');
                }
                if (strlen($_FILES['qualification_file']['tmp_name']) != 0) {
                    $data['qualification_file'] = uploadFile('upload/branch-files/student/qualification-file', 'qualification_file', '');
                }
                if (strlen($_FILES['identity_proof']['tmp_name']) != 0) {
                    $data['identity_proof'] = uploadFile('upload/branch-files/student/identity-proof-file', 'identity_proof', '');
                }  

                if (!empty($data['confirm_password'])) {
                    $data['password'] = password_hash($this->request->getPost('confirm_password'), PASSWORD_DEFAULT);
                }else {
                    unset($data['password']);
                }

                #UNSET DATA
                unset($data['csrf_token_name'], $data['oldStudentFile'], $data['oldQualificationFile'], $data['oldIdentityFile'], $data['is_continue'], $data['confirm_password']);
                $this->data['is_continue'] = '';
                if ($id && is_numeric($id)) {
                    $data['updated_at'] = strtotime('now');
                    if ($this->crud->updateData('student', array('id' => $id, 'branch_id' => $this->session->branchData['id']), $data)) {

                        $student_table_details = $this->crud->select('student', '', array('id' => $id), '', true);
                        $student_status = $student_table_details->status;
                        $notiArr = array(
                            'from_id' => $this->session->branchData['id'],
                            'form_id_type' => 2,
                            'to_id' => 1,
                            'to_id_type' => 1,
                            'old_status' => $student_status,
                            'type' => 'student_update',
                            'slug' => 'student-update',
                            'date' => strtotime('now'),
                        );
                        $this->notification->addNotification('notifications', $notiArr);

                        $this->data['success'] = true;
                        $this->data['message'] = 'Student details has been successfully updated';
                        if ($is_continue) {
                            $this->data['is_continue'] = site_url('branch/student/new-admission/').encrypt($id);
                        }
                        echo json_encode($this->data); die;
                    }else{
                        $this->data['message'] = 'Something went wrong!';
                        echo json_encode($this->data); die;
                    }
                }else{
                    $data['added_by'] = $data['branch_id'] = $this->session->branchData['id'];
                    $data['created_at'] = strtotime('now');

                    if ($last_id = $this->crud->add('student', $data)) {
                        $notiArr = array(
                            'from_id' => $this->session->branchData['id'],
                            'form_id_type' => 2,
                            'to_id' => 1,
                            'to_id_type' => 1,
                            'type' => 'student_registration',
                            'slug' => 'student-registration',
                            'date' => strtotime('now'),
                        );
                        $this->notification->addNotification('notifications', $notiArr);

                        $dataArr['registration_number'] = fieldValue('branch', 'student_registration_prefix', array('id' => $this->session->branchData['id'])).leadingZero($last_id, 4);
                        if ($this->crud->updateData('student', array('id' => $last_id), $dataArr)) {
                            $this->data['success'] = true;
                            $this->data['message'] = 'Student details has been successfully added';
                            if ($is_continue) {
                                $this->data['is_continue'] = site_url('branch/student/new-admission/').encrypt($last_id);
                            }
                            echo json_encode($this->data); die;
                        }
                    }else{
                        $this->data['message'] = 'Something went wrong!';
                        echo json_encode($this->data); die;
                    }
                }
            }
        }else if (($this->request->getMethod() == 'get') && (!$this->request->isAjax())) {
            $this->data['title'] = ($id)?'Edit Registration Details':'Registration';
            $this->data['details'] = array();
            $this->data['id'] = ($id)?'/'.encrypt($id):'';
            if ($id && is_numeric($id)) {
                $this->data['details'] = $this->crud->select('student', '*', array('id' =>$id), '', true);
            }
            return  view('branch/student/registration', $this->data);
        }
    }

    public function new_admission($id = '')
    {
       


        if($this->request->getMethod() == "post"){
            if ($this->request->isAjax()) {
                $this->data['success'] = false;
                $this->data['hash'] = csrf_hash();
                if (strlen($this->request->getPost('student_name')) == 0) {
                    $this->data['id'] = '#student_name';
                    $this->data['message'] = 'Enter student name';
                    error($this->data);
                }
                if (strlen($this->request->getPost('student_dob')) == 0) {
                    $this->data['id'] = '#student_dob';
                    $this->data['message'] = 'Enter date of birth of student';
                    error($this->data);
                }elseif (!validateDate($this->request->getPost('student_dob'))) {
                    $this->data['id'] = '#student_dob';
                    $this->data['message'] = 'Enter a valid date of brith';
                    error($this->data);
                }
                if (strlen($this->request->getPost('gender')) == 0) {
                    $this->data['id'] = '#gender';
                    $this->data['message'] = "Select student's gender";
                    error($this->data);
                }
                if (strlen($this->request->getPost('mobile')) == 0) {
                    $this->data['id'] = '#mobile';
                    $this->data['message'] = 'Enter mobile number';
                    error($this->data);
                }
                if (strlen($this->request->getPost('residential_address')) == 0) {
                    $this->data['id'] = '#residential_address';
                    $this->data['message'] = "Enter residentials address";
                    error($this->data);
                }

                if (strlen($this->request->getPost('father_name')) == 0) {
                    $this->data['id'] = '#father_name';
                    $this->data['message'] = "Enter father's name";
                    error($this->data);
                }

                if (strlen($this->request->getPost('mother_name')) == 0) {
                    $this->data['id'] = '#mother_name';
                    $this->data['message'] = "Enter mother's name";
                    error($this->data);
                }
                if (strlen($_FILES['student_photo']['tmp_name']) == 0 && (empty($this->request->getPost('oldStudentFile'))) ) {
                    $this->data['message'] = 'Select student photographs to upload';
                    echo json_encode($this->data); die;
                }
                if (strlen($this->request->getPost('qualification_document_type')) == 0) {
                    $this->data['id'] = '#qualification_document_type';
                    $this->data['message'] = "Select qualification document type";
                    error($this->data);
                }
                if (strlen($_FILES['qualification_file']['tmp_name']) == 0 && (empty($this->request->getPost('oldQualificationFile'))) ) {
                    $this->data['message'] = 'Select educational qualification file to upload';
                    echo json_encode($this->data); die;
                }
                if (strlen($this->request->getPost('identity_card_type')) == 0) {
                    $this->data['id'] = '#identity_card_type';
                    $this->data['message'] = "Select identity card type";
                    error($this->data);
                }
                if (strlen($_FILES['identity_proof']['tmp_name']) == 0 && (empty($this->request->getPost('oldIdentityFile'))) ) {
                    $this->data['message'] = 'Select idenity file to upload';
                    echo json_encode($this->data); die;
                }
                if (strlen($this->request->getPost('course_type')) == 0) {
                    $this->data['id'] = '#course_type';
                    $this->data['message'] = "Select course type";
                    error($this->data);
                }
                if (strlen($this->request->getPost('course_name')) == 0) {
                    $this->data['id'] = '#course_name';
                    $this->data['message'] = "Select course name";
                    error($this->data);
                }
                if (strlen($this->request->getPost('is_urgent_certificate_required')) == 0) {
                    $this->data['id'] = '#is_urgent_certificate_required';
                    $this->data['message'] = "Select urgent certificate required or not";
                    error($this->data);
                }
                if (strlen($this->request->getPost('icard_expired_date')) == 0) {
                    $this->data['id'] = '#icard_expired_date';
                    $this->data['message'] = "Select I-Card expiry date";
                    error($this->data);
                }elseif (!validateDate($this->request->getPost('icard_expired_date'))) {
                    $this->data['id'] = '#icard_expired_date';
                    $this->data['message'] = 'Enter a valid expiry date';
                    error($this->data);
                }

                if (strlen($this->request->getPost('from_session')) == 0) {
                    $this->data['id'] = '#from_session';
                    $this->data['message'] = "Select from session date";
                    error($this->data);
                }elseif (!validateDate($this->request->getPost('from_session'))) {
                    $this->data['id'] = '#from_session';
                    $this->data['message'] = 'Enter a valid from session date';
                    error($this->data);
                }

                if (strlen($this->request->getPost('to_session')) == 0) {
                    $this->data['id'] = '#to_session';
                    $this->data['message'] = "Select to session date";
                    error($this->data);
                }elseif (!validateDate($this->request->getPost('to_session'))) {
                    $this->data['id'] = '#to_session';
                    $this->data['message'] = 'Enter a valid to session date';
                    error($this->data);
                }

                if (strlen($this->request->getPost('admission_date')) == 0) {
                    $this->data['id'] = '#admission_date';
                    $this->data['message'] = 'Enter admission date';
                    error($this->data);
                }elseif (!validateDate($this->request->getPost('admission_date'))) {
                    $this->data['id'] = '#admission_date';
                    $this->data['message'] = 'Enter a valid admission date';
                    error($this->data);
                }

                if (strlen($this->request->getPost('course_fees')) == 0) {
                    $this->data['id'] = '#course_name';
                    $this->data['message'] = "Enter course fees";
                    error($this->data);
                }
                if (strlen($this->request->getPost('amount_paid')) == 0 || $this->request->getPost('amount_paid') <= 0) {
                    $this->data['id'] = '#amount_paid';
                    $this->data['message'] = "Enter valid paid amount";
                    error($this->data);
                }

                $data = $this->request->getPost();
                $data['student_dob'] = strtotime($this->request->getPost('student_dob'));
                $data['icard_expired_date'] = strtotime($this->request->getPost('icard_expired_date'));
                $data['from_session'] = strtotime($this->request->getPost('from_session'));
                $data['to_session'] = strtotime($this->request->getPost('to_session'));
                $data['admission_date'] = strtotime($this->request->getPost('admission_date'));
                $expiredDate = config('SiteConfig')->general['STUDENT_EXPIRY_DAYS'];
                $expiredDate = strtotime(date('Y-m-d', strtotime($this->request->getPost('to_session').'+'.$expiredDate.' days')));
                if (strlen($_FILES['student_photo']['tmp_name']) != 0) {
                    $data['student_photo'] = uploadFile('upload/branch-files/student/student-image', 'student_photo', '');
                }else {
                    $data['student_photo'] = $this->request->getPost('oldStudentFile');
                }
                if (strlen($_FILES['qualification_file']['tmp_name']) != 0) {
                    $data['qualification_file'] = uploadFile('upload/branch-files/student/qualification-file', 'qualification_file', '');
                }else {
                    $data['qualification_file'] = $this->request->getPost('oldQualificationFile');
                }
                if (strlen($_FILES['identity_proof']['tmp_name']) != 0) {
                    $data['identity_proof'] = uploadFile('upload/branch-files/student/identity-proof-file', 'identity_proof', '');
                }else {
                    $data['identity_proof'] = $this->request->getPost('oldIdentityFile');
                } 
                #GET MAX ENROLLMENT NUMBER OF RESPECTIVE BRANCH
                $maxEnroll = maxValue('admission', 'max_enroll_no', array('branch_id' => $this->session->branchData['id']));
                if (empty($maxEnroll)) {
                    $maxEnroll = fieldValue('branch', 'maxEnrollNumber', array('id' => $this->session->branchData['id']));
                }  
                $data['enrollment_number'] = fieldValue('branch', 'student_enrollment_prefix', array('id' => $this->session->branchData['id'])).leadingZero(($maxEnroll+1), 4);
                $data['max_enroll_no'] = $maxEnroll + 1;
    
                #UNSET DATA
                unset($data['csrf_token_name'], $data['oldStudentFile'], $data['oldQualificationFile'], $data['oldIdentityFile'], $data['course_fees'], $data['amount_paid'], $data['discount']);
                $data['added_by'] = $data['branch_id'] = $this->session->branchData['id'];
                $data['created_at'] = strtotime('now');
                if ($last_id = $this->crud->add('admission', $data)) {
                    $paymentArr = array(
                        'branch_id' =>  $this->session->branchData['id'],
                        'admission_id' => $last_id,
                        'course_fees' => $this->request->getPost('course_fees'),
                        'amount' => $this->request->getPost('amount_paid'),
                        'discount' => $this->request->getPost('discount'),
                        'payment_type' => 1,
                        'created_at' => strtotime('now'),
                    );
                    if ($payID = $this->crud->add('payment', $paymentArr)) {
                        $this->crud->updateData('payment', array('id' => $payID), array('invoice_no' => fieldValue('branch', 'invoice_prefix', array('id' => $this->session->branchData['id'])).leadingZero($payID, 4)));
                        $this->crud->updateData('student', ['registration_number' => $data['registration_number']], ['login_access_expired_on' => $expiredDate]);
                    }

                    $notiArr = array(
                        'from_id' => $this->session->branchData['id'],
                        'form_id_type' => 2,
                        'to_id' => 1,
                        'to_id_type' => 1,
                        'type' => 'student_admission',
                        'slug' => 'student-admission',
                        'date' => strtotime('now'),
                    );
                    $this->notification->addNotification('notifications', $notiArr);

                    $this->data['success'] = true;
                    $this->data['redirect'] = site_url('branch/student/admission-details/').encrypt($last_id);
                    $this->data['message'] = 'Admission details has been successfully added';
                    echo json_encode($this->data); die;
                }else{
                    $this->data['message'] = 'Something went wrong!';
                    echo json_encode($this->data); die;
                }
            }
        } else if ($this->request->getMethod('get') && !$this->request->isAjax()) {
            $this->data['title'] = 'New Admission';
            $this->data['details'] = '';
            if (!empty($id)) {
                $id = decrypt($id); $today = strtotime(date('Y-m-d 11:59:59'));
                if ($id) {
                   $branchID = $this->session->branchData['id'];
                    $this->data['details'] = $details = $this->crud->select('student', '', "(id='$id' OR registration_number='$id') AND branch_id=$branchID AND status=1 AND is_deleted=0", '', true);
                    if (!empty($details)) {
                        if (is_numeric($id)) {
                            $regNo = fieldValue('student','registration_number', array('id' => $id, 'branch_id' => $this->session->branchData['id']));
                        }else {
                            $regNo = $id;
                        }
                        // if (empty($this->stud->isPartOfAnyActiveCourse($regNo, $this->session->branchData['id']))) {
                        //     $this->session->setFlashData('message', 'The student is enrolled in an active course, can\'t enroll in two courses at a time.');
                        //     $this->session->setFlashData('message_type', 'error');
                        //     return redirect()->to('branch/student/new-admission'); die;
                        // }
                    }else {
                        $this->session->setFlashData('message', 'Enter correct registration number or Student is inactive.');
                        $this->session->setFlashData('message_type', 'error');
                        return redirect()->to('branch/student/new-admission'); die;
                    }
                }else{
                    $this->session->setFlashData('message', 'Something went wrong!');
                    $this->session->setFlashData('message_type', 'error');
                    return redirect()->to('branch/student/new-admission'); die;
                }
            } 
            $this->data['courseType'] = $this->crud->select('course_type');

            return view('branch/student/new-addmission', $this->data); die;
        }
    }

    public function update_admission($id = 0)
    {
        if($this->request->getMethod() == "post"){
            if ($this->request->isAjax()) {
                if (!empty($id)) {
                    $id = decrypt($id);
                }
                $this->data['success'] = false;
                $this->data['hash'] = csrf_hash();
                if (strlen($this->request->getPost('student_name')) == 0) {
                    $this->data['id'] = '#student_name';
                    $this->data['message'] = 'Enter student name';
                    error($this->data);
                }
                if (strlen($this->request->getPost('student_dob')) == 0) {
                    $this->data['id'] = '#student_dob';
                    $this->data['message'] = 'Enter date of birth of student';
                    error($this->data);
                }elseif (!validateDate($this->request->getPost('student_dob'))) {
                    $this->data['id'] = '#student_dob';
                    $this->data['message'] = 'Enter a valid date of brith';
                    error($this->data);
                }
                if (strlen($this->request->getPost('gender')) == 0) {
                    $this->data['id'] = '#gender';
                    $this->data['message'] = "Select student's gender";
                    error($this->data);
                }
                if (strlen($this->request->getPost('mobile')) == 0) {
                    $this->data['id'] = '#mobile';
                    $this->data['message'] = 'Enter mobile number';
                    error($this->data);
                }
                if (strlen($this->request->getPost('residential_address')) == 0) {
                    $this->data['id'] = '#residential_address';
                    $this->data['message'] = "Enter residentials address";
                    error($this->data);
                }

                if (strlen($this->request->getPost('father_name')) == 0) {
                    $this->data['id'] = '#father_name';
                    $this->data['message'] = "Enter father's name";
                    error($this->data);
                }

                if (strlen($this->request->getPost('mother_name')) == 0) {
                    $this->data['id'] = '#mother_name';
                    $this->data['message'] = "Enter mother's name";
                    error($this->data);
                }
                
                if (strlen($this->request->getPost('qualification_document_type')) == 0) {
                    $this->data['id'] = '#qualification_document_type';
                    $this->data['message'] = "Select qualification document type";
                    error($this->data);
                }
                if (strlen($_FILES['qualification_file']['tmp_name']) == 0 && (empty($this->request->getPost('oldQualificationFile'))) ) {
                    $this->data['message'] = 'Select educational qualification file to upload';
                    echo json_encode($this->data); die;
                }
                if (strlen($this->request->getPost('identity_card_type')) == 0) {
                    $this->data['id'] = '#identity_card_type';
                    $this->data['message'] = "Select identity card type";
                    error($this->data);
                }
                if (strlen($_FILES['identity_proof']['tmp_name']) == 0 && (empty($this->request->getPost('oldIdentityFile'))) ) {
                    $this->data['message'] = 'Select idenity file to upload';
                    echo json_encode($this->data); die;
                }                
                if (strlen($this->request->getPost('icard_expired_date')) == 0) {
                    $this->data['id'] = '#icard_expired_date';
                    $this->data['message'] = "Select I-Card expiry date";
                    error($this->data);
                }elseif (!validateDate($this->request->getPost('icard_expired_date'))) {
                    $this->data['id'] = '#icard_expired_date';
                    $this->data['message'] = 'Enter a valid expiry date';

                }
                if (strlen($this->request->getPost('admission_date')) == 0) {
                    $this->data['id'] = '#admission_date';
                    $this->data['message'] = 'Enter admission date';
                    error($this->data);
                }elseif (!validateDate($this->request->getPost('admission_date'))) {
                    $this->data['id'] = '#admission_date';
                    $this->data['message'] = 'Enter a valid admission date';
                    error($this->data);
                }
                if (strlen($_FILES['student_photo']['tmp_name']) == 0 && (empty($this->request->getPost('oldStudentFile'))) ) {
                    $this->data['message'] = 'Select student photographs to upload';
                    echo json_encode($this->data); die;
                }elseif(strlen($_FILES['student_photo']['tmp_name']) > 0 ){
                    $image_dimention_validation = image_dimention_validation($_FILES['student_photo']['tmp_name'],150,150);
                    if( !$image_dimention_validation){
                        $this->data['id'] = '#student_photo';
                        $this->data['message'] = 'Image dimention should be 150x150';
                         error($this->data);
                    }
                }


                if (strlen($this->request->getPost('is_urgent_certificate_required')) == 0) {
                    $this->data['id'] = '#is_urgent_certificate_required';
                    $this->data['message'] = "Select urgent certificate required or not";
                    error($this->data);
                }
                


                $data = $this->request->getPost();
                $data['student_dob'] = strtotime($this->request->getPost('student_dob'));
                $data['icard_expired_date'] = strtotime($this->request->getPost('icard_expired_date'));
                if (strlen($_FILES['student_photo']['tmp_name']) != 0) {
                    $data['student_photo'] = uploadFile('upload/branch-files/student/student-image', 'student_photo', $this->request->getPost('oldStudentFile'));
                }
                if (strlen($_FILES['qualification_file']['tmp_name']) != 0) {
                    $data['qualification_file'] = uploadFile('upload/branch-files/student/qualification-file', 'qualification_file', $this->request->getPost('oldQualificationFile'));
                }
                if (strlen($_FILES['identity_proof']['tmp_name']) != 0) {
                    $data['identity_proof'] = uploadFile('upload/branch-files/student/identity-proof-file', 'identity_proof', $this->request->getPost('oldIdentityFile'));
                }   
                $data['admission_date'] = strtotime($this->request->getPost('admission_date'));
                #UNSET DATA
                unset($data['csrf_token_name'], $data['oldStudentFile'], $data['oldQualificationFile'], $data['oldIdentityFile'], $data['course_fees']);
                if ($id && is_numeric($id)) {
                    $data['updated_at'] = strtotime('now');
                    if ($this->crud->updateData('admission', array('id' => $id, 'branch_id' => $this->session->branchData['id']), $data)) {

                        $notiArr = array(
                            'from_id' => $this->session->branchData['id'],
                            'form_id_type' => 2,
                            'to_id' => 1,
                            'to_id_type' => 1,
                            'type' => 'student_admission_update',
                            'slug' => 'student-admission-update',
                            'date' => strtotime('now'),
                        );
                        $this->notification->addNotification('notifications', $notiArr);

                        $this->data['success'] = true;
                        $this->data['message'] = 'Admission details has been successfully updated';
                        echo json_encode($this->data); die;
                    }else{
                        $this->data['message'] = 'Something went wrong!';
                        echo json_encode($this->data); die;
                    }
                }
            }
        } else if ($this->request->getMethod('get') && !$this->request->isAjax()) {
             if (!empty($id)) {
                $id = decrypt($id);
                if ($id && is_numeric($id)) {
                    $this->data['title'] = 'Update Admission Details';
                    $this->data['id'] = $id;
                    $this->data['details'] = $details = $this->stud->getAdmissionDetailsById($id , $this->session->branchData['id']);
                    $this->data['courseType'] = $this->crud->select('course_type');
                    $this->data['courseNames'] = $this->crud->select('course', 'id, course_name', array('course_type' => $details->course_type));
                    return view('branch/student/update-addmission', $this->data); die;
                }else{
                    $this->session->setFlashData('message', 'Something went wrong!');
                    $this->session->setFlashData('message_type', 'error');
                    return redirect()->to('branch/student/manage-admission'); die;
                }
            }else{
                $this->session->setFlashData('message', 'Something went wrong!');
                $this->session->setFlashData('message_type', 'error');
                return redirect()->to('branch/student/manage-admission'); die;
            } 
        }
    }

    /*AJAX REQUESTS*/
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
        $branchId = $this->session->branchData['id'];

        ## Total number of records without filtering
        $totalRecords = $this->dt->getStudListCount(array('is_deleted' => 0, 'branch_id' => $branchId));
        ## Total number of records with filtering
        $totalRecordwithFilter = $totalRecords;
        $where .= "`student.branch_id`=$branchId";
        if (!empty($status)) {
            $where .= empty($where)?"`student.status`=$status":" AND student.status`=$status";
        }
        if (!empty($gender)) {
            $where .= empty($where)?"`student.gender`='$gender'":" AND `student.gender`='$gender'";
        }
        if (!empty($keyword)) {
            $where .= empty($where)?"(`student.registration_number` LIKE '%$keyword%' ESCAPE '!' OR `student.mobile` LIKE '%$keyword%' ESCAPE '!' OR `student.student_name` LIKE '%$keyword%' ESCAPE '!')":" AND (`student.registration_number` LIKE '%$keyword%' ESCAPE '!' OR `student.mobile` LIKE '%$keyword%' ESCAPE '!' OR `student.student_name` LIKE '%$keyword%' ESCAPE '!')";
        }
        if (!empty($where)) {
            $totalRecordwithFilter = $this->dt->getStudListCount($where);
        }


        ## Fetch records
        $records = $this->dt->getAjaxDatatableBranchStudentList($status, $keyword, $gender, $columnSortOrder, $rowperpage, $start, $branchId);
        $data = array();
        $i = $start+1;
        foreach($records as $record ){
            if ($record->status == 1) {
                $statusHtml = '<a href="javascript:void(0)" data-toggle="tooltip" title="Click to inactive" class="changeStudentStatus" data-id="'.encrypt($record->id).'" data-val="2"><span class="trip theme-cl theme-bg-light">Active</span></a>';
                $subAction = '<a href="javascript:void(0)" data-toggle="tooltip" title="Click to inactive" class="changeStudentStatus dropdown-item" data-id="'.encrypt($record->id).'" data-val="2">Inactive</a>';

            }else {
                $statusHtml = '<a href="javascript:void(0)" data-toggle="tooltip" title="Click to active" class="changeStudentStatus" data-id="'.encrypt($record->id).'" data-val="1"><span class="trip text-danger bg-light-danger">Inactive</span></a>';
                $subAction = '<a href="javascript:void(0)" data-toggle="tooltip" title="Click to active" class="changeStudentStatus dropdown-item" data-id="'.encrypt($record->id).'" data-val="1">Active</a>';

            }

            $actions = '<div class="dropdown show">
            <a  href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-ellipsis-h"></i>
            </a>
            <div class="drp-select dropdown-menu">
            '.$subAction.'
            <a class="dropdown-item" href="'.site_url('branch/student/registration/').encrypt($record->id).'">Edit</a>
            <a class="dropdown-item deleteStud" href="javascript:void(0)" data-id="'.encrypt($record->id).'">Delete</a>
            </div>
            </div>';

            $data[] = array( 
                "slNo" => $i++,
                "student" => $record->student_name.'<br>'.$record->registration_number,
                "gender" => $record->gender,
                "mobile" => $record->mobile,
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

    public function ajax_dt_get_admission_list()
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
        $fromDate = $dtpostData['fromDate'];
        $toDate = $dtpostData['toDate'];
        $branchId = $this->session->branchData['id'];

        ## Total number of records without filtering
        $totalRecords = get_count('admission', array('branch_id' => $branchId));
        ## Total number of records with filtering
        $totalRecordwithFilter = $totalRecords;
        $where .= "`admission.branch_id`=$branchId";
        if (!empty($keyword)) {
            $where .= empty($where)?"(`admission.enrollment_number` LIKE '%$keyword%' ESCAPE '!' OR `admission.student_name` LIKE '%$keyword%' ESCAPE '!' OR `cr.course_name` LIKE '%$keyword%' ESCAPE '!' OR `cr.course_code` LIKE '%$keyword%' ESCAPE '!' OR `crt.course_type` LIKE '%$keyword%' ESCAPE '!')":" AND (`admission.enrollment_number` LIKE '%$keyword%' ESCAPE '!' OR `admission.student_name` LIKE '%$keyword%' ESCAPE '!' OR `cr.course_name` LIKE '%$keyword%' ESCAPE '!' OR `cr.course_code` LIKE '%$keyword%' ESCAPE '!' OR `crt.course_type` LIKE '%$keyword%' ESCAPE '!')";
        }
        if (!empty($fromDate) && !empty($toDate)) {
            $fromDate = strtotime($fromDate.' 00:00:00');
            $toDate = strtotime($toDate.' 11:59:59');
            $where .= empty($where)?"(`admission.created_at` >= '$fromDate' AND `admission.created_at` <= '$toDate')":" AND (`admission.created_at` >= '$fromDate' AND `admission.created_at` <= '$toDate')";
        } elseif (!empty($fromDate)) {
            $fromDate = strtotime($fromDate.' 00:00:00');
            $where .= empty($where)?"(`admission.created_at` >= '$fromDate')":" AND (`admission.created_at` >= '$fromDate')";

        } elseif (!empty($toDate)) {
            $toDate = strtotime($toDate.' 11:59:59');
            $where .= empty($where)?"(`admission.created_at` >= '$fromDate')":" AND (`admission.created_at` <= '$toDate')";
        }
        if (!empty($where)) {
            $totalRecordwithFilter = $this->dt->getAdmissionListCount($where);
        }
       


        ## Fetch records
        $records = $this->dt->getAjaxDatatableBranchAdmissionList($where, $columnSortOrder, $rowperpage, $start);
        $data = array();
        $i = $start+1;

        foreach($records as $record ){
             $actions = ''; $subAction = '';
            if (!empty($record->nycta_icard)) {
                $subAction .= '<a class="dropdown-item" href="'.site_url('public/upload/branch-files/student/identity-card/'.$record->nycta_icard.'.pdf').'" download="'.decrypt($record->nycta_icard).'.pdf'.'">Download I-Card</a>';
            }

            $subAction .= '<a class="dropdown-item" href="'.site_url('exporter/'.(empty($record->nycta_icard)?'generate-identity-card':'regenerate-identity-card').'/'.encrypt($record->id)).'">'.(empty($record->nycta_icard)?'Generate I-Card':'Re-Generate I-Card').'</a>';

            $actions .= '<div class="dropdown show">
            <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-ellipsis-h"></i>
            </a>
            <div class="drp-select dropdown-menu">
            <a class="dropdown-item" href="'.site_url('branch/student/admission-details/').encrypt($record->id).'">Details</a>
            <a class="dropdown-item" href="'.site_url('branch/student/update-admission/').encrypt($record->id).'">Edit</a>
            <a class="dropdown-item deleteStudAdmission" href="javascript:void(0)" data-id="'.encrypt($record->id).'">Delete</a>
            '.$subAction.'
            </div>
            </div>';
            if ($record->is_urgent_certificate_required == 'Yes') {
                $req = 'Certificate: <b class="text-muted">Urgent</b>';
            }else {
                $req = 'Certificate: <b class="text-muted">Regular</b>';
            }
            $data[] = array( 
                "slNo" => $i++,
                "student" => $record->student_name.'<br>'.$record->enrollment_number.'<br>'.$req,
                "course_name" => $record->course_name.'<br>'.$record->course_code,
                "course_type" => $record->course_type,
                "course_duration" => ($record->course_duration > 1)?$record->course_duration.' Months':$record->course_duration.' Month',
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

    public function ajax_get_course_by_type()
    {   
        if ($this->request->isAjax()) {
            $type =  $this->request->getPost('type');
            $record = $this->stud->GetCoursesByType($type, $this->session->branchData['id']);
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

    public function ajax_get_course_by_id()
    {   
        if ($this->request->isAjax()) {
            $id =  $this->request->getPost('id');
            $record = $this->stud->GetCoursesByID($id, $this->session->branchData['id']);
            $duration = ($record->course_duration - 1);
            $createdDate = $record->created_at;
            $this->data['prevDate'] =  date("m-01-Y", strtotime("-$duration months", $createdDate));
            $this->data['prevDate'] =  date("m-01-Y", strtotime("01-01-2016"));
            $this->data['success'] = true;
            $this->data['details'] = $record;
            echo json_encode($this->data); die;
        }
    }

    public function ajax_get_student_by_reg_no()
    {   
        if ($this->request->isAjax()) {
            $this->data['success'] = false;
            $tbody = ''; $today = strtotime(date('Y-m-d 11:59:59'));
            $regNo =  $this->request->getPost('regNo');

            $record = $this->crud->select('student', '', array('registration_number' => $regNo, 'branch_id' => $this->session->branchData['id'], 'status' => 1, 'is_deleted' => 0), '', true);
            if (!empty($record)) {
                $activeCourseEndDate = $this->stud->getActiveCourseEndDateByregNo($regNo, $this->session->branchData['id']);
                if (!empty($activeCourseEndDate)) {
                    if ($activeCourseEndDate >= $today) {
                        $this->data['message'] = 'The student is enrolled in an active course, can\'t enroll in two courses at a time.';
                        echo json_encode($this->data); die;
                    }
                }

                $record->student_dob_raw = date('Y-m-d', $record->student_dob);
                $record->student_dob = date('F j, Y', $record->student_dob);
                $fileArr[] = array(
                    'name' => "Student's Image",
                    'file' => $record->student_photo,
                    'url' => site_url('public/upload/branch-files/student/student-image/'.$record->student_photo),
                );
                $fileArr[] = array(
                    'name' => $record->qualification_document_type,
                    'file' => $record->qualification_file,
                    'url' => site_url('public/upload/branch-files/student/qualification-file/'.$record->qualification_file),
                );
                $fileArr[] = array(
                    'name' => $record->identity_card_type,
                    'file' => $record->identity_proof,
                    'url' => site_url('public/upload/branch-files/student/identity-proof-file/'.$record->identity_proof),
                );

                
                if (!empty($fileArr)) {
                    foreach ($fileArr as $file) {
                        if (empty($file['file'])) {
                            continue;
                        }
                        $tbody .= '<tr>
                        <th scope="row">1</th>
                        <td><div class="smalls lg">'.$file['name'].'</div></td>
                        <td><a class="btn btn-sm btn-icon btn-dark" href="'.$file['url'].'" download><i class="fa-solid fa-download"></i></a></td>
                        </tr>';
                    }
                }

                $record->tbody = $tbody;


                $this->data['success'] = true;
                $this->data['details'] = $record;
            }else {
                $this->data['message'] = 'Enter correct registration number or Student is inactive.';
            }
            echo json_encode($this->data); die;
        }
    }
}
