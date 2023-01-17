<?php namespace App\Models;

use CodeIgniter\Model;

class Datatable_model extends Model
{
    protected $db;

    public function __construct($db)
    {
        $this->db =& $db;
        $this->builder = $this->db->table('branch');
        $this->stud = $this->db->table('student');
        $this->adm = $this->db->table('admission');
        $this->pay = $this->db->table('payment');
        $this->msheet = $this->db->table('marksheets');
        $this->cert = $this->db->table('certificates');
        $this->letter = $this->db->table('authletter');
        $this->admit = $this->db->table('admits');
        $this->csm = $this->db->table('course_study_materials');
        $this->media = $this->db->table('media');
        $this->cpdf = $this->db->table('combined_pdf');
        $this->wallet = $this->db->table('wallet');
        $this->exam = $this->db->table('exam_setup');
    }

    
    public function getAjaxDatatableAuthLetterList($branch_id = 0, $columnSortOrder = '', $rowperpage = 0, $start = 0 )
    {

        $this->letter->select('authletter.*,br.branch_name,br.branch_code');
        $this->letter->join('branch br', 'br.id=authletter.branch_id', 'left');
        if ($branch_id && is_numeric($branch_id)) {
            $this->letter->where('branch_id', $branch_id);
        }
        $this->letter->where('is_deleted', 2);
        $this->letter->orderBy('id', 'desc');
        $this->letter->limit($rowperpage, $start);

        $data = $this->letter->get()->getResult();
        return $data;
    }

    public function getAjaxDatatableBranchList($status = 0, $keyword = '', $columnSortOrder = '', $rowperpage = 0, $start = 0 )
    {
        $this->builder->select('*');
        if ($status && is_numeric($status)) {
            $this->builder->where('status', $status);
        }
        if (!empty($keyword)) {
            $this->builder->like('branch_name', $keyword);
            $this->builder->orLike('branch_email', $keyword);
        }
        $this->builder->orderBy('id', 'desc');
        $this->builder->limit($rowperpage, $start);

        $data = $this->builder->get()->getResult();
        return $data;
    }

    public function getAjaxDatatableStudentList($status = 0, $keyword = '', $gender = '', $columnSortOrder = '', $rowperpage = 0, $start = 0 )
    {
        $this->stud->select('student.*, br.branch_name');
        $this->stud->join('branch br', 'br.id=student.branch_id', 'left');
        if ($status && is_numeric($status)) {
            $this->stud->where('student.status', $status);
        }
        if ($gender) {
            $this->stud->where('student.gender', $gender);
        }
        if (!empty($keyword)) {
            $this->stud->like('student.student_name', $keyword);
            $this->stud->orLike('student.mobile', $keyword);
            $this->stud->orLike('student.registration_number', $keyword);
            $this->stud->orLike('br.branch_name', $keyword);
        }
        $this->stud->where('student.is_deleted', 0);
        $this->stud->orderBy('student.id', 'desc');
        $this->stud->limit($rowperpage, $start);

        $data = $this->stud->get()->getResult();
        return $data;
    }

    public function getAjaxDatatableBranchStudentList($status = 0, $keyword = '', $gender = '', $columnSortOrder = '', $rowperpage = 0, $start = 0,$branchId=0 )
    {
        $this->stud->select('student.*');
        if ($status && is_numeric($status)) {
            $this->stud->where('student.status', $status);
        }
        if ($gender) {
            $this->stud->where('student.gender', $gender);
        }
        if (!empty($keyword)) {
            $this->stud->groupStart();
            $this->stud->like('student.student_name', $keyword);
            $this->stud->orLike('student.mobile', $keyword);
            $this->stud->orLike('student.registration_number', $keyword);
            $this->stud->groupEnd();
        }
        $this->stud->where('student.is_deleted', 0);
        $this->stud->where('student.branch_id', $branchId);
        $this->stud->orderBy('student.id', 'desc');
        $this->stud->limit($rowperpage, $start);

        $data = $this->stud->get()->getResult();
        return $data;
    }

    public function getStudListCount($where = '')
    {
        $this->stud->select('student.id, br.branch_name');
        $this->stud->join('branch br', 'br.id=student.branch_id', 'left');
        $this->stud->where($where);
        $count = $this->stud->countAllResults();
        if ($count > 0) {
            return $count;
        } else {
            return 0;
        }
    }

