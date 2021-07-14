<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ubigeo extends Model
{
    protected $fillable = ['code', 'department', 'province', 'district', 'capital'];
}
