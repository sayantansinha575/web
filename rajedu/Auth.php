<?php
namespace App\Controllers;
use App\Controllers\BaseController;

class Auth extends BaseController
{

    public function __construct()
    {

    }


    function groupsNPermissions()
    {
        if (session()->isLoggedIn && $this->request->getMethod() == 'get' && ! $this->request->isAJAX()) {
            $this->data['title'] = 'Groups & Permissions - '.setting('App.siteName');
            return view('auth/groups-n-permissions', $this->data);
        } else {
            return redirect()->route('dashboard');
        }
    }
    function manageUser()
    {
        if (session()->isLoggedIn && $this->request->getMethod() == 'get' && ! $this->request->isAJAX()) {
            $this->data['title'] = 'User Management';
            $this->data['deparment'] = $this->common->getMasterData(18);
            $this->data['designation'] = $this->common->getMasterData(19);
            $this->data['groups'] = $this->common->getGroups();
           
            return view('auth/manage-user', $this->data);
        } else {
            return redirect()->route('dashboard');
        }
    }




    public function index()
    {
        if ($this->request->getMethod() == 'get' && ! $this->request->isAJAX()) {
            if (session()->get('isLoggedIn')) {
                return redirect()->to('dashboard');
            }
            $this->data['title'] = 'Login - '.setting('App.siteName');
            return view('auth/login', $this->data);
        }
    }

