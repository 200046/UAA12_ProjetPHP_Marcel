<div class="container mt-4">
    <h1>Mes Réservations</h1>

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

    <?php if (!empty($reservations)): ?>
        <div class="row">
            <?php foreach ($reservations as $reservation): ?>
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <?php if (!empty($reservation['photo_principale'])): ?>
                            <img src="/assets/images/offres/<?php echo htmlspecialchars($reservation['photo_principale']); ?>" class="card-img-top" alt="Photo de l'offre" style="max-height: 200px; object-fit: cover;">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($reservation['titre_offre']); ?></h5>
                            <p class="card-text">
                                Date de réservation : <strong><?php echo htmlspecialchars(date('d/m/Y', strtotime($reservation['date_reservation']))); ?></strong><br>
                                Statut de votre réservation : <span class="badge <?php
                                    if ($reservation['statut_reservation'] === 'Confirmée') echo 'bg-success';
                                    elseif ($reservation['statut_reservation'] === 'En attente') echo 'bg-warning text-dark';
                                    elseif ($reservation['statut_reservation'] === 'Annulée') echo 'bg-danger';
                                    else echo 'bg-secondary';
                                ?>">
                                    <?php echo htmlspecialchars($reservation['statut_reservation']); ?>
                                </span>
                            </p>
                            <hr>
                            <p class="card-text">
                                **Détails de l'Offre :**<br>
                                Lieu : <?php echo htmlspecialchars($reservation['lieu'] . ', ' . $reservation['pays']); ?><br>
                                Période : Du <?php echo htmlspecialchars(date('d/m/Y', strtotime($reservation['date_debut']))); ?> au <?php echo htmlspecialchars(date('d/m/Y', strtotime($reservation['date_fin']))); ?><br>
                                Type d'hébergement : <?php echo htmlspecialchars($reservation['type_hebergement']); ?><br>
                                Statut de l'offre : <?php echo htmlspecialchars($reservation['statut_offre']); ?>
                            </p>
                            <?php if (!empty($reservation['description_offre'])): ?>
                                <p class="card-text">
                                    Description : <?php echo nl2br(htmlspecialchars($reservation['description_offre'])); ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info" role="alert">
            <?php echo htmlspecialchars($errors['no_reservations'] ?? 'Aucune réservation trouvée pour le moment.'); ?>
            <p>N'hésitez pas à explorer nos <a href="/">offres de séjour</a> pour votre prochaine aventure !</p>
        </div>
    <?php endif; ?>
</div>