<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Auth');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Auth', ['as' => 'login']);
$routes->get('sign-out', 'Auth::signOut', ['as' => 'logout']);
$routes->post('login', 'Auth::attempToLogin');
$routes->get('password-reset', 'Auth::resetPassword');
$routes->post('password-reset-verification', 'Auth::resetVerification');
$routes->post('password-reset', 'Auth::attemptToResetPassword');

$routes->get('dashboard', 'Dashboard::dashboard');


// Application
$routes->get('search-student', 'Application::searchStudent');
$routes->get('new-application', 'Application::newApplication');
$routes->get('new-application/(:any)', 'Application::newApplication/$1');



$routes->group("auth", ["namespace" => "App\Controllers"], function ($routes) {
    $routes->get('groups-and-permissions', 'Auth::groupsNPermissions');
    $routes->post('save-groups-n-permissions', 'Auth::attemptToSaveGroupsPermissions');
    $routes->post('get-groups-n-permissions-dt', 'Auth::ajaxGetGroupsPermissionsDt');
    $routes->post('get-groups-n-permissions-details', 'Auth::ajaxGetGroupsPermissionsDetails');
    $routes->post('delete-groups-n-permissions', 'Auth::attemptToDeleteGroupPermissions');
    $routes->post('change-groups-n-permissions-status', 'Auth::attemptToChangeStatusGroupPermissions');
});


$routes->group("master", ["namespace" => "App\Controllers"], function ($routes) {
    $routes->get('type-of-degree', 'Master::typeOfDegree');
    $routes->post('save-type-of-degree', 'Master::attemptToSaveTypeOfDegree');
    $routes->post('get-type-of-degree-dt', 'Master::ajaxGetTypeOfDegreeDt');
    $routes->post('get-type-of-degree-details', 'Master::ajaxGetTypeOfDegreeDetails');
    $routes->post('delete-type-of-degree', 'Master::attemptToDeleteTypeOfDegree');
    $routes->post('change-type-of-degree-status', 'Master::attemptToChangeStatusTypeOfDegree');

    $routes->get('university-programs', 'Master::universityPrograms');
    $routes->post('save-university-programs', 'Master::attemptToSaveUniversityPrograms');
    $routes->post('get-university-programs-dt', 'Master::ajaxGetUniversityProgramsDt');
    $routes->post('get-university-programs-details', 'Master::ajaxGetUniversityProgramsDetails');
    $routes->post('delete-university-programs', 'Master::attemptToDeleteUniversityPrograms');
    $routes->post('change-university-programs-status', 'Master::attemptToChangeStatusUniversityPrograms');

    $routes->get('intake', 'Master::intake');
    $routes->post('save-intake', 'Master::attemptToSaveIntake');
    $routes->post('get-intake-dt', 'Master::ajaxGetIntakeDt');
    $routes->post('get-intake-details', 'Master::ajaxGetIntakeDetails');
    $routes->post('delete-intake', 'Master::attemptToDeleteIntake');
    $routes->post('change-intake-status', 'Master::attemptToChangeStatusIntake');

    $routes->get('status', 'Master::status');
    $routes->post('save-status', 'Master::attemptToSaveStatus');
    $routes->post('get-status-dt', 'Master::ajaxGetStatusDt');
    $routes->post('get-status-details', 'Master::ajaxGetStatusDetails');
    $routes->post('delete-status', 'Master::attemptToDeleteStatus');
    $routes->post('change-status-status', 'Master::attemptToChangeStatusStatus');

    $routes->get('search-tags', 'Master::search');
    $routes->post('save-search', 'Master::attemptToSaveSearch');
    $routes->post('get-search-dt', 'Master::ajaxGetSearchDt');
    $routes->post('get-search-details', 'Master::ajaxGetSearchDetails');
    $routes->post('delete-search', 'Master::attemptToDeleteSearch');
    $routes->post('change-search-status', 'Master::attemptToChangeStatusSearch');

    $routes->get('type-of-exam', 'Master::typeOfExam');
    $routes->post('save-type-of-exam', 'Master::attemptToSaveTypeOfExam');
    $routes->post('get-type-of-exam-dt', 'Master::ajaxGetTypeOfExamDt');
    $routes->post('get-type-of-exam-details', 'Master::ajaxGetTypeOfExamDetails');
    $routes->post('delete-type-of-exam', 'Master::attemptToDeleteTypeOfExam');
    $routes->post('change-type-of-exam-status', 'Master::attemptToChangeStatusTypeOfExam');

    $routes->get('test-type', 'Master::testType');
    $routes->post('save-test-type', 'Master::attemptToSaveTestType');
    $routes->post('get-test-type-dt', 'Master::ajaxGetTestTypeDt');
    $routes->post('get-test-type-details', 'Master::ajaxGetTestTypeDetails');
    $routes->post('delete-test-type', 'Master::attemptToDeleteTestType');
    $routes->post('change-test-type-status', 'Master::attemptToChangeStatusTestType');

    $routes->get('document-type', 'Master::documentType');
    $routes->post('save-document-type', 'Master::attemptToSavedocumentType');
    $routes->post('get-document-type-dt', 'Master::ajaxGetdocumentTypeDt');
    $routes->post('get-document-type-details', 'Master::ajaxGetdocumentTypeDetails');
    $routes->post('delete-document-type', 'Master::attemptToDeletedocumentType');
    $routes->post('change-document-type-status', 'Master::attemptToChangeStatusdocumentType');
});

$routes->group("associate", ["namespace" => "App\Controllers"], function ($routes) {
    $routes->get('list', 'Associate::associateList');
    $routes->get('edit/(:num)', 'Associate::editAssociate/$1');
    $routes->post('save-associate', 'Associate::attemptToSaveAssociate');
    $routes->post('update-password', 'Associate::attemptToUdateAssociatePassword');
    $routes->post('get-associate-dt', 'Associate::ajaxGetAssociateDt');
    // $routes->post('get-associate-details', 'Associate::ajaxGetAssociateDetails');
    $routes->post('delete-associate', 'Associate::attemptToDeleteAssociate');
    $routes->post('change-associate-type-status', 'Associate::attemptToChangeStatusAssociate');
    $routes->post('save-bank-details', 'Associate::attemptToSaveAssociateBankDetails');
    $routes->get('Bank-details-list', 'Associate::getBankDetails');
});


$routes->group("university", ["namespace" => "App\Controllers"], function ($routes) {
    $routes->get('list', 'University::universityList');
    $routes->post('university-list-dt', 'University::ajaxGetUniverSityDt');   
    $routes->post('save-university', 'University::saveUnivercity');
    $routes->post('delete-university-dt', 'University::deleteUniversity');
    $routes->get('edit-university-info/(:num)', 'University::editUniversity/$1');
    $routes->post('update-university', 'University::UpdateUniversity');
    $routes->get('edit-university-general-info/(:num)', 'University::editgeneralInfo/$1');
    $routes->post('update-university-general-info', 'University::UpdateUniversityGeneralInfo');
    $routes->get('edit-university-contact-info/(:num)', 'University::UniversityContactInfo/$1');
    $routes->post('save-university-contact', 'University::saveUniversityContact');



});
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
