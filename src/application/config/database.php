<?php defined('SYSPATH') or die('No direct access allowed.');

return array
(
    'local' => array
    (
        'type'       => 'mysql',
        'connection' => array(
            'hostname'   => 'localhost',
            'database'   => 'dbname',
            'username'   => 'username',
            'password'   => '*******',
            'persistent' => FALSE,
        ),
        'table_prefix' => '',
        'charset'      => 'utf8',
        'caching'      => FALSE,
        'profiling'    => TRUE,
    )
);