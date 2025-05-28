-- Création des tables
CREATE TABLE utilisateur (
    id_utilisateur INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE,
    nom VARCHAR(100),
    prenom VARCHAR(100),
    motdepasse VARCHAR(100),
    telephone VARCHAR(20),
    role VARCHAR(50),
    date_inscription DATE
);

CREATE TABLE employe (
    id_employe INT PRIMARY KEY,
    id_utilisateur INT UNIQUE,
    poste VARCHAR(100),
    statut VARCHAR(50),
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_utilisateur)
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
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_utilisateur),
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

-- Script d'insertion de fausses données

INSERT INTO utilisateur (email, nom, prenom, motdepasse, telephone, role, date_inscription) VALUES
('001@gmail.com', 'Dubois', 'Alice', 'test', '0612345678', 'client', '2023-01-10'),
('002@gmail.com', 'Martin', 'Bernard', 'test', '0623456789', 'employe', '2023-01-15'),
('003@gmail.com', 'Petit', 'Carole', 'test', '0634567890', 'client', '2023-01-20'),
('004@gmail.com', 'Durand', 'David', 'test', '0645678901', 'employe', '2023-01-25'),
('005@gmail.com', 'Leroy', 'Emilie', 'test', '0656789012', 'client', '2023-02-01'),
('006@gmail.com', 'Moreau', 'Franck', 'test', '0667890123', 'employe', '2023-02-05'),
('007@gmail.com', 'Simon', 'Sophie', 'test', '0678901234', 'client', '2023-02-10'),
('008@gmail.com', 'Laurent', 'Guillaume', 'test', '0689012345', 'employe', '2023-02-15'),
('009@gmail.com', 'Michel', 'Julie', 'test', '0690123456', 'client', '2023-02-20'),
('010@gmail.com', 'Garcia', 'Kevin', 'test', '0601234567', 'employe', '2023-02-25'),
('011@gmail.com', 'Roux', 'Laura', 'test', '0611223344', 'client', '2023-03-01'),
('012@gmail.com', 'Thomas', 'Marc', 'test', '0622334455', 'employe', '2023-03-05'),
('013@gmail.com', 'Bernard', 'Nathalie', 'test', '0633445566', 'client', '2023-03-10'),
('014@gmail.com', 'Robert', 'Olivier', 'test', '0644556677', 'employe', '2023-03-15'),
('015@gmail.com', 'Richard', 'Pauline', 'test', '0655667788', 'client', '2023-03-20'),
('016@gmail.com', 'Dupont', 'Quentin', 'test', '0666778899', 'employe', '2023-03-25'),
('017@gmail.com', 'Dubois', 'Rachel', 'test', '0677889900', 'client', '2023-04-01'),
('018@gmail.com', 'Bertrand', 'Samuel', 'test', '0688990011', 'employe', '2023-04-05'),
('019@gmail.com', 'Fournier', 'Tina', 'test', '0699001122', 'client', '2023-04-10'),
('020@gmail.com', 'Girard', 'Ulysse', 'test', '0600112233', 'employe', '2023-04-15'),
('021@gmail.com', 'Bonnet', 'Victoria', 'test', '0610203040', 'client', '2023-04-20'),
('022@gmail.com', 'Dufour', 'William', 'test', '0620304050', 'employe', '2023-04-25'),
('023@gmail.com', 'Meyer', 'Xavier', 'test', '0630405060', 'client', '2023-05-01'),
('024@gmail.com', 'Fabre', 'Yasmine', 'test', '0640506070', 'employe', '2023-05-05'),
('025@gmail.com', 'Lefevre', 'Zoe', 'test', '0650607080', 'client', '2023-05-10'),
('admin@gmail.com', 'Tasnier', 'Marcel', 'admin', '0612345678', 'admin', '2023-01-10');

