<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Focus extends Model
{
    protected $guarded = [];

    public function profiles()
    {
        return $this->belongsToMany(Profile::class);
    }
}
