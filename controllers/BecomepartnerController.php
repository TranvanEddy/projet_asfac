<?php
class BecomepartnerController extends Controller
{
    //la methode qui affiche la page
    public function index()
    {
        $this->renderView('becomepartner');
    }
    //la methode qui liste les futurs partenaires
    public function list()
    {
        //réservée à l'admin
        new SessionVerify();
        $partners = Becomepartner::getAll();
        $this->renderView('admin/list_partner', [
            "partners" =>  $partners
        ]);
    }
    //la methode qui insert le formulaire en bdd 
    public function insert()
    {
        if (isset($_POST['lastName'])) {
            //les if servent a insérer les champs non obligatoires seulement s'ils sont remplis 
            $partner = new Becomepartner();
            $partner->setNom($_POST['lastName']);
            if (!empty($_POST['firstName'])) {
                $partner->setPrenom($_POST['firstName']);
            }
            if (!empty($_POST['address'])) {
                $partner->setAdresse($_POST['address']);
            }
            if (!empty($_POST['phone'])) {
                $partner->setTelephone($_POST['phone']);
            }
            $partner->setEmail($_POST['email']);
            $partner->setMessage($_POST['message']);
            $partner->insert();
        }
        $this->renderView('becomepartner', [
            'partner' => $partner
        ]);
    }
    //la methode de suppression 
    public function delete()
    {
        //réservée à l'admin
        new SessionVerify();
        $partner = Becomepartner::getOne($_GET['id']);
        if ($partner instanceof Becomepartner) {
            $partner->delete();
        }
        $this->redirectToRoute("becomepartner", "list");
    }
    //la methode qui affiche toutes les infos par l'id
    public function lookDetails()
    {
        new SessionVerify();
        $partner = Becomepartner::getOne($_GET['id']);
        $this->renderView('admin/lookpartner', [
            'partner' =>  $partner
        ]);
    }
}
