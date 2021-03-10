<?php


namespace bd\models;


class Company extends \Illuminate\Database\Eloquent\Model
{

    protected $table = 'company';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function games() {
        return $this->belongsToMany ("bd\models\Game", "game_publishers", "comp_id", "game_id");
    }

}