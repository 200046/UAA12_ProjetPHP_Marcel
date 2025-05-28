<?php
require_once("Models/userModel.php");
require_once("Models/teamModel.php");
require_once("Models/teamModel.php");


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

            updateUser($pdo);
            updateSession($pdo);

            // Message de succès
            $_SESSION['success'] = "Vos informations ont été mises à jour avec succès.";
            header("Location: /compte");
            exit;
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
} elseif ($uri === "/team") {
    $teamMembers = getTeamMembers($pdo);
    $title = "Nos employés";
    $template = "Views/Info/notreEquipe.php";
    require_once("Views/base.php");
} elseif ($uri === "/gestion") {
    if (isset($_POST['updateSejour'])) {
        $errors = [];
        if (empty($_POST['id_offre']) || !is_numeric($_POST['id_offre'])) {
            $errors['id_offre'] = "L'identifiant du séjour est manquant ou invalide.";
        }
        if (empty($_POST['titre'])) {
            $errors['titre'] = "Le titre est obligatoire.";
        }
        if (empty($_POST['prix'])) {
            $errors['prix'] = "Le prix est obligatoire.";
        } elseif (!is_numeric($_POST['prix']) || $_POST['prix'] < 0) {
            $errors['prix'] = "Le prix doit être un nombre positif.";
        }
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
            if (updateSejour($pdo)) {
                $_SESSION['success'] = "Le séjour a été mis à jour avec succès !";
                header("Location: /gestion");
                exit;
            }
        }
    }

    if (isset($_POST['createSejour'])) {
        $errors = [];

        if (empty($_POST['titre'])) {
            $errors['titre'] = "Le titre est obligatoire.";
        }
        if (empty($_POST['prix'])) {
            $errors['prix'] = "Le prix est obligatoire.";
        } elseif (!is_numeric($_POST['prix']) || $_POST['prix'] < 0) {
            $errors['prix'] = "Le prix doit être un nombre positif.";
        }
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
            if (createSejour($pdo)) {
                $_SESSION['success'] = "Le nouveau séjour a été créé avec succès !";
                header("Location: /gestion");
                exit;
            }
        }
    }

    $title = "Page admin";
    $template = "Views/Staff/gestion.php";
    require_once("Views/base.php");
}