INSERT INTO offre_sejour (id_offre, titre, description, lieu, pays, date_debut, date_fin, capacite, places_disponibles, statut, photo_principale, type_hebergement) VALUES
(1, 'Aventure en Montagne', 'Explorez les sommets majestueux et profitez de la nature.', 'Chamonix', 'France', '2024-07-01', '2024-07-08', 20, 15, 'Disponible', 'montagne_01.jpg', 'Chalet'),
(2, 'Détente au Bord de Mer', 'Séjour relaxant sur les plages ensoleillées.', 'Nice', 'France', '2024-07-15', '2024-07-22', 25, 20, 'Disponible', 'mer_01.jpg', 'Hôtel'),
(3, 'Safari en Afrique', 'Découvrez la faune sauvage dans son habitat naturel.', 'Serengeti', 'Tanzanie', '2024-08-01', '2024-08-10', 15, 10, 'Disponible', 'safari_01.jpg', 'Lodge'),
(4, 'Randonnée en Patagonie', 'Des paysages à couper le souffle pour les amoureux de la marche.', 'El Chalten', 'Argentine', '2024-09-01', '2024-09-12', 18, 12, 'Disponible', 'patagonie_01.jpg', 'Camping'),
(5, 'Circuit Culturel Japon', 'Immersion dans la culture et les traditions japonaises.', 'Kyoto', 'Japon', '2024-10-01', '2024-10-09', 22, 18, 'Disponible', 'japon_01.jpg', 'Ryokan'),
(6, 'Plongée aux Maldives', 'Explorez les fonds marins exceptionnels.', 'Malé', 'Maldives', '2024-11-01', '2024-11-07', 10, 8, 'Disponible', 'maldives_01.jpg', 'Bungalow'),
(7, 'Ski dans les Alpes', 'Profitez des pistes enneigées et des paysages hivernaux.', 'Courchevel', 'France', '2024-12-01', '2024-12-08', 30, 25, 'Disponible', 'ski_01.jpg', 'Appartement'),
(8, 'Exploration de la Forêt Amazonienne', 'Une aventure unique au cœur de la biodiversité.', 'Manaus', 'Brésil', '2025-01-01', '2025-01-10', 12, 7, 'Disponible', 'amazonie_01.jpg', 'Éco-lodge'),
(9, 'Voyage en Islande', 'Découvrez les aurores boréales et les paysages volcaniques.', 'Reykjavik', 'Islande', '2025-02-01', '2025-02-07', 16, 10, 'Disponible', 'islande_01.jpg', 'Hôtel'),
(10, 'Croisière en Méditerranée', 'Visitez plusieurs pays et profitez de la mer.', 'Barcelone', 'Espagne', '2025-03-01', '2025-03-08', 40, 35, 'Disponible', 'mediterranee_01.jpg', 'Bateau'),
(11, 'Aventure Désertique', 'Explorez les dunes et les oasis du désert.', 'Marrakech', 'Maroc', '2025-04-01', '2025-04-06', 14, 9, 'Disponible', 'desert_01.jpg', 'Bivouac'),
(12, 'Escapade Urbaine Londres', 'Découvrez les monuments et l\'ambiance de Londres.', 'Londres', 'Royaume-Uni', '2025-05-01', '2025-05-05', 28, 22, 'Disponible', 'londres_01.jpg', 'Hôtel'),
(13, 'Randonnée en Nouvelle-Zélande', 'Des paysages époustouflants pour les marcheurs.', 'Queenstown', 'Nouvelle-Zélande', '2025-06-01', '2025-06-14', 18, 13, 'Disponible', 'nz_01.jpg', 'Gîte'),
(14, 'Séjour Balnéaire Thaïlande', 'Plages de sable blanc et eaux turquoises.', 'Phuket', 'Thaïlande', '2025-07-01', '2025-07-08', 25, 20, 'Disponible', 'thailande_01.jpg', 'Resort'),
(15, 'Découverte de l\'Égypte Antique', 'Voyage à travers l\'histoire et les pyramides.', 'Le Caire', 'Égypte', '2025-08-01', '2025-08-09', 20, 16, 'Disponible', 'egypte_01.jpg', 'Bateau de croisière'),
(16, 'Aventure en Laponie', 'Rencontrez le Père Noël et admirez les aurores boréales.', 'Rovaniemi', 'Finlande', '2025-09-01', '2025-09-06', 15, 10, 'Disponible', 'laponie_01.jpg', 'Igloo'),
(17, 'Road Trip USA Ouest', 'Parcs nationaux et villes emblématiques.', 'Los Angeles', 'États-Unis', '2025-10-01', '2025-10-15', 20, 15, 'Disponible', 'usa_01.jpg', 'Motel'),
(18, 'Séjour Gastronomique Italie', 'Découvrez les saveurs de la cuisine italienne.', 'Florence', 'Italie', '2025-11-01', '2025-11-07', 12, 9, 'Disponible', 'italie_01.jpg', 'Agriturismo'),
(19, 'Exploration de la Grande Barrière de Corail', 'Plongée et snorkeling dans un site unique.', 'Cairns', 'Australie', '2025-12-01', '2025-12-08', 10, 7, 'Disponible', 'australie_01.jpg', 'Bateau'),
(20, 'Escapade Romantique Paris', 'La ville de l\'amour et ses monuments.', 'Paris', 'France', '2026-01-01', '2026-01-05', 18, 14, 'Disponible', 'paris_01.jpg', 'Hôtel de charme'),
(21, 'Trek au Népal', 'Aventure en haute montagne avec des vues imprenables.', 'Katmandou', 'Népal', '2026-02-01', '2026-02-12', 15, 10, 'Disponible', 'nepal_01.jpg', 'Tea House'),
(22, 'Découverte de la Grèce Antique', 'Sites historiques et îles paradisiaques.', 'Athènes', 'Grèce', '2026-03-01', '2026-03-08', 22, 17, 'Disponible', 'grece_01.jpg', 'Hôtel'),
(23, 'Voyage en Afrique du Sud', 'Safaris et paysages variés.', 'Le Cap', 'Afrique du Sud', '2026-04-01', '2026-04-10', 18, 14, 'Disponible', 'afriquesud_01.jpg', 'Lodge'),
(24, 'Aventure en Forêt Noire', 'Randonnée et contes de fées en Allemagne.', 'Fribourg', 'Allemagne', '2026-05-01', '2026-05-07', 20, 16, 'Disponible', 'foretnoire_01.jpg', 'Gîte rural'),
(25, 'Séjour Bien-être Bali', 'Détente et spiritualité sur l\'île des Dieux.', 'Ubud', 'Indonésie', '2026-06-01', '2026-06-08', 15, 12, 'Disponible', 'bali_01.jpg', 'Villa');

