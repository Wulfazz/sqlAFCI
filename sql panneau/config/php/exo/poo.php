<?php

// class Moreau {
//     public $benjamine = "Evlyn";


// }

// $moreau = new Moreau;
// $moreau2 = new Moreau;

// echo $moreau->benjamine;

class Vehicule {

    public $nombreRoues;
    public $couleur;
    public $dateConst;
    public $marque;

    public function __construct($nombreRoues,$couleur,$dateConst,$marque)
    {
        $this->nombreRoues=$nombreRoues;
        $this->couleur=$couleur;
        $this->dateConst=$dateConst;
        $this->marque=$marque;
    }

    public function ajouter($annee)
    {
        $this->dateConst+=$annee;
    }

    public function marque($changeMarque)
    {
        $this->marque.=$changeMarque;
    }

}

$voiture = new Vehicule(4, "Violet", 2009, "Renault");
$moto = new Vehicule(2, "Jaune", 2023, "Yamaha");

$voiture->ajouter(22);

$moto->marque("/Honda");


// Pour afficher les informations sur la voiture
echo "<h2>Voiture</h2>";
echo "Nombre de roues: " . $voiture->nombreRoues . "<br>";
echo "Couleur: " . $voiture->couleur . "<br>";
echo "Année de construction: " . $voiture->dateConst . "<br>";
echo "Marque: " . $voiture->marque . "<br>";

// Pour afficher les informations sur la moto
echo "<h2>Moto</h2>";
echo "Nombre de roues: " . $moto->nombreRoues . "<br>";
echo "Couleur: " . $moto->couleur . "<br>";
echo "Année de construction: " . $moto->dateConst . "<br>";
echo "Marque: " . $moto->marque . "<br>";
?>