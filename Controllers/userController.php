<?php
require_once("Models/userModel.php");

// Récupération du chemin désiré
$uri = $_SERVER["REQUEST_URI"];

if ($uri === "/inscription") {
    var_dump("coucouuu");
    var_dump($_POST);
    if (isset($_POST['btnEnvoi'])) {
        var_dump("hellooooooooooo");
        // Vérif des données encodées
        $messageError = verifEmptyData();
        // S'il n'y a pas d'erreur
        var_dump($messageError);
        if (!$messageError) {
            // Ajout de l'utilisateur à la base de données
            var_dump("salutttttttttt");
            createUser($pdo);
            // Rédirection vers la page de connexion
            header("location:/connexion");
        }
    }
    $title = "Inscription";
    $template = "Views/Users/inscription.php";
    require_once("Views/base.php");
} elseif ($uri === "/connexion") {
    // Vérifier si l'utilisateur a cliqué sur le bouton du form
    if (isset($_POST['btnEnvoi'])) {
        // Pour récupere l'erreur si l'utilisateur fait une faute de frappe
        $erreur = false;
        // Tentative de connexion et de récuperation des données de l'utilisateur
        if (connectUser($pdo)) {
            // Rédirection vers la page d'accueil
            header("location:/compte");
        }
    }
    $title = "Connexion";
    $template = "Views/Users/connexion.php";
    require_once("Views/base.php");
} elseif ($uri === "/compte") {
    $title = "Mon compte";
    $template = "Views/Users/compte.php";
    require_once("Views/base.php");
}
