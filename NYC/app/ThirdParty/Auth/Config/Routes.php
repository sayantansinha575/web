<?php

$routes->group('', ['namespace' => 'Auth\Controllers'], function($routes) {
	// Registration
    // $routes->get('register', 'RegistrationController::register', ['as' => 'register']);
    // $routes->post('register', 'RegistrationController::attemptRegister');

    // Activation
    // $routes->get('activate-account', 'RegistrationController::activateAccount', ['as' => 'activate-account']);

    // headoffice Login/out
    $routes->get('head-office', 'LoginController::login', ['as' => 'login']);
    $routes->post('head-office', 'LoginController::attemptLogin');
    $routes->get('logout', 'LoginController::logout');

    // branch Login/out
    $routes->get('branch', 'LoginController::branch_login', ['as' => 'branch_login']);
    $routes->post('branch', 'LoginController::attemptBranchLogin');
    $routes->get('branch-signout', 'LoginController::branch_logout');

    //branch Login/out
    $routes->post('student', 'LoginController::attemptStudentLogin');
    $routes->get('student-signout', 'LoginController::student_logout');


    // Forgotten password and reset
    $routes->get('forgot-password', 'PasswordController::student_forgot_password');
    $routes->post('forgot-password', 'PasswordController::attemptForgotPassword');

    $routes->get('branch/forgot-password', 'PasswordController::branchForgotPassword');
    $routes->post('branch/forgot-password', 'PasswordController::branchAttemptForgotPassword');
    $routes->get('branch/reset-password', 'PasswordController::branchResetPassword');
    $routes->post('branch/reset-password', 'PasswordController::branchAttemptResetPassword');

    $routes->get('head-office/forgot-password', 'PasswordController::headofficeForgotPassword');
    $routes->post('head-office/forgot-password', 'PasswordController::headofficeAttemptForgotPassword');
    $routes->get('head-office/reset-password', 'PasswordController::headofficeResetPassword');
    $routes->post('head-office/reset-password', 'PasswordController::headofficeAttemptResetPassword');

     $routes->get('employer', 'EmployerController::home');
     $routes->post('employer/save-employe', 'EmployerController::register');
     $routes->get('employer-signIn', 'EmployerController::empLogin');
     $routes->post('save-login', 'EmployerController::attemptEmpLogin');





    // Account settings
    // $routes->get('account', 'AccountController::account', ['as' => 'account']);
    // $routes->post('account', 'AccountController::updateAccount');
    // $routes->post('change-email', 'AccountController::changeEmail');
    // $routes->get('confirm-email', 'AccountController::confirmNewEmail');
    // $routes->post('change-password', 'AccountController::changePassword');
    // $routes->post('delete-account', 'AccountController::deleteAccount');
});
