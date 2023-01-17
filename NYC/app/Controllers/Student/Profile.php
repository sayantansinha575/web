<?php
namespace App\Controllers\Student;

use App\Models\Student\ProfileModel;


class Profile extends BaseController
{

    public function __construct()
    {
        $db = db_connect();
        $this->profile = new ProfileModel($db);
    }


    public function index()
    {
        $this->data['title'] = 'My Profile';
        $this->data['details'] = $this->profile->getProfileDetails($this->session->studData['id']);
        return  view('student/profile/my-profile', $this->data);    
    }
}
