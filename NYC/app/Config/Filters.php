<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseConfig
{
    /**
     * Configures aliases for Filter classes to
     * make reading things nicer and simpler.
     *
     * @var array
     */
    public $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
    ];

    /**
     * List of filter aliases that are always
     * applied before and after every request.
     *
     * @var array
     */
    public $globals = [
        'before' => [
            'csrf' => [
                'except' => [
                    'admin/book/getAuthorDropdownData',
                    'branch/student/ajax-dt-get-student-list',
                    'branch/student/ajax-get-course-by-type',
                    'branch/student/ajax-get-course-by-id',
                    'branch/student/ajax-get-student-by-reg-no',
                    'head-office/ajax-dt-get-branch-list',
                    'head-office/ajax-dt-get-student-list',
                    'branch/student/ajax-dt-get-admission-list',
                    'head-office/ajax-dt-get-admission-list',
                    'branch/payment/ajax-dt-get-payment-list',
                    'head-office/ajax-dt-get-payment-list',
                    'branch/marksheet/ajax-dt-get-marksheet-list',
                    'head-office/marksheet/ajax-dt-get-marksheet-list',
                    'branch/certificate/ajax-dt-get-certificate-list',
                    'head-office/certificate/ajax-dt-get-certificate-list',
                    'head-office/ajax-dt-get-authletter-list',
                    'branch/admit/ajax-dt-get-admit-list',
                    'head-office/admit/ajax-dt-get-admit-list',
                    'head-office/document/ajax-get-course-by-type',
                    'head-office/document/ajax-dt-get-study-materials-list',
                    'branch/document/ajax-dt-get-study-materials-list',
                    'student/payment/ajax-dt-get-payment-list',
                    'common/encrypt-data',
                    'head-office/document/ajax-dt-get-branch-doc-list',
                    'branch/document/ajax-dt-get-ho-docs-list',
                    'head-office/prints/ajax-dt-get-combined-pdf-list',
                    'head-office/wallet/ajax-dt-get-wallet-list',
                ],
            ],
        ],
        'after' => [
            'toolbar',
            // 'honeypot',
            // 'secureheaders',
        ],
    ];

    /**
     * List of filter aliases that works on a
     * particular HTTP method (GET, POST, etc.).
     *
     * Example:
     * 'post' => ['csrf', 'throttle']
     *
     * @var array
     */
    public $methods = [];

    /**
     * List of filter aliases that should run on any
     * before or after URI patterns.
     *
     * Example:
     * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
     *
     * @var array
     */
    public $filters = [];
}
