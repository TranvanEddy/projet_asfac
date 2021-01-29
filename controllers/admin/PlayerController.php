<?php
class PlayerController extends Controller
{
    //la methode de séléction des joueurs
    public function index()
    {
        //$seasons = Season::getMany();
        //$levels = Level::getMany();
        $teams = Teams::getAll();
        $positions = Position::getMany();
        $this->renderView('teams', [
            //"seasons" =>  $seasons,
            //"levels" =>  $levels,
            "teams" => $teams,
            "positions" => $positions
        ]);
    }
    //la methode qui liste tous les joueurs
    public function list()
    {
        //réservée à l'admin
        new SessionVerify();
        //$seasons = Season::getMany();
        //$levels = Level::getMany();
        $teams = Teams::getAll();
        $positions = Position::getMany();
        $players = Player::getMany();
        $this->renderView('admin/list_player', [
            //"seasons" =>  $seasons,
            //"levels" =>  $levels,
            "teams" =>  $teams,
            "positions" => $positions,
            "players" => $players
        ]);
    }
    //la méthode qui crée un nouveau joueur
    public function insert()
    {
        //réservée à l'admin
        new SessionVerify();
        //$seasons = Season::getMany();
        //$levels = Level::getMany();
        $teams = Teams::getAll();
        $positions = Position::getMany();
        if (isset($_POST['lastNamePlayer'])) {
            $result_file = $this->uploadImage('uploads/', "image");
            if ($result_file) {
                $player = new Player();
                $player->setFirstNamePlayer($_POST['firstNamePlayer']);
                $player->setLastNamePlayer($_POST['lastNamePlayer']);
                $player->setIdTeams($_POST['id_teams']);
                $player->setImage($result_file);
                $player->setIdPosition($_POST['id_position']);
                $player->insert();
            }
        }
        $this->renderView('admin/insert_player', [
            "teams" =>  $teams,
            "positions" =>  $positions
        ]);
    }
    public function edit()
    {
        //réservée à l'admin
        new SessionVerify();
        $player = Player::getOne($_GET['id']);
        $teams = Teams::getAll();
        $positions = Position::getMany();
        if (isset($_POST['lastNamePlayer'])) {
            $player->setFirstNamePlayer($_POST['firstNamePlayer']);
            $player->setLastNamePlayer($_POST['lastNamePlayer']);
            $player->setIdTeams($_POST['id_teams']);
            $player->setIdPosition($_POST['id_position']);
            //s'il y'a une nouvelle image on remplace l'ancienne
            if (!empty($_FILES['image'])) {
                $result_file = $this->uploadImage('uploads/', "image");
                if ($result_file) {
                    unlink("uploads" . DIRECTORY_SEPARATOR . $player->getImage());
                    $player->setImage($result_file);
                }
            } else
            //sinon on garde l'ancienne
            {
                $player->setImage($player->getImage());
            }
            $player->edit();
           /* $this->redirectTo("index.php?controller=Player&action=list");*/
        }
        $this->renderView('admin/edit_player', [
            'player' =>  $player,
            'positions' =>  $positions,
            'teams' => $teams
        ]);
    }
    //la methode effacer joueur
    public function delete()
    {
        //réservée à l'admin
        new SessionVerify();
        $player = Player::getOne($_GET['id']);
        if ($player instanceof Player) {
            $image = $player->getImage();
            $player->delete();
            unlink('uploads/' . $image);
        }
        $this->redirectToRoute("Player", "list");
    }
}
