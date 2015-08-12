<?php defined('SYSPATH') or die('No direct script access.');

class Controller_BeerList extends Controller {

    public function action_index()
    {
        $this->action_list();
    }
    public function action_list()
    {
        //list all users with public lists
        $view = View::factory('beerlist/list');
        $view->beerlists = ORM::factory('User')
            ->where("publicLevel",">","0")
            ->find_all();
        $view->page_title = "Publiczne listy";
        $this->response->body($view);
    }
    public function action_show()
    {
        $id = $this->request->param('id');

        if (!isset($id)){
            $userEntity = ORM::factory('User')
                ->where("username","=",$this->request->param('user'))
                ->find();
            $id = $userEntity->id;
        }
        else
        {
            $userEntity = ORM::factory('User')
                ->where("id","=",$this->request->param('id'))
                ->find();
        }
        if (Auth::instance()->logged_in() && $id==Auth::instance()->get_user()->id)
        {
            $this->redirect('BeerEntry/list');
        }

        if ($userEntity->publicLevel<=0 && !Helper_User::areFriends(Auth::instance()->get_user()->id, $id)) {
            $this->action_list();
            return;
        }

        $view = View::factory('beerlist/show');
        $view->beers = ORM::factory('BeerEntry')
            ->where("userId","=",$id)
            ->find_all();
        $view->userEntity = $userEntity;
        $view->page_title = "Lista użytkownika ".$userEntity->username;
        $this->response->body($view);

    }

}