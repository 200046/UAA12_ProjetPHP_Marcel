<?php
session_start();
require_once 'config/database.php';
require_once '../../Models/userModel.php'; 

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION["user"])) {
    $_SESSION['error'] = "Vous devez être connecté pour supprimer votre compte.";
    header("Location: login.php");
    exit;
}
// Vérifier que la confirmation est présente
if (!isset($_GET['confirm']) || $_GET['confirm'] !== 'yes') {
    header("Location: confirm_delete.php"); // Rediriger vers la page de confirmation
    exit;
}

// Vérifier que l'ID utilisateur correspond bien à l'utilisateur connecté
$userId = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($userId != $_SESSION["user"]->id_utilisateur) {
    $_SESSION['error'] = "Action non autorisée.";
    header("Location: account.php");
    exit;
}

try {    
    // Appeler la fonction de suppression
    $result = deleteUserAccount($pdo, $userId);
    
    if ($result) {
        // Détruire la session
        session_destroy();
        
        // Rediriger vers la page d'accueil avec un message de succès
        session_start();
        $_SESSION['success'] = "Votre compte a été supprimé avec succès. Au revoir !";
        header("Location: index.php");
        exit;
    } else {
        $_SESSION['error'] = "Une erreur est survenue lors de la suppression de votre compte.";
        header("Location: compte");
        exit;
    }
} catch (PDOException $e) {
    $_SESSION['error'] = "Erreur de connexion à la base de données.";
    header("Location: compte");
    exit;
}
?>