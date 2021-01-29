<?php
class Teams
{
    private $id;
    private $name;
    private $image;
    private $id_level;
    private $id_season;
    private $content;
    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setName($name): void
    {
        $this->name = $name;
    }
    public function getImage()
    {
        return $this->image;
    }
    public function setImage($image): void
    {
        $this->image = $image;
    }
    public function getIdLevel()
    {
        return $this->id_level;
    }
    public function setIdLevel($id_level): void
    {
        $this->id_level = $id_level;
    }
    public function getIdSeason()
    {
        return $this->id_season;
    }
    public function setIdSeason($id_season): void
    {
        $this->id_season = $id_season;
    }
    public function getContent()
    {
        return $this->content;
    }
    public function setContent($content): void
    {
        $this->content = $content;
    }
    //on récupère toutes les équipes selon la sélection
    public static function getMany($id_season , $id_level = null)
    //si aucun niveau sélectionné
    {
        $db = new Database();
        $params = [$id_season];
        $level_request = "";
        if ($id_level != null) //si un niveau sélectionné
        {
            $level_request = "AND id_level=?";
            $params[] = $id_level;
        }
        $teams = $db->getMany(
            "SELECT teams.id, teams.name, `level`.`name`, `image`, id_level, id_season, content 
                                FROM teams 
                                INNER JOIN season ON teams.id_season=season.id 
                                INNER JOIN `level` ON teams.id_level=`level`.id 
                                WHERE id_season=?" . $level_request,
            'Teams',
            $params
        );
        return $teams;
    }
    //on récupère toutes les équipes
    public static function getAll()
    {
        $db = new Database();
        $teams = $db->getMany(
            "SELECT teams.id, teams.name, `level`.`name`, `image`, id_level, id_season, content 
                                FROM teams 
                                INNER JOIN season ON teams.id_season=season.id 
                                INNER JOIN `level` ON teams.id_level=`level`.id 
                               ",
            'Teams'
        );
        return $teams;
    }
    //on récupère une équipe par son id
    public static function getOne($id)
    {
        $db = new Database();
        $team = $db->getOne("SELECT id, name, image, id_level, id_season, content FROM teams WHERE id=?", [$id], 'Teams');
        return $team;
    }
    //on insert une nouvelle équipe
    public function insert()
    {
        $db = new Database();
        $db->insert(
            "INSERT INTO teams (name, content, id_level, id_season, image) VALUES (?,?,?,?,?)",
            [
                $this->name,
                $this->content,
                $this->id_level,
                $this->id_season,
                $this->image
            ]
        );
    }
    //on met à jour une équipe
    public function edit()
    {
        $db = new Database();
        return $db->updateOrDelete(
            "
                UPDATE teams SET name= ? , content = ? , id_level = ? , id_season = ? ,  image = ? WHERE id = ?",
            [
                $this->name,
                $this->content,
                $this->id_level,
                $this->id_season,
                $this->image,
                $this->id
            ]
        );
    }
    //on supprime une équipe par son id
    public function delete()
    {
        $db = new Database();
        return $db->updateOrDelete('DELETE FROM teams WHERE id = ?', [$this->id]);
    }
    //on retourne en chaine de caractère
    public function __toString()
    {
        return $this->name;
    }

}
