<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventRegister extends Model
{
    protected $guarded = [];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
