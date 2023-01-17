<?php
namespace App\Controllers;

use App\Models\Crud_model;



class Mail extends BaseController
{
    public function __construct()
    {
        $db = db_connect();
        $this->request = \Config\Services::request();
        $this->session = \Config\Services::session();
        $this->crud = new Crud_model($db);
        //load helper
        helper(array('custom', 'mail'));
    }

    public function sendEmailFromBranch()
    {
        $rules = [
            'recipient' => ['rules' => 'required|valid_emails'],
            'subject' => ['rules' => 'required'],
            'body' => ['rules' => 'stripTag[body]|required'],
        ];
        $errors = [
            'subject' => [
                'required' => 'The subject field can\'t be blank.',
            ],
            'recipient' => [
                'required' => 'The recipient field can\'t be blank.',
                'valid_emails' => 'The recipient field must contain all valid email addresses.'
            ],
            'body' => [
                'required' => 'The body field can\'t be blank.',
                'stripTag' => 'The body field can\'t be blank.',
            ],
        ];
        if (!$this->validate($rules, $errors)) {
            return redirect()->back()->withInput();
        }

        $data = array(
            'recipients' => $this->request->getPost('recipient'),
            'body' => $this->request->getPost('body'),
            'from' => $this->session->branchData['branch_email'],
            'subject' => $this->request->getPost('subject'),
        );


        if (sendAttemptMailFromBranch($data)) {
            $this->session->setFlashdata('message', 'Mail has been sucessfully sent.');
            $this->session->setFlashdata('message_type', 'success');
            return redirect()->back();
        } else {
            $this->session->setFlashdata('message', 'Something went wrong, could\'t sent mail.');
            $this->session->setFlashdata('message_type', 'error');
            return redirect()->back();
        }
    }
}