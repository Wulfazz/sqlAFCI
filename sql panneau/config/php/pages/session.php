<?php

    include("function.php");
    $resultsPedagogie = selectAll("pedagogie");
    $resultsFormations = selectAll("formations");
    $resultsCentres = selectAll("centres");

    // Récupération des sessions
    $sqlSessions = "SELECT s.id_session, s.date_debut, s.nom_session, c.ville_centre, f.nom_formation, p.nom_pedagogie 
                    FROM session s
                    LEFT JOIN centres c ON s.id_centre = c.id_centre
                    LEFT JOIN formations f ON s.id_formation = f.id_formation
                    LEFT JOIN pedagogie p ON s.id_pedagogie = p.id_pedagogie";
    $stmtSessions = $bdd->prepare($sqlSessions);
    $stmtSessions->execute();
    $sessions = $stmtSessions->fetchAll(PDO::FETCH_ASSOC);

?>

<!-- Tableau -->
<div class="centerDiv">

    <!-- Partie d'ajout de données -->
    <form method="POST">
        <h1>Ajout de session</h1>
        <label>Date de début :</label>
        <input type="text" name="dateDebut">
        <br>
        <label>Nom de session :</label>
        <input type="text" name="nomSession">
        <br>
        <label>Formateur</label>            
        <select name="idPedagogie" id="">
            
            <?php
            foreach ($resultsPedagogie as $value) {             
                echo '<option value="' . htmlspecialchars($value['id_pedagogie']) . '">' . htmlspecialchars($value['nom_pedagogie']) . '</option>';
            }
            ?>

        </select>
        <br>
        <label>Formation :</label>
        <select name="idFormation" id="">

            <?php
            foreach ($resultsFormations as $value) {             
                echo '<option value="' . htmlspecialchars($value['id_formation']) . '">' . htmlspecialchars($value['nom_formation']) . '</option>';
            }
            ?>

        </select>
        <br>
        <label>Centre :</label>
        <select name="idCentre" id="">

            <?php
            foreach ($resultsCentres as $value) {             
                echo '<option value="' . htmlspecialchars($value['id_centre']) . '">' . htmlspecialchars($value['ville_centre']) . '</option>';
            }
            ?>

        </select>
        <br>
        <input type="submit" name="submitSession" value="Enregistrer">
    </form>

    <table border="1">

        <tr>
            <!-- Noms des colonnes -->
            <th>Date de début :</th>
            <th>Num de session</th>
            <th>Nom de formation :</th>
            <th>Centre :</th>
            <th>Nom formateur :</th>
            <th>Modifier :</th>
            <th>Action :</th>
        </tr>

        <?php
        //Données à entrer dans le tableau par bdd
        foreach($sessions as $session){
            echo '<tr>';
            echo '<td>' . htmlspecialchars($session['date_debut']) . '</td>';
            echo '<td>' . htmlspecialchars($session['nom_session']) . '</td>';
            echo '<td>' . htmlspecialchars($session['nom_formation']) . '</td>';
            echo '<td>' . htmlspecialchars($session['ville_centre']) . '</td>';
            echo '<td>' . htmlspecialchars($session['nom_pedagogie']) . '</td>';
            echo '<td><a href="?page=session&type=modifier&id=' . htmlspecialchars($session['id_session']) . '"><button>Modifier</button></a></td>';
            echo '<td><a href="?page=session&deleteSession=' . htmlspecialchars($session['id_session']) . '" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer cette session ?\');"><button>Supprimer</button></a></td>';
            echo '</tr>';
        }
        ?>

    </table>

</div>

