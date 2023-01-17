<?php

namespace App\Controllers\Student;

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
        $this->data['title'] = 'dashboard';
        $this->data['breadcrumb'] = '<li class="breadcrumb-item">
        <span>Home</span>
        </li>
        <li class="breadcrumb-item active"><span>Dashboard</span></li>';
        return  view('student/dashboard/dashboard', $this->data);    
    }
}
