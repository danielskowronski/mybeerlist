<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Friend extends Controller
{

    public function before()
    {
        Helper_User::checkAuth($this);
    }

    public function action_index()
    {
        $this->action_list();
    }

    public function action_list()
    {
        $view = View::factory('friend/list')
            ->bind('message', $message)
            ->bind('friendships', $friendships);

        $message = "";

        $curruid = Auth::instance()->get_user()->id;

        $friendships = ORM::factory('Friend')
            ->select(DB::expr("(IF(`uid_a`=$curruid,`uid_b`,`uid_a`)) AS `friend_uid`"), "date_confirmed")
            ->where("confirmed","=","1")
            ->and_where_open()
            ->or_where("uid_a","=",$curruid)
            ->or_where("uid_b","=",$curruid)
            ->and_where_close()
            ->find_all();

        $this->response->body($view);
    }

    public function action_add()
    {
        if($this->request->method() == 'POST')
        {
            $user = ORM::factory('User')
                ->where("username","=",$this->request->post('login'))
                ->find();

            if ($user->id === null)
            {
                $errors = "Nie ma takiego użytkownika!";
            }
            else
            {
                $currid = Auth::instance()->get_user()->id;
                $cnt = ORM::factory('Friend')
                    ->select(DB::expr("(IF(`uid_a`=$currid,`uid_b`,`uid_a`)) AS `friend_uid`"), "date_confirmed")
                    ->and_where_open()
                    ->and_where("uid_a","=",$currid)
                    ->and_where("uid_b","=",$user->id)
                    ->and_where_close()
                    ->count_all();
                if ($cnt==0)
                {
                    $friendship = ORM::factory('Friend')
                        ->create();
                    $friendship->values(array(
                        'uid_a' => Auth::instance()->get_user()->id,
                        'uid_b' => $user->id
                    ));
                    $friendship->save();
                    Helper_Email::sendNewFriendRequest($user->email, Auth::instance()->get_user()->username, $user->username);
                    $message = "Dane OK. Zaproszenie wysłane.";
                }
                else
                {
                    $errors = "Nie można drugi raz wysłać zaproszenia. Albo jesteście już znajomymi, albo druga strona nie zatwierdziła znajomości.";
                }
            }
        }

        $view = View::factory('friend/add');
        $view->bind('message', $message)->bind('errors', $errors);

        $this->response->body($view);
    }

    public function action_delete()
    {
        $id = $this->request->param('id');
        $currid = Auth::instance()->get_user()->id;
        $friendship = ORM::factory('Friend')
            ->select(DB::expr("(IF(`uid_a`=$currid,`uid_b`,`uid_a`)) AS `friend_uid`"), "date_confirmed")
            ->where("confirmed","=","1")
            ->and_where_open()
            ->and_where("uid_a","=",$currid)
            ->and_where("uid_b","=",$id)
            ->and_where_close()
            ->find();
        $friendship->delete();
        $this->action_index();
    }

    public function action_confirm()
    {
        $id = $this->request->param('id');
        $friendship = ORM::factory('Friend')
            ->where("uid_b","=",Auth::instance()->get_user()->id)
            ->where("uid_a","=",$id)
            ->find();
        $friendship->confirmed = 1;
        $friendship->date_confirmed = Date::formatted_time('now', Date::$timestamp_format);
        $friendship->save();
        $this->action_index();
    }

    public function action_ignore()
    {
        $id = $this->request->param('id');
        $friendship = ORM::factory('Friend')
            ->where("uid_b","=",Auth::instance()->get_user()->id)
            ->where("uid_a","=",$id)
            ->find();
        $friendship->b_ignored = 1;
        $friendship->save();
        $this->redirect('friend/requests');
        //cannot use direct call to action due to:
        // 1) refresh possibility with double action via get
        // 2) conflict with action_list routing (anything as id shows ignored ones causing probems)
    }

    public function action_requests()
    {
        $view = View::factory('friend/requests')
            ->bind('message', $message)
            ->bind('friendships', $friendships)
            ->bind('ignored', $b_ignored);

        $message = "";
        $b_ignored = is_null($this->request->param('id')) ? 0 : 1;

        $friendships = ORM::factory('Friend')
            ->where("confirmed","=","0")
            ->where("uid_b","=",Auth::instance()->get_user()->id)
            ->where("b_ignored","=",$b_ignored)
            ->find_all();

        $this->response->body($view);
    }
}
?>