<?php
class Post
{
    private $id;
    private $title;
    private $content;
    private $id_category;
    private $image;
    private $createdAt;
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
    public function getIdCategory()
    {
        return $this->id_category;
    }
    public function setIdCategory($id_category): void
    {
        $this->id_category = $id_category;
    }
    public function getImage()
    {
        return $this->image;
    }
    public function setImage($image): void
    {
        $this->image = $image;
    }
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    public function setCreatedAt($createdAt): void
    {
        $this->createdAt = $createdAt;
    }
    //on récupère un article par son id
    public static function getOne(int $id)
    {
        $db = new Database();
        $post = $db->getOne("SELECT id, title, content, createdAt, id_category, image FROM post WHERE id = ?", [$id], 'Post');
        return $post;
    }
    //on récupère tous les articles
    public static  function getMany()
    {
        $db = new Database();
        $posts = $db->getMany("SELECT post.id, title, content, id_category, image, createdAt, name FROM post INNER JOIN category ON post.id_category=category.id ORDER BY createdAt DESC", 'Post');
        return $posts;
    }
    //on crée un nouveau article
    public function insert()
    {
        $db = new Database();
        $db->insert(
            "INSERT INTO post (title, content, id_category, image) VALUES (?,?,?,?)",
            [
                $this->title,
                $this->content,
                $this->id_category,
                $this->image
            ]
        );
    }
    //on met à jour un article
    public function edit()
    {
        $db = new Database();
        return $db->updateOrDelete(
            "
                UPDATE post SET title= ? , content = ? , id_category = ? ,  image = ? WHERE id = ?",
            [
                $this->title,
                $this->content,
                $this->id_category,
                $this->image,
                $this->id
            ]
        );
    }
    //on supprime un article par son id
    public function delete()
    {
        $db = new Database();
        return $db->updateOrDelete('DELETE FROM post WHERE id = ?', [$this->id]);
    }
}
