<?php defined('SYSPATH') or die('No direct script access.');

class Controller_User extends Controller_Template {

    public function action_index()
    {
        $this->template->content = View::factory('user/info')
            ->bind('user', $user);
        $user = Auth::instance()->get_user();
        if (!$user)
        {
            Request::current()->redirect('user/login');
        }
    }

    public function action_create()
    {
        $this->template->content = View::factory('user/create')
            ->bind('errors', $errors)
            ->bind('message', $message);

        if (HTTP_Request::POST == $this->request->method())
        {
            try {
                $user = ORM::factory('User')->create_user($this->request->post(), array(
                    'username',
                    'password',
                    'email'
                ));
                $user->add('roles', ORM::factory('Role', array('name' => 'login')));
                $_POST = array();
                $message = "Rejestracja użytkownika '{$user->username}' powiodła się. Sprawdź skrzynkę e-mail celem aktywacji konta.";

            }
            catch (ORM_Validation_Exception $e)
            {
                $message = 'Wystąpiły błędy:';
                $errors = $e->errors('models');
            }
        }
    }
    public function action_edit()
    {
        $this->template->content = View::factory('user/edit')
            ->bind('user', $user);

        Helper_User::checkAuth($this);

        $uid = Auth::instance()->get_user()->id;
        $user = Auth::instance()->get_user();
        $userDb = ORM::factory('User', $uid);

        if($this->request->method() == 'POST')
        {
            $_POST['publicLevel']=Helper_PublicLevel::encodePublicLevel($_POST['publicLevel']);
            $userDb->values($_POST);
            $userDb->id = $uid;
            $userDb->save();
            //$user->

            $this->redirect('user/');
        }
    }
    public function action_password()
    {
        $this->template->content = View::factory('user/password');
        $msg =  "Stare hasło się nie zgadza!";
        Helper_User::checkAuth($this);

        if($this->request->method() == 'POST')
        {
            $user = Session::instance()->get('auth_user');
            if ($user->password == Auth::instance()->hash($_POST['oldpass'])) {
                $user->password = $_POST['newpass1'];
                $user->save();
                $this->redirect('user/');
            }
            else{
                $this->template->content->bind("message", $msg);
            }

        }
    }
    public function action_login()
    {
        $this->template->content = View::factory('user/login')
            ->bind('message', $message);

        if (HTTP_Request::POST == $this->request->method())
        {
            $remember = array_key_exists('remember', $this->request->post()) ? (bool) $this->request->post('remember') : FALSE;
            $user = Auth::instance()->login($this->request->post('username'), $this->request->post('password'), $remember);

            if ($user)
            {
                Request::current()->redirect('user/index');
            }
            else
            {
                $message = 'Logowanie nie powiodło się';
            }
        }
    }

    public function action_logout()
    {
        Auth::instance()->logout();
        Request::current()->redirect('user/login');
    }

}
?>