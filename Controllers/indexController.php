<?php 

require_once("Models/travailModel.php");
$uri = $_SERVER["REQUEST_URI"];

if ($uri === "/index.php" || $uri === "/") {
    // Récuperer toutes les données de la table school 
    $offres = getOffres($pdo);
    $title = "Page d'accueil";
    $template = "Views/pageAccueil.php";
    require_once("Views/base.php");
}

?>