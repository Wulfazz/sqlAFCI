<?php

    // Récupération des informations pour les menus déroulants
    include("function.php");
    $centres = selectAll("centres");
    $pedagogies = selectAll("pedagogie");

    // Affichage des affectations existantes
    $sqlAffecter = "SELECT a.id_centre, a.id_pedagogie, c.ville_centre, p.nom_pedagogie 
                    FROM affecter a
                    JOIN centres c ON a.id_centre = c.id_centre
                    JOIN pedagogie p ON a.id_pedagogie = p.id_pedagogie";
    $affectations = $bdd->query($sqlAffecter)->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="centerDiv">

    <form method="POST">
        <h1>Ajout d'affectation</h1>
        <label>Centre :</label>
        <select name="idCentre">

            <?php foreach ($centres as $centre) {
                echo "<option value='".htmlspecialchars($centre['id_centre'])."'>".htmlspecialchars($centre['ville_centre'])."</option>";
            } ?>

        </select>
        <br>
        <label>Équipe pédagogique :</label>
        <select name="idPedagogie">

            <?php foreach ($pedagogies as $pedagogie) {
                echo "<option value='".htmlspecialchars($pedagogie['id_pedagogie'])."'>".htmlspecialchars($pedagogie['nom_pedagogie'])."</option>";
            } ?>

        </select>
        <br>
        <input type="submit" name="submitAffecter" value="Enregistrer">
    </form>

    <table border="1">

        <tr>
            <th>Centre</th>
            <th>Équipe pédagogique</th>
            <th>Modifier</th>
            <th>Actions</th>
        </tr>

        <?php foreach ($affectations as $affectation) { 
            echo '<tr>';
            echo '<td>' . htmlspecialchars($affectation['ville_centre']) . '</td>';
            echo '<td>' . htmlspecialchars($affectation['nom_pedagogie']) . '</td>';
            echo '<td><a href="?page=affecter&action=edit&idCentre=' . htmlspecialchars($affectation['id_centre']) . '&idPedagogie=' . htmlspecialchars($affectation['id_pedagogie']) . '"><button>Modifier</button></a></td>';
            echo '<td><a href="?page=affecter&delete&idCentre=' . htmlspecialchars($affectation['id_centre']) . '&idPedagogie=' . htmlspecialchars($affectation['id_pedagogie']) . '" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer cette affectation ?\');"><button>Supprimer</button></a></td>';
            echo '</tr>';
         } 
         ?>

    </table>

</div>

<?php
    // Traitement de l'ajout d'une nouvelle affectation
    if (isset($_POST['submitAffecter'])) {

        $sqlInsert = "INSERT INTO affecter (id_centre, id_pedagogie) VALUES (:idCentre, :idPedagogie)";
        $stmtInsert = $bdd->prepare($sqlInsert);

        $stmtInsert->bindParam(':idCentre', $_POST['idCentre']);
        $stmtInsert->bindParam(':idPedagogie', $_POST['idPedagogie']);
        $stmtInsert->execute();

        echo "Affectation ajoutée avec succès";
    }

    if (isset($_GET['delete'], $_GET['idCentre'], $_GET['idPedagogie'])) {
        $idCentre = $_GET['idCentre'];
        $idPedagogie = $_GET['idPedagogie'];

        $sqlDelete = "DELETE FROM affecter WHERE id_centre = :idCentre AND id_pedagogie = :idPedagogie";
        $stmtDelete = $bdd->prepare($sqlDelete);
       
        $stmtDelete->bindParam(':idCentre', $idCentre);
        $stmtDelete->bindParam(':idPedagogie', $idPedagogie);
        $stmtDelete->execute();
    }


    if (isset($_GET['action'], $_GET['idCentre'], $_GET['idPedagogie']) && $_GET['action'] == 'edit') {
        // Vous pouvez ajuster la requête SQL selon votre schéma de base de données
    
        // Affichez le formulaire de modification
        echo "<form method='POST'>";
        echo "<input type='hidden' name='action' value='updateAffectation'>";
    
        // Sélectionner le centre actuel
        echo "<select name='idCentre'>";

        foreach ($centres as $centre) {

            $selected = ($centre['id_centre'] == $_GET['idCentre']) ? "selected" : "";
            echo "<option value='".htmlspecialchars($centre['id_centre'])."' ".htmlspecialchars($selected).">".htmlspecialchars($centre['ville_centre'])."</option>";
        }

        echo "</select>";
    
        // Sélectionner l'équipe pédagogique actuelle
        echo "<select name='idPedagogie'>";

        foreach ($pedagogies as $pedagogie) {
            $selected = ($pedagogie['id_pedagogie'] == $_GET['idPedagogie']) ? "selected" : "";
            echo "<option value='".htmlspecialchars($pedagogie['id_pedagogie'])."' ".htmlspecialchars($selected).">".htmlspecialchars($pedagogie['nom_pedagogie'])."</option>";
        }

        echo "</select>";
    
        echo "<input type='submit' value='Mettre à jour'>";
        echo "</form>";
    }

    if (isset($_POST['action']) && $_POST['action'] == 'updateAffectation') {
        $newIdCentre = $_POST['idCentre'];
        $newIdPedagogie = $_POST['idPedagogie'];
        $oldIdCentre = $_GET['idCentre'];
        $oldIdPedagogie = $_GET['idPedagogie'];
    
        // Effectuez la mise à jour
        $sqlUpdate = "UPDATE affecter SET id_centre = :newIdCentre, id_pedagogie = :newIdPedagogie WHERE id_centre = :oldIdCentre AND id_pedagogie = :oldIdPedagogie";
        $stmtUpdate = $bdd->prepare($sqlUpdate);

        $stmtUpdate->bindParam(':newIdCentre', $newIdCentre);
        $stmtUpdate->bindParam(':newIdPedagogie', $newIdPedagogie);
        $stmtUpdate->bindParam(':oldIdCentre', $oldIdCentre);
        $stmtUpdate->bindParam(':oldIdPedagogie', $oldIdPedagogie);
        $stmtUpdate->execute();
    
        echo "Mise à jour effectuée avec succès";
    }

?>