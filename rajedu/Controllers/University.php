<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\University_model;


class University extends BaseController
{

    public function __construct()
    {
        $db = db_connect();
        $this->unversity = new University_model($db);
    }


    function universityList()
    {
        if (session()->isLoggedIn && $this->request->getMethod() == 'get' && !$this->request->isAJAX()) {
            $this->data['title'] = 'Universities - ' . setting('App.siteName');
            return view('university/university-list', $this->data);
        } else {
            return redirect()->route('dashboard');
        }
    }

    function saveUnivercity()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            $rules = [
                'university_name'                    => ['label' => 'Univercity Name ', 'rules' => 'required'],
                'country'                            => ['label' => 'Country', 'rules' => 'required'],
                'state'                              => ['label' => 'State ', 'rules' => 'required'],
                'city'                               => ['label' => 'City', 'rules' => 'required'],
                'address'                            => ['label' => 'Address', 'rules' => 'required'],
                'intake'                             => ['label' => 'Intake', 'rules' => 'required'],
                'date_of_establishment'              => ['label' => 'Year of Establishment', 'rules' => 'required'],
                'university_logo'                    => ['label' => 'Upload Logo', 'rules' => 'ext_in[university_logo,png,jpg,jpeg]|max_size[university_logo,2048]'],

            ];

