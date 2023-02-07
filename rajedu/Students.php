<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\QualificationModel;
use App\Models\ProgramsModel;
use App\Models\ApplicationsModel;
use App\Models\CommentsModel;
class Students extends BaseController
{

    public function __construct()
    {
        $db = db_connect();
        $this->qualfication = new QualificationModel();
        $this->program = new ProgramsModel();
        $this->application = new ApplicationsModel();
        $this->comment = new CommentsModel();
    }

    function studentsList()
    {
        if (session()->isLoggedIn && $this->request->getMethod() == 'get' && ! $this->request->isAJAX()) {
            $this->data['title'] = 'Students List - '.setting('App.siteName');
            return view('student/student-list', $this->data);
        } else {
            return redirect()->route('dashboard');
        }
    }

    function ajaxGetStudentsListDt()
    {
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            $response = array();
            $where = '';
            $draw = $this->request->getPost('draw');
            $start = $this->request->getPost('start');
            $rowperpage = $this->request->getPost('length');
            $columnIndex =  $this->request->getPost('order')[0]['column'];
            $columnName =  $this->request->getPost('columns')[$columnIndex]['data'];
            $columnSortOrder =  $this->request->getPost('order')[0]['dir'];
            $keyword = $this->request->getPost('search')['value'];
            switch ($columnName) {
                case 'id':
                $columnName = 'id';
                break;
                case 'name':
                $columnName = 'name';
                break;
                case 'email':
                $columnName = 'email';
                break;
                case 'phone':
                $columnName = 'phone';
                break;
                default:
                $columnName = 'id';
                break;
            }


            $totalRecords = $totalRecordwithFilter = $this->dt->ajaxGetStudentListDt(1);


            if (! empty($keyword)) {
                $where .= empty($where)?"(master_data.title LIKE '%$keyword%' ESCAPE '!')":" AND (master_data.title LIKE '%$keyword%' ESCAPE '!')";
            }

            if (! empty($where)) {
                $totalRecordwithFilter = $this->dt->ajaxGetStudentListDt(1, '', '', $where);
            }

            $records = $this->dt->ajaxGetStudentListDt(0, $rowperpage, $start, $where, $columnSortOrder, $columnName);
            $data = array();
            $i = $start+1;

            foreach($records as $record ){
                $actions = $subAction = $status = '';

                $subAction .= '<a href="'. site_url('student/profile/information/'. encrypt($record['id'])) .'" class="dropdown-item edit-row"><i class="ft-edit-2 success"></i> Edit</a>';
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
                    "id" => $i++,
                    "name" => $record['name'],
                    "email" => $record['email'],
                    "phone" => $record['phone'],
                    "action" => $actions,
                );
            }
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