    public function getAjaxDatatableBranchAdmissionList($where = '', $columnSortOrder = '', $rowperpage = 0, $start = 0)
    {
        $this->adm->select('admission.*, br.branch_name, cr.course_name, crt.course_type');
        $this->adm->join('branch br', 'br.id=admission.branch_id', 'left');
        $this->adm->join('course cr', 'cr.course_code=admission.course_code', 'left');
        $this->adm->join('course_type crt', 'crt.id=admission.course_type', 'left');

        if (!empty($where)) {
            $this->adm->where($where);

        }
        $this->adm->where('admission.is_deleted', 0);
        $this->adm->orderBy('admission.id', 'desc');
        $this->adm->limit($rowperpage, $start);

        $data = $this->adm->get()->getResult();
        return $data;
    }

    public function getAjaxDatatableHoAdmissionList($keyword = '', $columnSortOrder = '', $rowperpage = 0, $start = 0 )
    {
        $this->adm->select('admission.*, br.branch_name, cr.course_name, crt.course_type');
        $this->adm->join('branch br', 'br.id=admission.branch_id', 'left');
        $this->adm->join('course cr', 'cr.course_code=admission.course_code', 'left');
        $this->adm->join('course_type crt', 'crt.id=admission.course_type', 'left');

        if (!empty($keyword)) {
            $this->adm->like('admission.student_name', $keyword);
            $this->adm->orLike('admission.enrollment_number', $keyword);
            $this->adm->orLike('cr.course_name', $keyword);
            $this->adm->orLike('cr.course_code', $keyword);
            $this->adm->orLike('crt.course_type', $keyword);
            $this->adm->orLike('br.branch_name', $keyword);
        }
        $this->adm->where('admission.is_deleted', 0);
        $this->adm->orderBy('admission.id', 'desc');
        $this->adm->limit($rowperpage, $start);

        $data = $this->adm->get()->getResult();
        return $data;
    }

    public function getAdmissionListCount($where = '')
    {
        $this->adm->select('admission.id, br.branch_name');
        $this->adm->join('branch br', 'br.id=admission.branch_id', 'left');
        $this->adm->join('course cr', 'cr.course_code=admission.course_code', 'left');
        $this->adm->join('course_type crt', 'crt.id=admission.course_type', 'left');
        $this->adm->where($where);
        $count = $this->adm->countAllResults();
        if ($count > 0) {
            return $count;
        } else {
            return 0;
        }
    }

    public function getAjaxDatatableBranchPaymentList($keyword = '', $columnSortOrder = '', $rowperpage = 0, $start = 0,$branchId =0)
    {
        $this->pay->select('payment.*, adm.student_name, adm.enrollment_number');
         $this->pay->join('admission adm', 'adm.id=payment.admission_id', 'left');

        if (!empty($keyword)) {
            $this->pay->like('adm.student_name', $keyword);
            $this->pay->orLike('adm.enrollment_number', $keyword);
            $this->pay->orLike('payment.invoice_no', $keyword);
            $this->pay->orLike('payment.amount', $keyword);
        }
        $this->pay->where('payment.branch_id', $branchId);
        $this->pay->orderBy('payment.id', 'desc');
        $this->pay->limit($rowperpage, $start);

        $data = $this->pay->get()->getResult();
        return $data;
    }

    public function getAjaxDatatableHoPaymentList($keyword = '', $columnSortOrder = '', $rowperpage = 0, $start = 0, $branchId = 0 )
    {
        $this->pay->select('payment.*, adm.student_name, adm.enrollment_number, br.branch_name');
         $this->pay->join('admission adm', 'adm.id=payment.admission_id', 'left');
         $this->pay->join('branch br', 'br.id=payment.branch_id', 'left');

        if (!empty($keyword)) {
            $this->pay->like('adm.student_name', $keyword);
            $this->pay->orLike('adm.enrollment_number', $keyword);
            $this->pay->orLike('payment.invoice_no', $keyword);
            $this->pay->orLike('payment.amount', $keyword);
            $this->pay->orLike('br.branch_name', $keyword);
        }
        if (!empty($branchId)) {
            $this->pay->where('payment.branch_id', $branchId);
        }
        $this->pay->orderBy('payment.id', 'desc');
        $this->pay->limit($rowperpage, $start);

        $data = $this->pay->get()->getResult();
        return $data;
    }

    public function getPaymentListCount($where = '')
    {
        $this->pay->select('payment.id');
        $this->pay->join('admission adm', 'adm.id=payment.admission_id', 'left');
        $this->pay->where($where);
        $count = $this->pay->countAllResults();
        if ($count > 0) {
            return $count;
        } else {
            return 0;
        }
    }

    public function getMarksheetListCount($where = '')
    {
        $this->msheet->select('marksheets.id');
        $this->msheet->join('course', 'course.id=marksheets.course_id', 'left');
        $this->msheet->where($where);
        $count = $this->msheet->countAllResults();
        if ($count > 0) {
            return $count;
        } else {
            return 0;
        }
    }

