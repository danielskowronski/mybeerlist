<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Photo extends Controller
{
    public function action_upload()
    {
        Helper_User::checkAuth($this);

        $view = View::factory('photo/upload');
        $filename = NULL;
        $error_message=NULL;
        if ($this->request->method() == Request::POST)
        {
            if (isset($_FILES['photo']))
            {
                $filename = $this->_save_image($_FILES['photo']);
            }
        }

        if ( ! $filename)
        {
            $error_message = 'There was a problem while uploading the image.
                Make sure it is uploaded and must be JPG/PNG/GIF file.';
        }


        $view->body = isset($error_message) ? "ERROR" : $filename;
        $this->response->body($view);
    }

    protected function _save_image($image)
    {
        if (
            ! Upload::valid($image) OR
            ! Upload::not_empty($image) OR
            ! Upload::type($image, array('jpg', 'jpeg', 'png', 'gif')))
        {
            return FALSE;
        }

        $directory = dirname(__FILE__)."/../../../photos/";

        if ($file = Upload::save($image, NULL, $directory))
        {
            $filename = strtolower(Text::random('alnum', 20)).'.jpg';

            $trgt = Helper_Photo::generatePhotoUrl(Auth::instance()->get_user(), "jpg");
            Image::factory($file)
                ->resize(800, 600, Image::AUTO)
                ->save($trgt);

            // Delete the temporary file
            unlink($file);


            preg_match("(__A.*\.jpg)", $trgt, $m);
            $filename=$m[0];
            return $filename;
        }

        return FALSE;
    }

    public function action_delete()
    {
        Helper_User::checkAuth($this);
        $file = $this->request->param('name');

        if (Helper_Photo::isPhotoOwnedByUser(Auth::instance()->get_user(), $file))
        {
            preg_match("(__A.*\.jpg)", $file, $m);
            $filename=$m[0];
            if (preg_match('/^[A-Z0-9_]$/i', $filename)) return;//hacker detector
            unlink(dirname(__FILE__)."/../../../photos/".$filename);
        }
    }
}
?>