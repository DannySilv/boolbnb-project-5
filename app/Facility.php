<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $table = 'facilities';
    public function accomodations()
    {
        return $this->belongsToMany('App\Accomodation');
    }
}
