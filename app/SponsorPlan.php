<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SponsorPlan extends Model
{
    protected $table = 'sponsor_plans';
    protected $fillable = [
        'name',
        'price',
        'number_of_hours'
    ];
}
