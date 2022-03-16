<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mac extends Model
{
    protected $fillable = ['mac', 'code_id'];

    public function code() {
        return $this->belongsTo(Code::class);
    }
}
