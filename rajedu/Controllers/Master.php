<?php
namespace App\Controllers;
use App\Controllers\BaseController;

class Master extends BaseController
{

    public function __construct()
    {
        $db = db_connect();
    }


    function typeOfDegree()
    {
        if (session()->isLoggedIn && $this->request->getMethod() == 'get' && ! $this->request->isAJAX()) {
            $this->data['title'] = 'Type of Degree - '.setting('App.siteName');
            return view('master/type-of-degree', $this->data);
        } else {
            return redirect()->route('dashboard');
        }
    }


    function attemptToSaveTypeOfDegree()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            $rules = [
                'degree_type'           => ['label' => 'Degree Type', 'rules' => 'required'],
                'status'                => ['label' => 'Status', 'rules' => 'required|in_list[Active, Inactive]'],
            ];
            $errors = [];
            if ($this->validate($rules, $errors)) {
                $data = array(
                    'title'             => trim($this->request->getPost('degree_type')),
                    'status'            => $this->request->getPost('status'),
                );

                if (empty($this->request->getPost('id'))) {
                    $data['created_by'] = session()->userData['id'];
                    $data['type'] = 1;
                    $data['created_at'] = time();
                    if ($lastId = $this->crud->add('master_data', $data)) {
                        $this->data['success'] = true;
                        $this->data['message'] = 'Type of degree has been successfully added.';
                        return $this->response->setJSON($this->data);
                    } else {
                        $this->data['message'] = 'Something went wrong.';
                        return $this->response->setJSON($this->data);
                    }
                } else {
                    $data['updated_at'] = time();
                    if ($lastId = $this->crud->updateData('master_data', ['id' => $this->request->getPost('id'), 'type' => 1], $data)) {
                        $this->data['success'] = true;
                        $this->data['message'] = 'Type of degree has been successfully updated.';
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


    function ajaxGetTypeOfDegreeDt()
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
                $columnName = 'master_data.id';
                break;
                case 'type':
                $columnName = 'master_data.title';
                break;
                case 'status':
                $columnName = 'master_data.status';
                break;
                default:
                $columnName = 'master_data.id';
                break;
            }

            $totalRecords = $totalRecordwithFilter = $this->dt->ajaxGetTypeOfDegreeDt(1);

            
            if (! empty($keyword)) {
                $where .= empty($where)?"(master_data.title LIKE '%$keyword%' ESCAPE '!')":" AND (master_data.title LIKE '%$keyword%' ESCAPE '!')";
            }

            if (! empty($where)) {
                $totalRecordwithFilter = $this->dt->ajaxGetTypeOfDegreeDt(1, '', '', $where);
            }

            $records = $this->dt->ajaxGetTypeOfDegreeDt(0, $rowperpage, $start, $where, $columnSortOrder, $columnName);
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
                    "type" => $record['title'],
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


    function attemptToDeleteTypeOfDegree()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        $ids = [];
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            foreach ($this->request->getPost('ids') as $id) {
                if (!empty($id)) {
                    $this->crud->deleteData('master_data', ['id' => $id, 'type' => 1]);
                }
            }
            $this->data['success'] = true;
            $this->data['message'] = 'Type of degree has been succesfully deleted.';
            return $this->response->setJSON($this->data);
        } else {
            $this->data['message'] = 'Something went wrong!';
            return $this->response->setJSON($this->data);
        }
    }


