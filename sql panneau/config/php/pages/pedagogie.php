<?php

        $sqlRole = "SELECT * FROM role";
        $requeteRole = $bdd->query($sqlRole);
        $resultsRole = $requeteRole->fetchAll(PDO::FETCH_ASSOC);

        $sqlPedagogie = "SELECT * FROM pedagogie";
        $requetePedagogie = $bdd->prepare($sqlPedagogie);
        $requetePedagogie->execute();
        $resultsPedagogie = $requetePedagogie->fetchAll(PDO::FETCH_ASSOC);

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
                        echo '<option value="' . ($role['id_role']) . '">' . ($role['nom_role']) . '</option>';
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
                    echo '<td>' . ($pedagogie['nom_pedagogie']) . '</td>';
                    echo '<td>' . ($pedagogie['prenom_pedagogie']) . '</td>';
                    echo '<td>' . ($pedagogie['mail_pedagogie']) . '</td>';
                    echo '<td>' . ($pedagogie['num_pedagogie']) . '</td>';
                    echo '<td>' . ($pedagogie['id_role']) . '</td>'; 
                    echo '<td><a href="?page=pedagogie&type=modifier&id=' . ($pedagogie['id_pedagogie']) . '"><button>Modifier</button></a></td>';
                    echo '<td><a href="?page=pedagogie&deletePedagogie=' . ($pedagogie['id_pedagogie']) . '" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer ce membre ?\');"><button>Supprimer</button></a></td>';
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
                            <input type="hidden" name="updateIdPedagogie" value="<?php echo ($resultsId['id_pedagogie']); ?>">
                            <input type="text" name="updateNomPedagogie" value="<?php echo ($resultsId['nom_pedagogie']); ?>">
                            <input type="text" name="updatePrenomPedagogie" value="<?php echo ($resultsId['prenom_pedagogie']); ?>">
                            <input type="text" name="updateMailPedagogie" value="<?php echo ($resultsId['mail_pedagogie']); ?>">
                            <input type="text" name="updateNumPedagogie" value="<?php echo ($resultsId['num_pedagogie']); ?>">
                            <input type="submit" name="updatePedagogie" value="Mise à jour">
                        </form>
                        <?php
                    }
            }

            if (isset($_POST["updatePedagogie"])){
                //valider et changer les données dans la bdd avec le bouton "modifier"
                $updateIdPedagogie = $_POST["updateIdPedagogie"];
                $updateNomPedagogie = $_POST["updateNomPedagogie"];
                $updatePrenomPedagogie = $_POST["updatePrenomPedagogie"];
                $updateMailPedagogie = $_POST["updateMailPedagogie"];
                $updateNumPedagogie = $_POST["updateNumPedagogie"];
    
                $sqlUpdate = "UPDATE pedagogie SET nom_pedagogie = :nomPedagogie, prenom_pedagogie = :prenomPedagogie, mail_pedagogie = :mailPedagogie, num_pedagogie = :numPedagogie  WHERE id_pedagogie = :idPedagogie";
                $stmtUpdate = $bdd->prepare($sqlUpdate);
                
                $stmtUpdate->bindParam(':nomPedagogie', $updateNomPedagogie);
                $stmtUpdate->bindParam(':prenomPedagogie', $updatePrenomPedagogie);
                $stmtUpdate->bindParam(':mailPedagogie', $updateMailPedagogie);
                $stmtUpdate->bindParam(':numPedagogie', $updateNumPedagogie);
                $stmtUpdate->bindParam(':idPedagogie', $updateIdPedagogie);
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
            $nomPedagogie = $_POST['nomPedagogie'];
            $prenomPedagogie = $_POST['prenomPedagogie'];
            $mailPedagogie = $_POST['mailPedagogie'];
            $numPedagogie = $_POST['numPedagogie'];
            $idRole = $_POST['idRole'];

            $sqlInsert = "INSERT INTO pedagogie (nom_pedagogie, prenom_pedagogie, mail_pedagogie, num_pedagogie, id_role) VALUES (:nomPedagogie, :prenomPedagogie, :mailPedagogie, :numPedagogie, :idRole)";
            $stmtInsert = $bdd->prepare($sqlInsert);

            $stmtInsert->bindParam(':nomPedagogie', $nomPedagogie);
            $stmtInsert->bindParam(':prenomPedagogie', $prenomPedagogie);
            $stmtInsert->bindParam(':mailPedagogie', $mailPedagogie);
            $stmtInsert->bindParam(':numPedagogie', $numPedagogie);
            $stmtInsert->bindParam(':idRole', $idRole);
            $stmtInsert->execute();

            echo "Membre d'équipe ajouté avec succès";
        }

?>