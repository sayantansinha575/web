<?php namespace App\Models\Common;

use CodeIgniter\Model;

class Datatable_model extends Model
{
    protected $db;

    public function __construct($db)
    {
        $this->db =& $db;
        $this->builder = $this->db->table('products');
        $this->master = $this->db->table('master_data');
        $this->group = $this->db->table('groups');
        $this->user = $this->db->table('users');
        $this->university = $this->db->table('universities');
        $this->contact = $this->db->table('university_contacts');
        $this->academic = $this->db->table('university_academic_programs');
        $this->score = $this->db->table('university_required_score');
        $this->deadline = $this->db->table('university_deadlines');
        $this->uniApp = $this->db->table('university_application_info');
        $this->checklist = $this->db->table('university_document_checklist');
    }


    function ajaxGetTypeOfDegreeDt($isCount = false, $rowperpage = '', $start = '', $where = '', $columnSortOrder = '', $columnName = 'master_data.id')
    {
       $this->master->select('*');
        if (!empty($where)) {
            $this->master->where($where);
        }
        $this->master->where('type', 1);
        $this->master->groupBy('id');
        $this->master->orderBy($columnName, $columnSortOrder);
        if (! $isCount) {
            $this->master->limit($rowperpage, $start);
        }
        if ($isCount) {
            return $this->master->countAllResults();
        } else {
            return $this->master->get()->getResultArray();
        }
    }


    function ajaxGetUniversityProgramsDt($isCount = false, $rowperpage = '', $start = '', $where = '', $columnSortOrder = '', $columnName = 'master_data.id')
    {
       $this->master->select('*');
        if (!empty($where)) {
            $this->master->where($where);
        }
        $this->master->where('type', 2);
        $this->master->groupBy('id');
        $this->master->orderBy($columnName, $columnSortOrder);
        if (! $isCount) {
            $this->master->limit($rowperpage, $start);
        }
        if ($isCount) {
            return $this->master->countAllResults();
        } else {
            return $this->master->get()->getResultArray();
        }
    }


    function ajaxGetIntakeDt($isCount = false, $rowperpage = '', $start = '', $where = '', $columnSortOrder = '', $columnName = 'master_data.id')
    {
       $this->master->select('*');
        if (!empty($where)) {
            $this->master->where($where);
        }
        $this->master->where('type', 4);
        $this->master->groupBy('id');
        $this->master->orderBy($columnName, $columnSortOrder);
        if (! $isCount) {
            $this->master->limit($rowperpage, $start);
        }
        if ($isCount) {
            return $this->master->countAllResults();
        } else {
            return $this->master->get()->getResultArray();
        }
    }


    function ajaxGetStatusDt($isCount = false, $rowperpage = '', $start = '', $where = '', $columnSortOrder = '', $columnName = 'master_data.id')
    {
        $this->master->select('*');
        if (!empty($where)) {
            $this->master->where($where);
        }
        $this->master->where('type', 5);
        $this->master->groupBy('id');
        $this->master->orderBy($columnName, $columnSortOrder);
        if (! $isCount) {
            $this->master->limit($rowperpage, $start);
        }
        if ($isCount) {
            return $this->master->countAllResults();
        } else {
            return $this->master->get()->getResultArray();
        }
    }


    function ajaxGetSearchDt($isCount = false, $rowperpage = '', $start = '', $where = '', $columnSortOrder = '', $columnName = 'master_data.id')
    {
        $this->master->select('master_data.*, md2.title program_name');
        $this->master->join('master_data md2', 'md2.id=master_data.title', 'left');
        if (!empty($where)) {
            $this->master->where($where);
        }
        $this->master->where('master_data.type', 3);
        $this->master->groupBy('master_data.id');
        $this->master->orderBy($columnName, $columnSortOrder);
        if (! $isCount) {
            $this->master->limit($rowperpage, $start);
        }
        if ($isCount) {
            return $this->master->countAllResults();
        } else {
            return $this->master->get()->getResultArray();
        }
    }

  function ajaxGetGroupsPermissionsDt($isCount = false, $rowperpage = '', $start = '', $where = '', $columnSortOrder = '', $columnName = 'groups.id')
    {
        $this->group->select('*');
        if (!empty($where)) {
            $this->group->where($where);
        }
        $this->group->groupBy('id');
        $this->group->orderBy($columnName, $columnSortOrder);
        if (! $isCount) {
            $this->group->limit($rowperpage, $start);
        }
        if ($isCount) {
            return $this->group->countAllResults();
        } else {
            return $this->group->get()->getResultArray();
        }
    }


