<?php
class NewsController extends Controller
{
    //la methode qui affiche toutes les news
    public function index()
    {
        $posts = Post::getMany();
        $this->renderView('news', [
            'posts' => $posts
        ]);
    }
    //la methode qui liste toutes les news
    public function list()
    {
        //réservée à l'admin
        new SessionVerify();
        $posts = Post::getMany();
        $categorys = Category::getMany();
        $this->renderView('admin/list_news', [
            'posts' => $posts,
            'categorys' => $categorys
        ]);
    }
    //la methode qui affiche la news sélectionnée par son id
    public function show()
    {
        $post = Post::getOne($_GET['id']);
        $this->renderView('show_post', [
            'post' => $post
        ]);
    }
    //la methode qui crée une nouvelle news
    public function insert()
    {
        //réservée à l'admin
        new SessionVerify();
        $categorys = Category::getMany();
        if (isset($_POST['title'])) {
            $result_file = $this->uploadImage('uploads/', "image");
            if ($result_file) {
                $post = new Post();
                $post->setTitle($_POST['title']);
                $post->setContent($_POST['content']);
                $post->setIdCategory($_POST['id_category']);
                $post->setImage($result_file);
                $post->insert();
            }
        }
        $this->renderView('admin/insert_news', [
            'categorys' =>  $categorys,
        ]);
    }
    //la methode de mise à jour d'une news
    public function edit()
    {
        //réservée à l'admin
        new SessionVerify();
        $post = Post::getOne($_GET['id']);
        $categorys = Category::getMany();
        if (isset($_POST['title'])) {
            $post->setTitle($_POST['title']);
            $post->setContent($_POST['content']);
            $post->setIdCategory($_POST['id_category']);
            //s'il y'a une nouvelle image, on remplace l'ancienne
            if (!empty($_FILES['image'])) {
                $result_file = $this->uploadImage('uploads/', "image");
                if ($result_file) {
                    unlink("uploads" . DIRECTORY_SEPARATOR . $post->getImage());
                    $post->setImage($result_file);
                }
            }
            //sinon on garde l'ancienne
            else {
                $post->setImage($post->getImage());
            }
            $post->edit();
            $this->redirectTo("index.php?controller=News&action=list");
        }
        $this->renderView('admin/edit_news', [
            'categorys' =>  $categorys,
            'post' => $post
        ]);
    }
    //la méthode de suppression d'une news
    public function delete()
    {
        //réservée à l'admin
        new SessionVerify();
        $post = Post::getOne($_GET['id']);
        if ($post instanceof Post) {
            $image = $post->getImage();
            $post->delete();
            unlink('uploads/' . $image);
        }
        $this->redirectToRoute("News", "list");
    }
}
