CREATE TABLE Utilisateur (
    id_utilisateur INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE,
    nom VARCHAR(100),
    prenom VARCHAR(100),
    telephone VARCHAR(20),
    role VARCHAR(50),
    date_inscription DATE
);

CREATE TABLE employe (
    id_employe INT PRIMARY KEY,
    id_utilisateur INT UNIQUE,
    poste VARCHAR(100),
    statut VARCHAR(50),
    FOREIGN KEY (id_utilisateur) REFERENCES Utilisateur(id_utilisateur)
);

CREATE TABLE offre_sejour (
    id_offre INT PRIMARY KEY,
    titre VARCHAR(255),
    description TEXT,
    lieu VARCHAR(255),
    pays VARCHAR(100),
    date_debut DATE,
    date_fin DATE,
    capacite INT,
    places_disponibles INT,
    statut VARCHAR(50),
    photo_principale VARCHAR(255),
    type_hebergement VARCHAR(100)
);

CREATE TABLE reservation (
    id_reservation INT PRIMARY KEY,
    id_utilisateur INT,
    id_offre INT,
    date_reservation DATE,
    statut VARCHAR(50),
    FOREIGN KEY (id_utilisateur) REFERENCES Utilisateur(id_utilisateur),
    FOREIGN KEY (id_offre) REFERENCES offre_sejour(id_offre)
);

CREATE TABLE affectation_employe (
    id_affectation INT PRIMARY KEY,
    id_employe INT,
    id_offre INT,
    role VARCHAR(100),
    FOREIGN KEY (id_employe) REFERENCES employe(id_employe),
    FOREIGN KEY (id_offre) REFERENCES offre_sejour(id_offre)
);
