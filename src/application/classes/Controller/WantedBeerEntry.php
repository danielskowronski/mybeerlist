<?php defined('SYSPATH') or die('No direct script access.');

class Controller_WantedBeerEntry extends Controller {

    public function before()
    {
        Helper_User::checkAuth($this);
    }
    public function action_edit()
    {
        $id = $this->request->param('id');
        $wantedbeerentry = ORM::factory('WantedBeerEntry', $id);

        if(Helper_Request::isPost($this))
        {
            $wantedbeerentry->values($_POST);
            $wantedbeerentry->userId=Auth::instance()->get_user()->id;
            $wantedbeerentry->save();

            $this->redirect('BeerEntry/list/');
        }

        $view = View::factory('wantedbeerentry/edit');
        $view->wantedbeerentry = $wantedbeerentry;

        $this->response->body($view);
    }
    public function action_convert()
    {
        $id = $this->request->param('id');
        $wantedbeerentry = ORM::factory('WantedBeerEntry', $id);
        $beerentry = ORM::factory('BeerEntry');
        $beerentry->beerName=$wantedbeerentry->beerName;
        $beerentry->beerLink=$wantedbeerentry->beerLink;
        $beerentry->notes=$wantedbeerentry->notes;

        $wantedbeerentry->delete();

        $view = View::factory('beerentry/edit');
        $view->beerentry = $beerentry;

        $this->response->body($view);
    }
    public function action_delete()
    {
        $id = $this->request->param('id');
        ORM::factory('WantedBeerEntry', $id)->delete();
        $this->redirect('BeerEntry/list');
    }

}
