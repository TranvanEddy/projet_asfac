<?php
class Category
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
    //on récupère toutes les catégories
    public static function getMany()
    {
        $db = new Database();
        $categorys = $db->getMany("SELECT id, name FROM category", 'Category');
        return $categorys;
    }
    //on récupère une catégorie par son id 
    public static function getOne($id)
    {
        $db = new Database();
        $category = $db->getOne("SELECT id, name FROM category WHERE id=?", [$id], 'Category');
        return $category;
    }
    //on insert une nouvelle catégorie
    public function insert()
    {
        $db = new Database();
        $db->insert(
            "INSERT INTO category (name) VALUES ( ? )",
            [$this->name]
        );
    }
    //on met à jour une catégorie
    public function edit()
    {
        $db = new Database();
        return $db->updateOrDelete(
            "UPDATE category SET name = ? WHERE id = ?",
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
