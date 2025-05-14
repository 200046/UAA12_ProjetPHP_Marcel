<section class="team-section">
    <div class="team-header">
        <h1>Notre Équipe d'Experts</h1>
        <p>Découvrez les passionnés qui font de votre séjour une expérience unique</p>
    </div>

    <div class="team-grid">
        <?php foreach ($teamMembers as $member): ?>
            <div class="team-member">
                <div class="member-photo">
                    <?php $randomPhoto = rand(1, 10); ?>
                    <img src="../../Assets/Photo-team/<?= $randomPhoto ?>.png" alt="<?= htmlspecialchars($member['prenom'] . ' ' . $member['nom']); ?>">
                    <span class="status-badge <?= strtolower($member['statut_employe']); ?>"></span>
                </div>

                <div class="member-info">
                    <h3><?= htmlspecialchars($member['prenom'] . ' ' . $member['nom']); ?></h3>
                    <p class="position"><?= htmlspecialchars($member['poste']); ?></p>

                    <div class="member-contact">
                        <a class="email-button"
                            href="mailto:<?= htmlspecialchars($member['email']); ?>?subject=Contact%20depuis%20le%20site&body=Bonjour%20<?= htmlspecialchars($member['prenom']); ?>%2C%0D%0A%0D%0AJe%20souhaite%20vous%20contacter%20concernant%20%3A%20%5Bvotre%20objet%20ici%5D.%0D%0A%0D%0AMes%20informations%20%3A%0D%0A-%20Nom%20%3A%20%5Bvotre%20nom%5D%0D%0A-%20Prénom%20%3A%20%5Bvotre%20prénom%5D%0D%0A-%20Téléphone%20%3A%20%5Bvotre%20numéro%5D%0D%0A-%20Message%20%3A%0D%0A%5Bvotre%20message%5D%0D%0A%0D%0ACordialement%2C%0D%0A%5Bsignature%5D">
                            <button type="button">Contacter par email</button>
                        </a>

                        <div class="phone-wrapper">
                            <button type="button" onclick="togglePhoneInfo(this)">Appeler</button>
                            <div class="phone-info">
                                <p><strong>Horaires d'appel :</strong><br>
                                    Lundi au vendredi : 9h - 12h / 14h - 18h<br>
                                    Samedi : 10h - 13h<br>
                                    Fermé le dimanche</p>

                                <p><strong>Tarifs :</strong><br>
                                    Appel non surtaxé — coût d’un appel local depuis la France métropolitaine.<br>
                                    Gratuit depuis un forfait illimité ou via une box internet.</p>

                                <a href="tel:<?= htmlspecialchars($member['telephone']); ?>" class="call-now">📞 Appeler maintenant</a>
                            </div>
                        </div>

                    </div>

                    <?php $assignments = getEmployeeAssignments($pdo, $member['id_employe']); ?>
                    <?php if (!empty($assignments)): ?>
                        <div class="member-assignments">
                            <p><strong>Affectations :</strong></p>
                            <ul>
                                <?php foreach ($assignments as $assignment): ?>
                                    <li>
                                        <a href="offre?id=<?= $assignment['id_offre']; ?>">
                                            <?= htmlspecialchars($assignment['titre']); ?>
                                            <?php if (!empty($assignment['role'])): ?>
                                                <span class="role">(<?= htmlspecialchars($assignment['role']); ?>)</span>
                                            <?php endif; ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>