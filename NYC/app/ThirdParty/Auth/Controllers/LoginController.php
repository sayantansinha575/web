<?php
namespace Auth\Controllers;

use CodeIgniter\Controller;
use Config\Email;
use Config\Services;
use Auth\Models\UserModel;
use Auth\Models\BranchModel;
use Auth\Models\StudentModel;


class LoginController extends Controller
{
	/**
	 * Access to current session.
	 *
	 * @var \CodeIgniter\Session\Session
	 */
	protected $session;

	/**
	 * Authentication settings.
	 */
	protected $config;


    //--------------------------------------------------------------------

	public function __construct()
	{
		// start session
		$this->session = Services::session();

		// load auth settings
		$this->config = config('Auth');

	}

    //--------------------------------------------------------------------

	/**
	 * Displays login form or redirects if user is already logged in.
	 */
	public function login()
	{	
		if ($this->session->isLoggedIn) {
			if ($this->session->userData['group_id'] == 1) {
				return redirect()->to('head-office/dashboard');
			}
			
		}
		return view($this->config->views['login'], ['config' => $this->config]);
	}	

	public function branch_login()
	{
		if ($this->session->isBranchLoggedIn) {
			return redirect()->to('branch/dashboard');
		}
		return view($this->config->views['branch-login'], ['config' => $this->config]);
	}

    //--------------------------------------------------------------------

	/**
	 * Attempts to verify user's credentials through POST request.
	 */
	public function attemptLogin()
	{
		// validate request
		// print_r($this->request->getVar());
			

		$rules = [
			'email'		=> 'required',
			'password' 	=> 'required|min_length[5]',
		];

		if (! $this->validate($rules)) {
			return redirect()->to('head-office')
			->withInput()
			->with('errors', $this->validator->getErrors());
		}
		// check credentials
		$users = new UserModel();
		$user = $users->where('email', $this->request->getPost('email'))->first();
		$user || $user = $users->where('mobile', $this->request->getPost('email'))->first();
		if (
			is_null($user) ||
			! password_verify($this->request->getPost('password'), $user['password_hash'])
		) {
			return redirect()->to('head-office')->withInput()->with('error', lang('Auth.wrongCredentials'));
		}

		// check activation
		if (!$user['active'] || !$user['is_deleted']) {
			return redirect()->to('head-office')->withInput()->with('error', lang('Auth.notActivated'));
		}

		// login OK, save user data to session
		$this->session->set('isLoggedIn', true);
		$this->session->set('userData', [
			'id' 			=> $user['id'],
			'group_id' 		=> $user['group_id'],
			'parent_id' 	=> $user['parent_id'],
			'name' 			=> $user['name'],
			'email' 		=> $user['email'],
			'image' 		=> $user['image']
		]);
		if($user['group_id'] == 1){
			return redirect()->to('head-office/dashboard');
		}
		
	}


	public function attemptBranchLogin()
	{
		$rules = [
			'email'		=> 'required',
			'password' 	=> 'required|min_length[5]',
		];

		if (! $this->validate($rules)) {
			return redirect()->to('branch')
			->withInput()
			->with('errors', $this->validator->getErrors());
		}
		// check credentials
		$branchM = new BranchModel();
		$branch = $branchM->where('branch_email', $this->request->getPost('email'))->first();
		$branch || $branch = $branchM->where('username', $this->request->getPost('email'))->first();
		if (
			is_null($branch) ||
			! password_verify($this->request->getPost('password'), $branch['password'])
		) {
			return redirect()->to('branch')->withInput()->with('error', lang('Auth.wrongCredentials'));
		}

		// check activation
		if ($branch['status'] == 2) {
			return redirect()->to('branch')->withInput()->with('error', lang('Auth.notActivated'));
		}

		// login OK, save user data to session
		$this->session->set('isBranchLoggedIn', true);
		$this->session->set('branchData', [
			'id' 			=> $branch['id'],
			'branch_name' 			=> $branch['branch_name'],
			'branch_email' 		=> $branch['branch_email'],
			'branch_image' 		=> $branch['branch_image']
		]);
		return redirect()->to('branch/dashboard');
		
	}


	public function attemptStudentLogin()
	{
		$rules = [
			'registration_number' => ['label' => 'Registration Number', 'rules' => 'required'],
			'password' => ['label' => 'Password', 'rules' => 'required|min_length[5]'],
		];

		if (!$this->validate($rules)) {
			return redirect()->to('')
			->withInput()
			->with('errors', $this->validator->getErrors());
		}
		// check credentials
		$studentM = new StudentModel();
		$student = $studentM->where('registration_number', $this->request->getPost('registration_number'))->first();
		if (
			is_null($student) ||
			! password_verify($this->request->getPost('password'), $student['password'])
		) {
			return redirect()->to('')->withInput()->with('error', lang('Auth.wrongCredentials'));
		}

		// check activation
		if ($student['status'] == 2) {
			return redirect()->to('')->withInput()->with('error', lang('Auth.notActivated'));
		}

		// login OK, save user data to session
		$this->session->set('isStudLoggedIn', true);
		$this->session->set('studData', [
			'id' 			=> $student['id'],
			'branchId' 			=> $student['branch_id'],
			'studentName' 		=> $student['student_name'],
			'registrationNumber' 		=> $student['registration_number'],
			'student_photo' 		=> $student['student_photo']
		]);
		return redirect()->to('student/dashboard');
		
	}

    //--------------------------------------------------------------------

	/**
	 * Log the user out.
	 */
	public function logout()
	{
		$this->session->remove(['isLoggedIn', 'userData']);

		return redirect()->to('head-office');
	}

	public function branch_logout()
	{
		$this->session->remove(['isBranchLoggedIn', 'branchData']);

		return redirect()->to('branch');
	}

	public function student_logout()
	{
		$this->session->remove(['isStudLoggedIn', 'studData']);

		return redirect()->to('');
	}

}
