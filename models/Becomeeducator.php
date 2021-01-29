<?php
class Becomeeducator
{
    private $id;
    private $nom;
    private $prenom;
    private $adresse;
    private $telephone;
    private $email;
    private $message;
    private $image;
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
    public function getImage()
    {
        return $this->image;
    }
    public function setImage($image): void
    {
        $this->image = $image;
    }
    //on récupère tout
    public static function getAll()
    {
        $db = new Database();
        $educators = $db->getMany(
            "SELECT id, nom, prenom, adresse, telephone, email, message, image 
                                FROM educator
                                ORDER BY id DESC",
            'Becomeeducator'
        );
        return $educators;
    }
    //on récupère un par son  id
    public static function getOne($id)
    {
        $db = new Database();
        $educator = $db->getOne("SELECT id, nom, prenom, adresse, telephone, email, message, image 
                                FROM educator WHERE id=?", [$id], 'Becomeeducator');
        return $educator;
    }
    //on insert un nouveau 
    public function insert()
    {
        $db = new Database();
        $db->insert(
            "INSERT INTO educator (nom, prenom, adresse, telephone, email, message, image) VALUES (?,?,?,?,?,?,?)",
            [
                $this->nom,
                $this->prenom,
                $this->adresse,
                $this->telephone,
                $this->email,
                $this->message,
                $this->image
            ]
        );
    }
    //on efface un par son id
    public function delete()
    {
        $db = new Database();
        return $db->updateOrDelete('DELETE FROM educator WHERE id = ?', [$this->id]);
    }
}
