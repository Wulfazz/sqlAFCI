<?php

    include("function.php");
    $resultsRole = selectAll("role");
    $resultsPedagogie = selectAll("pedagogie");

?>

<!-- Tableau -->
<div class="centerDiv">

    <!-- Partie d'ajout de données -->
    <form method="POST">
        <h1>Ajout d'un membre d'équipe</h1>
        <label>Nom :</label>
        <input type="text" name="nomPedagogie">
        <br>
        <label>Prénom :</label>
        <input type="text" name="prenomPedagogie">
        <br>
        <label>Mail :</label>
        <input type="text" name="mailPedagogie">
        <br>
        <label>Téléphone :</label>
        <input type="text" name="numPedagogie">
        <br>
        <label>Role :</label>
        <select name="idRole" id="">
            <?php
            foreach($resultsRole as $role) {             
                echo '<option value="' . htmlspecialchars($role['id_role']) . '">' . htmlspecialchars($role['nom_role']) . '</option>';
            }
            ?>
        </select>
        <input type="submit" name="submitPedagogie" value="Enregistrer">
    </form>

    <table border="1">

        <tr>
            <!-- Noms des colonnes -->
            <th>Nom :</th>
            <th>Prénom :</th>
            <th>Mail :</th>
            <th>Téléphone :</th>
            <th>Role :</th>
            <th>Modifier :</th>
            <th>Action :</th>
        </tr>

        <?php
        //Données à entrer dans le tableau par bdd
        foreach($resultsPedagogie as $pedagogie){
            echo '<tr>';
            echo '<td>' . htmlspecialchars($pedagogie['nom_pedagogie']) . '</td>';
            echo '<td>' . htmlspecialchars($pedagogie['prenom_pedagogie']) . '</td>';
            echo '<td>' . htmlspecialchars($pedagogie['mail_pedagogie']) . '</td>';
            echo '<td>' . htmlspecialchars($pedagogie['num_pedagogie']) . '</td>';
            echo '<td>' . htmlspecialchars($pedagogie['id_role']) . '</td>';
            echo '<td><a href="?page=pedagogie&type=modifier&id=' . htmlspecialchars($pedagogie['id_pedagogie']) . '"><button>Modifier</button></a></td>';
            echo '<td><a href="?page=pedagogie&deletePedagogie=' . htmlspecialchars($pedagogie['id_pedagogie']) . '" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer ce membre ?\');"><button>Supprimer</button></a></td>';
            echo '</tr>';
        }
        ?>

    </table>

</div>

<?php

    // Si URL de type = modifier (true) avec ID :
    if(isset($_GET['type']) && $_GET['type'] == "modifier") {
        $id = $_GET["id"];
        $sqlId = "SELECT * FROM pedagogie WHERE id_pedagogie = :id";
        $requeteId = $bdd->prepare($sqlId);
        $requeteId->bindParam(':id', $id);
        $requeteId->execute();
        $resultsId = $requeteId->fetch(PDO::FETCH_ASSOC);

            //Formulaire de modification
            if ($resultsId){
                ?>
                <form method="POST">
                    <input type="hidden" name="updateIdPedagogie" value="<?php echo htmlspecialchars($resultsId['id_pedagogie']); ?>">
                    <input type="text" name="updateNomPedagogie" value="<?php echo htmlspecialchars($resultsId['nom_pedagogie']); ?>">
                    <input type="text" name="updatePrenomPedagogie" value="<?php echo htmlspecialchars($resultsId['prenom_pedagogie']); ?>">
                    <input type="text" name="updateMailPedagogie" value="<?php echo htmlspecialchars($resultsId['mail_pedagogie']); ?>">
                    <input type="text" name="updateNumPedagogie" value="<?php echo htmlspecialchars($resultsId['num_pedagogie']); ?>">
                    <input type="submit" name="updatePedagogie" value="Mise à jour">
                </form>
                <?php
            }
            
    }
    if (isset($_POST["updatePedagogie"])){
        
        //valider et changer les données dans la bdd avec le bouton "modifier"
        $sqlUpdate = "UPDATE pedagogie SET nom_pedagogie = :nomPedagogie, prenom_pedagogie = :prenomPedagogie, mail_pedagogie = :mailPedagogie, num_pedagogie = :numPedagogie  WHERE id_pedagogie = :idPedagogie";
        $stmtUpdate = $bdd->prepare($sqlUpdate);
        
        $stmtUpdate->bindParam(':nomPedagogie', $_POST["updateNomPedagogie"]);
        $stmtUpdate->bindParam(':prenomPedagogie', $_POST["updatePrenomPedagogie"]);
        $stmtUpdate->bindParam(':mailPedagogie', $_POST["updateMailPedagogie"]);
        $stmtUpdate->bindParam(':numPedagogie', $_POST["updateNumPedagogie"]);
        $stmtUpdate->bindParam(':idPedagogie', $_POST["updateIdPedagogie"]);
        $stmtUpdate->execute();
    
        echo "Données modifiées";
    }
    
    // Suppression de données avec bouton "supprimer"
    if(isset($_GET['deletePedagogie'])) {

        $idPedagogie = $_GET['deletePedagogie'];
        $sqlDelete = "DELETE FROM pedagogie WHERE id_pedagogie = :idPedagogie";
        $stmtDelete = $bdd->prepare($sqlDelete);
        $stmtDelete->bindParam(':idPedagogie', $idPedagogie);
        $stmtDelete->execute();

        echo "Membre supprimé";

    }
    
    // Ajout de données avec bouton "ajouter"
    if (isset($_POST['submitPedagogie'])) {

        $sqlInsert = "INSERT INTO pedagogie (nom_pedagogie, prenom_pedagogie, mail_pedagogie, num_pedagogie, id_role) VALUES (:nomPedagogie, :prenomPedagogie, :mailPedagogie, :numPedagogie, :idRole)";
        $stmtInsert = $bdd->prepare($sqlInsert);

        $stmtInsert->bindParam(':nomPedagogie', $_POST['nomPedagogie']);
        $stmtInsert->bindParam(':prenomPedagogie', $_POST['prenomPedagogie']);
        $stmtInsert->bindParam(':mailPedagogie', $_POST['mailPedagogie']);
        $stmtInsert->bindParam(':numPedagogie', $_POST['numPedagogie']);
        $stmtInsert->bindParam(':idRole', $_POST['idRole']);
        $stmtInsert->execute();

        echo "Membre d'équipe ajouté avec succès";
    }
    
?>