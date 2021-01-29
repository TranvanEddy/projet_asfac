<?php
class LevelController extends Controller
{
    public function __construct()
    {
        //réservée à l'admin
        new SessionVerify();
    }
    //la methode qui liste tous les levels
    public function index()
    {
        $levels = Level::getMany();
        $this->renderView('admin/list_levels', [
            'levels' => $levels
        ]);
    }
    //la methode qui sélectionne un level par son id
    public function getOne()
    {
        $level = Level::getOne($_POST['id']);
        $this->renderView('admin/edit_level', [
            'level' => $level
        ]);
    }
    //la methode qui crée un nouveau level
    public function insert()
    {
        if (isset($_POST['name'])) {
            $level = new Level();
            $level->setName($_POST['name']);
            $level->insert();
        }
        $this->renderView('admin/insert_level');
    }
    //la methode de mise à jour d'un level
    public function edit()
    {
        $level = Level::getOne($_GET['id']);
        if (isset($_POST['name'])) {
            $level->setName($_POST['name']);
            $level->setId($level->getId());
            $level->edit();
            $this->redirectTo("index.php?controller=Level");
        }
        $this->renderView('admin/edit_level', [
            "level" =>  $level
        ]);
    }
}
