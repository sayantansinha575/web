<?php

namespace App\Controllers;
use Config\Email;
use Config\Services;



class Home extends BaseController
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

    public function __construct()
    {
        $this->session = Services::session();
        $this->config = config('Auth');
    }

    public function index()
    {
        if ($this->session->isStudLoggedIn) {
            return redirect()->to('student/dashboard');
        }
        return view($this->config->views['student-login'], ['config' => $this->config]);
    }
}
