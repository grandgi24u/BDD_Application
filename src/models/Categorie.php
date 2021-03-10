<?php


namespace bd\models;


class Categorie extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'company';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function annonces() {
        return $this->belongsToMany ("model\Annonce", "appartenanceCategorieAnnonce", "categorie_id", "annonce_id");
    }

}