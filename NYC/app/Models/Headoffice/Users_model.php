<?php namespace App\Models\Headoffice;

use CodeIgniter\Model;

class Users_model extends Model
{
	protected $db;

	public function __construct($db){
		$this->db =& $db;
		$this->builder = $this->db->table('users');
		$this->session = \Config\Services::session();
		
	}


	function getUserByGroup($group_id){
		if (isset($group_id) && is_numeric($group_id)) {
			$select = '';
			if ($group_id != 1) {
				$select .= ',us.name as parentName';
			}
			$this->builder->select("users.* $select");

			if ($group_id != 1) {
				$this->builder->join('users as us', 'us.id=users.parent_id', 'left');
			}

			#if the user is a supervisor
			if (is_supervisor()) {
				$this->builder->where('users.parent_id', $this->session->userData['id']);
			}
			$this->builder->where('users.group_id', $group_id);
			$this->builder->where('users.is_deleted', 1);
			$this->builder->orderBy('users.id','desc');
			$data = $this->builder->get()->getResult();
			if (!empty($data)) {
				return $data;
			}
		}else{
			return false;
		}
	}

	function getUserById ($id){
		if (isset($id) && is_numeric($id)) {
			$this->builder->select('*');
			$this->builder->where('id', $id);
			$this->builder->groupBy('id');
			$this->builder->orderBy('id','desc');
			$this->builder->limit(1);
			$data = $this->builder->get()->getRow();
			if (!empty($data)) {
				return $data;
			}
		}else{
			return false;
		}
	}

	function insertPersonalDetails($data = array())
	{
		if (!empty($data)) {
			if ($this->builder->insert($data)) {
				return $this->db->insertID();
			}else {
				return false;
			}
		}else {
			return false;
		}
	}

	function updatePersonalDetails($id = '', $data = array())
	{
		if (!empty($data) && is_numeric($id)) {
			$this->builder->where('id', $id);
			if ($this->builder->update($data)) {
				return true;
			}else {
				return false;
			}
		}else{
			return false;
		}
	}

	function username_exist_in_database($name='', $id = 0)
	{
		$this->builder->select('user_name');
		$this->builder->where('user_name', $name);
		if ($id > 0 && is_numeric($id)) {
			$this->builder->where('id <>', $id);
		}
		$count = $this->builder->countAllResults();
		if ($count == 0) {
			return false;
		}else {
			return true;
		}
	}

	function getUsersListDd($type = 0, $name = ''){
		$this->builder->select('*');
		$this->builder->where('group_id', $type);
		if (!empty($name)) {
			$this->builder->like('name', $name);
			$this->builder->orLike('email', $name);
		}
		$this->builder->orderBy('name','asc');
		$data = $this->builder->get()->getResult();
		if (!empty($data)) {
			return $data;
		}
	}

}
