<?php

namespace App\Controllers;
use Config\Email;
use Config\Services;



class Common extends BaseController
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
        helper('custom');
    }

    public function encrypt_data()
    {
        $string = $_POST['string'];
        $this->data['success'] = true;
        $this->data['data'] = encrypt($string);
        echo json_encode($this->data); die;
    }
}
