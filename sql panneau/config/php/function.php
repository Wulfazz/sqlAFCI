<?php

function selectAll($table) {

    $sql = "SELECT * FROM $table";
    $table = $bdd->query($sql)->fetchAll(PDO::FETCH_ASSOC);

}

?>
