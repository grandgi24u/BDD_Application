<?php


namespace bd\models;


class Users extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'users';
    protected $primaryKey = 'email';
    public $incrementing = false;
    public $keyType = "string";
    public $timestamps = false;

    public function commentaires () {
        return $this->hasMany("bd\models\Commentary", "user_id","id");
    }

}