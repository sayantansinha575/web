<?php namespace Auth\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\ConnectionInterface;

class RegisterModel extends Model
{

  protected $db;
  public function __construct(ConnectionInterface &$db) {
    $this->db =&$db;
    $this->builder=$this->db->table('users');

  }


  function add($data){
  	return $this->builder->insert($data);
  }






}
