<?php defined('SYSPATH') or die('No direct script access.');

class Controller_User extends Controller_Template {

    public function action_index()
    {
        Helper_User::checkAuth($this);

        $user = Auth::instance()->get_user();
        $this->template->content = View::factory('user/info')
            ->bind('user', $user);
    }

    public function action_create()
    {
        $this->template->content = View::factory('user/create')
            ->bind('errors', $errors)
            ->bind('message', $message);
        $message="";

        if (HTTP_Request::POST == $this->request->method())
        {
            $token = Helper_Random::randomString(16);
            try
            {
                $user = ORM::factory('User')->create_user($this->request->post(), array(
                    'username',
                    'password',
                    'email'
                ));
                $user->register_token = $token; $user->save();
                $user->add('roles', ORM::factory('Role', array('name' => 'login')));

                $message = "Rejestracja użytkownika '{$user->username}' powiodła się. Sprawdź skrzynkę e-mail celem aktywacji konta.<br />".
                    "Jeśli nie możesz znaleźć wiadomości - sprawdź folder SPAM lub ".HTML::anchor('user/resendVerifMail', 'poproś o ponowne jej wysłanie').".";
                $_POST = array();

                Helper_Email::sendRegistrationEmail($user->email, $user->username, $token);

                $this->template->content = View::factory('user/login')
                    ->bind('errors', $errors)
                    ->bind('message', $message);
            }
            catch (ORM_Validation_Exception $e)
            {
                $errors = $e->errors('models');
            }
        }
    }

    public function action_activate()
    {
        $this->template->content = View::factory('user/activate')
            ->bind('errors', $errors)
            ->bind('message', $message);

        $token = $this->request->param('id');
        $user = ORM::factory('User')
            ->where("register_token","=",$token)
            ->find();
        if ($user->id !== null)
        {
            $user->register_token="";
            $user->update();
            $message="Aktywacja konta OK. Zaloguj się.";
            $this->template->content = View::factory('user/login')
                ->bind('errors', $errors)
                ->bind('message', $message);
        }
        else
        {
            $errors = "Nie znaleziono takiego tokena. Spróbuj się zalogować.<br />".
                "Jeśli nie możesz znaleźć wiadomości - sprawdź folder SPAM lub ".HTML::anchor('user/resendVerifMail', 'poproś o ponowne jej wysłanie').".";
        }

    }

    public function action_edit()
    {
        $this->template->content = View::factory('user/edit')
            ->bind('errors', $errors)
            ->bind('user', $user);

        Helper_User::checkAuth($this);

        $uid = Auth::instance()->get_user()->id;
        $user = Auth::instance()->get_user(); //for template->content binding - do not delete - phpstorm cannot track pass-by-reference :(
        $userDb = ORM::factory('User', $uid);

        if($this->request->method() == 'POST')
        {
            $_POST['publicLevel']=Helper_PublicLevel::encodePublicLevel($_POST['publicLevel']);
            $userDb->values($_POST); //not OOP due to hack above - TODO
            $userDb->id = $uid;
            $userDb->save();

            $this->redirect('user/');
        }
    }

    public function action_password()
    {
        $this->template->content = View::factory('user/password');
        $errors =  "Stare hasło się nie zgadza!";
        Helper_User::checkAuth($this);
        $message="";

        if($this->request->method() == 'POST')
        {
            $user = Session::instance()->get('auth_user');
            if ($user->password == Auth::instance()->hash($this->request->post('oldpass'))) {
                $user->password = $this->request->post('password');
                $user->save();
                $this->redirect('user/');
            }
            else{
                $this->template->content->bind("message", $message)->bind('errors', $errors);
            }

        }
    }

    public function action_reset()
    {
        $tokenGet= $this->request->param('id');
        $tokenPost = $this->request->post('token');
        $token = isset($tokenGet) ? $tokenGet : (isset($tokenPost) ? $tokenPost : "");

        $message="";
        if (!isset($token) || $token=="" )
        {
            //request for token
            $this->template->content = View::factory('user/reset-request');
            if($this->request->method() == 'POST')
            {
                $user = ORM::factory('User')
                    ->where("email","=",$this->request->post('email'))
                    ->find();
                if ($user->id === null)
                {
                    $errors = "Dane nie pasują!";
                }
                else
                {
                    $newToken = Helper_Random::randomString(16);
                    $user->register_token = $newToken;
                    $user->save();
                    Helper_Email::sendPasswdResetEmail($user->email, $user->username, $newToken);
                    $msg = "Dane OK. Sprawdź skrzynkę mailową.";
                }
                $this->template->content
                    ->bind('message', $message)
                    ->bind('errors', $errors);
            }
        }
        else
        {
            //mail verified, password change
            $this->template->content = View::factory('user/reset-reset');
            $this->template->content
                ->bind('token', $token);
            if($this->request->method() == 'POST')
            {
                $user = ORM::factory('User')
                    ->where("reset_token","=",$token)
                    ->where("username","=",$this->request->post('login'))
                    ->find();
                if ($user->id !== null)
                {
                    $user->reset_token = "";
                    $user->password = $this->request->post('password');
                    $user->save();
                    $message = "Dane OK. Zmiana hasła OK.";
                    $this->template->content = View::factory('user/login')
                        ->bind('message', $msg);
                }
                else
                {
                    $errors = "Dane nie pasują lub token niepoprawny!";
                }
                $this->template->content
                    ->bind('message', $msg)
                    ->bind('errors', $errors);
            }
        }
    }

    public function action_login()
    {
        $this->template->content = View::factory('user/login')
            ->bind('errors', $errors)
            ->bind('message', $message);

        if (HTTP_Request::POST == $this->request->method())
        {
            $remember = array_key_exists('remember', $this->request->post()) ? (bool) $this->request->post('remember') : FALSE;
            $user = Auth::instance()->login($this->request->post('username'), $this->request->post('password'), $remember);

            if ($user)
            {
                if(Auth::instance()->get_user()->register_token!="")
                {
                    $errors = 'Konto wymaga aktywacji - sprawdź pocztę. <br />'.
                        "Jeśli nie możesz znaleźć wiadomości - sprawdź folder SPAM lub ".HTML::anchor('user/resendVerifMail', 'poproś o ponowne jej wysłanie').".";
                    Auth::instance()->login("bla","bla"); //destroy session without explicit logout via framework
                }
                else
                {
                    Request::current()->redirect('user/index');
                }
            }
            else
            {
                $errors = 'Logowanie nie powiodło się';
            }
        }
    }

    public function action_resendVerifMail()
    {
        $this->template->content = View::factory('user/resendVerifMail');
        if($this->request->method() == 'POST')
        {
            $user = ORM::factory('User')
                ->where("email","=",$this->request->post('email'))
                ->where("register_token","<>","")
                ->find();
            if ($user->id === null)
            {
                $errors = "Dane nie pasują!";
            }
            else
            {
                $newToken = Helper_Random::randomString(16);
                $user->register_token = $newToken;
                $user->save();
                Helper_Email::sendRegistrationEmail($user->email, $user->username, $newToken);
                $message = "Dane OK. Sprawdź skrzynkę mailową.";
            }
            $this->template->content
                ->bind('errors', $errors)
                ->bind('message', $message);
        }

    }

    public function action_logout()
    {
        Auth::instance()->logout();
        Request::current()->redirect('user/login');
    }

}
?>