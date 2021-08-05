<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ruc extends Model
{
    protected $fillable = ['ruc', 'name', 'state', 'condition_', 'ubigeo', 'type_way', 'name_way', 'zone_code', 'type_zone', 'number', 'inside', 'lot', 'department', 'block', 'km'];
}
