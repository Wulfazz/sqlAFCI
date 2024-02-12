<?php

function selectAll($table) {

    include 'db.php';
    $sql = "SELECT * FROM $table";
    return $bdd->query($sql)->fetchAll(PDO::FETCH_ASSOC);

}

?>
