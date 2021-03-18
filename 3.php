<?php
echo '<pre>';

use bd\models\Game;
use Illuminate\Database\Capsule\Manager as DB;

require 'vendor/autoload.php';

$config = ['settings' => [
    'displayErrorDetails' => true,
]];



$db = new \Illuminate\Database\Capsule\Manager();
$db->addConnection(parse_ini_file('src/conf/conf.ini'));
$db->setAsGlobal();
$db->bootEloquent();

$db->connection()->enableQueryLog();

// PARTIE 1 //

// Q1 - lister l'ensemble des jeux
/**
$time1 = microtime (true);
$question1 = Game::all();
$time2 = microtime (true);

echo "Le temps de la requette : " . $time2 - $time1;


// Q2 - lister les jeux dont le nom contient 'Mario'
$time1 = microtime (true);
$question2 = Game::where("Name", "LIKE", "%Mario%")->get();
$time2 = microtime (true);
$temps = $time2 - $time1;

echo "Le temps de la requette : " . $temps;


// Q3 - afficher les personnages des jeux dont le nom débute par 'Mario'
$time1 = microtime (true);
$quest3 = \bd\models\Game::where('name', 'LIKE', 'Mario%')->get();
$time2 = microtime (true);
$temps = $time2 - $time1;

echo "Le temps de la requette : " . $temps;


// Q4 - les jeux dont le nom débute par 'Mario' et dont le rating initial contient '3+'
$time1 = microtime (true);
$quest4 = \bd\models\Game::where('name', 'LIKE', 'Mario%')->get();

foreach ($quest4 as $q) {
    if(strpos($q->rating()->first(),"3+")){}
}
$time2 = microtime (true);
$temps = $time2 - $time1;

echo "Le temps de la requette : " . $temps;


// Etudier la requête : "lister les jeux dont le nom débute par '<valeur>' "
// Q1 - mesurer son temps d'exécution avec 3 valeurs différentes
$time1 = microtime (true);
$req1 = \bd\models\Game::where('name', 'LIKE', 'Mario%')->get();
$time2 = microtime (true);
$t1 = $time2 - $time1;

$time1 = microtime (true);
$req2 = \bd\models\Game::where('name', 'LIKE', 'FIFA%')->get();
$time2 = microtime (true);
$t2 = $time2 - $time1;

$time1 = microtime (true);
$req3 = \bd\models\Game::where('name', 'LIKE', 'Desert%')->get();
$time2 = microtime (true);
$t3 = $time2 - $time1;

echo "Temps 1 : " . $t1 . " - Temps 1 : " . $t2 . " - Temps 1 : " . $t3;

// Q2 - créer un index sur la colonne 'name' de la table 'game'
// réaliser depuis phpMyAdmin

// Q3 - mesurer à nouveau le temps d'exécution avec 3 nouvelles valeurs
// Les requetes sont réaliser beaucoup plus rapidement
// car le fichier index est plus petit que le fichier de données


// Etudier la requête : "lister les jeux dont le nom contient '<valeur>' "
// Q1 - mesurer son temps d'exécution avec 3 valeurs différentes
$time1 = microtime (true);
$req1 = \bd\models\Game::where('name', 'LIKE', '%Mario%')->get();
$time2 = microtime (true);
$t1 = $time2 - $time1;

$time1 = microtime (true);
$req2 = \bd\models\Game::where('name', 'LIKE', '%FIFA%')->get();
$time2 = microtime (true);
$t2 = $time2 - $time1;

$time1 = microtime (true);
$req3 = \bd\models\Game::where('name', 'LIKE', '%Desert%')->get();
$time2 = microtime (true);
$t3 = $time2 - $time1;

echo "Temps 1 : " . $t1 . " - Temps 1 : " . $t2 . " - Temps 1 : " . $t3;

// Q2 - créer un index sur la colonne 'name' de la table 'game'
// réaliser depuis phpMyAdmin

// Les requetes sont réalisée pareil car l'index n'est pas utilisé


// Etudier la requête : "Liste des compagnies d'un pays(location_country) "
// Q1 - mesurer son temps d'exécution avec 3 valeurs différentes
$time1 = microtime (true);
$jap = \bd\models\Company::where("location_country", "=", "Japan")->get();
$time2 = microtime (true);
$t1 = $time2 - $time1;

$time1 = microtime (true);
$jap = \bd\models\Company::where("location_country", "=", "France")->get();
$time2 = microtime (true);
$t2 = $time2 - $time1;

$time1 = microtime (true);
$jap = \bd\models\Company::where("location_country", "=", "USA")->get();
$time2 = microtime (true);
$t3 = $time2 - $time1;

echo "Temps 1 : " . $t1 . " - Temps 1 : " . $t2 . " - Temps 1 : " . $t3;

// Q2 - créer un index sur la colonne 'name' de la table 'game'
// réaliser depuis phpMyAdmin

// Il y a un gain mais plus faible que dans la premiere requette
// car il y a moins de pays que de nom


// PARTIE 2 //

// Q1 - lister les jeux dont le nom contient 'Mario'
$quest1 = \bd\models\Game::where('name', 'LIKE', '%Mario%')->get();
// 1 requetes


// Q2 - afficher le nom des personnages du jeu 12342
$quest2 = \bd\models\Game::find(12342);
$quest2 = $quest2->characters;
// 2 requetes


// Q3 - afficher les noms des persos apparus pour la 1ère fois dans 1 jeu dont le nom contient Mario
$perso = \bd\models\Character::all();
$mario = \bd\models\Game::where('name', 'LIKE', '%Mario%')->get();

foreach ($perso as $q) {
    foreach ($mario as $m) {
        if($q->first_appeared_in_game_id === $m->id) {

        }
    }
}
// 2 requetes


// Q4 - afficher le nom des personnages des jeux dont le nom (du jeu) contient 'Mario'
$quest4 = \bd\models\Game::where('name', 'LIKE', '%Mario%')->get();
foreach ($quest4 as $q) {
    $q->characters;
}
// 159 requetes

// Reprog en chargement liée
$quest4 = Game::where('name', 'LIKE', '%Mario%')->with('characters')->get();
foreach ($quest4 as $q) {
    $q->characters;
}
// 2 requetes
*/


// Q5 - les jeux développés par une compagnie dont le nom contient 'Sony'
$quest5 = \bd\models\Company::where("name", "LIKE", "%Sony%")->get();
foreach ($quest5 as $q) {
    $q->games;
}
// 14 requetes
// Reprog en chargement liée
$quest5 = \bd\models\Company::where("name", "LIKE", "%Sony%")->with('games')->get();
// 2 requetes


/**
 * affichage du log de requêtes
 */
foreach( DB::getQueryLog() as $q){
    echo "-------------- \n";
    echo "query : " . $q['query'] ."\n";
    echo " --- bindings : [ ";
    foreach ($q['bindings'] as $b ) {
        echo " ". $b.",";
    }
    echo " ] ---\n";
    echo "-------------- \n \n";
};

