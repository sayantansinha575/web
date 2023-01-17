<?php namespace Auth\Models;

use CodeIgniter\Model;

class StudentModel extends Model
{
	protected $table      = 'student';
	protected $primaryKey = 'id';

	protected $returnType = 'array';
	protected $useSoftDeletes = false;

	// this happens first, model removes all other fields from input data
	protected $allowedFields = [
		'branch_id', 'registration_number', 'password', 'student_name', 'student_photo', 'status',
		'is_deleted'
	];

	protected $useTimestamps = true;
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $dateFormat  	 = 'int';

	protected $validationRules = [];

	// we need different rules for registration, account update, etc
	protected $dynamicRules = [
		'registration' => [
			'name' 				=> 'required|min_length[2]',
			'email' 			=> 'required|valid_email|is_unique[users.email]',
			'password'			=> 'required|min_length[5]',
			'password_confirm'	=> 'matches[password]'
		],
		'updateAccount' => [
			'id'	=> 'required|is_natural_no_zero',
			'name'	=> 'required|min_length[2]'
		],
		'changeEmail' => [
			'id'			=> 'required|is_natural_no_zero',
			'new_email'		=> 'required|valid_email|is_unique[users.email]',
			'activate_hash'	=> 'required'
		]
	];

	protected $validationMessages = [];

	protected $skipValidation = false;

	// this runs after field validation
	protected $beforeInsert = ['hashPassword'];
	protected $beforeUpdate = ['hashPassword'];


    //--------------------------------------------------------------------

    /**
     * Retrieves validation rule
     */
	public function getRule(string $rule)
	{
		return $this->dynamicRules[$rule];
	}


}