    public function getAjaxDatatableMarksheetList($keyword = '', $columnSortOrder = '', $rowperpage = 0, $start = 0,$branchId=0, $status = '' )
    {
        $this->msheet->select('marksheets.*, course.short_name, admission.is_urgent_certificate_required');
        $this->msheet->join('course', 'course.id=marksheets.course_id', 'left');
        $this->msheet->join('admission', 'admission.enrollment_number=marksheets.enrollment_number', 'left');

        if (!empty($keyword)) {
            $this->msheet->like('marksheets.marksheet_no', $keyword);
            $this->msheet->orLike('marksheets.enrollment_number', $keyword);
            $this->msheet->orLike('marksheets.candidate_name', $keyword);
            $this->msheet->orLike('course.short_name', $keyword);
        }
        if (!empty($status)) {
            $this->msheet->where('marksheets.status', $status);  
        }
        $this->msheet->where('marksheets.branch_id', $branchId);
        $this->msheet->groupBy('marksheets.id');
        $this->msheet->orderBy('marksheets.id', 'desc');
        $this->msheet->limit($rowperpage, $start);

        $data = $this->msheet->get()->getResult();
        return $data;
    }
    
    public function getAjaxDatatableHoMarksheetList($keyword = '', $columnSortOrder = '', $rowperpage = 0, $start = 0,$branchId = 0, $status = '' )
    {
        $this->msheet->select('marksheets.*, course.short_name, admission.is_urgent_certificate_required');
        $this->msheet->join('course', 'course.id=marksheets.course_id', 'left');
        $this->msheet->join('admission', 'admission.enrollment_number=marksheets.enrollment_number', 'left');

        if (!empty($keyword)) {
            $this->msheet->like('marksheets.marksheet_no', $keyword);
            $this->msheet->orLike('marksheets.enrollment_number', $keyword);
            $this->msheet->orLike('marksheets.candidate_name', $keyword);
            $this->msheet->orLike('course.short_name', $keyword);
        }
        if (!empty($status)) {
            $this->msheet->where('marksheets.status', $status);  
        }
        if (!empty($branchId)) {
            $this->msheet->where('marksheets.branch_id', $branchId);  
        }
        $this->msheet->groupBy('marksheets.id');
        $this->msheet->orderBy('marksheets.id', 'desc');
        $this->msheet->limit($rowperpage, $start);

        $data = $this->msheet->get()->getResult();
        return $data;
    }

    public function getCertificateListCount($where = '')
    {
        $this->cert->select('certificates.id');
        $this->cert->join('course', 'course.id=certificates.course_id', 'left');
        $this->cert->where($where);
        $count = $this->cert->countAllResults();
        if ($count > 0) {
            return $count;
        } else {
            return 0;
        }
    }

    public function getAjaxDatatableCertificateList($keyword = '', $columnSortOrder = '', $rowperpage = 0, $start = 0,$branchId=0, $status = '' )
    {
        $this->cert->select('certificates.*, course.short_name, admission.is_urgent_certificate_required');
        $this->cert->join('course', 'course.id=certificates.course_id', 'left');
        $this->cert->join('admission', 'admission.enrollment_number=certificates.enrollment_number', 'left');
        
        if (!empty($keyword)) {
            $this->cert->like('certificates.certificate_no', $keyword);
            $this->cert->orLike('certificates.enrollment_number', $keyword);
            $this->cert->orLike('certificates.candidate_name', $keyword);
            $this->cert->orLike('certificates.grade', $keyword);
            $this->cert->orLike('course.short_name', $keyword);
        }
        if (!empty($status)) {
            $this->cert->where('certificates.status', $status);  
        }
        $this->cert->where('certificates.branch_id', $branchId);
        $this->cert->groupBy('certificates.id');
        $this->cert->orderBy('certificates.id', 'desc');
        $this->cert->limit($rowperpage, $start);

        $data = $this->cert->get()->getResult();
        return $data;
    }

