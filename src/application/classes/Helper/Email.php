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

        mail($email, mb_encode_mimeheader($subject,"UTF-8"), $body, $headers);
    }
    public static function sendPasswdResetEmail($email, $username, $token)
    {
        $body =
            "Witaj $username!\r\n".
            "Ktoś poprosił o reset hasła Twojego konta. Jeśli to nie Ty - możesz zignorować tą wiadomość.\r\n".
            "Aby kontynuować wystarczy kliknąć w link http://$_SERVER[SERVER_NAME]/user/reset/$token\r\n".
            "\r\n".
            "Ekipa MBL";
        $subject = "Reset hasła MBL";

        $headers = 'From: webmaster@mbl.dsinf.net' . "\r\n" .
            'Reply-To: webmaster@dsinf.net' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        mail($email, mb_encode_mimeheader($subject,"UTF-8"), $body, $headers);
    }
    public static function sendNewFriendRequest($email, $username, $friendUsername)
    {
        $body =
            "Witaj $friendUsername!\r\n".
            "Użytkownik $username poprosił o dołączenie do grona Twoich znajomych.\r\n".
            "Jeśli go znasz i chcesz udostępnić mu swoją listę - kliknij w link http://$_SERVER[SERVER_NAME]/friend/requests i zatwierdź zaproszenie\r\n".
            "\r\n".
            "Ekipa MBL";
        $subject = "Zaproszenie do znajomych na MBL";

        $headers = 'From: webmaster@mbl.dsinf.net' . "\r\n" .
            'Reply-To: webmaster@dsinf.net' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        mail($email, mb_encode_mimeheader($subject,"UTF-8"), $body, $headers);
    }

}