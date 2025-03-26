<?php 

$uri = $_SERVER["REQUEST_URI"];

if ($uri === "/index.php" || $uri === "/") {
   
    $title = "Bienvenue sur le site";
    $template = "Views/pageAccueil.php";
    require_once("Views/base.php");
}

?>