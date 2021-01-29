<?php
class Contact
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
    //on recupère tous les contacts
    public static function getAll()
    {
        $db = new Database();
        $contacts = $db->getMany(
            "SELECT id, nom, prenom, adresse, telephone, email, message 
                                FROM contact
                                ORDER BY id DESC",
            'Contact'
        );
        return $contacts;
    }
    //on récupère un contact par son id
    public static function getOne($id)
    {
        $db = new Database();
        $contact = $db->getOne("SELECT id, nom, prenom, adresse, telephone, email, message 
                                FROM contact WHERE id=?", [$id], 'Contact');
        return $contact;
    }
    //on insert un nouveau contact  
    public function insert()
    {
        $db = new Database();
        $db->insert(
            "INSERT INTO contact (nom, prenom, adresse, telephone, email, message) VALUES (?,?,?,?,?,?)",
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
    //on efface un contact
    public function delete()
    {
        $db = new Database();
        return $db->updateOrDelete('DELETE FROM contact WHERE id = ?', [$this->id]);
    }
}
