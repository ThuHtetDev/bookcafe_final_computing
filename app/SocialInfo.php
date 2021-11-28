<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialInfo extends Model
{
    protected $table='social_info';

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
