<?php

    include("function.php");
    $resultsFormation = selectAll("formations");
        
?>

<!-- Tableau -->
<div class="centerDiv">

    <!-- Partie d'ajout de données -->
    <form method="POST">
        <h1>Ajout de Formation</h1>
        <label>Nom de la formation :</label>
        <input type="text" name="nomFormation">
        <br>
        <label>Durée de formation :</label>
        <input type="text" name="dureeFormation">
        <br>
        <label>Niveau à la sortie de formation :</label>
        <input type="text" name="niveauFormation">
        <br>
        <label>Description :</label>
        <input type="text" name="descFormation">
        <br>
        <input type="submit" name="submitFormation" value="Enregistrer">
    </form>

    <table border="1">

        <tr>
            <!-- Noms de colonnes -->
            <th>Nom formation :</th>
            <th>Durée formation :</th>
            <th>Niveau de sortie :</th>
            <th>Description :</th>
            <th>Actions</th>
        </tr>

        <?php
        //Données à entrer dans le tableau par la base de données
        foreach($resultsFormation as $formations){
            echo '<tr>';
            echo '<td>' . htmlspecialchars($formations['nom_formation']) . '</td>';
            echo '<td>' . htmlspecialchars($formations['duree_formation']) . '</td>';
            echo '<td>' . htmlspecialchars($formations['niveau_sortie_formation']) . '</td>';
            echo '<td>' . htmlspecialchars($formations['description']) . '</td>';
            echo '<td><a href="?page=formation&type=modifier&id=' . htmlspecialchars($formations['id_formation']) . '"><button>Modifier</button></a></td>';
            echo '<td><a href="?page=formation&deleteFormation=' . htmlspecialchars($formations['id_formation']) . '" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer cette formation ?\');"><button>Supprimer</button></a></td>';
            echo '</tr>';
        }
        ?>

    </table>

</div>

<?php
    // Si URL de type = modifier (true) avec ID :
    if(isset($_GET['type']) && $_GET['type'] == "modifier"){
        $id = $_GET["id"];
        $sqlId = "SELECT * FROM formations WHERE id_formation = :id";
        $requeteId = $bdd->prepare($sqlId);
        $requeteId->bindParam(':id', $id);
        $requeteId->execute();
        $resultsId = $requeteId->fetch(PDO::FETCH_ASSOC);
            //Formulaire de modification
            if ($resultsId){
                ?>
                <form method="POST">
                    <input type="hidden" name="updateIdFormation" value="<?php echo htmlspecialchars($resultsId['id_formation']); ?>">
                    <input type="text" name="updateNomFormation" value="<?php echo htmlspecialchars($resultsId['nom_formation']); ?>">
                    <input type="text" name="updateDureeFormation" value="<?php echo htmlspecialchars($resultsId['duree_formation']); ?>">
                    <input type="text" name="updateNiveauFormation" value="<?php echo htmlspecialchars($resultsId['niveau_sortie_formation']); ?>">
                    <input type="text" name="updateDescriptionFormation" value="<?php echo htmlspecialchars($resultsId['description']); ?>">
                    <input type="submit" name="updateFormation" value="Mise à jour">
                </form>
                <?php
            }
    }

    if (isset($_POST["updateFormation"])){
        //valider et changer les données dans la bdd avec le bouton "modifier"

        $updateDescriptionFormation = $_POST["updateDescriptionFormation"];
        $sqlUpdate = "UPDATE formations SET nom_formation = :nomFormation, duree_formation = :dureeFormation, niveau_sortie_formation = :niveauFormation, `description` = :descFormation  WHERE id_formation = :idFormation";
        $stmtUpdate = $bdd->prepare($sqlUpdate);

        $stmtUpdate->bindParam(':nomFormation', $_POST["updateNomFormation"]);
        $stmtUpdate->bindParam(':dureeFormation', $_POST["updateDureeFormation"]);
        $stmtUpdate->bindParam(':niveauFormation', $_POST["updateNiveauFormation"]);
        $stmtUpdate->bindParam(':descFormation', $_POST["updateDescriptionFormation"]);
        $stmtUpdate->bindParam(':idFormation', $_POST["updateIdFormation"]);
        $stmtUpdate->execute();
    
        echo "Données de formation mises à jour";
    }

    //suppression de données avec bouton "supprimer"
    if (isset($_GET['deleteFormation'])){
        $idFormation = $_GET['deleteFormation'];
        $sql = "DELETE FROM formations WHERE id_formation = :idFormation";
        $stmt = $bdd->prepare($sql);
        $stmt->bindParam('idFormation', $idFormation);
        $stmt->execute();
    }

    //Ajout de données avec bouton "ajouter"
    if (isset($_POST['submitFormation'])){

        $sql = "INSERT INTO formations (nom_formation, duree_formation, niveau_sortie_formation, description) VALUES (:nomFormation, :dureeFormation, :niveauFormation, :descFormation)";
        $stmt = $bdd->prepare($sql);

        $stmt->bindParam(':nomFormation', $_POST['nomFormation']);
        $stmt->bindParam(':dureeFormation', $_POST['dureeFormation']);
        $stmt->bindParam(':niveauFormation', $_POST['niveauFormation']);
        $stmt->bindParam(':descFormation', $_POST['descFormation']);
        $stmt->execute();
        
        echo "Formation ajoutée dans la BDD";
    }
    
?>