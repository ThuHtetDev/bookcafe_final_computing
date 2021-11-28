<?php

use Illuminate\Http\Request;
use App\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
    // ! API (updated)
    // Route::group(['middleware' => 'auth:api'], function() {
    //     Route::post('/best-rent-list','API\Book\ApiBookController@bestRentList')->name('bestRentList');


    //     Route::post('/my-book-list','API\Book\ApiBookController@myBookList')->name('myBookList');
    //     Route::post('/book-list','API\Book\ApiBookController@bookList')->name('bookList');
    //     Route::post('/book/detail','API\Book\ApiBookController@BookDetail')->name('bookDetail');
    //     Route::post('/my-rent-list','API\Book\ApiBookController@myRentList')->name('myRentList');
    // });


    //////////////////////////////////////////////////////////////////////////////
    // @ Login With Google Account
    Route::post('/redirect', 'API\SocialAuthGoogleController@redirect');
    Route::post('/callback', 'API\SocialAuthGoogleController@callback');

    Route::post('login', 'API\AuthController@login')->name('api.login');
    Route::post('register', 'API\AuthController@register')->name('api.register');

    Route::post('request',function(){
        return "success";
    });

    Route::group(['middleware' => 'auth:api'], function() {

        // ! Users
        Route::post('/user', 'API\User\UserController@authUser')->name('authUser'); // Get Auth User
        Route::post('/logout', 'API\AuthController@logout')->name('api.logout');
        Route::post('/change-profile','API\User\UserController@changeProfile')->name('changeProfile');

        Route::post('/best-rent-list','API\Book\ApiBookController@bestRentList')->name('bestRentList');

        Route::post('/overdate-rent-list','API\Book\AdminBookController@overDateRentList')->name('overDateRentList'); // overdate rent list

        // ! Admin Permission
        Route::group([ 'middleware' => 'can:manage-administration' ], function(){
            Route::post('/users','API\User\UserController@getUser');

            // app management
            Route::post('/memberlist','API\Book\AdminBookController@memberlist')->name('memberlist');
            Route::post('/adminlist','API\Book\AdminBookController@adminlist')->name('adminlist');
            Route::post('/member/add','API\Book\AdminBookController@saveMember')->name('saveMember');
            Route::post('/admin/add','API\Book\AdminBookController@saveAdmin')->name('saveAdmin');
            Route::post('/category/add','API\Book\AdminBookController@saveCategory')->name('saveCategory');

            Route::post('/book/request','API\Book\AdminBookController@pendingRequest')->name('pendingRequest'); // view pending books
            Route::post('/book/publish','API\Book\AdminBookController@publishBook')->name('publishBook'); // publish book

            Route::post('/return-books','API\Book\AdminBookController@returnBooks')->name('returnBooks'); // return Books
            Route::post('/return-approval','API\Book\AdminBookController@returnApproval')->name('returnApproval'); // return approval
            Route::post('/admin/current-rent-list','API\Book\AdminBookController@currentRentList')->name('currentRentList'); // current rent list
            Route::post('/rent-request-list','API\Book\AdminBookController@rentRequestList')->name('rentRequestList'); // new rent request list
            Route::post('/rent-request-confirm','API\Book\AdminBookController@rentRequestConfirm')->name('rentRequestList'); // rent request confirm

            Route::post('/rented-list','API\Book\AdminBookController@rentedList')->name('rentedList'); // rented list 
          
        });

        // ! Member Permission
        Route::group([ 'middleware' => 'can:isMember' ], function(){
            Route::post('/my-book-list' ,'API\Book\ApiBookController@myBookList')->name('myBookList');
            Route::post('/book-list'    ,'API\Book\ApiBookController@bookList')->name('bookList');
            Route::post('/book/detail'  ,'API\Book\ApiBookController@BookDetail')->name('bookDetail');
            Route::post('/my-rent-list' ,'API\Book\ApiBookController@myRentList')->name('myRentList');

            Route::post('/register-book','API\Book\ApiBookController@memberSaveBook')->name('memberSaveBook'); // register book
            Route::post('/rent-request' ,'API\Book\ApiBookController@rentRequest')->name('rentRequest'); // rent book
            Route::post('/return-book'  ,'API\Book\ApiBookController@returnBook')->name('returnBook');

        });

    });