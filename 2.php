<?php

use bd\models\Genre;

echo '<pre>';

require 'vendor/autoload.php';

$config = ['settings' => [
    'displayErrorDetails' => true,
]];

$db = new \Illuminate\Database\Capsule\Manager();
$db->addConnection(parse_ini_file('src/conf/conf.ini'));
$db->setAsGlobal();
$db->bootEloquent();

/**
// afficher (name , deck) les personnages du jeu 12342
$quest1 = \bd\models\Game::find(12342);
$quest1 = $quest1->characters;

echo "<h1>Question 1</h1><br>";
foreach ($quest1 as $q) {
    echo $q->name . " : " . $q->deck . "<br><br>";
}


// les personnages des jeux dont le nom (du jeu) débute par 'Mario'
$quest2 = \bd\models\Game::where('name', 'LIKE', 'Mario%')->get();

echo "<h1>Question 2</h1><br>";
foreach ($quest2 as $q) {
    $perso = $q->characters;
    echo "<h3>Persos du jeu : $q->name</h3>";
    foreach ($perso as $p) {
        echo $p->name . "<br>";
    }
}

//les jeux développés par une compagnie dont le nom contient 'Sony'
$quest3 = \bd\models\Company::where("name", "LIKE", "%Sony%")->get();

echo "<h1>Question 3</h1><br>";
foreach ($quest3 as $q) {
    $jeux = $q->games;
    echo "<h3>Jeux de : $q->name</h3>";
    foreach ($jeux as $j) {
        echo $j->name . "<br>";
    }
}*/

//le rating initial (indiquer le rating board) des jeux dont le nom contient Mario
$quest4 = \bd\models\Game::where('name', 'LIKE', '%Mario%')->get();

echo "<h1>Question 4</h1><br>";
foreach ($quest4 as $q) {
    $rating = $q->rating()->get()->take(1);
    echo "<h3>Jeu : $q->name</h3>";

    foreach ($rating as $r) {
        echo $r->rating_board->name . "<br>";
    }
}

/**
//les jeux dont le nom débute par Mario et ayant plus de 3 personnages
$quest5 = \bd\models\Game::where('name', 'LIKE', 'Mario%')->get();

echo "<h1>Question 5</h1><br>";
foreach ($quest5 as $q){
    $game = $q->has("characters", ">" , "3")->get();
    foreach ($game as $g){
        echo $g->name . "<br>";
    }
}

//les jeux dont le nom débute par Mario et dont le rating initial contient "3+"
$quest6 = \bd\models\Game::where('name', 'LIKE', 'Mario%')->get();

echo "<h1>Question 6</h1><br>";
foreach ($quest6 as $q) {
    if(strpos($q->rating()->first(),"3+")){
        echo "<h3>Jeu : $q->name, rating : {$q->rating()->first()->name}</h3>";
    }
}

//les jeux dont le nom débute par Mario, publiés par une compagnie dont le nom contient
//"Inc." et dont le rating initial contient "3+
echo "<h1>Question 7</h1><br>";

$game = \bd\models\Game::where('name', 'LIKE', 'Mario%')->whereHas('company_publishers', function($company) {
    $company->where('name', 'LIKE', '%INC.%');
})->get();

foreach ($game as $g) {
    if(strpos($g->rating()->first(),"3+")){
        echo $g->name . "<br>";
    }
}

//les jeux dont le nom débute Mario, publiés par une compagnie dont le nom contient "Inc",
//dont le rating initial contient "3+" et ayant reçu un avis de la part du rating board nommé
//"CERO"
echo "<h1>Question 8</h1><br>";

$game = \bd\models\Game::where('name', 'LIKE', 'Mario%')->whereHas('company_publishers', function($company) {
    $company->where('name', 'LIKE', '%INC%');
})->get();

foreach ($game as $g) {
    if(strpos($g->rating()->first(),"3+")){
        $test = false;
        foreach ($g->rating as $r) {
            if(!$test && strpos($r,"CERO")) {
                $test = true;
            }
        }
        if($test){
            echo $g->name . "<br>";
        }
    }
}

//ajouter un nouveau genre de jeu, et l'associer aux jeux 12, 56, 12, 345
$genre = new Genre();
$genre->name = "Un super genre";
$genre->save();

$genre->games()->attach([12,56,345]);*/








