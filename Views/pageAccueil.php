<?php 
// Appeler la fonction pour récupérer les offres
/* // Afficher les offres pour débogage (par exemple)
echo '<pre>';
print_r($offres);
echo '</pre>';
*/
?>
 <h1>Bienvenue sur notre agence de camping !</h1>
    <p>Réservez vos prochaines vacances ci-dessous 🏕️</p>

    <div class="cards-container">
        <?php foreach ($offres as $offre): ?>
            <div class="card">
                <h2><?php echo  $offre['titre']; ?></h2>
                <p>Prix : <?php echo $offre['prix_par_nuit']; ?>€/nuit</p>
                <p>Adresse : <?php echo $offre['lieu'] . ', ' . $offre['pays']; ?></p>
                <p><?php echo $offre['description']; ?></p>
                <p>Places disponibles : <?php echo $offre['places_disponibles']; ?></p>

                <?php if ($offre['places_disponibles'] > 0): ?>
                    <?php if ($isClientLoggedIn): ?>
                        <a href="reserver?offre_id=<?php echo $offre['id_offre']; ?>" class="btn btn-primary">Voir plus</a>
                    <?php else: ?>
                        <p class="warning">Connectez-vous pour réserver.</p>
                    <?php endif; ?>
                <?php else: ?>
                    <p class="warning">Désolé, cette offre est complète.</p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>