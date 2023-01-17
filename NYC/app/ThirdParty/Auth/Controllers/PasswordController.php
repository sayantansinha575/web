<?php
namespace Auth\Controllers;

use CodeIgniter\Controller;
use Config\Email;
use Config\Services;
use Auth\Models\UserModel;
use Auth\Models\BranchModel;
use Auth\Models\StudentModel;

class PasswordController extends Controller
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

    public function student_forgot_password()
	{
		if ($this->session->isStudLoggedIn) {
			return redirect()->to('/student/dashboard');
		}

		return view($this->config->views['student-forgot-password'], ['config' => $this->config]);
	}

	public function branchForgotPassword()
	{
		if ($this->session->isStudLoggedIn) {
			return redirect()->to('/branch/dashboard');
		}

		return view($this->config->views['branch-forgot-password'], ['config' => $this->config]);
	}

	public function headofficeForgotPassword()
	{
		if ($this->session->isLoggedIn) {
			return redirect()->to('/head-office/dashboard');
		}

		return view($this->config->views['headoffice-forgot-password'], ['config' => $this->config]);
	}

    //--------------------------------------------------------------------

	public function branchAttemptForgotPassword()
	{
		// validate request
		if (! $this->validate(['email' => 'required|valid_email'])) {
            return redirect()->back()->with('error', lang('Auth.wrongEmail'));
        }

		// check if email exists in DB
		$branch = new BranchModel();
		$data = $branch->where('branch_email', $this->request->getPost('email'))->first();
		if (! $data) {
            return redirect()->back()->with('error', lang('Auth.wrongEmail'));
        }

        // check if email is already sent to prevent spam
        if (! empty($data['reset_expires']) && $data['reset_expires'] >= time()) {
			return redirect()->back()->with('error', lang('Auth.emailAlreadySent'));
        }

		// set reset hash and expiration
		helper('text');
		$updatedBranch['id'] = $data['id'];
		$updatedBranch['reset_hash'] = random_string('alnum', 32);
		$updatedBranch['reset_expires'] = time() + (MINUTE * 30);
		$branch->save($updatedBranch);
		// send password reset e-mail
		helper('auth');
        send_password_reset_email($this->request->getPost('email'), site_url('branch/reset-password?token=').$updatedBranch['reset_hash']);

        return redirect()->back()->with('success', lang('Auth.forgottenPasswordEmail'));
	}

	public function headofficeAttemptForgotPassword()
	{
		// validate request
		if (! $this->validate(['email' => 'required|valid_email'])) {
            return redirect()->back()->with('error', lang('Auth.wrongEmail'));
        }

		// check if email exists in DB
		$users = new UserModel();
		$data = $users->where('email', $this->request->getPost('email'))->first();
		if (! $data) {
            return redirect()->back()->with('error', lang('Auth.wrongEmail'));
        }

        // check if email is already sent to prevent spam
        if (! empty($data['reset_expires']) && $data['reset_expires'] >= time()) {
			return redirect()->back()->with('error', lang('Auth.emailAlreadySent'));
        }

		// set reset hash and expiration
		helper('text');
		$updatedUser['id'] = $data['id'];
		$updatedUser['reset_hash'] = random_string('alnum', 32);
		$updatedUser['reset_expires'] = time() + (MINUTE * 30);
		$users->save($updatedUser);
		// send password reset e-mail
		helper('auth');
        send_password_reset_email($this->request->getPost('email'), site_url('head-office/reset-password?token=').$updatedUser['reset_hash']);

        return redirect()->back()->with('success', lang('Auth.forgottenPasswordEmail'));
	}


    //--------------------------------------------------------------------

	public function branchResetPassword()
	{
		// check reset hash and expiration
		$branch = new BranchModel();
		$data = $branch->where('reset_hash', $this->request->getGet('token'))
			->where('reset_expires >', time())
			->first();

		if (!$data) {
            return redirect()->to('branch')->with('error', lang('Auth.invalidRequest'));
        }

		return view($this->config->views['branch-reset-password'], ['config' => $this->config]);
	}

	public function headofficeResetPassword()
	{
		// check reset hash and expiration
		$users = new UserModel();
		$data = $users->where('reset_hash', $this->request->getGet('token'))
			->where('reset_expires >', time())
			->first();

		if (!$data) {
            return redirect()->to('head-office')->with('error', lang('Auth.invalidRequest'));
        }

		return view($this->config->views['headoffice-reset-password'], ['config' => $this->config]);
	}

    //--------------------------------------------------------------------

	public function branchAttemptResetPassword()
	{
		// validate request
		$rules = [
			'token' => ['label' => 'Token', 'rules' => 'required'],
			'password' => ['label' => 'Password', 'rules' => 'required|passwordValidation[password]'],
			'password_confirm' => ['label' => 'Confirm Password', 'rules' => 'matches[password]'],
		];
		$errors = [
			'password' => [
				'required' => 'Password is required.',
				'passwordValidation' => 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.',
			]
		];
		if (! $this->validate($rules, $errors)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

		// check reset hash, expiration
		$branch = new BranchModel();
		$data = $branch->where('reset_hash', $this->request->getPost('token'))
			->where('reset_expires >', time())
			->first();

		if (!$data) {
            return redirect()->to('branch')->with('error', lang('Auth.invalidRequest'));
        }

		// update user password
        $updatedBranch['id'] = $data['id'];
        $updatedBranch['password'] =  password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        $updatedBranch['reset_hash'] = null;
        $updatedBranch['reset_expires'] = null;
        $branch->save($updatedBranch);

		// redirect to login
        return redirect()->to('branch')->with('success', lang('Auth.passwordUpdateSuccess'));
	}

	public function headofficeAttemptResetPassword()
	{
		// validate request
		$rules = [
			'token' => ['label' => 'Token', 'rules' => 'required'],
			'password' => ['label' => 'Password', 'rules' => 'required|passwordValidation[password]'],
			'password_confirm' => ['label' => 'Confirm Password', 'rules' => 'matches[password]'],
		];
		$errors = [
			'password' => [
				'required' => 'Password is required.',
				'passwordValidation' => 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.',
			]
		];
		if (! $this->validate($rules, $errors)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

		// check reset hash, expiration
		$users = new UserModel();
		$data = $users->where('reset_hash', $this->request->getPost('token'))
			->where('reset_expires >', time())
			->first();

		if (!$data) {
            return redirect()->to('head-office')->with('error', lang('Auth.invalidRequest'));
        }

		// update user password
        $updatedUsers['id'] = $data['id'];
        $updatedUsers['password_hash'] =  password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        $updatedUsers['reset_hash'] = null;
        $updatedUsers['reset_expires'] = null;
        $users->save($updatedUsers);

		// redirect to login
        return redirect()->to('head-office')->with('success', lang('Auth.passwordUpdateSuccess'));
	}

}
