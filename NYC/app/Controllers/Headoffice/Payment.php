<?php
namespace App\Controllers\Headoffice;

use App\Models\Crud_model;
use App\Models\Datatable_model;


use Config\Services;

class Payment extends BaseController
{

    public function __construct()
    {
        $db = db_connect();
        $this->request = \Config\Services::request();
        $this->session = \Config\Services::session();

        $this->crud = new Crud_model($db);
        $this->dt = new Datatable_model($db);


        //load helper
        helper('custom');
    }

    public function index()
    {
         if(($this->request->getMethod() == "get") && !$this->request->isAjax()){
            $this->data['title'] = 'Payment';
            $this->data['branches'] = $this->crud->select('branch', 'branch_name, id', array('status' => 1));
            return view('headoffice/payment/manage-payment', $this->data);
         }
    }

    /*AJAX REQUESTS*/

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
        $branchId = $dtpostData['branchId'];

        ## Total number of records without filtering
        $totalRecords = get_count('payment', array('id<>'=>0));
        ## Total number of records with filtering
        $totalRecordwithFilter = $totalRecords;
        if (!empty($keyword)) {
            $where .= empty($where)?"`adm.enrollment_number` LIKE '%$keyword%' ESCAPE '!' OR `adm.student_name` LIKE '%$keyword%' ESCAPE '!'":" AND `adm.enrollment_number` LIKE '%$keyword%' ESCAPE '!' OR `adm.student_name` LIKE '%$keyword%' ESCAPE '!' OR `br.branch_name` LIKE '%$keyword%' ESCAPE '!'";
        }
        if (!empty($where)) {
            $totalRecordwithFilter = $this->dt->getPaymentListCount($where);
        }

        ## Fetch records
        $records = $this->dt->getAjaxDatatableHoPaymentList($keyword, $columnSortOrder, $rowperpage, $start, $branchId);
        $data = array();
        $i = $start+1;
        foreach($records as $record ){
            $data[] = array( 
                "slNo" => $i++,
                "branch_name" => $record->branch_name,
                "student_name" => $record->enrollment_number,
                "invoice_number" => $record->invoice_no,
                "amount" => number_format($record->amount,2),
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
