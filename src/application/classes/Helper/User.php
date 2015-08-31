<?php defined('SYSPATH') or die('No direct script access.');

class Helper_User extends Controller
{
    static function checkAuth($that) /* not this */
    {
        if ( ! Auth::instance()->logged_in() )
        {
            $that->redirect('user/login');
        }
    }
    public static function userNotFound($user)
    {
        return ($user->id === null);
    }
    public static function userSummary($uid)
    {
        $user = ORM::factory('User')
            ->where("id","=",$uid)
            ->find();
        return $user;
    }
    public static function areFriends($uid_a, $uid_b)
    {
        $cnt = ORM::factory('Friend')
            ->where("confirmed","=","1")

            ->and_where_open()

            ->or_where_open()
            ->and_where("uid_a","=",$uid_a)
            ->and_where("uid_b","=",$uid_b)
            ->or_where_close()

            ->or_where_open()
            ->and_where("uid_a","=",$uid_b)
            ->and_where("uid_b","=",$uid_a)
            ->or_where_close()

            ->and_where_close()

            ->count_all();
        return $cnt>0;
    }
}