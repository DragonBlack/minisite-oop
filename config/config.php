<?php
return [
    'components' => [
        'db' => [
            'class' => '\db\mysql\DbMysql',
            'dbuser' => 'root',
            'dbpassword' => '',
            'dbname' => 'minisite',
            'dbhost' => 'localhost'
        ],

        'session' => [
            'class' => '\Session',
        ],

        'viewer' => [
            'class' => '\Viewer',
            'viewPath' => 'view',
            'layout' => 'layout/main',
        ],

        'user' => [
            'class' => '\User',
        ],

        'request' => [
            'class' => '\Request',
        ],

        'response' => [
            'class' => '\Response',
        ],
    ],
];