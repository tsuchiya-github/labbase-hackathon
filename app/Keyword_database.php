<?php

namespace App;

use Illuminate\database\Eloquent\Model;

class Keyword_database extends Model
{
    protected $table = "keyword_database";

    protected $guarded = ['_token'];

    public $timestamps = false;
}
