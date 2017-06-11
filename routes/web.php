<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
use Illuminate\Support\Facades\Input;

Route::get('gym-zona', function(){
    $cat_id = Input::get('zona_id');
    $gym = DB::table("gyms")
                    ->where("zona_id","like","%".$cat_id."%")
                    ->pluck("title","id");
    return Response::json($gym);
});

Route::get('/', function () {
    return redirect('/u/overview');
});

Route::get('/home', function () {
    return redirect('/u/overview');
});

// Authentication

Route::get('auth/login', 'Auth\LoginController@getLogin');
Route::post('auth/login', 'Auth\LoginController@postLogin');
Route::get('auth/forgot', 'Auth\ForgotPasswordController@getForgot');
Route::post('auth/forgot', 'Auth\ForgotPasswordController@postForgot');
Route::get('auth/password/reset/{token}', 'Auth\ResetPasswordController@getReset');
Route::post('auth/password/reset/{token}', 'Auth\ResetPasswordController@postReset');

Route::group(['namespace' => 'Dashboard','middleware'=>'authenticated'], function() {
    Route::resource('/u/overview', 'OverviewController');

    Route::post('/u/gyms/{gym}/checkin', 'GymController@checkIn');
    Route::post('/u/gyms/{gym}/checkout', 'GymController@checkOut');
    Route::get('/u/getpromo/{idpaket}','PackagelistPriceController@getpromo');
    Route::resource('/u/zonas', 'ZonaController');
    Route::get('/u/zonas/list/{id}', 'ZonaController@listGym');

    Route::resource('/u/gyms', 'GymController');
    Route::get('/u/getpaket/{id}','GymController@getpaket');
    Route::get('/u/getpaketharian/{id}','GymController@getpaketharian');
    Route::patch('/u/searchgym','GymController@search');
    Route::get('/u/showgym/{idgym}','ZonaController@showgym');
    Route::get('/u/members/attendances/upload', 'MemberAttendanceController@upload')->name('members.attendances.upload');
    Route::post('/u/members/attendances/upload', 'MemberAttendanceController@postUpload');
    Route::resource('/u/members/attendances', 'MemberAttendanceController');
    Route::get('/u/members/ex_member','MemberController@ex_member');
    Route::post('/u/members/post_exmember','MemberController@postEx_member');
    Route::resource('/u/members/extend', 'MemberExtendController');
    Route::post('/u/members/activate/{transaction}', 'MemberController@postActivate');
    Route::get('/u/members/activate', 'MemberController@activatet');
   Route::patch('/u/members/getactivate', 'MemberController@getActivate');
    Route::post('/u/members/{member}/assigncard', 'MemberController@assignCard');
    Route::patch('/u/searchemail','ListEmailController@search');
    Route::patch('/u/search_index','ListEmailController@search_index');
    Route::get('/u/members/upload', 'MemberController@upload')->name('members.upload');
    Route::post('/u/members/upload', 'MemberController@postUpload');
    Route::resource('/u/listemail','ListEmailController');
    Route::resource('/u/template','TemplateEmailController');
    Route::resource('/u/members', 'MemberController');
    Route::patch('/u/updateak/{id}','MemberController@upaktivasi');
    Route::resource('/u/tiketsupport', 'TiketSupportController');
    Route::patch('/u/tiketmsg/reply/{idsupport}', 'TiketSupportController@reply');
    Route::get('/u/tiketsupport/1/ed', 'TiketSupportController@coba');
    Route::resource('/u/packageprices', 'PackagelistPriceController'); 
    Route::patch('/u/packageprices/ubah/{id}', 'PackagelistPriceController@ubah'); 
    Route::patch('/u/searchpackage','PackagelistPriceController@search');
    Route::patch('/u/searchinpackage','PackageController@search');
    Route::resource('/u/packages', 'PackageController');
    Route::get('/u/packages/list/{id}', 'PackageController@listharga');
    Route::patch('/u/ubahtransaksi/{id}','MemberController@uptransaksi');
    Route::resource('/u/events', 'EventController');
    Route::resource('/u/promos', 'PromoController');
    Route::resource('/u/news', 'NewsController');
    Route::resource('/u/poolings', 'PoolingController');
    Route::resource('/u/listemail', 'ListEmailController');
    Route::get('/u/listemail/{id}/edit', 'ListEmailController@edit');
    Route::post('/u/listemail/{id}/update_list', 'ListEmailController@update_list');
    Route::resource('/u/gymharian', 'GymsharianController');
    Route::get('/u/gymharian/lookprice/{id}','GymsharianController@lookprice');
    Route::resource('/u/personaltrainer', 'PersonaltrainerController');
    Route::resource('/u/kantin', 'KantinController');
    Route::resource('/u/pettycash', 'PettycashController');
    Route::resource('/u/pengeluaran', 'PengeluaranController');
    Route::resource('/u/storan', 'StoranController');
    Route::resource('/u/trial', 'TrialmemberController');
    Route::resource('/u/schedule', 'TrainingscheduleController');
    ROute::resource('/u/templateemail','TemplateEmailController');
    Route::resource('/u/cards', 'CardController');
    Route::resource('/u/promoinfo', 'PromoinfoController');

    Route::resource('/u/transactions', 'TransactionController');
    Route::get('/u/transactions/lookdiscount/{promo_id}', 'TransactionController@lookdiscount');
    Route::get('/u/trialmember/addmember/{idtrial}','TrialmemberController@addmember');
    Route::post('/u/trialmember/addmember','TrialmemberController@postaddmember');
    Route::resource('/u/roles', 'RoleController');
    Route::resource('/u/privileges', 'PrivilegeController');

    Route::resource('/u/profile', 'ProfileController');
    Route::resource('/u/barcode', 'BarcodeController');
    Route::get('/u/barcode/pdf/{total}/{start}', 'BarcodeController@pdfview');
    Route::get('/u/mail','SendemailController@mail');
    Route::resource('/u/target','TargetController');
    Route::post('/u/kirim','SendemailController@kirim');
   
    Route::get('auth/logout/', function(){ auth()->logout(); return redirect('/'); });
});
Route::group(['namespace' => 'Report','middleware'=>'authenticated'], function() {
    Route::get('/u/report/member','MemberReportController@member');
     Route::patch('/u/report/searchmember','MemberReportController@searchmember');
     Route::get('/u/report/link_zonamember/{id}','MemberReportController@link_zonamember');

     Route::get('/u/report/memberbaru','memberbaruController@member');
     Route::patch('/u/report/memberbarusearch','memberbaruController@searchmember');
     Route::get('/u/report/link_zonamemberbaru/{id}','memberbaruController@link_zonamemberbaru');

     Route::get('/u/report/memberbaruvs','memberbaruvsController@member');
     Route::patch('/u/report/memberbaruvssearch','memberbaruvsController@searchmember');
     Route::get('/u/report/link_zonamemberbaruvs/{id}','memberbaruvsController@link_zonamemberbaru');

     Route::get('/u/report/extends','extendsController@member');
     Route::patch('/u/report/extendssearch','extendsController@searchmember');
     Route::get('/u/report/link_zonaextends/{id}','extendsController@link_zonamemberextends');

     Route::get('/u/report/extendsvs','extendsvsController@member');
     Route::patch('/u/report/extendsvssearch','extendsvsController@searchmember');
     Route::get('/u/report/link_zonaextendsvs/{id}','extendsvsController@link_zonamemberextends');

     Route::get('/u/report/expired','expiredController@member');
     Route::patch('/u/report/expiredsearch','expiredController@searchmember');
     Route::get('/u/report/link_zonaexpired/{id}','expiredController@link_zonamemberexpired');

     Route::get('/u/report/expiredvs','expiredvsController@member');
     Route::patch('/u/report/expiredvssearch','expiredvsController@searchmember');
     Route::get('/u/report/link_zonaexpiredvs/{id}','expiredvsController@link_zonamemberexpired');

     Route::get('/u/report/registermember','RegisterMemberController@member');
     Route::patch('/u/report/searchregister','RegisterMemberController@searchmember');
     Route::get('/u/report/link_zonaregistrasi/{id}','RegisterMemberController@link_zonaregistrasi');
     Route::get('/u/report/usiamember','usiamemberController@member');
     Route::patch('/u/report/searchusia','usiamemberController@searchmember');
     Route::get('/u/report/link_zonausia/{id}','usiamemberController@link_zonausia');

     Route::get('/u/report/usiamemberbaru','usiamemberbaruController@member');
     Route::patch('/u/report/searchusiabaru','usiamemberbaruController@searchmember');
     Route::get('/u/report/link_zonausiabaru/{id}','usiamemberbaruController@link_zonausia');

     Route::get('/u/report/usiamemberbarudetail','usiamemberbarudetailController@member');
     Route::patch('/u/report/searchusiabarudetail','usiamemberbarudetailController@searchmember');
     Route::get('/u/report/link_zonausiabarudetail/{id}','usiamemberbarudetailController@link_zonausia');

     Route::get('/u/report/usiamemberbaruvs','usiamemberbaruvsController@member');
     Route::patch('/u/report/searchusiabaruvs','usiamemberbaruvsController@searchmember');
     Route::get('/u/report/link_zonausiabaruvs/{id}','usiamemberbaruvsController@link_zonausia');

     Route::get('/u/report/usiamemberlong','usiamemberlongController@member');
     Route::patch('/u/report/searchusialong','usiamemberlongController@searchmember');
     Route::get('/u/report/link_zonausialong/{id}','usiamemberlongController@link_zonausia');

     Route::get('/u/report/usiamemberlongdetail','usiamemberlongdetailController@member');
     Route::patch('/u/report/searchusialongdetail','usiamemberlongdetailController@searchmember');
     Route::get('/u/report/link_zonausialongdetail/{id}','usiamemberlongdetailController@link_zonausia');

     Route::get('/u/report/usiamemberlongvs','usiamemberlongvsController@member');
     Route::patch('/u/report/searchusialongvs','usiamemberlongvsController@searchmember');
     Route::get('/u/report/link_zonausialongvs/{id}','usiamemberlongvsController@link_zonausia');

     Route::get('/u/report/usiamemberext','usiamemberextController@member');
     Route::patch('/u/report/searchusiaext','usiamemberextController@searchmember');
     Route::get('/u/report/link_zonausiaext/{id}','usiamemberextController@link_zonausia');

     Route::get('/u/report/usiamemberextdetail','usiamemberextdetailController@member');
     Route::patch('/u/report/searchusiaextdetail','usiamemberextdetailController@searchmember');
     Route::get('/u/report/link_zonausiaextdetail/{id}','usiamemberextdetailController@link_zonausia');

     Route::get('/u/report/usiamemberextvs','usiamemberextvsController@member');
     Route::patch('/u/report/searchusiaextvs','usiamemberextvsController@searchmember');
     Route::get('/u/report/link_zonausiaextvs/{id}','usiamemberextvsController@link_zonausia');

     Route::get('/u/report/pendapatan','pendapatanController@member');
     Route::patch('/u/report/searchpendapatan','pendapatanController@searchmember');
     Route::get('/u/report/link_zonapendapatan/{id}','pendapatanController@link_zonapendapatan');
     Route::get('/u/report/pendapatanlong','penlongController@member');
     Route::patch('/u/report/searchpendapatanlong','penlongController@searchmember');
     Route::get('/u/report/link_zonapendapatanlong/{id}','penlongController@link_zonapendapatan');

     Route::get('/u/report/pendapatanbayar','penbybayarController@member');
     Route::patch('/u/report/searchpendapatanbayar','penbybayarController@searchmember');
     Route::get('/u/report/link_zonapendapatanbayar/{id}','penbybayarController@link_zonapendapatan');

     Route::get('/u/report/pendapatannew','pendapatannewController@member');
     Route::patch('/u/report/searchpendapatannew','pendapatannewController@searchmember');
     Route::get('/u/report/link_zonapendapatannew/{id}','penpatannewController@link_zonapendapatan');



     Route::get('/u/report/checkin','checkinController@member');
     Route::patch('/u/report/searchcheckin','checkinController@searchmember');
     Route::get('/u/report/link_zonacheckin/{id}','checkinController@link_zonacheckin');
     Route::get('/u/report/promo','promoController@member');
     Route::patch('/u/report/searchpromo','promoController@searchmember');
     Route::get('/u/report/link_zonapromo/{id}','promoController@link_zonapromo');

     Route::get('/u/report/extendvs', 'ReportAllController@view_extendvs');
     Route::get('/u/report/extendvs/{id}', 'ReportAllController@zona_extendvs');
    Route::get('/u/report/longpacket', 'ReportAllController@view_longpacket');
    Route::get('/u/report/longpacket/{id}', 'ReportAllController@zona_longpacket');
    Route::get('/u/report/promovs', 'ReportAllController@view_promovs');
    Route::get('/u/report/promovs/{id}', 'ReportAllController@zona_promovs');
    
    Route::get('/u/report/newmembervs', 'ReportAllController@view_newmembervs');
    Route::get('/u/report/newmembervs/{id}', 'ReportAllController@zona_newmembervs');

    Route::get('/u/report/newextendsvs', 'newextendsvsController@view_newmembervs');
    Route::get('/u/report/newextendsvs/{id}', 'newextendsvsController@zona_newmembervs');

    Route::get('/u/report/newexpiredvs', 'newexpiredvsController@view_newmembervs');
    Route::get('/u/report/newexpiredvs/{id}', 'newexpiredvsController@zona_newmembervs');

    Route::get('/u/report/newmemberyear', 'ReportAllController@view_newmemberyear');
    Route::get('/u/report/newmemberyear/{id}', 'ReportAllController@zona_newmemberyear');

    Route::get('/u/report/newextendsyear', 'newextendsyearController@view_newmemberyear');
    Route::get('/u/report/newextendsyear/{id}', 'newextendsyearController@zona_newmemberyear');

    Route::get('/u/report/newexpiredyear', 'newexpiredyearController@view_newmemberyear');
    Route::get('/u/report/newexpiredyear/{id}', 'newexpiredyearController@zona_newmemberyear');

    Route::get('/u/report/newmemberyearvs', 'newmemberyearvsController@view_newmemberyear');
    Route::get('/u/report/newmemberyearvs/{id}', 'newmemberyearvsController@zona_newmemberyear');

    Route::get('/u/report/newextendsyearvs', 'newextendsyearvsController@view_newmemberyear');
    Route::get('/u/report/newextendsyearvs/{id}', 'newextendsyearvsController@zona_newmemberyear');

    Route::get('/u/report/newexpiredyearvs', 'newexpiredyearvsController@view_newmemberyear');
    Route::get('/u/report/newexpiredyearvs/{id}', 'newexpiredyearvsController@zona_newmemberyear');

    Route::get('/u/report/extendlongvs', 'ReportAllController@view_extendlongvs');
    Route::get('/u/report/extendlongvs/{id}', 'ReportAllController@zona_extendlongvs');
     Route::get('/u/report/analisapendapatan', 'analisaController@index');
     Route::patch('/u/report/searchanalisa', 'analisaController@searchmember');
      Route::get('/u/report/link_zonaanalisa/{id}', 'analisaController@link_zonamember');
     Route::get('/u/report/slipsetoran', 'setoranController@index');
     Route::patch('/u/report/searchsetoran', 'setoranController@search');
    Route::get('/u/report/reportkhusus', 'ReportKhususController@index');
    Route::patch('/u/report/searchkhusus', 'ReportKhususController@search');
    Route::get('/u/report/link_zonakhusus/{id}', 'ReportKhususController@link_zonakhusus');
    Route::get('/u/report/extendlongvs', 'ReportAllController@view_extendlongvs');

    Route::get('/u/report/income', 'incomeController@view_incomevs');
    Route::patch('/u/report/searchincome', 'incomeController@searchincome');
    Route::get('/u/report/income/{id}', 'incomeController@zona_incomevs');

    Route::get('/u/report/incomevs', 'ReportAllController@view_incomevs');
    Route::get('/u/report/incomevs/{id}', 'ReportAllController@zona_incomevs');

    Route::get('/u/report/incomeday', 'ReportAllController@view_incomeday');
    
    Route::get('/exportExcelMember', 'MemberReportController@exportExcel');

    Route::get('/exportPDFMember', 'MemberReportController@exportPDF');

    Route::get('/exportExcelMember/search', 'MemberReportController@exportExcel_1');

    Route::get('/exportPDFMember/search', 'MemberReportController@exportPDF_1');

    Route::get('/exportExcelMemberBaru', 'memberbaruController@exportExcel');

    Route::get('/exportPDFMemberBaru', 'memberbaruController@exportPDF');

    Route::get('/exportExcelMemberBaru/search', 'memberbaruController@exportExcel_1');

    Route::get('/exportPDFMemberBaru/search', 'memberbaruController@exportPDF_1');

    Route::get('/exportExcelNewMembervs', 'ReportAllController@exportExcel_newmembervs');

    Route::get('/exportPDFNewMembervs', 'ReportAllController@exportPDF_newmembervs');

    Route::get('/exportExcelNewMembervs/seacrh', 'ReportAllController@exportExcel_newmembervs1');

    Route::get('/exportPDFNewMembervs/seacrh', 'ReportAllController@exportPDF_newmembervs1');

    Route::get('/exportExcelNewMemberyear', 'ReportAllController@exportExcel_newmemberyear');

    Route::get('/exportPDFNewMemberyear', 'ReportAllController@exportPDF_newmemberyear');

    Route::get('/exportExcelNewMemberyear/search', 'ReportAllController@exportExcel_newmemberyear1');

    Route::get('/exportPDFNewMemberyear/search', 'ReportAllController@exportPDF_newmemberyear1');

    Route::get('/exportExcelNewMemberyearvs', 'newmemberyearvsController@exportExcel_newmemberyearvs');

    Route::get('/exportPDFNewMemberyearvs', 'newmemberyearvsController@exportPDF_newmemberyearvs');

    Route::get('/exportExcelNewMemberyearvs/search', 'newmemberyearvsController@exportExcel_newmemberyearvs1');
    
    Route::get('/exportPDFNewMemberyearvs/search', 'newmemberyearvsController@exportPDF_newmemberyearvs1');

    Route::get('/exportExcelMemberBaruvs', 'memberbaruvsController@exportExcel');

    Route::get('/exportPDFMemberBaruvs', 'memberbaruvsController@exportPDF');

    Route::get('/exportExcelMemberBaruvs/search', 'memberbaruvsController@exportExcel1');

    Route::get('/exportPDFMemberBaruvs/search', 'memberbaruvsController@exportPDF1');

    Route::get('/exportExcelextends', 'extendsController@exportExcel');

    Route::get('/exportPDFextends', 'extendsController@exportPDF');

    Route::get('/exportExcelextends/search', 'extendsController@exportExcel1');

    Route::get('/exportPDFextends/search', 'extendsController@exportPDF1');

    Route::get('/exportExcelnewextendsvs', 'newextendsvsController@exportExcel');

    Route::get('/exportPDFnewextendsvs', 'newextendsvsController@exportPDF');

    Route::get('/exportExcelnewextendsvs/search', 'newextendsvsController@exportExcel1');

    Route::get('/exportPDFnewextendsvs/search', 'newextendsvsController@exportPDF1');

    Route::get('/exportExcelnewextendsyear', 'newextendsyearController@exportExcel');

    Route::get('/exportPDFnewextendsyear', 'newextendsyearController@exportPDF');

    Route::get('/exportExcelnewextendsyear/search', 'newextendsyearController@exportExcel1');

    Route::get('/exportPDFnewextendsyear/search', 'newextendsyearController@exportPDF1');

    Route::get('/exportExcelnewextendsyearvs', 'newextendsyearvsController@exportExcel');

    Route::get('/exportPDFnewextendsyearvs', 'newextendsyearvsController@exportPDF');

    Route::get('/exportExcelnewextendsyearvs/search', 'newextendsyearvsController@exportExcel1');

    Route::get('/exportPDFnewextendsyearvs/search', 'newextendsyearvsController@exportPDF1');

    Route::get('/exportExcelextendsvs', 'extendsvsController@exportExcel');

    Route::get('/exportPDFextendsvs', 'extendsvsController@exportPDF');

    Route::get('/exportExcelextendsvs/search', 'extendsvsController@exportExcel1');

    Route::get('/exportPDFextendsvs/search', 'extendsvsController@exportPDF1');

    Route::get('/exportExcelexpired', 'expiredController@exportExcel');

    Route::get('/exportPDFexpired', 'expiredController@exportPDF');

    Route::get('/exportExcelnewexpiredvs', 'newexpiredvsController@exportExcel');

    Route::get('/exportPDFnewexpiredvs', 'newexpiredvsController@exportPDF');

    Route::get('/exportExcelnewexpiredyear', 'newexpiredyearController@exportExcel');

    Route::get('/exportPDFnewexpiredyear', 'newexpiredyearController@exportPDF');

    Route::get('/exportExcelnewexpiredyearvs', 'newexpiredyearvsController@exportExcel');

    Route::get('/exportPDFnewexpiredyearvs', 'newexpiredyearvsController@exportPDF');

    Route::get('/exportExcelexpiredvs', 'expiredvsController@exportExcel');

    Route::get('/exportPDFexpiredvs', 'expiredvsController@exportPDF');

    Route::get('/exportExcelextendvs', 'ReportAllController@exportExcel_extendvs');

    Route::get('/exportPDFextendvs', 'ReportAllController@exportPDF_extendvs');

    Route::get('/exportExcellongpacket', 'ReportAllController@exportExcel_longpacket');

    Route::get('/exportPDFlongpacket', 'ReportAllController@exportPDF_longpacket');

    Route::get('/exportExcelusiamember', 'usiamemberController@exportExcel');

    Route::get('/exportPDFusiamember', 'usiamemberController@exportPDF');

    Route::get('/exportExcelusiamemberbaru', 'usiamemberbaruController@exportExcel');

    Route::get('/exportPDFusiamemberbaru', 'usiamemberbaruController@exportPDF');

    Route::get('/exportExcelusiamemberbarudetail', 'usiamemberbarudetailController@exportExcel');

    Route::get('/exportPDFusiamemberbarudetail', 'usiamemberbarudetailController@exportPDF');

    Route::get('/exportExcelusiamemberbaruvs', 'usiamemberbaruvsController@exportExcel');

    Route::get('/exportPDFusiamemberbaruvs', 'usiamemberbaruvsController@exportPDF');

    Route::get('/exportExcelusiamemberlong', 'usiamemberlongController@exportExcel');

    Route::get('/exportPDFusiamemberlong', 'usiamemberlongController@exportPDF');

    Route::get('/exportExcelusiamemberlongdetail', 'usiamemberlongdetailController@exportExcel');

    Route::get('/exportPDFusiamemberlongdetail', 'usiamemberlongdetailController@exportPDF');

    Route::get('/exportExcelusiamemberlongvs', 'usiamemberlongvsController@exportExcel');

    Route::get('/exportPDFusiamemberlongvs', 'usiamemberlongvsController@exportPDF');

    Route::get('/exportExcelusiamemberexp', 'usiamemberextController@exportExcel');

    Route::get('/exportPDFusiamemberexp', 'usiamemberextController@exportPDF');

    Route::get('/exportExcelusiamemberexpdetail', 'usiamemberextdetailController@exportExcel');

    Route::get('/exportPDFusiamemberexpdetail', 'usiamemberextdetailController@exportPDF');

    Route::get('/exportExcelusiamemberexpvs', 'usiamemberextvsController@exportExcel');

    Route::get('/exportPDFusiamemberexpvs', 'usiamemberextvsController@exportPDF');

    Route::get('/exportExcelpendapatan', 'pendapatanController@exportExcel');

    Route::get('/exportPDFpendapatan', 'pendapatanController@exportPDF');

    Route::get('/exportExcelpendapatanlong', 'penlongController@exportExcel');

    Route::get('/exportPDFpendapatanlong', 'penlongController@exportPDF');

    Route::get('/exportExcelpendapatanbayar', 'penbybayarController@exportExcel');

    Route::get('/exportPDFpendapatanbayar', 'penbybayarController@exportPDF');

    Route::get('/exportExcelreportkhusus', 'ReportKhususController@exportExcel');

    Route::get('/exportPDFreportkhusus', 'ReportKhususController@exportPDF');

    Route::get('/exportExcelcheckin', 'checkinController@exportExcel');

    Route::get('/exportPDFcheckin', 'checkinController@exportPDF');

    Route::get('/exportExcelanalisa', 'analisaController@exportExcel');

    Route::get('/exportPDFanalisa', 'analisaController@exportPDF');

    Route::get('/exportExcelpromo', 'promoController@exportExcel');

    Route::get('/exportPDFpromo', 'promoController@exportPDF');

    Route::get('/exportExcelpromovs', 'ReportAllController@exportExcel_promovs');

    Route::get('/exportPDFpromovs', 'ReportAllController@exportPDF_promovs');

    Route::get('/exportExcelincomeday', 'ReportAllController@exportExcel_incomeday');

    Route::get('/exportPDFincomeday', 'ReportAllController@exportPDF_incomeday');

    Route::get('/exportExcelslipsetoran', 'setoranController@exportExcel');

    Route::get('/exportPDFslipsetoran', 'setoranController@exportPDF');

    Route::get('/exportExcelincome', 'incomeController@exportExcel');

    Route::get('/exportPDFincome', 'incomeController@exportPDF');

    Route::get('/exportExcelincomevs', 'ReportAllController@exportExcel_incomevs');

    Route::get('/exportPDFincomevs', 'ReportAllController@exportPDF_incomevs');

    Route::get('/exportExcelextendlongvs', 'ReportAllController@exportExcel_extendlongvs');

    Route::get('/exportPDFextendlongvs', 'ReportAllController@exportPDF_extendlongvs');
    
    Route::get('auth/logout/', function(){ auth()->logout(); return redirect('/'); });
});
Auth::routes();

Route::get('croncheckout','cronjobController@autocheckout');
Route::get('cronbirthday','cronjobController@birthday');
Route::get('croncustom','cronjobController@custom');
Route::get('cronexpire','cronjobController@expire');
Route::get('cronjofree','cronjobController@joinfree');
Route::get('testime','cronjobController@testtime');
