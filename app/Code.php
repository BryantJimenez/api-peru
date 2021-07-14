<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    protected $fillable = ['name', 'code', 'queries', 'limit', 'mac', 'state', 'user_id'];

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @param  string|null  $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where($field, $value)->firstOrFail();
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function inquiries() {
        return $this->hasMany(Query::class);
    }
}
