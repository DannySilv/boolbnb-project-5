<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Accomodation extends Model
{

    use SoftDeletes;

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
        'is_visible',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function facilities()
    {
        return $this->belongsToMany('App\Facility');
    }

    public function messages()
    {
        return $this->hasMany('App\Message');
    }

    public function sponsor_plans() {
        return $this->belongsToMany('App\SponsorPlan')->withPivot(['creating_date','expiring_date']);
    }

    public static function generateAccomodationSlug($name)
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
