<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Book;
use Auth;
use App\User;
use App\BookImage;
use Carbon\Carbon;
use App\RentBook;
use App\Category;
use DB;
use Image;
use App\RentRating;

class BookController extends Controller
{
    // @ Save Request Book By Member
    public function memberSaveBook(Request $request){
        $datas = json_decode($request['data']);

        $front_image = str_replace('data:image/png;base64,', '', $request['front_file']);
        $front_image = str_replace(' ', '+', $front_image);
        $front_file_name = 'front_'.time().'.png';

        $front_image_small = str_replace('data:image/png;base64,', '', $request['front_small']);
        $front_image_small = str_replace(' ', '+', $front_image_small);
        $front_file_name_small = 'front_small_'.time().'.png';

        if($front_image != "" && $front_image_small != "" ){
            \Storage::disk('public')->put('user_'.Auth::user()->id.'/book/front_cover/'.$front_file_name,base64_decode($front_image));
            \Storage::disk('public')->put('user_'.Auth::user()->id.'/book/front_cover/'.$front_file_name_small,base64_decode($front_image_small));
        }

        $back_image = str_replace('data:image/png;base64,', '', $request['back_file']);
        $back_image = str_replace(' ', '+', $back_image);
        $back_file_name = 'back_'.time().'.png';

        $back_image_small = str_replace('data:image/png;base64,', '', $request['back_small']);
        $back_image_small = str_replace(' ', '+', $back_image_small);
        $back_file_name_small = 'back_small_'.time().'.png';

        if($back_image!="" && $back_image_small != "" ){
            \Storage::disk('public')->put('user_'.Auth::user()->id.'/book/back_cover/'.$back_file_name,base64_decode($back_image));
            \Storage::disk('public')->put('user_'.Auth::user()->id.'/book/back_cover/'.$back_file_name_small,base64_decode($back_image_small));
        }
        $createBook = new Book;
        $createBook->isbn = mt_rand(10000000,99999999);
        $createBook->name = $datas->name;
        $createBook->description = $datas->desc;
        $createBook->user_id = Auth::user()->id;
        $createBook->front_cover = $front_file_name;
        $createBook->back_cover = $back_file_name;
        $createBook->category_id = $datas->category;
        $createBook->save();

        // $images = $request['images'];
        // foreach($images as $image){
        //     $fileName =$image->getClientOriginalName();
        //     $fileSize = $image->getClientSize();
        //     $image->storeAs('public/user_'.Auth::user()->id.'/book/inner_images/',$fileName);

        //     $newBookImage = new BookImage;
        //     $newBookImage->img_path = $fileName;
        //     $newBookImage->book_id = $createBook->id;
        //     $newBookImage->save();
        // }
        return response()->json(['message' => 'Registered Book is successfully sent to Admin']);
    }

