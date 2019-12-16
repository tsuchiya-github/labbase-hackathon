<?php

namespace App;

use Illuminate\database\Eloquent\Model;

class Tag extends Model
{
    protected $table = "tag";

    protected $guarded = ['_token'];

    public $timestamps = false;
}
