<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(true);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

$routes->post('send-mail/branch-to-any', 'Mail::sendEmailFromBranch');

/*
 * --------------------------------------------------------------------
 * headoffice Route Definitions Begin
 * --------------------------------------------------------------------
 */
$routes->group("head-office", ["namespace" => "App\Controllers\Headoffice"], function ($routes) {
    $routes->get("dashboard", "Dashboard");
    #payment related
    $routes->get("payment", "Payment");
    $routes->post("ajax-dt-get-payment-list", "Payment::ajax_dt_get_payment_list");
    #authletter related
    $routes->get("auth-letter", "Authletter");
    $routes->get("generate-authletter", "Authletter::generate_authletter");
    $routes->get("generate-authletter/(:any)", "Authletter::generate_authletter/$1");
    $routes->post("generate-authletter", "Authletter::generate_authletter");
    $routes->get("auth-letter/(:any)", "Authletter/$1");
    $routes->post("auth-letter", "Authletter");
    $routes->post("delete-auth-letter", "Authletter::delete_auth_letter");
    $routes->post("ajax-dt-get-authletter-list", "Authletter::ajax_dt_get_authletter_list");
    #branch related
    $routes->get("branch", "Branch");
    $routes->post("ajax-dt-get-branch-list", "Branch::ajax_dt_get_branch_list");
    $routes->get("branch/delete-branch/(:num)", "Branch::atteptToDeleteBranch/$1");
    $routes->post("branch/add-branch/(:num)", "Branch::add_branch/$1");
    $routes->get("branch/edit-branch/(:num)", "Branch::add_branch/$1");
    $routes->get("branch/branch-details/(:num)", "Branch::details/$1");
    $routes->get("branch/get-countdown/(:num)", "Branch::get_countdown/$1");
    $routes->get("branch/change-status/(:num)/(:num)", "Branch::change_status/$1/$2");
    $routes->match(["get", "post"], "branch/add-branch", "Branch::add_branch");
    #uesrs related
    $routes->post("users/change-password/(:num)", "Users::change_password/$1");
    $routes->post("student/cv/save-cv", "Users::save_cv");
    #course related
    $routes->get("course", "Course");
    $routes->match(["get", "post"], "course/set-marksheet-fields/(:num)", "Course::set_marksheet_fields/$1");
    $routes->post("course/add-course/(:num)", "Course::add_course/$1");
    $routes->match(["get", "post"], "course/add-course", "Course::add_course");
    $routes->get("course/edit-course/(:num)", "Course::add_course/$1");
    $routes->get("course/change-status/(:num)/(:num)", "Course::change_status/$1/$2");
    #student related
    $routes->get("student", "Student");
    $routes->get("student/manage-admission", "Student::manage_admission");
    $routes->post("ajax-dt-get-student-list", "Student::ajax_dt_get_student_list");
    $routes->get("student/student-details/(:num)", "Student::details/$1");
    $routes->get("student/change-status/(:num)/(:num)", "Student::change_status/$1/$2");
    $routes->get("student/delete-student/(:num)", "Student::delete_student/$1");
    $routes->post("ajax-dt-get-admission-list", "Student::ajax_dt_get_admission_list");
    #wallet related
    $routes->get("wallet", "Wallet");
    $routes->match(["get", "post"], "wallet/add-transaction", "Wallet::add_transaction");
    $routes->post('wallet/ajax-dt-get-wallet-list', 'Wallet::ajax_dt_get_wallet_list');
    #marksheet related
    $routes->get("marksheet", "Marksheet");
    $routes->post("marksheet/ajax-dt-get-marksheet-list", "Marksheet::ajax_dt_get_marksheet_list");
    $routes->get("marksheet/marksheet-details/(:num)", "Marksheet::marksheet_details/$1");
    $routes->get("marksheet/chnage-status/(:any)/(:num)", "Marksheet::change_status/$1/$2");
    #certificate related
    $routes->get("certificate", "Certificate");
    $routes->post("certificate/ajax-dt-get-certificate-list", "Certificate::ajax_dt_get_certificate_list");
    $routes->get("certificate/certificate-details/(:num)", "Certificate::certificate_details/$1");
    $routes->get("certificate/chnage-status/(:any)/(:num)", "Certificate::change_status/$1/$2");
    #admit related
    $routes->get("admit", "Admit");
    $routes->get("admit/admit-details/(:num)", "Admit::admit_details/$1");
    $routes->post("admit/ajax-dt-get-admit-list", "Admit::ajax_dt_get_admit_list");
    $routes->post("admit/delete-admit", "Admit::deleteAdmit");
    $routes->match(["get", "post"], "admit/edit-admit/(:num)", "Admit::edit_admit/$1");
    #document Related
    $routes->get("document/study-materials", "Document");
    $routes->get("document/branch-document", "Document::branch_document");
    $routes->match(["get", "post"], "document/add-study-material", "Document::add_study_material");
    $routes->match(["get", "post"], "document/add-branch-document", "Document::add_branch_document");
    $routes->match(["get", "post"], "document/add-branch-document/(:num)", "Document::add_branch_document/$1");
    $routes->post("document/ajax-get-course-by-type", "Document::ajax_get_course_by_type");
    $routes->post("document/ajax-get-document-details-by-course", "Document::ajax_get_document_details_course");
    $routes->post("document/delete-study-material", "Document::delete_study_material");
    $routes->post("document/delete-study-material-section", "Document::delete_study_material_section");
    $routes->post("document/delete-bulk-branch-docs", "Document::delete_bulk_branch_docs");
    $routes->post("document/ajax-dt-get-study-materials-list", "Document::ajax_dt_get_study_material_list");
    $routes->post("document/ajax-dt-get-branch-doc-list", "Document::ajax_dt_get_branch_doc_list");
    $routes->get("document/details/(:num)", "Document::doc_details/$1");
    $routes->match(["get", "post"], "document/edit-files/(:num)/(:num)", "Document::edit_files/$1/$2");
    $routes->match(["get", "post"], "document/add-files/(:num)", "Document::add_files/$1");
    #settings related
    $routes->get("setting", "Setting");
    $routes->post("setting/update-setting/(:any)", "Setting::update_setting/$1");
    $routes->get("setting/certificate-marksheet-setting", "Setting::certificate_marksheet_setting");
    $routes->get("setting/media-setting", "Setting::media_setting");
    $routes->get("setting/meta-tags-setting", "Setting::meta_tags_setting");
    #print pdf related
    $routes->get("print-pdf", "Prints");
    $routes->get("branch/delete-combined-pdf/(:num)", "Prints::delete_combined_pdf/$1");
    $routes->post("print/generate", "Prints::generate");
    $routes->post("prints/ajax-dt-get-combined-pdf-list", "Prints::ajax_dt_get_combined_pdf_list");

    #Exam Module
    $routes->get("exam", "Exam::set_exam_paper"); 
    $routes->get("exam/(:num)", "Exam::set_exam_paper/$1");
    $routes->get("exam/(:num)/(:num)", "Exam::set_exam_paper/$1/$2");
    $routes->post("exam/save-exam", "Exam::save_exam");
    $routes->get("exam", "Exam::examList");
    $routes->post("exam/delete-paper", "Exam::delete_exam_paper");
    $routes->get("exam/change-status/(:num)/(:num)", "Exam::change_status/$1/$2");

 

}); 



/*
 * --------------------------------------------------------------------
 * headoffice Route Definitions End
 * --------------------------------------------------------------------
 */


 /*
 * --------------------------------------------------------------------
 * Branch Route Definitions Begin
 * --------------------------------------------------------------------
 */
$routes->group("branch", ["namespace" => "App\Controllers\Branch"], function ($routes) {
    $routes->get("dashboard", "Dashboard");
    $routes->get("get-countdown", "Branch::get_count_down");
    $routes->get("student", "Student");
    $routes->get("branch-details", "Branch::branch_details");
    $routes->match(["get", "post"], "ammend-branch-details", "Branch::ammend_branch_details");
    $routes->match(["get", "post"], "student/enroll", "Student::enroll");
    
});

$routes->group("employer", ["namespace" => "App\Controllers\Employer"], function ($routes) {
    $routes->get("student-lists",  "Employer::student_lists");
    $routes->post("student-lists/ajax-dt-get-student-list", "Employer::ajax_dt_get_student_list");
});
/*
 * --------------------------------------------------------------------
 * Branch Route Definitions End
 * --------------------------------------------------------------------
 */

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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
