<div class="centerDiv">
<?php

// class Moreau {
//     public $benjamine = "Evlyn";


// }

// $moreau = new Moreau;
// $moreau2 = new Moreau;

// echo $moreau->benjamine;

class Vehicule {

    // Les attributs de base pour savoir qui est quoi 
    public $nombreRoues;
    public $couleur;
    public $dateConst;
    public $marque;

    // Fontion pour affilié les données au bon endroit dans la fonction
    public function __construct($nombreRoues,$couleur,$dateConst,$marque)
    {
        $this->nombreRoues=$nombreRoues;
        $this->couleur=$couleur;
        $this->dateConst=$dateConst;
        $this->marque=$marque;
    }

    // Fonction pour ajouter un nombre d'années
    public function ajouter($annee)
    {
        // + se met avant le =
        $this->dateConst+=$annee;
    }

    // fonction pour ajouter Honda à la marque de moto
    public function marque($changeMarque)
    {
        // Il faut mettre  un . avant le = pour qu'il garde les anciennes données sans les changer
        $this->marque.=$changeMarque;
    }

    // Concatenation des données pour mieux les mettre sur la page
    public function presentation()
    {
        echo "Nombre de roues: " . $this->nombreRoues . "<br>" . "Couleur: " . $this->couleur . "<br>" . "Année de construction: " . $this->dateConst . "<br>" . "Marque: " . $this->marque;
        echo "<br><br>";
    }

}

//Les véhicules
$voiture = new Vehicule(4, "Violet", 2009, "Renault");
$moto = new Vehicule(2, "Jaune", 2023, "Yamaha");

// Les modifications à faire 
$voiture->ajouter(22);

$moto->marque("/Honda");

// Un titre parce que pourquoi pas ? 
echo "<h2>Voiture</h2>";
echo $voiture->presentation();

echo "<h2>Moto</h2>";
echo $moto->presentation();


?>
</div>