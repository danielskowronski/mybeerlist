<?php defined('SYSPATH') or die('No direct script access.');

class Controller_BeerEntry extends Controller {

    public function action_index()
    {
        $this->action_list();
    }
    public function action_list()
    {
        Helper_User::checkAuth($this);

        $view = View::factory('beerentry/list');
        $view->beers = ORM::factory('BeerEntry')
            ->where("userId","=",Auth::instance()->get_user()->id)
            ->find_all();

        $view->debug=Auth::instance()->get_user()->id;

        $this->response->body($view);
    }


} // End Welcome
