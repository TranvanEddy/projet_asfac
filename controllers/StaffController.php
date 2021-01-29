<?php
class StaffController extends Controller
{
    //la methode qui affiche la page
    public function index()
    {
        $this->renderView('staff');
    }
}
