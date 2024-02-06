<?php

            // Récupération des informations pour les menus déroulants
            $sqlRoles = "SELECT * FROM role";
            $roles = $bdd->query($sqlRoles)->fetchAll(PDO::FETCH_ASSOC);
        
            $sqlSessions = "SELECT * FROM session";
            $sessions = $bdd->query($sqlSessions)->fetchAll(PDO::FETCH_ASSOC);
        
            // Récupération de la liste des apprenants pour affichage
            $sqlApprenants = "SELECT app.*, r.nom_role, s.date_debut 
                            FROM apprenants app
                            JOIN role r ON app.id_role = r.id_role
                            JOIN session s ON app.id_session = s.id_session";
            $apprenants = $bdd->query($sqlApprenants)->fetchAll(PDO::FETCH_ASSOC);
    
        ?>

        <!-- Tableau -->
        <div class="centerDiv">

            <!-- Partie d'ajout de données -->
            <form method="POST">
                <h1>Ajout d'un apprenant</h1>
                <label>Nom :</label>
                <input type="text" name="nomApprenant">
                <br>
                <label>Prenom :</label>
                <input type="text" name="prenomApprenant">
                <br>
                <label>Mail :</label>
                <input type="text" name="mailApprenant">
                <br>
                <label>Adresse :</label>
                <input type="text" name="adresseApprenant">
                <br>
                <label>Ville :</label>
                <input type="text" name="villeApprenant">
                <br>
                <label>Code postal :</label>
                <input type="text" name="cpApprenant">
                <br>
                <label>Téléphone :</label>
                <input type="text" name="telApprenant">
                <br>
                <label>Date de naissance :</label>
                <input type="text" name="naissanceApprenant">
                <br>
                <label>Diplome :</label>
                <input type="text" name="nivApprenant">
                <br>
                <label>Pole emploi :</label>
                <input type="text" name="peApprenant">
                <br>
                <label>Numéro de sécurité sociale :</label>
                <input type="text" name="secuApprenant">
                <br>
                <label>RIB :</label>
                <input type="text" name="ribApprenant">
                <br>

                <label>Role :</label>
                <select name="idRoleAp" id="">

                    <?php 
                    foreach ($roles as $role) {
                    echo "<option value='{$role['id_role']}'>{$role['nom_role']}</option>";
                    } 
                    ?>

                </select>
                <br>

                <label>Session :</label>
                <select name="idSession">

                    <?php 
                    foreach ($sessions as $session) {
                    echo "<option value='{$session['id_session']}'>{$session['date_debut']}</option>";
                    } 
                    ?>

                </select><br>

                <input type="submit" name="submitApprenant" value="Enregistrer">
            </form>

            <table border="1">
                <tr>
                    <!-- Noms des colonnes -->
                    <th>Nom :</th>
                    <th>Prenom :</th>
                    <th>Mail :</th>
                    <th>Adresse :</th>
                    <th>Ville :</th>
                    <th>Code postal :</th>
                    <th>Téléphone :</th>
                    <th>Diplome :</th>
                    <th>Modifier :</th>
                    <th>Action :</th>
                </tr>

                <?php
                // Données à entrer dans le tableau par bdd
                foreach ($apprenants as $apprenant) {
                    echo '<tr>';
                    echo '<td>' . ($apprenant['nom_apprenant']) . '</td>';
                    echo '<td>' . ($apprenant['prenom_apprenant']) . '</td>';
                    echo '<td>' . ($apprenant['mail_apprenant']) . '</td>';
                    echo '<td>' . ($apprenant['adresse_apprenant']) . '</td>';
                    echo '<td>' . ($apprenant['ville_apprenant']) . '</td>';
                    echo '<td>' . ($apprenant['code_postal_apprenant']) . '</td>';
                    echo '<td>' . ($apprenant['tel_apprenant']) . '</td>';
                    echo '<td>' . ($apprenant['niveau_apprenant']) . '</td>';
                    echo '<td><a href="?page=apprenant&type=modifier&id=' . $apprenant['id_apprenant'] . '"><button>Modifier</button></a> </td>';
                    echo '<td><a href="?page=apprenant&deleteApprenant=' . $apprenant['id_apprenant'] . '" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer cet apprenant ?\');"><button>Supprimer</button></a></td>';
                    echo '</tr>';
                }
                ?>

            </table>

        </div>
        
        <?php

        // Si URL de type = modifier (true) avec ID :
            // Si URL de type = modifier (true) avec ID pour un apprenant :
            if(isset($_GET['type']) && $_GET['type'] == "modifier" && isset($_GET['id'])) {
                $idApprenant = $_GET['id'];
                $sqlIdApprenant = "SELECT * FROM apprenants WHERE id_apprenant = :idApprenant";
                $stmtIdApprenant = $bdd->prepare($sqlIdApprenant);
                $stmtIdApprenant->execute([':idApprenant' => $idApprenant]);
                $apprenantDetails = $stmtIdApprenant->fetch(PDO::FETCH_ASSOC);

                if ($apprenantDetails) {
                    // Affichez le formulaire de mise à jour avec les informations de l'apprenant pré-remplies
                    ?>
                    <form method="POST">
                        <input type="hidden" name="idApprenant" value="<?php echo ($apprenantDetails['id_apprenant']); ?>">
                        <label>Nom :</label>
                        <input type="text" name="nomApprenant" value="<?php echo ($apprenantDetails['nom_apprenant']); ?>">
                        <br>
                        <label>Prenom :</label>
                        <input type="text" name="prenomApprenant" value="<?php echo ($apprenantDetails['prenom_apprenant']); ?>">
                        <br>
                        <label>Mail :</label>
                        <input type="text" name="mailApprenant" value="<?php echo ($apprenantDetails['mail_apprenant']); ?>">
                        <br>
                        <label>Adresse :</label>
                        <input type="text" name="adresseApprenant" value="<?php echo ($apprenantDetails['adresse_apprenant']); ?>">
                        <br>
                        <label>Ville :</label>
                        <input type="text" name="villeApprenant" value="<?php echo ($apprenantDetails['ville_apprenant']); ?>">
                        <br>
                        <label>Code postal :</label>
                        <input type="text" name="cpApprenant" value="<?php echo ($apprenantDetails['code_postal_apprenant']); ?>">
                        <br>
                        <label>Téléphone</label>
                        <input type="text" name="numApprenant" value="<?php echo ($apprenantDetails['tel_apprenant']); ?>">
                        <br>
                        <!-- Ajoutez d'autres champs ici si nécessaire -->
                        <input type="submit" name="updateApprenant" value="Mettre à jour">
                    </form>
                    <?php
                }
            }

            if (isset($_POST['updateApprenant'])) {
                // Récupérez les valeurs depuis le formulaire
                $idApprenant = $_POST['idApprenant'];
                $nomApprenant = $_POST['nomApprenant'];
                $prenomApprenant = $_POST['prenomApprenant'];
                $mailApprenant = $_POST['mailApprenant'];
                $adresseApprenant = $_POST['adresseApprenant'];
                $villeApprenant = $_POST['villeApprenant'];
                $cpApprenant = $_POST['cpApprenant'];
                $numApprenant = $_POST['numApprenant'];

                // Mettez à jour la base de données
                $sqlUpdateApprenant = "UPDATE apprenants SET nom_apprenant = :nomApprenant, prenom_apprenant = :prenomApprenant, mail_apprenant = :mailApprenant, adresse_apprenant = :adresseApprenant, ville_apprenant = :villeApprenant, code_postal_apprenant = :cpApprenant, tel_apprenant = :numApprenant WHERE id_apprenant = :idApprenant";
                $stmtUpdateApprenant = $bdd->prepare($sqlUpdateApprenant);
                $stmtUpdateApprenant->execute([
                    ':nomApprenant' => $nomApprenant,
                    ':prenomApprenant' => $prenomApprenant,
                    ':mailApprenant' => $mailApprenant,
                    ':adresseApprenant' => $adresseApprenant,
                    ':villeApprenant' => $villeApprenant,
                    ':cpApprenant' => $cpApprenant,       
                    ':numApprenant' => $numApprenant,
                    ':idApprenant' => $idApprenant
                ]);
            
                echo "Informations de l'apprenant mises à jour avec succès.";
            }

            // Suppression de données
            if (isset($_GET['deleteApprenant'])) {
                $idApprenant = $_GET['deleteApprenant'];
                $sqlDelete = "DELETE FROM apprenants WHERE id_apprenant = :idApprenant"; 
                $stmtDelete = $bdd->prepare($sqlDelete);
                $stmtDelete->bindParam(':idApprenant', $idApprenant);
                $stmtDelete->execute();

                echo "Apprenant supprimer";
            }


            // Traitement de l'ajout d'un apprenant
            if (isset($_POST['submitApprenant'])) {
                $nomApprenant = $_POST['nomApprenant'];
                $prenomApprenant = $_POST['prenomApprenant'];
                $mailApprenant = $_POST['mailApprenant'];
                $idRole = $_POST['idRoleAp'];
                $idSession = $_POST['idSession'];

                $sqlInsert = "INSERT INTO apprenants (nom_apprenant, prenom_apprenant, mail_apprenant, adresse_apprenant, ville_apprenant, code_postal_apprenant, tel_apprenant, date_naissance_apprenant, niveau_apprenant, num_PE_apprenant, num_secu_apprenant, rib_apprenant, id_role, id_session) 
                            VALUES (:nomApprenant, :prenomApprenant, :mailApprenant, :adresseApprenant, :villeApprenant, :cpApprenant, :telApprenant, :naissanceApprenant, :nivApprenant, :peApprenant, :secuApprenant, :ribApprenant, :idRole, :idSession)";
                $stmtInsert = $bdd->prepare($sqlInsert);
                $stmtInsert->execute([
                    ':nomApprenant' => $nomApprenant,
                    ':prenomApprenant' => $prenomApprenant,
                    ':mailApprenant' => $mailApprenant,
                    ':adresseApprenant' => $_POST['adresseApprenant'],
                    ':villeApprenant' => $_POST['villeApprenant'],
                    ':cpApprenant' => $_POST['cpApprenant'],
                    ':telApprenant' => $_POST['telApprenant'],
                    ':naissanceApprenant' => $_POST['naissanceApprenant'],
                    ':nivApprenant' => $_POST['nivApprenant'],
                    ':peApprenant' => $_POST['peApprenant'],
                    ':secuApprenant' => $_POST['secuApprenant'],
                    ':ribApprenant' => $_POST['ribApprenant'],
                    ':idRole' => $idRole,
                    ':idSession' => $idSession
                ]);

                echo "<p>Apprenant ajouté avec succès.</p>";
            }

?>