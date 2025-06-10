<div class="container mt-4">
    <h1>Mes Affectations</h1>

    <?php if (!empty($successMessage)): ?>
        <div class="alert alert-success" role="alert">
            <?php echo htmlspecialchars($successMessage); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger" role="alert">
            <?php foreach ($errors as $error): ?>
                <p><?php echo htmlspecialchars($error); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($affectations)): ?>
        <div class="row">
            <?php foreach ($affectations as $affectation): ?>
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Titre de l'Offre : <?php echo htmlspecialchars($affectation['titre_offre']); ?></h5>
                            <p class="card-text">
                                <small class="text-muted">Votre rôle : <strong><?php echo htmlspecialchars($affectation['role_affectation']); ?></strong></small><br>
                                Lieu : <?php echo htmlspecialchars($affectation['lieu'] . ', ' . $affectation['pays']); ?><br>
                                Du : <?php echo htmlspecialchars(date('d/m/Y', strtotime($affectation['date_debut']))); ?><br>
                                Au : <?php echo htmlspecialchars(date('d/m/Y', strtotime($affectation['date_fin']))); ?>
                            </p>
                            <?php if (!empty($affectation['description_offre'])): ?>
                                <p class="card-text">
                                    Description de l'Offre : <?php echo nl2br(htmlspecialchars($affectation['description_offre'])); ?>
                                </p>
                            <?php endif; ?>
                            <p class="card-text"><small class="text-muted">Statut de l'offre : <?php echo htmlspecialchars($affectation['statut_offre']); ?></small></p>
                            <?php if (!empty($affectation['description_affectation'])): ?>
                                <p class="card-text">Notes d'affectation : <?php echo nl2br(htmlspecialchars($affectation['description_affectation'])); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info" role="alert">
            <?php echo $errors['no_affectations'] ?? 'Aucune affectation trouvée pour le moment.'; ?>
        </div>
    <?php endif; ?>
</div>