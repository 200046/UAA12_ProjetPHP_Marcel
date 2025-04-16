<?php
require_once("Models/userModel.php");

// Récupération du chemin désiré
$uri = $_SERVER["REQUEST_URI"];

if ($uri === "/inscription") {
    if (isset($_POST['btnEnvoi'])) {
        // Vérif des données encodées
        $messageError = verifEmptyData();
        // S'il n'y a pas d'erreur
        var_dump($messageError);
        if (!$messageError) {
            // Ajout de l'utilisateur à la base de données
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
    $nom = 
    $title = "Mon compte";
    $template = "Views/Users/compte.php";
    require_once("Views/base.php");
} elseif ($uri === "/about") {
    $title = "Qui sommes-nous ?";
    $template = "Views/Users/about.php";
    require_once("Views/base.php");
} elseif ($uri === "/deconnexion") {
    // Nettoayeg de la session et retour à l'index
    session_destroy();
    header("location:/");
 } elseif ($uri === "/delete") {
    // Afficher la page de confirmation
    $title = "Suppression de compte";
    $template = "Views/Users/delete.php";
    require_once("Views/base.php");
} elseif ($uri === "/delete-confirm") {
    // Traiter la suppression effective du compte
    if (isset($_SESSION["user"])) {
        $userId = $_SESSION["user"]->id_utilisateur;
        if (deleteUserAccount($pdo, $userId)) {
            session_destroy();
            session_start();
            $_SESSION['success'] = "Votre compte a été supprimé avec succès.";
            header("location:/");
            exit;
        } else {
            $_SESSION['error'] = "Erreur lors de la suppression du compte.";
            header("location:/compte");
            exit;
        }
    } else {
        header("location:/connexion");
        exit;
    }
}

