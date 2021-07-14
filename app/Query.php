<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Query extends Model
{
    protected $fillable = ['queries', 'type', 'code_id'];

    public function code() {
        return $this->belongsTo(Code::class);
    }
}
