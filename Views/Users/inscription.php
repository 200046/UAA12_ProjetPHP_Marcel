<div class="inscription-container">
        <div class="inscription-header">
            <h1>Créez votre compte</h1>
        </div>
        
        <form class="inscription-form" method="post">
            <div class="form-group">
                <label for="prenom">Prénom</label>
                <input type="text" id="prenom" placeholder="Votre prénom" name="prenom" required>
            </div>
            
            <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" id="nom" placeholder="Votre nom" name="nom" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" placeholder="exemple@email.com" name="email" required>
            </div>

            <div class="form-group">
                <label for="telephone">telephone</label>
                <input type="phone" id="telephone" placeholder="0471659863" name="telephone" required>
            </div>
            
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="motdepasse" placeholder="••••••••" name="motdepasse" required>
                <small>8 caractères minimum</small>
            </div>
            
            <div class="form-actions">
                <button type="submit" value="btnEnvoi" name="btnEnvoi">S'inscrire</button>
            </div>
            
            <div class="login-link">
                <p>Déjà membre ? <a href="connexion">Connectez-vous</a></p>
            </div>
        </form>
</div>