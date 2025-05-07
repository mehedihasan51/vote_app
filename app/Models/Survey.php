<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Survey extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = [];

    public function opinions()
    {
        return $this->hasMany(SurveyOpinion::class);
    }
}