    public function sendMail(){
        $to_name =  'thuhtettun';
        $to_email = 'thuhtettun.dev@gmail.com';
        $user_data = [
            'contributor_name' => 'jon',
            'student_name' => 'nnn',
            'email' => 'jon@gmail.com',
            'msg_inbox' => 'School Application',
            'title' => 'Student Contribution Request'
        ];
        \Mail::send('mails.send', $user_data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)->subject("Student Contribution Request");
            $message->from('thuchangetheworld03@gmail.com','no-reply');
        });
        // @ check for failures
        if (\Mail::failures()) {
            return response()->json(['message' => 'failed']);
        }
        return response()->json(['message' => 'success']);
    }

    // Member Edit Book
    public function memberEditBook(Request $request){
        $datas = json_decode($request['data']);

        $front_image = str_replace('data:image/png;base64,', '', $request['front_file']);
        $front_image = str_replace(' ', '+', $front_image);
        $front_file_name = 'front_'.time().'.png';

        $front_image_small = str_replace('data:image/png;base64,', '', $request['front_small']);
        $front_image_small = str_replace(' ', '+', $front_image_small);
        $front_file_name_small = 'front_small_'.time().'.png';

        if($front_image != "" && $front_image_small != "" ){
            \Storage::disk('public')->put('user_'.Auth::user()->id.'/book/front_cover/'.$front_file_name,base64_decode($front_image));
            \Storage::disk('public')->put('user_'.Auth::user()->id.'/book/front_cover/'.$front_file_name_small,base64_decode($front_image_small));
        }

        $back_image = str_replace('data:image/png;base64,', '', $request['back_file']);
        $back_image = str_replace(' ', '+', $back_image);
        $back_file_name = 'back_'.time().'.png';

        $back_image_small = str_replace('data:image/png;base64,', '', $request['back_small']);
        $back_image_small = str_replace(' ', '+', $back_image_small);
        $back_file_name_small = 'back_small_'.time().'.png';

        if($back_image!="" && $back_image_small != "" ){
            \Storage::disk('public')->put('user_'.Auth::user()->id.'/book/back_cover/'.$back_file_name,base64_decode($back_image));
            \Storage::disk('public')->put('user_'.Auth::user()->id.'/book/back_cover/'.$back_file_name_small,base64_decode($back_image_small));
        }

        $editBook = Book::find($datas->id);
        $editBook->name = $datas->name;
        $editBook->description = $datas->desc;
        $editBook->user_id = Auth::user()->id;
        $editBook->front_cover = $front_file_name;
        $editBook->back_cover = $back_file_name;
        $editBook->category_id = Category::where('name',$datas->category)->first()->id;
        $editBook->save();

        return response()->json(['message' => 'Book is successfully Edited']);
    }

    // @ Get Member Book Lists
    public function memberBookList(){
        $authBookList = Book::where('user_id',Auth::user()->id)->where('is_available','1')->orderBy('created_at','desc')->get();
        // $getAll = $authBookList->get();
        $books = [];
        foreach($authBookList  as $book){
            $book['category'] = $book->category->getAttributes();
            $books[] = $book->getAttributes();
        }
        return response()->json($authBookList);
    }

    // @ Get Member Request Book For Admin
    public function memberBookRequest(){
        $bookRequest = Book::where('status','pending')->where('is_reject','0')->where('is_cancel','0')->orderBy('created_at','desc')->get();
        $books = [];
        foreach($bookRequest as $book){
            $book['category'] = $book->category->getAttributes();
            $books[] = $book->getAttributes();
        }
        return response()->json($books);
    }

    // @ Get Detail Books For Admin
    public function bookDetail($id){
        $bookDetail = Book::find($id);
        if(is_null($bookDetail)){
            return response()->json(['message' => 'Page Not Found']);
        }
        $bookImages = $bookDetail->bookimages;
        $publishAdmin = null;
        if(!is_null($bookDetail->publish_user_id)){
            $publishAdmin = User::where('id',$bookDetail->publish_user_id)->first();
        }
        $output = [
            'bookDetail' => $bookDetail,
            'bookUser' => $bookDetail->user,
            'bookImages' => $bookImages,
            'bookCategory' => $bookDetail->category,
            'publishAdmin' => $publishAdmin
        ];
        return response()->json($output);
    }

    // @ Publish book By Admin
    public function publishBook(Request $request){
        $publishId = $request->id;
        $publishBook = Book::find($publishId);
        $publishBook->status = "publish";
        $publishBook->publish_user_id = Auth::user()->id;
        $publishBook->save();
        $output = [
            'success' => 'true',
            'publish_admin' => Auth::user()
        ];


        // send mail to book owner 
        $owner = User::find($publishBook->user_id);
        $msg = 'Your Book is successfully published on RoadMap Book Rental Platform';
        $title = 'Your Book ( '.$publishBook->name.' ) is live now';
        $subject = "Book Publishing Approvement";
        $this->sendMailNotiToOwner($owner,$publishBook,$msg,$title,$subject);

        return response()->json($output);
    }

    public function sendMailNotiToOwner($owner,$book,$msg,$title,$subject)
    {
        $to_name =  $owner->name;
        $to_email = $owner->email;
        $user_data = [
            'msg_inbox' => $msg,
            'title' => $title,
            'to_name' => $owner->name,
            'to_email' => $owner->email,
            'book_name' => $book->name
        ];
        
        \Mail::send('mails.send', $user_data, function($message) use ($to_name, $to_email,$subject) {
            $message->to($to_email, $to_name)->subject($subject);
            $message->from('thuchangetheworld03@gmail.com','no-reply');
        });
    }

    public function sendMailNotiToRenter($renter,$book,$msg,$title,$subject)
    {
        $to_name =  $renter->name;
        $to_email = $renter->email;
        $user_data = [
            'msg_inbox' => $msg,
            'title' => $title,
            'to_name' => $renter->name,
            'to_email' => $renter->email,
            'book_name' => $book->name
        ];
        
        \Mail::send('mails.send', $user_data, function($message) use ($to_name, $to_email,$subject) {
            $message->to($to_email, $to_name)->subject($subject);
            $message->from('thuchangetheworld03@gmail.com','no-reply');
        });
    }

    // @ Get  Books Lists with category/rent-list
    public function bookList(Request $request){
        $bookList =  Book::where('status','publish')->where('is_reject','0')->where('is_cancel','0')->where('is_available','1')->orderBy('updated_at', 'desc')->get();
        $books = [];
        $availableBooks = [];
        $unavailableBooks = [];
        foreach($bookList as $book){
            $book['category'] = $book->category->getAttributes();
            $book['rentList'] = $book->rentBooks;
                $book['checkIfBookIsAvailable'] = true;
                foreach($book['rentList'] as $rb){
                    if($rb->return_approve == '0'){
                        $book['checkIfBookIsAvailable'] = false;
                    }
                }
            $books[] = $book->getAttributes();
            if($book->checkIfBookIsAvailable == true){
                $availableBooks[] = $book->getAttributes();
            }else{
                $unavailableBooks[] =  $book->getAttributes();
            }
        }
        if($request->sort == 'available'){
            return response()->json($availableBooks);
        }else if($request->sort == 'no_available'){
            return response()->json($unavailableBooks);
        }
            return response()->json($books);
    }

    // @ Get Detail Books For Members
    public function memberBookDetail($id){
        $bookDetail = Book::find($id);
        if(is_null($bookDetail)){
            return response()->json(['message' => 'Page Not Found']);
        }
        $bookImages = $bookDetail->bookimages;
        $bookCategory =  $bookDetail->category;
        $rentLists = $bookDetail->rentBooks;
        return response()->json($bookDetail);
    }

    // @ Get Member Pending Books
    public function memberPendingList(){
        $pendingList = Book::where('status','pending')->where('user_id',Auth::user()->id)->where('is_reject','0')->where('is_cancel','0')->where('is_available','1')->orderBy('created_at','desc')->get();
        return response()->json($pendingList);
    }

    // @ Cancel Pending Book By Member
    public function memberPendingListCancel(Request $request){
        $cancelBook = Book::find($request['id']);
        $cancelBook->is_cancel = '1';
        $cancelBook->save();
        return response()->json($cancelBook);
    }

    // @ Take Back Member book
    public function memberPublishedBookRemove(Request $request){
        $cancelBook = Book::find($request['id']);
        $cancelBook->is_cancel = '1';
        $cancelBook->is_available = '0';
        $cancelBook->save();
        return response()->json(['success' => true],200);
    }

    // @ Reject Book By Admin
    public function rejectBook(Request $request){
        $rejectId = $request['id'];
        $rejectBook = Book::find($rejectId);
        $rejectBook->is_reject = '1';
        $rejectBook->save();
        return response()->json(['message' => $rejectBook->name .' is rejected']);
    }

    // @ Rent Request By member
    public function rentRequest(Request $request){
        $rentRequestBook = Book::find($request['bookId']);
        $start_date = Carbon::parse($request['start_date']);
        $return_date = Carbon::parse($request['return_date']);
        $rentBook = new RentBook;
        $rentBook->user_id = Auth::user()->id;
        $rentBook->book_id = $rentRequestBook->id;
        $rentBook->start_date =  $start_date;
        $rentBook->return_date =  $return_date;
        $rentBook->save();
        return response()->json(['message' => 'Rent Request Successfully']);
    }

    // @ Rent Request View By Admin
    public function checkRentList(){
        $rentRequest = RentBook::where('rent_status','queue')->where('has_return','0')->get();
        $groupedList = $rentRequest->groupBy('book_id');
        return response()->json($groupedList);
    }

    // @ Rent Request Sort By Admin
    public function RentListSort($id){
        $rentBookList = RentBook::where('book_id',$id)->where('rent_status','queue')->where('has_return','0')->orderBy('start_date', 'asc')->get();
        $rentInfos = [];
        foreach($rentBookList as $rentBook){
            $rentBook['about_member'] = $rentBook->user;
            $rentBook['about_book'] = $rentBook->book;
            $rentInfos[] = $rentBook;
        }
        return response()->json($rentInfos);
    }

    // @ Confirm Rent Request By Admin
    public function saveRent(Request $request){
        $rentBook = RentBook::find($request['id']);
        if($request['type'] == 'confirm'){
            $rentBook->rent_status = 'confirm';
            $rentBook->save();
            $output = [
                'success' => 'confirm',
                'message' => 'Confirmation is sent'
            ];

            // send mail to book renter (confirm) 
            $renter = User::find($rentBook->user_id);
            $msg = 'Your Rent Request is confirmed. You can get it due to rent date. Thank You';
            $book = Book::find($rentBook->book_id);
            $title = 'Your Rent Book ( '.$book->name.' ) is confirmed';
            $subject = "Book Renting Confirmation";
            $this->sendMailNotiToRenter($renter,$book,$msg,$title,$subject);

            // send mail to book renter (confirm) 
            $book = Book::find($rentBook->book_id);
            $renter = User::find($rentBook->user_id);

            $owner = User::find($book->user_id);
            $msg = 'Your Book will be in rent by '.$renter->name .'. He will direct contact to you soon. Please negotiate with him. Thank You';
           
            $title = 'Your Book ( '.$book->name.' ) is now in rent';
            $subject = "Book Renting In Rent";
            $this->sendMailNotiToOwner($owner,$book,$msg,$title,$subject);


            return response()->json($output);
        }else{
            $rentBook->rent_status = 'reject';
            $rentBook->save();
            $output = [
                'success' => 'confirm',
                'message' => 'Rejection is sent'
            ];

             // send mail to book renter (reject) 
            $renter = User::find($rentBook->user_id);
            $msg = 'Your Rent Request is unavailable for some reason. Admins are apologized for that case. You can find others awesome books on newsfeeed agian. Thank You';
            $book = Book::find($rentBook->book_id);
            $title = 'Your Rent Book ( '.$book->name.' ) is not available';
            $subject = "Book Renting Unavailable";
            $this->sendMailNotiToRenter($renter,$book,$msg,$title,$subject);

            return response()->json($output);
        }
    }


    // @ Member Own Queue List
    public function queueLists(){
        $authUser = Auth::user()->id;
        $MyQueueBookList = RentBook::where('user_id',$authUser)->where('has_return','0')->where('return_approve','0')->orderBy('created_at', 'desc')->get();
        
        $rentInfos = [];
        foreach($MyQueueBookList as $rentBook){
            $rentBook['about_book'] = $rentBook->book;
            $requestStartDate = str_replace("-", "", Carbon::parse($rentBook->start_date)->format('Y-m-d')) ;
            $today = str_replace("-", "", Carbon::now()->toDateString());
          
            if($today < $requestStartDate || $rentBook->rent_status == 'queue'){
                $rentInfos[] = $rentBook;
            }
        }

        return response()->json($rentInfos);
    }

    // @ Member Own Rent List
    public function rentLists(){
        $authUser = Auth::user()->id;
        $MyCurrentRent = RentBook::where('user_id',$authUser)->where('rent_status','confirm')->where('has_return','0')->orderBy('created_at', 'desc')->get();
        $rentInfos = [];
        foreach($MyCurrentRent as $rentBook){
            $rentBook['about_book'] = $rentBook->book;
            $requestStartDate = str_replace("-", " ", Carbon::parse($rentBook->start_date)->format('Y-m-d'));
            $today = str_replace("-", " ", Carbon::now()->toDateString());
            if($today >= $requestStartDate){
                $rentInfos[] = $rentBook;
            }
        }
        return response()->json($rentInfos);
    }

    // @ Member's Book Shop For Admin
    public function adminBookShop(){
       $members = User::where('type','member')->get();
       $bookInfo = [];
       foreach($members as $member){
        $member['ownBookCount'] = $member->books->where('is_available','1')->count();
        $bookInfo[] = $member;
       }
       return response()->json($bookInfo);
    }

    // @ Member's Book Shop Detail
    public function adminBookShopDetail($id){
        $detailMember = User::find($id);

        $ownBooks = Book::where('user_id',$detailMember->id)->where('is_available','1')->get();

        $data = [];
        $data['member'] = $detailMember;
        $data['isBookExist'] = count($ownBooks) > 0 ? true : false;
        $bookInfo = [];
        foreach($ownBooks as $book){
          $rentCount = RentBook::where('book_id',$book->id)->where('rent_status','confirm')->where('has_return','1')->where('return_approve','1')->count();
          $bookInfo[] = [
            'book' => $book,
            'rented' => $rentCount
          ];
        }
        array_push($data,$bookInfo);
        return response()->json($data);
    }

    // @ Member Return Book
    public function returnBook(Request $request){
        $returnBookId = $request->id;
        $returnBook = RentBook::where('id',$returnBookId)->where('has_return','0')->first();
        $returnBook->has_return = '1';
        $returnBook->real_return_date = Carbon::now()->format('Y-m-d');
        $returnBook->save();
        $result = [
            'success' => true,
            'message' => 'Thank You For Return Book'
        ];

        // send mail to book owner 
        $book = Book::find($returnBook->book_id);
        $renter = User::find($returnBook->user_id);
        $owner = User::find($book->user_id);
        $msg = 'Your Book is return from '.$renter->name.' on RoadMap Book Rental Platform';
        $title = 'Your Book ( '.$book->name.' ) is return from rent';
        $subject = "Book Return Notification";
        $this->sendMailNotiToOwner($owner,$book,$msg,$title,$subject);

        return response()->json($result,200);
    }

    // @ Check Return List By Admin
    public function returnList(){
        $returnBooks = RentBook::where('rent_status','confirm')->where('has_return','1')->orderBy('created_at', 'desc')->get();
        $returnInfos = [];
        foreach($returnBooks as $return){
            $book = $return->book;
            $user = $return->user;
            $returnInfos[] = $return;
        }
        return response()->json($returnInfos);
    }

    // @ Admin Approval For return book
    public function returnApproval(Request $request){
       $findReturnBook = RentBook::where('id',$request->id)->where('has_return','1')->first();
       $findReturnBook->return_approve = '1';
       $findReturnBook->save();

        // send mail to book owner 
        $book = Book::find($findReturnBook->book_id);
        $renter = User::find($findReturnBook->user_id);
        $owner = User::find($book->user_id);
        $msg = 'Your Book is approved previous rent from '.$renter->name.' on RoadMap Book Rental Platform';
        $title = 'Your Book ( '.$book->name.' ) return is approved by admin';
        $subject = "Book Return Approved Notification";
        $this->sendMailNotiToOwner($owner,$book,$msg,$title,$subject);

        // send mail to book renter 
        $msg = 'Your Return Rent Book from '.$owner->name.' is approved by Admin on RoadMap Book Rental Platform';
        $title = 'Your Return Rent Book ( '.$book->name.' ) is approved by admin';
        $subject = "Book Return Approved Notification";
        $this->sendMailNotiToRenter($renter,$book,$msg,$title,$subject);

       return response()->json(['success' => true],200);
    }

    // Rating Book From Member
    public function rateBook(Request $request){
        $existing = RentRating::where('rent_book_id',$request->bookId)->first();
        if(is_null($existing)){
            $newRate = new RentRating();
            $newRate->rent_book_id = $request->bookId;
            $newRate->rating_count = $request->rate;
            $newRate->save();

            // send mail to book owner 
            $book = Book::find($request->bookId);
            $owner = User::find($book->user_id);
            $msg = 'Your Book is return on RoadMap Book Rental Platform. Please contact to Admin if any mistake happened';
            $title = 'Your Book ( '.$book->name.' ) is return from rent';
            $subject = "Book Return Notification";
            $this->sendMailNotiToOwner($owner,$book,$msg,$title,$subject);

            return response()->json(['success'=>true,'message'=>'Thank You For Rating'],200);
        }
        $existing->rating_count = $request->rate;
        $existing->save();

        // send mail to book owner 
        $book = Book::find($request->bookId);
        $owner = User::find($book->user_id);
        $msg = 'Your Book is return on RoadMap Book Rental Platform. Please contact to Admin if any mistake happened';
        $title = 'Your Book ( '.$book->name.' ) is return from rent';
        $subject = "Book Return Notification";
        $this->sendMailNotiToOwner($owner,$book,$msg,$title,$subject);

        return response()->json(['success'=>true,'message'=>'Thank You For Your Memorable Kind'],200);
    }

    // @ Admin Dashboard
    public function adminDashboard(){
        $countAdmin    = User::where('type','!=','member')->count();
        $countMember   = User::where('type','member')->count();
        $countCategory = Category::count();
        $countPublishBook = Book::where('status','publish')->where('is_reject','0')->where('is_cancel','0')->where('is_available','1')->count();
        $countPendingBook = Book::where('status','pending')->where('is_reject','0')->where('is_cancel','0')->where('is_available','1')->count();
        $countAllBook = Book::where('is_reject','0')->where('is_cancel','0')->where('is_available','1')->count();
        $currentRent  = RentBook::where('rent_status','confirm')->where('has_return','0')->count();
        $queueRent    = RentBook::where('rent_status','queue')->where('has_return','0')->count();

        $maxUploadedBookUser = DB::table('users')
        ->join('books','users.id','=','books.user_id')
        ->where('status','publish')
        ->where('is_reject','0')
        ->where('is_cancel','0')
        ->where('is_available','1')
        ->select(DB::raw('count(user_id) as count'),'users.id','users.name')
        ->groupBy('id')
        ->orderBy('count','desc')
        ->take(4)
        ->get();

        $maxRentedBook = DB::table('books')
        ->join('rent_books','books.id','=','rent_books.book_id')
        ->where('has_return','1')
        ->where('real_return_date','!=',null)
        ->select(DB::raw('count(book_id) as count'),'books.id','books.name')
        ->groupBy('id')
        ->orderBy('count','desc')
        ->take(4)
        ->get();

        $maxRentedBookForThisMonth = DB::table('books')
        ->join('rent_books','books.id','=','rent_books.book_id')
        ->whereMonth('rent_books.start_date', '=', Carbon::now()->month)
        ->whereYear('rent_books.start_date', Carbon::now()->year)
        ->where('has_return','1')
        ->select(DB::raw('count(book_id) as count'),'books.id','books.name')
        ->groupBy('id')
        ->orderBy('count','desc')
        ->take(10)
        ->get();

        $maxRentedUser = DB::table('users')
        ->join('rent_books','users.id','=','rent_books.user_id')
        ->where('has_return','1')
        ->where('real_return_date','!=',null)
        ->select(DB::raw('count(user_id) as count'),'users.id','users.name')
        ->groupBy('id')
        ->orderBy('count','desc')
        ->take(4)
        ->get();

        $datas = [
         'current_admin_count' =>  $countAdmin,
         'current_member_count' =>  $countMember,
         'category_count' =>  $countCategory,
         'current_book_count' => $countAllBook,
         'publish_book_count' => $countPublishBook,
         'pending_book_count' => $countPendingBook,
         'current_rent_count' => $currentRent,
         'current_queue_count'=> $queueRent,
         'max_uploaded_bookuser' => $maxUploadedBookUser,
         'max_rented_book' => $maxRentedBook,
         'max_rented_user' => $maxRentedUser,
         'max_rented_book_this_month' => $maxRentedBookForThisMonth
        ];
        return response()->json($datas);
     }

     // @ Search Books
     public function searchBooks(Request $request){
        if(isset($request->keywords)){
            $search = $request->keywords;
            $results =  Book::where(function($query) use ($search){
                $query->where('name','LIKE',"%$search%");
            })->where('status','publish')->get();
        return response()->json($results);
        }
     }

     // Member Rented Book List
     public function myRentedList(){
        $rentBook = new RentBook;
        $RentedAuthBook = $rentBook->authRentBooks()->where('has_return','1')->get();
        $rentedList = [];
        foreach($RentedAuthBook as $rented){
            $rentedList[] = [
                'rentedBookId'   => $rented->id,
                'rentedBookName' => $rented->book->name,
                'rentedEndTime'  => $rented->real_return_date,
                'rating'         => $rented->rentRatings == null ? $rented->rentRatings :  $rented->rentRatings->rating_count,
                'admin_approval' => $rented->return_approve == '0' ? false : true
            ];
        }
        return response()->json($rentedList,200);
     }

     // @ Admin Show Member Current Rent List
     public function adminRentList(){
        $rentBooks = RentBook::where('rent_status','confirm')->where('has_return','0')->orderBy('created_at', 'desc')->get();
        $rentBookList = [];
        foreach($rentBooks as $rb){
            $rentBookList[] = [
                'rentBookISBN' => $rb->book->isbn,
                'rentBookName' => $rb->book->name,
                'rentMember'   => $rb->user->name,
                'startDate'    => $rb->start_date,
                'returnDate'   => $rb->return_date,
                'checkDate'    => Carbon::now()->toDateString() > Carbon::parse($rb->return_date)->format('Y-m-d') ? false : true
            ];
        }
        return response()->json($rentBookList,200);
     }

     // Member Book Edit
     public function bookEdit(Request $request){
       $editBook = Book::find($request->id);
       $editBook->category;
       $categories = Category::all();
       $data =[
           'editBook' => $editBook,
           'categories' => $categories
       ];
       return response()->json($data);
     }

     // Member Dashboard
     public function memberDashboard(){
        $authUser = Auth::user();
        $authBookAvailable = Book::where('user_id',Auth::user()->id)->where('is_available','1')->where('is_reject','0')->where('is_cancel','0');
        $myRentedList = RentBook::where('user_id',Auth::user()->id);
        $today = Carbon::now()->toDateString();

        // $maxRentedBookForThisMonth = DB::table('users')
        // ->join('rent_books','users.id','=','rent_books.user_id')
        // ->where('users.id','=',Auth::user()->id)
        // ->whereDay('rent_books.start_date', '=', $today)
        // ->whereYear('rent_books.start_date', Carbon::now()->year)
        // ->where('has_return','1')
        // ->select(DB::raw('count(book_id) as count'),'books.id','books.name')
        // ->groupBy('id')
        // ->orderBy('count','desc')
        // ->take(10)
        // ->get();

        // dd($myRentedList->where('rent_status','confirm')->where('return_date','>',$today)->count());
        $myOverDateBooks = $myRentedList->where('rent_status','confirm')->where('return_date','>',$today)->count();
        $myCurrentRentBooks = $myRentedList->where('rent_status','confirm')->where('start_date','<=',$today )->where('return_date','>=',$today)->where('real_return_date',null)->count();

       $data = [
        'name' => $authUser->name,
        'email' => $authUser->email,
        'app_lang' => $authUser->lang == 'mm' ? 'Myanmar' : 'English',
        'authBookPublished' => $authBookAvailable->where('status','publish')->count(),
        'authBookPending' => $authBookAvailable->where('status','pending')->count(),
        'myRentedBooks' => $myRentedList->where('has_return','1')->where('real_return_date','!=',null)->count(),
        'myRequestedBooks' => $myRentedList->where('rent_status','queue')->where('has_return','0')->count(),
        'myCurrentRentBooks' => $myCurrentRentBooks,
        'myOverDateBooks' =>  $myOverDateBooks,
        'myOverDatedCount' => $myRentedList->where('rent_status','confirm')->where('has_return','1')->where('real_return_date','!=',null)->where('return_date','<','real_return_date')->count(),
        
       ];
       return response()->json($data);
     }

}
