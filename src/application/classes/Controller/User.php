<?php defined('SYSPATH') or die('No direct script access.');

class Controller_User extends Controller_Template {

    public function action_index()
    {

        $this->template->content = View::factory('user/info')
            ->bind('user', $user);

        // Load the user information
        $user = Auth::instance()->get_user();

        // if a user is not logged in, redirect to login page
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

                // Create the user using form values
                $user = ORM::factory('User')->create_user($this->request->post(), array(
                    'username',
                    'password',
                    'email'
                ));

                // Grant user login role
                $user->add('roles', ORM::factory('Role', array('name' => 'login')));

                // Reset values so form is not sticky
                $_POST = array();

                // Set success message
                $message = "Rejestracja użytkownika '{$user->username}' powiodła się. Sprawdź skrzynkę e-mail celem aktywacji konta.";

            } catch (ORM_Validation_Exception $e) {

                // Set failure message
                $message = 'Wystąpiły błędy:';

                // Set errors using custom messages
                $errors = $e->errors('models');
            }
        }
    }

    public function action_login()
    {
        $this->template->content = View::factory('user/login')
            ->bind('message', $message);

        if (HTTP_Request::POST == $this->request->method())
        {
            // Attempt to login user
            $remember = array_key_exists('remember', $this->request->post()) ? (bool) $this->request->post('remember') : FALSE;
            $user = Auth::instance()->login($this->request->post('username'), $this->request->post('password'), $remember);

            // If successful, redirect user
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
        // Log user out
        Auth::instance()->logout();

        // Redirect to login page
        Request::current()->redirect('user/login');
    }

}
?>