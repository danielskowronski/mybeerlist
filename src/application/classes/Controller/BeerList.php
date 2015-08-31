<?php defined('SYSPATH') or die('No direct script access.');

class Controller_BeerList extends Controller {

    public function action_index()
    {
        $this->action_list();
    }
    public function action_mylist()
    {
        $this->redirect('beerlist/'.Auth::instance()->get_user()->username);
    }
    public function action_list()
    {
        $view = View::factory('beerlist/list');
        $view->beerlists = ORM::factory('User')
            ->where("publicLevel",">","0")
            ->find_all();
        $this->response->body($view);
    }
    public function action_show()
    {
        $id = $this->request->param('id');

        $requestByUsername = !isset($id);
        $userEntity = null;
        if ($requestByUsername){
            $userEntity = ORM::factory('User')
                ->where("username","=",$this->request->param('user'))
                ->find();
            $id = $userEntity->id;
        }

        $isCurrentUserList =
            Auth::instance()->logged_in() && $id==Auth::instance()->get_user()->id;

        if ($isCurrentUserList)
        {
            $this->response = Request::factory('BeerEntry/list')->execute();
            return;
            //$this->redirect('mylist');
        }

        $notPublicList = $userEntity->publicLevel<=0;
        $userIsFriend = Helper_User::areFriends(Auth::instance()->get_user()->id, $id);

        if ($notPublicList && !$userIsFriend)
        {
            $this->action_list();
            return;
        }

        $view = View::factory('beerlist/show');
        $view->beers = ORM::factory('BeerEntry')
            ->where("userId","=",$id)
            ->find_all();
        $view->userEntity = $userEntity;
        $this->response->body($view);

    }

}