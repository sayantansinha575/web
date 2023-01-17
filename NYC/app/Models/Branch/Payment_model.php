<?php namespace App\Models\Branch;

use CodeIgniter\Model;

class Payment_model extends Model
{
	protected $db;

	public function __construct($db){
		$this->db =& $db;
		$this->builder = $this->db->table('payment');
	}


	public function getPaymentDetailsByEnrollNo($enrollNo = 0, $branchId = 0) {
		if (!empty($enrollNo) && !empty($branchId)) {
			$this->builder->select('payment.*, adm.student_name, adm.registration_number');
			$this->builder->join('admission adm', 'adm.id=payment.admission_id');
			if (!empty($branchId)) {
				$this->builder->where('payment.branch_id', $branchId);
			}
			$this->builder->where('adm.enrollment_number', $enrollNo);
			$this->builder->orderBy('payment.id', 'desc');
			$this->builder->groupBy('payment.id');
			$data = $this->builder->get()->getResult();
			if (!empty($data)) {
				return $data;
			}else {
				return false;
			}
		}else {
			return false;
		}
	}
}
