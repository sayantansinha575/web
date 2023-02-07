<?php namespace App\Models\Common;

use CodeIgniter\Model;

class Datatable_model extends Model
{
    protected $db;

    public function __construct($db)
    {
        $this->db =& $db;
        $this->builder = $this->db->table('products');
        $this->master = $this->db->table('master_data');
        $this->group = $this->db->table('groups');
        $this->user = $this->db->table('users');
        $this->university = $this->db->table('universities');
      
    }

   
    function ajaxGetTypeOfDegreeDt($isCount = false, $rowperpage = '', $start = '', $where = '', $columnSortOrder = '', $columnName = 'master_data.id')
    {
       $this->master->select('*');
        if (!empty($where)) {
            $this->master->where($where);
        }
        $this->master->where('type', 1);
        $this->master->groupBy('id');
        $this->master->orderBy($columnName, $columnSortOrder);
        if (! $isCount) {
            $this->master->limit($rowperpage, $start);
        }
        if ($isCount) {
            return $this->master->countAllResults();
        } else {
            return $this->master->get()->getResultArray();
        }
    }

   
    function ajaxGetUniversityProgramsDt($isCount = false, $rowperpage = '', $start = '', $where = '', $columnSortOrder = '', $columnName = 'master_data.id')
    {
       $this->master->select('*');
        if (!empty($where)) {
            $this->master->where($where);
        }
        $this->master->where('type', 2);
        $this->master->groupBy('id');
        $this->master->orderBy($columnName, $columnSortOrder);
        if (! $isCount) {
            $this->master->limit($rowperpage, $start);
        }
        if ($isCount) {
            return $this->master->countAllResults();
        } else {
            return $this->master->get()->getResultArray();
        }
    }

   
    function ajaxGetIntakeDt($isCount = false, $rowperpage = '', $start = '', $where = '', $columnSortOrder = '', $columnName = 'master_data.id')
    {
       $this->master->select('*');
        if (!empty($where)) {
            $this->master->where($where);
        }
        $this->master->where('type', 4);
        $this->master->groupBy('id');
        $this->master->orderBy($columnName, $columnSortOrder);
        if (! $isCount) {
            $this->master->limit($rowperpage, $start);
        }
        if ($isCount) {
            return $this->master->countAllResults();
        } else {
            return $this->master->get()->getResultArray();
        }
    }
    

    function ajaxGetStatusDt($isCount = false, $rowperpage = '', $start = '', $where = '', $columnSortOrder = '', $columnName = 'master_data.id')
    {
        $this->master->select('*');
        if (!empty($where)) {
            $this->master->where($where);
        }
        $this->master->where('type', 5);
        $this->master->groupBy('id');
        $this->master->orderBy($columnName, $columnSortOrder);
        if (! $isCount) {
            $this->master->limit($rowperpage, $start);
        }
        if ($isCount) {
            return $this->master->countAllResults();
        } else {
            return $this->master->get()->getResultArray();
        }
    }


    function ajaxGetSearchDt($isCount = false, $rowperpage = '', $start = '', $where = '', $columnSortOrder = '', $columnName = 'master_data.id')
    {
        $this->master->select('master_data.*, md2.title program_name');
        $this->master->join('master_data md2', 'md2.id=master_data.title', 'left');
        if (!empty($where)) {
            $this->master->where($where);
        }
        $this->master->where('master_data.type', 3);
        $this->master->groupBy('master_data.id');
        $this->master->orderBy($columnName, $columnSortOrder);
        if (! $isCount) {
            $this->master->limit($rowperpage, $start);
        }
        if ($isCount) {
            return $this->master->countAllResults();
        } else {
            return $this->master->get()->getResultArray();
        }
    }

  function ajaxGetGroupsPermissionsDt($isCount = false, $rowperpage = '', $start = '', $where = '', $columnSortOrder = '', $columnName = 'groups.id')
    {
        $this->group->select('*');
        if (!empty($where)) {
            $this->group->where($where);
        }
        $this->group->groupBy('id');
        $this->group->orderBy($columnName, $columnSortOrder);
        if (! $isCount) {
            $this->group->limit($rowperpage, $start);
        }
        if ($isCount) {
            return $this->group->countAllResults();
        } else {
            return $this->group->get()->getResultArray();
        }
    }


    function ajaxGetTypeOfExamDt($isCount = false, $rowperpage = '', $start = '', $where = '', $columnSortOrder = '', $columnName = 'master_data.id')
    {
       $this->master->select('*');
        if (!empty($where)) {
            $this->master->where($where);
        }
        $this->master->where('type', 6);
        $this->master->groupBy('id');
        $this->master->orderBy($columnName, $columnSortOrder);
        if (! $isCount) {
            $this->master->limit($rowperpage, $start);
        }
        if ($isCount) {
            return $this->master->countAllResults();
        } else {
            return $this->master->get()->getResultArray();
        }
    }


    function ajaxGetTestTypeDt($isCount = false, $rowperpage = '', $start = '', $where = '', $columnSortOrder = '', $columnName = 'master_data.id')
    {
       $this->master->select('*');
        if (!empty($where)) {
            $this->master->where($where);
        }
        $this->master->where('type', 7);
        $this->master->groupBy('id');
        $this->master->orderBy($columnName, $columnSortOrder);
        if (! $isCount) {
            $this->master->limit($rowperpage, $start);
        }
        if ($isCount) {
            return $this->master->countAllResults();
        } else {
            return $this->master->get()->getResultArray();
        }
    }

    function ajaxGetdocumentTypeDt($isCount = false, $rowperpage = '', $start = '', $where = '', $columnSortOrder = '', $columnName = 'master_data.id')
    {
        $this->master->select('*');
        if (!empty($where)) {
            $this->master->where($where);
        }
        $this->master->where('type', 8);
        $this->master->groupBy('id');
        $this->master->orderBy($columnName, $columnSortOrder);
        if (! $isCount) {
            $this->master->limit($rowperpage, $start);
        }
        if ($isCount) {
            return $this->master->countAllResults();
        } else {
            return $this->master->get()->getResultArray();
        }
    }


    function ajaxGetAssociateDt($isCount = false, $rowperpage = '', $start = '', $where = '', $columnSortOrder = '', $columnName = 'users.id')
    {
        $this->user->select('users.*, user_details.name, user_details.phone,user_details.address,user_details.establishment_date');
        $this->user->join('user_details', 'users.id=user_details.parent_id', 'left');
        if (!empty($where)) {
            $this->user->where($where);
        }
        $this->user->where('group_id', 2);
        $this->user->where('deleted', 2);

        $this->user->groupBy('users.id');
        $this->user->orderBy($columnName, $columnSortOrder);
        if (! $isCount) {
            $this->builder->limit($rowperpage, $start);
        }
        if ($isCount) {
            return $this->user->countAllResults();
        } else {
            return $this->user->get()->getResultArray();
        }
    }
    function ajaxUniversityDt($isCount = false, $rowperpage = '', $start = '', $where = '', $columnSortOrder = '', $columnName = 'universities.id')
    {
     $this->university->select('*');
     if (!empty($where)) {
        $this->university->where($where);
    }
    $this->university->groupBy('id');
    $this->university->orderBy($columnName, $columnSortOrder);
    if (! $isCount) {
        $this->university->limit($rowperpage, $start);
    }
    if ($isCount) {
        return $this->university->countAllResults();
    } else {
        return $this->university->get()->getResultArray();
    }
}



}
