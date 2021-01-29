<?php
class Season
{
    private $id;
    private $name;
    public function getId()
    {
        return $this->id;
    }
    public function setId($id): void
    {
        $this->id = $id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setName($name): void
    {
        $this->name = $name;
    }
    //on récupère toutes les saisons
    public static function getMany()
    {
        $db = new Database();
        $seasons = $db->getMany("SELECT id, name FROM season", 'Season');
        return $seasons;
    }
    //on récupère une saison par son id
    public static function getOne($id)
    {
        $db = new Database();
        $season = $db->getOne("SELECT id, name FROM season WHERE id=?", [$id], 'Season');
        return $season;
    }
    //on crée une nouvelle saison
    public function insert()
    {
        $db = new Database();
        return $db->insert(
            "INSERT INTO season (name) VALUES ( ? )",
            [$this->name]
        );
    }
    //on met à jour une nouvelle saison
    public function edit()
    {
        $db = new Database();

        return $db->updateOrDelete(
            "UPDATE season SET name = ? WHERE id = ?",
            [
                $this->name,
                $this->id
            ]
        );
    }
    //on retourne en chaine de caractère
    public function __toString()
    {
        return $this->name;
    }
}
