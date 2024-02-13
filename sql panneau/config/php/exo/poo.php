<div class="centerDiv">
<?php

// class Moreau {
//     public $benjamine = "Evlyn";


// }

// $moreau = new Moreau;
// $moreau2 = new Moreau;

// echo $moreau->benjamine;

// class Vehicule {

//     // Les attributs de base pour savoir qui est quoi 
//     public $nombreRoues;
//     public $couleur;
//     public $dateConst;
//     public $marque;

//     // Fontion pour affilié les données au bon endroit dans la fonction
//     public function __construct($nombreRoues,$couleur,$dateConst,$marque)
//     {
//         $this->nombreRoues=$nombreRoues;
//         $this->couleur=$couleur;
//         $this->dateConst=$dateConst;
//         $this->marque=$marque;
//     }

//     // Fonction pour ajouter un nombre d'années
//     public function ajouter($annee)
//     {
//         // + se met avant le =
//         $this->dateConst+=$annee;
//     }

//     // fonction pour ajouter Honda à la marque de moto
//     public function marque($changeMarque)
//     {
//         // Il faut mettre  un . avant le = pour qu'il garde les anciennes données sans les changer
//         $this->marque.=$changeMarque;
//     }

//     // Concatenation des données pour mieux les mettre sur la page
//     public function presentation()
//     {
//         echo "Nombre de roues: " . $this->nombreRoues . "<br>" . "Couleur: " . $this->couleur . "<br>" . "Année de construction: " . $this->dateConst . "<br>" . "Marque: " . $this->marque;
//         echo "<br><br>";
//     }

// }

// //Les véhicules
// $voiture = new Vehicule(4, "Violet", 2009, "Renault");
// $moto = new Vehicule(2, "Jaune", 2023, "Yamaha");

// // Les modifications à faire 
// $voiture->ajouter(22);

// $moto->marque("/Honda");

// // Un titre parce que pourquoi pas ? 
// echo "<h2>Voiture</h2>";
// echo $voiture->presentation();

// echo "<h2>Moto</h2>";
// echo $moto->presentation();





// class Personnage {
//     public $taille;
//     public $genre;
//     public $couleurCheveux;

//     // Permet de créer des instances
//     public function __construct($taille, $genre, $couleurCheveux){

//         $this->taille=$taille;
//         $this->genre=$genre;
//         $this->couleurCheveux=$couleurCheveux;
//     }

//     public function presentation()
//     {
//         return "Taille: " . $this->taille . "<br>" . "Genre: " . $this->genre . "<br>" . "Couleur de cheveux: " . $this->couleurCheveux;
//         return "<br><br>";
//     }
    
// }

// // extentions Personnage
// class Mecanicien extends Personnage{

//     public function mecphrase(){
//         return "Mon rôle est de réparer des voitures";
//     }
// }

// class Developpeur extends Personnage{

//     public function devphrase(){
//         return "Je suis développeur fullstack";
//     }
// }

// class PiloteAvion extends Personnage{

//     public function __construct($taille, $genre){

//     $this->taille=$taille;
//     $this->genre=$genre;
    
//     }

//     public function presentation()
//     {
//         return "Taille: " . $this->taille . "<br>" . "Genre: " . $this->genre;
//         return "<br><br>";
//     }
// }

// // extensions développeur 
// class Frontend extends Developpeur{
//     public function devphrase(){
//         return "Je suis développeur frontend";
//     }
// }

// class Backend extends Developpeur{
//     public function devphrase(){
//         return "J'aime la base de données";
//     }
// }

// // Les différentes personnes
// $personnage=new Personnage(170, "Homme", "Bleu");
// $mecanicien=new Mecanicien(180, "Femme", "Rouge");
// $devFull=new Developpeur(190, "Homme", "Blanc");
// $devFront=new Frontend(170, "Homme", "Noir");
// $devBack=new Backend(170, "Femme", "Noir");
// $pilote=new PiloteAvion(180, "Homme");

// // Affichage des fonctions
// echo "<h2>Personnage</h2>";
// echo $personnage->presentation();

// echo "<h2>Mécanicien</h2>";
// echo $mecanicien->presentation();
// echo $mecanicien->mecphrase();

// echo "<h2>Developpeur</h2>";
// echo $devFull->presentation();
// echo $devFull->devphrase();

// echo "<h2>DeveloppeurFront</h2>";
// echo $devFront->presentation();
// echo $devFront->devphrase();

// echo "<h2>DeveloppeurBack</h2>";
// echo $devBack->presentation();
// echo $devBack->devphrase();

// echo "<h2>Pilote</h2>";
// echo $pilote->presentation();







//Partie gestion des personnages

abstract class Hero {
    public $nom;
    public $genre;
    public $arme;

    public function __construct($nom, $genre, $arme) {
        $this->nom = $nom;
        $this->genre = $genre;
        $this->arme = $arme;
    }

    public function presentation()
    {
        return "Nom: " . $this->nom . "<br>" . "Genre: " . $this->genre . "<br>" . "Arme: " . $this->arme . "<br>" . "<br>";
        return "<br><br>";
    }
}

        class Assassin extends Hero {
            public function affichage(){
                return "Tu n'es pas en sécurité près d'un buisson ... <br><br>";
            }
        }

        class Tank extends Hero {
            public function affichage(){
                return "Sois rassuré ! Mon corps sera ton bouclier ! <br><br>";
            }
        }

        class Combattant extends Hero {
            public function affichage(){
                return "Tu succomberas sous mes coups ! <br><br>";
            }
        }

        class Mage extends Hero {
            public function affichage(){
                return "Il reste beaucoup de choses à découvrir ... <br><br>";
            }
        }

        class Tirreur extends Hero {
            public function affichage(){
                return "Une balle ! Un mort ! <br><br>";
            }
        }

        class Support extends Hero {
            public function affichage(){
                return "Tu ne sera jamais seul ! <br><br>";
            }
        }


        // Les persos
        $nolan=new Assassin("Nolan", "Homme", "Dague");
        $karina=new Assassin("Karina", "Femme", "Double Dague");
        $franco=new Tank("Franco", "Homme", "Ancre");
        $edith=new Tank("Edith", "Femme", "Robot");
        $balmond=new Combattant("Balmond", "Homme", "Hache");
        $cici=new Combattant("Cici", "Femme", "Yoyo");
        $cecilion=new Mage("Cecilion", "Homme", "Sceptre");
        $vexana=new Mage("Vexana", "Femme", "Sceptre");
        $melissa=new Tirreur("Melissa", "Femme", "Voodoo");
        $bruno=new Tirreur("Bruno", "Homme", "Ballon");
        $estes=new Support("Estes", "Homme", "Rouleau");
        $angela=new Support("Angela", "Femme", "Poupée");


        // Affichage des persos 
        echo "<h2>Assassins</h2>";

        echo $karina->affichage();
        echo $nolan->presentation();
        echo $karina->presentation();

        echo "<h2>Tank</h2>";

        echo $franco->affichage();
        echo $franco->presentation();
        echo $edith->presentation();

        echo "<h2>Combattant</h2>";

        echo $balmond->affichage();
        echo $balmond->presentation();
        echo $cici->presentation();

        echo "<h2>Mage</h2>";

        echo $cecilion->affichage();
        echo $cecilion->presentation();
        echo $vexana->presentation();

        echo "<h2>Tirreur</h2>";

        echo $melissa->affichage();
        echo $melissa->presentation();
        echo $bruno->presentation();

        echo "<h2>Support</h2>";
        
        echo $estes->affichage();
        echo $estes->presentation();
        echo $angela->presentation();
?>
</div>