<?php 
// Fonction pour récupérer les réservations d'un client
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
// Fonction pour récupérer les affectations d'un employé
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

// Connexion à la base de données
function getOffres($pdo) {
    // Requête SQL pour récupérer les offres disponibles
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
