<?php namespace App\Models\Headoffice;

use CodeIgniter\Model;

class Wallet_model extends Model
{
	protected $db;

	public function __construct($db){
		$this->db =& $db;
		$this->builder = $this->db->table('wallet');		
	}


	function getTransaction(){
		$this->builder->select("wallet.*, b.branch_name");
		$this->builder->join('branch as b', 'b.id=wallet.branch', 'left');
		$this->builder->orderBy('wallet.id','desc');
		$data = $this->builder->get()->getResult();
		if (!empty($data)) {
			return $data;
		}
	}
}
