<?php
class ContactController extends Controller
{
    //la methode afficher page
    public function index()
    {
        $this->renderView('contact');
    }
    //la methode liste tous les contacts
    public function list()
    {
        //réservée a l'admin
        new SessionVerify();
        $contacts = Contact::getAll();
        $this->renderView('admin/list_contact', [
            "contacts" =>  $contacts
        ]);
    }
    //la methode insertion du formulaire de contact
    public function insert()
    {
        if (isset($_POST['lastName'])) {
            //les if servent a insérer les champs non obligatoires seulement s'ils sont remplis 
            $contact = new Contact();
            $contact->setNom($_POST['lastName']);
            if (!empty($_POST['firstName'])) {
                $contact->setPrenom($_POST['firstName']);
            }
            if (!empty($_POST['address'])) {
                $contact->setAdresse($_POST['address']);
            }
            if (!empty($_POST['phone'])) {
                $contact->setTelephone($_POST['phone']);
            }
            $contact->setEmail($_POST['email']);
            $contact->setMessage($_POST['message']);
            $contact->insert();
        }
        $this->renderView('contact', [
            'contact' => $contact
        ]);
    }
    //la methode suppression
    public function delete()
    {
        //reservée à l'admin
        new SessionVerify();
        $contact = Contact::getOne($_GET['id']);
        if ($contact instanceof Contact) {
            $contact->delete();
        }
        $this->redirectToRoute("Contact", "list");
    }
    //la methode qui affiche toutes les infos par l'id du contact
    public function lookDetails()
    {
        new SessionVerify();
        $contact = Contact::getOne($_GET['id']);
        $this->renderView('admin/lookcontact', [
            'contact' =>  $contact
        ]);
    }
}
