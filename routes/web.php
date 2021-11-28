<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

    // Route::get('/', function () {
    //     return view('auth.login');
    // })->name('login');
    // Route::get('/test', function () {
    //     return view('test');
    // });
    // Route::get('/',function(){
    //     return view('layouts.main');
    // })->name('main');
    Route::get('register','Auth\RegisterController@redirectToLogin');
    Route::get('/home', 'HomeController@index')->name('home');
    Auth::routes([
        'register' => false, // Registration Routes...
        'reset' => false, // Password Reset Routes...
        'verify' => false, // Email Verification Routes...
    ]);
    //
    Route::get('/redirect', 'SocialAuthGoogleController@redirect');
    Route::get('/callback', 'SocialAuthGoogleController@callback');

  // LANGUAGE CHANGE SECTION
    Route::get('locale/{locale}', function($locale){
        Session::put('locale', $locale);
        if(\Auth::check()){
            if(\Auth::user()->lang != $locale){
                $user = \Auth::user();
                $user->lang = $locale;
                $user->save();
            }
        }
        return redirect()->back();
    })->name('locale');

  Route::group([ 'prefix' => '_bookcafe' ], function(){
        // @ Admin & SuperAdmin Permission
        Route::group([ 'middleware' => 'can:manage-administration' ], function(){
                Route::get('/memberlist','User\UserController@memberlist')->name('users.memberlist');
                Route::get('/adminlist','User\UserController@adminlist')->name('users.adminlist');
                Route::post('/member/save','User\UserController@saveMember')->name('member.save');
                Route::post('/member/save/social-account','User\UserController@saveSocialMember')->name('member.saveSocialAcc');
                Route::post('/admin/save','User\UserController@saveAdmin')->name('admin.save');
                Route::get('/','Admin\CategoryController@getCategory')->name('admin.getcategory');
                Route::post('/add','Admin\CategoryController@saveCategory')->name('admin.savecategory');
                Route::get('member/request','Book\BookController@memberBookRequest')->name('admin.bookrequest');
                Route::get('detail/{id}','Book\BookController@bookDetail')->name('admin.bookrequest-detail');

                // Publish
                Route::post('/book/publish','Book\BookController@publishBook')->name('admin.publish');
                Route::get('/admin/book-list/','Book\BookController@bookList')->name('adminpublish.booklist');
                Route::post('/book/reject','Book\BookController@rejectBook')->name('admin.reject');

                Route::get('/admin/check-rent-request','Book\BookController@checkRentList')->name('admin.checkRentList');
                Route::get('/admin/rent-sort-detail/{id}','Book\BookController@RentListSort')->name('admin.rentListSort');
                Route::post('/admin/save-rent-request','Book\BookController@saveRent')->name('admin.saveRent');

                Route::get('/admin/dashboard','Book\BookController@adminDashboard')->name('admin.dashboard');
                Route::get('/admin/book-shop','Book\BookController@adminBookShop')->name('admin.bookShop');
                Route::get('/admin/book-shop/{id}','Book\BookController@adminBookShopDetail')->name('admin.bookShopDetail');

                Route::get('/admin/return-list','Book\BookController@returnList')->name('admin.returnList');
                Route::post('/admin/return-approval','Book\BookController@returnApproval')->name('admin.returnApproval');
                Route::get('/admin/rent-list','Book\BookController@adminRentList')->name('admin.rentList');
        });

        // @ Member Permission
        Route::group([ 'middleware' => 'can:isMember' ], function(){
            Route::get('/get','Admin\CategoryController@getCategory')->name('member.getcategory');
            Route::post('/request','Book\BookController@memberSaveBook')->name('member.savebook');
            Route::post('/request/book/edit','Book\BookController@memberEditBook')->name('member.editBook');
            Route::get('/my-book-list','Book\BookController@memberBookList')->name('member.booklist');
            Route::post('/member/book-list','Book\BookController@bookList')->name('memberpublish.booklist');
            Route::get('/member/book/detail/{id}','Book\BookController@memberBookDetail')->name('memberpublish.bookdetail');
            
            Route::get('/member/dashboard','Book\BookController@memberDashboard')->name('memberDashboard');

            Route::post('/member/book/edit','Book\BookController@bookEdit')->name('memberPending.bookEdit');

            Route::get('/member/pending-list','Book\BookController@memberPendingList')->name('memberpending.booklist');
            Route::post('/member/pending-list/cancel','Book\BookController@memberPendingListCancel')->name('memberpending.cancel');
            Route::post('/member/published-book/remove','Book\BookController@memberPublishedBookRemove')->name('memberPublishedBookRemove');
            Route::post('/rent-request','Book\BookController@rentRequest')->name('member.rentRequest');
            Route::post('/change-password','User\UserController@changePassword')->name('member.changePassword');

            Route::get('/member/queue-list','Book\BookController@queueLists')->name('member.queueList');
            Route::get('/member/rent-list','Book\BookController@rentLists')->name('member.rentList');
            Route::post('/member/return-book','Book\BookController@returnBook')->name('member.returnBook');
            Route::post('/member/book-rating','Book\BookController@rateBook')->name('member.rateBook');

            Route::post('books/search', 'Book\BookController@searchBooks')->name('searchBooks');

            Route::get('/member/my-rented-list', 'Book\BookController@myRentedList')->name('myRentedList');
        });
        // @ All Permission
        Route::group([ 'middleware' => 'can:manage-all' ], function(){
        });
    });

Route::get('/{any}', 'HomeController@index')->where('any', '^(?!api).*$');

Route::get('sendMe/mail',function(){
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
});


