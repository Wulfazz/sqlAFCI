<?php

        $sqlCentre = "SELECT * FROM centres";
        $requeteCentre = $bdd->query($sqlCentre);
        $resultsCentre = $requeteCentre->fetchAll(PDO::FETCH_ASSOC);

        ?>

        <!-- Tableau -->
        <div class="centerDiv">

            <!-- Partie d'ajout de données -->
            <form method="POST">
                <h1>Ajout de centre</h1>
                <label>Ville :</label>
                <input type="text" name="villeCentre">
                <br>
                <label>Adresse :</label>
                <input type="text" name="adresseCentre">
                <br>
                <label>Code postal :</label>
                <input type="text" name="cpCentre">
                <br>
                <input type="submit" name="submitCentre" value="Enregistrer">
            </form>

            <table border="1">
                <tr>
                    <!-- Noms des colonnes -->
                    <th>Ville :</th>
                    <th>Adresse :</th>
                    <th>Code postal :</th>
                    <th>Modifier :</th>
                    <th>Action :</th>
                </tr>

                <?php
                //Données à entrer dans le tableau par la base de données
                foreach($resultsCentre as $centres){
                    echo '<tr>';
                    echo '<td>' . ($centres['ville_centre']) . '</td>';
                    echo '<td>' . ($centres['adresse_centre']) . '</td>';
                    echo '<td>' . ($centres['code_postal_centre']) . '</td>';
                    echo '<td><a href="?page=centre&type=modifier&id=' . ($centres['id_centre']) . '"><button>Modifier</button></a></td>';
                    echo '<td><a href="?page=centre&deleteCentre=' . ($centres['id_centre']) . '" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer ce centre ?\');"><button>Supprimer</button></a></td>';
                    echo '</tr>';
                }
                ?>

            </table>

        </div>

        <?php

        // Si URL de type = Modifier (true) avec ID :
        if(isset($_GET['type']) && $_GET['type'] == "modifier"){
            $id = $_GET["id"];
            $sqlId = "SELECT * FROM centres WHERE id_centre = :id";
            $requeteId = $bdd->prepare($sqlId);
            $requeteId->bindParam(':id', $id);
            $requeteId->execute();
            $resultsId = $requeteId->fetch(PDO::FETCH_ASSOC);

            // Formulaire de modification
            if ($resultsId){
                ?>
                <form method="POST">
                    <input type="hidden" name="updateIdCentre" value="<?php echo ($resultsId['id_centre']); ?>">
                    <input type="text" name="updateVilleCentre" value="<?php echo ($resultsId['ville_centre']); ?>">
                    <input type="text" name="updateAdresseCentre" value="<?php echo ($resultsId['adresse_centre']); ?>">
                    <input type="text" name="updateCpCentre" value="<?php echo ($resultsId['code_postal_centre']); ?>">
                    <input type="submit" name="updateCentre" value="Mise à jour">
                </form>
                <?php
            }

        }
        
        if (isset($_POST["updateCentre"])) {
            //valider et changer les données dans la bdd avec le bouton "modifier"
            $updateIdCentre = $_POST["updateIdCentre"];
            $updateVilleCentre = $_POST["updateVilleCentre"];
            $updateAdresseCentre = $_POST["updateAdresseCentre"];
            $updateCpCentre = $_POST["updateCpCentre"];
        
            $sqlUpdate = "UPDATE centres SET ville_centre = :villeCentre, adresse_centre = :adresseCentre, code_postal_centre = :cpCentre WHERE id_centre = :idCentre";
            $stmtUpdate = $bdd->prepare($sqlUpdate);
            $stmtUpdate->bindParam(':villeCentre', $updateVilleCentre);
            $stmtUpdate->bindParam(':adresseCentre', $updateAdresseCentre);
            $stmtUpdate->bindParam(':cpCentre', $updateCpCentre);
            $stmtUpdate->bindParam(':idCentre', $updateIdCentre);
            $stmtUpdate->execute();
        
            echo "Données modifiées";
        }

        // Suppression de données avec bouton "supprimer"
        if (isset($_GET['deleteCentre'])){
            $idCentre = $_GET['deleteCentre'];
            $sql = "DELETE FROM centres WHERE id_centre = :idCentre";
            $stmt = $bdd->prepare($sql);
            $stmt->bindParam(':idCentre', $idCentre);
            $stmt->execute();
        }


        //Ajout de données avec bouton "ajouter"
        if (isset($_POST['submitCentre'])){
            $villeCentre = $_POST['villeCentre'];
            $adresseCentre = $_POST['adresseCentre'];
            $cpCentre = $_POST['cpCentre'];

            $sql = "INSERT INTO `centres`(`ville_centre`, `adresse_centre`, `code_postal_centre`) 
            VALUES ('$villeCentre','$adresseCentre','$cpCentre')";
            $bdd->query($sql);

            echo "data ajoutée dans la bdd";
        }

?>