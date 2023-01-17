<?php namespace App\Models;

use CodeIgniter\Model;

class Exporter_model extends Model
{
    protected $db;

    public function __construct($db)
    {
        $this->db =& $db;
        $this->adm = $this->db->table('admission');
        $this->pay = $this->db->table('payment');
        $this->msheet = $this->db->table('marksheets');
        $this->cert = $this->db->table('certificates');
        $this->branch = $this->db->table('branch');
        $this->admit = $this->db->table('admits');
    }


    public function getIdentityCardData($admissionId = 0, $branchId = 0)
    {
        $this->adm->select('admission.student_name, admission.id, admission.enrollment_number, admission.icard_expired_date, admission.father_name, admission.student_photo, br.branch_name, br.branch_code, br.academy_phone, cr.course_name,br.branch_name,br.academy_phone,br.signature as branch_signature,cr.short_name');
        $this->adm->join('branch br', 'br.id=admission.branch_id', 'left');
        $this->adm->join('course cr', 'cr.course_code=admission.course_code', 'left');
        $this->adm->join('course_type crt', 'crt.id=admission.course_type', 'left');
        $this->adm->where('admission.is_deleted', 0);
        $this->adm->where('admission.id', $admissionId);
        $this->adm->where('admission.branch_id', $branchId);

        $data = $this->adm->get()->getRow();
        return $data;
    }

    public function getInvoiceData($id = 0, $branchId = 0)
    {
        $this->pay->select('payment.*,admission.enrollment_number,admission.student_name,admission.mobile,admission.residential_address,admission.pin,admission.residential_address,course.course_name as course_name_text');
        $this->pay->where('payment.id', $id);
        $this->pay->where('payment.branch_id', $branchId);
        $this->pay->join('admission', 'admission.id=payment.admission_id', 'left');
        $this->pay->join('course', 'course.id=admission.course_name', 'left');
        $data = $this->pay->get()->getRow();
        return $data;
    }
    public function getBranchData($branchId = 0)
    {
        $this->branch->select('branch.*');
        $this->branch->where('branch.id', $branchId);
        $data = $this->branch->get()->getRow();
        return $data;
    }

    public function getMarksheetData($id)
    {
        $this->msheet->select('marksheets.*, course.short_name,branch.academy_code,branch.signature,branch.academy_name as atp_name');
        $this->msheet->join('course', 'course.id=marksheets.course_id', 'left');
        $this->msheet->join('branch', 'branch.id=marksheets.branch_id', 'left');
        // $this->msheet->where('marksheets.status', 2);  
        $this->msheet->where('marksheets.id', $id);  
        $this->msheet->orderBy('marksheets.id', 'desc');
        $this->msheet->groupBy('marksheets.id');

        $data = $this->msheet->get()->getRow();
        return $data;   
    } 

    public function getCertificateData($id)
    {
        $this->cert->select('certificates.*, course.short_name, course.course_name, branch.branch_name, branch.signature as branch_signature,course.course_duration,branch.academy_code');
        $this->cert->join('course', 'course.id=certificates.course_id', 'left');
        $this->cert->join('branch', 'branch.id=certificates.branch_id', 'left');
        // $this->cert->where('marksheets.status', 2);  
        $this->cert->where('certificates.id', $id);  
        $this->cert->orderBy('certificates.id', 'desc');
        $this->cert->groupBy('certificates.id');

        $data = $this->cert->get()->getRow();
        return $data;   
    } 
}
