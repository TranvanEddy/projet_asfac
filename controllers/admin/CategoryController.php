<?php
class CategoryController extends Controller
{
    //accès résrervé à l'admin
    public function __construct()
    {
        new SessionVerify();
    }
    //la methode liste toutes les catégories
    public function index()
    {
        $categorys = Category::getMany();
        $this->renderView('admin/list_category', [
            'categorys' => $categorys
        ]);
    }
    //la methode qui récupère la catégorie concernée par l'id de la news 
    public function getOne()
    {
        $category = Category::getOne($_POST['id']);
        $this->renderView('admin/list_news', [
            'category' => $category
        ]);
    }
    //la methode insertion d'une nouvelle catégorie
    public function insert()
    {
        if (isset($_POST['name'])) {
            $category = new Category();
            $category->setName($_POST['name']);
            $category->insert();
        }
        $this->renderView('admin/insert_category');
    }
    // la methode de mise a jour d'une catégorie
    public function edit()
    {
        $category = Category::getOne($_GET['id']);
        if (isset($_POST['name'])) {
            $category->setName($_POST['name']);
            $category->setId($category->getId());
            $category->edit();
            $this->redirectTo("index.php?controller=Category");
        }
        $this->renderView('admin/edit_category', [
            "category" =>  $category
        ]);
    }
}
