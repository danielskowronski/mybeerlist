<?php defined('SYSPATH') or die('No direct script access.');

class Helper_Email extends Controller
{
    public static function sendRegistrationEmail($email, $username, $token)
    {
        $body =
            "Witaj $username!\r\n".
            "Dziękujemy za rejestrację na MyBeerList. Zanim będziesz mógł korzystać z konta musisz je aktywować.\r\n".
            "Wystarczy kliknąć w link http://$_SERVER[SERVER_NAME]/user/activate/$token\r\n".
            "\r\n".
            "Ekipa MBL";
        $subject = "Aktywacja konta MBL";

        $headers = 'From: webmaster@mbl.dsinf.net' . "\r\n" .
            'Reply-To: webmaster@dsinf.net' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        mail($email, $subject, $body, $headers);
    }
}