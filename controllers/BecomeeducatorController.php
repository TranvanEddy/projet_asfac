<?php
class BecomeeducatorController extends Controller
{
    //la methode qui affiche la page
    public function index()
    {
        $this->renderView('becomeeducator');
    }
    // la methode qui liste les candidatures
    public function list()
    {
        //réservée à l'admin
        new SessionVerify();
        $educators = Becomeeducator::getAll();
        $this->renderView('admin/list_educators', [
            "educators" =>  $educators
        ]);
    }
    //la methode qui insert le formulaire en bdd
    public function insert()
    {
        if (isset($_POST['lastName'])) {
            //les if servent a insérer les champs non obligatoires seulement s'ils sont remplis 
            $educator = new Becomeeducator();
            $educator->setNom($_POST['lastName']);
            if (!empty($_POST['firstName'])) {
                $educator->setPrenom($_POST['firstName']);
            }
            if (!empty($_POST['address'])) {
                $educator->setAdresse($_POST['address']);
            }
            if (!empty($_POST['phone'])) {
                $educator->setTelephone($_POST['phone']);
            }
            $educator->setEmail($_POST['email']);
            $educator->setMessage($_POST['message']);
            $result_file = $this->uploadImage('uploads/', "image");
            if ($result_file) {
                $educator->setImage($result_file);
            }
            $educator->insert();
        }
        $this->renderView('becomeeducator', [
            'educator' =>  $educator
        ]);
    }
    //la methode de suppression
    public function delete()
    {
        //réservée à l'admin
        new SessionVerify();
        $educator = Becomeeducator::getOne($_GET['id']);
        if ($educator instanceof Becomeeducator) {
            $image = $educator->getImage();
            $educator->delete();
            unlink('uploads/' . $image);
        }
        $this->redirectToRoute("becomeeducator", "list");
    }
    //la methode qui affiche toutes les infos par l'id
    public function lookCv()
    {
        new SessionVerify();
        $educator = Becomeeducator::getOne($_GET['id']);
        $this->renderView('admin/lookcv', [
            'educator' =>  $educator
        ]);
    }
}
