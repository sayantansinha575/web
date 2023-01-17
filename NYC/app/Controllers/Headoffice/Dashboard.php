<?php

namespace App\Controllers\Headoffice;

use Config\Services;

class Dashboard extends BaseController
{

    /**
     * Access to current session.
     *
     * @var \CodeIgniter\Session\Session
     */
    protected $session;

    public function __construct()
    {
        // start session
        $this->session = Services::session();
    }


    public function index()
    {
        if (!$this->session->isLoggedIn) {
            return redirect()->to('head-office');
        }
        $this->data['title'] = 'dashboard';
        return  view('headoffice/dashboard/dashboard', $this->data);    
    }
}
