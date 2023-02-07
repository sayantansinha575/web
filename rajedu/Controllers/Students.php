<?php
namespace App\Controllers;
use App\Controllers\BaseController;

class Students extends BaseController
{

    public function __construct()
    {
        $db = db_connect();
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
                $columnName = 'users.id';
                break;
                case 'name':
                $columnName = 'name.name';
                break;
                case 'email':
                $columnName = 'email.email';
                break;
                case 'phone':
                $columnName = 'phone.phone';
                break;
                default:
                $columnName = 'users.id';
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


                $data[] = array(
                    "id" => $record['id'],
                    "name" => $record['name'],
                    "email" => $record['email'],
                    "phone" => $record['phone'],
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
                'phone'                   => ['label' => 'Student Phone ', 'rules' => 'required'],
            ];

            $errors = [];
            if ($this->validate($rules, $errors)) {

                $Userdata = [

                    'email'                   => trim($this->request->getPost('email')),
                    'group_id' => 3,
                    'created_at'              => time(),

                ];

                $Detailsdata = [

                    'name'                        => trim($this->request->getPost('name')),
                    'phone'                       => trim($this->request->getPost('phone')),

                ];


                if ($lastId = $this->crud->add('users', $Userdata)){
                    $Detailsdata['parent_id'] = $lastId;
                    $this->crud->add('user_details', $Detailsdata);
                    $this->data['success'] = true;
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
}