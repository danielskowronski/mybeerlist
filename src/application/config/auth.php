<?php defined('SYSPATH') or die('No direct access allowed.');

return array(

    'driver'       => 'ORM',
    'hash_method'  => 'sha256',
    'hash_key'     => 'change me on production senpai',
    'lifetime'     => 1209600,
    'session_key'  => 'auth_user'

);
?>