<?php 
function getReservations($pdo, $id_utilisateur) {
    $query = "SELECT reservation.id_reservation, reservation.date_reservation, reservation.statut, 
              offre_sejour.titre, offre_sejour.lieu, offre_sejour.date_debut, offre_sejour.date_fin 
              FROM reservation 
              JOIN offre_sejour ON reservation.id_offre = offre_sejour.id_offre
              WHERE reservation.id_utilisateur = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id_utilisateur]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retourne toutes les réservations sous forme de tableau associatif
}
function getAffectations($pdo, $id_utilisateur) {
    $query = "SELECT affectation_employe.id_affectation, affectation_employe.role, 
              offre_sejour.titre, offre_sejour.lieu, offre_sejour.date_debut, offre_sejour.date_fin 
              FROM affectation_employe
              JOIN offre_sejour ON affectation_employe.id_offre = offre_sejour.id_offre
              JOIN employe ON affectation_employe.id_employe = employe.id_employe
              WHERE employe.id_utilisateur = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id_utilisateur]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retourne toutes les affectations sous forme de tableau associatif
}
function getOffres($pdo) {
    $query = "
       SELECT * FROM offre_sejour";


    try {
        // Exécuter la requête
        $stmt = $pdo->query($query);

        // Récupérer tous les résultats
        $offres = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $offres; // Retourner les résultats sous forme de tableau associatif
    } catch (PDOException $e) {
        // Si une erreur se produit, afficher l'erreur
        echo "Erreur lors de la récupération des offres : " . $e->getMessage();
        return [];
    }
}

function getOffreById(PDO $pdo, int $id_offre) {
    try {
        $query = "SELECT * FROM offre_sejour WHERE id_offre = :id_offre";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['id_offre' => $id_offre]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erreur lors de la récupération de l'offre : " . $e->getMessage();
        return false;
    }
}

function updateOffrePlaces(PDO $pdo, int $offre_id, int $nb_places) {
    $sql = "UPDATE offre_sejour SET places_restantes = places_restantes - :nb_places WHERE id_offre = :offre_id AND places_restantes >= :nb_places";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'nb_places' => $nb_places,
        'offre_id' => $offre_id
    ]);
    return $stmt->rowCount(); // Retourne 1 si mise à jour, 0 sinon
}
function createReservation(PDO $pdo, int $user_id, int $offre_id, int $nb_personnes) {
    $sql = "INSERT INTO reservation (user_id, offre_id, nb_personnes, date_reservation) 
            VALUES (:user_id, :offre_id, :nb_personnes, NOW())";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'user_id' => $user_id,
        'offre_id' => $offre_id,
        'nb_personnes' => $nb_personnes
    ]);
    return $pdo->lastInsertId(); // Retourne l'ID de la nouvelle réservation
}
