<?php namespace App\Models;

use CodeIgniter\Model;

class University_model extends Model
{
    protected $db;

    public function __construct($db)
    {
        $this->db =& $db;
        $this->builder = $this->db->table('universities');
        
       
    }

    function getUnviersityDataById($id = 0) //Unviversity model method
    {
        $this->builder->select('*');

        $this->builder->where('universities.id', $id);
        
        $this->builder->groupBy('universities.id');
       
        return $this->builder->get()->getRowArray();
    }

}
