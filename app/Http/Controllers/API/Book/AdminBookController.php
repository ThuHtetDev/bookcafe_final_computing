<?php

namespace App\Http\Controllers\API\Book;

use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Http\Resources\RentBookResource;
use App\Http\Resources\RentBookResourceCollection;
use App\User;
use Validator;
use App\Book;
use App\RentBook;
use DB;
use Auth;

class AdminBookController extends BaseController
{
    // Member List
    public function memberlist(Request $request){
        $members = User::where('type','member')->get();
        return $this->sendRequest($members);
    }

    // Admin List
    public function adminlist(){
        $admins = User::where('type','admin')->get();
        return $this->sendRequest($admins);
    }

    // Save New Member
    public function saveMember(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:255',
            'email' => 'required|unique:users',
            'password' => 'required'
        ]);
        if($validator->fails()){
            return $this->errorRequest($validator->errors(),"required_err");
        }

       $newuser = new User();
       $newuser->name = $request['name'];
       $newuser->email = $request['email'];
       $newuser->password = \Hash::make($request['password']);
       $newuser->type = "member";
       $newuser->save();
       \CreatePath::createStoragePath($newuser->id);

       $output = [
           'message' => trans('api_common.registered'),
       ];
       return $this->sendRequest($output);
    }

    // Save New Admin
    public function saveAdmin(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:255',
            'email' => 'required|unique:users',
            'password' => 'required'
        ]);
        if($validator->fails()){
            return $this->errorRequest($validator->errors(),"required_err");
        }
        $newadmin = new User();
        $newadmin->name = $request['name'];
        $newadmin->email = $request['email'];
        $newadmin->password = \Hash::make($request['password']);
        $newadmin->type = $request['type'];
        $newadmin->save();
        $output = [
            'message' => trans('api_common.registered'),
        ];
        return $this->sendRequest($output);
    }

    // View Pending Request Books
    public function pendingRequest(){
        $bookModel = new Book();
        $bookRequest = $bookModel->onlyPendingBooks()->get();
        $books = [];
        foreach($bookRequest as $book){
            $book['category'] = $book->category->getAttributes();
            $books[] = $book->getAttributes();
        }
        return $this->sendRequest($books);
    }

    // Publish book
    public function publishBook(Request $request){
        $publishId = $request->id;
        $publishBook = Book::find($publishId);
        if(!$publishBook){
            return $this->errorRequest(trans('api_common.notFound'),"not_found");
        }
        if($publishBook->status != 'pending'){
            return $this->errorRequest(trans('api_common.alreadyPublished'),"already published");
        }
        $publishBook->status = "publish";
        $publishBook->publish_user_id = Auth::user()->id;
        $publishBook->save();
        return $this->sendRequest($publishBook);
    }
    
    // return approval
    public function returnApproval(Request $request){
        $findReturnBook = RentBook::find($request->id);
        if(!$findReturnBook){
            return $this->errorRequest(trans('api_common.notFound'),"not_found");
        }
        $result = $findReturnBook->onlyMemberReturnBooksApprove();
        if(!$result){
            return $this->errorRequest(trans('api_common.invalidList'),"invalid");
        }
        return $this->sendRequest($result);
    }

    // current rent list
    public function currentRentList(){
       $rentModel = new RentBook;
       $currentRentBook = $rentModel->onlyCurrentRentBooks();
        return $this->sendRequest(new RentBookResourceCollection(RentBookResource::collection($currentRentBook)));
    }

    // overdate rent list
    public function overDateRentList(){
        $rentModel = new RentBook;
        $overdateRentBooks = $rentModel->overDateRentBooksList()->get();
        return $this->sendRequest(new RentBookResourceCollection(RentBookResource::collection($overdateRentBooks)));
    }

    // New Rent Request List
    public function rentRequestList(){
        $rentModel = new RentBook;
        $result = $rentModel->getRentRequestList();
        if(is_null($result)) return $this->errorRequest(trans('api_common.notFound'),"not_exist");
        return $this->sendRequest($result);
    }

    // Rent Request Confirm
    public function rentRequestConfirm(Request $request){
        $rentBook = RentBook::find($request['id']);
        if(is_null($rentBook)) return $this->errorRequest(trans('api_common.notFound'),"not_found");
        $rentBook->rent_status = 'confirm';
        $rentBook->save();
        return $this->sendRequest($rentBook);
    }

    // Rented List (admin approve)
    public function rentedList(){
        $rentModel = new RentBook;
        $rented = $rentModel->getAllRentedList()->get();
        if(!count($rented) > 0) return $this->errorRequest(trans('api_common.notFound'),"not_found");
        return $this->sendRequest(new RentBookResourceCollection(RentBookResource::collection($rented)));
    }

    // Return Books
    public function returnBooks(){
        $rentModel = new RentBook;
        $returnBooks = $rentModel->onlyReturnBooks()->get();
        if(!count($returnBooks) > 0) return $this->errorRequest(trans('api_common.notFound'),"not_found");
        return $this->sendRequest(new RentBookResourceCollection(RentBookResource::collection($returnBooks)));
    }
}
