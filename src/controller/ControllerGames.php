<?php


namespace bd\controller;

use bd\models\Character;
use bd\models\Commentary;
use bd\models\Game;
use bd\models\Platform;
use bd\models\Users;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use\Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class ControllerGames
{
    private $container;

    public function __construct($c){
        $this->container=$c;
    }

    public function game(Request $request, Response $response, array $args){
        try {
            $game=Game::where('id', '=', $args['id'])->firstOrFail();
        }catch (ModelNotFoundException $e){
            return $response->withStatus(404);
        }

        $response->withHeader('Content-Type', 'application/json');

        return $response->withJson(
            array(
                'game' => array(
                    'id' => $game->id,
                    'name' => $game->name,
                    'alias' => $game->alias,
                    'deck' => $game->deck,
                    'description' => $game->description,
                    'original_release_date' => $game->original_release_date
                ),
                'links' => array(
                    'comments' => ['href' => $this->container->router->pathFor('comments', ['id' => $game->id])],
                    'characters' => ['href' => $this->container->router->pathFor('characters', ['id' => $game->id])]
                )
            )
        );
    }

    public function gamesCollection(Request $request, Response $response, array $args){
        $num = $request->getQueryParam('page');

        if (isset($num)){
            $games=Game::skip(200*$num)->take(200)->get();
        }else{
            $games=Game::take(200)->get();
        }

        $tab=[];

        foreach ($games as $g){
            $link = $this->container->router->pathFor('idGame', ['id' => $g->id]);
            $tab[]=array(
                'game' => array(
                    'id' => $g->id,
                    'name' => $g->name,
                    'alias' => $g->alias,
                    'deck' => $g->deck
                ),
                'links' => ['self' => ['href' => $link]]
            );
        }

        $response->withHeader('Content-type', 'application/json');
        $next = $num+1;
        $prev = $num-1;
        return $response->withJson(array('games' => $tab, 'links' => [
            'prev' => ['href' => "/api/games?page=" .$prev ],
            'next' => ['href' => "/api/games?page=" . $next ]
        ]));
    }

    public function gameComments(Request $request, Response $response, array $args){
        $comm=Commentary::where('game_id', '=', $args['id'])->get();

        $tab=[];
        foreach ($comm as $c){
            $tab[]=[
                'id' => $c->id,
                'title' => $c->titre,
                'text' => $c->contenu,
                'date_created' => $c->created_at,//TODO
                'name_user' => Users::where('id', '=', $c->user_id)->first()->nom
            ];
        }

        $response->withHeader('Content-Type', 'application/json');

        return $response->withJson($tab);
    }

    public function platformsCollection(Request $request, Response $response, array $args){
        $num = $request->getQueryParam('page');

        if (isset($num)){
            $platf=Platform::skip(25*$num)->take(25)->get();
        }else{
            $platf=Platform::take(25)->get();
        }

        $tab=[];

        foreach ($platf as $p){
            $link = "";//$this->container->router->pathFor('descrPlatform', ['id' => $p->id]);TODO
            $tab[]=array(
                'platform' => array(
                    'id' => $p->id,
                    'name' => $p->name,
                    'alias' => $p->alias,
                    'abbreviation' => $p->abbreviation
                ),
                'links' => ['description' => ['href' => $link]]
            );
        }

        $response->withHeader('Content-type', 'application/json');
        $next = $num+1;
        $prev = $num-1;

        return $response->withJson(
            array(
                'games' => $tab,
                'links' => [
                    'prev' => ['href' => "/api/games?page=" .$prev ],
                    'next' => ['href' => "/api/games?page=" . $next ]
                ]
            )
        );
    }

    public function gameCharacters(Request $request, Response $response, array $args){
        $perso=Game::where('id', '=', $args['id'])->first()->characters;

        $tab['characters']=[];
        foreach ($perso as $p){
            $link = "";//$this->container->router->pathFor('character', ['id' => $p->id]);TODO
            $tab['characters'][]=[
                'character' => [
                    'id' => $p->id,
                    'name' => $p->name
                ],
                'links' => ['self' => ['href' => $link]]
            ];
        }

        $response->withHeader('Content-Type', 'application/json');

        return $response->withJson($tab);
    }

    public function postGameComments(Request $request, Response $response, array $args){
        filter_var($request->getParsedBody())
    }
}