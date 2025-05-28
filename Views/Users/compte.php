<div id="profile" class="tab-content active">
    <div class="user-info">
        <h2 class="section-title">Informations Personnelles</h2>
        
        <form method="post" action="/compte">
            <div class="edit-form">
                <div class="form-group">
                    <label for="nom">Nom</label>
                    <input type="text" id="nom" name="nom" value="<?=$_SESSION["user"]->nom?>" required>
                    <?php if (isset($errors['nom'])): ?>
                        <span class="error"><?= $errors['nom'] ?></span>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="prenom">Prénom</label>
                    <input type="text" id="prenom" name="prenom" value="<?=$_SESSION["user"]->prenom?>" required>
                    <?php if (isset($errors['prenom'])): ?>
                        <span class="error"><?= $errors['prenom'] ?></span>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?=$_SESSION["user"]->email?>" required>
                    <?php if (isset($errors['email'])): ?>
                        <span class="error"><?= $errors['email'] ?></span>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="telephone">Téléphone</label>
                    <input type="tel" id="telephone" name="telephone" value="<?=$_SESSION["user"]->telephone?>" required>
                    <?php if (isset($errors['telephone'])): ?>
                        <span class="error"><?= $errors['telephone'] ?></span>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="motdepasse">Mot de passe</label>
                    <input type="password" id="motdepasse" name="motdepasse" placeholder="Laissez vide pour ne pas modifier">
                    <?php if (isset($errors['motdepasse'])): ?>
                        <span class="error"><?= $errors['motdepasse'] ?></span>
                    <?php endif; ?>
                </div>
                <div class="form-actions">
                    <button type="submit" name="updateProfile" class="btn btn-primary">Sauvegarder</button>
                </div>
            </div>
        </form>
        
        <div class="account-actions">
            <a href="/delete" class="btn btn-danger">Supprimer mon compte</a>
        </div>
    </div>
</div>