<?php
//session
class SessionVerify
{
    public function __construct()
    {
        //si il n'y a pas de session active, on demarre la session
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (!array_key_exists('logged', $_SESSION) || $_SESSION['logged'] != true) {
            header("Location: index.php");
            exit();
        }
    }
}
