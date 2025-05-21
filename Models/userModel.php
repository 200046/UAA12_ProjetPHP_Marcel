<?php
function connectUser($pdo)
{
    try {
        // Requête adaptée au schéma Utilisateur
        $query = 'SELECT * FROM Utilisateur WHERE email = :email AND motdepasse = :motdepasse';
        $connectUser = $pdo->prepare($query);
        $connectUser->execute([
            'email' => $_POST['email'],
            'motdepasse' => $_POST['motdepasse']
        ]);

        $user = $connectUser->fetch();
        if (!$user) {
            return false;
        } else {
            $_SESSION["user"] = $user;
            return true;
        }
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}

function createUser($pdo)
{
    try {
        // Requête adaptée au schéma Utilisateur
        $query = 'INSERT INTO utilisateur (nom, prenom, email, telephone, role, date_inscription, motdepasse) 
                  VALUES (:nom, :prenom, :email, :telephone, :role, :date_inscription, :motdepasse)';

        $ajouterUser = $pdo->prepare($query);
        $ajouterUser->execute([
            'nom' => $_POST["nom"],
            'prenom' => $_POST["prenom"],
            'email' => $_POST["email"],
            'telephone' => $_POST["telephone"],
            'role' => 'client', // Valeur par défaut
            'motdepasse' => $_POST["motdepasse"],
            'date_inscription' => date("Y-m-d", time())
        ]);
    }
    //  echo "Utilisateur ajouté avec succès !";
    catch (PDOException $e) {
        die("Erreur : " . $e->getMessage());
    }
}

function verifEmptyData()
{
    foreach ($_POST as $key => $value) {
        if ($key != 'btnEnvoi') {
            if (empty(str_replace(' ', '', $value))) {
                $messageError[$key] = "Votre " . $key . " est vide";
            }
        }
    }
    if (isset($messageError)) {
        return $messageError;
    } else {
        return false;
    }
}

function updateUser($pdo) {
    try {
        $query = 'UPDATE Utilisateur SET nom = :nom, prenom = :prenom, email = :email, telephone = :telephone, motdepasse = :motdepasse
                  WHERE id_utilisateur = :id_utilisateur';

        $ajouterUser = $pdo->prepare($query);
        $ajouterUser->execute([
            'nom' => $_POST["nom"],
            'prenom' => $_POST["prenom"],
            'email' => $_POST["email"],
            'telephone' => $_POST["telephone"],
            'motdepasse' => $_POST["motdepasse"],
            'id_utilisateur' => $_SESSION["user"]->id_utilisateur
        ]);
        
        return true;
    } catch (PDOException $e) {
        error_log("Erreur lors de la mise à jour de l'utilisateur: " . $e->getMessage());
        return false;
    }
}

function updateSession($pdo)
{
    try {
        $query = 'SELECT * FROM Utilisateur WHERE id_utilisateur = :id_utilisateur';
        $selectUser = $pdo->prepare($query);
        $selectUser->execute([
            'id_utilisateur' => $_SESSION["user"]->id_utilisateur
        ]);

        $user = $selectUser->fetch();
        $_SESSION["user"] = $user;
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}

function deleteUserAccount($pdo, $userId)
{
    try {
        $pdo->beginTransaction();

        // Récupérer le rôle de l'utilisateur
        $stmtRole = $pdo->prepare("SELECT role FROM utilisateur WHERE id_utilisateur = :userId");
        $stmtRole->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmtRole->execute();
        $userRole = $stmtRole->fetchColumn();

        // Si c'est un client, supprimer d'abord ses réservations
        if ($userRole === 'client') {
            $stmtDeleteReservations = $pdo->prepare("DELETE FROM reservation WHERE id_utilisateur = :userId");
            $stmtDeleteReservations->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmtDeleteReservations->execute();
        }
        // Si c'est un employé, supprimer ses affectations et son entrée dans la table employé
        else if ($userRole === 'employe') {
            // Récupérer l'id_employe correspondant à cet utilisateur
            $stmtEmployeId = $pdo->prepare("SELECT id_employe FROM employe WHERE id_utilisateur = :userId");
            $stmtEmployeId->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmtEmployeId->execute();
            $employeId = $stmtEmployeId->fetchColumn();

            if ($employeId) {
                // Supprimer les affectations de l'employé
                $stmtDeleteAssignments = $pdo->prepare("DELETE FROM affectation_employe WHERE id_employe = :employeId");
                $stmtDeleteAssignments->bindParam(':employeId', $employeId, PDO::PARAM_INT);
                $stmtDeleteAssignments->execute();

                // Supprimer l'entrée dans la table employe
                $stmtDeleteEmployee = $pdo->prepare("DELETE FROM employe WHERE id_utilisateur = :userId");
                $stmtDeleteEmployee->bindParam(':userId', $userId, PDO::PARAM_INT);
                $stmtDeleteEmployee->execute();
            }
        }

        // Finalement, supprimer l'utilisateur lui-même
        $stmtDeleteUser = $pdo->prepare("DELETE FROM utilisateur WHERE id_utilisateur = :userId");
        $stmtDeleteUser->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmtDeleteUser->execute();

        $pdo->commit();
        return true;
    } catch (PDOException $e) {
        $pdo->rollBack();
        error_log("Erreur lors de la suppression du compte utilisateur: " . $e->getMessage());
        return false;
    }
}