<?php

    include("function.php");
    $users = selectAll("users");

?>

<div class="centerDiv">

    <form method="POST">
        <h2>Nouvel utilisateur</h2>
        <label for="">Mail :</label>
        <input type="text" name="identifiantNU">
        <label for="">Mot de passe :</label>
        <input type="password" name="passwordNU">
        <input type="submit" name="submitUser" value="Créer">
    </form>

</div>

<?php

    if (isset($_POST['submitUser'])) {

        //Pour crypter le mot de passe
        $hash = password_hash($passwordNU, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (identifiant, password) VALUES (:identifiantNU, :hash)";
        $stmt = $bdd->prepare($sql);

        $stmt->bindParam(':identifiantNU', $_POST['identifiantNU']);
        $stmt->bindParam(':hash', $_POST['hash']);
        $stmt->execute();

        echo "Inscription faite";
    }

?>

<div class="centerDiv">

    <form method="POST">
        <h2>Connexion</h2>
        <label for="">Mail :</label>
        <input type="text" name="identifiantConnect">
        <label for="">Mot de passe :</label>
        <input type="password" name="passwordConnect">
        <input type="submit" name="submitConnectUser" value="Connexion">
    </form>

</div>

<?php

    if (isset($_POST['submitConnectUser'])) {
    
        $identifiantConnect = $_POST['identifiantConnect'];
        $passwordConnect = $_POST['passwordConnect'];
        
        $sql = "SELECT * FROM users WHERE identifiant = :identifiantConnect";
        $stmt = $bdd->prepare($sql);
        $stmt->bindParam(':identifiantConnect', $identifiantConnect);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            
            if (password_verify($passwordConnect, $user['password'])) {
            
                echo 'Connexion réussie !';
            } else {
                
                echo 'Mot de passe incorrect.';
            }
        } else {
            
            echo 'Aucun utilisateur trouvé avec cet identifiant.';
        }
    }
?>