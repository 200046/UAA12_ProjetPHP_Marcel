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