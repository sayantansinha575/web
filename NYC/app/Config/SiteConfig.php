<?php namespace Config;

use CodeIgniter\Config\BaseConfig;
use Config\Database;

class SiteConfig extends BaseConfig
{
    
    public function __construct ()
    {
        parent::__construct();
        $db = Database::connect();
        #SET GENERAL SETTINGS BEGIN
        $genSetsArr = array();
        $genSets = $db->query('SELECT * FROM setting WHERE `setting_type`=1 ')->getResult();
        if (!empty($genSets)) {
            foreach ($genSets as $genSet) {
                $genSetsArr[strtoupper($genSet->name)] = $genSet->value;
            }
        }
        $this->general = $genSetsArr;
        #SET GENERAL SETTINGS ENDS

        #SET CERTIFICATE & MARSHEET SETTINGS BEGIN
        $genSetsArr = array();
        $genSets = $db->query('SELECT * FROM setting WHERE `setting_type`=2 ')->getResult();
        if (!empty($genSets)) {
            foreach ($genSets as $genSet) {
                $genSetsArr[strtoupper($genSet->name)] = $genSet->value;
            }
        }
        $this->cert_n_marc = $genSetsArr;
        #SET CERTIFICATE & MARSHEET SETTINGS ENDS

        #SET MEDIA SETTINGS BEGIN
        $genSetsArr = array();
        $genSets = $db->query('SELECT * FROM setting WHERE `setting_type`=3 ')->getResult();
        if (!empty($genSets)) {
            foreach ($genSets as $genSet) {
                $genSetsArr[strtoupper($genSet->name)] = $genSet->value;
            }
        }
        $this->media = $genSetsArr;
        #SET MEDIA SETTINGS ENDS

        #SET META TAG BEGIN
        $genSetsArr = array();
        $genSets = $db->query('SELECT * FROM setting WHERE `setting_type`=4 ')->getResult();
        if (!empty($genSets)) {
            foreach ($genSets as $genSet) {
                $genSetsArr[strtoupper($genSet->name)] = $genSet->value;
            }
        }
        $this->meta = $genSetsArr;
        #SET META TAG ENDS

        $db->close();
    }
} 
