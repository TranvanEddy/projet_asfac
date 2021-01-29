<?php
class Becomepartner
{
    private $id;
    private $nom;
    private $prenom;
    private $adresse;
    private $telephone;
    private $email;
    private $message;
    public function getId()
    {
        return $this->id;
    }
    public function getNom()
    {
        return $this->nom;
    }
    public function setNom($nom): void
    {
        $this->nom = $nom;
    }
    public function getPrenom()
    {
        return $this->prenom;
    }
    public function setPrenom($prenom): void
    {
        $this->prenom = $prenom;
    }
    public function getAdresse()
    {
        return $this->adresse;
    }
    public function setAdresse($adresse): void
    {
        $this->adresse = $adresse;
    }
    public function getTelephone()
    {
        return $this->telephone;
    }
    public function setTelephone($telephone): void
    {
        $this->telephone = $telephone;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email): void
    {
        $this->email = $email;
    }
    public function getMessage()
    {
        return $this->message;
    }
    public function setMessage($message): void
    {
        $this->message = $message;
    }
    //on récupère tout
    public static function getAll()
    {
        $db = new Database();
        $partners = $db->getMany(
            "SELECT id, nom, prenom, adresse, telephone, email, message 
                                FROM partner
                                ORDER BY id DESC",
            'Becomepartner'
        );
        return $partners;
    }
    //on récupère un par son id
    public static function getOne($id)
    {
        $db = new Database();
        $partner = $db->getOne("SELECT id, nom, prenom, adresse, telephone, email, message 
                                FROM partner WHERE id=?", [$id], 'Becomepartner');
        return $partner;
    }
    //on insert un nouveau
    public function insert()
    {
        $db = new Database();
        $db->insert(
            "INSERT INTO partner (nom, prenom, adresse, telephone, email, message) VALUES (?,?,?,?,?,?)",
            [
                $this->nom,
                $this->prenom,
                $this->adresse,
                $this->telephone,
                $this->email,
                $this->message
            ]
        );
    }
    //on efface un par son id 
    public function delete()
    {
        $db = new Database();
        return $db->updateOrDelete('DELETE FROM partner WHERE id = ?', [$this->id]);
    }
}
