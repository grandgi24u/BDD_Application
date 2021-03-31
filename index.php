<?php

require 'vendor/autoload.php';

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$config = ['settings' => [
    'displayErrorDetails' => true,
]];

$db = new \Illuminate\Database\Capsule\Manager();
$db->addConnection(parse_ini_file('src/conf/conf.ini'));
$db->setAsGlobal();
$db->bootEloquent();

$container=new \Slim\Container($config);

$db->connection()->enableQueryLog();

$app=new \Slim\App($config);

$app->get('/api/games/{id}/characters', \bd\controller\ControllerGames::class . ':gameCharacters')
    ->setName('characters');

$app->get('/api/games/{id}/comments', \bd\controller\ControllerGames::class . ':gameComments')
    ->setName('comments');

$app->post('/api/games/{id}/comments', \bd\controller\ControllerGames::class . ':postGameComments');

$app->get('/api/games/{id}', \bd\controller\ControllerGames::class . ':game')->setName('idGame');

$app->get('/api/games', \bd\controller\ControllerGames::class . ':gamesCollection')
    ->setName('games');

$app->get('/api/platform/{id}', \bd\controller\ControllerGames::class . ':platform')
    ->setName('platform');

$app->get('/api/platform/{id}/description', \bd\controller\ControllerGames::class . ':platformDescr')
    ->setName('platformDescr');

$app->get('/api/character/{id}', \bd\controller\ControllerGames::class . ':character')
    ->setName('character');

$app->run();
