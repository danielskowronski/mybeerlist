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
        //lists currernt friends with link to their list -> via beerlist and to action_delete
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

        $view->page_title = "Lista znajomych";
        $this->response->body($view);
    }

    public function action_add()
    {
        //form to find user and send request (+mail)
        if($this->request->method() == 'POST')
        {
            $user = ORM::factory('User')
                ->where("username","=",$this->request->post('login'))
                ->find();
            if ($user->id === null)
            {
                $message = "Nie ma takiego użytkownika!";
            }
            else
            {
                $friendshipOld = ORM::factory('Friend')
                    ->select(DB::expr("(IF(`uid_a`=@UID,`uid_b`,`uid_a`)) AS `friend_uid`"), "date_confirmed")
                    ->and_where_open()
                    ->or_where("uid_a","=",Auth::instance()->get_user()->id)
                    ->or_where("uid_b","=",Auth::instance()->get_user()->id)
                    ->and_where_close()
                    ->find();

                if ($friendshipOld->id === null)
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
                    $message = "Nie można drugi raz wysłać zaproszenia. Albo jesteście już znajomymi, albo druga strona nie zatwierdziła znajomości.";
                }
            }
        }

        $view = View::factory('friend/add');
        $view->bind('message', $message);
        $view->page_title = "Dodaj przyjaciela";

        $this->response->body($view);
    }

    public function action_delete()
    {
        //deletes friend
        $friendship = ORM::factory('Friend')
            ->select(DB::expr("(IF(`uid_a`=@UID,`uid_b`,`uid_a`)) AS `friend_uid`"), "date_confirmed")
            ->where("confirmed","=","1")
            ->and_where_open()
            ->or_where("uid_a","=",Auth::instance()->get_user()->id)
            ->or_where("uid_b","=",Auth::instance()->get_user()->id)
            ->and_where_close()
            ->find();
        $friendship->delete();
        $this->action_index();
    }

    public function action_confirm()
    {
        //confirms friendship
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
        //ignores friendship request
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
        //lists requests (via form shows also ignored ones and ignores selected and accepts selected)
        $view = View::factory('friend/requests')
            ->bind('message', $message)
            ->bind('friendships', $friendships)
            ->bind('ignored', $b_ignored);

        $message = "";
        $b_ignored = is_null($this->request->param('id')) ? 0 : 1;

        $friendships = ORM::factory('Friend')
            ->where("uid_b","=",Auth::instance()->get_user()->id)
            ->where("b_ignored","=",$b_ignored)
            ->find_all();

        $view->page_title = "Lista zaproszeń do znajomych";
        $this->response->body($view);
    }
}
?>