<?php


namespace bd\models;


use Illuminate\Database\Eloquent\Model;

class Annonce extends Model
{
    protected $table = 'annonce';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function photos() {
        return $this->hasMany ("model\Photo", "id_annonce");
    }

    public function categories() {
        return $this->belongsToMany ("model\Categorie", "appartenanceCategorieAnnonce", "annonce_id", "categorie_id");
    }

}