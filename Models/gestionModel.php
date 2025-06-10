<?php 
function createSejour(PDO $pdo) {
    try {
        $titre = $_POST['titre'];
        $description = $_POST['description'];
        $lieu = $_POST['lieu'];
        $pays = $_POST['pays'];
        $capacite = $_POST['capacite'];
        $prix = $_POST['prix'];

        $date_debut = $_POST['date_debut'] ?? date('Y-m-d'); 
            // Si ajouté au formulaire, sinon date du jour
        $date_fin = $_POST['date_fin'] ?? date('Y-m-d', strtotime('+15 days')); 
            // Si ajouté au formulaire, sinon 15 jours plus tard
        $statut = $_POST['statut'] ?? 'actif'; 
            // Statut par défaut
        $photo_principale = $_POST['photo_principale'] ?? 'default.jpg'; 
            // Photo par défaut
        $type_hebergement = $_POST['type_hebergement'] ?? 'Hôtel'; 
            // Type d'hébergement par défaut

        $query = "INSERT INTO offre_sejour (
                    titre, description, lieu, pays, date_debut, date_fin,
                    capacite, places_disponibles, statut, photo_principale, type_hebergement
                    -- , prix -- Décommenter si 'prix' est ajouté à la table
                  ) VALUES (
                    :titre, :description, :lieu, :pays, :date_debut, :date_fin,
                    :capacite, :places_disponibles, :statut, :photo_principale, :type_hebergement
                    -- , :prix -- Décommenter si 'prix' est ajouté à la table
                  )";

        $stmt = $pdo->prepare($query);

        $stmt->execute([
            'titre' => $titre,
            'description' => $description,
            'lieu' => $lieu,
            'pays' => $pays,
            'date_debut' => $date_debut,
            'date_fin' => $date_fin,
            'capacite' => $capacite,
            'statut' => $statut,
            'photo_principale' => $photo_principale,
            'type_hebergement' => $type_hebergement,
            'prix' => $prix
        ]);
        return true;

    } catch (PDOException $e) {
        $message = "Erreur lors de la création du séjour : " . $e->getMessage();
        die($message);
    }
}

function updateSejour(PDO $pdo) {
    try {
        $id_offre = $_POST['id_offre']; 
        $titre = $_POST['titre'];
        $description = $_POST['description'];
        $lieu = $_POST['lieu'];
        $pays = $_POST['pays'];
        $places_disponibles = (int)$_POST['places_disponibles'];

        $date_debut = $_POST['date_debut'] ?? null;
        $date_fin = $_POST['date_fin'] ?? null;
        $capacite = $_POST['capacite'] ?? null;
        $statut = $_POST['statut'] ?? null;
        $photo_principale = $_POST['photo_principale'] ?? null;
        $type_hebergement = $_POST['type_hebergement'] ?? null;
        $prix = isset($_POST['prix']) ? (float)$_POST['prix'] : null;

        $query = "UPDATE offre_sejour SET
                    titre = :titre,
                    description = :description,
                    lieu = :lieu,
                    pays = :pays,
                    places_disponibles = :places_disponibles";

        $params = [
            'titre' => $titre,
            'description' => $description,
            'lieu' => $lieu,
            'pays' => $pays,
            'places_disponibles' => $places_disponibles
        ];

        $query .= " WHERE id_offre = :id_offre";
        $params['id_offre'] = $id_offre;

        $stmt = $pdo->prepare($query);
        $stmt->execute($params);

    } catch (PDOException $e) {
        $message = "Erreur lors de la mise à jour du séjour : " . $e->getMessage();
        die($message);
    }
}