<?php
class Position
{
    private $id_position;
    private $poste;
    
    public function getIdPosition()
    {
        return $this->id_position;
    }
    public function setIdPosition($id_position): void
    {
        $this->id_position = $id_position;
    }
    public function getPoste()
    {
        return $this->poste;
    }
    public function setPoste($poste): void
    {
        $this->poste = $poste;
    }
    //on récupère tous les postes
    public static function getMany()
    {
        $db = new Database();
        $positions = $db->getMany("SELECT id_position, poste FROM position", 'Position');
        return $positions;
    }
    //on récupère un poste par son id 
    public static function getOne($id_position)
    {
        $db = new Database();
        $position = $db->getOne("SELECT id_position, poste FROM position WHERE id_position=?", [$id_position], 'Position');
        return $position;
    }
    //on insert un nouveau poste
    public function insert()
    {
        $db = new Database();
        $db->insert(
            "INSERT INTO position (poste) VALUES ( ? )",
            [$this->poste]
        );
    }
    //on met à jour un poste
    public function edit()
    {
        $db = new Database();
        return $db->updateOrDelete(
            "UPDATE position SET poste = ? WHERE id_position = ?",
            [
                $this->poste,
                $this->id_position
            ]
        );
    }
    //on retourne en chaine de caractère
    public function __toString()
    {
        return $this->poste;
    }
}