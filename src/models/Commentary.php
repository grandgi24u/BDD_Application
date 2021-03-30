<?php


namespace bd\models;


class Commentary extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'commentary';
    protected $primaryKey = 'id';
    public $timestamps = true;
}