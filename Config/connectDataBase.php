<?php
/* try {
    $strConnexion = "mysql:host=localhost;dbname=marcel";
    $pdo=new PDO($strConnexion, "root", "root", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
    ]);
} catch (PDOException $e) {
    $message = $e->getMessage();
    die($message);
} */

try {
    $strConnexion = "mysql:host=10.10.51.98;dbname=Marcel"; 
    $pdo=new PDO($strConnexion, "root", "root", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
    ]);
    echo "Connexion à la base de données réussie !"; 
} catch (PDOException $e) {
    $message = $e->getMessage();
    die("Erreur de connexion à la base de données : " . $message);
}
?>