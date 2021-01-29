<?php
//appel des fichiers s'ils n'y sont pas déjà
require_once "utilities/config.php";
require_once 'utilities/autoload.php';
//appel du controlleur
if (isset($_GET['controller'])) {
    if (!empty($_GET['controller'])) {
        $class = ucfirst(strtolower($_GET['controller'])) . "Controller";
        try {
            $controller = new $class();
        } catch (Exception $e) {
            die($e->getMessage());
        }
        //appel de l'action
        if (isset($_GET['action'])) {
            if (!empty($_GET['action'])) {
                $action = $_GET['action'];
                try {
                    $controller->$action();
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                http_response_code(404);
                throw new Exception('cette page n\'existe pas');
            }
        } else {
            $controller->index();
        }
    } else {
        http_response_code(404);
        throw new Exception('cette page n\'existe pas');
    }
} else {
    //instanciation 
    $controller = new FrontController();
    $controller->index();
}
