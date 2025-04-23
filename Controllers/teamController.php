<?php

var_dump($teamMembers);
/**
 * Récupère tous les membres de l'équipe (employés) avec leurs informations de base
 */
function getTeamMembers($pdo) {
    $query = "
        SELECT e.id_employe, e.poste, e.statut as statut_employe, 
               u.nom, u.prenom, u.email, u.telephone
        FROM employe e
        JOIN utilisateur u ON e.id_utilisateur = u.id_utilisateur
        ORDER BY u.nom, u.prenom
    ";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Récupère les affectations d'un employé à des offres de séjour
 */
function getEmployeeAssignments($pdo, $employeeId) {
    $query = "
        SELECT a.id_affectation, a.role, o.id_offre, o.titre
        FROM affectation_employe a
        JOIN offre_sejour o ON a.id_offre = o.id_offre
        WHERE a.id_employe = :employeeId
        ORDER BY o.date_debut DESC
    ";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':employeeId', $employeeId, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}