<?php

        $sqlFormation = "SELECT * FROM formations";
        $requeteFormation = $bdd->query($sqlFormation);
        $resultsFormation = $requeteFormation->fetchAll(PDO::FETCH_ASSOC);
        
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
                    echo '<td>' . ($formations['nom_formation']) . '</td>';
                    echo '<td>' . ($formations['duree_formation']) . '</td>';
                    echo '<td>' . ($formations['niveau_sortie_formation']) . '</td>';
                    echo '<td>' . ($formations['description']) . '</td>';
                    echo '<td><a href="?page=formation&type=modifier&id=' . ($formations['id_formation']) . '"><button>Modifier</button></a></td>';
                    echo '<td><a href="?page=formation&deleteFormation=' . ($formations['id_formation']) . '" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer cette formation ?\');"><button>Supprimer</button></a></td>';
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
                        <input type="hidden" name="updateIdFormation" value="<?php echo ($resultsId['id_formation']); ?>">
                        <input type="text" name="updateNomFormation" value="<?php echo ($resultsId['nom_formation']); ?>">
                        <input type="text" name="updateDureeFormation" value="<?php echo ($resultsId['duree_formation']); ?>">
                        <input type="text" name="updateNiveauFormation" value="<?php echo ($resultsId['niveau_sortie_formation']); ?>">
                        <input type="text" name="updateDescriptionFormation" value="<?php echo ($resultsId['description']); ?>">
                        <input type="submit" name="updateFormation" value="Mise à jour">
                    </form>
                    <?php
                }
        }

        if (isset($_POST["updateFormation"])){
            //valider et changer les données dans la bdd avec le bouton "modifier"
            $updateIdFormation = $_POST["updateIdFormation"];
            $updateNomFormation = $_POST["updateNomFormation"];
            $updateDureeFormation = $_POST["updateDureeFormation"];
            $updateNiveauFormation = $_POST["updateNiveauFormation"];
            $updateDescriptionFormation = $_POST["updateDescriptionFormation"];

            $sqlUpdate = "UPDATE formations SET nom_formation = :nomFormation, duree_formation = :dureeFormation, niveau_sortie_formation = :niveauFormation, `description` = :descFormation  WHERE id_formation = :idFormation";
            $stmtUpdate = $bdd->prepare($sqlUpdate);
            $stmtUpdate->bindParam(':nomFormation', $updateNomFormation);
            $stmtUpdate->bindParam(':dureeFormation', $updateDureeFormation);
            $stmtUpdate->bindParam(':niveauFormation', $updateNiveauFormation);
            $stmtUpdate->bindParam(':descFormation', $updateDescriptionFormation);
            $stmtUpdate->bindParam(':idFormation', $updateIdFormation);
            $stmtUpdate->execute();
        
            echo "Données modifiées";
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
            $nomFormation = $_POST['nomFormation'];
            $dureeFormation = $_POST['dureeFormation'];
            $niveauFormation = $_POST['niveauFormation'];
            $descFormation = $_POST['descFormation'];

            $sql = "INSERT INTO `formations`(`nom_formation`, `duree_formation`, `niveau_sortie_formation`, `description`) 
            VALUES ('$nomFormation','$dureeFormation','$niveauFormation','$descFormation')";
            $bdd->query($sql);

            echo "data ajoutée dans la bdd";
        }

?>