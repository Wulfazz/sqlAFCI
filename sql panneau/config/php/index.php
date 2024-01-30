<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AFCI</title>
</head>
<body>
    
    <!-- navbar pour changer de page (pas besoin d'avoir plusieurs pages) -->
    <header>
        <nav>
            <ul>
                <a href="?page=role"><li>Role</li></a>
                <a href="?page=centre"><li>Centre</li></a>
                <a href="?page=formation"><li>Formation</li></a>
                <a href="?page=equipe"><li>Equipe</li></a>
                <a href="?page=session"><li>Session</li></a>
                <a href="?page=apprenant"><li>Apprenant</li></a>
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

    // echo "Connexion réussie !";

    // Page role

    //supprimer des données
    if (isset($_GET['deleteRole'])) {
        $idRole = $_GET['deleteRole'];
        $sql = "DELETE FROM role WHERE id_role = :idRole";
        $stmt = $bdd->prepare($sql);
        $stmt->bindParam(':idRole', $idRole, PDO::PARAM_INT);
        $stmt->execute();
    }

    //contenu de la page formation
    if (isset($_GET["page"]) && $_GET["page"] == "role"){

        $sql = "SELECT * FROM role";
        $stmt = $bdd->prepare($sql);
        $stmt->execute();
        $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);

        ?>

            <!-- Formulaire à remplir -->
            <form method="POST">
                <h1>Ajout de rôle</h1>
                <label>Rôle :</label>
                <input type="text" name="nomRole">
                <br>
                <input type="submit" name="submitRole" value="Enregistrer">
            </form>

        <?php

        // Afficher dans un tableau
        echo '<table border="1">';
        echo '<tr><th>ID</th><th>Nom du rôle</th><th>Actions</th></tr>';
        foreach ($roles as $role) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($role['id_role']) . '</td>';
            echo '<td>' . htmlspecialchars($role['nom_role']) . '</td>';
            echo '<td><a href="?page=role&deleteRole=' . $role['id_role'] . '" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer ce rôle ?\');">Supprimer</a></td>';
            echo '</tr>';
        }

        echo '</table>';

    }

    // Bouton enregistrer dans BDD
    if (isset($_POST['submitRole'])){
        $nomRole = $_POST['nomRole'];

        $sql = "INSERT INTO `role`(`nom_role`) VALUES ('$nomRole')";
        $bdd->query($sql);

        echo "data ajoutée dans la bdd";

    }

    // Page centre

    //supprimer des données
    if (isset($_GET['deleteCentre'])) {
        $idCentre = $_GET['deleteCentre'];
        $sql = "DELETE FROM centres WHERE id_centre = :idCentre";
        $stmt = $bdd->prepare($sql);
        $stmt->bindParam(':idCentre', $idCentre, PDO::PARAM_INT);
        $stmt->execute();
    }
    
    //contenu de la page formation
    if (isset($_GET["page"]) && $_GET["page"] == "centre"){

        $sql = "SELECT * FROM centres";
        $stmt = $bdd->prepare($sql);
        $stmt->execute();
        $centres = $stmt->fetchAll(PDO::FETCH_ASSOC);

        ?>

            <!-- Formulaire à remplir -->
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
        <?php

        // Afficher dans un tableau
        echo '<table border="1">';
        echo '<tr><th>Ville</th><th>Adresse</th><th>Code Postal</th><th>Actions</th></tr>';
        foreach ($centres as $centre) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($centre['ville_centre']) . '</td>';
            echo '<td>' . htmlspecialchars($centre['adresse_centre']) . '</td>';
            echo '<td>' . htmlspecialchars($centre['code_postal_centre']) . '</td>';
            echo '<td><a href="?page=centre&deleteCentre=' . $centre['id_centre'] . '" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer ce centre ?\');">Supprimer</a></td>';
            echo '</tr>';
        }
        echo '</table>';
    }

    // Bouton enregistrer dans BDD
    if (isset($_POST['submitCentre'])){
        $villeCentre = $_POST['villeCentre'];
        $adresseCentre = $_POST['adresseCentre'];
        $cpCentre = $_POST['cpCentre'];

        $sql = "INSERT INTO `centres`(`ville_centre`, `adresse_centre`, `code_postal_centre`) 
        VALUES ('$villeCentre','$adresseCentre','$cpCentre')";
        $bdd->query($sql);

        echo "data ajoutée dans la bdd";
    }

    // Page formation

    //supprimer des données
    if (isset($_GET['deleteFormation'])) {
        $idFormation = $_GET['deleteFormation'];
        $sql = "DELETE FROM formations WHERE id_formation = :idFormation";
        $stmt = $bdd->prepare($sql);
        $stmt->bindParam(':idFormation', $idFormation, PDO::PARAM_INT);
        $stmt->execute();
    }

    //contenu de la page formation
    if (isset($_GET["page"]) && $_GET["page"] == "formation"){

        $sql = "SELECT * FROM formations";
        $stmt = $bdd->prepare($sql);
        $stmt->execute();
        $formations = $stmt->fetchAll(PDO::FETCH_ASSOC);

        ?>

        <!-- Formulaire à remplir -->
            <form method="POST">
                <h1>Ajout de formation</h1>
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
        <?php

        // Afficher dans un tableau
        echo '<table border="1">';
        echo '<tr><th>Formation</th><th>Durée</th><th>Niveau de sortie</th><th>Description</th><th>Actions</th></tr>';
        foreach ($formations as $formation) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($formation['nom_formation']) . '</td>';
            echo '<td>' . htmlspecialchars($formation['duree_formation']) . '</td>';
            echo '<td>' . htmlspecialchars($formation['niveau_sortie_formation']) . '</td>';
            echo '<td>' . htmlspecialchars($formation['description']) . '</td>';
            echo '<td><a href="?page=formation&deleteFormation=' . $formation['id_formation'] . '" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer cette formation ?\');">Supprimer</a></td>';
            echo '</tr>';
        }
        
        echo '</table>';

    }

    // Bouton enregistrer dans BDD
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

    // Page equipe

    if (isset($_GET["page"]) && $_GET["page"] == "equipe"){

        $sql = "SELECT * FROM role";
        $requete = $bdd->query($sql);
        $results = $requete->fetchAll(PDO::FETCH_ASSOC);

        $sql = "SELECT * FROM pedagogie";
        $stmt = $bdd->prepare($sql);
        $stmt->execute();
        $pedagogie = $stmt->fetchAll(PDO::FETCH_ASSOC);

        ?>
            <form method="POST">
                <h1>Ajout d'un membre d'équipe</h1>
                <label>Nom :</label>
                <input type="text" name="nomEquipe">
                <br>
                <label>Prénom :</label>
                <input type="text" name="prenomEquipe">
                <br>
                <label>Mail :</label>
                <input type="text" name="mailEquipe">
                <br>
                <label>Téléphone :</label>
                <input type="text" name="numEquipe">
                <br>
                <label>Role :</label>
                <select name="idRole" id="">

                    <?php
                    foreach( $results as $value ){             
                    echo '<option value="' . $value['id_role'] .  '">' . $value['id_role'] . ' - ' . $value['nom_role'] . '</option>';
                    }
                    ?>

                <br>
                </select>
                <input type="submit" name="submitEquipe" value="Enregistrer">
            </form>
        
        <?php

        // Display the roles in a table
        echo '<table border="1">';
        echo '<tr><th>Nom</th><th>Prénom</th><th>Mail</th><th>Num</th></tr>';
        foreach ($pedagogie as $pedagogie) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($pedagogie['nom_pedagogie']) . '</td>';
            echo '<td>' . htmlspecialchars($pedagogie['prenom_pedagogie']) . '</td>';
            echo '<td>' . htmlspecialchars($pedagogie['mail_pedagogie']) . '</td>';
            echo '<td>' . htmlspecialchars($pedagogie['num_pedagogie']) . '</td>';
            echo '</tr>';
        }
                
        echo '</table>';

    if (isset($_POST['submitEquipe'])){
        $nomEquipe = $_POST['nomEquipe'];
        $prenomEquipe = $_POST['prenomEquipe'];
        $mailEquipe = $_POST['mailEquipe'];
        $numEquipe = $_POST['numEquipe'];
        $role = $_POST['idRole'];

        $sql = "INSERT INTO `pedagogie`(`nom_pedagogie`, `prenom_pedagogie`, `mail_pedagogie`, `num_pedagogie`, `id_role`) 
        VALUES ('$nomEquipe','$prenomEquipe','$mailEquipe','$numEquipe', '$role')";
        $bdd->query($sql);

        echo "data ajoutée dans la bdd";
    }
    }

    // Page session
    if (isset($_GET["page"]) && $_GET["page"] == "session"){

        $sql = "SELECT s.date_debut, s.nom_session, c.ville_centre, f.nom_formation, p.nom_pedagogie 
        FROM session s
            LEFT JOIN centres c ON s.id_centre = c.id_centre
            LEFT JOIN formations f ON s.id_formation = f.id_formation
            LEFT JOIN pedagogie p ON s.id_pedagogie = p.id_pedagogie";
        $stmt = $bdd->prepare($sql);
        $stmt->execute();
        $sessions = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $sqlPedagogie = "SELECT * FROM pedagogie";
        $requetePedagogie = $bdd->query($sqlPedagogie);
        $resultsPedagogie = $requetePedagogie->fetchAll(PDO::FETCH_ASSOC);
    
        $sqlFormations = "SELECT * FROM formations";
        $requeteFormations = $bdd->query($sqlFormations);
        $resultsFormations = $requeteFormations->fetchAll(PDO::FETCH_ASSOC);

        $sqlCentres = "SELECT * FROM centres";
        $requeteCentres = $bdd->query($sqlCentres);
        $resultsCentres = $requeteCentres->fetchAll(PDO::FETCH_ASSOC);

        ?>
            <form method="POST">
                <h1>Ajout de session</h1>
                <label>Date de début :</label>
                <input type="text" name="dateSession">
                <br>
                <label>Nom de session :</label>
                <input type="text" name="nomSession">
                <br>
                <label>Equipe :</label>
                
                <select name="idPedagogie" id="">

                    <?php
                    foreach( $resultsPedagogie as $value ){             
                    echo '<option value="' . $value['id_pedagogie'] .  '">' . $value['id_pedagogie'] . ' - ' . $value['nom_pedagogie'] . '</option>';
                    }
                    ?>

                </select>
                <br>

                <label>Formation</label>

                <select name="idFormation" id="">

                    <?php
                    foreach( $resultsFormations as $value ){             
                    echo '<option value="' . $value['id_formation'] .  '">' . $value['id_formation'] . ' - ' . $value['nom_formation'] . '</option>';
                    }
                    ?>

                </select>
                <br>

                <label>Centre</label>

                <select name="idCentre" id="">

                    <?php
                    foreach( $resultsCentres as $value ){             
                    echo '<option value="' . $value['id_centre'] .  '">' . $value['id_centre'] . ' - ' . $value['ville_centre'] . '</option>';
                    }
                    ?>

                </select>
                <br>

                <input type="submit" name="submitSession" value="Enregistrer">
            </form>
        <?php

        // Display the roles in a table
        echo '<table border="1">';
        echo '<tr><th>Date de début</th><th>Formation</th><th>ID Session</th><th>Centre</th><th>Formateur</th></tr>';
        foreach ($sessions as $session) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($session['date_debut']) . '</td>';
            echo '<td>' . htmlspecialchars($session['nom_formation']) . '</td>';
            echo '<td>' . htmlspecialchars($session['nom_session']) . '</td>';
            echo '<td>' . htmlspecialchars($session['ville_centre']) . '</td>';
            echo '<td>' . htmlspecialchars($session['nom_pedagogie']) . '</td>';
            echo '</tr>';
        }
        echo '</table>';

    }

    if (isset($_POST['submitSession'])){
        $dateSession = $_POST['dateSession'];
        $nomSession = $_POST['nomSession'];
        $pedagogie = $_POST['idPedagogie'];
        $formation = $_POST['idFormation'];
        $centre = $_POST['idCentre'];

        $sql = "INSERT INTO `session`(`date_debut`, `id_pedagogie`,`id_formation`, `id_centre`, `nom_session`) 
        VALUES ('$dateSession', '$pedagogie', '$formation', '$centre', '$nomSession')";
        $bdd->query($sql);

        echo "data ajoutée dans la bdd";
    }

    // Page apprenant
    if (isset($_GET["page"]) && $_GET["page"] == "apprenant"){

        $sql = "SELECT * FROM apprenants";
        $stmt = $bdd->prepare($sql);
        $stmt->execute();
        $apprenants = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $sqlidRoleAp = "SELECT * FROM role";
        $requeteidRoleAp = $bdd->query($sqlidRoleAp);
        $resultsidRoleAp = $requeteidRoleAp->fetchAll(PDO::FETCH_ASSOC);

        $sqlSession = "SELECT * FROM session";
        $requeteSession = $bdd->query($sqlSession);
        $resultsSession = $requeteSession->fetchAll(PDO::FETCH_ASSOC);


        ?>
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
                    foreach( $resultsidRoleAp as $value ){             
                    echo '<option value="' . $value['id_role'] .  '">' . $value['id_role'] . ' - ' . $value['nom_role'] . '</option>';
                    }
                    ?>

                </select>
                <br>

                <label>Session :</label>
                <select name="idSession" id="">

                    <?php
                    foreach( $resultsSession as $value ){             
                    echo '<option value="' . $value['id_session'] .  '">' . $value['id_session'] . ' - ' . $value['date_debut'] . '</option>';
                    }
                    ?>

                </select>
                <br>

                <input type="submit" name="submitApprenant" value="Enregistrer">
            </form>
        <?php

        // Display the roles in a table
        echo '<table border="1">';
        echo '<tr><th>Nom</th><th>Prénom</th><th>Mail</th><th>Adresse</th><th>Ville</th><th>Code Postal</th><th>Téléphone</th><th>Diplome</th></tr>';
        foreach ($apprenants as $apprenants) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($apprenants['nom_apprenant']) . '</td>';
            echo '<td>' . htmlspecialchars($apprenants['prenom_apprenant']) . '</td>';
            echo '<td>' . htmlspecialchars($apprenants['mail_apprenant']) . '</td>';
            echo '<td>' . htmlspecialchars($apprenants['adresse_apprenant']) . '</td>';
            echo '<td>' . htmlspecialchars($apprenants['ville_apprenant']) . '</td>';
            echo '<td>' . htmlspecialchars($apprenants['code_postal_apprenant']) . '</td>';
            echo '<td>' . htmlspecialchars($apprenants['tel_apprenant']) . '</td>';
            echo '<td>' . htmlspecialchars($apprenants['niveau_apprenant']) . '</td>';
            echo '</tr>';
        }
                
        echo '</table>';

    }

    if (isset($_POST['submitApprenant'])){
        $nomApprenant = $_POST['nomApprenant'];
        $prenomApprenant = $_POST['prenomApprenant'];
        $mailApprenant = $_POST['mailApprenant'];
        $adresseApprenant = $_POST['adresseApprenant'];
        $villeApprenant = $_POST['villeApprenant'];
        $cpApprenant = $_POST['cpApprenant'];
        $telApprenant = $_POST['telApprenant'];
        $naissanceApprenant = $_POST['naissanceApprenant'];
        $nivApprenant = $_POST['nivApprenant'];
        $peApprenant = $_POST['peApprenant'];
        $secuApprenant = $_POST['secuApprenant'];
        $ribApprenant = $_POST['ribApprenant'];
        $idRoleAp = $_POST['idRoleAp'];
        $idSession = $_POST['idSession'];

        $sql = "INSERT INTO `apprenants`(`nom_apprenant`, `prenom_apprenant`, `mail_apprenant`, `adresse_apprenant`, `ville_apprenant`, `code_postal_apprenant`, `tel_apprenant`, `date_naissance_apprenant`, `niveau_apprenant`, `num_PE_apprenant`, `num_secu_apprenant`, `rib_apprenant`, `id_role`, `id_session`) 
        VALUES ('$nomApprenant','$prenomApprenant','$mailApprenant','$adresseApprenant','$villeApprenant','$cpApprenant','$telApprenant','$naissanceApprenant','$nivApprenant','$peApprenant','$secuApprenant', '$ribApprenant', '$idRoleAp' , '$idSession')";
        $bdd->query($sql);

        echo "data ajoutée dans la bdd";
    }

?>

</body>
</html>