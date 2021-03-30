<?php

use bd\models\Users;

echo '<pre>';

require 'vendor/autoload.php';

$config = ['settings' => [
    'displayErrorDetails' => true,
]];

$db = new \Illuminate\Database\Capsule\Manager();
$db->addConnection(parse_ini_file('src/conf/conf.ini'));
$db->setAsGlobal();
$db->bootEloquent();

$db->connection()->enableQueryLog();


/** PARTIE 1 */
/**
// Creer deux utilisateurs

$u1 = new \bd\models\Users();
$u1->email = "bilal.scouri@gmail.com";
$u1->nom = "Scouri";
$u1->prenom = "Bilal";
$u1->adresse = "51170 Reims route des arbres";
$u1->telephone = "0808080808";
$u1->naissance = date("Y-m-d H:i:s");
$u1->save();

$u2 = new \bd\models\Users();
$u2->email = "grandgirard.clement24@gmail.com";
$u2->nom = "Grandgirard";
$u2->prenom = "Clément";
$u2->adresse = "54000 Nancy route des arc-en-ciel";
$u2->telephone = "0808080808";
$u2->naissance = date("Y-m-d H:i:s");
$u2->save();

// Creer trois commentaires concernant le jeu 12342

// Commentaire de Bilal
$c1_u1 = new \bd\models\Commentary();
$c1_u1->titre = "Commentaire 1";
$c1_u1->contenu = "C'est un super commentaire hein";
$c1_u1->user_id = \bd\models\Users::where("email", "=", "bilal.scouri@gmail.com")->first()->id;
$c1_u1->game_id = 12342;
$c1_u1->save();

$c2_u1 = new \bd\models\Commentary();
$c2_u1->titre = "Commentaire 2";
$c2_u1->contenu = "Un autre super commentaire";
$c2_u1->user_id = \bd\models\Users::where("email", "=", "bilal.scouri@gmail.com")->first()->id;
$c2_u1->game_id = 12342;
$c2_u1->save();

$c3_u1 = new \bd\models\Commentary();
$c3_u1->titre = "Commentaire 3";
$c3_u1->contenu = "C'est un le troisième et dernier commentaire pour ma part";
$c3_u1->user_id = \bd\models\Users::where("email", "=", "bilal.scouri@gmail.com")->first()->id;
$c3_u1->game_id = 12342;
$c3_u1->save();

// Commentaire de clément
$c1_u2 = new \bd\models\Commentary();
$c1_u2->titre = "Commentaire 1";
$c1_u2->contenu = "C'est un super commentaire hein";
$c1_u2->user_id = \bd\models\Users::where("email", "=", "grandgirard.clement24@gmail.com")->first()->id;
$c1_u2->game_id = 12342;
$c1_u2->save();

$c2_u2 = new \bd\models\Commentary();
$c2_u2->titre = "Commentaire 2";
$c2_u2->contenu = "un autre super commentaire";
$c2_u2->user_id = \bd\models\Users::where("email", "=", "grandgirard.clement24@gmail.com")->first()->id;
$c2_u2->game_id = 12342;
$c2_u2->save();

$c3_u2 = new \bd\models\Commentary();
$c3_u2->titre = "Commentaire 3";
$c3_u2->contenu = "C'est un le troisième et dernier commentaire pour ma part";
$c3_u2->user_id = \bd\models\Users::where("email", "=", "grandgirard.clement24@gmail.com")->first()->id;
$c3_u2->game_id = 12342;
$c3_u2->save();
*/

/** PARTIE 2 */

// Génération des utilisateurs
/**
$i = 1;

$faker = Faker\Factory::create();

while($i < 25001) {
    $u = new \bd\models\Users();
    $email = $faker->email();
    $u->email = $email;
    $u->nom = $faker->lastName();
    $u->prenom = $faker->firstName();
    $u->adresse = $faker->address();
    $u->telephone = $faker->phoneNumber();
    $u->naissance = date("Y-m-d H:i:s");
    $u->save();
    $j = 0;
    while($j<10) {
        $c = new \bd\models\Commentary();
        $c->titre = $faker->sentence(3);
        $c->contenu = $faker->paragraph(2);
        $c->user_id = $i;
        $c->game_id = rand(1, 47948);
        $c->save();
        $j++;
    }
    $i++;
}

*/


// lister les commentaires d'un utilisateur donné, afficher la date du commentaire de façon
// lisible, ordonnés par date décroissante,
/**
$comments = Users::where("id","=", 1)->first()->commentaires()->orderBy('created_at', 'ASC')->get();
foreach($comments as $c){
    echo "<h2>" . $c->titre . "</h2><br>";
    echo "<h3>" . $c->contenu . "</h3><br>";
}*/

// lister les utilisateurs ayant posté plus de 5 commentaires

$user = Users::has('commentaires', '>', 5)->get();

foreach ($user as $u) {
    echo "<h2>" . $u->email . "</h2><br>";
}