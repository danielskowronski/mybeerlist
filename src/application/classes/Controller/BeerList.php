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

        $userEntity = ORM::factory('User')
            ->where("id","=",$id)
            ->find();

        if ($userEntity->publicLevel<=0) {
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