    function ajaxGetTypeOfExamDt($isCount = false, $rowperpage = '', $start = '', $where = '', $columnSortOrder = '', $columnName = 'master_data.id')
    {
       $this->master->select('*');
        if (!empty($where)) {
            $this->master->where($where);
        }
        $this->master->where('type', 6);
        $this->master->groupBy('id');
        $this->master->orderBy($columnName, $columnSortOrder);
        if (! $isCount) {
            $this->master->limit($rowperpage, $start);
        }
        if ($isCount) {
            return $this->master->countAllResults();
        } else {
            return $this->master->get()->getResultArray();
        }
    }


    function ajaxGetTestTypeDt($isCount = false, $rowperpage = '', $start = '', $where = '', $columnSortOrder = '', $columnName = 'master_data.id')
    {
       $this->master->select('*');
        if (!empty($where)) {
            $this->master->where($where);
        }
        $this->master->where('type', 7);
        $this->master->groupBy('id');
        $this->master->orderBy($columnName, $columnSortOrder);
        if (! $isCount) {
            $this->master->limit($rowperpage, $start);
        }
        if ($isCount) {
            return $this->master->countAllResults();
        } else {
            return $this->master->get()->getResultArray();
        }
    }

    function ajaxGetdocumentTypeDt($isCount = false, $rowperpage = '', $start = '', $where = '', $columnSortOrder = '', $columnName = 'master_data.id')
    {
        $this->master->select('*');
        if (!empty($where)) {
            $this->master->where($where);
        }
        $this->master->where('type', 8);
        $this->master->groupBy('id');
        $this->master->orderBy($columnName, $columnSortOrder);
        if (! $isCount) {
            $this->master->limit($rowperpage, $start);
        }
        if ($isCount) {
            return $this->master->countAllResults();
        } else {
            return $this->master->get()->getResultArray();
        }
    }


    function ajaxGetAssociateDt($isCount = false, $rowperpage = '', $start = '', $where = '', $columnSortOrder = '', $columnName = 'users.id')
    {
        $this->user->select('users.*, user_details.name, user_details.phone,user_details.address,user_details.establishment_date');
        $this->user->join('user_details', 'users.id=user_details.parent_id', 'left');
        if (!empty($where)) {
            $this->user->where($where);
        }
        $this->user->where('group_id', 2);
        $this->user->where('deleted', 2);

        $this->user->groupBy('users.id');
        $this->user->orderBy($columnName, $columnSortOrder);
        if (! $isCount) {
            $this->builder->limit($rowperpage, $start);
        }
        if ($isCount) {
            return $this->user->countAllResults();
        } else {
            return $this->user->get()->getResultArray();
        }
    }


    function ajaxUniversityDt($isCount = false, $rowperpage = '', $start = '', $where = '', $columnSortOrder = '', $columnName = 'universities.id')
    {
        $this->university->select('*');
        if (!empty($where)) {
            $this->university->where($where);
        }
        $this->university->groupBy('id');
        $this->university->orderBy($columnName, $columnSortOrder);
        if (! $isCount) {
            $this->university->limit($rowperpage, $start);
        }
        if ($isCount) {
            return $this->university->countAllResults();
        } else {
            return $this->university->get()->getResultArray();
        }
    }


    function ajaxUniversityContactInfoDt($isCount = false, $rowperpage = '', $start = '', $where = '', $columnSortOrder = '', $columnName = 'university_id')
    {
        $this->contact->select('*');
        if (!empty($where)) {
            $this->contact->where($where);
        }
        $this->contact->groupBy('id');
        $this->contact->orderBy($columnName, $columnSortOrder);
        if (! $isCount) {
            $this->contact->limit($rowperpage, $start);
        }
        if ($isCount) {
            return $this->contact->countAllResults();
        } else {
            return $this->contact->get()->getResultArray();
        }
    }

    function ajaxUniversityAcademicInfoDt($isCount = false, $rowperpage = '', $start = '', $where = '', $columnSortOrder = '', $columnName = 'university_id')
    {
        $this->academic->select('*');
        if (!empty($where)) {
            $this->academic->where($where);
        }
        $this->academic->groupBy('id');
        $this->academic->orderBy($columnName, $columnSortOrder);
        if (! $isCount) {
            $this->academic->limit($rowperpage, $start);
        }
        if ($isCount) {
            return $this->academic->countAllResults();
        } else {
            return $this->academic->get()->getResultArray();
        }
    }

    function ajaxUniversityRequriedScoreInfoDt($isCount = false, $rowperpage = '', $start = '', $where = '', $columnSortOrder = '', $columnName = '')
    {
        $this->score->select('university_required_score.*, master_data.title exam_type_name');
        $this->score->join('master_data', 'master_data.id=university_required_score.exam_type', 'left');
        if (!empty($where)) {
            $this->score->where($where);
        }
        $this->score->groupBy('university_required_score.id');
        $this->score->orderBy($columnName, $columnSortOrder);
        if (! $isCount) {
            $this->score->limit($rowperpage, $start);
        }
        if ($isCount) {
            return $this->score->countAllResults();
        } else {
            return $this->score->get()->getResultArray();
        }
    }

