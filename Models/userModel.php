<?php 
function connectUser($pdo) {
    try {
        // Requête adaptée au schéma Utilisateur
        $query = 'SELECT * FROM Utilisateur WHERE email = :email AND mot_de_passe = :mot_de_passe';
        $connectUser = $pdo->prepare($query);
        $connectUser->execute([
            'email' => $_POST['email'],
            'mot_de_passe' => $_POST['mot_de_passe']
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
        
        /* CREATE TABLE utilisateur (
    id_utilisateur INT PRIMARY KEY,
    email VARCHAR(255) UNIQUE,
    nom VARCHAR(100),
    prenom VARCHAR(100),
	motdepasse VARCHAR(100),
    telephone VARCHAR(20),
    role VARCHAR(50),
    date_inscription DATE
); */
        $ajouterUser = $pdo->prepare($query);
 var_dump("La préparation est faiteeeeeeee");
        $ajouterUser->execute([
            'nom' => $_POST["nom"],
            'prenom' => $_POST["prenom"],
            'email' => $_POST["email"],
            'telephone' => $_POST["telephone"],
            'role' => 'client', // Valeur par défaut
            'motdepasse' => $_POST["motdepasse"],
            'date_inscription' => time()
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
        $query = 'UPDATE Utilisateur SET nom = :nom, prenom = :prenom, email = :email, telephone = :telephone, mot_de_passe = :mot_de_passe
                  WHERE id_utilisateur = :id_utilisateur';
        
        $ajouterUser = $pdo->prepare($query);
        $ajouterUser->execute([
            'nom' => $_POST["nom"],
            'prenom' => $_POST["prenom"],
            'email' => $_POST["email"],
            'telephone' => $_POST["telephone"],
            'mot_de_passe' => $_POST["mot_de_passe"],
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