<?php

    // Si URL de type = modifier (true) avec ID :
    if (isset($_GET['type']) && $_GET['type'] == "modifier" && !empty($_GET["id"])) {
        $id = $_GET["id"];
        $sqlId = "SELECT * FROM session WHERE id_session = :id";
        $requeteId = $bdd->prepare($sqlId);
        $requeteId->bindParam(':id', $id);
        $requeteId->execute();
        $sessionDetails = $requeteId->fetch(PDO::FETCH_ASSOC);
    
        if ($sessionDetails) {
            // Formulaire de modification
            ?>
            <form method="POST">
                <input type="hidden" name="sessionId" value="<?php echo htmlspecialchars($sessionDetails['id_session']); ?>">
                <label>Date de début :</label>
                <input type="text" name="updateDateDebut" value="<?php echo htmlspecialchars($sessionDetails['date_debut']); ?>">
                <br>
                <label>Nom de session :</label>
                <input type="text" name="updateNomSession" value="<?php echo htmlspecialchars($sessionDetails['nom_session']); ?>">
                <br>
                <label>Formation :</label>
                <select name="updateIdFormation">
                    <?php foreach ($resultsFormations as $formation) {
                        $selected = $sessionDetails['id_formation'] == $formation['id_formation'] ? 'selected' : '';
                        echo "<option value='{$formation['id_formation']}' {$selected}>{$formation['nom_formation']}</option>";
                    } ?>
                </select>
                <br>
                <label>Centre :</label>
                <select name="updateIdCentre">
                    <?php foreach ($resultsCentres as $centre) {
                        $selected = $sessionDetails['id_centre'] == $centre['id_centre'] ? 'selected' : '';
                        echo "<option value='{$centre['id_centre']}' {$selected}>{$centre['ville_centre']}</option>";
                    } ?>
                </select>
                <br>
                <label>Formateur :</label>
                <select name="updateIdPedagogie">
                    <?php foreach ($resultsPedagogie as $formateur) {
                        $selected = $sessionDetails['id_pedagogie'] == $formateur['id_pedagogie'] ? 'selected' : '';
                        echo "<option value='{$formateur['id_pedagogie']}' {$selected}>{$formateur['nom_pedagogie']}</option>";
                    } ?>
                </select>
                <br>
                <input type="submit" name="updateSession" value="Mettre à jour">
            </form>
            <?php
        }
    }

    // Traitement de la mise à jour
    if (isset($_POST['updateSession'])) {

        // First, get the old values before the update
        $sqlGetOldValues = "SELECT id_formation, id_centre FROM session WHERE id_session = :idSession";
        $stmtGetOldValues = $bdd->prepare($sqlGetOldValues);
        $stmtGetOldValues->bindParam(':idSession', $sessionId);
        $stmtGetOldValues->execute();
        $oldValues = $stmtGetOldValues->fetch(PDO::FETCH_ASSOC);
        if ($oldValues) {

            // Now update the session table
            $sqlUpdateSession = "UPDATE session SET date_debut = :dateDebut, nom_session = :nomSession, id_formation = :idFormation, id_centre = :idCentre, id_pedagogie = :idPedagogie WHERE id_session = :idSession";
            $stmtUpdateSession = $bdd->prepare($sqlUpdateSession);

            $stmtUpdateSession->bindParam(':dateDebut', $_POST['updateDateDebut']);
            $stmtUpdateSession->bindParam(':nomSession', $_POST['updateNomSession']);
            $stmtUpdateSession->bindParam(':idFormation', $_POST['updateIdFormation']);
            $stmtUpdateSession->bindParam(':idCentre', $_POST['updateIdCentre']);
            $stmtUpdateSession->bindParam(':idPedagogie', $_POST['updateIdPedagogie']);
            $stmtUpdateSession->bindParam(':idSession', $_POST['sessionId']);
            $stmtUpdateSession->execute();

            // Update the localiser table using the old values
            $sqlUpdateLocaliser = "UPDATE localiser SET id_formation = :newIdFormation, id_centre = :newIdCentre WHERE id_formation = :oldIdFormation AND id_centre = :oldIdCentre";
            $stmtUpdateLocaliser = $bdd->prepare($sqlUpdateLocaliser);

            $stmtUpdateLocaliser->bindParam(':newIdFormation', $updateIdFormation);
            $stmtUpdateLocaliser->bindParam(':newIdCentre', $updateIdCentre);
            $stmtUpdateLocaliser->bindParam(':oldIdFormation', $oldValues['id_formation']);
            $stmtUpdateLocaliser->bindParam(':oldIdCentre', $oldValues['id_centre']);
            $stmtUpdateLocaliser->execute();

            echo "Session et localisation mises à jour avec succès.";
        }
    }

    // Suppression de données avec bouton "supprimer"
    if (isset($_GET['deleteSession'])) {
        $idSession = $_GET['deleteSession'];
        // D'abord, récupérer les informations de la session pour mettre à jour la table localiser
        $sqlGetSessionInfo = "SELECT id_formation, id_centre FROM session WHERE id_session = :idSession";
        $stmtGetSessionInfo = $bdd->prepare($sqlGetSessionInfo);
        $stmtGetSessionInfo->bindParam(':idSession', $idSession);
        $stmtGetSessionInfo->execute();
        $sessionInfo = $stmtGetSessionInfo->fetch(PDO::FETCH_ASSOC);
        if ($sessionInfo) {

            // Suppression de l'entrée dans la table localiser
            $sqlDeleteLocaliser = "DELETE FROM localiser WHERE id_formation = :idFormation AND id_centre = :idCentre";
            $stmtDeleteLocaliser = $bdd->prepare($sqlDeleteLocaliser);
            $stmtDeleteLocaliser->bindParam(':idFormation', $sessionInfo['id_formation']);
            $stmtDeleteLocaliser->bindParam(':idCentre', $sessionInfo['id_centre']);
            $stmtDeleteLocaliser->execute();
        }

        // Ensuite supprimer la session elle-même
        $sqlDeleteSession = "DELETE FROM session WHERE id_session = :idSession";
        $stmtDeleteSession = $bdd->prepare($sqlDeleteSession);
        $stmtDeleteSession->bindParam(':idSession', $idSession);
        $stmtDeleteSession->execute();

        echo "Session et localisation supprimées avec succès.";
    }

    // Ajout de données avec bouton "ajouter"
    if (isset($_POST['submitSession'])) {

        // Insertion dans la table session
        $sqlInsertSession = "INSERT INTO session (date_debut, nom_session, id_formation, id_centre, id_pedagogie) VALUES (:dateDebut, :nomSession, :idFormation, :idCentre, :idPedagogie)";
        $stmtInsertSession = $bdd->prepare($sqlInsertSession);
        $stmtInsertSession->bindParam(':dateDebut', $_POST['dateDebut']);
        $stmtInsertSession->bindParam(':nomSession', $_POST['nomSession']);
        $stmtInsertSession->bindParam(':idFormation', $_POST['idFormation']);
        $stmtInsertSession->bindParam(':idCentre', $_POST['idCentre']);
        $stmtInsertSession->bindParam(':idPedagogie', $_POST['idPedagogie']);
        if ($stmtInsertSession->execute()) {

            // Insertion dans la table localiser
            $sqlInsertLocaliser = "INSERT INTO localiser (id_formation, id_centre) VALUES (:idFormation, :idCentre)";
            $stmtInsertLocaliser = $bdd->prepare($sqlInsertLocaliser);
            $stmtInsertLocaliser->bindParam(':idFormation', $idFormation);
            $stmtInsertLocaliser->bindParam(':idCentre', $idCentre);
            $stmtInsertLocaliser->execute();

        echo "Session et localisation ajoutées avec succès.";
        }
    }

?>
