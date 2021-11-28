<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RentBook extends Model
{
    protected $table = 'rent_books';

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function book()
    {
        return $this->belongsTo('App\Book');
    }
    public function rentRatings()
    {
        return $this->hasOne('App\RentRating');
    }

    public function authRentBooks(){
        return $this->where('user_id',\Auth::user()->id);
    }

    public function hasNotReturnBooks(){
        if($this->has_return == "0" && $this->rent_status == "confirm"){
            $this->has_return = '1';
            $this->real_return_date = \Carbon\Carbon::now()->format('Y-m-d');
            $this->save();
            return true;
        }
        return false;
     
    }

    // @ only member return books
    public function onlyMemberReturnBooksApprove(){
        if($this->has_return == '1'){
            $this->return_approve = '1';
            $this->save();
            return true;
        }
        return false;
    }

    // @ only current rent book
    public function onlyCurrentRentBooks(){
        return \App\RentBook::where('rent_status','confirm')->where('has_return','0')->orderBy('created_at', 'desc')->get();
    }

    // @ only return book
    public function onlyReturnBooks(){
        return \App\RentBook::where('rent_status','confirm')->where('has_return','1')->where('return_approve','0')->orderBy('created_at', 'desc');
    }

    // @ rented book list detail
    public function rentedBooksList($bookId){
        return \App\RentBook::where('book_id',$bookId)->where('return_approve','1');
    }

    // @ rented book list all
    public function getAllRentedList(){
       return \App\RentBook::where('return_approve','1');
    }

    // @ OverDate current rent book list
    public function overDateRentBooksList(){
      return \App\RentBook::where('rent_status','confirm')->where('has_return','0')->where('return_date','<', \Carbon\Carbon::now()->toDateString());
    }

    // @ Rent Request Book List
    public function getRentRequestList(){
        $rentRequest = \App\RentBook::where('rent_status','queue')->where('has_return','0')->orderBy('start_date', 'asc')->get();
        if(!count($rentRequest) > 0) return null;
        $groupByBook = $rentRequest->groupBy('book_id');
        return $groupByBook;
    }

}
