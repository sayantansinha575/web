<?php
namespace App\Controllers\Branch;
use App\Models\Branch\Payment_model;
use App\Models\Notification_model;



class Payment extends BaseController
{

    public function __construct()
    {
        $db = db_connect();
        $this->pay = new Payment_model($db);
        $this->notification = new Notification_model($db);
    }

    public function index()
    {
         if(($this->request->getMethod() == "get") && !$this->request->isAjax()){
            $this->data['title'] = 'Payment';
            return view('branch/payment/manage-payment', $this->data);
         }
    }

    public function new_payment()
    {
        if (($this->request->getMethod() == "get") && !$this->request->isAjax()) {
            $this->data['title'] = 'New Payment';
            $branchId = $this->session->branchData['id'];
            if (!empty($_REQUEST['enrollNo'])) {
                $enrollNo = $_REQUEST['enrollNo'];
                if (!empty($enrollNo)) {
                    $record = $this->pay->getPaymentDetailsByEnrollNo($enrollNo, $branchId);
                    $totalCourseFees = 0; $totalAmountPaid = 0; $totalDiscount = 0; $pendingAmount = 0; $i = 1;
                    $tblData = '<tr><td colspan="6" class="text-center text-muted">No Payments History Found</td></tr>';
                    if (!empty($record)) {
                        foreach ($record as $value) {
                            ($i == 1)?$tblData = '':'';
                            $totalCourseFees = $value->course_fees;
                            $totalAmountPaid += $value->amount;
                            $totalDiscount += $value->discount;
                            $admission_id = $value->admission_id;

                            $tblData .= '<tr>';
                            $tblData .= '<td>'.$i++.'</td>';
                            $tblData .= '<td>'.$value->invoice_no.'</td>';
                            $tblData .= '<td class="indianCurrency">'.number_format($value->course_fees, 2).'</td>';
                            $tblData .= '<td class="indianCurrency">'.number_format($value->discount, 2).'</td>';
                            $tblData .= '<td class="indianCurrency">'.number_format($value->amount, 2).'</td>';
                            $tblData .= '<td>'.date('M j, Y', $value->created_at).'</td>';
                            $tblData .= '</tr>';
                        }
                        $pendingAmount = $totalCourseFees - ($totalAmountPaid + $totalDiscount);
                        $this->data['details'] = array(
                            'totalCourseFees' => $totalCourseFees,
                            'totalAmountPaid' => $totalAmountPaid,
                            'totalDiscount' => $totalDiscount,
                            'pendingAmount' => $pendingAmount,
                            'admission_id' => encrypt($admission_id),
                            'tblData' =>$tblData,
                        );
                    } else {
                        $this->session->setFlashdata('message', 'Please Enter a valid enrollment number');
                        $this->session->setFlashdata('message_type', 'error');
                        return redirect()->to('/branch/payment/new-payment'); die;
                    }
                }else{

                }
            }
            return view('branch/payment/new-payment', $this->data);
        }   
    }

