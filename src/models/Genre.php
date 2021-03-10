<?php


namespace bd\models;


class Genre extends \Illuminate\Database\Eloquent\Model
{

    protected $table = 'genre';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function games(){
        return $this->belongsToMany ("bd\models\Game", "game2genre", "genre_id", 'game_id');
    }

}