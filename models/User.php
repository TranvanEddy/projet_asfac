<?php
class User
{
    private $userId;
    private $userName;
    private $email;
    private $password;

    public function getUserId()
    {
        return $this->userId;
    }
    public function setUserId($userId): void
    {
        $this->userId = $userId;
    }
    public function getUserName()
    {
        return $this->userName;
    }
    public function setUserName($userName): void
    {
        $this->userName = $userName;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email): void
    {
        $this->email = $email;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function setPassword($password): void
    {
        $this->password = $password;
    }
    //on récupère tous les utilisateurs
    public static function getMany()
    {
        $db = new Database();
        $users = $db->getMany("SELECT userId, userName, email, password FROM user", 'User');
        return $users;
    }
    //on récupère un utilisateur par son id 
    public static function getOne($userId)
    {
        $db = new Database();
        $user = $db->getOne("SELECT userId, userName, email, password FROM user WHERE userId=?", [$userId], 'User');
        return $user;
    }
    //on récupère un utilisateur par son adresse mail
    public function getOneByEmail($email)
    {
        $db = new Database();
        $user = $db->getOne("SELECT * FROM `user` WHERE Email= ?", [$email], 'User');
        return $user;
    }

    //on insert une nouveau utilisateur
    public function insert()
    {
        $db = new Database();
        $db->insert(
            "INSERT INTO user (userName, email, password) VALUES (?,?,?)",
            [
                $this->userName,
                $this->email,
                //$this->password
                password_hash($this->password, PASSWORD_BCRYPT)
            ]
        );
    }
    //on met à jour un utilisateur
    public function edit()
    {
        $db = new Database();
        return $db->updateOrDelete(
            "UPDATE user SET userName = ?, email = ?, password = ? WHERE userId = ?",
            [
                $this->userName,
                $this->email,
                $this->password,
                $this->userId
            ]
        );
    }
    //on supprime un utilisateur par son id
    public function delete()
    {
        $db = new Database();
        return $db->updateOrDelete('DELETE FROM user WHERE userId = ?', [$this->userId]);
    }
}
