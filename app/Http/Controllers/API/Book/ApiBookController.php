<?php

namespace App\Http\Controllers\API\Book;

use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Http\Resources\BookResource;
use App\Http\Resources\DetailResource;
use App\Http\Resources\BookResourceCollection;
use App\Book;
use App\RentBook;
use Auth;
use DB;
use Carbon\Carbon;
use Validator;

class ApiBookController extends BaseController
{
    // My Book List
    public function myBookList(){
        $authBookList = Book::where('user_id',Auth::user()->id)->get();
        $authBookList->map(function ($a) {
            $a['type'] = 'mybooklist';
            return $a;
        });
        return $this->sendRequest(new BookResourceCollection(BookResource::collection($authBookList)));
    }

    // @ Book List
    public function bookList(Request $request){
    	$id = $request->get('id');
        $bookList =  Book::where('is_reject','0')
        					->where('is_cancel','0');
        if(!is_null($id)){
        	$bookList = $bookList->where('id', '<', $id);
        }
        $bookList = $bookList->orderBy('id', 'desc')->take(4)->get();
        $bookList->map(function ($a) {
            $a['type'] = 'booklist';
            return $a;
        });
        return $this->sendRequest(new BookResourceCollection(BookResource::collection($bookList)));
    }

    // @ Book List Detail
    public function BookDetail(Request $request){
        $bookDetail = Book::find($request->id);
        if(is_null($bookDetail)){
            return response()->json(['message' => trans('api_common.notFound')]);
        }
        return $this->sendRequest(new DetailResource($bookDetail));
    }

    // @ My Current Rent Books
    public function myRentList(){
        $authUser = Auth::user()->id;
        $MyCurrentRent = RentBook::where('user_id',$authUser)->where('rent_status','confirm')->where('has_return','0')->orderBy('created_at', 'desc')->get();
        if(!count($MyCurrentRent) > 0){
            return response()->json([], 200);
        }
        $MyCurrentRent->map(function ($a) {
            $a['type'] = 'myrentlist';
            return $a;
        });
        return  $this->sendRequest(new BookResourceCollection(BookResource::collection($MyCurrentRent)));
    }

    // @ Best 10 Rent List
    public function bestRentList(Request $request){
        $bestRentBooks =  Book::join('rent_books', 'rent_books.book_id', '=', 'books.id')
                        ->select('books.*', DB::raw('count(book_id) as count'))
                        ->where('return_approve','1')
                        ->orderBy('count','desc')
                        ->groupBy('id')
                        ->get();

        $bestRentBooks->map(function ($a) {
            $a['type'] = 'bestrentbooks';
            return $a;
        });
        return $this->sendRequest(new BookResourceCollection(BookResource::collection($bestRentBooks)));
    }

      // @ Save Request Book By Member
    public function memberSaveBook(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'desc' => 'required',
            'category' => 'required',
            'front_img' => 'required|file|image',
            'back_img' => 'required|file|image',
        ]);
        if($validator->fails()){
            return $this->errorRequest($validator->errors(),"required_err");
        }

        $front_img = $request->file('front_img');
        $frontFileName =$front_img->getClientOriginalName();
        $frontFileSize = $front_img->getClientSize();
        $front_img->storeAs('public/user_'.Auth::user()->id.'/book/front_cover/',$frontFileName);

        $back_img = $request->file('back_img');
        $backFileName =$back_img->getClientOriginalName();
        $backFileSize = $back_img->getClientSize();
        $back_img->storeAs('public/user_'.Auth::user()->id.'/book/back_cover/',$backFileName);

        $createBook = new Book;
        $createBook->isbn = mt_rand(10000000,99999999);
        $createBook->name = $request->name;
        $createBook->description = $request->desc;
        $createBook->user_id = Auth::user()->id;
        $createBook->front_cover = $frontFileName;
        $createBook->back_cover = $backFileName;
        $createBook->category_id = $request->category;
        $createBook->save();

        return  $this->sendRequest(['message' => trans('api_common.registered')]);
    }

    // @ Rent Book
    public function rentRequest(Request $request){
        // ! request include => rentbookId,startDate,endDate
        $rentRequestBook = Book::find($request['bookId']);

        if(!$rentRequestBook){
            return $this->errorRequest( trans('api_common.notFound'),"not_found");
        }

        $startDate = str_replace("-", "", Carbon::parse($request->start_date)->format('Y-m-d'));
        $endDate =  str_replace("-", "", Carbon::parse($request->return_date)->format('Y-m-d'));

        $bookModel = new Book;
        $getAvailable = $bookModel->calculateRentDateAvailable($request['bookId'], $startDate, $endDate); //Check Rent Request Date is available

        if($getAvailable != true){
            return $this->errorRequest( trans('api_common.someoneRentFirst'),"not_available");
        }

        $rentBook = new RentBook;
        $rentBook->user_id = Auth::user()->id;
        $rentBook->book_id =  $rentRequestBook->id;
        $rentBook->start_date  = $startDate;
        $rentBook->return_date = $endDate;
        $rentBook->save();
        return $this->sendRequest(['message' => trans('api_common.rentRegisterd')]);
    }

    // @ Return Book
    public function returnBook(Request $request){
        $findBook = RentBook::find($request->id);
        if(!$findBook){
            return $this->errorRequest(trans('api_common.notFound'),"not_found");
        }
        $returnBook = $findBook->hasNotReturnBooks();
        if(!$returnBook){
            return $this->errorRequest(trans('api_common.invalidList'),"invalid");
        }
        return $this->sendRequest(['message' => trans('api_common.returnBook')]);
    }
}
