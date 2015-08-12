<?php defined('SYSPATH') or die('No direct script access.');

class Controller_StaticPages extends Controller {

    public function action_index()
    {
        $view = View::factory('staticpages/index');
        $this->response->body($view);
    }

    public function action_about()
    {
        $view = View::factory('staticpages/about');
        $this->response->body($view);
    }

}