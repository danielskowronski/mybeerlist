<?php defined('SYSPATH') or die('No direct script access.');

class Helper_Request extends Controller
{
    public static function isPost($that)
    {
        return ($that->request->method() == 'POST');
    }
}