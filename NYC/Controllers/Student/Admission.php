<?php
namespace App\Controllers\Student;

use App\Models\Student\AdmissionModel;
use App\Models\Student\PaymentModel;



class Admission extends BaseController
{

    public function __construct()
    {
        $db = db_connect();
        $this->admissiion = new AdmissionModel($db);
        $this->paym = new PaymentModel($db);
    }


    public function index()
    {
        $this->data['title'] = 'Admission List';
        $this->data['lists'] = $this->admissiion->getadmissionList($this->session->studData['registrationNumber']);
        return  view('student/admission/list', $this->data);    
    }

    public function details($id = '')
    {
       $this->data['title'] = 'Admission Details';
        if (($this->request->getMethod() == 'get') && !empty($id)) {
            $id = decrypt($id);
            if (is_numeric($id)) {
                $this->data['details'] = $this->admissiion->getadmissionListById($id, $this->session->studData['registrationNumber']);
            }
            return view('student/admission/details', $this->data);
        }
    }

    public function payment_list($enrollmentNumber = '')
    {
        $this->data['title'] = 'Payment List';
        $enrollmentNumber = decrypt($enrollmentNumber);
        if (($this->request->getMethod() == 'get') && !empty($enrollmentNumber)) {
            $this->data['payments'] = $this->admissiion->getPaymentListByEnrNo($enrollmentNumber);
        }
        return view('student/admission/payment-list', $this->data);
    }

    public function study_materials($courseId = 0)
    {
        if ((empty($courseId)) && (!empty($_REQUEST['matId']))) {
            $courseId = $_REQUEST['matId'];
        }
        $branchId = $this->session->studData['branchId'];
        $this->data['title'] = 'Study Materials';
        $this->data['materials'] = array();
        $this->data['course'] = $this->paym->getEnlistedCourseList($this->session->studData['registrationNumber']);
        if (!empty($courseId)) {
            $courseId = decrypt($courseId);
            if (($this->request->getMethod() == 'get') && !empty($courseId)) {
                $this->data['materials'] = $this->admissiion->getStudyMaterialsByCourseId($courseId, $this->session->studData['registrationNumber'], $branchId);
            }
        }else {
            $this->data['materials'] = $this->admissiion->getStudyMaterialsByCourseId('', $this->session->studData['registrationNumber'], $branchId);
        }
        if (!empty($this->data['materials'])) {
            $this->data['count'] = count($this->data['materials']);
        }else {
            $this->data['count'] = 0;
        }
        $this->data['courseId'] = $courseId;
        return view('student/admission/study-material-list', $this->data);
    }
}
