<h1>Bienvenue sur notre agence de camping !</h1>
<p>Réservez vos prochaines vacances ci-dessous 🏕️</p>
<div class="cards-container">
    <?php foreach ($offres as $offre): ?>
        <div class="card">
            <h2><?php echo  $offre['titre']; ?></h2>
            <p>Adresse : <?php echo $offre['lieu'] . ', ' . $offre['pays']; ?></p>
            <p><?php echo $offre['description']; ?></p>
            <p>Places disponibles : <?php echo $offre['places_disponibles']; ?></p>

            <?php if ($offre['places_disponibles'] > 0): ?>
                <?php if (isset($_SESSION["user"])): ?>
                    <a href="reserver?id_offre=<?php echo $offre['id_offre']; ?>" class="btn btn-primary btnReserver">Voir plus</a>
                <?php else: ?>
                    <p class="warning">Connectez-vous pour réserver.</p>
                <?php endif; ?>
            <?php else: ?>
                <p class="warning">Désolé, cette offre est complète.</p>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>