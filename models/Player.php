<?php
class Player
{
    private $id_player;
    private $firstNamePlayer;
    private $lastNamePlayer;
    private $id_teams;
    private $image;
    private $id_position;
    
    public function getIdPlayer()
    {
        return $this->id_player;
    }
    public function getFirstNamePlayer()
    {
        return $this->firstNamePlayer;
    }
    public function setFirstNamePlayer($firstNamePlayer): void
    {
        $this->firstNamePlayer = $firstNamePlayer;
    }
    public function getLastNamePlayer()
    {
        return $this->lastNamePlayer;
    }
    public function setLastNamePlayer($lastNamePlayer): void
    {
        $this->lastNamePlayer = $lastNamePlayer;
    }
    public function getIdTeams()
    {
        return $this->id_teams;
    }
    public function setIdTeams($id_teams): void
    {
        $this->id_teams = $id_teams;
    }
    public function getImage()
    {
        return $this->image;
    }
    public function setImage($image): void
    {
        $this->image = $image;
    }
    public function getIdPosition()
    {
        return $this->id_position;
    }
    public function setIdPosition($id_position): void
    {
        $this->id_position = $id_position;
    }
    //on récupère tous les joueurs
    public static function getMany()
    {
        $db = new Database();
        $players = $db->getMany("SELECT player.id_player, firstNamePlayer, lastNamePlayer, id_teams, player.image, player.id_position, poste, name FROM player INNER JOIN position ON player.id_position=position.id_position INNER JOIN teams ON player.id_teams=teams.id ", 'Player');
        return $players;
    }
    //on récupère un joueur par son id
    public static function getOne(int $id_player)
    {
        
        $db = new Database();
        $player = $db->getOne("SELECT player.id_player, firstNamePlayer, lastNamePlayer, id_teams, player.image, player.id_position, poste, name FROM player INNER JOIN position ON player.id_position=position.id_position INNER JOIN teams ON player.id_teams=teams.id WHERE id_player = ?", [$id_player], 'Player');
        return $player;
    }
    //on crée un nouveau joueur
    public function insert()
    {
        $db = new Database();
        $db->insert(
            "INSERT INTO player (firstNamePlayer, lastNamePlayer, id_teams, image, id_position) VALUES (?,?,?,?,?)",
            [
                $this->firstNamePlayer,
                $this->lastNamePlayer,
                $this->id_teams,
                $this->image,
                $this->id_position
            ]
        );
    }
    //on met à jour un joueur
    public function edit()
    {
        $db = new Database();
        return $db->updateOrDelete(
            "
                UPDATE player SET firstNamePlayer = ? , lastNamePlayer = ? , id_teams = ? ,  image = ? , id_position =? WHERE id_player = ?",
            [
                $this->firstNamePlayer,
                $this->lastNamePlayer,
                $this->id_teams,
                $this->image,
                $this->id_position,
                $this->id_player
            ]
        );
    }
     //on supprime un joueur par son id
    public function delete()
    {
        $db = new Database();
        return $db->updateOrDelete('DELETE FROM player WHERE id_player = ?', [$this->id_player]);
    }
}