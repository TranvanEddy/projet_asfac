<?php
class PositionController extends Controller
{
    //accèes reservé à l'admin
    public function __construct()
    {
        new SessionVerify();
    }
    //la methode liste tous les postes
    public function index()
    {
        $positions = Position::getMany();
        $this->renderView('admin/list_position', [
            'positions' => $positions    
        ]);
    }
    
    //la methode qui récupère le poste concerné par l'id du joueur 
    public function getOne()
    {
        $position = Position::getOne($_POST['id']);
        $this->renderView('admin/list_player', [
            'position' => $position
        ]);
    }
    //la methode insertion d'un nouveau poste
    public function insert()
    {
        if (isset($_POST['poste'])) {
            $position = new Position();
            $position->setPoste($_POST['poste']);
            $position->insert();
        }
        $this->renderView('admin/insert_position');
    }
    // la methode de mise a jour d'un poste
    public function edit()
    {
        $position = Position::getOne($_GET['id']);
        if (isset($_POST['poste'])) {
            $position->setPoste($_POST['poste']);
            $position->setIdPosition($position->getIdPosition());
            $position->edit();
            $this->redirectTo("index.php?controller=Position");
        }
        $this->renderView('admin/edit_position', [
            "position" =>  $position
        ]);
    }
}