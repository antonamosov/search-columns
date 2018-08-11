<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomColumn extends Model
{
    protected $fillable = [
        'name',
    ];
}
