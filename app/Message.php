<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = "messages";
    protected $fillable = [
        'user_name',
        'user_surname',
        'email',
        'message_text',
        'accomodation_id',
    ];

    public function accomodation()
    {
        return $this->belongsTo('App\Accomodation');
    }
}
