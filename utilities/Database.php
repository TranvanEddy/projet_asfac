<?php
class Database
{
    private $cnx;
    public function __construct()
    {
        try {
            $this->cnx = new PDO(
                "mysql:host=" . DATABASE['host'] . ";dbname=" . DATABASE['dbname'] . ";charset=utf8",
                DATABASE['user'],
                DATABASE['password']
            );
        } catch (PDOException $exception) {
            die($exception->getMessage());
        }
    }
    public function getOne(string $request, array $params, string $class)
    {
        $query = $this->cnx->prepare($request);
        $query->execute($params);
        $query->setFetchMode(PDO::FETCH_CLASS, $class);
        $result = $query->fetch();
        return $result;
    }
    public function getMany(string $request, string $class, array $params = [])
    {
        $query = $this->cnx->prepare($request);
        $query->execute($params);
        $result = $query->fetchAll(PDO::FETCH_CLASS, $class);
        return $result;
    }
    public function insert(string $request, array $params)
    {
        $query = $this->cnx->prepare($request);
        $query->execute($params);
        // retourne l'id du dernier élément inséré dans la bdd
        $lastId = ($this->cnx)->lastInsertId();
        return $lastId;
    }
    //Mettre à jour ou Supprimer une ligne (élément) de la BDD
    public function updateOrDelete(string $request, array $params): bool
    {
        $query = $this->cnx->prepare($request);
        $result = $query->execute($params);
        return $result;
    }
    public function __destruct()
    {
        $this->cnx = null;
    }
}
