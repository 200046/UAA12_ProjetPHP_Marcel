<?php 
// Récupérer les réservations pour un client
if ($_SESSION["user"]->role == "client") {
    $reservations = getReservations($pdo, $_SESSION["user"]->id_utilisateur);
}

// Récupérer les affectations pour un employé
if ($_SESSION["user"]->role != "client") {
    $affectations = getAffectations($pdo, $_SESSION["user"]->id_utilisateur);
} 
?>

<input type="radio" name="tabs" id="profile-tab" checked>
<?php if ($_SESSION["user"]->role == "client"): ?>
    <input type="radio" name="tabs" id="reservations-tab">
<?php elseif ($_SESSION["user"]->role != "client"): ?>
    <input type="radio" name="tabs" id="assignments-tab">
<?php endif; ?>

<div class="tabs">
    <label for="profile-tab" class="tab">Profil</label>
    <?php if ($_SESSION["user"]->role == "client"): ?>
        <label for="reservations-tab" class="tab">Mes Réservations</label>
    <?php elseif ($_SESSION["user"]->role != "client"): ?>
        <label for="assignments-tab" class="tab">Mes Affectations</label>
    <?php endif; ?>
</div>

<div id="profile" class="tab-content active">
    <div class="user-info">
        <h2 class="section-title">Informations Personnelles</h2>
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Nom</div>
                <div class="info-value"><?= $_SESSION["user"]->nom ?></div>
            </div>
            <div class="info-item">
                <div class="info-label">Prenom</div>
                <div class="info-value"><?= $_SESSION["user"]->prenom ?></div>
            </div>
            <div class="info-item">
                <div class="info-label">Téléphone</div>
                <div class="info-value"><?= $_SESSION["user"]->telephone ?></div>
            </div>
            <div class="info-item">
                <div class="info-label">Date d'inscription</div>
                <div class="info-value"><?= $_SESSION["user"]->date_inscription ?></div>
            </div>
            <div class="info-item">
                <div class="info-label">Adresse email</div>
                <div class="info-value"><?= $_SESSION["user"]->email ?></div>
            </div>
        </div>
        <!-- Bouton de suppression de compte -->
        <div class="account-actions">
            <form action="delete">
                <a href="delete">Supprimer mon compte</button>
            </form>
        </div>
    </div>
</div>
<?php if ($_SESSION["user"]->role == "client"): ?>
    <div id="reservations" class="tab-content">
        <h2>Mes Réservations</h2>
        <table>
            <thead>
                <tr>
                    <th>ID Réservation</th>
                    <th>Séjour</th>
                    <th>Lieu</th>
                    <th>Dates</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($reservations)): ?>
                    <?php foreach ($reservations as $res): ?>
                        <tr>
                            <td><?= 'RES-' . str_pad($res['id_reservation'], 4, '0', STR_PAD_LEFT) ?></td>
                            <td><?= $res['titre'] ?></td>
                            <td><?= $res['lieu'] ?></td>
                            <td><?= date('d/m/Y', strtotime($res['date_debut'])) ?> - <?= date('d/m/Y', strtotime($res['date_fin'])) ?></td>
                            <td><span class="status status-<?= strtolower($res['statut']) ?>"><?= $res['statut'] ?></span></td>
                            <td>
                                <a href="#" class="btn btn-secondary">Détails</a>
                                <?php if (strtolower($res['statut']) !== 'annulee'): ?>
                                    <a href="#" class="btn btn-danger">Annuler</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6">Aucune réservation trouvée. 😔</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>


<?php if ($_SESSION["user"]->role != "client"): ?>
    <div id="assignments" class="tab-content">
        <h2>Mes Affectations</h2>
        <table>
            <thead>
                <tr>
                    <th>ID Affectation</th>
                    <th>Séjour</th>
                    <th>Lieu</th>
                    <th>Dates</th>
                    <th>Rôle</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($affectations)): ?>
                    <?php foreach ($affectations as $aff): ?>
                        <tr>
                            <td><?= 'AFF-' . str_pad($aff['id_affectation'], 4, '0', STR_PAD_LEFT) ?></td>
                            <td><?= $aff['titre'] ?></td>
                            <td><?= $aff['lieu'] ?></td>
                            <td><?= date('d/m/Y', strtotime($aff['date_debut'])) ?> - <?= date('d/m/Y', strtotime($aff['date_fin'])) ?></td>
                            <td><?= $aff['role'] ?></td>
                            <td><span class="status status-<?= strtolower($aff['role']) ?>"><?= $aff['role'] ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6">Aucune affectation trouvée. 😔</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

