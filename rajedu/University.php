<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\University_model;
use App\Models\MasterModel;


class University extends BaseController
{

    public function __construct()
    {
        $db = db_connect();
        $this->university = new University_model($db);
        $this->master = new MasterModel($db);
    }


    function universityList()
    {
        if (session()->isLoggedIn && $this->request->getMethod() == 'get' && !$this->request->isAJAX()) {
            $this->data['title'] = 'University List';
            return view('university/university-list', $this->data);
        } else {
            return redirect()->route('dashboard');
        }
    }

    function saveUniversity()
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
                $columnName = 'universities.university_name';
                break;
                case 'country':
                $columnName = 'countries.name';
                break;
                case 'state';
                $columnName = 'states.name';
                break;
                case 'address';
                $columnName = 'universities.address';
                break;
                case 'intake';
                $columnName = 'universities.intake';
                break;
                case 'date_of_establishment';
                $columnName = 'universities.date_of_establishment';
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
                $subAction .= '<a href="' . site_url('university/edit-university-info/' . encrypt($record['id'])) . '" class="dropdown-item"><i class="ft-edit-2 success"></i> Edit</a>';
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
                    "country" => $record['countryName'],
                    "state" => $record['stateName'],
                    "address" => $record['address'],
                    "intake" => $record['intake'],
                    "date_of_establishment" => date('M j, y', $record['date_of_establishment']),
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
            if (!empty($id = decrypt($id)) && !empty($details = $this->university->getUnviersityDataById($id))) {
                $this->data['title'] = 'University Info';
                $this->data['result'] = $details;
                if (! empty($details)) {
                    $this->data['country'] = $this->crud->select('countries', '', ['id' => $details['country']], '', true);
                    $this->data['state'] = $this->crud->select('states', '', ['id' => $details['state']], '', true);
                    $this->data['city'] = $this->crud->select('cities', '', ['id' => $details['city']], '', true);
                }
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
            if (!empty($id = decrypt($id)) && !empty($details = $this->university->getUnviersityDataById($id))) {
                $this->data['title'] = 'University General Info';
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

    function universityContactInfo($id = 0)
    {
        if (session()->isLoggedIn && $this->request->getMethod() == 'get' && !$this->request->isAJAX()) {
            if (!empty($id = decrypt($id)) && !empty($details = $this->university->getUnviersityDataById($id))) {
                $this->data['title'] = 'University Contact Info';
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

    function editUniversityContactInfo($id = 0, $subId = 0)
    {
        if (session()->isLoggedIn && $this->request->getMethod() == 'get' && !$this->request->isAJAX()) {
            if (!empty($id = decrypt($id)) && !empty($subId = decrypt($subId)) && !empty($details = $this->university->getUnviersityDataById($id))) {
                $this->data['title'] = 'University Contact Info';
                $this->data['result'] = $details;
                $this->data['details'] = $this->crud->select('university_contacts', '', ['university_id' => $id, 'id' => $subId], '', 1);
                $this->data['content'] = view('university/edit/university-contact-info', $this->data);
                return view('university/edit-university', $this->data);
            } else {
                return redirect()->route('dashboard');
            }

        } else {
            return redirect()->route('dashboard');
        }
    }

    function universityAcademicInfo($id = 0)
    {
        if (session()->isLoggedIn && $this->request->getMethod() == 'get' && !$this->request->isAJAX()) {
            if (!empty($id = decrypt($id)) && !empty($details = $this->university->getUnviersityDataById($id))) {
                $this->data['title'] = 'University Academic Program';
                $this->data['result'] = $details;
                $this->data['content'] = view('university/edit/university-academic-info', $this->data);
                return view('university/edit-university', $this->data);
            } else {
                return redirect()->route('dashboard');
            }

        } else {
            return redirect()->route('dashboard');
        }
    }

    function editUniversityAcademicInfo($id = 0, $subId = 0)
    {
        if (session()->isLoggedIn && $this->request->getMethod() == 'get' && !$this->request->isAJAX()) {
            if (!empty($id = decrypt($id)) && !empty($subId = decrypt($subId)) && !empty($details = $this->university->getUnviersityDataById($id))) {
                $this->data['title'] = 'University Academic Program';
                $this->data['result'] = $details;
                $this->data['details'] = $det = $this->crud->select('university_academic_programs', '', ['university_id' => $id, 'id' => $subId], '', 1);
                if(!empty($det)) {
                    $this->data['typeOfDegree'] = $this->master->getMasterData(explode(',', $det['type_of_degree']), 1);
                    $this->data['programs'] = $this->master->getMasterData(explode(',', $det['programs']), 2);
                }
                $this->data['content'] = view('university/edit/university-academic-info', $this->data);
                return view('university/edit-university', $this->data);
            } else {
                return redirect()->route('dashboard');
            }

        } else {
            return redirect()->route('dashboard');
        }
    }

    function editUniversityDocumentCheckList($id = 0, $subId = 0)
    {
        if (session()->isLoggedIn && $this->request->getMethod() == 'get' && !$this->request->isAJAX()) {
            if (!empty($id = decrypt($id)) && !empty($subId = decrypt($subId)) && !empty($details = $this->university->getUnviersityDataById($id))) {
                $this->data['title'] = 'University Document Checklist';
                $this->data['result'] = $details;
                $this->data['details'] = $det = $this->crud->select('university_document_checklist', '', ['university_id' => $id, 'id' => $subId], '', 1);
                if(!empty($det)) {
                    $this->data['levelOfDegree'] = $this->master->getMasterData(explode(',', $det['level_of_degree']), 1);
                    $this->data['documentsName'] = $this->master->getMasterData(explode(',', $det['document_name']), 8);
                }
                $this->data['content'] = view('university/edit/university-doc-checklist', $this->data);
                return view('university/edit-university', $this->data);
            } else {
                return redirect()->route('dashboard');
            }

        } else {
            return redirect()->route('dashboard');
        }
    }

    function universityMinimumRequriedInfo($id = 0)
    {
        if (session()->isLoggedIn && $this->request->getMethod() == 'get' && !$this->request->isAJAX()) {
            if (!empty($id = decrypt($id)) && !empty($details = $this->university->getUnviersityDataById($id))) {
                $this->data['title'] = 'University Required Score';
                $this->data['result'] = $details;
                $this->data['content'] = view('university/edit/university-required-info', $this->data);
                return view('university/edit-university', $this->data);
            } else {
                return redirect()->route('dashboard');
            }

        } else {
            return redirect()->route('dashboard');
        }
    }

    function editUniversityMinimumRequriedInfo($id = 0, $subId = 0)
    {
        if (session()->isLoggedIn && $this->request->getMethod() == 'get' && !$this->request->isAJAX()) {
            if (!empty($id = decrypt($id)) && !empty($subId = decrypt($subId)) && !empty($details = $this->university->getUnviersityDataById($id))) {
                $this->data['title'] = 'University Required Score';
                $this->data['result'] = $details;
                $this->data['details'] = $det = $this->crud->select('university_required_score', '', ['university_id' => $id, 'id' => $subId], '', 1);
                if(!empty($det)) {
                    $this->data['exams'] = $this->master->getMasterData(explode(',', $det['exam_type']), 6);
                }
                $this->data['content'] = view('university/edit/university-required-info', $this->data);
                return view('university/edit-university', $this->data);
            } else {
                return redirect()->route('dashboard');
            }

        } else {
            return redirect()->route('dashboard');
        }
    }

    function universityAdimissionInfo($id = 0)
    {
        if (session()->isLoggedIn && $this->request->getMethod() == 'get' && !$this->request->isAJAX()) {
            if (!empty($id = decrypt($id)) && !empty($details = $this->university->getUnviersityDataById($id))) {
                $admission_info_details = array();
                $this->data['details'] = $this->crud->select('university_admission_info', '', ['university_id' => $id], '', 1);
                $this->data['title'] = 'University Admission Info';
                $this->data['result'] = $details;
                $this->data['content'] = view('university/edit/university-admission-info', $this->data);
                return view('university/edit-university', $this->data);
            } else {
                return redirect()->route('dashboard');
            }
        } else {
            return redirect()->route('dashboard');
        }
    }

    function universityDatesDeadline($id = 0)
    {
        if (session()->isLoggedIn && $this->request->getMethod() == 'get' && !$this->request->isAJAX()) {
            if (!empty($id = decrypt($id)) && !empty($details = $this->university->getUnviersityDataById($id))) {
                $this->data['title'] = 'University Dates Deadline';
                $this->data['result'] = $details;
                $this->data['content'] = view('university/edit/university-dates-deadlines', $this->data);
                return view('university/edit-university', $this->data);
            } else {
                return redirect()->route('dashboard');
            }

        } else {
            return redirect()->route('dashboard');
        }
    }

    function universityApplicationInfo($id = 0)
    {
        if (session()->isLoggedIn && $this->request->getMethod() == 'get' && !$this->request->isAJAX()) {
            if (!empty($id = decrypt($id)) && !empty($details = $this->university->getUnviersityDataById($id))) {
                $togRaw = $togUnique = [];

                $this->data['title'] = 'University Application Info';
                $this->data['result'] = $details;
                $typeOfDegree = $this->crud->select('university_academic_programs', 'type_of_degree', ['university_id' => $id, 'is_deleted' => 2]);
                if (! empty($typeOfDegree)) {
                    foreach ($typeOfDegree as $tog) {
                        $togRaw = array_merge($togRaw, explode(',', $tog['type_of_degree']));
                    }
                }
                $togUnique = array_unique($togRaw);
                if (!empty($togUnique)) {
                    $this->data['typeOfDegree'] =  $this->master->getMasterData($togUnique, 1);
                }
                $this->data['feeType'] =  $this->master->getMasterDataByType(10);
                $this->data['costType'] =  $this->master->getMasterDataByType(9);
                $this->data['currency'] =  $this->master->getMasterDataByType(11);


                $this->data['content'] = view('university/edit/university-application-info', $this->data);
                return view('university/edit-university', $this->data);
            } else {
                return redirect()->route('dashboard');
            }

        } else {
            return redirect()->route('dashboard');
        }
    }

    function universityDocumentCheckList($id = 0)
    {
        if (session()->isLoggedIn && $this->request->getMethod() == 'get' && !$this->request->isAJAX()) {
            if (!empty($id = decrypt($id)) && !empty($details = $this->university->getUnviersityDataById($id))) {
                $this->data['title'] = 'University Application Info';
                $this->data['result'] = $details;
                $this->data['content'] = view('university/edit/university-doc-checklist', $this->data);
                return view('university/edit-university', $this->data);
            } else {
                return redirect()->route('dashboard');
            }

        } else {
            return redirect()->route('dashboard');
        }
    }

    function editUniversityApplicationInfo($id = 0, $subId = 0)
    {
        if (session()->isLoggedIn && $this->request->getMethod() == 'get' && !$this->request->isAJAX()) {
            if (!empty($id = decrypt($id)) && !empty($subId = decrypt($subId)) && !empty($details = $this->university->getUnviersityDataById($id))) {
                $togRaw = $togUnique = [];

                $this->data['title'] = 'University Application Info';
                $this->data['result'] = $details;
                $typeOfDegree = $this->crud->select('university_academic_programs', 'type_of_degree', ['university_id' => $id, 'is_deleted' => 2]);
                if (! empty($typeOfDegree)) {
                    foreach ($typeOfDegree as $tog) {
                        $togRaw = array_merge($togRaw, explode(',', $tog['type_of_degree']));
                    }
                }
                $togUnique = array_unique($togRaw);
                if (!empty($togUnique)) {
                    $this->data['typeOfDegree'] =  $this->master->getMasterData($togUnique, 1);
                }
                $this->data['details'] = $det = $this->crud->select('university_application_info', '', ['university_id' => $id, 'id' => $subId], '', 1);
                $this->data['feeType'] =  $this->master->getMasterDataByType(10);
                $this->data['costType'] =  $this->master->getMasterDataByType(9);
                $this->data['currency'] =  $this->master->getMasterDataByType(11);


                $this->data['content'] = view('university/edit/university-application-info', $this->data);
                return view('university/edit-university', $this->data);
            } else {
                return redirect()->route('dashboard');
            }

        } else {
            return redirect()->route('dashboard');
        }
    }

    function editUniversityDatesDeadline($id = 0, $subId = 0)
    {
        if (session()->isLoggedIn && $this->request->getMethod() == 'get' && !$this->request->isAJAX()) {
            if (!empty($id = decrypt($id)) && !empty($subId = decrypt($subId)) && !empty($details = $this->university->getUnviersityDataById($id))) {
                $this->data['title'] = 'University Dates Deadline';
                $this->data['result'] = $details;
                $this->data['details'] = $det = $this->crud->select('university_deadlines', '', ['university_id' => $id, 'id' => $subId], '', 1);
                $this->data['content'] = view('university/edit/university-dates-deadlines', $this->data);
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


                if ($lastId = $this->crud->updateData('universities', ['id' => decrypt($this->request->getPost('id'))], $data)){

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


    function updateUniversityGeneralInfo()
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

                if ($lastId = $this->crud->updateData('universities', ['id' => decrypt($this->request->getPost('id'))], $data)){

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

                $data = [
                    'type_of_contact'              => trim($this->request->getPost('type_of_contact')),
                    'name'                         => trim($this->request->getPost('name')),
                    'designation'                  => trim($this->request->getPost('designation')),
                    'email'                        => trim($this->request->getPost('email')),
                    'contact'                      => trim($this->request->getPost('contact')),
                    'alternative_contact'          => trim($this->request->getPost('alternative_contact')),
                ];
                if (! empty($subId = decrypt($this->request->getPost('sub_id')))) {
                    $data['updated_at'] = time();
                    if ($lastId = $this->crud->updateData('university_contacts', ['university_id' => decrypt($this->request->getPost('id')), 'id' => $subId] , $data)){
                        $this->data['success'] = true;
                        $this->data['message'] = 'Universities Contact data has been successfully updated.';
                        return $this->response->setJSON($this->data);
                    } else {
                        $this->data['message'] = 'Something went wrong.';
                        return $this->response->setJSON($this->data);
                    }

                } else {
                    $data['university_id'] = trim(decrypt($this->request->getPost('id')));
                    $data['created_at'] = time();
                    if ($lastId = $this->crud->add('university_contacts', $data)){
                        $this->data['success'] = true;
                        $this->data['message'] = 'Universities Contact has been successfully added.';
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


    function saveUniversityAcademicInfo()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            $rules = [
                'type_of_degree'         => ['label' => 'Type of Degree ', 'rules' => 'required'],
                'preferred_program'      => ['label' => 'Preffred Program', 'rules' => 'required'],
                'programs'               => ['label' => 'Select from the Programs (Available)  ', 'rules' => 'required'],

            ];

            $errors = [];
            if ($this->validate($rules, $errors)) {

                $data = array(
                    'type_of_degree'              => $this->request->getPost('type_of_degree'),
                    'preferred_program'           => trim($this->request->getPost('preferred_program')),
                    'programs'                    => $this->request->getPost('programs'),
                );

                if (! empty($subId = decrypt($this->request->getPost('sub_id')))) {
                    $data['updated_at'] = time();
                    if ($lastId = $this->crud->updateData('university_academic_programs', ['university_id' => decrypt($this->request->getPost('id')), 'id' => $subId] , $data)){
                        $this->data['success'] = true;
                        $this->data['message'] = 'University academic data has been successfully updated.';
                        return $this->response->setJSON($this->data);
                    } else {
                        $this->data['message'] = 'Something went wrong.';
                        return $this->response->setJSON($this->data);
                    }
                } else {
                   $data['university_id'] = trim(decrypt($this->request->getPost('id')));
                   $data['created_at'] = time();
                    if ($lastId = $this->crud->add('university_academic_programs', $data)){
                        $this->data['success'] = true;
                        $this->data['message'] = 'University Academic has been successfully added.';
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


    function ajaxGetUniverSityContactInfoDt()
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
                case 'university_id':
                $columnName = 'university_id';
                break;
                case 'type_of_contact':
                $columnName = 'type_of_contact';
                break;
                case 'name':
                $columnName = 'name';
                break;
                case 'designation';
                $columnName = 'designation';
                break;
                case 'email';
                $columnName = 'email';
                break;
                case 'contact';
                $columnName = 'contact';
                break;
                case 'alternative_contact';
                $columnName = 'alternative_contact';
                break;
                default:
                $columnName = 'university_id';
                break;
            }

            $where .= "university_id=".$this->request->getPost('university_id');


            $totalRecords = $totalRecordwithFilter = $this->dt->ajaxUniversityContactInfoDt(1, '', '', $where);


            if (! empty($keyword)) {
                $where .= empty($where)?"(master_data.title LIKE '%$keyword%' ESCAPE '!')":" AND (master_data.title LIKE '%$keyword%' ESCAPE '!')";
            }

            if (! empty($where)) {
                $totalRecordwithFilter = $this->dt->ajaxUniversityContactInfoDt(1, '', '', $where);
            }

            $records = $this->dt->ajaxUniversityContactInfoDt(0, $rowperpage, $start, $where, $columnSortOrder, $columnName);
            $data = array();


            foreach( $records as $record ){
                $actions = $subAction = '';
                $subAction .= '<a href="' . site_url('university/edit-university-contact-info/'. encrypt($record['university_id']) . '/' . encrypt($record['id'])) . '" class="dropdown-item"><i class="ft-edit-2 success"></i> Edit</a>';
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
                    "type_of_contact" => $record['type_of_contact'],
                    "name" => $record['name'],
                    "designation" => $record['designation'],
                    "email" => $record['email'],
                    "contact" => $record['contact'],
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

    function deleteUniversityContact()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        $ids = [];
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            foreach ($this->request->getPost('ids') as $id) {
                if (!empty($id)) {
                    $this->crud->deleteData('university_contacts', ['id' => $id]);
                }
            }
            $this->data['success'] = true;
            $this->data['message'] = 'Universities Contact has been succesfully deleted.';
            return $this->response->setJSON($this->data);
        } else {
            $this->data['message'] = 'Something went wrong!';
            return $this->response->setJSON($this->data);
        }
    }

    function ajaxGetUniversityContactDetails()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            if (!empty($id = $this->request->getPost('id')) && !empty($details = $this->crud->select('university_contacts', '', ['id' => $id], '', 1))) {
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

    function ajaxGetUniverSityAcademicInfoDt()
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
                case 'university_id':
                $columnName = 'university_id';
                break;
                case 'type_of_degree':
                $columnName = 'type_of_degree';
                break;
                case 'programs':
                $columnName = 'programs';
                break;
                case 'preferred_program';
                $columnName = 'preferred_program';
                break;
                default:
                $columnName = 'university_id';
                break;
            }

            $where .= "university_id=".$this->request->getPost('university_id');


            $totalRecords = $totalRecordwithFilter = $this->dt->ajaxUniversityAcademicInfoDt(1, '', '', $where);


            if (! empty($keyword)) {
                $where .= empty($where)?"(master_data.title LIKE '%$keyword%' ESCAPE '!')":" AND (master_data.title LIKE '%$keyword%' ESCAPE '!')";
            }

            if (! empty($where)) {
                $totalRecordwithFilter = $this->dt->ajaxUniversityAcademicInfoDt(1, '', '', $where);
            }

            $records = $this->dt->ajaxUniversityAcademicInfoDt(0, $rowperpage, $start, $where, $columnSortOrder, $columnName);
            $data = [];


            foreach($records as $record ){
                $actions = $subAction = '';
                $togNames = $progNames = [];
                $subAction .= '<a href="' . site_url('university/edit-university-academic-program-info/'. encrypt($record['university_id']) . '/' . encrypt($record['id'])) . '" class="dropdown-item edit-row"><i class="ft-edit-2 success"></i> Edit</a>';
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

               $typeOfDegree = $this->master->getMasterData(explode(',', $record['type_of_degree']), 1);
               foreach ($typeOfDegree as $tog) {
                   $togNames[] = $tog['title'];
               }

               $programs = $this->master->getMasterData(explode(',', $record['programs']), 2);
               foreach ($programs as $prog) {
                   $progNames[] = $prog['title'];
               }

                $data[] = array(

                    "type_of_degree" => advanceImplode($togNames),
                    "programs" => advanceImplode($progNames),
                    "preferred_program" => $record['preferred_program'],
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

    function ajaxGetUniverDocumentCheckListDt()
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
                case 'level_of_degree':
                $columnName = 'level_of_degree';
                break;
                case 'document_name':
                $columnName = 'document_name';
                break;
                case 'mandatory':
                $columnName = 'mandatory';
                break;
                default:
                $columnName = 'id';
                break;
            }

            $where .= "university_id=".decrypt($this->request->getPost('university_id'));


            $totalRecords = $totalRecordwithFilter = $this->dt->ajaxGetUniverDocumentCheckListDt(1, '', '', $where);


            if (! empty($keyword)) {
                $where .= empty($where)?"(master_data.title LIKE '%$keyword%' ESCAPE '!')":" AND (master_data.title LIKE '%$keyword%' ESCAPE '!')";
            }

            if (! empty($where)) {
                $totalRecordwithFilter = $this->dt->ajaxGetUniverDocumentCheckListDt(1, '', '', $where);
            }

            $records = $this->dt->ajaxGetUniverDocumentCheckListDt(0, $rowperpage, $start, $where, $columnSortOrder, $columnName);
            $data = [];


            foreach($records as $record ){
                $actions = $subAction = '';
                $degreeNames = $docNames = [];
                $subAction .= '<a href="' . site_url('university/edit-university-documents-check-list/'. encrypt($record['university_id']) . '/' . encrypt($record['id'])) . '" class="dropdown-item edit-row"><i class="ft-edit-2 success"></i> Edit</a>';

                $actions = '<span class="dropdown">
                <button id="btnSearchDrop12" type="button" class="btn btn-sm btn-icon btn-pure font-medium-2" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                <i class="ft-more-vertical"></i>
                </button>
                <span aria-labelledby="btnSearchDrop12" class="dropdown-menu mt-1 dropdown-menu-right">
                '. $subAction .'
                </span>
                </span>';

               $levelOfDegree = $this->master->getMasterData(explode(',', $record['level_of_degree']), 1);
               foreach ($levelOfDegree as $degree) {
                   $degreeNames[] = $degree['title'];
               }

               $documents = $this->master->getMasterData(explode(',', $record['document_name']), 8);
               foreach ($documents as $doc) {
                   $docNames[] = $doc['title'];
               }

                $data[] = array(
                    "level_of_degree" => advanceImplode($degreeNames),
                    "document_name" => advanceImplode($docNames),
                    "mandatory" => $record['mandatory'],
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

    function ajaxGetUniverSityDatesDeadlineDt()
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
                case 'type':
                $columnName = 'deadline_type';
                break;
                case 'intake':
                $columnName = 'deadline_intake';
                break;
                case 'date':
                $columnName = 'date';
                break;
                default:
                $columnName = 'id';
                break;
            }

            $where .= "university_id=".decrypt($this->request->getPost('university_id'));


            $totalRecords = $totalRecordwithFilter = $this->dt->ajaxUniversityDatesDeadlineDt(1, '', '', $where);

            if (! empty($where)) {
                $totalRecordwithFilter = $this->dt->ajaxUniversityDatesDeadlineDt(1, '', '', $where);
            }

            $records = $this->dt->ajaxUniversityDatesDeadlineDt(0, $rowperpage, $start, $where, $columnSortOrder, $columnName);
            $data = [];


            foreach($records as $record ){
                $actions = $subAction = '';
                $subAction .= '<a href="' . site_url('university/edit-university-deadline/'. encrypt($record['university_id']) . '/' . encrypt($record['id'])) . '" class="dropdown-item edit-row"><i class="ft-edit-2 success"></i> Edit</a>';
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

                    "type" => $record['deadline_type'],
                    "intake" => $record['deadline_intake'],
                    "date" => date('M j, y', $record['date']),
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

    function deleteUniversityAcademic()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        $ids = [];
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            foreach ($this->request->getPost('ids') as $id) {
                if (!empty($id)) {
                    $this->crud->deleteData('university_academic_programs', ['id' => $id]);
                }
            }
            $this->data['success'] = true;
            $this->data['message'] = 'Universities Academic has been succesfully deleted.';
            return $this->response->setJSON($this->data);
        } else {
            $this->data['message'] = 'Something went wrong!';
            return $this->response->setJSON($this->data);
        }
    }

    function saveUniversityRequiredScoreInfo()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            $rules = [
                'exam_type'          => ['label' => 'Type of Exam', 'rules' => 'required'],
                'minimum_score'      => ['label' => 'Minimum score', 'rules' => 'required|numeric'],
                'average_score'      => ['label' => 'Average score', 'rules' => 'numeric'],

            ];

            $errors = [];
            if ($this->validate($rules, $errors)) {

                $data = array(
                    'exam_type'               => trim($this->request->getPost('exam_type')),
                    'minimum_score'           => trim($this->request->getPost('minimum_score')),
                    'average_score'           => trim($this->request->getPost('average_score')),
                    'comment'                 => trim($this->request->getPost('comment')),
                );

                if (! empty($subId = decrypt($this->request->getPost('sub_id')))) {
                    $data['updated_at'] = time();
                    if ($lastId = $this->crud->updateData('university_required_score', ['university_id' => decrypt($this->request->getPost('id')), 'id' => $subId] , $data)){
                        $this->data['success'] = true;
                        $this->data['message'] = 'Universities required scrore data has been successfully updated.';
                        return $this->response->setJSON($this->data);
                    } else {
                        $this->data['message'] = 'Something went wrong.';
                        return $this->response->setJSON($this->data);
                    }

                } else {
                    $data['university_id'] = trim(decrypt($this->request->getPost('id')));
                    $data['created_at'] = time();
                    if ($lastId = $this->crud->add('university_required_score', $data)){

                        $this->data['success'] = true;
                        $this->data['message'] = 'Universities required scrore data has been successfully added.';
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

    function ajaxGetUniverSityRequiredScoreInfoDt()
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
                case 'exam_type':
                $columnName = 'master_data.title';
                break;
                case 'minimum_score':
                $columnName = 'university_required_score.minimum_score';
                break;
                case 'average_score';
                $columnName = 'university_required_score.average_score';
                break;
                case 'comment';
                $columnName = 'university_required_score.comment';
                break;
                default:
                $columnName = 'university_required_score.university_id';
                break;
            }

            $where .= "university_id=".$this->request->getPost('university_id');


            $totalRecords = $totalRecordwithFilter = $this->dt->ajaxUniversityRequriedScoreInfoDt(1, '', '', $where);


            if (! empty($keyword)) {
                $where .= empty($where)?"(master_data.title LIKE '%$keyword%' ESCAPE '!')":" AND (master_data.title LIKE '%$keyword%' ESCAPE '!')";
            }

            if (! empty($where)) {
                $totalRecordwithFilter = $this->dt->ajaxUniversityRequriedScoreInfoDt(1, '', '', $where);
            }

            $records = $this->dt->ajaxUniversityRequriedScoreInfoDt(0, $rowperpage, $start, $where, $columnSortOrder, $columnName);
            $data = array();


            foreach($records as $record ){
                $actions = $subAction = '';
                $subAction .= '<a href="' . site_url('university/edit-university-minimum-required-score/'. encrypt($record['university_id']) . '/' . encrypt($record['id'])) . '" class="dropdown-item edit-row"><i class="ft-edit-2 success"></i> Edit</a>';
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

                    "exam_type" => $record['exam_type_name'],
                    "minimum_score" => $record['minimum_score'],
                    "average_score" => $record['average_score'],
                    "comment" => $record['comment'],
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


    function ajaxGetUniverSityApplicationInfoDt()
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
                case 'degree_type':
                $columnName = 'm_tog.title';
                break;
                case 'cost_type':
                $columnName = 'm_ct.title';
                break;
                case 'fee_type';
                $columnName = 'm_ft.title';
                break;
                case 'currency';
                $columnName = 'm_cs.title';
                break;
                case 'fee';
                $columnName = 'university_application_info.fee_amount';
                break;
                case 'used_in_registration';
                $columnName = 'university_application_info.used_in_registration';
                break;
                default:
                $columnName = 'university_required_score.id';
                break;
            }

            $where .= "university_id=".decrypt($this->request->getPost('university_id'));


            $totalRecords = $totalRecordwithFilter = $this->dt->ajaxGetUniverSityApplicationInfoDt(1, '', '', $where);


            if (! empty($keyword)) {
                $where .= empty($where)?"(master_data.title LIKE '%$keyword%' ESCAPE '!')":" AND (master_data.title LIKE '%$keyword%' ESCAPE '!')";
            }

            if (! empty($where)) {
                $totalRecordwithFilter = $this->dt->ajaxGetUniverSityApplicationInfoDt(1, '', '', $where);
            }

            $records = $this->dt->ajaxGetUniverSityApplicationInfoDt(0, $rowperpage, $start, $where, $columnSortOrder, $columnName);
            $data = array();


            foreach($records as $record ){
                $actions = $subAction = '';
                $subAction .= '<a href="' . site_url('university/edit-university-application-info/'. encrypt($record['university_id']) . '/' . encrypt($record['id'])) . '" class="dropdown-item edit-row"><i class="ft-edit-2 success"></i> Edit</a>';
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

                    "degree_type" => $record['degree_type_name'],
                    "cost_type" => $record['cost_type_name'],
                    "fee_type" => $record['fee_type_name'],
                    "currency" => $record['currency_name'],
                    "fee" => $record['fee_amount'],
                    "used_in_registration" => $record['used_in_registration'],
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

    function deleteUniversityRequriedScore()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        $ids = [];
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            foreach ($this->request->getPost('ids') as $id) {
                if (!empty($id)) {
                    $this->crud->deleteData('university_required_score', ['id' => $id]);
                }
            }
            $this->data['success'] = true;
            $this->data['message'] = 'Universities Required Score has been succesfully deleted.';
            return $this->response->setJSON($this->data);
        } else {
            $this->data['message'] = 'Something went wrong!';
            return $this->response->setJSON($this->data);
        }
    }

    function saveUniversityAdmissionInfo()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            $rules = [
                'ets_score'             => ['label' => 'University ETScode  ', 'rules' => 'required|numeric'],
                'application_type'      => ['label' => 'Application Type', 'rules' => 'required'],
                'min_acc_percentage'    => ['label' => 'Min Academic Percentage ', 'rules' => 'required|numeric'],
                'max_back_logs'         => ['label' => 'Max Back logs Allowed', 'rules' => 'required|numeric'],
                'amount'                => ['label' => 'Amount Bank Statement Req ', 'rules' => 'required|numeric'],
                'test_score_photo_copy' => ['label' => 'Photo Copis of test scores Accepted ', 'rules' => 'required'],
                'dispatch_mode'         => ['label' => 'Mode of Dispatch(MOD) ', 'rules' => 'required'],

            ];
            $errors = [];
            if ($this->validate($rules, $errors)) {
                $data = array(
                    'ets_score'              => trim($this->request->getPost('ets_score')),
                    'application_type'       => trim($this->request->getPost('application_type')),
                    'min_acc_percentage'     => trim($this->request->getPost('min_acc_percentage')),
                    'max_back_logs'          => trim($this->request->getPost('max_back_logs')),
                    'amount'                 => trim($this->request->getPost('amount')),
                    'test_score_photo_copy'=> trim($this->request->getPost('test_score_photo_copy')),
                    'dispatch_mode' => trim($this->request->getPost('dispatch_mode')),
                    'comment' => trim($this->request->getPost('comment')),
                );

                if (! empty($subId = decrypt($this->request->getPost('sub_id')))) {
                    $data['updated_at'] = time();
                    if ($lastId = $this->crud->updateData('university_admission_info', ['university_id' => decrypt($this->request->getPost('id')), 'id' => $subId] , $data)){
                        $this->data['success'] = true;
                        $this->data['message'] = 'Universities admission info data has been successfully updated.';
                        $this->data['redirect'] = site_url('university/edit-university-deadline/'.$this->request->getPost('id'));
                        return $this->response->setJSON($this->data);
                    } else {
                        $this->data['message'] = 'Something went wrong.';
                        return $this->response->setJSON($this->data);
                    }
                } else {
                    $data['university_id'] = trim(decrypt($this->request->getPost('id')));
                    $data['created_at'] = time();
                    if ($lastId = $this->crud->add('university_admission_info', $data)) {
                        $this->data['success'] = true;
                        $this->data['message'] = 'University Admission Info has been successfully added.';
                        $this->data['redirect'] = site_url('university/edit-university-deadline/'.$this->request->getPost('id'));
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

    function saveUniversityApplicationInfo()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            $rules = [
                'type_of_degree'            => ['label' => 'Type of degree', 'rules' => 'required'],
                'fee_type'                  => ['label' => 'Fee type', 'rules' => 'required'],
                'cost_type'                 => ['label' => 'Cost type', 'rules' => 'required'],
                'currency_symbol'           => ['label' => 'Curremncy symbol', 'rules' => 'required'],
                'fee_amount'                => ['label' => 'Fee amount', 'rules' => 'required|numeric'],
                'used_in_registration'      => ['label' => 'Used in registration', 'rules' => 'required'],
            ];
            $errors = [];
            if ($this->validate($rules, $errors)) {
                $data = array(
                    'type_of_degree'            => trim($this->request->getPost('type_of_degree')),
                    'fee_type'                  => trim($this->request->getPost('fee_type')),
                    'cost_type'                 => trim($this->request->getPost('cost_type')),
                    'currency_symbol'           => trim($this->request->getPost('currency_symbol')),
                    'fee_amount'                => trim($this->request->getPost('fee_amount')),
                    'used_in_registration'      => trim($this->request->getPost('used_in_registration')),
                );

                if (! empty($subId = decrypt($this->request->getPost('sub_id')))) {
                    $data['updated_at'] = time();
                    if ($lastId = $this->crud->updateData('university_application_info', ['university_id' => decrypt($this->request->getPost('id')), 'id' => $subId] , $data)){
                        $this->data['success'] = true;
                        $this->data['message'] = 'University admission info data has been successfully updated.';
                        return $this->response->setJSON($this->data);
                    } else {
                        $this->data['message'] = 'Something went wrong.';
                        return $this->response->setJSON($this->data);
                    }
                } else {
                    $data['university_id'] = trim(decrypt($this->request->getPost('id')));
                    $data['created_at'] = time();
                    $data['status'] = 1;
                    $data['added_by'] = session()->userData['id'];
                    if ($lastId = $this->crud->add('university_application_info', $data)) {
                        $this->data['success'] = true;
                        $this->data['message'] = 'University application Info data has been successfully added.';
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

    function saveUniversityDeadlineInfo()
    {
        $this->data['success'] = false;
        $this->data['hash'] = csrf_hash();
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            $rules = [
                'deadline_type'        => ['label' => 'Deadline Type', 'rules' => 'required'],
                'deadline_intake'      => ['label' => 'Deadlines intake', 'rules' => 'required'],
                'date'                 => ['label' => 'Date', 'rules' => 'required|valid_date[Y-m-d]'],

            ];

            $errors = [];
            if ($this->validate($rules, $errors)) {

                $data = array(
                    'deadline_type'    => trim($this->request->getPost('deadline_type')),
                    'deadline_intake'  => trim($this->request->getPost('deadline_intake')),
                    'date'             => strtotime(trim($this->request->getPost('date'))),
                );

                if (! empty($subId = decrypt($this->request->getPost('sub_id')))) {
                    $data['updated_at'] = time();
                    if ($lastId = $this->crud->updateData('university_deadlines', ['university_id' => decrypt($this->request->getPost('id')), 'id' => $subId] , $data)){
                        $this->data['success'] = true;
                        $this->data['message'] = 'Universities deadline data has been successfully updated.';
                        return $this->response->setJSON($this->data);
                    } else {
                        $this->data['message'] = 'Something went wrong.';
                        return $this->response->setJSON($this->data);
                    }

                } else {
                    $data['university_id'] = trim(decrypt($this->request->getPost('id')));
                    $data['created_at'] = time();

                    if ($lastId = $this->crud->add('university_deadlines', $data)){

                        $this->data['success'] = true;
                        $this->data['message'] = 'Universities deadline data has been successfully added.';
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

    function checkAvailabilityOftypeOfExam()
    {
        $this->data['success'] = false;
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            if (! $this->university->checkAvailabilityOftypeOfExam(decrypt($this->request->getPost('university')), $this->request->getPost('examType'))) {
                $this->data['success'] = true;
                return $this->response->setJSON($this->data);
            } else {
                $this->data['message'] = 'The exam type is already exists for this university.';
                return $this->response->setJSON($this->data);
            }
        } else {
            $this->data['message'] = 'Access Denied.';
            return $this->response->setJSON($this->data);
        }
    }

    function validateTypeOfDegree()
    {
        $this->data['success'] = true;
        if (session()->isLoggedIn && $this->request->getMethod() == 'post' && $this->request->isAJAX()) {
            $universityId = decrypt($this->request->getPost('university'));
            $typeOfDegree = $this->request->getPost('type_of_degree');
            $usedInRegistration = $this->request->getPost('used_in_registration');
            if ($usedInRegistration == 1 && !empty($typeOfDegree)) {
                if ($this->university->validateTypeOfDegree($universityId, $typeOfDegree)) {
                   $this->data['success'] = false;
                   $this->data['message'] = 'The used in registration value "Yes" already exists for selected degree.';
                }
            }
            return $this->response->setJSON($this->data);
        } else {
            $this->data['message'] = 'Access Denied.';
            return $this->response->setJSON($this->data);
        }
    }
}
