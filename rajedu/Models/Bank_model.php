<?php namespace App\Models;

use CodeIgniter\Model;

class Bank_model extends Model
{
    protected $db;

    public function __construct($db)
    {
        $this->db =& $db;
        $this->builder = $this->db->table('bank_details');
       
    }

  
    public function getList($user_id=0){
        $this->builder->select('*');
        if (! empty($user_id)){
          $this->builder->where('user_id', $user_id);
      }
      $data = $this->builder->get()->getResultArray();
      return $data;
  }


}
