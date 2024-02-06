    <!-- connexion à la bdd -->
    <?php
    include 'db.php';
    ?>

    <?php
    include 'header.php';
    ?>

    <?php
    include 'navbar.php';
    ?>

        <!-- Contenus site (les différentes pages) -->

        <?php
        // Permet de reconnaître la page sur laquelle on se trouve, si la page est l'une des pages php, la page se chargera. 
        if (isset($_GET['page'])){
            $page = $_GET['page'];
            include "pages/$page.php";
        }
        ?>

    <!-- footer -->
    <?php
    include 'footer.php';
    ?>