    function attemptToDeleteStudent()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        $ids = [];
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            foreach ($this->request->getPost('ids') as $id) {
                if (!empty($id)) {
                    $this->crud->deleteData('users', ['id' => $id, 'group_id' => 3]);
                    $this->crud->deleteData('user_details', ['parent_id' => $id]);
                }
            }
            $this->data['success'] = true;
            $this->data['message'] = 'Student has been succesfully deleted.';
            return $this->response->setJSON($this->data);
        } else {
            $this->data['message'] = 'Something went wrong!';
            return $this->response->setJSON($this->data);
        }
    }

    function saveStudentInfo()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            $rules = [
                'name'                    => ['label' => 'Student Name ', 'rules' => 'required'],
                'email'                   => ['label' => 'Student Email', 'rules' => 'required|is_unique[users.email]'],
                'phone'                   => ['label' => 'Student Phone ', 'rules' => 'required|is_unique[users.mobile]'],
            ];

            $errors = [];
            if ($this->validate($rules, $errors)) {

                $userData = [
                    'email'                     => trim($this->request->getPost('email')),
                    'group_id'                  => 3,
                    'mobile'                    => trim($this->request->getPost('phone')),
                    'created_at'                => time(),
                ];


                $detailsData = [
                    'name'                        => trim($this->request->getPost('name')),
                    'phone'                       => trim($this->request->getPost('phone')),
                ];

                if ($lastId = $this->crud->add('users', $userData)){
                    $detailsData['parent_id'] = $lastId;
                    $studId = 'STUD'.sprintf('%04d', $lastId);
                    $this->crud->add('user_details', $detailsData);
                    $this->crud->updateData('users', ['id' => $lastId], ['prefix_id' => $studId]);
                    $this->data['success'] = true;
                    $this->data['redirect'] = site_url('student/profile/information/'.$studId);
                    $this->data['message'] = 'Application Student has been successfully added.';
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

    function profileInformation($id)
    {
        if (session()->isLoggedIn && $this->request->getMethod() == 'get' && ! $this->request->isAJAX()) {
            $this->data = array_merge($this->data, $this->educationSummaryDependancies($id));
            $this->data['title'] = 'New Application - Personal Information';
            $this->data['details'] = $data['details'] = $this->crud->select('students_view', '', ['id' => decrypt($id)], '', true);
            $this->data['component'] =  view('student/edit/information', $data);
            return view('application/new-application', $this->data);
        } else {
            return redirect()->route('dashboard');
        }
    }

    function addNewApplication($id)
    {
        if (session()->isLoggedIn && $this->request->getMethod() == 'get' && ! $this->request->isAJAX()) {
            $this->data = array_merge($this->data, $this->educationSummaryDependancies($id));
            $this->data['title'] = 'Application List';
            $this->data['details'] = $data['details'] = $this->crud->select('students_view', '', ['id' => decrypt($id)], '', true);
            $this->data['appliedPrograms'] = $this->application->getAppliedProgramsByStudentId(decrypt($id));
            $this->data['component'] = view('student/application/add-application', $this->data);
            return view('application/new-application', $this->data);
        } else {
            return redirect()->route('dashboard');
        }
    }

    function applicationDocument($id)
    {
        if (session()->isLoggedIn && $this->request->getMethod() == 'get' && ! $this->request->isAJAX()) {
            $this->data = array_merge($this->data, $this->educationSummaryDependancies($id));
            $this->data['title'] = 'Application List';
            $this->data['details'] = $data['details'] = $this->crud->select('students_view', '', ['id' => decrypt($id)], '', true);
            $this->data['document']=$data['document']=$document = $this->common->getMasterData(8);
            $this->data['component'] =  view('student/edit/application-documents', $this->data);
            return view('application/new-application', $this->data);
        } else {
            return redirect()->route('dashboard');
        }
    }

    function profileMailingAddress($id)
    {
        if (session()->isLoggedIn && $this->request->getMethod() == 'get' && ! $this->request->isAJAX()) {
            $this->data = array_merge($this->data, $this->educationSummaryDependancies($id));
            $this->data['title'] = 'New Application - Mailing Address';
            $this->data['details'] = $data['details'] = $details = $this->crud->select('students_view', '', ['id' => decrypt($id)], '', true);
            if (!empty($details)) {
                $data['city'] = $this->crud->select('cities', '', ['id' => $details['city']], '', true);
                $data['state'] = $this->crud->select('states', '', ['id' => $details['state']], '', true);
                $data['country'] = $this->crud->select('countries', '', ['id' => $details['country']], '', true);
            }
            $this->data['component'] =  view('student/edit/mailing-address', $data);
            return view('application/new-application', $this->data);
        } else {
            return redirect()->route('dashboard');
        }
    }

    function profilePermanentAddress($id)
    {
        if (session()->isLoggedIn && $this->request->getMethod() == 'get' && ! $this->request->isAJAX()) {
            $this->data = array_merge($this->data, $this->educationSummaryDependancies($id));
            $this->data['title'] = 'New Application - Permanent Address';
            $this->data['details'] = $data['details'] = $details = $this->crud->select('students_view', '', ['id' => decrypt($id)], '', true);
            if (!empty($details)) {
                $data['city'] = $this->crud->select('cities', '', ['id' => $details['perma_city']], '', true);
                $data['state'] = $this->crud->select('states', '', ['id' => $details['perma_state']], '', true);
                $data['country'] = $this->crud->select('countries', '', ['id' => $details['perma_country']], '', true);
            }
            $this->data['component'] =  view('student/edit/permanent-address', $data);
            return view('application/new-application', $this->data);
        } else {
            return redirect()->route('dashboard');
        }
    }

    function passPortInformation($id)
    {
        if (session()->isLoggedIn && $this->request->getMethod() == 'get' && ! $this->request->isAJAX()) {
            $this->data = array_merge($this->data, $this->educationSummaryDependancies($id));
            $this->data['title'] = 'New Application - Passport Information';
            $this->data['details'] = $data['details'] = $details=$this->crud->select('students_view', '', ['id' => decrypt($id)], '', true);
            if (!empty($details)) {
                $data['country'] = $this->crud->select('countries', '', ['id' => $details['country']], '', true);
                $data['country1'] = $this->crud->select('countries', '', ['id' => $details['birth_country']], '', true);
                $data['city'] = $this->crud->select('cities', '', ['id' => $details['birth_city']], '', true);
            }
            $this->data['component'] =  view('student/edit/passport-information', $data);
            return view('application/new-application', $this->data);
        } else {
            return redirect()->route('dashboard');
        }
    }

    function nationality($id)
    {
        if (session()->isLoggedIn && $this->request->getMethod() == 'get' && ! $this->request->isAJAX()) {
            $this->data = array_merge($this->data, $this->educationSummaryDependancies($id));
            $this->data['title'] = 'New Application - Nationality';
            $this->data['details'] = $data['details'] = $details = $this->crud->select('students_view', '', ['id' => decrypt($id)], '', true);
            if (!empty($details)) {
                $data['country'] = $this->crud->select('countries', '', ['id' => $details['nationality']], '', true);
                $data['country1'] = $this->crud->select('countries', '', ['id' => $details['citizenship']], '', true);
            }
            $this->data['component'] =  view('student/edit/nationality', $data);
            return view('application/new-application', $this->data);
        } else {
            return redirect()->route('dashboard');
        }
    }

    function backgroundInfo($id)
    {
        if (session()->isLoggedIn && $this->request->getMethod() == 'get' && ! $this->request->isAJAX()) {
            $this->data['title'] = 'New Application - Nationality';
            $this->data['details'] = $data['details'] = $details = $this->crud->select('students_view', '', ['id' => decrypt($id)], '', true);

            $this->data['component'] =  view('student/edit/background-info', $data);
            return view('application/new-application', $this->data);
        } else {
            return redirect()->route('dashboard');
        }
    }

    function alternateContact($id)
    {
        if (session()->isLoggedIn && $this->request->getMethod() == 'get' && ! $this->request->isAJAX()) {
            $this->data = array_merge($this->data, $this->educationSummaryDependancies($id));
            $this->data['title'] = 'Alternate Contact - Nationality';
            $this->data['details'] = $data['details'] = $details=$this->crud->select('students_view', '', ['id' => decrypt($id)], '', true);

            $this->data['component'] =  view('student/edit/alternate-contact', $data);
            return view('application/new-application', $this->data);
        } else {
            return redirect()->route('dashboard');
        }
    }

    function educationSummary($id)
    {

        if (session()->isLoggedIn && $this->request->getMethod() == 'get' && ! $this->request->isAJAX()) {
            $this->data = array_merge($this->data, $this->educationSummaryDependancies($id));
            $this->data['title'] = 'Education Summary';
            $this->data['details'] = $data['details'] = $details=$this->crud->select('students_view', '', ['id' => decrypt($id)], '', true);
            $this->data['component'] =  view('student/edit/education-summary', $this->data);
            return view('application/new-application', $this->data);
        } else {
            return redirect()->route('dashboard');
        }
    }


    function workExperience($id)
    {
        if (session()->isLoggedIn && $this->request->getMethod() == 'get' && ! $this->request->isAJAX()) {
            $this->data = array_merge($this->data, $this->educationSummaryDependancies($id));
            $this->data['title'] = 'New Application - Personal Information';
            $this->data['details'] = $data['details'] = $this->crud->select('students_view', '', ['id' => decrypt($id)], '', true);
            $this->data['component'] =  view('student/edit/experience-details', $data);
            return view('application/new-application', $this->data);
        } else {
            return redirect()->route('dashboard');
        }
    }

    function UpdatePersonalInfo()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX() && !empty($this->request->getPost('id'))) {
            $rules = [
                'dob'                       => ['label' => 'Date of Birth ', 'rules' => 'required'],
                'gender'                    => ['label' => 'Gender', 'rules' => 'required'],
                'status'                    => ['label' => 'Marital Status ', 'rules' => 'required'],
                'name'                      => ['label' => 'Student Name ', 'rules' => 'required'],
                'email'                     => ['label' => 'Student Email', 'rules' => 'required|custom_is_unique[users.email,id,{id}]'],
                'phone'                     => ['label' => 'Student Phone ', 'rules' => 'required|custom_is_unique[users.mobile,id,{id}]'],
                'display_picture'           => ['label' => 'Profile picture', 'rules' => 'ext_in[display_picture,' . DP_EXT . ']|max_size[display_picture,2048]|max_dims[display_picture,115,115]'],
            ];

            $errors = [];
            if ($this->validate($rules, $errors)) {

                $data = array(
                    'dob'                          => strtotime($this->request->getPost('dob')),
                    'gender'                       => trim($this->request->getPost('gender')),
                    'marital_status'               => trim($this->request->getPost('status')),
                    'name'                        => trim($this->request->getPost('name')),
                    'phone'                       => trim($this->request->getPost('phone')),
                );

                $userData = [
                    'email'                     => trim($this->request->getPost('email')),
                    'mobile'                    => trim($this->request->getPost('phone')),
                ];

                $dp = $this->request->getFile('display_picture');
                if ($dp->isValid()) {
                    $dpArr = upload('display_picture', USER_DP_UPLOAD_PATH);
                    $data['display_picture'] = $dpArr['encryptedName'];
                }

                if ($lastId = $this->crud->updateData('user_details', ['parent_id' => decrypt($this->request->getPost('id'))], $data)){
                    $this->crud->updateData('users', ['id' => decrypt($this->request->getPost('id'))], $userData);
                    $this->data['success'] = true;
                    $this->data['message'] = 'Personal Information has been successfully updated.';
                    $this->data['redirect'] = site_url('student/profile/mailing-address/'.$this->request->getPost('id'));
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

    function UpdateMalingAddressInfo()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX() && !empty($this->request->getPost('id'))) {
            $rules = [
                'address'                    => ['label' => 'Address 1', 'rules' => 'required'],
                'address_2'                  => ['label' => 'Address 2', 'rules' => 'required'],
                'country'                    => ['label' => 'Country ', 'rules' => 'required'],
                'state'                      => ['label' => 'State ', 'rules' => 'required'],
                'city'                       => ['label' => 'City ', 'rules' => 'required'],
                'pin_code'                   => ['label' => 'Pincode ', 'rules' => 'required'],

            ];

            $errors = [];
            if ($this->validate($rules, $errors)) {

                $data = array(
                    'address'                         => trim($this->request->getPost('address')),
                    'address_2'                       => trim($this->request->getPost('address_2')),
                    'country'                         => trim($this->request->getPost('country')),
                    'state'                           => trim($this->request->getPost('state')),
                    'city'                            => trim($this->request->getPost('city')),
                    'pin_code'                        => trim($this->request->getPost('pin_code')),

                );

                if ($lastId = $this->crud->updateData('user_details', ['parent_id' => decrypt($this->request->getPost('id'))], $data)){

                    $this->data['success'] = true;
                    $this->data['message'] = 'Maling Address has been successfully updated.';
                    $this->data['redirect'] = site_url('student/profile/permanent-address/'.$this->request->getPost('id'));
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

    function updatePermanentAddressInfo()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX() && !empty($this->request->getPost('id'))) {
            $rules = [
                'perma_address'                    => ['label' => 'Address 1', 'rules' => 'required'],
                'perma_address_2'                  => ['label' => 'Address 2', 'rules' => 'required'],
                'perma_country'                    => ['label' => 'Country ', 'rules' => 'required'],
                'perma_state'                      => ['label' => 'State ', 'rules' => 'required'],
                'perma_city'                       => ['label' => 'City ', 'rules' => 'required'],
                'perma_pin_code'                   => ['label' => 'Pincode ', 'rules' => 'required'],

            ];

            $errors = [];
            if ($this->validate($rules, $errors)) {

                $data = array(
                    'parent_id'                             => trim($this->request->getPost('id')),
                    'perma_address'                         => trim($this->request->getPost('perma_address')),
                    'perma_address_2'                       => trim($this->request->getPost('perma_address_2')),
                    'perma_country'                         => trim($this->request->getPost('perma_country')),
                    'perma_state'                           => trim($this->request->getPost('perma_state')),
                    'perma_city'                            => trim($this->request->getPost('perma_city')),
                    'perma_pin_code'                        => trim($this->request->getPost('perma_pin_code')),

                );

                if (! empty($this->crud->select('user_permanent_address', 'id', ['parent_id' => decrypt($this->request->getPost('id'))], '', true))) {
                    if ($lastId = $this->crud->updateData('user_permanent_address', ['parent_id' => decrypt($this->request->getPost('id'))], $data)){
                        $this->data['success'] = true;
                        $this->data['message'] = 'Parmanent Address has been successfully updated.';
                        $this->data['redirect'] = site_url('student/profile/passport-information/'.$this->request->getPost('id'));
                        return $this->response->setJSON($this->data);
                    } else {
                        $this->data['message'] = 'Something went wrong.';
                        return $this->response->setJSON($this->data);
                    }
                } else {
                    $data['parent_id'] = decrypt($this->request->getPost('id'));
                    if ($lastId = $this->crud->add('user_permanent_address', $data)){
                        $this->data['success'] = true;
                        $this->data['message'] = 'Parmanent Address has been successfully added.';
                        $this->data['redirect'] = site_url('student/profile/passport-information/'.$this->request->getPost('id'));
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

    function updatePassportInfo()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX() && !empty($this->request->getPost('id'))) {
            $rules = [
                'passport_number'             => ['label' => 'Passport Number', 'rules' => 'required'],
                'issue_date'                  => ['label' => 'Issue Date', 'rules' => 'required'],
                'expiry_date'                 => ['label' => 'Expiry Date ', 'rules' => 'required'],
                'country'                     => ['label' => 'Country ', 'rules' => 'required'],
                'birth_country'               => ['label' => 'Country of Birth ', 'rules' => 'required'],
                'birth_city'                  => ['label' => 'City of Birth ', 'rules' => 'required'],

            ];

            $errors = [];
            if ($this->validate($rules, $errors)) {

                $data = array(
                    'parent_id'                        => trim($this->request->getPost('id')),
                    'passport_number'                  => trim($this->request->getPost('passport_number')),
                    'issue_date'                       => strtotime($this->request->getPost('issue_date')),
                    'expiry_date'                      => strtotime($this->request->getPost('expiry_date')),
                    'country'                          => trim($this->request->getPost('country')),
                    'birth_country'                    => trim($this->request->getPost('birth_country')),
                    'birth_city'                       => trim($this->request->getPost('birth_city')),

                );

                if (! empty($this->crud->select(' user_passport_info', 'id', ['parent_id' => decrypt($this->request->getPost('id'))], '', true))) {
                    if ($lastId = $this->crud->updateData(' user_passport_info', ['parent_id' => decrypt($this->request->getPost('id'))], $data)){
                        $this->data['success'] = true;
                        $this->data['message'] = 'Passport Information has been successfully updated.';
                        $this->data['redirect'] = site_url('student/profile/nationality/'.$this->request->getPost('id'));
                        return $this->response->setJSON($this->data);
                    } else {
                        $this->data['message'] = 'Something went wrong.';
                        return $this->response->setJSON($this->data);
                    }
                } else {
                    $data['parent_id'] = decrypt($this->request->getPost('id'));
                    if ($lastId = $this->crud->add(' user_passport_info', $data)){
                        $this->data['success'] = true;
                        $this->data['message'] = 'Passport Information has been successfully added.';
                        $this->data['redirect'] = site_url('student/profile/nationality/'.$this->request->getPost('id'));
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

    function updateNationality()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX() && !empty($this->request->getPost('id'))) {
            $rules = [
                'nationality'                           => ['label' => 'Passport Number', 'rules' => 'required'],
                'citizenship'                           => ['label' => 'Issue Date', 'rules' => 'required'],
                'citizen_of_multiple_country'           => ['label' => 'Expiry Date ', 'rules' => 'required'],
                'living_studying_in_other_country'      => ['label' => 'Country ', 'rules' => 'required'],

            ];

            $errors = [];
            if ($this->validate($rules, $errors)) {

                $data = array(
                    'parent_id'                             => trim($this->request->getPost('id')),
                    'nationality'                       => trim($this->request->getPost('nationality')),
                    'citizenship'                       => trim($this->request->getPost('citizenship')),
                    'citizen_of_multiple_country'       => trim($this->request->getPost('citizen_of_multiple_country')),
                    'living_studying_in_other_country'  => trim($this->request->getPost('living_studying_in_other_country')),

                );

                if (! empty($this->crud->select(' user_nationality', 'id', ['parent_id' => decrypt($this->request->getPost('id'))], '', true))) {
                    if ($lastId = $this->crud->updateData(' user_nationality', ['parent_id' => decrypt($this->request->getPost('id'))], $data)){
                        $this->data['success'] = true;
                        $this->data['message'] = 'Nationality has been successfully updated.';
                        $this->data['redirect'] = site_url('student/profile/background-info/'.$this->request->getPost('id'));
                        return $this->response->setJSON($this->data);
                    } else {
                        $this->data['message'] = 'Something went wrong.';
                        return $this->response->setJSON($this->data);
                    }
                } else {
                    $data['parent_id'] = decrypt($this->request->getPost('id'));
                    if ($lastId = $this->crud->add(' user_nationality', $data)){
                        $this->data['success'] = true;
                        $this->data['message'] = 'Nationality has been successfully added.';
                        $this->data['redirect'] = site_url('student/profile/background-info/'.$this->request->getPost('id'));
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

    function updateBackgroud()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX() && !empty($this->request->getPost('id'))) {
            $rules = [
                'applied_immigration_in_other_country'  => ['label' => 'Has applicant applied for any type of immigration into any country?', 'rules' => 'required'],
                'suffer_serious_medical_condition'       => ['label' => 'Does applicant suffer from a serious medical condition?', 'rules' => 'required'],
                'visa_refusal_any_country'           => ['label' => 'Has applicant Visa refusal for any country? ', 'rules' => 'required'],
                'have_criminal_record'      => ['label' => 'Has applicant ever been convicted of a criminal offence? ', 'rules' => 'required'],

            ];

            $errors = [];
            if ($this->validate($rules, $errors)) {

                $data = array(
                    'parent_id'                             => trim($this->request->getPost('id')),
                    'applied_immigration_in_other_country' => trim($this->request->getPost('applied_immigration_in_other_country')),
                    'suffer_serious_medical_condition'      => trim($this->request->getPost('suffer_serious_medical_condition')),
                    'visa_refusal_any_country'       => trim($this->request->getPost('visa_refusal_any_country')),
                    'have_criminal_record'  => trim($this->request->getPost('have_criminal_record')),

                );

                if (! empty($this->crud->select(' user_background_info', 'id', ['parent_id' => decrypt($this->request->getPost('id'))], '', true))) {
                    if ($lastId = $this->crud->updateData(' user_background_info', ['parent_id' => decrypt($this->request->getPost('id'))], $data)){
                        $this->data['success'] = true;
                        $this->data['message'] = 'background-info has been successfully updated.';
                        $this->data['redirect'] = site_url('student/profile/alternate-contact/'.$this->request->getPost('id'));
                        return $this->response->setJSON($this->data);
                    } else {
                        $this->data['message'] = 'Something went wrong.';
                        return $this->response->setJSON($this->data);
                    }
                } else {
                    $data['parent_id'] = decrypt($this->request->getPost('id'));
                    if ($lastId = $this->crud->add(' user_background_info', $data)){
                        $this->data['success'] = true;
                        $this->data['message'] = 'background-info has been successfully added.';
                        $this->data['redirect'] = site_url('student/profile/alternate-contact/'.$this->request->getPost('id'));
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

    function updateAlternateContact()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX() && !empty($this->request->getPost('id'))) {
            $rules = [
                'name'                            => ['label' => 'Name', 'rules' => 'required'],
                'phone'                           => ['label' => 'Phone', 'rules' => 'required'],
                'email'                           => ['label' => 'Email ', 'rules' => 'required'],
                'relation'       => ['label' => 'Relation with Applicant ', 'rules' => 'required'],

            ];

            $errors = [];
            if ($this->validate($rules, $errors)) {

                $data = array(
                    'parent_id'                             => trim($this->request->getPost('id')),
                    'name'                       => trim($this->request->getPost('name')),
                    'phone'                      => trim($this->request->getPost('phone')),
                    'email'                      => trim($this->request->getPost('email')),
                    'relation'                   => trim($this->request->getPost('relation')),

                );

                if (! empty($this->crud->select(' user_alternate_contact', 'id', ['parent_id' => decrypt($this->request->getPost('id'))], '', true))) {
                    if ($lastId = $this->crud->updateData(' user_alternate_contact', ['parent_id' => decrypt($this->request->getPost('id'))], $data)){
                        $this->data['success'] = true;
                        $this->data['message'] = 'Alternate-Contact has been successfully updated.';
                        $this->data['redirect'] = site_url('student/profile/education-summary/'.$this->request->getPost('id'));
                        return $this->response->setJSON($this->data);
                    } else {
                        $this->data['message'] = 'Something went wrong.';
                        return $this->response->setJSON($this->data);
                    }
                } else {
                    $data['parent_id'] = decrypt($this->request->getPost('id'));
                    if ($lastId = $this->crud->add(' user_alternate_contact', $data)){
                        $this->data['success'] = true;
                        $this->data['message'] = 'Alternate-Contact has been successfully added.';
                        $this->data['redirect'] = site_url('student/profile/education-summary/'.$this->request->getPost('id'));
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

    function attemptToSaveEducationSummary()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            $rules = [
                'level_of_study'                    => ['label' => 'Level of Study', 'rules' => 'required|sumamryUnique[student_id]'],
                'stream'                            => ['label' => 'Stream', 'rules' => 'required'],
                'course_from'                       => ['label' => 'Course From  ', 'rules' => 'required'],
                'course_to'                         => ['label' => 'Course To ', 'rules' => 'required'],
                'grading_system'                    => ['label' => 'Grading system', 'rules' => 'required'],
                'score'                             => ['label' => 'score ', 'rules' => 'required'],
                'institute'                         => ['label' => 'Institution ', 'rules' => 'required'],
                'country_of_study'                  => ['label' => 'Country of Study ', 'rules' => 'required'],
                'state_of_study'                    => ['label' => 'State of Study  ', 'rules' => 'required'],
                'city_of_study'                     => ['label' => 'City of Study ', 'rules' => 'required'],
                'primary_language'                  => ['label' => 'Primary Langauge', 'rules' => 'required'],
                'back_logs'                         => ['label' => 'Back Logs', 'rules' => 'required'],
                'highest_qualification'             => ['label' => 'Highest Qualification ', 'rules' => 'required'],
            ];
            $errors = [
                'level_of_study' => [
                    'sumamryUnique' => 'Level of study should contains unique value per student.'
                ]
            ];
            if ($this->validate($rules, $errors)) {
                $data = array(
                    'parent_id'                             => decrypt($this->request->getPost('student_id')),
                    'level_of_study'                        => trim($this->request->getPost('level_of_study')),
                    'stream'                                => trim($this->request->getPost('stream')),
                    'course_from'                           => strtotime($this->request->getPost('course_from')),
                    'course_to'                             => strtotime($this->request->getPost('course_to')),
                    'grading_system'                        => trim($this->request->getPost('grading_system')),
                    'score'                                 => trim($this->request->getPost('score')),
                    'institute'                             => trim($this->request->getPost('institute')),
                    'country_of_study'                      => trim($this->request->getPost('country_of_study')),
                    'state_of_study'                        => trim($this->request->getPost('state_of_study')),
                    'city_of_study'                         => trim($this->request->getPost('city_of_study')),
                    'primary_language'                      => trim($this->request->getPost('primary_language')),
                    'back_logs'                             => trim($this->request->getPost('back_logs')),
                    'highest_qualification'                 => trim($this->request->getPost('highest_qualification')),
                );
                if (empty($this->request->getPost('id'))) {
                    if ($lastId = $this->crud->add('user_qualification', $data)) {
                        $this->data['success'] = true;
                        $this->data['message'] = 'Education Summary has been successfully added.';
                        return $this->response->setJSON($this->data);
                    } else {
                        $this->data['message'] = 'Something went wrong.';
                        return $this->response->setJSON($this->data);
                    }
                } else {

                    if ($lastId = $this->crud->updateData('user_qualification', ['id' => decrypt($this->request->getPost('id'))], $data)) {
                        $this->data['success'] = true;
                        $this->data['message'] = 'Education Summary has been successfully updated.';
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

    function ajaxGetTypeOfEducationSummaryDt()
    {
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            $response = array();
            $where = '';
            $draw = $this->request->getPost('draw');
            $start = $this->request->getPost('start');
            $rowperpage = $this->request->getPost('length');
            $columnIndex =  $this->request->getPost('order')[0]['column'];
            $columnName =  $this->request->getPost('columns')[$columnIndex]['data'];
            $columnSortOrder =  $this->request->getPost('order')[0]['dir'];
            $keyword = $this->request->getPost('search')['value'];
            $studId = $this->request->getPost('student_id');
            switch ($columnName) {
                case 'id':
                $columnName = 'user_qualification.id';
                break;
                case 'level_of_study':
                $columnName = 'master_data.title';
                break;
                case 'stream':
                $columnName = 'user_qualification.stream';
                break;
                case 'grading_system':
                $columnName = 'user_qualification.grading_system';
                break;
                case 'highest_qualification':
                $columnName = 'user_qualification.highest_qualification';
                break;
                default:
                $columnName = 'id';
                break;
            }
            if (! empty($studId)) {
                $where .= empty($where)?"(user_qualification.parent_id=$studId)":" AND (user_qualification.parent_id=$studId)";
            }

            $totalRecords = $totalRecordwithFilter = $this->dt->ajaxEducationSummaryDt(1, '', '', $where);


            if (! empty($keyword)) {
                $where .= empty($where)?"(master_data.title LIKE '%$keyword%' ESCAPE '!')":" AND (master_data.title LIKE '%$keyword%' ESCAPE '!')";
            }

            if (! empty($where)) {
                $totalRecordwithFilter = $this->dt->ajaxEducationSummaryDt(1, '', '', $where);
            }

            $records = $this->dt->ajaxEducationSummaryDt(0, $rowperpage, $start, $where, $columnSortOrder, $columnName);
            $data = array();
            $i = $start+1;

            foreach($records as $record ){
                $actions = $subAction = $status = '';

                $subAction .= '<a href="javascript:void(0)" data-id="'. $record['id'] .'" class="dropdown-item edit-education-summary"><i class="ft-edit-2 success"></i> Edit</a>';
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
                    "id" => $i++,
                    "level_of_study" => $record['levelOfDegreeName'],
                    "stream" => $record['stream'],
                    "grading_system" => $record['grading_system'],
                    "highest_qualification" => $record['highest_qualification'],
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

    function attemptToDeleteEducationSummary()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        $ids = [];
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            foreach ($this->request->getPost('ids') as $id) {
                if (!empty($id)) {
                    $this->crud->deleteData('user_qualification', ['id' => $id]);
                }
            }
            $this->data['success'] = true;
            $this->data['message'] = 'Education Summary has been succesfully deleted.';
            return $this->response->setJSON($this->data);
        } else {
            $this->data['message'] = 'Something went wrong!';
            return $this->response->setJSON($this->data);
        }
    }

    function ajaxGetEducationSummaryDetails()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            if (!empty($id = $this->request->getPost('id')) && !empty($details = $this->crud->select('user_qualification', '', ['id' => $id], '', 1))) {
                $details['course_from'] = date('Y-m-d', $details['course_from']);
                $details['course_to'] = date('Y-m-d', $details['course_to']);
                if (strtolower(str_replace(' ', '', $details['grading_system'])) == 'outof100') {
                    $details['grading_system'] = 1;
                } else {
                    $details['grading_system'] = 2;
                }
                if ($details['highest_qualification'] == 'Yes') {
                    $details['highest_qualification'] = 1;
                } else {
                    $details['highest_qualification'] = 2;
                }
                if (!empty($details['country_of_study'])) {
                    $country = $this->crud->select('countries', '', ['id' => $details['country_of_study']], '', 1);
                    $details['country_of_study'] = '<option value="' . $country['id'] . '" selected>' . $country['name'] . '</select>';
                }
                if (!empty($details['state_of_study'])) {
                    $country = $this->crud->select('states', '', ['id' => $details['state_of_study']], '', 1);
                    $details['state_of_study'] = '<option value="' . $country['id'] . '" selected>' . $country['name'] . '</select>';
                }
                if (!empty($details['city_of_study'])) {
                    $country = $this->crud->select('cities', '', ['id' => $details['city_of_study']], '', 1);
                    $details['city_of_study'] = '<option value="' . $country['id'] . '" selected>' . $country['name'] . '</select>';
                }
                $details['id'] = encrypt($details['id']);
                $this->data['success'] = true;
                $this->data['result'] = $details;
                return $this->response->setJSON($this->data);
            } else {
                $this->data['message'] = 'Something went wrong!';
                return $this->response->setJSON($this->data);
            }
        } else {
            $this->data['message'] = 'Something went wrong!';
            return $this->response->setJSON($this->data);
        }
    }

    function attemptToSaveWorkExperience()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            $rules = [
                'organization'                => ['label' => 'Organization', 'rules' => 'required'],
                'position'                    => ['label' => 'Position', 'rules' => 'required'],
                'email_address'               => ['label' => 'Email address ', 'rules' => 'required'],
            ];
            $errors = [];
            if ($this->validate($rules, $errors)) {
                $data = array(
                    'parent_id'                       => decrypt($this->request->getPost('id')),
                    'organization'                    => trim($this->request->getPost('organization')),
                    'position'                        => trim($this->request->getPost('position')),
                    'email_address'                   => trim($this->request->getPost('email_address')),

                );

                if (empty($this->request->getPost('id'))) {

                    if ($lastId = $this->crud->add('user_experience', $data)) {
                        $this->data['success'] = true;
                        $this->data['message'] = 'User Experience has been successfully added.';
                        return $this->response->setJSON($this->data);
                    } else {
                        $this->data['message'] = 'Something went wrong.';
                        return $this->response->setJSON($this->data);
                    }
                } else {

                    if ($lastId = $this->crud->updateData('user_experience', ['id' => $this->request->getPost('id')], $data)) {
                        $this->data['success'] = true;
                        $this->data['message'] = 'User Experience has been successfully updated.';
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

    function ajaxGetWorkExperienceListDt()
    {
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            $response = array();
            $where = '';
            $draw = $this->request->getPost('draw');
            $start = $this->request->getPost('start');
            $rowperpage = $this->request->getPost('length');
            $columnIndex =  $this->request->getPost('order')[0]['column'];
            $columnName =  $this->request->getPost('columns')[$columnIndex]['data'];
            $columnSortOrder =  $this->request->getPost('order')[0]['dir'];
            $keyword = $this->request->getPost('search')['value'];
            switch ($columnName) {
                case 'id':
                $columnName = 'id';
                break;
                case 'organization':
                $columnName = 'organization';
                break;
                case 'position':
                $columnName = 'position';
                break;
                case 'email_address':
                $columnName = 'email_address';
                break;
                default:
                $columnName = 'id';
                break;
            }


            $totalRecords = $totalRecordwithFilter = $this->dt->ajaxWorkExperienceInfoDt(1);


            if (! empty($keyword)) {
                $where .= empty($where)?"(master_data.title LIKE '%$keyword%' ESCAPE '!')":" AND (master_data.title LIKE '%$keyword%' ESCAPE '!')";
            }

            if (! empty($where)) {
                $totalRecordwithFilter = $this->dt->ajaxWorkExperienceInfoDt(1, '', '', $where);
            }

            $records = $this->dt->ajaxWorkExperienceInfoDt(0, $rowperpage, $start, $where, $columnSortOrder, $columnName);
            $data = array();
            $i = $start+1;

            foreach($records as $record ){
                $actions = $subAction = $status = '';

                $subAction .= '<a href="javascript:void(0)" data-id="'.encrypt($record['id']).'" class="dropdown-item edit-work-exp"><i class="ft-edit-2 success"></i> Edit</a>';
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
                    "id" => $i++,
                    "organization" => $record['organization'],
                    "position" => $record['position'],
                    "email_address" => $record['email_address'],
                    "action" => $actions,
                );
            }
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

    function attemptToDeleteWorkExperience()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        $ids = [];
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            foreach ($this->request->getPost('ids') as $id) {
                if (!empty($id)) {
                    $this->crud->deleteData('user_experience', ['id' => $id]);
                }
            }
            $this->data['success'] = true;
            $this->data['message'] = 'Work Experience has been succesfully deleted.';
            return $this->response->setJSON($this->data);
        } else {
            $this->data['message'] = 'Something went wrong!';
            return $this->response->setJSON($this->data);
        }
    }

    function ajaxGetWorkExperiencepiDetails()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            if (!empty($id = $this->request->getPost('id')) && !empty($details = $this->crud->select('user_experience', '', ['id' => decrypt($id)], '', 1))) {
                $this->data['success'] = true;
                $this->data['result'] = $details;
                return $this->response->setJSON($this->data);
            } else {
                $this->data['message'] = 'Something went wrong!';
                return $this->response->setJSON($this->data);
            }
        } else {
            $this->data['message'] = 'Something went wrong!';
            return $this->response->setJSON($this->data);
        }
    }


    function testScore($id)
    {

        if (session()->isLoggedIn && $this->request->getMethod() == 'get' && ! $this->request->isAJAX()) {
            $this->data = array_merge($this->data, $this->educationSummaryDependancies($id));
            $this->data['title'] = 'New Application - Test Score';
            $this->data['details'] = $data['details'] = $this->crud->select('students_view', '', ['id' => decrypt($id)], '', true);
            $this->data['testType'] = $data['testType'] =$this->common->getMasterData(7);




            $this->data['component'] =  view('student/edit/test-score', $data);
            return view('application/new-application', $this->data);
        } else {
            return redirect()->route('dashboard');
        }
    }

    function attemptToCheckFieldData()
    {
        $html = '';
        $this->data['hash'] = csrf_hash();
        if ($this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            $data = $this->crud->select('master_data', '', ['id' => $this->request->getPost('id'), 'type' => 7], '', true);
            if (! empty($data) && ! empty($data['fields'])) {
                $fields = unserialize($data['fields']);
                $html = '<div class="row">';
                foreach ($fields as $key => $val) {

                     $html .= '<div class="col-md-6">
                    <div class="form-group">
                      <label for="companyinput5">'.$val.'</label>
                      <input type="text" class="form-control"  name="fields['.str_replace(" ","_",$val).'][field]" >
                    </div>
                  </div>';
                } $html .= '</div>';
            }
            $this->data['html'] = $html;
            $this->data['success'] = true;
            return $this->response->setJSON($this->data);
        } else {
            $this->data['message'] = 'Access Denied!';
            return $this->response->setJSON($this->data);
        }
    }


    function attemptToSaveTestScore()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            $rules = [

              'testType'           => ['label' => 'Test Type', 'rules' => 'required'],
              'date'           => ['label' => 'Exam date', 'rules' => 'required'],

            ];
            $errors = [

            ];
            if ($this->validate($rules, $errors)) {
                $data = array(
                    'parent_id'                       => trim($this->request->getPost('parent_id')),
                    'test_type_id'                       => trim($this->request->getPost('testType')),

                    'marks'        => serialize($this->request->getPost('fields')),
                    'exam_date'         =>strtotime($this->request->getPost('date')),

                );

                if (empty($this->request->getPost('id'))) {

                    if ($lastId = $this->crud->add('user_score', $data)) {
                        $this->data['success'] = true;
                        $this->data['message'] = 'Test Score has been successfully added.';
                        return $this->response->setJSON($this->data);
                    } else {
                        $this->data['message'] = 'Something went wrong.';
                        return $this->response->setJSON($this->data);
                    }
                } else {

                    if ($lastId = $this->crud->updateData('user_score', $data)) {
                        $this->data['success'] = true;
                        $this->data['message'] = 'Test Score has been successfully updated.';
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

    function ajaxGetTestScoreDt()
    {
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            $response = array();
            $where = '';
            $draw = $this->request->getPost('draw');
            $start = $this->request->getPost('start');
            $rowperpage = $this->request->getPost('length');
            $columnIndex =  $this->request->getPost('order')[0]['column'];
            $columnName =  $this->request->getPost('columns')[$columnIndex]['data'];
            $columnSortOrder =  $this->request->getPost('order')[0]['dir'];
            $keyword = $this->request->getPost('search')['value'];
            switch ($columnName) {
                case 'id':
                $columnName = 'id';
                break;
                case 'test_type_id':
                $columnName = 'test_type_id';
                break;
                case 'exam_date':
                $columnName = 'exam_date';
                break;
                default:
                $columnName = 'id';
                break;
            }

            $totalRecords = $totalRecordwithFilter = $this->dt->ajaxTestScoreInfoDt(1);


            if (! empty($keyword)) {
                $where .= empty($where)?"(master_data.title LIKE '%$keyword%' ESCAPE '!')":" AND (master_data.title LIKE '%$keyword%' ESCAPE '!')";
            }

            if (! empty($where)) {
                $totalRecordwithFilter = $this->dt->ajaxTestScoreInfoDt(1, '', '', $where);
            }

            $records = $this->dt->ajaxTestScoreInfoDt(0, $rowperpage, $start, $where, $columnSortOrder, $columnName);
            $data = array();
            $i = $start+1;

            foreach($records as $record ){
                $actions = $subAction =  '';

                $subAction .= '<a href="javascript:void(0)" data-id="'. $record['id'] .'" class="dropdown-item edit-row"><i class="ft-edit-2 success"></i> Edit</a>';
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
                    "id" => $i++,
                    "test_type_id" => $record['testType'],
                    "exam_date" =>  date('Y-m-d',$record['exam_date']),

                    "action" => $actions,
                );
            }
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

    function attemptToDeleteTestScore()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        $ids = [];
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            foreach ($this->request->getPost('ids') as $id) {
                if (!empty($id)) {
                    $this->crud->deleteData('user_score', ['id' => $id]);
                }
            }
            $this->data['success'] = true;
            $this->data['message'] = 'Test Score has been succesfully deleted.';
            return $this->response->setJSON($this->data);
        } else {
            $this->data['message'] = 'Something went wrong!';
            return $this->response->setJSON($this->data);
        }
    }

    function ajaxGetTestScoreDetails()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            if (!empty($id = $this->request->getPost('id')) && !empty($details = $this->crud->select('user_score', '', ['id' => $id], '', 1))) {
                $this->data['success'] = true;
                $this->data['result'] = $details;
                return $this->response->setJSON($this->data);
            } else {
                $this->data['message'] = 'Something went wrong!';
                return $this->response->setJSON($this->data);
            }
        } else {
            $this->data['message'] = 'Something went wrong!';
            return $this->response->setJSON($this->data);
        }
    }

    function attemptToSaveComment()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            $rules = [
                'comment'               => ['label' => 'Comments', 'rules' => 'required'],
            ];
            $errors = [];
            if ($this->validate($rules, $errors)) {
                $data = [
                    'from_id'               => session()->userData['id'],
                    'application_id'        => decrypt($this->request->getPost('application_id')),
                    'comment'               => trim($this->request->getPost('comment')),
                    'created_at'            => time(),
                ];

                $attachment = $this->request->getFile('attachment');
                if ($attachment->isValid()) {
                    $attachmentArr = upload('attachment', UPLOAD_PATH.'comments/');
                    $data['attachment'] = $attachmentArr['encryptedName'];
                    $data['org_file_name'] = $attachmentArr['name'];
                }

                if ($lastId = $this->crud->add('comments', $data)) {
                    $this->data['success'] = true;
                    $data = [
                        'comment' => $this->comment->getCommentById($lastId),
                    ];
                    $this->data['lastComment'] = view('student/application/single-comment', $data);
                    $this->data['message'] = 'Comment has been successfully added.';
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

    function attemptToSaveDocument()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            $rules = [
               // 'document_id'                    => ['label' => 'Documents Type ', 'rules' => 'required'],

                'file_name'                 => ['label' => 'Upload', 'rules' => 'ext_in[file_name,png,jpg,jpeg]|max_size[file_name,2048]'],

            ];

            $errors = [];
            if ($this->validate($rules, $errors)) {

                $data = array(

                    'upload_by'                        => decrypt($this->request->getPost('student_id')),
                    //'document_id'                        => trim($this->request->getPost('document_id')),

                    'created_at'                           => time(),
                );

                #INIT SCRIPT OF UPLOAD
                $panCard = $this->request->getFile('file_name');
                if ($panCard->isValid()) {
                    $panCardArr = upload('file_name', UPLOAD_PATH.'document/');
                    $data['file_name'] = $panCardArr['encryptedName'];
                }
                #ENDS


                if ($lastId = $this->crud->add('application_document', $data)){

                    $this->data['success'] = true;
                    $this->data['message'] = 'Document Details has been successfully added.';
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

    function attemptToApplyForCourse()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            $courseIds = $this->request->getPost('ids');
            $studId = $this->request->getPost('stud');
            if (empty(decrypt($studId)) || empty($studDet = $this->crud->select('students_view', '', ['id' => decrypt($studId)], '', true))) {
                $this->data['message'] = 'Select a valid student';
                return $this->response->setJSON($this->data);
            }
            if (!empty($courseIds)) {
                foreach ($courseIds as $course) {
                    if (!empty(decrypt($course)) && !empty($courseDet = $this->program->getProgramById(decrypt($course)))) {
                        $data = [
                            'student_id'    => $studDet['id'],
                            'course_id'     => $courseDet['id'],
                            'created_at'    => strtotime('now'),
                            'added_by'      => session()->userData['id'],
                        ];
                        if ($lastId = $this->crud->add('applications', $data)) {
                            $applicationId = 'APP'.sprintf('%04d', $lastId);
                            $this->crud->updateData('applications', ['id' => $lastId], ['application_id' => $applicationId]);
                        }
                    }
                }
                $this->data['success'] = true;
                $this->data['message'] = 'Successfully Applied';
                $this->data['prevUrl'] = site_url('student/application/new-application/' . encrypt($studDet['id']));
                return $this->response->setJSON($this->data);
            }
        } else {
            $this->data['message'] = 'Access Denied.';
            return $this->response->setJSON($this->data);
        }
    }

    function getAllComments()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            $applicationId = decrypt($this->request->getPost('id'));
            if (!empty($applicationId)) {
                $data = [
                    'comments' => $this->comment->getAllComments($applicationId),
                    'studentId' => $this->request->getPost('student'),
                    'applicationId' => $this->request->getPost('id')
                ];
                $this->data['component'] = view('student/application/comment', $data);
                $this->data['success'] = true;
                echo json_encode($this->data);
            }
        } else {
            $this->data['message'] = 'Access Denied.';
            return $this->response->setJSON($this->data);
        }
    }

    private function educationSummaryDependancies(?string $id):array
    {
        return [
            'qualiFicationForSummary'       => $this->common->getMasterData(14),
            'streamForSummary'              => $this->common->getMasterData(15),
            'primaryLanguageForSummary'     => $this->common->getMasterData(17),
            'institutionForSummary'         => $this->common->getMasterData(16),
            'qualMenus'                     => $this->qualfication->getQualifications(decrypt($id))
        ];
    }

}