<?php
class FrontController extends Controller
{
    //la methode qui affiche la page d'acceuil  
    public function index()
    {
        $sponsors = Sponsors::getMany();
        $posts = Post::getMany();
        $this->renderView('index', [
            'posts' => $posts,
            'sponsors' => $sponsors
        ]);
    }
}
