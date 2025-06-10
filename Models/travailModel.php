<?php 

function getOffres(PDO $pdo) {
    $query = "SELECT id_offre, titre, lieu, pays, description, places_disponibles FROM offre_sejour"; // Suppression de 'prix'
    try {
        $stmt = $pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("ERREUR (getOffres): " . $e->getMessage());
        return [];
    }
}

function getOffreById(PDO $pdo, int $id_offre) {
    try {
        $query = "SELECT id_offre, titre, lieu, pays, description, places_disponibles FROM offre_sejour WHERE id_offre = :id_offre"; // Suppression de 'prix'
        $stmt = $pdo->prepare($query);
        $stmt->execute(['id_offre' => $id_offre]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Erreur lors de la récupération de l'offre par ID : " . $e->getMessage());
        return false;
    }
}

function updateOffrePlaces(PDO $pdo, int $id_offre, int $nb_places_soustraire) {
    $sql = "UPDATE offre_sejour SET places_disponibles = places_disponibles - :nb_places_soustraire WHERE id_offre = :id_offre AND places_disponibles >= :nb_places_soustraire";
    $stmt = $pdo->prepare($sql);
    try {
        $stmt->execute([
            'nb_places_soustraire' => $nb_places_soustraire, 
            'id_offre' => $id_offre
        ]);
        return $stmt->rowCount(); 
    } catch (PDOException $e) {
        error_log("Erreur lors de la mise à jour des places d'offre : " . $e->getMessage());
        return 0;
    }
}

// Fonction createSejour modifiée (sans le prix)
function createSejour(PDO $pdo, string $titre, string $lieu, string $pays, string $description, int $places_disponibles) {
    $sql = "INSERT INTO offre_sejour (titre, lieu, pays, description, places_disponibles)
            VALUES (:titre, :lieu, :pays, :description, :places_disponibles)";

    error_log("DEBUG (createSejour): Tentative d'insertion SQL.");
    error_log("DEBUG (createSejour): Requête SQL: " . $sql);
    error_log("DEBUG (createSejour): Paramètres: " . print_r([
        'titre' => $titre,
        'lieu' => $lieu,
        'pays' => $pays,
        'description' => $description,
        'places_disponibles' => $places_disponibles
    ], true));

    try {
        $stmt = $pdo->prepare($sql);
        if ($stmt === false) {
            error_log("ERREUR (createSejour): La préparation de la requête SQL a échoué !");
            error_log("ERREUR (createSejour): Informations PDO (prepare): " . print_r($pdo->errorInfo(), true));
            return false;
        }

        $success = $stmt->execute([
            'titre' => $titre,
            'lieu' => $lieu,
            'pays' => $pays,
            'description' => $description,
            'places_disponibles' => $places_disponibles
        ]);

        if ($success) {
            $lastId = $pdo->lastInsertId();
            error_log("DEBUG (createSejour): Insertion réussie ! ID du nouveau séjour: " . $lastId);
            return true;
        } else {
            error_log("ERREUR (createSejour): L'exécution de la requête a échoué.");
            error_log("ERREUR (createSejour): Informations PDO (execute): " . print_r($stmt->errorInfo(), true));
            return false;
        }
    } catch (PDOException $e) {
        error_log("ERREUR FATALE PDO (createSejour): " . $e->getMessage());
        return false;
    }
}

// Fonction updateSejour modifiée (sans le prix)
function updateSejour(PDO $pdo, array $data) {
    $sql = "UPDATE offre_sejour SET
                titre = :titre,
                lieu = :lieu,
                pays = :pays,
                description = :description,
                places_disponibles = :places_disponibles
            WHERE id_offre = :id_offre";
    $stmt = $pdo->prepare($sql);
    try {
        return $stmt->execute([
            'titre' => $data['titre'],
            'lieu' => $data['lieu'],
            'pays' => $data['pays'],
            'description' => $data['description'],
            'places_disponibles' => $data['places_disponibles'],
            'id_offre' => $data['id_offre']
        ]);
    } catch (PDOException $e) {
        error_log("Erreur lors de la mise à jour du séjour : " . $e->getMessage());
        return false;
    }
}

// Fonction createReservation (inchangée car le prix n'y est pas directement lié)
function createReservation(PDO $pdo, int $user_id, int $id_offre, int $nombre_places) {
    $sql = "INSERT INTO reservation (id_utilisateur, id_offre, nombre_places, date_reservation)
            VALUES (:id_utilisateur, :id_offre, :nombre_places, NOW())";
    $stmt = $pdo->prepare($sql);
    try {
        $stmt->execute([
            'id_utilisateur' => $user_id,
            'id_offre' => $id_offre,
            'nombre_places' => $nombre_places
        ]);
        return $pdo->lastInsertId();
    } catch (PDOException $e) {
        error_log("Erreur lors de la création de la réservation : " . $e->getMessage());
        return false;
    }
}