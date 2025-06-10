<h2>Modifier</h2>
<div class="cards-container">
    <form method="post" action="/gestion">
        <?php foreach ($offres as $offre): ?>
            <div class="card">
                <h3>Offre #<?php echo $offre['id_offre']; ?></h3>
                <input type="hidden" name="id_offre[]" value="<?php echo $offre['id_offre']; ?>">

                <p>
                    <label for="titre_<?php echo $offre['id_offre']; ?>">Titre :</label>
                    <input type="text" name="titre[]" id="titre_<?php echo $offre['id_offre']; ?>" value="<?php echo htmlspecialchars($offre['titre']); ?>" required>
                </p>

                <p>
                    <label for="lieu_<?php echo $offre['id_offre']; ?>">Lieu :</label>
                    <input type="text" name="lieu[]" id="lieu_<?php echo $offre['id_offre']; ?>" value="<?php echo htmlspecialchars($offre['lieu']); ?>" required>
                </p>

                <p>
                    <label for="pays_<?php echo $offre['id_offre']; ?>">Pays :</label>
                    <input type="text" name="pays[]" id="pays_<?php echo $offre['id_offre']; ?>" value="<?php echo htmlspecialchars($offre['pays']); ?>" required>
                </p>

                <p>
                    <label for="description_<?php echo $offre['id_offre']; ?>">Description :</label>
                    <textarea name="description[]" id="description_<?php echo $offre['id_offre']; ?>" rows="5" required><?php echo htmlspecialchars($offre['description']); ?></textarea>
                </p>

                <p>
                    <label for="places_disponibles_<?php echo $offre['id_offre']; ?>">Places disponibles :</label>
                    <input type="number" name="places_disponibles[]" id="places_disponibles_<?php echo $offre['id_offre']; ?>" value="<?php echo htmlspecialchars($offre['places_disponibles']); ?>" required>
                </p>
            </div>
        <?php endforeach; ?>
        <button type="submit" name="updateSejoursBtn" class="btn btn-success">Enregistrer les modifications</button>
    </form>
</div>

<h2>Créer un nouveau séjour</h2>
<div class="cards-container">
    <form method="post" action="/gestion">
        <div class="card">
            <p><label for="titre">Titre :</label><input type="text" name="titre" id="titre" required></p>
            <p><label for="lieu">Lieu :</label><input type="text" name="lieu" id="lieu" required></p>
            <p><label for="pays">Pays :</label><input type="text" name="pays" id="pays" required></p>
            <p><label for="description">Description :</label><textarea name="description" id="description" rows="5" required></textarea></p>
            <p><label for="places_disponibles">Places disponibles :</label><input type="number" name="places_disponibles" id="places_disponibles" required></p>
        </div>
        <button type="submit" name="createSejourBtn" class="btn btn-primary">Créer le séjour</button>
    </form>
</div>