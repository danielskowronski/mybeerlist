<?php defined('SYSPATH') or die('No direct script access.');

class Controller_BeerEntry extends Controller {

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
        $view = View::factory('beerentry/list');
        $view->beers = ORM::factory('BeerEntry')
            ->where("userId","=",Auth::instance()->get_user()->id)
            ->find_all();

        $view->debug=Auth::instance()->get_user()->id;
        $view->page_title = "Moja lista piw";
        $this->response->body($view);
    }
    public function action_edit()
    {
        $id = $this->request->param('id');
        $beerentry = ORM::factory('BeerEntry', $id);
        if($this->request->method() == 'POST')
        {
            $beerentry->values($_POST);
            $beerentry->userId=Auth::instance()->get_user()->id;
            $beerentry->save();

            $this->redirect('BeerEntry/show/'.$beerentry->id );
        }

        $view = View::factory('beerentry/edit');
        $view->beerentry = $beerentry;
        $view->page_title = "Edytuj wpis";

        $this->response->body($view);
    }
    public function action_show()
    {
        $id = $this->request->param('id');
        $beerentry = ORM::factory('BeerEntry', $id);

        $view = View::factory('beerentry/show');
        $view->beer = $beerentry;
        $view->page_title = "Pokaż wpis";

        $this->response->body($view);
    }
    public function action_delete()
    {
        $id = $this->request->param('id');
        ORM::factory('BeerEntry', $id)->delete();
        $this->redirect('BeerEntry/list');
    }

}