INSERT INTO employe (id_employe, id_utilisateur, poste, statut) VALUES
(1, 2, 'Manager', 'Actif'),
(2, 4, 'Guide de Montagne', 'Actif'),
(3, 6, 'Agent de Réservation', 'Actif'),
(4, 8, 'Responsable Logistique', 'Actif'),
(5, 10, 'Guide Culturel', 'Actif'),
(6, 12, 'Spécialiste Plongée', 'Actif'),
(7, 14, 'Moniteur de Ski', 'Actif'),
(8, 16, 'Expert Faune', 'Actif'),
(9, 18, 'Coordinateur Voyages', 'Actif'),
(10, 20, 'Conseiller Clientèle', 'Actif'),
(11, 22, 'Développeur Produits', 'Actif'),
(12, 24, 'Chargé de Communication', 'Actif');

INSERT INTO reservation (id_reservation, id_utilisateur, id_offre, date_reservation, statut) VALUES
(1, 1, 1, '2024-06-01', 'Confirmée'),
(2, 3, 2, '2024-06-05', 'Confirmée'),
(3, 5, 3, '2024-06-10', 'En attente'),
(4, 7, 4, '2024-06-12', 'Confirmée'),
(5, 9, 5, '2024-06-15', 'Confirmée'),
(6, 11, 6, '2024-06-18', 'En attente'),
(7, 13, 7, '2024-06-20', 'Confirmée'),
(8, 15, 8, '2024-06-22', 'Confirmée'),
(9, 17, 9, '2024-06-25', 'En attente'),
(10, 19, 10, '2024-06-28', 'Confirmée'),
(11, 21, 11, '2024-07-01', 'Confirmée'),
(12, 23, 12, '2024-07-03', 'Confirmée'),
(13, 25, 13, '2024-07-05', 'En attente'),
(14, 1, 14, '2024-07-07', 'Confirmée'),
(15, 3, 15, '2024-07-10', 'Confirmée'),
(16, 5, 16, '2024-07-12', 'En attente'),
(17, 7, 17, '2024-07-15', 'Confirmée'),
(18, 9, 18, '2024-07-18', 'Confirmée'),
(19, 11, 19, '2024-07-20', 'En attente'),
(20, 13, 20, '2024-07-22', 'Confirmée'),
(21, 15, 21, '2024-07-25', 'Confirmée'),
(22, 17, 22, '2024-07-28', 'En attente'),
(23, 19, 23, '2024-08-01', 'Confirmée'),
(24, 21, 24, '2024-08-03', 'Confirmée'),
(25, 23, 25, '2024-08-05', 'En attente');

INSERT INTO affectation_employe (id_affectation, id_employe, id_offre, role) VALUES
(1, 1, 1, 'Responsable'),
(2, 2, 1, 'Assistant'),
(3, 1, 2, 'Responsable'),
(4, 3, 2, 'Assistant'),
(5, 4, 3, 'Responsable'),
(6, 5, 3, 'Assistant'),
(7, 2, 4, 'Responsable'),
(8, 4, 4, 'Assistant'),
(9, 5, 5, 'Responsable'),
(10, 1, 5, 'Assistant'),
(11, 6, 6, 'Responsable'),
(12, 3, 6, 'Assistant'),
(13, 7, 7, 'Responsable'),
(14, 2, 7, 'Assistant'),
(15, 8, 8, 'Responsable'),
(16, 5, 8, 'Assistant'),
(17, 9, 9, 'Responsable'),
(18, 4, 9, 'Assistant'),
(19, 10, 10, 'Responsable'),
(20, 6, 10, 'Assistant'),
(21, 11, 11, 'Responsable'),
(22, 7, 11, 'Assistant'),
(23, 12, 12, 'Responsable'),
(24, 8, 12, 'Assistant'),
(25, 1, 13, 'Responsable');