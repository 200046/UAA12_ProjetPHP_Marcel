<?php 
require_once("Models/userModel.php");

// Récupération du chemin désiré
$uri = $_SERVER["REQUEST_URI"];

if ($uri === "/inscription") {
    $title = "Inscription";
    $template = "Views/Users/inscription.php";
    require_once("Views/base.php");
} elseif ($uri === "/connexion") {
    $title = "Connexion";
    $template = "Views/Users/connexion.php";
    require_once("Views/base.php");
}