    public function getAjaxDatatableHoCertificateList($keyword = '', $columnSortOrder = '', $rowperpage = 0, $start = 0,$branchId = 0, $status = '' )
    {
        $this->cert->select('certificates.*, course.short_name, admission.is_urgent_certificate_required');
        $this->cert->join('course', 'course.id=certificates.course_id', 'left');
        $this->cert->join('admission', 'admission.enrollment_number=certificates.enrollment_number', 'left');

        if (!empty($keyword)) {
            $this->cert->like('certificates.certificate_no', $keyword);
            $this->cert->orLike('certificates.enrollment_number', $keyword);
            $this->cert->orLike('certificates.candidate_name', $keyword);
            $this->cert->orLike('certificates.grade', $keyword);
            $this->cert->orLike('course.short_name', $keyword);
        }
        if (!empty($status)) {
            $this->cert->where('certificates.status', $status);  
        }
        if (!empty($branchId)) {
            $this->cert->where('certificates.branch_id', $branchId);  
        }
        $this->cert->groupBy('certificates.id');
        $this->cert->orderBy('certificates.id', 'desc');
        $this->cert->limit($rowperpage, $start);

        $data = $this->cert->get()->getResult();
        return $data;
    }

    public function getAdmitsListCount($where = '')
    {
        $this->admit->select('admits.id');
        $this->admit->where($where);
        $count = $this->admit->countAllResults();
        if ($count > 0) {
            return $count;
        } else {
            return 0;
        }
    }

    public function getAjaxDatatableAdmitsList($keyword = '', $columnSortOrder = '', $rowperpage = 0, $start = 0,$branchId=0)
    {
        $this->admit->select('admits.*');
        if (!empty($keyword)) {
            $this->admit->like('admits.id', $keyword);
            $this->admit->orLike('admits.enrollment_number', $keyword);
            $this->admit->orLike('admits.candidate_name', $keyword);
            $this->admit->orLike('admits.exam_name', $keyword);
            $this->admit->orLike('admits.exam_time', $keyword);
        }
        $this->admit->where('admits.branch_id', $branchId);
        $this->admit->groupBy('admits.id');
        $this->admit->orderBy('admits.id', 'desc');
        $this->admit->limit($rowperpage, $start);

        $data = $this->admit->get()->getResult();
        return $data;
    }

    public function getAjaxDatatableHoAdmitList($keyword = '', $columnSortOrder = '', $rowperpage = 0, $start = 0,$branchId=0)
    {
        $this->admit->select('admits.*');
        if (!empty($keyword)) {
            $this->admit->like('admits.id', $keyword);
            $this->admit->orLike('admits.enrollment_number', $keyword);
            $this->admit->orLike('admits.candidate_name', $keyword);
            $this->admit->orLike('admits.exam_name', $keyword);
            $this->admit->orLike('admits.exam_time', $keyword);
        }
        if (!empty($branchId)) {
            $this->admit->where('admits.branch_id', $branchId);
        }
        $this->admit->groupBy('admits.id');
        $this->admit->orderBy('admits.id', 'desc');
        $this->admit->limit($rowperpage, $start);

        $data = $this->admit->get()->getResult();
        return $data;
    }

    public function getStudyMatsListCount($where = '')
    {
        $this->csm->select('course_study_materials.id');
        $this->csm->join('branch', 'branch.id=course_study_materials.branch_id', 'left');
        $this->csm->join('course', 'course.id=course_study_materials.course_id', 'left');
        $this->csm->join('course_type', 'course_type.id=course_study_materials.course_type', 'left');
        $this->csm->where($where);
        $count = $this->csm->countAllResults();
        if ($count > 0) {
            return $count;
        } else {
            return 0;
        }
    }


    public function getStudyMatsListCountBranch($where = '', $courseIds = array())
    {
        $this->csm->select('course_study_materials.id');
        $this->csm->join('branch', 'branch.id=course_study_materials.branch_id', 'left');
        $this->csm->join('course', 'course.id=course_study_materials.course_id', 'left');
        $this->csm->join('course_type', 'course_type.id=course_study_materials.course_type', 'left');
        if (!empty($where)) {
            $this->csm->where($where);
        }
        $this->csm->whereIn('course_study_materials.course_id', $courseIds);
        $this->csm->groupBy('course_study_materials.course_id');
        $count = $this->csm->countAllResults();
        if ($count > 0) {
            return $count;
        } else {
            return 0;
        }
    }

    public function getAjaxDatatableHoStudyMatsList($keyword = '', $columnSortOrder = '', $rowperpage = 0, $start = 0)
    {
        $this->csm->select('course_study_materials.*, course.course_name, course.short_name, course_type.course_type as courseTypeName');
        $this->csm->join('course', 'course.id=course_study_materials.course_id', 'left');
        $this->csm->join('course_type', 'course_type.id=course_study_materials.course_type', 'left');
        if (!empty($keyword)) {
            $this->csm->like('course.course_name', $keyword);
            $this->csm->orLike('course.short_name', $keyword);
            $this->csm->orLike('course_type.course_type', $keyword);
        }
        $this->csm->groupBy('course_study_materials.id');
        $this->csm->where('course_study_materials.added_by', 1);
        $this->csm->orderBy('course_study_materials.id', 'desc');
        $this->csm->limit($rowperpage, $start);

        $data = $this->csm->get()->getResult();
        return $data;
    }

