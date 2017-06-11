<?php

use Illuminate\Http\Request;

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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');
Route::group(['namespace' => 'Api'], function() {   
    Route::get('/testing','MemberController@index');
    Route::post('/findoldmember/','MemberController@oldmember');
    Route::post('/findpromocode/','MemberController@promocode');
    Route::post('/orderpackage/','MemberController@orderpackage');
    Route::post('/getmember','MemberController@getMember');
    Route::post('/member/update','MemberController@memberupdate');
    Route::post('/memberactivity','AttendanceController@index');
    Route::post('/registermember/','MemberController@register');
    Route::post('/registertrialmember/','TrialMemberController@register');
    Route::post('/tambahmember/{id}','MemberController@tambahmember');
    Route::post('/contohPost','MemberCotroller@contohPost');
    Route::post('/polling','PollingController@index');
    Route::post('/listtransaction','TransactionController@index');
    Route::post('/addtransaction','TransactionController@addtrans');
    Route::post('/memberlogin','MemberController@login');
    
    Route::post('/createticket','TicketController@create');
    Route::post('/replayticket','TicketController@replay');
    Route::post('/listticket','TicketController@listticket');
    Route::post('/detailticket','TicketController@detailticket');
    
    Route::post('/polling/save','PollingController@savedata');
    Route::get('/promo','PromoInfoController@index');
    Route::get('/training','TrainingInfoController@index');
    Route::get('/event','EventInfoController@index');
    Route::get('/promo/show/{id}','PromoInfoController@show');
    Route::get('/gym/listdata/','GymInfoController@listdata');
    Route::get('/package/listdata/','PackageInfoController@listdata');
});
