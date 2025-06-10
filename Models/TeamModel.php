<?php
function getTeamMembers($pdo) {
    $query = "
        SELECT id_employe, poste, statut as statut_employe,
               nom, prenom, email, telephone
        FROM employe e
        JOIN utilisateur u ON e.id_utilisateur = u.id_utilisateur
        ORDER BY nom, prenom
    ";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getEmployeeAssignments($pdo, $employeeId) {
    $query = "
       SELECT a.id_affectation, a.role, a.id_offre, o.titre
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