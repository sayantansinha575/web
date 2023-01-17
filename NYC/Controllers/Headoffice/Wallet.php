<?php namespace App\Controllers\Headoffice;
use App\Models\Crud_model;
use App\Models\Headoffice\Wallet_model;
use App\Models\Datatable_model;
use App\Models\Notification_model;


class Wallet extends BaseController
{


	public function __construct()
	{
		$db = db_connect();
		$this->request = \Config\Services::request();
		$this->session = \Config\Services::session();

		$this->crud = new Crud_model($db);
		$this->wallet = new Wallet_model($db);
        $this->dt = new Datatable_model($db);
        $this->notification = new Notification_model($db);

		//load helper
		helper('custom');
	}

	public function index($type = 0)
	{
		if ($this->request->getMethod() == 'get') {
			// echo 'string'; die;
			$this->data['title'] = 'Wallet';
			$this->data['transactions'] = $this->wallet->getTransaction();
			return view('headoffice/wallet/wallet-list', $this->data);
		}
	}


	function add_transaction($id = 0)
	{
		if($this->request->getMethod() == "post"){
			if ($this->request->isAjax() && is_headoffice()) {
				$this->data['success'] = false;
				$this->data['hash'] = csrf_hash();
				if (strlen($this->request->getPost('branch')) == 0) {
					$this->data['id'] = '#branch';
					$this->data['message'] = 'Select branch';
					error($this->data);
				}
				if (strlen($this->request->getPost('transaction_type')) == 0) {
					$this->data['id'] = '#transaction_type';
					$this->data['message'] = 'Select transaction type';
					error($this->data);
				}
				if (strlen($this->request->getPost('amount')) == 0 || $this->request->getPost('amount') <= 0) {
					$this->data['id'] = '#amount';
					$this->data['message'] = 'Enter amount';
					error($this->data);
				}

				$data = $this->request->getPost();
				unset($data['csrf_token_name']);
				
				$data['added_by'] = $this->session->userData['id'];
				$data['created_at'] = strtotime('now');

				if ($last_id = $this->crud->add('wallet', $data)) {

                    $notiArr = array(
                        'from_id' => $this->session->userData['id'],
                        'form_id_type' => 1,
                        'to_id' => $this->request->getPost('branch'),
                        'to_id_type' => 2,
                        'type' => 9,
                        'slug' => 'branch-wallet-transaction',
                        'date' => strtotime('now'),
                    );
                    $this->notification->addNotification('notifications', $notiArr);

					$this->data['success'] = true;
					$this->data['message'] = 'Transaction details has been successfully added';
					echo json_encode($this->data); die;
				}else{
					$this->data['message'] = 'Something went wrong!';
					echo json_encode($this->data); die;
				}
			}
		}else if($this->request->getMethod() == "get"){
			$this->data['title'] = 'Add Transaction';
			$this->data['branches'] = $this->crud->select('branch','', array('status' => 1));
			return view('headoffice/wallet/add-transaction', $this->data);
		}
	}

	public function ajax_dt_get_wallet_list()
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
        $type = $dtpostData['type'];
        switch ($columnName) {
            case 'slNo':
            $columnName = 'wallet.id';
            break;
            case 'amount':
            $columnName = 'wallet.amount';
            break;
            case 'date':
            $columnName = 'wallet.created_at';
            break;
            default:
            $columnName = 'wallet.id';
            break;
        }

        //init where for each time

        ## Total number of records without filtering
        $totalRecords = $this->dt->getWalletTransactionDataCount();
        ## Total number of records with filtering
        $totalRecordwithFilter = $totalRecords;


        if (!empty($keyword)) {
            $where .= empty($where)?"(`b.branch_name` LIKE '%$keyword%' ESCAPE '!' OR `wallet.notes` LIKE '%$keyword%' ESCAPE '!' OR `wallet.amount` LIKE '%$keyword%' ESCAPE '!')":" AND (`b.branch_name` LIKE '%$keyword%' ESCAPE '!' OR `wallet.notes` LIKE '%$keyword%' ESCAPE '!' OR `wallet.amount` LIKE '%$keyword%' ESCAPE '!')";
        }
        if (!empty($type)) {
            $where .= empty($where)?"`wallet.transaction_type`=$type":" AND `wallet.transaction_type`=$type";
        }
        if (!empty($where)) {
            $totalRecordwithFilter = $this->dt->getWalletTransactionDataCount($where);
        }



        ## Fetch records
        $records = $this->dt->getAjaxDatatableWalletTransactionData($rowperpage, $start, $where, $columnSortOrder, $columnName);
        $data = array();
        $i = $start+1;

        foreach($records as $record ){
            if ($record->transaction_type == 1) {
            	$type = '<h5><span class="badge badge-success-lighten">Credited</span></h5>';
            } else {
            	$type = '<h5><span class="badge badge-danger-lighten">Debited</span></h5>';
            }

            $data[] = array( 
                "slNo" => $i++,
                "branch_name" => $record->branch_name,
                "purpose" => (empty(strip_tags($record->notes)))?'NA':strip_tags($record->notes),
                "amount" => number_format($record->amount, 2),
                "type" => $type,
                "date" => date('F j, Y', $record->created_at),
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
