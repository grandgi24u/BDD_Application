<?php

namespace bd\models;

class Character extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'character';
    protected $primaryKey = 'id';
    public $timestamps = false;

}