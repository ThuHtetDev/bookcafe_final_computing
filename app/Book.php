<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'books';

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function category()
    {
        return $this->belongsTo('App\Category');
    }
    public function bookimages()
    {
        return $this->hasMany('App\BookImage');
    }
    public function rentBooks()
    {
        return $this->hasMany('App\RentBook');
    }

    public function onlyPendingBooks(){
        return $this->where('status','pending')->where('is_reject','0')->where('is_cancel','0')->orderBy('created_at','desc');
    }

    public function calculateRentDateAvailable($bookId,$sdate,$edate){
        $rentBooks = \App\RentBook::where('book_id',$bookId)->get();
        $isAvailable  = true;
        foreach($rentBooks as $rb){
            $existStartDate = str_replace("-", "", \Carbon\Carbon::parse($rb->start_date)->format('Y-m-d'));
            $existEndDate = str_replace("-", "", \Carbon\Carbon::parse($rb->return_date)->format('Y-m-d'));
            if(($sdate < $existStartDate && $edate < $existStartDate) || ($sdate > $existEndDate && $edate > $existEndDate)){
               // In this condition, request start and end date is available
            }else{
                $isAvailable = false;
            }
        }
        return $isAvailable;
    }
}
