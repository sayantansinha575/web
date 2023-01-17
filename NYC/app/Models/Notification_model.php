<?php namespace App\Models;

use CodeIgniter\Model;

class Notification_model extends Model
{
	protected $db;
    public function __construct($db)
    {
    	parent::__construct();
    	$this->db =& $db;
        $this->builder = $this->db->table('notifications');
    }

    public function addNotification($table, $data = array())
    {
        //echo '~~'; die;
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

    
}