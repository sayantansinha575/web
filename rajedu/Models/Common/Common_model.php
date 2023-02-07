<?php namespace App\Models\Common;

use CodeIgniter\Model;

class Common_model extends Model
{
    protected $db;

    public function __construct($db)
    {
        $this->db =& $db;
        $this->builder = $this->db->table('master_data');
        $this->country = $this->db->table('countries');
        $this->state = $this->db->table('states');
        $this->city = $this->db->table('cities');

    }

    public function getPrograms1($type = 0){
      $this->builder->select('*');
      $this->builder->where('type', $type);
      $data = $this->builder->get()->getResultArray();
      return $data;
    }

    public function getMasterDataDD(int $type, $isCount  = false, $name = '', $limit = 0, $offset = 0)
    {
        $this->builder->select('*');
        if (!empty($name)) {
            $this->builder->like('title', $name);
        }
        $this->builder->where('type', $type)
        ->where('status', 1)
        ->orderBy('title', 'asc');
        if (! $isCount) {
            $this->builder->limit($limit, $offset);
        }
        if ($isCount) {
            return $this->builder->countAllResults();
        } else {
            return $this->builder->get()->getResultArray();
        }
    }

    public function getCountryList($isCount  = false, $name = '', $limit = 0, $offset = 0)
    {
        if (!empty($name)) {
            $this->country->groupStart()
            ->like('name', $name)
            ->orLike('shortname', $name)
            ->groupEnd();
        }
        $this->country->orderBy('name', 'asc');

        if ($isCount) {
            return $this->country->countAllResults();
        } else {
            $this->country->limit($limit, $offset);
            return $this->country->get()->getResultArray();
        }
    }

    public function getStateList($country = 0, $isCount  = false, $name = '', $limit = 0, $offset = 0)
    {
        if (!empty($name)) {
           $this->state->like('name', $name);
        }
        if (!empty($country)) {
         $this->state->where('country_id', $country);
        }
        $this->state->orderBy('name', 'asc');

        if ($isCount) {
            return $this->state->countAllResults();
        } else {
            $this->state->limit($limit, $offset);
            return $this->state->get()->getResultArray();
        }
    }

    public function getCityList($state = 0, $isCount  = false, $name = '', $limit = 0, $offset = 0)
    {
        if (!empty($name)) {
           $this->city->like('name', $name);
        }
        if (!empty($state)) {
         $this->city->where('state_id', $state);
        }
        $this->city->orderBy('name', 'asc');

        if ($isCount) {
            return $this->city->countAllResults();
        } else {
            $this->city->limit($limit, $offset);
            return $this->city->get()->getResultArray();
        }
    }
}