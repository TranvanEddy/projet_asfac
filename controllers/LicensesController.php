<?php
class LicensesController extends Controller
{
    //la methode qui affiche la page
    public function index()
    {
        $this->renderView('licenses');
    }
}
