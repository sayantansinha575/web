<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Associate_model;
use App\Models\Bank_model;

class Associate extends BaseController
{

    public function __construct()
    {
        $db = db_connect();
        $this->associate = new Associate_model($db);
        $this->bank = new Bank_model($db);
    }


    function associateList()
    {
        if (session()->isLoggedIn && $this->request->getMethod() == 'get' && !$this->request->isAJAX()) {
            $this->data['title'] = 'Associate list - ' . setting('App.siteName');
            return view('associate/associate-list', $this->data);
        } else {
            return redirect()->route('dashboard');
        }
    }


    function attemptToSaveAssociate()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            if (empty($this->request->getPost('id'))) {
                $rules = [
                    'user_name'             => ['label' => 'User name', 'rules' => 'required|is_unique[users.user_name]'],
                    'email'                 => ['label' => 'Email', 'rules' => 'required|is_unique[users.email]'],
                    'password'              => ['label' => 'Password', 'rules' => 'required'],
                    'confirm_password'      => ['label' => 'Confirm password', 'rules' => 'required|matches[password]'],
                    'name'                  => ['label' => 'Name', 'rules' => 'required'],
                    'phone'                 => ['label' => 'Phone', 'rules' => 'required'],
                    'address'               => ['label' => 'Address', 'rules' => 'required'],
                    'file'                  => ['label' => 'User image', 'rules' => 'ext_in[file,png,jpg,jpeg]|max_size[file,2048]'],

                ];
            } else {
                $rules = [
                    'user_name'             => ['label' => 'User name', 'rules' => 'required|is_unique[users.user_name,id,{id}]'],
                    'email'                 => ['label' => 'Email', 'rules' => 'required|is_unique[users.email,id,{id}]'],
                    'name'                  => ['label' => 'Name', 'rules' => 'required'],
                    'phone'                 => ['label' => 'Phone', 'rules' => 'required'],
                    'address'               => ['label' => 'Address', 'rules' => 'required'],
                    'file'                  => ['label' => 'User image', 'rules' => 'ext_in[file,png,jpg,jpeg]|max_size[file,2048]'],

                ];
            }
            $errors = [];
            if ($this->validate($rules, $errors)) {
                $authArr = [
                    'group_id'                  => 2,
                    'user_name'                 => trim($this->request->getPost('user_name')),
                    'email'                     => trim($this->request->getPost('email')),
                ];

                $DetailsArr = array(
                    'name'                      => trim($this->request->getPost('name')),
                    'phone'                     => trim($this->request->getPost('phone')),
                    'alternative_phone'         => trim($this->request->getPost('number')),
                    'establishment_date'        => strtotime($this->request->getPost('date')),
                    'address'                   => trim($this->request->getPost('address')),
                );

                if (empty($this->request->getPost('id'))) {
                    $authArr['created_at'] = time();
                    $authArr['password_hash'] = trim(password_hash($this->request->getPost('confirm_password'), PASSWORD_DEFAULT),);
                    if ($lastId = $this->crud->add('users', $authArr)) {
                        $DetailsArr['parent_id'] = $lastId;

                        #INIT SCRIPT OF UPLOAD
                        $userImage = $this->request->getFile('file');
                        if ($userImage->isValid()) {
                            $userImageArr = upload('file', USER_DP_UPLOAD_PATH);
                            $DetailsArr['display_picture'] = $userImageArr['encryptedName'];
                        }
                        #ENDS

                        $this->crud->add('user_details', $DetailsArr);
                        $this->data['success'] = true;
                        $this->data['message'] = 'Associate has been successfully added.';
                        return $this->response->setJSON($this->data);
                    } else {
                        $this->data['message'] = 'Something went wrong.';
                        return $this->response->setJSON($this->data);
                    }
                } else {
                    $authArr['updated_at'] = time();
                    unset($authArr['group_id']);
                    if ($lastId = $this->crud->updateData('users', ['id' => $this->request->getPost('id'), 'group_id' => 2], $authArr)) {

                        #INIT SCRIPT OF UPLOAD
                        $userImage = $this->request->getFile('file');
                        if ($userImage->isValid()) {
                            $userImageArr = upload('file', USER_DP_UPLOAD_PATH);
                            $DetailsArr['display_picture'] = $userImageArr['encryptedName'];
                        }
                        #ENDS

                        $this->crud->updateData('user_details', ['parent_id' => $this->request->getPost('id')], $DetailsArr);
                        $this->data['success'] = true;
                        $this->data['message'] = 'Associate has been successfully updated.';
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

    function attemptToUdateAssociatePassword()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            $rules = [
                'id'                            => ['label' => 'Update ID', 'rules' => 'required|numeric'],
                'update_password'               => ['label' => 'Password', 'rules' => 'required'],
                'update_confirm_password'       => ['label' => 'Confirm password', 'rules' => 'required|matches[update_password]'],
            ];
            $errors = [];
            if ($this->validate($rules, $errors)) {
                $authArr = [
                    'password_hash'         => trim(password_hash($this->request->getPost('update_confirm_password'), PASSWORD_DEFAULT),),
                    'updated_at'            => time(),
                ];

                if ($lastId = $this->crud->updateData('users', ['id' => $this->request->getPost('id'), 'group_id' => 2], $authArr)) {
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

    function attemptToSaveAssociateBankDetails()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            $rules = [
                'account_no'                    => ['label' => 'A/C No ', 'rules' => 'required'],
                'account_name'                  => ['label' => 'Account Name ', 'rules' => 'required'],
                'ifsc_code'                     => ['label' => 'IFSC Code ', 'rules' => 'required'],
                'pan_card'                      => ['label' => 'PAN Card No', 'rules' => 'required'],
                'is_primary'                    => ['label' => 'Primary', 'rules' => 'required'],
                'pan_card_file'                 => ['label' => 'Upload PAN Card', 'rules' => 'ext_in[pan_card_file,png,jpg,jpeg]|max_size[pan_card_file,2048]'],

            ];

            $errors = [];
            if ($this->validate($rules, $errors)) {

                $data = array(
                    'account_no'                        => trim($this->request->getPost('account_no')),
                    'account_name'                      => trim($this->request->getPost('account_name')),
                    'ifsc_code'                         => trim($this->request->getPost('ifsc_code')),
                    'pan_no'                          =>  trim($this->request->getPost('pan_card')),
                    'is_primary'                        => trim($this->request->getPost('is_primary')),
                    'user_id'                           => $this->request->getPost('id'),
                    'created_at'                           => time(),
                );

                #INIT SCRIPT OF UPLOAD
                $panCard = $this->request->getFile('pan_card_file');
                if ($panCard->isValid()) {
                    $panCardArr = upload('pan_card_file', UPLOAD_PATH.'associate/pan-card/');
                    $data['pan_card'] = $panCardArr['encryptedName'];
                }
                #ENDS


                if ($lastId = $this->crud->add('bank_details', $data)){

                    $this->data['success'] = true;
                    $this->data['message'] = 'Bank Details has been successfully added.';
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


    function ajaxGetAssociateDt()
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
                case 'user_name':
                    $columnName = 'user_name.user_name';
                    break;
                case 'email':
                    $columnName = 'email.email';
                    break;
                case 'name':
                    $columnName = 'name.name';
                    break;
                case 'phone':
                    $columnName = 'phone.phone';
                    break;
                case 'date':
                    $columnName = 'establishment_date.date';
                default:
                    $columnName = 'users.id';
                    break;
            }

            $totalRecords = $totalRecordwithFilter = $this->dt->ajaxGetAssociateDt(1);


            if (!empty($keyword)) {
                $where .= empty($where) ? "(md2.title LIKE '%$keyword%' ESCAPE '!' OR master_data.search_tags LIKE '%$keyword%' ESCAPE '!')" : " AND (md2.title LIKE '%$keyword%' ESCAPE '!' OR master_data.search_tags LIKE '%$keyword%' ESCAPE '!')";
            }

            if (!empty($where)) {
                $totalRecordwithFilter = $this->dt->ajaxGetAssociateDt(1, '', '', $where);
            }

            $records = $this->dt->ajaxGetAssociateDt(0, $rowperpage, $start, $where, $columnSortOrder, $columnName);
            $data = array();

            foreach ($records as $record) {
                $actions = $subAction = $status = '';

                if ($record['active'] == 'Y') {
                    $status .= '<a href="javascript:void(0)" data-id="' . $record['id'] . '" data-status="N" class="change-status"><span class="badge badge-success">Active</span></a>';
                } else {
                    $status .= '<a href="javascript:void(0)" data-id="' . $record['id'] . '" data-status="Y" class="change-status"><span class="badge badge-warning">Inactive</span></a>';
                }

                $subAction .= '<a href="' . site_url('associate/edit/' . $record['id']) . '" class="dropdown-item"><i class="ft-edit-2 success"></i> Edit</a>';
                $subAction .= '<a href="javascript:void(0)" data-id="' . $record['id'] . '" class="dropdown-item delete-row"><i class="ft-trash-2 danger"></i> Delete</a>';

                $actions = '<span class="dropdown">
                <button id="btnSearchDrop12" type="button" class="btn btn-sm btn-icon btn-pure font-medium-2" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                <i class="ft-more-vertical"></i>
                </button>
                <span aria-labelledby="btnSearchDrop12" class="dropdown-menu mt-1 dropdown-menu-right">
                ' . $subAction . '
                </span>
                </span>';



                $data[] = array(
                    "id" => $record['id'],
                    "name" => $record['name'],
                    "email" => $record['email'],
                    "user_name" => $record['user_name'],
                    "status" => $status,
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


    function editAssociate($id = 0)
    {
        if (session()->isLoggedIn && $this->request->getMethod() == 'get' && !$this->request->isAJAX()) {
            if (!empty($id) && !empty($details = $this->associate->getAssociateDataById($id))) {
                $this->data['title'] = 'Edit Associate';
                $this->data['result'] = $details;
                $this->data['bankAccounts'] = $this->bank->getList();
                // pr( $this->data['bankAccounts']);
                return view('associate/edit-associate', $this->data);
            } else {
                return redirect()->route('dashboard');
            }
        } else {
            return redirect()->route('dashboard');
        }
    }   



    function attemptToDeleteAssociate()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        $ids = [];
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            foreach ($this->request->getPost('ids') as $id) {
                if (!empty($id)) {
                    $this->crud->deleteData('users', ['id' => $id, 'group_id' => 2]);
                     $this->crud->deleteData('user_details', ['parent_id' => $id]);
                }
            }
            $this->data['success'] = true;
            $this->data['message'] = 'Associate has been succesfully deleted.';
            return $this->response->setJSON($this->data);
        } else {
            $this->data['message'] = 'Something went wrong!';
            return $this->response->setJSON($this->data);
        }
    }

    function attemptToChangeStatusAssociate()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        $ids = [];
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
