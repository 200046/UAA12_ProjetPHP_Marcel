<div class="header">
    <div class="logo">
        <p>Campignions</p>
    </div>
    <nav class="nav" aria-label="Menu de navigation">
        <ul>
            <li><a href="/">Accueil</a></li>
            <li><a href="about">Qui sommes-nous ?</a></li>
            <li><a href="team">Notre équipe</a></li>

            <?php if (isset($_SESSION['user'])) : ?>
                <li><a href="compte">Mon compte</a></li>
                <?php if ($_SESSION['user']->role === 'admin') : ?>
                    <li><a href="gestion">Panel d'administration</a></li>
                <?php endif; ?>
                <?php if ($_SESSION['user']->role === 'employe') : ?>
                    <li><a href="mes-affectations">Vos affectations</a></li>
                <?php endif; ?>
                <?php if ($_SESSION['user']->role === 'client') : ?>
                    <li><a href="mes-reservations">Vos réservations</a></li>
                <?php endif; ?>
                <li><a href="deconnexion">Se déconnecter</a></li>
            <?php else : ?>
                <li><a href="inscription">Inscription</a></li>
                <li><a href="connexion">Connexion</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</div>