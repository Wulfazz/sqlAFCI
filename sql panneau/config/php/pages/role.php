<?php

    include("function.php");
    $roles = selectAll("role");
        
?>

<!-- Contenu -->
<div class="centerDiv">

    <!-- Formulaire d'ajout de données -->
    <form method="POST">
        <h1>Ajout de poste</h1>
        <label for="nomRole">Nom du poste :</label>
        <!-- Barre à remplir, type texte pour préciser qu'il s'agit d'un texte -->
        <input type="text" name="nomRole">
        <!-- Bouton enregistrer pour entrer le nouveau role -->
        <input type="submit" name="submitRole" value="Enregistrer">
    </form>

    <table border="1">

        <tr>
            <!-- Noms des colonnes -->
            <th>ID :</th>
            <th>Nom poste :</th>
            <th>Modifier :</th>
            <th>Action :</th>
        </tr>

        <?php
        // Données qui vont être dans le tableau d'informations
        foreach ($roles as $role) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($role['id_role']) . '</td>';
            echo '<td>' . htmlspecialchars($role['nom_role']) . '</td>';
            echo '<td><a href="?page=role&type=modifier&id=' . htmlspecialchars($role['id_role']) . '"><button>Modifier</button></a></td>';
            echo '<td><a href="?page=role&deleteRole=' . htmlspecialchars($role['id_role']) . '" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer ce poste ?\');"><button>Supprimer</button></a></td>';
            echo '</tr>';
        }
        ?>

    </table>

</div>

<?php

    // Si URL de Type = Modifier (true) avec ID :
    if (isset($_GET['type']) && $_GET['type'] == "modifier" && isset($_GET['id'])) {
        $idRole = $_GET["id"];
        $sqlIdRole = "SELECT * FROM role WHERE id_role = :idRole";
        $stmtIdRole = $bdd->prepare($sqlIdRole);
        $stmtIdRole->bindParam(':idRole', $idRole);
        $stmtIdRole->execute();
        $resultsIdRole = $stmtIdRole->fetch(PDO::FETCH_ASSOC);

        // Formulaire de modification
        if ($resultsIdRole) {
            ?>
            <form method="POST">
                <input type="hidden" name="idRole" value="<?php echo htmlspecialchars($resultsIdRole['id_role']); ?>">
                <label>Nom de poste :</label>
                <input type="text" name="nomRole" value="<?php echo htmlspecialchars($resultsIdRole['nom_role']); ?>">
                <input type="submit" name="updateRole" value="Mettre à jour">
            </form>
            <?php
        }
    }

    if (isset($_POST["updateRole"])) {

        // Mettez à jour la base de données
        $sqlUpdateRole = "UPDATE role SET nom_role = :nomRole WHERE id_role = :idRole";
        $stmtUpdateRole = $bdd->prepare($_POST["sqlUpdateRole"]);
        $stmtUpdateRole->bindParam(':nomRole', $_POST["nomRole"]);
        $stmtUpdateRole->bindParam(':idRole', $_POST["idRole"]);
        $stmtUpdateRole->execute();

        echo "Nom du poste modifié";
    }

    // Suppression de données avec bouton "supprimer"
    if (isset($_GET['deleteRole'])) {
        $idRole = $_GET['deleteRole'];
        $sql = "DELETE FROM role WHERE id_role = :idRole";
        $stmt = $bdd->prepare($sql);
        $stmtDeleteRole->bindParam(':idRole', $idRole);
        $stmtDeleteRole->execute();
    }
    
    // Ajout de données avec bouton "Ajouter"
    if (isset($_POST['submitRole'])) {
    
        $sql = "INSERT INTO role (nom_role) 
        VALUES (:nomRole)";
        $stmt = $bdd->prepare($sql);
        $stmtInsertRole->bindParam(':nomRole', $_POST['nomRole']);
        $stmtInsertRole->execute();
    
        echo "Role ajouté dans la BDD";
    }

?>