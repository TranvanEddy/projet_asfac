<?php
class Sponsors
{
    private $id;
    private $title;
    private $content;
    private $image;
    public function getId()
    {
        return $this->id;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function setTitle($title): void
    {
        $this->title = $title;
    }
    public function getContent()
    {
        return $this->content;
    }
    public function setContent($content): void
    {
        $this->content = $content;
    }
    public function getImage()
    {
        return $this->image;
    }
    public function setImage($image): void
    {
        $this->image = $image;
    }
    //on récupère un sponsor par son id
    public static function getOne(int $id)
    {
        $db = new Database();
        $sponsor = $db->getOne("SELECT id, title, content, `image` FROM sponsors WHERE id = ?", [$id], 'Sponsors');
        return $sponsor;
    }
    //on récupère tous les sponsors
    public static  function getMany()
    {
        $db = new Database();
        $sponsors = $db->getMany("SELECT id, title, content, `image` FROM sponsors", 'sponsors');
        return $sponsors;
    }
    //on crée un nouveau sponsor
    public function insert()
    {
        $db = new Database();
        $db->insert(
            "INSERT INTO sponsors (title, content, `image`) VALUES ( ?,?,? )",
            [
                $this->title,
                $this->content,
                $this->image
            ]
        );
    }
    //on met à jour un sponsor
    public function edit()
    {
        $db = new Database();
        return $db->updateOrDelete(
            "
                UPDATE sponsors SET title= ? , content = ? ,  image = ? WHERE id = ?",
            [
                $this->title,
                $this->content,
                $this->image,
                $this->id
            ]
        );
    }
    //on supprime un sponsor par son id
    public function delete()
    {
        $db = new Database();
        return $db->updateOrDelete('DELETE FROM sponsors WHERE id = ?', [$this->id]);
    }
}
