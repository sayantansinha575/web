<?php namespace App\Models;

use CodeIgniter\Model;

class Associate_model extends Model
{
    protected $db;

    public function __construct($db)
    {
        $this->db =& $db;
        $this->builder = $this->db->table('users');
       
    }

    function getAssociateDataById($id = 0) //Associate model method
    {
        $this->builder->select('users.*, user_details.name, user_details.phone, user_details.alternative_phone,user_details.address,user_details.establishment_date,user_details.display_picture');
        $this->builder->join('user_details', 'users.id=user_details.parent_id', 'left');

        $this->builder->where('users.id', $id);
        
        $this->builder->groupBy('users.id');
       
        return $this->builder->get()->getRowArray();
    }


}
