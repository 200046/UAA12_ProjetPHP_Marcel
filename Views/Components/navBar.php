<header class="header">
    <div class="logo">
        <a href="#">Campignions</a> 
    </div>
    <nav class="nav" aria-label="Menu de navigation">
        <ul>
            <li><a href="/">Accueil</a></li>
            <li><a href="about">Qui sommes-nous ?</a></li>
            <?php if (isset($_SESSION['user'])) :?>
                <li><a href="compte">Mon compte</a></li>
                <li><a href="deconnexion">Se déconnecter</a></li>
            <?php else :?>
                <li><a href="inscription">Inscription</a></li>
                <li><a href="connexion">Connexion</a></li>
            <?php endif ?>
        </ul>
    </nav>
</header>
