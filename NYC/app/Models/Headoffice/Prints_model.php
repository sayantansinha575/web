<?php namespace App\Models\Headoffice;

use CodeIgniter\Model;

class Prints_model extends Model
{
	protected $db;

	public function __construct($db){
		$this->db =& $db;
		$this->builder = $this->db->table('combined_pdf');		
	}


	function getgeneratedMarksheetIds(){
		$id = array();
		$this->builder->select('marksheet_id');
		$this->builder->where('marksheet_id<>', '');
		$this->builder->orderBy('id', 'desc');
		$data = $this->builder->get()->getResult();
		if (!empty($data)) {
			foreach ($data as $val) {
				$id = array_merge($id, unserialize($val->marksheet_id));
			}
		}
		return $id;
	}
	
	function generatedCertificateIds(){
		$id = array();
		$this->builder->select('certificate_id');
		$this->builder->where('certificate_id<>', '');
		$this->builder->orderBy('id', 'desc');
		$data = $this->builder->get()->getResult();
		if (!empty($data)) {
			foreach ($data as $val) {
				$id = array_merge($id, unserialize($val->certificate_id));
			}
		}
		return $id;
	}
}