    function attemptToChangeStatusTypeOfDegree()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        $ids = [];
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            if (!empty($this->request->getPost('id')) && $this->crud->updateData('master_data', ['id' => $this->request->getPost('id'), 'type' => 1], ['status' => $this->request->getPost('status')])) {
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


    function ajaxGetTypeOfDegreeDetails()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            if (!empty($id = $this->request->getPost('id')) && !empty($details = $this->crud->select('master_data', '', ['id' => $id, 'type' => 1], '', 1))) {
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


    function universityPrograms()
    {
        if (session()->isLoggedIn && $this->request->getMethod() == 'get' && ! $this->request->isAJAX()) {
            $this->data['title'] = 'University Programs - '.setting('App.siteName');
            return view('master/university-programs', $this->data);
        } else {
            return redirect()->route('dashboard');
        }
    }


    function attemptToSaveUniversityPrograms()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            $rules = [
                'program_name'           => ['label' => 'Program name', 'rules' => 'required'],
                'status'                => ['label' => 'Status', 'rules' => 'required|in_list[Active, Inactive]'],
            ];
            $errors = [];
            if ($this->validate($rules, $errors)) {
                $data = array(
                    'title'             => trim($this->request->getPost('program_name')),
                    'status'            => $this->request->getPost('status'),
                );

                if (empty($this->request->getPost('id'))) {
                    $data['created_by'] = session()->userData['id'];
                    $data['type'] = 2;
                    $data['created_at'] = time();
                    if ($lastId = $this->crud->add('master_data', $data)) {
                        $this->data['success'] = true;
                        $this->data['message'] = 'University program has been successfully added.';
                        return $this->response->setJSON($this->data);
                    } else {
                        $this->data['message'] = 'Something went wrong.';
                        return $this->response->setJSON($this->data);
                    }
                } else {
                    $data['updated_at'] = time();
                    if ($lastId = $this->crud->updateData('master_data', ['id' => $this->request->getPost('id'), 'type' => 2], $data)) {    
                        $this->data['success'] = true;
                        $this->data['message'] = 'University program has been successfully updated.';
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


    function ajaxGetUniversityProgramsDt()
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
                $columnName = 'master_data.id';
                break;
                case 'type':
                $columnName = 'master_data.title';
                break;
                case 'status':
                $columnName = 'master_data.status';
                break;
                default:
                $columnName = 'master_data.id';
                break;
            }

            $totalRecords = $totalRecordwithFilter = $this->dt->ajaxGetUniversityProgramsDt(1);


            if (! empty($keyword)) {
                $where .= empty($where)?"(master_data.title LIKE '%$keyword%' ESCAPE '!')":" AND (master_data.title LIKE '%$keyword%' ESCAPE '!')";
            }

            if (! empty($where)) {
                $totalRecordwithFilter = $this->dt->ajaxGetUniversityProgramsDt(1, '', '', $where);
            }

            $records = $this->dt->ajaxGetUniversityProgramsDt(0, $rowperpage, $start, $where, $columnSortOrder, $columnName);
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
                    "program" => $record['title'],
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


    function ajaxGetUniversityProgramsDetails()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            if (!empty($id = $this->request->getPost('id')) && !empty($details = $this->crud->select('master_data', '', ['id' => $id, 'type' => 2], '', 1))) {
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


    function attemptToDeleteUniversityPrograms()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        $ids = [];
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            foreach ($this->request->getPost('ids') as $id) {
                if (!empty($id)) {
                    $this->crud->deleteData('master_data', ['id' => $id, 'type' => 2]);
                }
            }
            $this->data['success'] = true;
            $this->data['message'] = 'University program has been succesfully deleted.';
            return $this->response->setJSON($this->data);
        } else {
            $this->data['message'] = 'Something went wrong!';
            return $this->response->setJSON($this->data);
        }
    }


    function attemptToChangeStatusUniversityPrograms()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        $ids = [];
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            if (!empty($this->request->getPost('id')) && $this->crud->updateData('master_data', ['id' => $this->request->getPost('id'), 'type' => 2], ['status' => $this->request->getPost('status')])) {
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


    function intake()
    {
        if (session()->isLoggedIn && $this->request->getMethod() == 'get' && ! $this->request->isAJAX()) {
            $this->data['title'] = 'Intake - '.setting('App.siteName');
            return view('master/intake', $this->data);
        } else {
            return redirect()->route('dashboard');
        }
    }


    function attemptToSaveIntake()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            $rules = [
                'intake_prefix'           => ['label' => 'Prefix name', 'rules' => 'required|in_list[SP, FA, SU]'],
                'intake_year'           =>['label' => 'Year name', 'rules' => 'required'],
                'status'                => ['label' => 'Status', 'rules' => 'required|in_list[Active, Inactive]'],
            ];
            $errors = [];
            if ($this->validate($rules, $errors)) {
                $data = array(
                    'intake_prefix'             => trim($this->request->getPost('intake_prefix')),
                    'intake_year'               =>trim($this->request->getPost('intake_year')),
                    'status'                    => $this->request->getPost('status'),
                );

                if (empty($this->request->getPost('id'))) {
                    $data['created_by'] = session()->userData['id'];
                    $data['type'] = 4;
                    $data['created_at'] = time();
                    if ($lastId = $this->crud->add('master_data', $data)) {
                        $this->data['success'] = true;
                        $this->data['message'] = 'Intake has been successfully added.';
                        return $this->response->setJSON($this->data);
                    } else {
                        $this->data['message'] = 'Something went wrong.';
                        return $this->response->setJSON($this->data);
                    }
                } else {
                    $data['updated_at'] = time();
                    if ($lastId = $this->crud->updateData('master_data', ['id' => $this->request->getPost('id'), 'type' => 4], $data)) {
                        $this->data['success'] = true;
                        $this->data['message'] = 'Intake has been successfully updated.';
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


    function ajaxGetIntakeDt()
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
                $columnName = 'master_data.id';
                break;
                case 'type':
                $columnName = 'master_data.title';
                break;
                case 'status':
                $columnName = 'master_data.status';
                break;
                default:
                $columnName = 'master_data.id';
                break;
            }

            $totalRecords = $totalRecordwithFilter = $this->dt->ajaxGetIntakeDt(1);


            if (! empty($keyword)) {
                $where .= empty($where)?"(master_data.title LIKE '%$keyword%' ESCAPE '!')":" AND (master_data.title LIKE '%$keyword%' ESCAPE '!')";
            }

            if (! empty($where)) {
                $totalRecordwithFilter = $this->dt->ajaxGetIntakeDt(1, '', '', $where);
            }

            $records = $this->dt->ajaxGetIntakeDt(0, $rowperpage, $start, $where, $columnSortOrder, $columnName);
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
                    "prefix" => $record['intake_prefix'],
                    "year" => $record['intake_year'],
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


    function ajaxGetIntakeDetails()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            if (!empty($id = $this->request->getPost('id')) && !empty($details = $this->crud->select('master_data', '', ['id' => $id, 'type' => 4], '', 1))) {
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


    function attemptToDeleteIntake()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        $ids = [];
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            foreach ($this->request->getPost('ids') as $id) {
                if (!empty($id)) {
                    $this->crud->deleteData('master_data', ['id' => $id, 'type' => 4]);
                }
            }
            $this->data['success'] = true;
            $this->data['message'] = 'Intake has been succesfully deleted.';
            return $this->response->setJSON($this->data);
        } else {
            $this->data['message'] = 'Something went wrong!';
            return $this->response->setJSON($this->data);
        }
    }


    function attemptToChangeStatusIntake()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        $ids = [];
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            if (!empty($this->request->getPost('id')) && $this->crud->updateData('master_data', ['id' => $this->request->getPost('id'), 'type' => 4], ['status' => $this->request->getPost('status')])) {
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


    function attemptToSaveStatus()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            $rules = [
                'status_name'           => ['label' => 'status name', 'rules' => 'required'],

                'status'                => ['label' => 'Status', 'rules' => 'required|in_list[Active, Inactive]'],
            ];
            $errors = [];
            if ($this->validate($rules, $errors)) {
                $data = array(
                    'title'             => trim($this->request->getPost('status_name')),
                    'status'                    => $this->request->getPost('status'),
                );

                if (empty($this->request->getPost('id'))) {
                    $data['created_by'] = session()->userData['id'];
                    $data['type'] = 5;
                    $data['created_at'] = time();
                    if ($lastId = $this->crud->add('master_data', $data)) {
                        $this->data['success'] = true;
                        $this->data['message'] = 'Status has been successfully added.';
                        return $this->response->setJSON($this->data);
                    } else {
                        $this->data['message'] = 'Something went wrong.';
                        return $this->response->setJSON($this->data);
                    }
                } else {
                    $data['updated_at'] = time();
                    if ($lastId = $this->crud->updateData('master_data', ['id' => $this->request->getPost('id'), 'type' => 5], $data)) {
                        $this->data['success'] = true;
                        $this->data['message'] = 'Status has been successfully updated.';
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


    function ajaxGetStatusDt()
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
                $columnName = 'master_data.id';
                break;
                case 'status_name':
                $columnName = 'master_data.title';
                break;
                case 'status':
                $columnName = 'master_data.status';
                break;
                default:
                $columnName = 'master_data.id';
                break;
            }

            $totalRecords = $totalRecordwithFilter = $this->dt->ajaxGetStatusDt(1);


            if (! empty($keyword)) {
                $where .= empty($where)?"(master_data.title LIKE '%$keyword%' ESCAPE '!')":" AND (master_data.title LIKE '%$keyword%' ESCAPE '!')";
            }

            if (! empty($where)) {
                $totalRecordwithFilter = $this->dt->ajaxGetStatusDt(1, '', '', $where);
            }

            $records = $this->dt->ajaxGetStatusDt(0, $rowperpage, $start, $where, $columnSortOrder, $columnName);
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
                    "status_name" => $record['title'],
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


    function ajaxGetStatusDetails()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            if (!empty($id = $this->request->getPost('id')) && !empty($details = $this->crud->select('master_data', '', ['id' => $id, 'type' => 5], '', 1))) {
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


    function attemptToDeleteStatus()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        $ids = [];
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            foreach ($this->request->getPost('ids') as $id) {
                if (!empty($id)) {
                    $this->crud->deleteData('master_data', ['id' => $id, 'type' => 5]);
                }
            }
            $this->data['success'] = true;
            $this->data['message'] = 'Status has been succesfully deleted.';
            return $this->response->setJSON($this->data);
        } else {
            $this->data['message'] = 'Something went wrong!';
            return $this->response->setJSON($this->data);
        }
    }


    function attemptToChangeStatusStatus()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        $ids = [];
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            if (!empty($this->request->getPost('id')) && $this->crud->updateData('master_data', ['id' => $this->request->getPost('id'), 'type' => 5], ['status' => $this->request->getPost('status')])) {
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


    function search()
    {
        if (session()->isLoggedIn && $this->request->getMethod() == 'get' && ! $this->request->isAJAX()) {
            $this->data['title'] = 'Search-tags - '.setting('App.siteName');
            $this->data['programs'] = $this->crud->select('master_data', '', ['type' => 2, 'status' => 'Active']);
            return view('master/search-tags', $this->data);
        } else {
            return redirect()->route('dashboard');
        }
    }

    function attemptToSaveSearch()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            $rules = [
                'program-name'           => ['label' => 'Program name', 'rules' => 'required'],
                'search-tag'           => ['label' => 'Search-tag name', 'rules' => 'required'], 
                'status'                => ['label' => 'Status', 'rules' => 'required|in_list[Active, Inactive]'],
            ];
            $errors = [];
            if ($this->validate($rules, $errors)) {
                $data = array(
                    'title'             => trim($this->request->getPost('program-name')),
                    'search_tags'             => trim($this->request->getPost('search-tag')),
                    'status'                    => $this->request->getPost('status'),
                );

                if (empty($this->request->getPost('id'))) {
                    $data['created_by'] = session()->userData['id'];
                    $data['type'] = 3;
                    $data['created_at'] = time();
                    if ($lastId = $this->crud->add('master_data', $data)) {
                        $this->data['success'] = true;
                        $this->data['message'] = 'Search-tag has been successfully added.';
                        return $this->response->setJSON($this->data);
                    } else {
                        $this->data['message'] = 'Something went wrong.';
                        return $this->response->setJSON($this->data);
                    }
                } else {
                    $data['updated_at'] = time();
                    if ($lastId = $this->crud->updateData('master_data', ['id' => $this->request->getPost('id'), 'type' => 3], $data)) {
                        $this->data['success'] = true;
                        $this->data['message'] = 'Search-tag has been successfully updated.';
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


    function ajaxGetSearchDt()
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
                $columnName = 'master_data.id';
                break;
                case 'program-name':
                $columnName = 'md2.title';
                break;
                case 'search-tag':
                $columnName = 'master_data.search_tags';
                break;
                case 'status':
                $columnName = 'master_data.status';
                break;
                default:
                $columnName = 'master_data.id';
                break;
            }

            $totalRecords = $totalRecordwithFilter = $this->dt->ajaxGetSearchDt(1);


            if (! empty($keyword)) {
                $where .= empty($where)?"(md2.title LIKE '%$keyword%' ESCAPE '!' OR master_data.search_tags LIKE '%$keyword%' ESCAPE '!')":" AND (md2.title LIKE '%$keyword%' ESCAPE '!' OR master_data.search_tags LIKE '%$keyword%' ESCAPE '!')";
            }

            if (! empty($where)) {
                $totalRecordwithFilter = $this->dt->ajaxGetSearchDt(1, '', '', $where);
            }

            $records = $this->dt->ajaxGetSearchDt(0, $rowperpage, $start, $where, $columnSortOrder, $columnName);
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
                    "program-name" => $record['program_name'],
                    "search-tag" => $record['search_tags'],
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

    function ajaxGetSearchDetails()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            if (!empty($id = $this->request->getPost('id')) && !empty($details = $this->crud->select('master_data', '', ['id' => $id, 'type' => 3], '', 1))) {
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


    function attemptToDeleteSearch()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        $ids = [];
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            foreach ($this->request->getPost('ids') as $id) {
                if (!empty($id)) {
                    $this->crud->deleteData('master_data', ['id' => $id, 'type' => 3]);
                }
            }
            $this->data['success'] = true;
            $this->data['message'] = 'Search-tag has been succesfully deleted.';
            return $this->response->setJSON($this->data);
        } else {
            $this->data['message'] = 'Something went wrong!';
            return $this->response->setJSON($this->data);
        }
    }


    function attemptToChangeStatusSearch()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        $ids = [];
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            if (!empty($this->request->getPost('id')) && $this->crud->updateData('master_data', ['id' => $this->request->getPost('id'), 'type' => 3], ['status' => $this->request->getPost('status')])) {
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


    function status()
    {
        if (session()->isLoggedIn && $this->request->getMethod() == 'get' && ! $this->request->isAJAX()) {
            $this->data['title'] = 'Status - '.setting('App.siteName');
            return view('master/status', $this->data);
        } else {
            return redirect()->route('dashboard');
        }
    }


    function typeOfExam()
    {
        if (session()->isLoggedIn && $this->request->getMethod() == 'get' && ! $this->request->isAJAX()) {
            $this->data['title'] = 'Type of Exam - '.setting('App.siteName');
            return view('master/type-of-exam', $this->data);
        } else {
            return redirect()->route('dashboard');
        }
    }

    function attemptToSaveTypeOfExam()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            $rules = [
                'exam-type'           => ['label' => 'Exam-type name', 'rules' => 'required'],
                'status'                => ['label' => 'Status', 'rules' => 'required|in_list[Active, Inactive]'],
            ];
            $errors = [];
            if ($this->validate($rules, $errors)) {
                $data = array(
                    'title'             => trim($this->request->getPost('exam-type')),
                    'status'                    => $this->request->getPost('status'),
                );

                if (empty($this->request->getPost('id'))) {
                    $data['created_by'] = session()->userData['id'];
                    $data['type'] = 6;
                    $data['created_at'] = time();
                    if ($lastId = $this->crud->add('master_data', $data)) {
                        $this->data['success'] = true;
                        $this->data['message'] = 'Exam-type has been successfully added.';
                        return $this->response->setJSON($this->data);
                    } else {
                        $this->data['message'] = 'Something went wrong.';
                        return $this->response->setJSON($this->data);
                    }
                } else {
                    $data['updated_at'] = time();
                    if ($lastId = $this->crud->updateData('master_data', ['id' => $this->request->getPost('id'), 'type' => 6], $data)) {
                        $this->data['success'] = true;
                        $this->data['message'] = 'Exam-type has been successfully updated.';
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

    function ajaxGetTypeOfExamDt()
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
                $columnName = 'master_data.id';
                break;
                case 'exam-type':
                $columnName = 'md2.title';
                break;
                case 'status':
                $columnName = 'master_data.status';
                break;
                default:
                $columnName = 'master_data.id';
                break;
            }

            $totalRecords = $totalRecordwithFilter = $this->dt->ajaxGetTypeOfExamDt(1);


            if (! empty($keyword)) {
                $where .= empty($where)?"(md2.title LIKE '%$keyword%' ESCAPE '!' OR master_data.search_tags LIKE '%$keyword%' ESCAPE '!')":" AND (md2.title LIKE '%$keyword%' ESCAPE '!' OR master_data.search_tags LIKE '%$keyword%' ESCAPE '!')";
            }

            if (! empty($where)) {
                $totalRecordwithFilter = $this->dt->ajaxGetTypeOfExamDt(1, '', '', $where);
            }

            $records = $this->dt->ajaxGetTypeOfExamDt(0, $rowperpage, $start, $where, $columnSortOrder, $columnName);
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
                    "exam-type" => $record['title'],
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

    function ajaxGetTypeOfExamDetails()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            if (!empty($id = $this->request->getPost('id')) && !empty($details = $this->crud->select('master_data', '', ['id' => $id, 'type' => 6], '', 1))) {
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


    function attemptToDeleteTypeOfExam()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        $ids = [];
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            foreach ($this->request->getPost('ids') as $id) {
                if (!empty($id)) {
                    $this->crud->deleteData('master_data', ['id' => $id, 'type' => 6]);
                }
            }
            $this->data['success'] = true;
            $this->data['message'] = 'Exam-type has been succesfully deleted.';
            return $this->response->setJSON($this->data);
        } else {
            $this->data['message'] = 'Something went wrong!';
            return $this->response->setJSON($this->data);
        }
    }


    function attemptToChangeStatusTypeOfExam()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        $ids = [];
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            if (!empty($this->request->getPost('id')) && $this->crud->updateData('master_data', ['id' => $this->request->getPost('id'), 'type' => 6], ['status' => $this->request->getPost('status')])) {
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


    function testType()
    {
        if (session()->isLoggedIn && $this->request->getMethod() == 'get' && ! $this->request->isAJAX()) {
            $this->data['title'] = 'Test Type - '.setting('App.siteName');
            return view('master/test-type', $this->data);
        } else {
            return redirect()->route('dashboard');
        }
    }


    function attemptToSaveTestType()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            $rules = [
                'test-type'           => ['label' => 'Test-type name', 'rules' => 'required'],
                'status'                => ['label' => 'Status', 'rules' => 'required|in_list[Active, Inactive]'],
            ];
            $errors = [];
            if ($this->validate($rules, $errors)) {
                $data = array(
                    'title'             => trim($this->request->getPost('test-type')),
                    'status'                    => $this->request->getPost('status'),
                );

                if (empty($this->request->getPost('id'))) {
                    $data['created_by'] = session()->userData['id'];
                    $data['type'] = 7;
                    $data['created_at'] = time();
                    if ($lastId = $this->crud->add('master_data', $data)) {
                        $this->data['success'] = true;
                        $this->data['message'] = 'Test-type has been successfully added.';
                        return $this->response->setJSON($this->data);
                    } else {
                        $this->data['message'] = 'Something went wrong.';
                        return $this->response->setJSON($this->data);
                    }
                } else {
                    $data['updated_at'] = time();
                    if ($lastId = $this->crud->updateData('master_data', ['id' => $this->request->getPost('id'), 'type' => 7], $data)) {
                        $this->data['success'] = true;
                        $this->data['message'] = 'Test-type has been successfully updated.';
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


    function ajaxGetTestTypeDt()
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
                $columnName = 'master_data.id';
                break;
                case 'test-type':
                $columnName = 'md2.title';
                break;
                case 'status':
                $columnName = 'master_data.status';
                break;
                default:
                $columnName = 'master_data.id';
                break;
            }

            $totalRecords = $totalRecordwithFilter = $this->dt->ajaxGetTestTypeDt(1);


            if (! empty($keyword)) {
                $where .= empty($where)?"(md2.title LIKE '%$keyword%' ESCAPE '!' OR master_data.search_tags LIKE '%$keyword%' ESCAPE '!')":" AND (md2.title LIKE '%$keyword%' ESCAPE '!' OR master_data.search_tags LIKE '%$keyword%' ESCAPE '!')";
            }

            if (! empty($where)) {
                $totalRecordwithFilter = $this->dt->ajaxGetTestTypeDt(1, '', '', $where);
            }

            $records = $this->dt->ajaxGetTestTypeDt(0, $rowperpage, $start, $where, $columnSortOrder, $columnName);
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
                    "test-type" => $record['title'],
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

     function ajaxGetTestTypeDetails()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            if (!empty($id = $this->request->getPost('id')) && !empty($details = $this->crud->select('master_data', '', ['id' => $id, 'type' => 7], '', 1))) {
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

     function attemptToDeleteTestType()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        $ids = [];
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            foreach ($this->request->getPost('ids') as $id) {
                if (!empty($id)) {
                    $this->crud->deleteData('master_data', ['id' => $id, 'type' => 7]);
                }
            }
            $this->data['success'] = true;
            $this->data['message'] = 'Test-type has been succesfully deleted.';
            return $this->response->setJSON($this->data);
        } else {
            $this->data['message'] = 'Something went wrong!';
            return $this->response->setJSON($this->data);
        }
    }

      function attemptToChangeStatusTestType()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        $ids = [];
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            if (!empty($this->request->getPost('id')) && $this->crud->updateData('master_data', ['id' => $this->request->getPost('id'), 'type' => 7], ['status' => $this->request->getPost('status')])) {
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

      function documentType()
    {
        if (session()->isLoggedIn && $this->request->getMethod() == 'get' && ! $this->request->isAJAX()) {
            $this->data['title'] = 'Document Type - '.setting('App.siteName');
            return view('master/document-type', $this->data);
        } else {
            return redirect()->route('dashboard');
        }
    }

    function attemptToSavedocumentType()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            $rules = [
                'document-type'           => ['label' => 'Document-type name', 'rules' => 'required'],
                'status'                => ['label' => 'Status', 'rules' => 'required|in_list[Active, Inactive]'],
            ];
            $errors = [];
            if ($this->validate($rules, $errors)) {
                $data = array(
                    'title'             => trim($this->request->getPost('document-type')),
                    'status'                    => $this->request->getPost('status'),
                );

                if (empty($this->request->getPost('id'))) {
                    $data['created_by'] = session()->userData['id'];
                    $data['type'] = 8;
                    $data['created_at'] = time();
                    if ($lastId = $this->crud->add('master_data', $data)) {
                        $this->data['success'] = true;
                        $this->data['message'] = 'Document-type has been successfully added.';
                        return $this->response->setJSON($this->data);
                    } else {
                        $this->data['message'] = 'Something went wrong.';
                        return $this->response->setJSON($this->data);
                    }
                } else {
                    $data['updated_at'] = time();
                    if ($lastId = $this->crud->updateData('master_data', ['id' => $this->request->getPost('id'), 'type' => 8], $data)) {
                        $this->data['success'] = true;
                        $this->data['message'] = 'Document-type has been successfully updated.';
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

     function ajaxGetdocumentTypeDt()
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
                $columnName = 'master_data.id';
                break;
                case 'document-type':
                $columnName = 'md2.title';
                break;
                case 'status':
                $columnName = 'master_data.status';
                break;
                default:
                $columnName = 'master_data.id';
                break;
            }

            $totalRecords = $totalRecordwithFilter = $this->dt->ajaxGetdocumentTypeDt(1);


            if (! empty($keyword)) {
                $where .= empty($where)?"(md2.title LIKE '%$keyword%' ESCAPE '!' OR master_data.search_tags LIKE '%$keyword%' ESCAPE '!')":" AND (md2.title LIKE '%$keyword%' ESCAPE '!' OR master_data.search_tags LIKE '%$keyword%' ESCAPE '!')";
            }

            if (! empty($where)) {
                $totalRecordwithFilter = $this->dt->ajaxGetdocumentTypeDt(1, '', '', $where);
            }

            $records = $this->dt->ajaxGetdocumentTypeDt(0, $rowperpage, $start, $where, $columnSortOrder, $columnName);
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
                    "document-type" => $record['title'],
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

         function ajaxGetdocumentTypeDetails()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            if (!empty($id = $this->request->getPost('id')) && !empty($details = $this->crud->select('master_data', '', ['id' => $id, 'type' => 8], '', 1))) {
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

     function attemptToDeletedocumentType()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        $ids = [];
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            foreach ($this->request->getPost('ids') as $id) {
                if (!empty($id)) {
                    $this->crud->deleteData('master_data', ['id' => $id, 'type' => 8]);
                }
            }
            $this->data['success'] = true;
            $this->data['message'] = 'Document-type has been succesfully deleted.';
            return $this->response->setJSON($this->data);
        } else {
            $this->data['message'] = 'Something went wrong!';
            return $this->response->setJSON($this->data);
        }
    }

      function attemptToChangeStatusdocumentType()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        $ids = [];
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            if (!empty($this->request->getPost('id')) && $this->crud->updateData('master_data', ['id' => $this->request->getPost('id'), 'type' => 8], ['status' => $this->request->getPost('status')])) {
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
    function attemptToDeleteQualification()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        $ids = [];
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            foreach ($this->request->getPost('ids') as $id) {
                if (!empty($id)) {
                    $this->crud->updateData('master_data', ['id' => $id, 'type' => 14], ['is_deleted' => 'Y']);
                }
            }
            $this->data['success'] = true;
            $this->data['message'] = 'Qualification has been succesfully deleted.';
            return $this->response->setJSON($this->data);
        } else {
            $this->data['message'] = 'Something went wrong!';
            return $this->response->setJSON($this->data);
        }
    }





}