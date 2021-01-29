<?php
class TeamsController extends Controller
{
    //la methode de sélection des équipes  
    public function index()
    {
        $seasons = Season::getMany();
        $levels = Level::getMany();
        $this->renderView('teams', [
            "seasons" =>  $seasons,
            "levels" =>  $levels
        ]);
    }
    //la methode qui liste toutes les équipes
    public function list()
    {
        //réservée à l'admin
        new SessionVerify();
        $seasons = Season::getMany();
        $levels = Level::getMany();
        $teams = Teams::getAll();
        $this->renderView('admin/list_teams', [
            "seasons" =>  $seasons,
            "levels" =>  $levels,
            "teams" =>  $teams
        ]);
    }
    //la methode qui affiche les équipes sélectionnées
    public function showTeams()
    {
        if (isset($_POST['etIdSeason'])) {
            if (isset($_POST['etIdLevel']))
                $teams = Teams::getMany($_POST['etIdSeason'], $_POST['etIdLevel']);
            else
                $teams = Teams::getMany($_POST['etIdSeason']);
        } else {
            $teams = [];
        }
        if (!empty($teams)) {
            for ($i = 0; $i < count($teams); $i++) {
                $teams[$i] = (array) $teams[$i];
            }
        }
        echo json_encode($teams, true);
        exit();
    }
    //la methode qui crée une nouvelle équipe
    public function insert()
    {
        //réservée à l'admin
        new SessionVerify();
        $seasons = Season::getMany();
        $levels = Level::getMany();
        if (isset($_POST['name'])) {
            $result_file = $this->uploadImage('uploads/', "image");
            if ($result_file) {
                $team = new Teams();
                $team->setName($_POST['name']);
                $team->setContent($_POST['content']);
                $team->setIdLevel($_POST['id_level']);
                $team->setIdSeason($_POST['id_season']);
                $team->setImage($result_file);
                $team->insert();
            }
        }
        $this->renderView('admin/insert_team', [
            "seasons" =>  $seasons,
            "levels" =>  $levels
        ]);
    }
    //la methode mise à jour d'une équipe
    public function edit()
    {
        //réservée à l'admin
        new SessionVerify();
        $team = Teams::getOne($_GET['id']);
        $levels = Level::getMany();
        $seasons = Season::getMany();
        if (isset($_POST['name'])) {
            $team->setName($_POST['name']);
            $team->setContent($_POST['content']);
            $team->setIdLevel($_POST['id_level']);
            $team->setIdSeason($_POST['id_season']);
            //s'il y'a une nouvelle image on remplace l'ancienne
            if (!empty($_FILES['image'])) {
                $result_file = $this->uploadImage('uploads/', "image");
                if ($result_file) {
                    unlink("uploads" . DIRECTORY_SEPARATOR . $team->getImage());
                    $team->setImage($result_file);
                }
            } else
            //sinon on garde l'ancienne
            {
                $team->setImage($team->getImage());
            }
            $team->edit();
            $this->redirectTo("index.php?controller=Teams&action=list");
        }
        $this->renderView('admin/edit_team', [
            'seasons' =>  $seasons,
            'levels' =>  $levels,
            'team' => $team
        ]);
    }
    //la methode effacer équipe
    public function delete()
    {
        //réservée à l'admin
        new SessionVerify();
        $team = Teams::getOne($_GET['id']);
        if ($team instanceof Teams) {
            $image = $team->getImage();
            $team->delete();
            unlink('uploads/' . $image);
        }
        $this->redirectToRoute("Teams", "list");
    }
}
