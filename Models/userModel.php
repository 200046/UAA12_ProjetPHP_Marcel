<?php 
function connectUser($pdo) {
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

function createUser($pdo) {
    var_dump("1");
    try {
        // Requête adaptée au schéma Utilisateur
        $query = 'INSERT INTO utilisateur (nom, prenom, email, telephone, role, date_inscription, motdepasse) 
                  VALUES (:nom, :prenom, :email, :telephone, :role, :date_inscription, :motdepasse)';
    
        $ajouterUser = $pdo->prepare($query);
 var_dump("La préparation est faiteeeeeeee");
        $ajouterUser->execute([
            'nom' => $_POST["nom"],
            'prenom' => $_POST["prenom"],
            'email' => $_POST["email"],
            'telephone' => $_POST["telephone"],
            'role' => 'client', // Valeur par défaut
            'motdepasse' => $_POST["motdepasse"],
            'date_inscription' => date("Y-m-d",time())
        ]);
        var_dump("Excetutionnnnnnnnnn");
    } 
    //  echo "Utilisateur ajouté avec succès !";
    catch (PDOException $e) {
        die("Erreur : " . $e->getMessage());
    }
}

function verifEmptyData() {
    foreach($_POST as $key => $value) {
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
        $query = 'UPDATE Utilisateur SET nom = :nom, prenom = :prenom, email = :email, telephone = :telephone, motdepasse = :mot_de_passe
                  WHERE id_utilisateur = :id_utilisateur';
        
        $ajouterUser = $pdo->prepare($query);
        $ajouterUser->execute([
            'nom' => $_POST["nom"],
            'prenom' => $_POST["prenom"],
            'email' => $_POST["email"],
            'telephone' => $_POST["telephone"],
            'mot_de_passe' => $_POST["motdepasse"],
            'id_utilisateur' => $_SESSION["user"]->id_utilisateur
        ]);
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}

function updateSession($pdo) {
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
?>