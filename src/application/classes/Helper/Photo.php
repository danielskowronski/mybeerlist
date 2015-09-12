<?php defined('SYSPATH') or die('No direct script access.');

class Helper_Photo extends Controller
{
    /*
        photo url format: /photos/__A<user id>B__<16 random chars>.jpg
    */

    public static function isPhotoOwnedByUser($user, $photoUrl)
    {
        preg_match("/__A(.*)B__/", $photoUrl, $m);
        return $m[1]==$user->id;
    }
    public static function generatePhotoUrl($user, $extension)
    {
        return dirname(__FILE__)."/../../../photos/__A".$user->id."B__".Helper_Random::randomString(16).".".$extension;
    }
}