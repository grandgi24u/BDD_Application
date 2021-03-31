<?php


namespace bd\controller;

use bd\models\Character;
use bd\models\Commentary;
use bd\models\Game;
use bd\models\Platform;
use bd\models\Users;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use \Psr\Http\Message\ServerRequestInterface as Request;
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
            return $response->withJson(["erreur" => $e], 404);
        }

        $platf = $game->platforms;
        $rep=[];
        foreach ($platf as $p){
            $link=$this->container->router->pathFor('platformDescr', ['id' => $p->id]);
            $rep[] = [
                'platform' => array(
                    'id' => $p->id,
                    'name' => $p->name,
                    'alias' => $p->alias,
                    'abbreviation' => $p->abbreviation
                ),
                'links' => ['description' => ['href' => $link]]
            ];
        }

        return $response->withJson(
            array(
                'game' => array(
                    'id' => $game->id,
                    'name' => $game->name,
                    'alias' => $game->alias,
                    'deck' => $game->deck,
                    'description' => $game->description,
                    'original_release_date' => $game->original_release_date,
                    'platforms' => $rep
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

        $next = $num+1;
        $prev = $num-1;
        $link= $this->container->router->pathFor('games');

        if($prev < 0){
            return $response->withJson(array('games' => $tab, 'links' => [
                'next' => ['href' => "$link?page=" . $next ]
            ]));
        } else {
            return $response->withJson(array('games' => $tab, 'links' => [
                'prev' => ['href' => "$link?page=" .$prev ],
                'next' => ['href' => "$link?page=" . $next ]
            ]));
        }


    }

    public function gameComments(Request $request, Response $response, array $args){
        $comm=Commentary::where('game_id', '=', $args['id'])->get();

        $tab=[];
        foreach ($comm as $c){
            $tab[]=[
                'id' => $c->id,
                'title' => $c->titre,
                'text' => $c->contenu,
                'date_created' => $c->created_at->format('Y-m-d'),
                'name_user' => Users::where('id', '=', $c->user_id)->first()->nom
            ];
        }

        return $response->withJson(['comments' => $tab]);
    }

    public function platform(Request $request, Response $response, array $args){
        try {
            $platform=Platform::where('id', '=', $args['id'])->firstOrFail();
        }catch (ModelNotFoundException $e){
            return $response->withJson(["erreur" => $e], 404);
        }

        return array(
            'platform' => array(
                'id' => $platform->id,
                'name' => $platform->name,
                'alias' => $platform->alias,
                'abbreviation' => $platform->abbreviation
            )
        );

    }

    public function gameCharacters(Request $request, Response $response, array $args){
        $perso=Game::where('id', '=', $args['id'])->first()->characters;

        $tab['characters']=[];
        foreach ($perso as $p){
            $link = $this->container->router->pathFor('character', ['id' => $p->id]);
            $tab['characters'][]=[
                'character' => [
                    'id' => $p->id,
                    'name' => $p->name
                ],
                'links' => ['self' => ['href' => $link]]
            ];
        }

        return $response->withJson($tab);
    }

    public function postGameComments(Request $request, Response $response, array $args){
        try {
            $res = $request->getParsedBody();
            $comment = new Commentary();
            $comment->titre=filter_var($res['titre'], FILTER_SANITIZE_STRING);
            $comment->contenu=filter_var($res['contenu'], FILTER_SANITIZE_STRING);
            $comment->user_id=filter_var($res['user_id'],FILTER_SANITIZE_NUMBER_INT);
            $comment->game_id=filter_var($res['game_id'], FILTER_SANITIZE_NUMBER_INT);
            $comment->save();
        } catch (\Exception $e){
            return $response->withJson(['erreur' => $e], 500);
        }

        return $response->withJson($comment, 201)
            ->withHeader('Location', $this->container->router->pathFor('comments', ['id' => $comment->id]));
    }

    public function platformDescr(Request $request, Response $response, array $args){
        try {
            $p = Platform::where('id', '=', $args['id'])->firstOrFail();
        } catch (\Exception $e){
            return $response->withJson(["erreur" => $e], 404);
        }


        return $response->withJson(['description' => $p->description]);
    }

    public function character(Request $request, Response $response, array $args){
        try {
            $c = Character::where('id', '=', $args['id'])->firstOrFail();
        } catch (\Exception $e){
            return $response->withJson(["erreur" => $e], 404);
        }


        return $response->withJson(['character' => [
            'name' => $c->name,
            'alias' => $c->alias,
            'deck' => $c->deck
        ]]);
    }
}