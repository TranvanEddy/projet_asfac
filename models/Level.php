<?php
class Level
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
    //on récupère tous les levels
    public static function getMany()
    {
        $db = new Database();
        $levels = $db->getMany("SELECT id, name FROM level", 'level');
        return $levels;
    }
    //on récupère un level par son id
    public static function getOne($id)
    {
        $db = new Database();
        $level = $db->getOne("SELECT id, name FROM level WHERE id=?", [$id], 'level');
        return $level;
    }
    //on crée un nouveau level
    public function insert()
    {
        $db = new Database();
        return $db->insert(
            "INSERT INTO level (name) VALUES ( ? )",
            [$this->name]
        );
    }
    //on met à jour un level
    public function edit()
    {
        $db = new Database();
        return $db->updateOrDelete(
            "UPDATE level SET name = ? WHERE id = ?",
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
