<?php

namespace bd\models;

class Game extends \Illuminate\Database\Eloquent\Model
{

    protected $table = 'game';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function characters() {
        return $this->belongsToMany ("bd\models\Character", "game2character", "game_id", "character_id");
    }

    public function rating() {
        return $this->belongsToMany ("bd\models\Game_rating", "game2rating", "game_id", "rating_id");
    }

    public function company_publishers() {
        return $this->belongsToMany ("bd\models\Company", "game_publishers", "game_id", "comp_id");
    }

    public function platforms() {
        return $this->belongsToMany ("bd\models\Platform", "game2platform", "game_id", "platform_id");
    }


}