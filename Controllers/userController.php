<?php
// Assurez-vous d'avoir ces fichiers de modèle, ils sont essentiels
require_once("Models/userModel.php");
require_once("Models/teamModel.php");

// Récupération du chemin désiré
$uri = $_SERVER["REQUEST_URI"];

if ($uri === "/inscription") {
    if (isset($_POST['btnEnvoi'])) {
        // Vérif des données encodées
        $messageError = verifEmptyData(); // Cette fonction devrait être définie dans userModel.php
        // S'il n'y a pas d'erreur
        var_dump($messageError); // Pour le débogage, à retirer en production
        if (!$messageError) {
            // Ajout de l'utilisateur à la base de données
            createUser($pdo); // Cette fonction devrait être définie dans userModel.php
            // Rédirection vers la page de connexion
            header("location:/connexion");
            exit(); // Toujours exit() après une redirection
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
        if (connectUser($pdo)) { // Cette fonction devrait être définie dans userModel.php
            // Rédirection vers la page d'accueil
            header("location:/compte");
            exit();
        }
    }
    $title = "Connexion";
    $template = "Views/Users/connexion.php";
    require_once("Views/base.php");
} elseif ($uri === "/compte") {
    // Récupération des offres (pour l'affichage sur la page compte si nécessaire)
    $offres = getOffres($pdo); 

    // Gestion de la mise à jour du profil
    if (isset($_POST['updateProfile'])) { 
        // Validation des données
        $errors = [];

        if (empty($_POST['nom'])) {
            $errors['nom'] = "Le nom est obligatoire";
        }
        if (empty($_POST['prenom'])) {
            $errors['prenom'] = "Le prénom est obligatoire";
        }
        if (empty($_POST['email'])) {
            $errors['email'] = "L'email est obligatoire";
        } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "L'email n'est pas valide";
        }
        if (empty($_POST['telephone'])) {
            $errors['telephone'] = "Le téléphone est obligatoire";
        }

        // Si pas d'erreurs, procéder à la mise à jour
        if (empty($errors)) {
            // Si le mot de passe n'est pas fourni, on garde l'ancien
            if (empty($_POST['motdepasse'])) {
                $_POST['motdepasse'] = $_SESSION["user"]->motdepasse;
            }

            updateUser($pdo); // Cette fonction devrait être définie dans userModel.php
            updateSession($pdo); // Cette fonction devrait être définie dans userModel.php

            // Message de succès
            $_SESSION['success'] = "Vos informations ont été mises à jour avec succès.";
            header("Location: /compte");
            exit();
        } else {
            // Stocke les erreurs pour les afficher dans la vue
            $_SESSION['errors'] = $errors;
        }
    }

    $title = "Mon compte";
    $template = "Views/Users/compte.php";
    require_once("Views/base.php");
} elseif ($uri === "/about") {
    $title = "Qui sommes-nous ?";
    $template = "Views/Info/about.php";
    require_once("Views/base.php");
} elseif ($uri === "/deconnexion") {
    // Nettoyage de la session et retour à l'index
    session_destroy();
    header("location:/");
    exit();
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
            exit();
        } else {
            $_SESSION['error'] = "Erreur lors de la suppression du compte.";
            header("location:/compte");
            exit();
        }
    } else {
        header("location:/connexion");
        exit();
    }
} elseif ($uri === "/team") {
    $teamMembers = getTeamMembers($pdo); 
    $title = "Nos employés";
    $template = "Views/Info/notreEquipe.php";
    require_once("Views/base.php");
} elseif ($uri === "/gestion") {
    // Récupération des offres pour les afficher dans le formulaire de modification
    $offres = getOffres($pdo);

    // --- Gestion de la mise à jour des séjours existants ---
    if (isset($_POST['updateSejoursBtn'])) {
        $errors = [];
        if (!isset($_POST['id_offre']) || !is_array($_POST['id_offre'])) {
            $errors['global'] = "Aucun séjour à mettre à jour ou données manquantes.";
        } else {
            foreach ($_POST['id_offre'] as $index => $id_offre) {
                $currentErrors = [];

                if (!is_numeric($id_offre) || $id_offre <= 0) {
                    $currentErrors['id_offre'] = "ID séjour invalide pour l'index " . $index;
                }
                if (empty($_POST['titre'][$index])) {
                    $currentErrors['titre'] = "Le titre est obligatoire pour l'offre " . $id_offre;
                }
                // Suppression de la validation du prix ici
                
                if (empty($currentErrors)) {
                    $data = [
                        'id_offre' => (int)$id_offre,
                        'titre' => $_POST['titre'][$index],
                        // Suppression du prix ici
                        'lieu' => $_POST['lieu'][$index],
                        'pays' => $_POST['pays'][$index],
                        'description' => $_POST['description'][$index],
                        'places_disponibles' => (int)$_POST['places_disponibles'][$index]
                    ];
                    if (!updateSejour($pdo, $data)) { 
                        $errors['db_update'] = "Erreur lors de la mise à jour du séjour avec l'ID " . $id_offre;
                        break; 
                    }
                } else {
                    $errors['validation'] = $currentErrors; 
                    break;
                }
            }
        }

        if (empty($errors)) {
            $_SESSION['success'] = "Les modifications ont été enregistrées avec succès !";
        } else {
            $_SESSION['error'] = "Erreur(s) lors de l'enregistrement des modifications.";
            $_SESSION['errors_detail'] = $errors; 
        }
        header("Location: /gestion");
        exit();
    }

    // --- Gestion de la création d'un nouveau séjour ---
    if (isset($_POST['createSejourBtn'])) {
        // Suppression du DEBUG temporaire
        // echo "<pre>DEBUG: Bouton 'createSejourBtn' détecté !</pre>";
        // echo "<pre>DEBUG: Contenu de \$_POST : ";
        // print_r($_POST);
        // echo "</pre>";
        // exit; 
        $errors = [];

        // Validation des données du nouveau séjour
        if (empty($_POST['titre'])) {
            $errors['titre'] = "Le titre est obligatoire.";
        }
        // Suppression de la validation du prix ici
        if (empty($_POST['lieu'])) {
            $errors['lieu'] = "Le lieu est obligatoire.";
        }
        if (empty($_POST['pays'])) {
            $errors['pays'] = "Le pays est obligatoire.";
        }
        if (empty($_POST['description'])) {
            $errors['description'] = "La description est obligatoire.";
        }
        if (empty($_POST['places_disponibles'])) {
            $errors['places_disponibles'] = "Le nombre de places disponibles est obligatoire.";
        } elseif (!is_numeric($_POST['places_disponibles']) || $_POST['places_disponibles'] < 0) {
            $errors['places_disponibles'] = "Le nombre de places doit être un entier positif.";
        }

        if (empty($errors)) {
            if (createSejour(
                $pdo,
                $_POST['titre'],
                $_POST['lieu'],
                $_POST['pays'],
                $_POST['description'],
                (int)$_POST['places_disponibles']
            )) {
                $_SESSION['success'] = "Le nouveau séjour a été créé avec succès !";
                header("Location: /gestion");
                exit();
            } else {
                $_SESSION['error'] = "Une erreur est survenue lors de la création du séjour en base de données.";
            }
        } else {
            $_SESSION['error'] = "Veuillez corriger les erreurs dans le formulaire.";
            $_SESSION['errors_create'] = $errors; 
            $_SESSION['old_input_create'] = $_POST; 
        }
        header("Location: /gestion"); 
        exit();
    }

    $title = "Page admin";
    $template = "Views/Staff/gestion.php";
    require_once("Views/base.php");
} elseif (isset($_GET["offre_id"]) && $uri === "/reserver?offre_id=" . $_GET["offre_id"]) {
    $title = "Réservation de séjour";
    $template = "Views/Reservation/reserver.php";

    $offre = null;
    $errors = [];
    $successMessage = '';

    $offre_id = filter_input(INPUT_GET, 'offre_id', FILTER_VALIDATE_INT);

    if ($offre_id !== false && $offre_id !== null) {
        $offre = getOffreById($pdo, $offre_id); 
        if (!$offre) $errors['offre'] = "Séjour introuvable.";
    } else {
        $errors['offre'] = "Identifiant de séjour manquant ou invalide.";
    }

    if (isset($_POST['btnReserver']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            var_dump("Controlleur reserver");
        if (!isset($_SESSION["user"])) {
            $errors['auth'] = "Vous devez être connecté pour réserver.";
        } else {
            $id_utilisateur = $_SESSION["user"]->id_utilisateur;
            $nombre_places = filter_input(INPUT_POST, 'nombre_places', FILTER_VALIDATE_INT);

            if ($nombre_places === false || $nombre_places <= 0) {
                $errors['nombre_places'] = "Le nombre de places doit être un entier positif.";
            } elseif ($offre && $nombre_places > $offre['places_disponibles']) { 
                $errors['nombre_places'] = "Il n'y a pas assez de places disponibles. Restant : " . $offre['places_disponibles'];
            }

            if (empty($errors) && $offre) {
                if (createReservation($pdo, $id_utilisateur, $offre['id_offre'], $nombre_places)) {
                    updateOffrePlaces($pdo, $offre['id_offre'], $nombre_places); 
                    $successMessage = "Votre réservation a été effectuée avec succès !";
                    $offre = getOffreById($pdo, $offre_id); 
                } else {
                    $errors['reservation'] = "Une erreur est survenue lors de la réservation.";
                }
            }
        }
    }

    require_once("Views/base.php");
}