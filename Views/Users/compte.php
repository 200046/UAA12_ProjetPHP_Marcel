  <!-- Radio buttons pour gérer les onglets -->
    <input type="radio" name="tabs" id="profile-tab" checked>
    <input type="radio" name="tabs" id="reservations-tab">
    <input type="radio" name="tabss" id="assignments-tab">
    
    <div class="tabs">
        <label for="profile-tab" class="tab">Profil</label>
        <label for="reservations-tab" class="tab">Mes Réservations</label>
        <label for="assignments-tab" class="tab">Mes Affectations</label>
    </div>
    
    <h6>Page fictive avec de fausses données pour les tests !</h6>
    <div id="profile" class="tab-content active">
        <div class="user-info">
            <h2 class="section-title">Informations Personnelles</h2>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Nom complet</div>
                    <div class="info-value">Jean Dupont</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Email</div>
                    <div class="info-value">jean.dupont@example.com</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Téléphone</div>
                    <div class="info-value">+33 6 12 34 56 78</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Date d'inscription</div>
                    <div class="info-value">15/03/2023</div>
                </div>
               <!--  <div class="info-item">
                    <div class="info-label">Rôle</div>
                    <div class="info-value">Client</div>
                </div>  -->
            </div>
        </div>
    </div>
    
    <div id="reservations" class="tab-content">
        <div class="reservations">
            <h2 class="section-title">Mes Réservations</h2>
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
                    <tr>
                        <td>RES-0001</td>
                        <td>Séjour à la montagne</td>
                        <td>Chamonix, France</td>
                        <td>15/07/2023 - 22/07/2023</td>
                        <td><span class="status status-active">Confirmée</span></td>
                        <td>
                            <a href="#" class="btn btn-secondary">Détails</a>
                            <a href="#" class="btn btn-danger">Annuler</a>
                        </td>
                    </tr>
                    <tr>
                        <td>RES-0002</td>
                        <td>Vacances à la mer</td>
                        <td>Nice, France</td>
                        <td>10/08/2023 - 20/08/2023</td>
                        <td><span class="status status-pending">En attente</span></td>
                        <td>
                            <a href="#" class="btn btn-secondary">Détails</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    
    <div id="assignments" class="tab-content">
        <div class="employee-assignments">
            <h2 class="section-title">Mes Affectations</h2>
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
                    <tr>
                        <td>AFF-0001</td>
                        <td>Séjour à la montagne</td>
                        <td>Chamonix, France</td>
                        <td>15/07/2023 - 22/07/2023</td>
                        <td>Personnel d'entretien</td>
                        <td><span class="status status-active">Active</span></td>
                    </tr>
                    <tr>
                        <td>AFF-0002</td>
                        <td>Vacances à la mer</td>
                        <td>Nice, France</td>
                        <td>10/08/2023 - 20/08/2023</td>
                        <td>Cuisinier</td>
                        <td><span class="status status-pending">En attente de confirmation</span></td>
                    </tr>
                </tbody>
            </table>
        </div>