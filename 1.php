<?php
echo '<pre>';


use bd\models\Game;

require 'vendor/autoload.php';

$config = ['settings' => [
    'displayErrorDetails' => true,
]];

$db = new \Illuminate\Database\Capsule\Manager();
$db->addConnection(parse_ini_file('src/conf/conf.ini'));
$db->setAsGlobal();
$db->bootEloquent();


// Question 1
$mario = Game::where("Name", "LIKE", "%Mario%")->get();

foreach ($mario as $ma) {
    //echo $ma->name . "\n";
}

// Question 2
$jap = \bd\models\Company::where("location_country", "=", "Japan")->get();

foreach ($jap as $j) {
    //echo $j->name . "\n";
}

// Question 3
$plat = \bd\models\Platform::where("install_base", ">=", "10000000")->get();

foreach ($plat as $p) {
    //echo $p->name . "\n";
}

// Question 4
$game = Game::skip(21173)->take(442)->get();

$i = 1;
foreach ($game as $g) {
    //echo $i . "  " . $g->name . "\n";
    $i++;
}

// Question 5
$game2 = Game::all();

$i = 1;
foreach ($game2 as $g) {
    if($i%500 == 0) {
        echo "Page " . $i/500 . "\n";
    }else{
        echo $g->name . "\n";
    }
    $i++;
}


?>

