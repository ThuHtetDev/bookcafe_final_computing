<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RentRating extends Model
{
    protected $table = 'rent_rating';

    public function rentRatingBook()
    {
        return $this->belongsTo('App\RentBook');
    }

}
