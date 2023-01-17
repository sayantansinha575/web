<?php

if (! function_exists('sendMailFromBranch'))
{
    function sendAttemptMailFromBranch($data = array())
    {
        $dataArr['body'] = $data['body'];
        $htmlMessage = view('template/mail/branch-dashboard', $dataArr);

        $email = \Config\Services::email();
        $email->initialize([
            'mailType' => 'html'
        ]);
        $email->setFrom($data['from'], 'NYCTA');
        $email->setTo($data['recipients']);
        $email->setSubject($data['subject']);
        $email->setMessage($htmlMessage);

       return $email->send();

    }
}