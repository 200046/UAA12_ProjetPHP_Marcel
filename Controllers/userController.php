<?php
// Assurez-vous d'avoir ces fichiers de modèle, ils sont essentiels
require_once("Models/userModel.php");
require_once("Models/teamModel.php");

// Récupération du chemin désiré
$uri = $_SERVER["REQUEST_URI"];

if ($uri === "/inscription") {
    if (isset($_POST['btnEnvoi'])) {
        // Vérif des données encodées
        $messageError = verifEmptyData();  
        // S'il n'y a pas d'erreur
        var_dump($messageError); // Pour le débogage, à retirer en production
        if (!$messageError) {
            // Ajout de l'utilisateur à la base de données
            createUser($pdo);  
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
        if (connectUser($pdo)) { 
            header("location:/compte");
            exit();
        }
    }
    $title = "Connexion";
    $template = "Views/Users/connexion.php";
    require_once("Views/base.php");
} elseif ($uri === "/compte") {
    $offres = getOffres($pdo);

    if (isset($_POST['updateProfile'])) {
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

        if (empty($errors)) {
            if (empty($_POST['motdepasse'])) {
                $_POST['motdepasse'] = $_SESSION["user"]->motdepasse;
            }

            updateUser($pdo); 
            updateSession($pdo); 

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
    $offres = getOffres($pdo);

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
    if (isset($_POST['createSejourBtn'])) {
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
} elseif (isset($_GET["id_offre"]) && $uri === "/reserver?id_offre=" . $_GET["id_offre"]) {
    $title = "Réservation de séjour";
    $template = "Views/Users/reserver.php";
    $offre = null;
    $errors = [];
    $successMessage = '';

    $id_offre = filter_input(INPUT_GET, 'id_offre', FILTER_VALIDATE_INT);
    if ($id_offre !== false && $id_offre !== null) {
        $offre = getOffreById($pdo, $id_offre);
        if (!$offre) $errors['offre'] = "Séjour introuvable.";
    } else {
        $errors['offre'] = "Identifiant de séjour manquant ou invalide.";
    }
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
    }
    require_once("Views/base.php");
} elseif ($uri === "/mes-affectations") {
       $title = "Vos affectations";
    $template = "Views/Staff/affectation.php";
    // Vérifier si l'utilisateur est connecté
    if (!isset($_SESSION["user"])) {
        $_SESSION['error'] = "Vous devez être connecté pour accéder à cette page.";
        header("Location: /connexion");
        exit();
    }

    // Vérifier si l'utilisateur est un employé
    if ($_SESSION["user"]->role !== 'employe') {
        $_SESSION['error'] = "Vous n'avez pas les autorisations nécessaires pour accéder à cette page.";
        header("Location: /compte"); // Rediriger vers une autre page si pas employé
        exit();
    }

    $id_utilisateur = $_SESSION["user"]->id_utilisateur;
    $affectations = getEmployeAffectations($pdo, $id_utilisateur);

    // Initialiser les messages d'erreur/succès pour la vue
    $errors = [];
    $successMessage = '';

    // Si aucune affectation n'est trouvée
    if (empty($affectations)) {
        $errors['no_affectations'] = "Vous n'avez pas d'affectations actuelles.";
    }

    require_once("Views/base.php");
} elseif ($uri === "/mes-reservations") {
    // Vérifier si l'utilisateur est connecté
    if (!isset($_SESSION["user"])) {
        $_SESSION['error'] = "Vous devez être connecté pour accéder à cette page.";
        header("Location: /connexion");
        exit();
    }
    if ($_SESSION["user"]->role !== 'client') {
        $_SESSION['error'] = "Vous n'êtes pas autorisé à voir cette page.";
        header("Location: /compte"); // Rediriger vers une autre page si le rôle n'est pas client
        exit();
    }

    $title = "Mes Réservations";
    $template = "Views/Clients/mesReservations.php"; // Chemin vers votre nouveau template

    $id_utilisateur = $_SESSION["user"]->id_utilisateur;
    $reservations = getClientReservations($pdo, $id_utilisateur);

    // Initialiser les messages d'erreur/succès pour la vue
    $errors = [];
    $successMessage = '';

    // Si aucune réservation n'est trouvée
    if (empty($reservations)) {
        $errors['no_reservations'] = "Vous n'avez pas de réservations actuelles.";
    }

    require_once("Views/base.php");
}

