<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Accomodation extends Model
{
    protected $table = 'accomodations';
    protected $fillable = [
        'name',
        'slug',
        'description',
        'n_rooms',
        'n_beds',
        'n_bathrooms',
        'size_sqm',
        'address',
        'latitude',
        'longitude',
        'image',
        'is_visible'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public static function generatePostSlug($name)
    {
        $base_slug = Str::slug($name, '-');
        $slug = $base_slug;
        $count = 1;
        $accomodation_found = Accomodation::where('slug', '=', $slug)->first();
        while ($accomodation_found) {
            $slug = $base_slug . '-' . $count;
            $accomodation_found = Accomodation::where('slug', '=', $slug)->first();
            $count++;
        }

        return $slug;
    }
}
