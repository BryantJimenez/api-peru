<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dni extends Model
{
    protected $fillable = ['dni', 'name', 'first_lastname', 'second_lastname'];
}
