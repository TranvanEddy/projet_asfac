<?php
class TrainingController extends Controller
{
    //la methode qui affiche la page
    public function index()
    {
        $this->renderView('training');
    }
}
