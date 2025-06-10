<!-- PAGE ADMIN -->
<p>Vous êtes connecté en: <span><?= $_SESSION["user"]->email ?></span> - <span><?= $_SESSION["user"]->nom ?></span> <span><?= $_SESSION["user"]->prenom ?></span></p>
<h2>Modifier</h2>
<div class="cards-container">
    <form method="post" action="/gestion">
        <?php foreach ($offres as $offre): ?>
            <p>
                <label for="titre_<?php echo $offre['id_offre']; ?>">Titre :</label>
                <input type="text" name="titre[]" id="titre_<?php echo $offre['id_offre']; ?>" value="<?php echo $offre['titre']; ?>" required>
            </p>

            <p>
                <label for="prix_<?php echo $offre['id_offre']; ?>">Prix :</label>
                <input type="number" name="prix[]" id="prix_<?php echo $offre['id_offre']; ?>" value="<?php echo $offre['prix']; ?>" required>
            </p>

            <p>
                <label for="lieu_<?php echo $offre['id_offre']; ?>">Lieu :</label>
                <input type="text" name="lieu[]" id="lieu_<?php echo $offre['id_offre']; ?>" value="<?php echo $offre['lieu']; ?>" required>
            </p>

            <p>
                <label for="pays_<?php echo $offre['id_offre']; ?>">Pays :</label>
                <input type="text" name="pays[]" id="pays_<?php echo $offre['id_offre']; ?>" value="<?php echo $offre['pays']; ?>" required>
            </p>

            <p>
                <label for="description_<?php echo $offre['id_offre']; ?>">Description :</label>
                <textarea name="description[]" id="description_<?php echo $offre['id_offre']; ?>" rows="5" required><?php echo $offre['description']; ?></textarea>
            </p>

            <p>
                <label for="places_disponibles_<?php echo $offre['id_offre']; ?>">Places disponibles :</label>
                <input type="number" name="places_disponibles[]" id="places_disponibles_<?php echo $offre['id_offre']; ?>" value="<?php echo $offre['places_disponibles']; ?>" required>
            </p>

            <?php if ($offre['places_disponibles'] > 0): ?>
                <?php if (isset($_SESSION["user"])): ?>
                    <a href="reserver?offre_id=<?php echo $offre['id_offre']; ?>" class="btn btn-primary">Voir plus</a>
                <?php else: ?>
                    <p class="warning">Connectez-vous pour réserver.</p>
                <?php endif; ?>
            <?php else: ?>
                <p class="warning">Désolé, cette offre est complète.</p>
            <?php endif; ?>
            <?php endforeach; ?>
<button type="updateSejour" class="btn btn-success">Enregistrer les modifications</button>
</form>
</div>

<h2>Créer un nouveau séjour</h2>
<div class="cards-container">
    <form method="post" action="/gestion">
        <p>
            <label for="titre">Titre :</label>
            <input type="text" name="titre" id="titre" required>
        </p>

        <p>
            <label for="prix">Prix :</label>
            <input type="number" name="prix" id="prix" required>
        </p>

        <p>
            <label for="lieu">Lieu :</label>
            <input type="text" name="lieu" id="lieu" required>
        </p>

        <p>
            <label for="pays">Pays :</label>
            <input type="text" name="pays" id="pays" required>
        </p>

        <p>
            <label for="description">Description :</label>
            <textarea name="description" id="description" rows="5" required></textarea>
        </p>

        <p>
            <label for="places_disponibles">Places disponibles :</label>
            <input type="number" name="places_disponibles" id="places_disponibles" required>
        </p>

        <button type="createSejour" class="btn btn-primary">Créer le séjour</button>
    </form>
</div>