    function ajaxUniversityDatesDeadlineDt($isCount = false, $rowperpage = '', $start = '', $where = '', $columnSortOrder = '', $columnName = '')
    {
        if (!empty($where)) {
            $this->deadline->where($where);
        }
        $this->deadline->groupBy('id');
        $this->deadline->orderBy($columnName, $columnSortOrder);

        if ($isCount) {
            return $this->deadline->countAllResults();
        } else {
            $this->deadline->limit($rowperpage, $start);
            return $this->deadline->get()->getResultArray();
        }
    }


    function ajaxGetTypeOfCostDt($isCount = false, $rowperpage = '', $start = '', $where = '', $columnSortOrder = '', $columnName = 'master_data.id')
    {
        $this->master->select('*');
        if (!empty($where)) {
            $this->master->where($where);
        }
        $this->master->where('type', 9);
        $this->master->groupBy('id');
        $this->master->orderBy($columnName, $columnSortOrder);
        if (! $isCount) {
            $this->master->limit($rowperpage, $start);
        }
        if ($isCount) {
            return $this->master->countAllResults();
        } else {
            return $this->master->get()->getResultArray();
        }
    }


    function ajaxGetTypeOfFeeDt($isCount = false, $rowperpage = '', $start = '', $where = '', $columnSortOrder = '', $columnName = 'master_data.id')
    {
        $this->master->select('*');
        if (!empty($where)) {
            $this->master->where($where);
        }
        $this->master->where('type', 10);
        $this->master->groupBy('id');
        $this->master->orderBy($columnName, $columnSortOrder);
        if (! $isCount) {
            $this->master->limit($rowperpage, $start);
        }
        if ($isCount) {
            return $this->master->countAllResults();
        } else {
            return $this->master->get()->getResultArray();
        }
    }

    function ajaxGetTypeOfCurrencyDt($isCount = false, $rowperpage = '', $start = '', $where = '', $columnSortOrder = '', $columnName = 'master_data.id')
    {
        $this->master->select('*');
        if (!empty($where)) {
            $this->master->where($where);
        }
        $this->master->where('type', 11);
        $this->master->groupBy('id');
        $this->master->orderBy($columnName, $columnSortOrder);
        if (! $isCount) {
            $this->master->limit($rowperpage, $start);
        }
        if ($isCount) {
            return $this->master->countAllResults();
        } else {
            return $this->master->get()->getResultArray();
        }
    }


    function ajaxGetStudentListDt($isCount = false, $rowperpage = '', $start = '', $where = '', $columnSortOrder = '', $columnName = 'users.id')
    {
        $this->user->select('users.*, user_details.name, user_details.phone');
        $this->user->join('user_details', 'users.id=user_details.parent_id', 'left');
        if (!empty($where)) {
            $this->user->where($where);
        }
        $this->user->where('group_id', 3);
        $this->user->groupBy('users.id');
        $this->user->orderBy($columnName, $columnSortOrder);
        if (! $isCount) {
            $this->builder->limit($rowperpage, $start);
        }
        if ($isCount) {
            return $this->user->countAllResults();
        } else {
            return $this->user->get()->getResultArray();
        }
    }


    function ajaxGetUniverSityApplicationInfoDt($isCount = false, $rowperpage = '', $start = '', $where = '', $columnSortOrder = '', $columnName = '')
    {
        $this->uniApp->select('university_application_info.*, m_tog.title degree_type_name, m_ft.title fee_type_name, m_ct.title cost_type_name, m_cs.title currency_name')
        ->join('master_data m_tog', 'm_tog.id=university_application_info.type_of_degree', 'left')
        ->join('master_data m_ft', 'm_ft.id=university_application_info.fee_type', 'left')
        ->join('master_data m_ct', 'm_ct.id=university_application_info.cost_type', 'left')
        ->join('master_data m_cs', 'm_cs.id=university_application_info.currency_symbol', 'left');
        if (!empty($where)) {
            $this->uniApp->where($where);
        }
        $this->uniApp->groupBy('university_application_info.id');
        $this->uniApp->orderBy($columnName, $columnSortOrder);
        if ($isCount) {
            return $this->uniApp->countAllResults();
        } else {
            $this->builder->limit($rowperpage, $start);
            return $this->uniApp->get()->getResultArray();
        }
    }


    function ajaxGetUniverDocumentCheckListDt($isCount = false, $rowperpage = '', $start = '', $where = '', $columnSortOrder = '', $columnName = '')
    {
        if (!empty($where)) {
            $this->checklist->where($where);
        }
        $this->checklist->groupBy('id');
        $this->checklist->orderBy($columnName, $columnSortOrder);
        if ($isCount) {
            return $this->checklist->countAllResults();
        } else {
            $this->builder->limit($rowperpage, $start);
            return $this->checklist->get()->getResultArray();
        }
    }




}
