<?php defined('SYSPATH') or die('No direct access allowed.');

return array(

    'file'  => array
    (
        'driver'             => 'file',
        'cache_dir'          => APPPATH.'cache/.kohana_cache',
        'default_expire'     => 1, //change me on production
    ),

);
?>