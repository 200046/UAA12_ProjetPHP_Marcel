<?php
session_start();
// Afficher les détails de la session var_dump($_SESSION);
require_once("Config/connectDataBase.php");
require_once("Controllers/indexController.php");
require_once("Controllers/userController.php");