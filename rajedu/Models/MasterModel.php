<?php namespace App\Models;

use CodeIgniter\Model;

class MasterModel extends Model
{
    protected $db;

    public function __construct($db)
    {
        $this->db =& $db;
        $this->builder = $this->db->table('master_data');
    }

    function getMasterData(array $id, int $type)
    {
        $this->builder->select('*')
        ->whereIn('id', $id)
        ->where('type', $type)
        ->where('status', 1);
        return $this->builder->get()->getResultArray();
    }

    function getMasterDataByType(int $type)
    {
        $this->builder->select('*')
        ->where('type', $type)
        ->where('status', 1);
        return $this->builder->get()->getResultArray();
    }

}
