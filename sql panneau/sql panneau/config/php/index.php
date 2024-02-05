<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>AFCI</title>
</head>
<body>
    
    <!-- navbar pour changer de page (pas besoin d'avoir plusieurs pages) -->
    <header>
        <nav>
            <ul>
                <li><a href="?page=role">Role</li></a>
                <li><a href="?page=centre">Centre</li></a>
                <li><a href="?page=formation">Formation</li></a>
                <li><a href="?page=pedagogie">Equipe</li></a>
                <li><a href="?page=session">Session</li></a>
                <li><a href="?page=apprenant">Apprenant</li></a>
                <li><a href="?page=affecter">Affectation</a></li>
            </ul>
        </nav>
    </header>

    <?php

// Connexion bdd
$host = "mysql"; // Remplacez par l'hôte de votre base de données
$port = "3306";
$dbname = "afci"; // Remplacez par le nom de votre base de données
$user = "admin"; // Remplacez par votre nom d'utilisateur
$pass = "admin"; // Remplacez par votre mot de passe


    // Création d'une nouvelle instance de la classe PDO
    $bdd = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $user, $pass);

    // Configuration des options PDO / permet les messages d'erreurs
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $bdd->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);





    // 1 Page role

    //Si page = role (true) : Afficher le contenu de la page role
    if (isset($_GET["page"]) && $_GET["page"] == "role") {
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





    // 2 Page centre

    //Si page = centre (true) : Afficher le contenu de la page centre
    if (isset($_GET["page"]) && $_GET["page"] == "centre"){
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





    // 3 Page formation

    //Si page = centre (true) : Afficher le contenu de la page centre
    if (isset($_GET["page"]) && $_GET["page"] == "formation"){
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





    // 4 Page pedagogie

    //Si page = pedagogie (true) : Afficher le contenu de la page pedagogie
    if (isset($_GET["page"]) && $_GET["page"] == "pedagogie"){
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





    // 5 Page session

    // Si page = session (true) : Afficher le contenu 
    if (isset($_GET["page"]) && $_GET["page"] == "session"){

        // Récupération des informations pour les menus déroulants
        $sqlPedagogie = "SELECT * FROM pedagogie";
        $stmtPedagogie = $bdd->query($sqlPedagogie);
        $resultsPedagogie = $stmtPedagogie->fetchAll(PDO::FETCH_ASSOC);

        $sqlFormations = "SELECT * FROM formations";
        $stmtFormations = $bdd->query($sqlFormations);
        $resultsFormations = $stmtFormations->fetchAll(PDO::FETCH_ASSOC);

        $sqlCentres = "SELECT * FROM centres";
        $stmtCentres = $bdd->query($sqlCentres);
        $resultsCentres = $stmtCentres->fetchAll(PDO::FETCH_ASSOC);

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
                        echo '<option value="' . $value['id_pedagogie'] .  '">' . $value['nom_pedagogie'] . '</option>';
                    }
                    ?>

                </select>
                <br>
                <label>Formation :</label>
                <select name="idFormation" id="">

                    <?php
                    foreach ($resultsFormations as $value) {             
                        echo '<option value="' . $value['id_formation'] .  '">' . $value['nom_formation'] . '</option>';
                    }
                    ?>

                </select>
                <br>
                <label>Centre :</label>
                <select name="idCentre" id="">

                    <?php
                    foreach ($resultsCentres as $value) {             
                        echo '<option value="' . $value['id_centre'] .  '">' . $value['ville_centre'] . '</option>';
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
                    echo '<td>' . ($session['date_debut']) . '</td>';
                    echo '<td>' . ($session['nom_session']) . '</td>';
                    echo '<td>' . ($session['nom_formation']) . '</td>';
                    echo '<td>' . ($session['ville_centre']) . '</td>';
                    echo '<td>' . ($session['nom_pedagogie']) . '</td>';
                    echo '<td><a href="?page=session&type=modifier&id=' . ($session['id_session']) . '"><button>Modifier</button></a></td>';
                    echo '<td><a href="?page=session&deleteSession=' . ($session['id_session']) . '" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer cette session ?\');"><button>Supprimer</button></a></td>';
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
                <input type="hidden" name="sessionId" value="<?php echo ($sessionDetails['id_session']); ?>">
                <label>Date de début :</label>
                <input type="text" name="updateDateDebut" value="<?php echo ($sessionDetails['date_debut']); ?>">
                <br>
                <label>Nom de session :</label>
                <input type="text" name="updateNomSession" value="<?php echo ($sessionDetails['nom_session']); ?>">
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
            $sessionId = $_POST['sessionId'];
            $updateDateDebut = $_POST['updateDateDebut'];
            $updateNomSession = $_POST['updateNomSession'];
            $updateIdFormation = $_POST['updateIdFormation'];
            $updateIdCentre = $_POST['updateIdCentre'];
            $updateIdPedagogie = $_POST['updateIdPedagogie'];
        
            $sqlUpdate = "UPDATE session SET date_debut = :dateDebut, nom_session = :nomSession, id_formation = :idFormation, id_centre = :idCentre, id_pedagogie = :idPedagogie WHERE id_session = :idSession";
            $stmtUpdate = $bdd->prepare($sqlUpdate);
            $stmtUpdate->bindParam(':dateDebut', $updateDateDebut);
            $stmtUpdate->bindParam(':nomSession', $updateNomSession);
            $stmtUpdate->bindParam(':idFormation', $updateIdFormation, PDO::PARAM_INT);
            $stmtUpdate->bindParam(':idCentre', $updateIdCentre, PDO::PARAM_INT);
            $stmtUpdate->bindParam(':idPedagogie', $updateIdPedagogie, PDO::PARAM_INT);
            $stmtUpdate->bindParam(':idSession', $sessionId, PDO::PARAM_INT);
        
            if ($stmtUpdate->execute()) {
                echo "Session mise à jour avec succès.";
            } else {
                echo "Erreur lors de la mise à jour de la session.";
            }
        }

            // Suppression de données avec bouton "supprimer"
            if (isset($_GET['deleteSession'])) {
                $idSession = $_GET['deleteSession'];
                $sqlDelete = "DELETE FROM session WHERE id_session = :idSession";
                $stmtDelete = $bdd->prepare($sqlDelete);
                $stmtDelete->bindParam(':idSession', $idSession, PDO::PARAM_INT);
                $stmtDelete->execute();
                echo "<p>Session supprimée avec succès.</p>";
            }
    }

    // Ajout de données avec bouton "ajouter"
    if (isset($_POST['submitSession'])) {
        // Vérification de la présence et non-vide des champs requis
        if (!empty($_POST['dateDebut']) && !empty($_POST['nomSession']) && isset($_POST['idFormation']) && isset($_POST['idCentre']) && isset($_POST['idPedagogie'])) {
            $dateDebut = $_POST['dateDebut'];
            $nomSession = $_POST['nomSession'];
            $idFormation = $_POST['idFormation'];
            $idCentre = $_POST['idCentre'];
            $idPedagogie = $_POST['idPedagogie'];
    
            try {
                $sqlInsert = "INSERT INTO session (date_debut, nom_session, id_formation, id_centre, id_pedagogie) VALUES (:dateDebut, :nomSession, :idFormation, :idCentre, :idPedagogie)";
                $stmtInsert = $bdd->prepare($sqlInsert);
    
                $stmtInsert->bindParam(':dateDebut', $dateDebut);
                $stmtInsert->bindParam(':nomSession', $nomSession);
                $stmtInsert->bindParam(':idFormation', $idFormation, PDO::PARAM_INT);
                $stmtInsert->bindParam(':idCentre', $idCentre, PDO::PARAM_INT);
                $stmtInsert->bindParam(':idPedagogie', $idPedagogie, PDO::PARAM_INT);
    
                if ($stmtInsert->execute()) {
                    echo "Session ajoutée avec succès.";
                } else {
                    echo "Erreur lors de l'ajout de la session.";
                }
            } catch (PDOException $e) {
                // Affichage d'une erreur SQL si elle se produit
                echo "Erreur SQL : " . $e->getMessage();
            }
        } else {
            echo "Tous les champs doivent être remplis.";
        }
    }





    // 6 Page apprenant

        //Si page = pedagogie (true) : Afficher le contenu de la page pedagogie
        if (isset($_GET["page"]) && $_GET["page"] == "apprenant") {

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

    }





    // 7 Page affectation
        if (isset($_GET["page"]) && $_GET["page"] == "affecter") {
            // Récupération des informations pour les menus déroulants
            $sqlCentres = "SELECT * FROM centres";
            $centres = $bdd->query($sqlCentres)->fetchAll(PDO::FETCH_ASSOC);

            $sqlPedagogie = "SELECT * FROM pedagogie";
            $pedagogies = $bdd->query($sqlPedagogie)->fetchAll(PDO::FETCH_ASSOC);

            // Affichage des affectations existantes
            $sqlAffecter = "SELECT * FROM affecter";
            $affectations = $bdd->query($sqlAffecter)->fetchAll(PDO::FETCH_ASSOC);

            // Affichage des affectations existantes
            $sqlAffecter = "SELECT a.id_centre, a.id_pedagogie, c.ville_centre, p.nom_pedagogie 
            FROM affecter a
            JOIN centres c ON a.id_centre = c.id_centre
            JOIN pedagogie p ON a.id_pedagogie = p.id_pedagogie";
            $affectations = $bdd->query($sqlAffecter)->fetchAll(PDO::FETCH_ASSOC);

            // Affichage du formulaire d'ajout d'affectation
            ?>
            <div class="centerDiv">
                <form method="POST">
                    <h1>Ajout d'affectation</h1>
                    <label>Centre :</label>
                    <select name="idCentre">

                        <?php foreach ($centres as $centre) {
                            echo "<option value='{$centre['id_centre']}'>{$centre['ville_centre']}</option>";
                        } 
                        ?>

                    </select>
                    <br>
                    <label>Équipe pédagogique :</label>
                    <select name="idPedagogie">

                        <?php foreach ($pedagogies as $pedagogie) {
                            echo "<option value='{$pedagogie['id_pedagogie']}'>{$pedagogie['nom_pedagogie']}</option>";
                        } 
                        ?>

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
                    echo '<td>' . ($affectation['ville_centre']) . '</td>';
                    echo '<td>' . ($affectation['nom_pedagogie']) . '</td>';
                    echo '<td><a href="?page=affecter&action=edit&idCentre=' . $affectation['id_centre'] . '&idPedagogie=' . $affectation['id_pedagogie'] . '"><button>Modifier</button></a></td>';
                    echo '<td><a href="?page=affecter&delete&idCentre=' . $affectation['id_centre'] . '&idPedagogie=' . $affectation['id_pedagogie'] . '" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer cette affectation ?\');"><button>Supprimer</button></a></td>';
                    echo '</tr>';
                 } ?>
            </table>
        </div>
        
            <?php

            // Traitement de l'ajout d'une nouvelle affectation
            if (isset($_POST['submitAffecter'])) {
                $idCentre = $_POST['idCentre'];
                $idPedagogie = $_POST['idPedagogie'];

                $sqlInsert = "INSERT INTO affecter (id_centre, id_pedagogie) VALUES (:idCentre, :idPedagogie)";
                $stmtInsert = $bdd->prepare($sqlInsert);
                $stmtInsert->execute([':idCentre' => $idCentre, ':idPedagogie' => $idPedagogie]);

                echo "<p class='success'>Affectation ajoutée avec succès.</p>";
            }

            if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['idCentre'], $_GET['idPedagogie'])) {
                $idCentre = $_GET['idCentre'];
                $idPedagogie = $_GET['idPedagogie'];
            
                $sqlDelete = "DELETE FROM affecter WHERE id_centre = :idCentre AND id_pedagogie = :idPedagogie";
                $stmtDelete = $bdd->prepare($sqlDelete);
                $stmtDelete->execute([':idCentre' => $idCentre, ':idPedagogie' => $idPedagogie]);

        }

        if (isset($_POST['action']) && $_POST['action'] == 'updateAffectation') {
            $idCentre = $_POST['idCentre'];
            $idPedagogie = $_POST['idPedagogie'];
        
            $sqlUpdate = "UPDATE affecter SET id_centre = :idCentre, id_pedagogie = :idPedagogie WHERE id_centre = :oldIdCentre AND id_pedagogie = :oldIdPedagogie";
            $stmtUpdate = $bdd->prepare($sqlUpdate);
            $stmtUpdate->execute([
                ':idCentre' => $idCentre,
                ':idPedagogie' => $idPedagogie,
            ]);
        
        }

        }
    ?>

</body>
</html>