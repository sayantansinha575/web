<?php
namespace App\Controllers;
use App\Controllers\BaseController;

class Auth extends BaseController
{
    
    public function __construct()
    {
       
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
        return redirect()->to('login');
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

    function groupsNPermissions()
    {
        if (session()->isLoggedIn && $this->request->getMethod() == 'get' && ! $this->request->isAJAX()) {
            $this->data['title'] = 'Groups & Permissions - '.setting('App.siteName');
            return view('auth/groups-n-permissions', $this->data);
        } else {
            return redirect()->route('dashboard');
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
                    "id" => $record['id'],
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




}