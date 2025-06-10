<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <?php foreach ($errors as $error): ?>
            <p><?php echo htmlspecialchars($error); ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php if (!empty($successMessage)): ?>
    <div class="alert alert-success">
        <p><?php echo htmlspecialchars($successMessage); ?></p>
    </div>
<?php endif; ?>

<?php if ($offre): // Si l'offre est trouvée et valide ?>
    <h1>Détails de la réservation pour : <?php echo htmlspecialchars($offre['titre']); ?></h1>
    <p>Lieu : <?php echo htmlspecialchars($offre['lieu'] . ', ' . $offre['pays']); ?></p>
    <p>Places disponibles : <?php echo htmlspecialchars($offre['places_disponibles']); ?></p>
    <?php else: ?>
    <p>Impossible d'afficher les détails de l'offre.</p>
<?php endif; ?>
<h1><?= $offre['titre'] ?></h1>
<p><?= $offre['description'] ?></p>
<p>Lieu : <?= $offre['lieu'] ?>, <?= $offre['pays'] ?></p>
<p>Prix : <?= $offre['prix'] ?>€</p>
<p>Places disponibles : <?= $offre['places_disponibles'] ?></p>

<?php if (!empty($errors)): ?>
    <ul class="error">
        <?php foreach ($errors as $err): ?>
            <li><?= $err ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php if (!empty($successMessage)): ?>
    <p class="success"><?= $successMessage ?></p>
<?php endif; ?>

<form method="POST">
    <label for="nombre_places">Nombre de places à réserver :</label>
    <input type="number" name="nombre_places" id="nombre_places" required min="1" max="<?= $offre['places_disponibles'] ?>">
    
    <button type="submit" name="btnReserver">Réserver</button>
</form>
