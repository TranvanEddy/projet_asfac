<?php
class SponsorsController extends Controller
{
    //la methode qui liste tous les sponsors
    public function index()
    {
        //réservée à l'admin
        new SessionVerify();
        $sponsors = Sponsors::getMany();
        $this->renderView('admin/list_sponsors', [
            'sponsors' => $sponsors
        ]);
    }
    //la methode qui affiche tous les sponsors
    public function show()
    {
        $sponsors = Sponsors::getMany();
        $this->renderView('sponsors', [
            'sponsors' => $sponsors
        ]);
    }
    //la methode qui crée un nouveau sponsor
    public function insert()
    {
        //réservée à l'admin
        new SessionVerify();
        if (isset($_POST['title'])) {
            $sponsor = new Sponsors();
            $sponsor->setTitle($_POST['title']);
            $sponsor->setContent($_POST['content']);
            $result_file = $this->uploadImage('uploads/', "image");
            if ($result_file) {
                $sponsor->setImage($result_file);
            }
            $sponsor->insert();
            $this->redirectTo("index.php?controller=Sponsors");
        }
        $this->renderView('admin/insert_sponsors');
    }
    //la methode de mise à jour d'un sponsor
    public function edit()
    {
        //réservée à l'admin
        new SessionVerify();
        $sponsor = Sponsors::getOne($_GET['id']);
        if (isset($_POST['title'])) {
            $sponsor->setTitle($_POST['title']);
            $sponsor->setContent($_POST['content']);
            //s'il y'a une nouvelle image, on remplace l'ancienne
            if (!empty($_FILES['image'])) {
                $result_file = $this->uploadImage('uploads/', "image");
                if ($result_file) {
                    unlink("uploads" . DIRECTORY_SEPARATOR . $sponsor->getImage());
                    $sponsor->setImage($result_file);
                }
            }
            //sinon on garde l'ancienne
            else {
                $sponsor->setImage($sponsor->getImage());
            }
            $sponsor->edit();
            $this->redirectTo("index.php?controller=Sponsors");
        }
        $this->renderView('admin/edit_sponsors', [
            'sponsor' => $sponsor
        ]);
    }
    //la methode de suppression d'un sponsor
    public function delete()
    {
        //réservée à l'admin
        new SessionVerify();
        $sponsor = Sponsors::getOne($_GET['id']);
        if ($sponsor instanceof Sponsors) {
            $image = $sponsor->getImage();
            $sponsor->delete();
            unlink('uploads/' . $image);
        }
        $this->redirectToRoute("Sponsors", "index");
    }
}
