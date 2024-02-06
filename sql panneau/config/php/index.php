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
        if (isset($_GET['page'])){
            $page = $_GET['page'];
            include "pages/$page.php";
        }
        ?>

    <!-- footer -->
    <?php
    include 'footer.php';
    ?>