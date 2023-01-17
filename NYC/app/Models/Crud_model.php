<?php namespace App\Models;

use CodeIgniter\Model;

class Crud_model extends Model
{
    public function add($table, $data = array())
    {
        if (!empty($table) && !empty($data)) {
            $db = db_connect();
            $builder = $db->table($table);
            if ($builder->insert($data)) {
                return $db->insertID();
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function updateData($table, $where = array(), $data = array(), $whereNotInColumn='', $whereNotInData = array())
    {
        if (!empty($table) && !empty($where) && !empty($data)) {
            $db = db_connect();
            $builder = $db->table($table);
            $builder->where($where);
            if (!empty($whereNotInData) && !empty($whereNotInColumn)) {
                $builder->whereNotIn($whereNotInColumn, $whereNotInData);
            }
            if ($builder->update($data)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function select($table, $select = '', $where = array(), $orderBy = array(), $singleRow = false, $groupBy = '', $whrNotInCol='', $whrNotInData = array())
    {
        if (!empty($table)) {
            if (empty($select)) {
                $select = '*';
            }
            $db = db_connect();
            $builder = $db->table($table);
            $builder->select($select);

            if (!empty($where)) {
                $builder->where($where);
            }
            if (!empty($whrNotInData) && !empty($whrNotInCol)) {
                $builder->whereNotIn($whrNotInCol, $whrNotInData);
            }
            if (!empty($orderBy)) {
                $builder->orderBy($orderBy);
            }
            if (!empty($groupBy)) {
               $builder->groupBy($groupBy); 
            }
            if (!empty($singleRow)) {
                $data = $builder->get()->getRow();
            }else{
                $data = $builder->get()->getResult();
            }
            if (!empty($data)) {
                return $data;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function deleteData($table, $where = array())
    {
        if (!empty($table)) {
            if (empty($select)) {
                $select = '*';
            }
            $db = db_connect();
            $builder = $db->table($table);

            if (!empty($where)) {
                $builder->where($where);
            }
            if ($builder->delete()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
