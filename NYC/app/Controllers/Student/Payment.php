<?php
namespace App\Controllers\Student;
use App\Models\Student\PaymentModel;

class Payment extends BaseController
{

    public function __construct()
    {
        $db = db_connect();
        $this->paym = new PaymentModel($db);
    }


    public function index()
    {
        $this->data['title'] = 'Payment List';
        $this->data['admissions'] = $this->paym->getEnlistedCourseList($this->session->studData['registrationNumber']);
        return  view('student/payment/list', $this->data);   
    }


    public function ajax_dt_get_payment_list()
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
        $enrollNo = $dtpostData['enrollNo'];
        $studRegistrationNumber = $this->session->studData['registrationNumber'];
        switch ($columnName) {
            case 'slNo':
            $columnName = 'payment.id';
            break;
            case 'invoice_no':
            $columnName = 'payment.invoice_no';
            break;
            case 'course_code':
            $columnName = 'admission.course_code';
            break;
            case 'course_fees':
            $columnName = 'payment.course_fees';
            break;
            case 'discount':
            $columnName = 'payment.discount';
            break;
            case 'amount':
            $columnName = 'payment.amount';
            break;
            case 'created_at':
            $columnName = 'payment.created_at';
            break;
            case 'enrollment_number':
            $columnName = 'admission.enrollment_number';
            break;
            default:
            $columnName = 'payment.id';
            break;
        }

        //init where for each time
        $where .= "`admission.registration_number`='$studRegistrationNumber'";

        ## Total number of records without filtering
        $totalRecords = $this->dt->getStudPaymentListCount($where);
        ## Total number of records with filtering
        $totalRecordwithFilter = $totalRecords;
        if (!empty($keyword)) {
            $where .= empty($where)?"`payment.invoice_no` LIKE '%$keyword%' ESCAPE '!' OR `payment.amount` LIKE '%$keyword%' ESCAPE '!' OR `payment.course_fees` LIKE '%$keyword%' ESCAPE '!' OR `payment.discount` LIKE '%$keyword%' ESCAPE '!' OR `admission.course_code` LIKE '%$keyword%' ESCAPE '!' OR `admission.enrollment_number` LIKE '%$keyword%' ESCAPE '!'":" AND `payment.invoice_no` LIKE '%$keyword%' ESCAPE '!' OR `payment.amount` LIKE '%$keyword%' ESCAPE '!' OR `payment.course_fees` LIKE '%$keyword%' ESCAPE '!' OR `payment.discount` LIKE '%$keyword%' ESCAPE '!' OR `admission.course_code` LIKE '%$keyword%' ESCAPE '!' OR `admission.enrollment_number` LIKE '%$keyword%' ESCAPE '!'";
        }
        if (!empty($enrollNo)) {
            $where .= empty($where)?"`admission.id`=$enrollNo":" AND `admission.id`=$enrollNo";
        }
        if (!empty($where)) {
            $totalRecordwithFilter = $this->dt->getStudPaymentListCount($where);
        }



        ## Fetch records
        $records = $this->dt->getAjaxDatatableStudPaymentList($rowperpage, $start, $where, $columnSortOrder, $columnName);
        $data = array();
        $i = $start+1;

        foreach($records as $record ){
            $actions = ''; 
            if (!empty($record->invoice_file)) {
                $actions .= '<a href="'.site_url('public/upload/branch-files/student/invoice/'.$record->invoice_file.'.pdf').'" download="'.decrypt($record->invoice_file).'.pdf'.'"><i class="zmdi zmdi-download"></i></a>';
            }else {
                $actions .= 'NA';
            }

            $data[] = array( 
                "slNo" => $i++,
                "invoice_no" => $record->invoice_no.'<br><small><p>'.$record->enrollment_number.'</p><p><b>'.date('M j, Y', $record->created_at).'</b></p></small>',
                "course_code" => $record->course_code,
                "course_fees" => number_format($record->course_fees, 2).'<br><span class="inr"> '.number_format($record->discount, 2).'<small> (Discount) </small></span>',
                "amount" => number_format($record->amount, 2).'<br><span class="inr"> '.number_format(($record->course_fees - ($record->amount + $record->discount)), 2).'<small> (Pending)</small></span>',
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
