<?php
namespace App\Controllers;
use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function dashboard()
    {
        if ($this->request->getMethod() == 'get' && ! $this->request->isAJAX()) {
            $this->data['title'] = 'Dasbboard';
            return view('dashboard/dashboard', $this->data);
        }
    }
}