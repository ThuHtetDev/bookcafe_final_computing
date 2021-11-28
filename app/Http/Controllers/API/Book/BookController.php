<?php

namespace App\Http\Controllers\API\Book;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Book;
use App\User;
use App\Category;
use Auth;
use App\RentBook;
use DB;
use Carbon\Carbon;

class BookController extends Controller
{
    // @ My Book List
    // public function myBookList(){
    //     $authBookList = Book::where('user_id',Auth::user()->id)->get();
    //     $books = [];
    //     foreach($authBookList as $book){
    //         $countRent = RentBook::where('book_id',$book->id)->where('rent_status','confirm')->where('has_return','1')->get();
    //         $books[] = [
    //             'id' => (string) $book->id,
    //             'isbn' => $book->isbn,
    //             'name' => $book->name,
    //             'categoryName' => $book['category']["name"],
    //             'categoryId' => (string) $book['category']["id"],
    //             'cover' => "http://book-cafe.sitetastingmyanmar.com/storage/user_". Auth::user()->id."/book/front_cover/front_small_".substr($book->front_cover, strpos($book->front_cover, "_") + 1),
    //             'rentCount' => (string) count($countRent),
    //             'starCount' => '0',
    //             'status' => $book->status,
    //             'uploadDate' => [
    //                 'date' => Carbon::parse($book->created_at)->format('Y-m-d'),
    //                 'since' => $book->created_at->diffForHumans()
    //             ],
    //             'isAvailable' => $book->is_available == '1' ? '1' : '0'
    //         ];
    //     }
    //     return response()->json($books,200);
    // }

    // @  Book List Detail
    // public function BookDetail(Request $request){
    //     $bookDetail = Book::find($request->id);
    //     if(is_null($bookDetail)){
    //         return response()->json(['message' => 'Page Not Found']);
    //     }
    //     $countRent = RentBook::where('book_id',$bookDetail->id)->where('rent_status','confirm')->where('has_return','1')->get();
    //     $rentLists = $bookDetail->rentBooks;
    //     $rentListsArray = $rentLists->where('rent_status','confirm')->where('has_return','0')->toArray();
    //     $isRentByMe = false;
    //     foreach($rentListsArray as $rent){
    //         if($rent['user_id'] == Auth::user()->id){
    //             $isRentByMe = true;
    //         }
    //     }
    //     $inRentedCountByOther = $rentLists->where('has_return','0')->where('rent_status','confirm')->where('user_id','!=',Auth::user()->id)->count();
    //     $details = [];
    //     $details = [
    //         'id' => (string) $bookDetail->id,
    //         'isbn' => $bookDetail->isbn,
    //         'cover' => [
    //             [
    //                 'path' => "http://book-cafe.sitetastingmyanmar.com/storage/user_". $bookDetail->user_id."/book/front_cover/".$bookDetail->front_cover,
    //                 'preview' => "http://book-cafe.sitetastingmyanmar.com/storage/user_". $bookDetail->user_id."/book/front_cover/front_small_".substr($bookDetail->front_cover, strpos($bookDetail->front_cover, "_") + 1),
    //                 'name' => 'Front Cover'
    //             ],
    //             [
    //                 'path' => "http://book-cafe.sitetastingmyanmar.com/storage/user_". $bookDetail->user_id."/book/back_cover/".$bookDetail->back_cover,
    //                 'preview' => "http://book-cafe.sitetastingmyanmar.com/storage/user_". $bookDetail->user_id."/book/back_cover/back_small_".substr($bookDetail->back_cover, strpos($bookDetail->back_cover, "_") + 1),
    //                 'name' => 'Back Cover'
    //             ],
    //         ],
    //         'name' => $bookDetail->name,
    //         'description' => $bookDetail->description,
    //         'categoryName' => $bookDetail->category->name,
    //         'categoryId' => (string) $bookDetail->category->id,
    //         'rentCount' => (string) count($countRent),
    //         'starCount' => '0',
    //         'status' => $bookDetail->status,
    //         'isInRent' => $isRentByMe == true ? '1' : '0',
    //         'isOwner' => $bookDetail->user_id == Auth::user()->id ? '1' : '0',
    //         'isRentBook' => $inRentedCountByOther > 0 ? '1' : '0',
    //         'isAvailable' => $bookDetail->is_available == '1' ? '1' : '0'
    //     ];
    //     return response()->json($details,200);
    // }