    public function attempToLogin()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        unset($this->data['config']);
        if ($this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            $rules = [
                'username' => ['label' => 'Username', 'rules' => 'required'],
                'password' => ['label' => 'Password', 'rules' => 'required'],
            ];
            $errors = [
            ];
            if ($this->validate($rules, $errors)) {
                $user = $this->crud->select('users', '', ['email' => $this->request->getPost('username')], '', true);
                if (empty($user) || ! password_verify($this->request->getPost('password'), $user['password_hash'])) {
                    $this->data['message'] = 'You have entered wrong login credentials.';
                    return $this->response->setJSON($this->data);
                } else if ($user['deleted'] == 'Y' || $user['active'] == 'N') {
                    $this->data['message'] = 'Your account has suspended, contact your admin';
                    return $this->response->setJSON($this->data);
                }

                session()->set('isLoggedIn', true);
                session()->set('userData', [
                    'id'            => $user['id'],
                    'group_id'      => $user['group_id'],
                ]);
                $this->data['success'] = true;
                $this->data['redirect'] = site_url('dashboard');
                return $this->response->setJSON($this->data);
            } else {
                $this->data['errors'] = $this->validation->getErrors();
                return $this->response->setJSON($this->data);
            }
        } else {

        }
    }

    public function signOut()
    {
        if (session()->isLoggedIn) {
            session()->remove(['isLoggedIn', 'userData']);
        }
        return redirect()->to(site_url());
    }

    public function register()
    {
        if ($this->request->getMethod() == 'get' && ! $this->request->isAJAX()) {
            $this->data['title'] = 'Register - '.setting('App.siteName');
            if (session()->isProviderLoggedIn) {
                return redirect()->to('dashboard');
            }

            return view($this->config->views['sign-up'], $this->data);
        }
    }

    public function attemptToRegister()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        unset($this->data['config']);
        if ($this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            $rules = [
                'first-name' => 'required|trim',
                'last-name' => 'required|trim',
                'email' => 'required|valid_email|is_unique[users.email]|trim',
                'password' => 'required|min_length[8]|max_length[15]|passwordValidation[password]',
                'confirm-password' => 'required|matches[password]',
                'toc' => 'required',
            ];
            $errors = [
                'first-name' => [
                    'required' => 'The first name field is required.'
                ],
                'last-name' => [
                    'required' => 'The last name field is required.'
                ],
                'email' => [
                    'required' => 'The email field is required.',
                    'valid_email' => 'Enter a valid email.',
                ],
                'password' => [
                    'required' => 'The password is required.',
                    'passwordValidation' => 'Use 8 or more characters with a mix of letters, numbers & symbols.'

                ],
                'confirm-password' => [
                    'required' => 'The password is required.',
                    'matches' => 'The confirm password field does not match the password field.'
                ],
                'toc' => [
                    'required' => 'The terms & condition field is required.'
                ]
            ];
            if ($this->validate($rules, $errors)) {
                $user = [
                    'group_id' => 2,
                    'email'             => $this->request->getPost('email'),
                    'password_hash'     => password_hash($this->request->getPost('confirm-password'), PASSWORD_DEFAULT),
                    'activate_hash'     => random_string('alnum', 32),
                    'created_at'        => time()
                ];
                $details = [
                    'first_name'    => $this->request->getPost('first-name'),
                    'last_name'     => $this->request->getPost('last-name'),
                    'toc'           =>  $this->request->getPost('toc'),
                ];

                if ($lastId = $this->crud->add('users', $user)) {
                    $details['parent_id'] = $lastId;
                    if ($this->crud->add('user_details', $details)) {
                        $this->data['success'] = true;
                        $this->data['message'] = 'A mail has been sent to '.$this->request->getPost('email').' address to confirm your registration';
                        return $this->response->setJSON($this->data);
                    }
                }

            } else {
                $this->data['errors'] = $this->validation->getErrors();
                return $this->response->setJSON($this->data);
            }
        } else {
            return false;
        }
    }

    public function resetPassword()
    {
        if ($this->request->getMethod() == 'get' && ! $this->request->isAJAX()) {
            if (session()->get('isLoggedIn')) {
                return redirect()->to('dashboard');
            }
            $this->data['title'] = 'Reset Password - '.setting('App.siteName');
            return view($this->config->views['reset-password'], $this->data);
        }
    }

    public function resetVerification()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        unset($this->data['config']);
        if ($this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            $rules = [
                'email' => 'required|valid_email|is_not_unique[users.email,email]|trim',
            ];
            $errors = [
                'email' => [
                    'required'          => 'The email field is required.',
                    'valid_email'       => 'Enter a valid email.',
                    'is_not_unique'     => 'No account found on the given details.'
                ]
            ];
            if ($this->validate($rules, $errors)) {
                $user = $this->crud->select('users', '', ['email' => $this->request->getPost('email')], '', true);
                if (! empty($user['activate_hash'])) {
                   $this->data['message'] = 'Your account is not activated.';
                   return $this->response->setJSON($this->data);
                } else if ($user['deleted'] == 'Y' || $user['active'] == 'N') {
                    $this->data['message'] = 'Your account has suspended, contact your admin.';
                    return $this->response->setJSON($this->data);
                }
                $data = [
                    'reset_hash'        => random_string('alnum', 32),
                    'reset_expires'     => time() + (MINUTE * 10)
                ];
                if ($this->crud->updateData('users', ['email' => $this->request->getPost('email')], $data)) {
                    $this->data['success'] = true;
                    $this->data['message'] = '<span class="text-success">We have sent a password reset link on '.$this->request->getPost('email').'.</span>';
                    return $this->response->setJSON($this->data);
                }
            } else {
                $this->data['errors'] = $this->validation->getErrors();
                return $this->response->setJSON($this->data);
            }
        } else {

        }
    }

   

     function attemptToSaveGroupsPermissions()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            $rules = [
                'group-name'           => ['label' => 'Group name', 'rules' => 'required'],

            ];
            $errors = [];
            if ($this->validate($rules, $errors)) {
                $data = array(
                    'name'             => trim($this->request->getPost('group-name')),

                );

                if (empty($this->request->getPost('id'))) {
                    $data['created_by'] = session()->userData['id'];
                   // $data['type'] = 3;
                    $data['created_at'] = time();
                    if ($lastId = $this->crud->add('groups', $data)) {
                        $this->data['success'] = true;
                        $this->data['message'] = 'Groups Name has been successfully added.';
                        return $this->response->setJSON($this->data);
                    } else {
                        $this->data['message'] = 'Something went wrong.';
                        return $this->response->setJSON($this->data);
                    }
                } else {
                    $data['updated_at'] = time();
                    if ($lastId = $this->crud->updateData('groups', ['id' => $this->request->getPost('id')],$data)) {
                        $this->data['success'] = true;
                        $this->data['message'] = 'Groups Name has been successfully updated.';
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

     function ajaxGetGroupsPermissionsDt()
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
                $columnName = 'groups.id';
                break;
                case 'group-name':
                $columnName = 'groups.name';
                break;
                default:
                $columnName = 'groups.id';
                break;
            }

            $totalRecords = $totalRecordwithFilter = $this->dt->ajaxGetGroupsPermissionsDt(1);


            if (! empty($keyword)) {
                $where .= empty($where)?"(groups.name LIKE '%$keyword%' ESCAPE '!')":" AND (groups.name LIKE '%$keyword%' ESCAPE '!')";
            }

            if (! empty($where)) {
                $totalRecordwithFilter = $this->dt->ajaxGetGroupsPermissionsDt(1, '', '', $where);
            }

            $records = $this->dt->ajaxGetGroupsPermissionsDt(0, $rowperpage, $start, $where, $columnSortOrder, $columnName);
            $data = array();
            $i = $start+1;

            foreach($records as $record ){
                $actions = $subAction = $status = '';

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

                if ($record['status'] == 'Active') {
                    $status .= '<a href="javascript:void(0)" data-id="'. $record['id'] .'" data-status="2" class="change-status"><span class="badge badge-success">Active</span></a>';
                } else {
                    $status .= '<a href="javascript:void(0)" data-id="'. $record['id'] .'" data-status="1" class="change-status"><span class="badge badge-warning">Inactive</span></a>';
                }



                $data[] = array(
                    "id" => $i++,
                    "group-name" => $record['name'],
                    "status" => $status,
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

     function ajaxGetGroupsPermissionsDetails()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            if (!empty($id = $this->request->getPost('id')) && !empty($details = $this->crud->select('groups', '', ['id' => $id], '', 1))) {
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

     function attemptToDeleteGroupPermissions()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        $ids = [];
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            foreach ($this->request->getPost('ids') as $id) {
                if (!empty($id)) {
                    $this->crud->deleteData('groups', ['id' => $id]);
                }
            }
            $this->data['success'] = true;
            $this->data['message'] = 'groups has been succesfully deleted.';
            return $this->response->setJSON($this->data);
        } else {
            $this->data['message'] = 'Something went wrong!';
            return $this->response->setJSON($this->data);
        }
    }

    function attemptToChangeStatusGroupPermissions()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        $ids = [];
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            if (!empty($this->request->getPost('id')) && $this->crud->updateData('groups', ['id' => $this->request->getPost('id')], ['status' => $this->request->getPost('status')])) {
                $this->data['success'] = true;
                $this->data['message'] = 'Status has been succesfully changed.';
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


    function saveUser()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();

        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            $user_id = 0;
            if($this->request->getPost('user_id') !=0){
                $user_id = decrypt($this->request->getPost('user_id'));
            }
            if ($this->request->getPost('user_id') == 0) {
                $rules = [
                    'user_name'              => ['label' => 'User Name  ', 'rules' => 'required|is_unique[users.user_name]'],
                    'name'                  => ['label' => 'Name', 'rules' => 'required'],
                    'phone'                 => ['label' => 'Mobile', 'rules' => 'required'],
                    'email'                   => ['label' => 'Student Email', 'rules' => 'required|is_unique[users.email]'],
                    'password'              => ['label' => 'Password', 'rules' => 'required'],
                    'confirm_password'      => ['label' => 'Confirm password', 'rules' => 'required|matches[password]'],
                    'group_id'               => ['label' => 'User Group', 'rules' => 'required'],
                    'designation_id'               => ['label' => 'Designation', 'rules' => 'required'],
                    'department_id'               => ['label' => 'Department', 'rules' => 'required'],
                    'address'               => ['label' => 'Address', 'rules' => 'required'],
                ];
           }else{
                 $rules = [
                    'user_name'              => ['label' => 'User Name  ', 'rules' => 'required|is_unique[users.user_name,id,'.$user_id.']'],
                    'name'                  => ['label' => 'Name', 'rules' => 'required'],
                    'email'                 => ['label' => 'Email', 'rules' => 'required|is_unique[users.email,id,'.$user_id.']'],
                    'phone'                 => ['label' => 'Mobile', 'rules' => 'required'],
                    'group_id'               => ['label' => 'User Group', 'rules' => 'required'],
                    'designation_id'               => ['label' => 'Designation', 'rules' => 'required'],
                    'department_id'               => ['label' => 'Department', 'rules' => 'required'],
                    'address'               => ['label' => 'Address', 'rules' => 'required'],
                ];
           }

            $errors = [];
            if ($this->validate($rules, $errors)) {

                if ($this->request->getPost('user_id') == 0) {
                    $userData = [
                        'user_name'                => trim($this->request->getPost('user_name')),
                        'email'                   => trim($this->request->getPost('email')),
                        'group_id'               => trim($this->request->getPost('group_id')),
                        'password_hash'         => password_hash($this->request->getPost('confirm_password'),PASSWORD_DEFAULT),
                        'created_at'              => time(),
                    ];
                }else{
                    $userData = [
                        'user_name'                => trim($this->request->getPost('user_name')),
                        'email'                   => trim($this->request->getPost('email')),
                        'group_id'               => trim($this->request->getPost('group_id')),
                        'created_at'              => time(),
                    ];
                }

                $detailsData = [
                    'name'                      => trim($this->request->getPost('name')),
                    'phone'                     => trim($this->request->getPost('phone')),
                    'alternative_phone'         => trim($this->request->getPost('alternative_phone')),
                    'dob'        => strtotime($this->request->getPost('dob')),
                    'address'    => trim($this->request->getPost('address')),
                    'designation_id'               => trim($this->request->getPost('designation_id')),
                    'department_id'               => trim($this->request->getPost('department_id')),
                
                ];

                if ($this->request->getPost('user_id') == 0){
                    $lastId = $this->crud->add('users', $userData);
                    $detailsData['parent_id'] = $lastId;
                    $this->crud->add('user_details', $detailsData);
                    $this->data['success'] = true;
                    $this->data['message'] = 'User  has been successfully added.';
                    return $this->response->setJSON($this->data);
                } else {
                    $this->crud->updateData('users', ['id' => $user_id], $userData);
                    $this->crud->updateData('user_details', ['parent_id' => $user_id], $detailsData);
                    $this->data['success'] = true;
                    $this->data['message'] = 'User  has been update successfully updated.';
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

    function ajaxGetuserDt()
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
                $columnName = 'users.id';
                break;
                case 'name':
                $columnName = 'name.name';
                break;
                case 'email':
                $columnName = 'email.email';
                break;
                case 'department_id':
                $columnName = 'department_id.department_id';
                break;
                case 'group_id':
                $columnName = 'group_id.group_id';
                break;
                case 'designation_id':
                $columnName = 'designation_id.designation_id';
                break;
                case 'active':
                $columnName = 'active.active';
                break;
                default:
                $columnName = 'users.id';
                break;
            }

            $totalRecords = $totalRecordwithFilter = $this->dt->ajaxGetuserDt(1);


            if (!empty($keyword)) {
                $where .= empty($where) ? "(md2.title LIKE '%$keyword%' ESCAPE '!' OR master_data.search_tags LIKE '%$keyword%' ESCAPE '!')" : " AND (md2.title LIKE '%$keyword%' ESCAPE '!' OR master_data.search_tags LIKE '%$keyword%' ESCAPE '!')";
            }

            if (!empty($where)) {
                $totalRecordwithFilter = $this->dt->ajaxGetuserDt(1, '', '', $where);
            }

            $records = $this->dt->ajaxGetuserDt(0, $rowperpage, $start, $where, $columnSortOrder, $columnName);
            $data = array();
             $i = $start+1;

            foreach ($records as $record) {
                $actions = $subAction  = $status ='';

             

                $subAction .= '<a href="' . site_url('auth/edit/' .encrypt($record['id'])) . '" class="dropdown-item"><i class="ft-edit-2 success"></i> Edit</a>';
                $subAction .= '<a href="javascript:void(0)" data-id="' . $record['id'] . '" class="dropdown-item delete-row"><i class="ft-trash-2 danger"></i> Delete</a>';
                 $subAction .= '<a href="javascript:void(0)" data-toggle="modal" data-target="#modal-user-password-update" data-id="' . $record['id'] . '" class="dropdown-item"><i class="ft-edit-2 success"></i> Edit password</a>';

                $actions = '<span class="dropdown">
                <button id="btnSearchDrop12" type="button" class="btn btn-sm btn-icon btn-pure font-medium-2" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                <i class="ft-more-vertical"></i>
                </button>
                <span aria-labelledby="btnSearchDrop12" class="dropdown-menu mt-1 dropdown-menu-right">
                ' . $subAction . '
                </span>
                </span>';

                if ($record['active'] == 'Y') {
                    $status .= '<a href="javascript:void(0)" data-id="'. $record['id'] .'" data-status="2" class="change-status"><span class="badge badge-success">Active</span></a>';
                } else {
                    $status .= '<a href="javascript:void(0)" data-id="'. $record['id'] .'" data-status="1" class="change-status"><span class="badge badge-warning">Inactive</span></a>';
                }



                $data[] = array(
                    "id" => $i++,
                    "name" => $record['name'],
                    "email" => $record['email'],
                 //   "address" => $record['address'],
                    "department" => $record['department'],
                    "gr" => $record['gr'],
                    "designation" => $record['designation'],
                      "active" => $status,                    
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

    function editUser($id)
    {
        if (session()->isLoggedIn && $this->request->getMethod() == 'get' && ! $this->request->isAJAX()) {
            $this->data['title'] = ' Application - User Management';
          $this->data['user_details'] = $data['user_details']=$user_details= $this->dt->getUserById(decrypt($id));
           // print_r($user_details);die;
             $this->data['deparment']=$data['deparment']=$deparment = $this->common->getMasterData(18);
            $this->data['designation'] =$data['designation']=$designation= $this->common->getMasterData(19);
            $this->data['groups'] =$data['groups']=$groups= $this->common->getGroups();
         
            return view('auth/manage-user', $this->data);
        } else {
            return redirect()->route('dashboard');
        }
    }

    function attemptToDeleteUser()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        $ids = [];
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            foreach ($this->request->getPost('ids') as $id) {
                if (!empty($id)) {
                    $this->crud->updateData('users', ['id' => $id], ['deleted' => 'Y']);
                    $this->crud->deleteData('user_details', ['id' => $id]);
                }
            }
            $this->data['success'] = true;
            $this->data['message'] = 'Users has been succesfully deleted.';
            return $this->response->setJSON($this->data);
        } else {
            $this->data['message'] = 'Something went wrong!';
            return $this->response->setJSON($this->data);
        }
    }

    function UpdateUserPassword()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            $rules = [
                
                'update_password'               => ['label' => 'Update Password', 'rules' => 'required'],
   
            ];
            $errors = [];
            if ($this->validate($rules, $errors)) {
                $authArr = [
                    'password_hash'         => trim(password_hash($this->request->getPost('update_password'), PASSWORD_DEFAULT),),
                    'updated_at'            => time(),
                ];

                if ($lastId = $this->crud->updateData('users', ['id' => $this->request->getPost('id')], $authArr)) {
                    $this->data['success'] = true;
                    $this->data['message'] = 'password has been successfully updated.';
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

    function attemptToChangeStatusUser()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();

        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            if (!empty($this->request->getPost('id')) && $this->crud->updateData('users', ['id' => $this->request->getPost('id')], ['active' => $this->request->getPost('status')])) {
                $this->data['success'] = true;
                $this->data['message'] = 'Status has been succesfully changed.';
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







}