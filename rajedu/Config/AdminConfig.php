<?php
namespace Config;

use CodeIgniter\Config\BaseConfig;

class AdminConfig extends BaseConfig
{
    public $views = [
    ];

    ## Layout for the views to extend
    public $viewLayout = 'template/_layout';
    public $authLayout = 'auth/_layout';
}