    // public function bookList(Request $request){
    // 	$id = $request->get('id');
    //     $bookList =  Book::where('is_reject','0')
    //     					->where('is_cancel','0');
    //     if(!is_null($id)){
    //     	$bookList = $bookList->where('id', '<', $id);
    //     }
    //     $bookList = $bookList->orderBy('id', 'desc')->take(4)->get();
    //     $list = [];
    //     foreach($bookList as $book){
    //         $countRent = RentBook::where('book_id',$book->id)
    //                                 ->where('rent_status','confirm')
    //                                 ->where('has_return','1')
    //                                 ->get();
    //         $list[] = [
    //             'id' => (string) $book->id,
    //             'isbn' => $book->isbn,
    //             'name' => $book->name,
    //             'categoryName' => $book->category->name,
    //             'categoryId' => (string) $book->category->id,
    //             'cover' =>  "http://book-cafe.sitetastingmyanmar.com/storage/user_". $book->user_id."/book/front_cover/front_small_".substr($book->front_cover, strpos($book->front_cover, "_") + 1),
    //             'rentCount' => (string) count($countRent),
    //             'starCount' => '0',
    //             'status' => $book->status,
    //             'uploadDate' => [
    //                 'date' => Carbon::parse($book->created_at)->format('Y-m-d'),
    //                 'since' => $book->created_at->diffForHumans()
    //             ],
    //             'isAvailable' => $book->is_available == '1' ? '1' : '0'
    //         ];
    //     }

    //     return response($list, 200);
    // }

    // @ My Current Rent Books
    // public function myRentList(){
    //     $authUser = Auth::user()->id;
    //     $MyCurrentRent = RentBook::where('user_id',$authUser)->where('rent_status','confirm')->where('has_return','0')->orderBy('created_at', 'desc')->get();

    //     $rentInfos = [];
    //     if(!count($MyCurrentRent) > 0){
    //         return response()->json([], 200);
    //     }
    //     foreach($MyCurrentRent as $rentBook){
    //         $countRent = RentBook::where('book_id',$rentBook->book_id)->where('rent_status','confirm')->where('has_return','1')->get();
    //         $countStatus = RentBook::where('book_id',$rentBook->book_id)->get();
    //         if($rentBook->rent_status == 'confirm'){
    //             $status = "in_rent";
    //         }else if($rentBook->rent_status == 'queue'){
    //             $status = "in_queue";
    //         }else if($rentBook->rent_status == 'reject'){
    //             $status = "reject_by_admin";
    //         }else{
    //             $status = "cancel_book";
    //         }
    //         $rentInfos[] = [
    //                 'id' => (string) $rentBook->book->id,
    //                 'isbn' => $rentBook->book->isbn,
    //                 'name' => $rentBook->book->name,
    //                 'categoryName' => $rentBook->book->category->name,
    //                 'categoryId' => (string) $rentBook->book->category->id,
    //                 'cover' => "http://book-cafe.sitetastingmyanmar.com/storage/user_". $rentBook->book->user_id ."/book/front_cover/front_small_".substr($rentBook->book->front_cover, strpos($rentBook->book->front_cover, "_") + 1),
    //                 'rentCount' => (string) count($countRent),
    //                 'starCount' => '0',
    //                 'status' =>  $status,
    //                 'uploadDate' => [
    //                     'date' => Carbon::parse($rentBook->created_at)->format('Y-m-d'),
    //                     'since' => $rentBook->created_at->diffForHumans()
    //                 ],
    //                 'isAvailable' => $rentBook->book->is_available == '1' ? '1' : '0'
    //         ];
    //     }
    //     return response()->json($rentInfos,200);
    // }

    // @ Best 10 rent list
    // public function bestRentList(Request $request){
    //     $pagination = $request->pagination - 1;
    //     $maxRentedBook = DB::table('books')
    //                                 ->join('rent_books','books.id','=','rent_books.book_id')
    //                                 ->select(DB::raw('count(book_id) as count'),'books.*')
    //                                 ->groupBy('id')
    //                                 ->orderBy('count','desc')
    //                                 ->take(10)
    //                                 ->get();

    //     $list = [];
    //     foreach($maxRentedBook->toArray() as $book){
    //         $bookCatId = Book::where('id',$book->id)->first()->category_id;
    //         $catId = Category::where('id',$bookCatId)->first()->id;
    //         $catName = Category::where('id',$bookCatId)->first()->name;

    //         $list[] = [
    //             'id' => (string) $book->id,
    //             'isbn' => $book->isbn,
    //             'name' => $book->name,
    //             'categoryName' => $catName,
    //             'categoryId' => (string)  $catId,
    //             'cover' =>  "http://book-cafe.sitetastingmyanmar.com/storage/user_". $book->user_id."/book/front_cover/front_small_".substr($book->front_cover, strpos($book->front_cover, "_") + 1),
    //             'rentCount' => (string) $book->count,
    //             'starCount' => '0',
    //             'status' => (string) $book->status,
    //             'uploadDate' => [
    //                 'date' => Carbon::parse($book->created_at)->format('Y-m-d'),
    //                 'since' => Carbon::parse($book->created_at)->diffForHumans()
    //             ],
    //             'isAvailable' => $book->is_available == '1' ? '1' : '0'
    //         ];
    //     }

    //      return response($list,200);
       // if(!is_null($maxRentedBook)){
       //      $segments = array_chunk($maxRentedBook->toArray(), 4);
       //      if($request->pagination == ''){
       //          if(isset($segments[0])) return response($segments[0],200);
       //          return response([],200);
       //      }
       //      if(isset($segments[$pagination])){
       //          return response($segments[$pagination],200);
       //      }else{
       //          $segmentsNull = [];
       //          return response($segmentsNull,200);
       //      }
       // }
    // }

}