    public function proceed_payment()
    {
      $this->data['success'] = false;
      $this->data['hash'] = csrf_hash();
      if ($this->session->isBranchLoggedIn && $this->request->isAjax()) {
        $admissionId = $this->request->getPost('admission_id');
        if (!empty($admissionId)) {
            $admission_id = decrypt($admissionId);
            $count = get_count('payment', array('admission_id' => $admission_id, 'branch_id' => $this->session->branchData['id']));
            if ($count) {
                $paymentArr = array(
                    'branch_id' =>  $this->session->branchData['id'],
                    'admission_id' => $admission_id,
                    'course_fees' => $this->request->getPost('pending_amount'),
                    'amount' => $this->request->getPost('amount'),
                    'discount' => 0,
                    'payment_type' => 1,
                    'created_at' => strtotime('now'),
                );
                if ($payID = $this->crud->add('payment', $paymentArr)) {
                    $this->crud->updateData('payment', array('id' => $payID), array('invoice_no' => getPrefixByColumnName('invoice_prefix').leadingZero($payID, 4)));
                   
                    $notiArr = array(
                        'from_id' => $this->session->branchData['id'],
                        'form_id_type' => 2,
                        'to_id' => 1,
                        'to_id_type' => 1,
                        'type' => 'new_payment',
                        'slug' => 'new-payment',
                        'date' => strtotime('now'),
                    );
                    $this->notification->addNotification('notifications', $notiArr);
                    
                    $this->data['success'] = true;
                    $this->data['message'] = 'Sucessfully paid';
                    echo json_encode($this->data); die;
                }
            }else{
                $this->data['message'] = 'Access Denied';
                error($this->data);
            }
        }else{
            $this->data['message'] = 'Access Denied';
            error($this->data);
        }
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
        $branchId = $this->session->branchData['id'];

        ## Total number of records without filtering
        $totalRecords = get_count('payment', array('branch_id' => $branchId));
        ## Total number of records with filtering
        $totalRecordwithFilter = $totalRecords;
        $where .= "`payment.branch_id`=$branchId";
        if (!empty($keyword)) {
            $where .= empty($where)?"`adm.enrollment_number` LIKE '%$keyword%' ESCAPE '!' OR `adm.student_name` LIKE '%$keyword%' ESCAPE '!' OR `payment.invoice_no` LIKE '%$keyword%' ESCAPE '!' OR `payment.amount` LIKE '%$keyword%' ESCAPE '!'":" AND adm.enrollment_number` LIKE '%$keyword%' ESCAPE '!' OR `adm.student_name` LIKE '%$keyword%' ESCAPE '!' OR `payment.invoice_no` LIKE '%$keyword%' ESCAPE '!' OR `payment.amount` LIKE '%$keyword%' ESCAPE '!'";
        }
        if (!empty($where)) {
            $totalRecordwithFilter = $this->dt->getPaymentListCount($where);
        }

        ## Fetch records
        $records = $this->dt->getAjaxDatatableBranchPaymentList($keyword, $columnSortOrder, $rowperpage, $start, $branchId);
        $data = array();
        $i = $start+1;
        foreach($records as $record ){
            $actions = ''; $subAction = '';
            if (!empty($record->invoice_file)) {
                $subAction .= '<a class="dropdown-item" href="'.site_url('public/upload/branch-files/student/invoice/'.$record->invoice_file.'.pdf').'" download="'.decrypt($record->invoice_file).'.pdf'.'">Download Invoice</a>';
            }else {
            $subAction .= '<a class="dropdown-item" href="'.site_url('exporter/generate-invoice/'.encrypt($record->id)).'">'.(empty($record->invoice_file)?'Generate Invoice':'Re-Generate Invoice').'</a>';
            }
            
            $actions .= '<div class="dropdown show">
            <a  href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-ellipsis-h"></i>
            </a>
            <div class="drp-select dropdown-menu">
            '.$subAction.'
            </div>
            </div>';


            $data[] = array( 
                "slNo" => $i++,
                "student_name" => $record->student_name.'<br>'.$record->enrollment_number,
                "invoice_number" => $record->invoice_no,
                "course_fees" => number_format($record->course_fees, 2).'<p><span class="indianCurrency">'.number_format($record->discount, 2).'</span><small> (Discount)</small></p>',
                "amount_paid" => number_format($record->amount, 2),
                "pending_amount" => number_format(($record->course_fees - ($record->discount + $record->amount)), 2),
                "created_at" => date('M j, Y', $record->created_at),
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

    public function ajax_get_payment_details_by_enroll_no()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        $enrollNo = $this->request->getPost('enrollNo');
        $branchId = $this->session->branchData['id'];
        if (!empty($enrollNo)) {
            $record = $this->pay->getPaymentDetailsByEnrollNo($enrollNo, $branchId);
            $totalCourseFees = 0; $totalAmountPaid = 0; $totalDiscount = 0; $pendingAmount = 0; $i = 1;
            $tblData = '<tr><td colspan="6" class="text-center text-muted">No Payments History Found</td></tr>';
            if (!empty($record)) {
                foreach ($record as $value) {
                 ($i == 1)?$tblData = '':'';
                 $totalCourseFees = $value->course_fees;
                 $totalAmountPaid += $value->amount;
                 $totalDiscount += $value->discount;
                 $admission_id = $value->admission_id;

                    $tblData .= '<tr>';
                    $tblData .= '<td>'.$i++.'</td>';
                    $tblData .= '<td>'.$value->invoice_no.'</td>';
                    $tblData .= '<td class="indianCurrency">'.number_format($value->course_fees, 2).'</td>';
                    $tblData .= '<td class="indianCurrency">'.number_format($value->discount, 2).'</td>';
                    $tblData .= '<td class="indianCurrency">'.number_format($value->amount, 2).'</td>';
                    $tblData .= '<td>'.date('M j, Y', $value->created_at).'</td>';
                    $tblData .= '</tr>';
                }
                $pendingAmount = $totalCourseFees - ($totalAmountPaid + $totalDiscount);
                $this->data['details'] = array(
                    'totalCourseFees' => $totalCourseFees,
                    'totalAmountPaid' => $totalAmountPaid,
                    'totalDiscount' => $totalDiscount,
                    'pendingAmount' => $pendingAmount,
                    'admission_id' => encrypt($admission_id),
                );
                $this->data['tblData'] = $tblData;
                $this->data['success'] = true;
                echo json_encode($this->data); die;
            }else {
                $this->data['message'] = 'Please Enter a valid enrollment number';
                error($this->data);
            }
        }else {
            $this->data['message'] = 'Please Enter a enrollment number';
            error($this->data);
        }
    }
}
