<?php


namespace bd\models;


class Game_rating extends \Illuminate\Database\Eloquent\Model
{

    protected $table = 'game_rating';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function rating_board() {
        return $this->belongsTo("bd\models\Rating_board", "rating_board_id");
    }

}