<?php
namespace Auth\Config;

use CodeIgniter\Config\BaseConfig;

class Auth extends BaseConfig
{
	//--------------------------------------------------------------------
    // Views used by Auth Controllers
    //--------------------------------------------------------------------

    public $views = [
        'login' => 'Auth\Views\login',
        'branch-login' => 'Auth\Views\branch-login',
        'student-login' => 'Auth\Views\student-login',
        'student-forgot-password' => 'Auth\Views\student-forgot',
        'branch-forgot-password' => 'Auth\Views\branch-forgot',
        'branch-reset-password' => 'Auth\Views\branch-reset',
        'headoffice-forgot-password' => 'Auth\Views\headoffice-forgot',
        'headoffice-reset-password' => 'Auth\Views\headoffice-reset',
        'employer' => 'Auth\Views\register',
        'employer-signIn' => 'Auth\Views\emp-login',
    ];

    // Layout for the views to extend
    public $viewLayout = 'Auth\Views\layout';
}
