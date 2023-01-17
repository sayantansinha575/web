<?php

namespace App\Controllers\Branch;

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
        if (!$this->session->isBranchLoggedIn) {
            return redirect()->to('branch');
        }
        $this->data['title'] = 'Branch Dashboard';
        return  view('branch/dashboard/dashboard', $this->data);    
    }
}