    public function getAjaxDatatableHoStudyMatsListBranch($keyword = '', $columnSortOrder = '', $rowperpage = 0, $start = 0, $branchId = 0, $courseIds = array())
    {
        $this->csm->select('course_study_materials.*, course.course_name, course.short_name, course_type.course_type as courseTypeName');
        $this->csm->join('course', 'course.id=course_study_materials.course_id', 'left');
        $this->csm->join('course_type', 'course_type.id=course_study_materials.course_type', 'left');
        if (!empty($keyword)) {
            $this->csm->groupStart();
            $this->csm->like('course.course_name', $keyword);
            $this->csm->orLike('course.short_name', $keyword);
            $this->csm->orLike('course_type.course_type', $keyword);
            $this->csm->groupEnd();
        }
        $this->csm->groupStart();
        $this->csm->whereIn('course_study_materials.course_id', $courseIds);
        $this->csm->groupEnd();
        $this->csm->groupStart();
        $this->csm->where('course_study_materials.added_by', 1);
        $this->csm->orWhere("course_study_materials.added_by=2 AND course_study_materials.created_by=$branchId");
        $this->csm->groupEnd();

        $this->csm->groupBy('course_study_materials.course_id');
        $this->csm->orderBy('course_study_materials.id', 'desc');
        $this->csm->limit($rowperpage, $start);
        $data = $this->csm->get()->getResult();
        return $data;
    }

    public function getAjaxDatatableCombinedPdfList($where = '', $columnSortOrder = '', $rowperpage = 0, $start = 0)
    {
        $this->cpdf->select('*');
        if (!empty($where)) {
            $this->cpdf->where($where);
        }
        $this->cpdf->groupBy('id');
        $this->cpdf->orderBy('id', 'desc');
        $this->cpdf->limit($rowperpage, $start);

        $data = $this->cpdf->get()->getResult();
        return $data;
    }

    public function getStudPaymentListCount($where = '')
    {
        $this->pay->select('payment.id');
        $this->pay->join('admission', 'admission.id=payment.admission_id');
        $this->pay->orderBy('payment.id', 'desc');
        $this->pay->groupBy('payment.id');
        $this->pay->where($where);
        $count = $this->pay->countAllResults();
        if ($count > 0) {
            return $count;
        } else {
            return 0;
        }
    }
   

    public function getAjaxDatatableStudPaymentList($rowperpage = 0, $start = 0, $where = '', $columnSortOrder = '', $columnName = 'id')
    {
        $this->pay->select('payment.invoice_no, payment.amount, payment.course_fees, payment.discount, payment.invoice_file, payment.created_at, admission.course_code, admission.enrollment_number');
        $this->pay->join('admission', 'admission.id=payment.admission_id');
        $this->pay->groupBy('payment.id');
        $this->pay->where($where);
        $this->pay->orderBy($columnName, $columnSortOrder);
        $this->pay->limit($rowperpage, $start);
        $data = $this->pay->get()->getResult();
        return $data;
    }

    public function getAjaxDatatableBranchDocsListByHo($columnSortOrder = '', $rowperpage = 0, $start = 0, $columnName = 'id')
    {
        $this->media->select('*');
        $this->media->where('type', 2);
        $this->media->orderBy($columnName, $columnSortOrder);
        $this->media->limit($rowperpage, $start);
        $data = $this->media->get()->getResult();
        return $data;
    }

    public function getWalletTransactionDataCount($where = '')
    {
        $this->wallet->select("wallet.*, b.branch_name");
        $this->wallet->join('branch as b', 'b.id=wallet.branch', 'left');
        if (!empty($where)) {
            $this->wallet->where($where);
        }
        $this->wallet->orderBy('wallet.id','desc');
        $count = $this->wallet->countAllResults();
        if ($count > 0) {
            return $count;
        } else {
            return 0;
        }
    }

    public function getAjaxDatatableWalletTransactionData($rowperpage = 0, $start = 0, $where = '', $columnSortOrder = '', $columnName = 'wallet.id')
    {
        $this->wallet->select("wallet.*, b.branch_name");
        $this->wallet->join('branch as b', 'b.id=wallet.branch', 'left');
        if (!empty($where)) {
            $this->wallet->where($where);
        }
        $this->wallet->orderBy($columnName, $columnSortOrder);
        $this->wallet->limit($rowperpage, $start);
        $data = $this->wallet->get()->getResult();
        return $data;
    }

 


 
}
