<?php

        $sqlRole = "SELECT * FROM role";
        $requeteRole = $bdd->query($sqlRole);
        $resultsRole = $requeteRole->fetchAll(PDO::FETCH_ASSOC);
        
        ?>

        <!-- Tableau -->
        <div class="centerDiv">

            <!-- Partie d'ajout de données -->
            <form method="POST">
                <h1>Ajout de rôle</h1>

                <label for="nomRole">Nom de role :</label>
                <input type="text" name="nomRole">
                <input type="submit" name="submitRole" value="Enregistrer">
            </form>

            <table border="1">
                <tr>
                    <!-- Noms des colonnes -->
                    <th>ID :</th>
                    <th>Nom Rôle :</th>
                    <th>Modifier :</th>
                    <th>Action :</th>
                </tr>

                <?php
                // Données à entrer dans le tableau par la base de données
                foreach ($resultsRole as $roles) {
                    echo '<tr>';
                    echo '<td>' . ($roles['id_role']) . '</td>';
                    echo '<td>' . ($roles['nom_role']) . '</td>';
                    echo '<td><a href="?page=role&type=modifier&id=' . ($roles['id_role']) . '"><button>Modifier</button></a></td>';
                    echo '<td><a href="?page=role&deleteRole=' . ($roles['id_role']) . '" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer ce rôle ?\');"><button>Supprimer</button></a></td>';
                    echo '</tr>';
                }
                ?>

            </table>

        </div>

        <?php
    
        // Si URL de Type = Modifier (true) avec ID :
        if (isset($_GET['type']) && $_GET['type'] == "modifier") {
            $id = $_GET["id"];
            $sqlId = "SELECT * FROM role WHERE id_role = :id";
            $requeteId = $bdd->prepare($sqlId);
            $requeteId->bindParam(':id', $id);
            $requeteId->execute();
            $resultsId = $requeteId->fetch(PDO::FETCH_ASSOC);
    
            // Formulaire de modification
            if ($resultsId) {
                ?>
                <form method="POST">
                    <input type="hidden" name="updateIdRole" value="<?php echo ($resultsId['id_role']); ?>">
                    <input type="text" name="updateNomRole" value="<?php echo ($resultsId['nom_role']); ?>">
                    <input type="submit" name="updateRole" value="Mise à jour">
                </form>
                <?php
            }
        }
    
        if (isset($_POST["updateRole"])) {
            // Valider et changer les données dans la base de données avec le bouton "modifier"
            $updateIdRole = $_POST["updateIdRole"];
            $updateNomRole = $_POST["updateNomRole"];
    
            $sqlUpdate = "UPDATE role SET nom_role = :nomRole WHERE id_role = :idRole";
            $stmtUpdate = $bdd->prepare($sqlUpdate);
            $stmtUpdate->bindParam(':nomRole', $updateNomRole);
            $stmtUpdate->bindParam(':idRole', $updateIdRole);
            $stmtUpdate->execute();
    
            echo "Données modifiées";
        }
    
        // Suppression de données avec bouton "supprimer"
        if (isset($_GET['deleteRole'])) {
            $idRole = $_GET['deleteRole'];
            $sql = "DELETE FROM role WHERE id_role = :idRole";
            $stmt = $bdd->prepare($sql);
            $stmt->bindParam(':idRole', $idRole);
            $stmt->execute();
        }

        // Ajout de données avec bouton "Ajouter"
        if (isset($_POST['submitRole'])) {
            $nomRole = $_POST['nomRole'];
        
            $sql = "INSERT INTO role (nom_role) VALUES (:nomRole)";
            $stmt = $bdd->prepare($sql);
            $stmt->bindParam(':nomRole', $nomRole);
            $stmt->execute();
        
            echo "Role ajouté dans la BDD";
        }
    
?>