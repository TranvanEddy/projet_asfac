<?php
class UserController extends Controller
{
    //accès résrervé à l'admin
    public function __construct()
    {
        new SessionVerify();
    }
    //la methode liste toutes les catégories
    public function index()
    {
        $users = User::getMany();
        $this->renderView('admin/list_user', [
            'users' => $users
        ]);
    }
    //la methode qui récupère l'utilisateur concerné par son id 
    public function getOne()
    {
        $user = User::getOne($_POST['id']);
        $this->renderView('admin/list_user', [
            'user' => $user
        ]);
    }
    public function getOneByEmail()
    {
        $user = new User();
        $user->getEmail($_POST['email']);
        $this->renderView('login', [
            'user' => $user
        ]);
    }
    //la methode insertion d'un nouveau utilisateur
    public function insert()
    {
        if (isset($_POST['userName'])) {
            $user = new User();
            $user->setUserName($_POST['userName']);
            $user->setEmail($_POST['email']);
            $user->setPassword($_POST['mdp']);
            $user->insert();
            $this->redirectTo("index.php?controller=User");
        }
        $this->renderView('admin/insert_user');
    }
    // la methode de mise a jour d'un utilisateur
    public function edit()
    {
        $user = User::getOne($_GET['id']);
        if (isset($_POST['userName'])) {
            $user->setUserName($_POST['userName']);
            $user->setUserId($user->getUserId());
            $user->edit();
            $this->redirectTo("index.php?controller=User");
        }
        $this->renderView('admin/edit_user', [
            "user" =>  $user
        ]);
    }
    //la methode effacer utilisateur
    public function delete()
    {
        $user = User::getOne($_GET['id']);
        if ($user instanceof User) {
            $user->delete();
        }
        $this->redirectTo("index.php?controller=User");
    }
}
