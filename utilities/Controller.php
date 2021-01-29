<?php
abstract class Controller
{
    //la methode qui affiche la vue
    public function renderView(string $view, array $params = [])
    {
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                ${$key}  = $value;
            }
        }
        $template = "views/$view.phtml";
        include 'views/layout.phtml';
    }
    //la methode de redirection par paramètres
    public function redirectToRoute($controller, $action)
    {
        header("Location: index.php?controller=$controller&action=$action");
        exit();
    }
    //la methode de redirection par url
    public function redirectTo($url)
    {
        header("Location: $url");
        exit();
    }
    //La methode de télechargement d'image
    public function uploadImage(string $target_dir, string $file_input_name)
    {
        if (isset($_FILES[$file_input_name]["name"]) && !empty($_FILES[$file_input_name]["name"])) {
            $imagename = time() . basename($_FILES[$file_input_name]["name"]);
            $target_file = $target_dir . $imagename;
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            // Vérifier si le fichier image est une image réelle ou une fausse image
            $check = filesize($_FILES[$file_input_name]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                echo "Le fichier n'est pas une image.";
                $uploadOk = 0;
            }
            // Vérifier si le fichier existe déjà
            if (file_exists($target_file)) {
                $uploadOk = 0;
            }
            // Vérifier la taille du fichier
            if ($_FILES[$file_input_name]["size"] > 5000000) {
                $uploadOk = 0;
            }
            // Autoriser certains formats de fichiers
            if (
                $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif" && $imageFileType != "pdf"
            ) {
                echo "Désolé, seuls les fichiers JPG, JPEG, PNG, PDF et GIF sont autorisés.";
                $uploadOk = 0;
            }
            // Vérifiez si $uploadOk est défini sur 0 par une erreur
            if ($uploadOk == 0) {
                echo "Désolé, votre fichier n'a pas été télechargé.";
                return false;
                // si tout va bien, essayez de télécharger le fichier
            } else {
                if (move_uploaded_file($_FILES[$file_input_name]["tmp_name"], $target_file)) {
                    return basename($imagename);
                } else {
                    echo "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
                    return false;
                }
            }
        } else {
            return false;
        }
    }
}
