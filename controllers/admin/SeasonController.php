<?php
class SeasonController extends Controller
{
    public function __construct()
    {
        //réservée à l'admin
        new SessionVerify();
    }
    //la methode qui liste toutes les saisons
    public function index()
    {
        $seasons = Season::getMany();
        $this->renderView('admin/list_seasons', [
            'seasons' => $seasons
        ]);
    }
    //la methode qui sélectionne une saison par son id
    public function getOne()
    {
        $season = Season::getOne($_POST['id']);
        $this->renderView('admin/edit_season', [
            'season' => $season
        ]);
    }
    //la methode qui crée une nouvelle saison
    public function insert()
    {
        if (isset($_POST['name'])) {
            $season = new Season();
            $season->setName($_POST['name']);
            $season->insert();
        }
        $this->renderView('admin/insert_season');
    }
    //la methode de mise à jour d'une saison
    public function edit()
    {
        $season = Season::getOne($_GET['id']);
        if (isset($_POST['name'])) {
            $season->setName($_POST['name']);
            $season->setId($season->getId());
            $season->edit();
            $this->redirectTo("index.php?controller=Season");
        }
        $this->renderView('admin/edit_season', [
            "season" =>  $season
        ]);
    }
}