            $errors = [];
            if ($this->validate($rules, $errors)) {

                $data = array(
                    'university_name'              => trim($this->request->getPost('university_name')),
                    'country'                      => trim($this->request->getPost('country')),
                    'state'                         => trim($this->request->getPost('state')),
                    'city'                          =>  trim($this->request->getPost('city')),
                    'address'                        => trim($this->request->getPost('address')),
                    'intake'                        => trim($this->request->getPost('intake')),
                    'region'                        => trim($this->request->getPost('region')),
                    'total_students'                => trim($this->request->getPost('total_students')),
                    'under_graduate'                 => trim($this->request->getPost('under_graduate')),
                    'graduate'                        => trim($this->request->getPost('graduate')),
                    'date_of_establishment'        => strtotime($this->request->getPost('date_of_establishment')),
                    'created_at'                           => time(),
                );

                #INIT SCRIPT OF UPLOAD
                $logo = $this->request->getFile('university_logo');
                if ($logo->isValid()) {
                    $logoArr = upload('university_logo', UPLOAD_PATH.'university/logo/');
                    $data['university_logo'] = $logoArr['encryptedName'];
                }
                #ENDS


                if ($lastId = $this->crud->add('universities', $data)){

                    $this->data['success'] = true;
                    $this->data['message'] = 'Universities has been successfully added.';
                    return $this->response->setJSON($this->data);
                } else {
                    $this->data['message'] = 'Something went wrong.';
                    return $this->response->setJSON($this->data);
                }

            } else {
                $this->data['errors'] = $this->validation->getErrors();
                return $this->response->setJSON($this->data);
            }
        } else {
            $this->data['message'] = 'Access Denied.';
            return $this->response->setJSON($this->data);
        }
    }

    function ajaxGetUniverSityDt()
    {
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            $response = array();
            $where = '';
            ## Read value
            $draw = $this->request->getPost('draw');
            $start = $this->request->getPost('start');
            $rowperpage = $this->request->getPost('length'); 
            $columnIndex =  $this->request->getPost('order')[0]['column'];
            $columnName =  $this->request->getPost('columns')[$columnIndex]['data'];
            $columnSortOrder =  $this->request->getPost('order')[0]['dir'];
            $keyword = $this->request->getPost('search')['value'];
            switch ($columnName) {
                case 'id':
                $columnName = 'universities.id';
                break;
                case 'university_name':
                $columnName = 'university_name.university_name';
                break;
                case 'country':
                $columnName = 'country.country';
                break;
                case 'state';
                $columnName = 'state.state';
                break;
                case 'address';
                $columnName = 'address.address';
                break;
                case 'intake';
                $columnName = 'intake.intake';
                break;
                case 'date_of_establishment';
                $columnName = 'date_of_establishment.date_of_establishment';
                break;
                default:
                $columnName = 'universities.id';
                break;
            }

            $totalRecords = $totalRecordwithFilter = $this->dt->ajaxUniversityDt(1);

            
            if (! empty($keyword)) {
                $where .= empty($where)?"(master_data.title LIKE '%$keyword%' ESCAPE '!')":" AND (master_data.title LIKE '%$keyword%' ESCAPE '!')";
            }

            if (! empty($where)) {
                $totalRecordwithFilter = $this->dt->ajaxUniversityDt(1, '', '', $where);
            }

            $records = $this->dt->ajaxUniversityDt(0, $rowperpage, $start, $where, $columnSortOrder, $columnName);
            $data = array();
            
            foreach($records as $record ){
                $actions = $subAction = '';
                $subAction .= '<a href="' . site_url('university/edit-university-info/' . $record['id']) . '" class="dropdown-item"><i class="ft-edit-2 success"></i> Edit</a>';
                $subAction .= '<a href="javascript:void(0)" data-id="'. $record['id'] .'" class="dropdown-item delete-row"><i class="ft-trash-2 danger"></i> Delete</a>';

                $actions = '<span class="dropdown">
                <button id="btnSearchDrop12" type="button" class="btn btn-sm btn-icon btn-pure font-medium-2" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                <i class="ft-more-vertical"></i>
                </button>
                <span aria-labelledby="btnSearchDrop12" class="dropdown-menu mt-1 dropdown-menu-right">
                '. $subAction .'
                </span>
                </span>';



                $data[] = array( 
                    "id" => $record['id'],
                    "university_name" => $record['university_name'],
                    "country" => $record['country'],
                    "state" => $record['state'],
                    "address" => $record['address'],
                    "intake" => $record['intake'],
                    "date_of_establishment" => $record['date_of_establishment'],
                    "action" => $actions,
                );
            }
            ## Response
            $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecordwithFilter,
                "aaData" => $data,
                'hash' => csrf_hash(),
            );
            return $this->response->setJSON($response);
        }
    }


    function deleteUniversity()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        $ids = [];
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            foreach ($this->request->getPost('ids') as $id) {
                if (!empty($id)) {
                    $this->crud->deleteData('universities', ['id' => $id]);
                }
            }
            $this->data['success'] = true;
            $this->data['message'] = 'Universities has been succesfully deleted.';
            return $this->response->setJSON($this->data);
        } else {
            $this->data['message'] = 'Something went wrong!';
            return $this->response->setJSON($this->data);
        }
    }


    function editUniversity($id = 0)
    {
        if (session()->isLoggedIn && $this->request->getMethod() == 'get' && !$this->request->isAJAX()) {
            if (!empty($id) && !empty($details = $this->unversity->getUnviersityDataById($id))) {
                $this->data['title'] = 'Edit University';
                $this->data['result'] = $details;
                $this->data['content'] = view('university/edit/university-info', $this->data);
                return view('university/edit-university', $this->data);
            } else {
                return redirect()->route('dashboard');
            }
        } else {
            return redirect()->route('dashboard');
        }
    }


    function editgeneralInfo($id = 0)
    {
        if (session()->isLoggedIn && $this->request->getMethod() == 'get' && !$this->request->isAJAX()) {
            if (!empty($id) && !empty($details = $this->unversity->getUnviersityDataById($id))) {
                $this->data['title'] = 'Edit University General Info';
                $this->data['result'] = $details;
                $this->data['content'] = view('university/edit/university-general-info', $this->data);
                return view('university/edit-university', $this->data);
            } else {
                return redirect()->route('dashboard');
            }
        } else {
            return redirect()->route('dashboard');
        }
    }

    function UniversityContactInfo($id = 0)
    {
        if (session()->isLoggedIn && $this->request->getMethod() == 'get' && !$this->request->isAJAX()) {
            if (!empty($id) && !empty($details = $this->unversity->getUnviersityDataById($id))) {
                $this->data['title'] = 'Edit University Contact Info';
                $this->data['result'] = $details;
                $this->data['content'] = view('university/edit/university-contact-info', $this->data);
                return view('university/edit-university', $this->data);
            } else {
                return redirect()->route('dashboard');
            }
            
        } else {    
            return redirect()->route('dashboard');
        }
    }


    function UpdateUniversity()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            $rules = [
                'university_name'          => ['label' => 'Univercity Name ', 'rules' => 'required'],
                'country'                  => ['label' => 'Country', 'rules' => 'required'],
                'state'                    => ['label' => 'State ', 'rules' => 'required'],
                'city'                     => ['label' => 'City', 'rules' => 'required'],
                'address'                  => ['label' => 'Address', 'rules' => 'required'],
                'intake'                   => ['label' => 'Intake', 'rules' => 'required'],
                'date_of_establishment'    => ['label' => 'Year of Establishment', 'rules' => 'required'],
                'university_logo'          => ['label' => 'Upload Logo', 'rules' => 'ext_in[university_logo,png,jpg,jpeg]|max_size[university_logo,2048]'],

            ];

            $errors = [];
            if ($this->validate($rules, $errors)) {

                $data = array(
                    'university_name'               => trim($this->request->getPost('university_name')),
                    'country'                       => trim($this->request->getPost('country')),
                    'state'                         => trim($this->request->getPost('state')),
                    'city'                          =>  trim($this->request->getPost('city')),
                    'address'                       => trim($this->request->getPost('address')),
                    'intake'                        => trim($this->request->getPost('intake')),
                    'region'                        => trim($this->request->getPost('region')),
                    'total_students'                => trim($this->request->getPost('total_students')),
                    'under_graduate'                => trim($this->request->getPost('under_graduate')),
                    'graduate'                      => trim($this->request->getPost('graduate')),
                    'date_of_establishment'         => strtotime($this->request->getPost('date_of_establishment')),
                    'updated_at'                    => time(),
                );

                #INIT SCRIPT OF UPLOAD
                $logo = $this->request->getFile('university_logo');
                if ($logo->isValid()) {
                    $logoArr = upload('university_logo', UPLOAD_PATH.'university/logo/');
                    $data['university_logo'] = $logoArr['encryptedName'];
                }
                #ENDS


                if ($lastId = $this->crud->updateData('universities', ['id' => $this->request->getPost('id')], $data)){

                    $this->data['success'] = true;
                    $this->data['message'] = 'Universities has been successfully updated.';
                    $this->data['redirect'] = site_url('university/edit-university-general-info/'.$this->request->getPost('id'));
                    return $this->response->setJSON($this->data);
                } else {
                    $this->data['message'] = 'Something went wrong.';
                    return $this->response->setJSON($this->data);
                }

            } else {
                $this->data['errors'] = $this->validation->getErrors();
                return $this->response->setJSON($this->data);
            }
        } else {
            $this->data['message'] = 'Access Denied.';
            return $this->response->setJSON($this->data);
        }
    }


    function UpdateUniversityGeneralInfo()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            $rules = [
                'about_university'               => ['label' => 'About University', 'rules' => 'required'],
                'app_procedure'                  => ['label' => 'App Procedure', 'rules' => 'required'],
                'follow_up_procedure'            => ['label' => 'Follow up Procedure  ', 'rules' => 'required'],
                'deferment_procedure'            => ['label' => 'Deferment Procedure', 'rules' => 'required'],
            ];

            $errors = [];
            if ($this->validate($rules, $errors)) {

                $data = array(
                    'about_university'              => trim($this->request->getPost('about_university')),
                    'app_procedure'                 => trim($this->request->getPost('app_procedure')),
                    'follow_up_procedure'           => trim($this->request->getPost('follow_up_procedure')),
                    'deferment_procedure'           =>  trim($this->request->getPost('deferment_procedure')),          
                    'updated_at'                    => time(),
                );

                if ($lastId = $this->crud->updateData('universities', ['id' => $this->request->getPost('id')], $data)){

                    $this->data['success'] = true;
                    $this->data['message'] = 'Universities General Info has been successfully updated.';
                    $this->data['redirect'] = site_url('university/edit-university-contact-info/'.$this->request->getPost('id'));
                    return $this->response->setJSON($this->data);
                } else {
                    $this->data['message'] = 'Something went wrong.';
                    return $this->response->setJSON($this->data);
                }

            } else {
                $this->data['errors'] = $this->validation->getErrors();
                return $this->response->setJSON($this->data);
            }
        } else {
            $this->data['message'] = 'Access Denied.';
            return $this->response->setJSON($this->data);
        }
    }

    function saveUniversityContact()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            $rules = [
                'type_of_contact'                    => ['label' => 'Type of Contact ', 'rules' => 'required'],
                'name'                               => ['label' => 'Name', 'rules' => 'required'],
                'designation'                        => ['label' => 'Designation ', 'rules' => 'required'],
                'email'                              => ['label' => 'Email', 'rules' => 'required'],
                'contact'                            => ['label' => 'Contact', 'rules' => 'required'],
                             
            ];

            $errors = [];
            if ($this->validate($rules, $errors)) {

                $data = array(
                    'university_id'                => trim($this->request->getPost('id')),
                    'type_of_contact'              => trim($this->request->getPost('type_of_contact')),
                    'name'                         => trim($this->request->getPost('name')),
                    'designation'                  => trim($this->request->getPost('designation')),
                    'email'                        => trim($this->request->getPost('email')),
                    'contact'                      => trim($this->request->getPost('contact')),
                    'alternative_contact'          => trim($this->request->getPost('alternative_contact')),
                    'created_at'                   => time(),
                );

                if ($lastId = $this->crud->add('university_contacts', $data)){

                    $this->data['success'] = true;
                    $this->data['message'] = 'Universities Contact has been successfully added.';
                    return $this->response->setJSON($this->data);
                } else {
                    $this->data['message'] = 'Something went wrong.';
                    return $this->response->setJSON($this->data);
                }

            } else {
                $this->data['errors'] = $this->validation->getErrors();
                return $this->response->setJSON($this->data);
            }
        } else {
            $this->data['message'] = 'Access Denied.';
            return $this->response->setJSON($this->data);
        }
    }

    
    function saveUniversityDocCheckList()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            $rules = [
                'level_of_degree'           => ['label' => 'Level of degree', 'rules' => 'required'],
                'document_name'             => ['label' => 'Document name', 'rules' => 'required'],
                'mandatory'                 => ['label' => 'Mandatory', 'rules' => 'required'],
            ];

            $errors = [];
            if ($this->validate($rules, $errors)) {

                $data = array(
                    'level_of_degree'       => implode(',', $this->request->getPost('level_of_degree')),
                    'document_name'         => implode(',', $this->request->getPost('document_name')),
                    'mandatory'             => $this->request->getPost('mandatory'),
                );

                if (! empty($subId = decrypt($this->request->getPost('sub_id')))) {
                    $data['updated_at'] = time();
                    if ($lastId = $this->crud->updateData('university_document_checklist', ['university_id' => decrypt($this->request->getPost('id')), 'id' => $subId] , $data)){
                        $this->data['success'] = true;
                        $this->data['message'] = 'University document checklist data has been successfully updated.';
                        return $this->response->setJSON($this->data);
                    } else {
                        $this->data['message'] = 'Something went wrong.';
                        return $this->response->setJSON($this->data);
                    }
                } else {
                   $data['university_id'] = trim(decrypt($this->request->getPost('id')));
                   $data['added_by'] = session()->userData['id'];
                   $data['created_at'] = time();
                    if ($lastId = $this->crud->add('university_document_checklist', $data)){
                        $this->data['success'] = true;
                        $this->data['message'] = 'University document checklist has been successfully added.';
                        return $this->response->setJSON($this->data);
                    } else {
                        $this->data['message'] = 'Something went wrong.';
                        return $this->response->setJSON($this->data);
                    }
                }
            } else {
                $this->data['errors'] = $this->validation->getErrors();
                return $this->response->setJSON($this->data);
            }
        } else {
            $this->data['message'] = 'Access Denied.';
            return $this->response->setJSON($this->data);
        }
    }

    
}
