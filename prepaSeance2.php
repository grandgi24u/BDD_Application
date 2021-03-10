<?php
echo '<pre>';

use bd\models\Annonce;
use bd\models\Photo;

require 'vendor/autoload.php';

$config = ['settings' => [
    'displayErrorDetails' => true,
]];

$db = new \Illuminate\Database\Capsule\Manager();
$db->addConnection(parse_ini_file('src/conf/conf.ini'));
$db->setAsGlobal();
$db->bootEloquent();

//question 1
$annonce22 = Annonce::where('id', '=', '22')->first();

//question 2
$quest2 = $annonce22->photos()->where('taille_octet', '>=', '100000')->get();

//question 3
$listeAnnonce = Annonce::all();
$quest3 = $listeAnnonce->where($listeAnnonce->photos()->count(), '>=', '3')->get();

//question 4
$quest4 = $listeAnnonce->photos()->where('taille_octet', '>=', '100000')->get();

//question 4
$photo = Photo::find(12);
$photo->id_annonce = 22;

//question 5
$category42 = \bd\models\Categorie::find(42);
$category73 = \bd\models\Categorie::find(73);

$lien1 = new appartenanceCategorieAnnonce;
$lien2 = new appartenanceCategorieAnnonce;
$lien1->id_annonce = 22;
$lien2->id_annonce = 22;
$lien1->id_categorie = 42;
$lien2->id_categorie = 73;

$lien1->save();
$lien2->save();