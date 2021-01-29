<?php
class LinkController extends Controller
{
    //la methode qui affiche la page
public function index()
    {
    $this->renderView('link');
    }
}