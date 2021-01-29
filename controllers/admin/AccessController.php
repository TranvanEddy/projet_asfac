<?php
class AccessController extends Controller
{
        
    //La méthode de LOGIN
    public function index()
    {
        //vérification de l'adresse mail et password
        $erreur = NULL;
        if (array_key_exists('email', $_POST)) {
            //enregistrement de l'email et password dans des variables
        $email = $_POST['email'];
        $password = $_POST['password'];
        //récupération de l'utilisateur par son email
        $user = new User;
        $userModel = $user->getOneByEmail($email);
        $hash = $userModel->getPassword($_POST['password']);
        
        if($userModel==false){
            $erreur = "Mail incorrect!";
        }
        else{
            if ($userModel->getEmail($_POST['email']) == $email) {
                if (password_verify($password,$hash)) {
                    //si c'est bon on démarre la session

                    if (session_status() != PHP_SESSION_ACTIVE) {
                        session_start();
                    }
                    $_SESSION['logged'] = true;
                    $this->redirectToRoute('News', "list");
                } else {
                    //sinon on affiche l'erreur
                    $erreur = "mot de passe incorrect!";
                }
            }
        }
        }
        // afficher
        $this->renderView('login', [
            'erreur' => $erreur
        ]);
    }
    //la methode logout
    public function logout()
    {
        session_start();
        unset($_SESSION['logged']);
        $this->redirectToRoute('front', 'index');
    }
}
