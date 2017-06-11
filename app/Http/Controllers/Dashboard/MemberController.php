<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Member;
use App\Gym;
use App\Card;
use App\Promo;
use Illuminate\Support\Facades\Mail;

use App\Package;
use App\Transaction;
use App\Jobs\MemberAssignCard;
use App\MemberVote;
use App\Vote;
use App\Mail\MemberCreated;
use App\Mail\mailCreatedCs;
use App\Mail\invoicepembayaran;
use App\Mail\MailAktifasi;
use App\Mail\freeTrial;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Aktifasi;
use App\MemberHistory;
use App\PackagePrice;
use App\TrasactionPayment;
use Carbon\Carbon;
use App\PromoPackage;
use App\CardMember;
use App\Attendance;
use App\GymUser;
use Auth;
use View;
class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
       
        if(\App\Permission::SubMenu('14',Auth::user()->role_id) == 0){
            return redirect()->back();
      }
        config(['regym.member_expire_reminder' => 'America/Chicago']);
        
        $gyms    =   Gym::orderBy('title','asc')->get();
        
        $expiredType = ['active' => "Not Expired", 'notactive' => "Expired", 'will' => "Will Expired"];
        /*Member::bootIndexPage($request->get('keyword'), ['name', 'nick_name', 'address_street', 'address_region', 'address_city', 'email','slug'],['name'=>'asc']);*/        
        
        if(\App\Permission::CheckGym(Auth::user()->id)==1){
            $gymuser = GymUser::where('user_id',Auth::user()->id)->pluck('gym_id');
             $gymsSearc = array();
            if($request->get('gyms')){
                 $selectgym = $request->get('gyms');
                $gymsSearc = $gymuser;
            }else{
                 $selectgym = $request->get('gyms');
                 $gymsSearc = $gymuser; 
            }
           
           
            Member::remakeIndexPage(['gym_id'=>['command'=>"=",'value'=>$gymsSearc],'expired'=>['command'=>"=","value"=>$request->get('expiredtype')],'memberonline'=>['command'=>"=","value"=>$request->get('onlineMember')],'expiredRange'=>['command'=>"=","value"=>$request->get('expiredRange')]], $request->get('keyword'), ['name', 'nick_name', 'address_street', 'address_region', 'address_city', 'email','slug','card'],['name'=>'asc']);
        }else{
            $gymsSearc = array();
            $selectgym = array();
            if($request->get('gyms')){
               
                $selectgym = $request->get('gyms');
                
            $gymsSearc = $request->get('gyms');
             }else{
                 $selectgym = $request->get('gyms');
             }
            
             Member::remakeIndexPage(['gym_id'=>['command'=>"=",'value'=>$gymsSearc],'expired'=>['command'=>"=","value"=>$request->get('expiredtype')],'memberonline'=>['command'=>"=","value"=>$request->get('onlineMember')],'expiredRange'=>['command'=>"=","value"=>$request->get('expiredRange')]], $request->get('keyword'), ['name', 'nick_name', 'address_street', 'address_region', 'address_city', 'email','slug','card'],['name'=>'asc']);
        }        
        return view('dashboard.member.index')->with('gyms',$gyms)->with('expiredtype',$expiredType)->with('selectgym',$selectgym);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $gyms    =   Gym::orderBy('title','asc')->get();
        $pakets = PackagePrice::get();
        $promos = Promo::get();
        $vote = Vote::where('enableregister','=',1)->get();
        return view('dashboard.member.create')->with('promos',$promos)->with('pakets',$pakets)->with('gyms',$gyms)->with('vote',$vote);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     
    public function store(Request $request)
    {
        
        $card = Member::where('card',$request->get('card'))->first();
        $expire = PackagePrice::find($request->get('paket'));
         if(!$request->get('vote_select')){
           $request->session()->flash('alert-error', 'pooling harus diisi');
            return redirect()->back()->withInput();
        }
        \Validator::make($request->all(),[
            'name'              =>'required',
            'nick_name'         =>'',
            'address_street'    =>'required',
            'address_region'    =>'required',
            'address_city'      =>'required',
            'phone'             =>'required',
            'email'             =>'',
            'gym_id'            =>'required',
            'gender'            =>'required',
            'place_of_birth'    =>'required',
            'date_of_birth'     =>'required',
            'foto'              =>'mimes:jpeg,bmp,png',
            'facebook_url'      =>'url',
            'twitter_url'       =>'url',
            'instagram_url'     =>'url',
            'hobby'             =>'',
            'job'               =>'required',
            'paket'             =>'required',
            'promo'             =>'',
            'keterangan'        =>'',
            'metode'            =>'required',
            'card'              =>'required | min:11|max:11',
            
        ])->setAttributeNames([
            'name'              =>'Nama Lengkap',
            'nick_name'         =>'Nama Panggilan',
            'address_street'    =>'Jalan',
            'address_region'    =>'Kabupaten',
            'address_city'      =>'Kota',
            'phone'             =>'No Telepon',
            'email'             =>'Email',
            'facebook_url'      =>'Link Facebook',
            'twitter_url'       =>'Link Twitter',
            'instagram_url'     =>'Link Instagram',
            'hobby'             =>'Hobi',
            'job'               =>'Pekerjaan',
            'gender'            =>'Jenis Kelamin',
            'place_of_birth'    =>'Tempat Lahir',
            'date_of_birth'     =>'Tanggal Lahir',
            'gym_id'            =>'Gym',
            'paket'             =>'Paket',
            'metode'            =>'Metode',
            'card'              =>'No Kartu',
            
        ])->validate();
       
         if($request->get('email')){
           $email = Member::where('email',$request->get('email'))->first();
           if($email != null){
           $request->session()->flash('alert-error', 'Email sudah dipakai'); 
           return redirect()->back()->withInput();
           }
        }
        $transaksi = new Transaction;
       
         if($card != null){
            $request->session()->flash('alert-error', 'No Kartu sudah terpakai');
            return redirect()->back()->withInput();
        }
        if(empty($request->get('promo'))){
            $validation = Transaction::validasi($request->get('paket'));
        }else{
            $validation = Transaction::validasi($request->get('paket'),$request->get('promo'));
        }
        if($validation==false){
            $request->session()->flash('alert-error', 'Promo tidak valid');
            return redirect()->back()->withInput();
        }
        
        $price = PackagePrice::find($request->get('paket'));
        if(!empty($request->get('promo'))){
            $promo = Promo::findOrFail($request->get('promo'));
            $transaksi->promo_id = $request->get('promo');
            $promoDiscount = Promo::find($request->get('promo'));
                if($promoDiscount->unit == "PERCENTAGE"){
                $total = $price->price - ($price->price * ($promoDiscount->value / 100));
                }
                else if($promoDiscount->unit == "NOMINAL"){
                    $total = $price->price - $promoDiscount->value;
                }else{
                $total = $price->price;
            }
            $promo->qty = $promo->qty - 1;
            $promo->save();
        }else{
            $transaksi->promo_id = '0';
            $total = $price->price;
        }
      //file_put_contents($destinationPath, $deco);
      
        
        $member                 =   new Member;
        $member->name           =   $request->get('name');
        $member->slug           =   ($request->get('slugcheck'))?$request->get('slug'):"";
        $member->nick_name      =   $request->get('nick_name');
        $member->address_street =   $request->get('address_street');
        $member->address_region =   $request->get('address_region');
        $member->address_city   =   $request->get('address_city');
        $member->phone          =   $request->get('phone');
        $member->email          =   $request->get('email');
        
        if(!empty($request->file('foto'))){
            $path = $request->file('foto');
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
           // $type = file_get_contents($request->file('foto'));
            //$base64 = base64_encode($type);
            $member->foto           =   $base64;
        }
        $member->facebook_url   =   $request->get('facebook_url');
        $member->twitter_url    =   $request->get('twitter_url');
        $member->instagram_url  =   $request->get('instagram_url');
        $member->hobby          =   $request->get('hobby');
        $member->job            =   $request->get('job');
        $member->gym_id         =   $request->get('gym_id');
        $member->gender         =   $request->get('gender');
        $member->place_of_birth =   $request->get('place_of_birth');
        $member->date_of_birth  =   date('Y-m-d',strtotime($request->get('date_of_birth')));
        $member->password       =   encrypt(str_random(8));
        $member->package_id     =   $request->get('paket');
        $member->extended_at    =   date("Y-m-d");
        $member->expired_at    =   Carbon::now()->addDays($expire->day);
        $member->registerfrom = $request->get('registerfrom');
        $member->status       = "ACTIVE";

        $member->card = $request->get('card');
        $member->type = 'New';
        $member->save();
        
        
        if($request->get('vote_select')){
            foreach($request->get('vote_select') as $pK => $pV){
                $voteMember = new MemberVote();
                $voteMember->vote_item_id = $pK;
                $voteMember->member_id = $member->id;
                $voteMember->save();
            }
        }
        
        
        
        $transaksi->member_id = $member->id;
        $transaksi->gym_id = $request->get('gym_id');
        $transaksi->package_price_id = $request->get('paket');
        $transaksi->code = str_random(8);
            
        $transaksi->total = $total;
        $transaksi->status="Active";
        $transaksi->save();

       $paymenttransaksi = new TrasactionPayment;
       $paymenttransaksi->transaction_id = $transaksi->id;
       $paymenttransaksi->pacakge_price_id = $request->get('paket');
       if(!empty($request->get('promo'))){
       $paymenttransaksi->promo_id =  $request->get('promo');
       
       }else{
           $paymenttransaksi->promo_id = '0';
       }
       if(empty($request->get('keterangan'))){
            $paymenttransaksi->refrences_payment   = "";
        }else{
        $paymenttransaksi->refrences_payment   = $request->get('keterangan');
        }
        
        $paymenttransaksi->payment_method = $request->get('metode');
        $paymenttransaksi->total_bayar = $request->get('bayar');
        $paymenttransaksi->save();
        $member->processAttendance($request->get('gym_id'));
        if(!empty($request->get('email'))){ 
        $memberSend  = Member::findOrFail($member->id);
        $pass = $memberSend->password;
        $email = $memberSend->email; 
        MemberHistory::DataAktifasiMasuk($member->id,$request->get('gym_id'),$request->get('paket'),Carbon::now()->addDays($expire->day),$request->get('promo'),'new');     
        Mail::to($email)->send(new MemberCreated($email,$pass));
         Mail::to($email)->send(new invoicepembayaran($transaksi->code));
        }
       
        Mail::to(Auth::user()->email)->send(new mailCreatedCs($email,$pass));
        
        $request->session()->flash('alert-success', trans('regym.success_added', ['name' => 'Member']));
        return redirect('/u/members');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        View::share('keyword','');
        $member                 =   Member::findOrFail($id);
        $memberAttendances      =   $member->attendances()->take(5)->orderBy('created_at','DESC')->get();
        $memberTransactions     =   $member->transactions()->where('member_id',$id)->orderBy('created_at','DESC')->paginate(15);
        
        return view('dashboard.member.show')->with('member',$member)->with('memberAttendances',$memberAttendances)
        ->with('memberTransactions',$memberTransactions);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         if (\App\Permission::EditPer('14',Auth::user()->role_id) == 0){
            return redirect()->back();
       }
        $member    =   Member::findOrFail($id);
        $gyms    =   Gym::orderBy('title','asc')->get();
        $password = decrypt($member->password);
        $packages    =   Package::orderBy('title','asc')->get();
        return view('dashboard.member.edit')->with('member',$member)->with('gyms',$gyms)->with('packages',$packages)->with('password',$password);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        \Validator::make($request->all(),[
            'name'              =>'required',
            'slug'              =>'required_if:slugcheck,1',
            'nick_name'         =>'required',
            'address_street'    =>'required',
            'address_region'    =>'required',
            'address_city'      =>'required',
            'phone'             =>'required',
            'email'             =>'',
            'facebook_url'      =>'url',
            'twitter_url'       =>'url',
            'instagram_url'     =>'url',
            'hobby'             =>'required',
            'job'               =>'required',
            
            'gym_id'            =>'required',
            'gender'            =>'required',
            'place_of_birth'    =>'required',
            'date_of_birth'     =>'required',
            'password'          =>'required',
        ])->setAttributeNames([
            'name'              =>'Nama Lengkap',
            'slug'              =>'ID Member Lama',
            'nick_name'         =>'Nama Panggilan',
            'address_street'    =>'Jalan',
            'address_region'    =>'Kabupaten',
            'address_city'      =>'Kota',
            'phone'             =>'No Telepon',
            'email'             =>'Email',
            'facebook_url'      =>'Link Facebook',
            'twitter_url'       =>'Link Twitter',
            'instagram_url'     =>'Link Instagram',
            'hobby'             =>'Hobi',
            'job'               =>'Pekerjaan',
            'gender'            =>'Jenis Kelamin',
            'place_of_birth'    =>'Tempat Lahir',
            'date_of_birth'     =>'Tanggal Lahir',
            'gym_id'            =>'Gym',
            'password'          =>'Password',
        ])->validate();
        if($request->get('email')){
           $email = Member::where('email',$request->get('email'))->first();
           if($email != null){
           $request->session()->flash('alert-error', 'Email sudah dipakai'); 
           return redirect()->back()->withInput();
           }
        }
        $member                 =   Member::findOrFail($id);
        $member->name           =   $request->get('name');
        $member->slug           =   ($request->get('slugcheck'))?$request->get('slug'):"";
        if(!empty($request->get('nick_name'))){
        $member->nick_name      =   $request->get('nick_name');
        }
        if(!empty($request->get('address_street'))){
        $member->address_street =   $request->get('address_street');
        }
        if(!empty($request->get('address_region'))){
        $member->address_region =   $request->get('address_region');
        }
        if(!empty($request->get('address_city'))){
        $member->address_city   =   $request->get('address_city');
        }
        $member->phone          =   $request->get('phone');
        $member->email          =   $request->get('email');
        if(!empty($request->get('facebook_url'))){
        $member->facebook_url   =   $request->get('facebook_url');
        }
        if(!empty($request->get('twitter_url'))){
        $member->twitter_url    =   $request->get('twitter_url');
        }
        if(!empty($request->get('instagram_url'))){
        $member->instagram_url  =   $request->get('instagram_url');
        }
        if(!empty($request->get('foto'))){
         $type = file_get_contents($request->file('foto'));
        $base64 = base64_encode($type);
        $member->foto           =   $base64;
        }
        $member->hobby          =   $request->get('hobby');
        $member->job            =   $request->get('job');
        $member->gym_id         =   $request->get('gym_id');
        
        try {
            if(decrypt($member->password)!=decrypt($request->get('password')))
            {
                $member->password   =   encrypt($request->get('password'));
            }
        } catch (\Exception $e) {
            $member->password   =   encrypt($request->get('password'));
        }
        $member->gender         =   $request->get('gender');
        if(empty($request->get('place_of_birth'))){
        $member->place_of_birth =   $request->get('place_of_birth');
        }
        if(empty($request->get('date_of_birth'))){
        $member->date_of_birth  =   date('Y-m-d',strtotime($request->get('date_of_birth')));
        }
        if(empty($request->get('package_id'))){
        $member->package_id     =   $request->get('package_id');
        }
        if(empty($request->get('expired_at'))){
        $member->expired_at     =   date("Y-m-d", strtotime($request->get('expired_at')));
        }
        if(empty($request->get('registerfrom'))){
        $member->registerfrom = $request->get('registerfrom');
        }
        $member->save();
        
        $request->session()->flash('alert-success', trans('regym.success_updated', ['name' => 'Member']));
        return redirect('/u/members');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(\App\Permission::DeletePer('14',Auth::user()->role_id) == 0){
            return redirect()->back();
       
        }
        $member    =   Member::findOrFail($id);
        $member->delete();
        request()->session()->flash('alert-success', trans('regym.success_deleted', ['name' => 'Member']));
        return redirect('/u/members');
    }
    
    public function assignCard(Request $request, \App\Member $member)
    {   
        $card = CardMember::orderBy('card_id','desc')->first();
       if($card == null){
           $starting = 1;
       }else{
           $starting= $card->card_id + 1;
       }
       
       $assign = new CardMember;
       $assign->member_id = $member->id;
       $assign->card_id = $starting; 
       $assign->save();
        $request->session()->flash('alert-success', 'Permintaan kartu telah masuk antrian');
       // dispatch(new MemberAssignCard($member));
       
        return redirect('/u/members');
    }
    public function activatet(Request $request )
    {
       if(\App\Permission::SubMenu('17',Auth::user()->role_id) == 0){
            return redirect()->back();
      }

if(!empty($request->get('code'))){
    if(\App\Permission::SubMenu('17',Auth::user()->role_id) == 0){
            return redirect()->back();
      }
    $transaction = Aktifasi::where('code','=',$request->get('code'));
    
     if($transaction->first() == null){

        $request->session()->flash('alert-error', 'Code aktifasi tidak ada');
        return view('dashboard.member.activate');
    }else{
        if($transaction->first()->expire < date('Y-m-d')){
        $request->session()->flash('alert-error', 'Code aktifasi sudah kadaluarsa');
        return view('dashboard.member.activate');
    }
    }
    $transaksis = Transaction::find($transaction->first()->trasaction_id);
    $member = $transaction->first()->member;
    $gym = Gym::findOrFail($member->gym_id);
    $gyms = Gym::get();
    $paket = PackagePrice::where('package_id',$gym->package->id)->get();
    $promo = Promo::get();
        if ($transaction->count()==1) {
            return view('dashboard.member.activate-verification')
            ->with('transaction',$transaction->first())
            ->with('member',$transaction->first()->member)
            ->with('package',$transaction->first()->PackagePrice)
            ->with('childPackage',$transaction->first()->packagePrice)
            ->with('transaksis',$transaksis)
            ->with('paket',$paket)
            ->with('promo',$promo)
            ->with('gyms',$gyms)
            ;   
            
        }
    }else{
        return view('dashboard.member.activate');
    }
    }
    public function getActivate(Request $request)
    {
    $transaction = Aktifasi::where('code','=',$request->get('code'));
  
    $transaksis = Transaction::find($transaction->first()->trasaction_id);
    $member = $transaction->first()->member;
    $gym = Gym::findOrFail($member->gym_id);
    $gyms = Gym::get();

    $paket = PackagePrice::where('package_id',$gym->package->id)->get();
    $promo = Promo::get();
        if ($transaction->count()==1) {
            return view('dashboard.member.activate-verification')
            ->with('transaction',$transaction->first())
            ->with('member',$member)
            ->with('package',$transaction->first()->PackagePrice)
            ->with('childPackage',$transaction->first()->packagePrice)
            ->with('transaksis',$transaksis)
            ->with('paket',$paket)
            ->with('promo',$promo)
            ->with('gyms',$gyms)
            ;            
        }
        return view('dashboard.member.activate');
    }

    public function postActivate(Request $request, $id)
    {
        $transaction = Aktifasi::findOrFail($id);
        $status = Transaction::findOrFail($transaction->trasaction_id);
        $member=Member::findOrFail($transaction->member_id);

       if($transaction->type == "New" || $member->card == 0){
           \Validator::make($request->all(),[
            'card'              =>'required',
            
        ])->setAttributeNames([
            'card'              =>'No Kartu',
            
        ])->validate();
            if(!empty($request->get('card'))){
                $membercard = Member::where('card',$request->get('card'))->first();
                    if(!is_null($membercard)){
                        $request->session()->flash('alert-error', 'Kartu sudah terpakai');
                        return redirect()->back()->withInput(['code'=>$transaction->code]);
                }
                $member->card = $request->get('card');
            }
       }
      
                
                    $memberd =$transaction->member_id;
                    $gym = $transaction->gym_id;
                    $packages = $transaction->package_price_id;
                    $packagePrice = PackagePrice::find($packages);
                if ($member->expired_at < \Carbon\Carbon::now()) {
                    
                    $expire     =   \Carbon\Carbon::now()->addDays($packagePrice->day);
                    $extend    = \Carbon\Carbon::now();
                }
                else if($member->expire_dat > \Carbon\Carbon::now())
                {
                    $extend     = $member->expired_at;
                    $expire     =   $member->expired_at->addDays($packagePrice->day);
                }else{
                    $expire     =   \Carbon\Carbon::now()->addDays($packagePrice->day);
                    $extend    = \Carbon\Carbon::now();
                }
                if($transaction->type == 'New'){
                    $member->type = 'New';
                }else{
                    $member->type = 'extends';
                }
                    $member->expired_at = $expire;
                    $member->extended_at = $extend;
                    $member->save();
                //update status member
                $transaction->member->status="ACTIVE";
                $transaction->member->save();
                //geting aktifa
                $result     =   $member->processAttendance($transaction->gym_id);
                if($transaction->type == 'New'){
                MemberHistory::DataAktifasiMasuk($member->id,$member->gym_id,$transaction->package_price_id,$expire,$transaction->promo_id,'new');
                }else{
                MemberHistory::DataAktifasiMasuk($member->id,$member->gym_id,$transaction->package_price_id,$expire,$transaction->promo_id,'extend');
                }
                //sending email
                $memberSend  = Member::findOrFail($memberd);
                $pass = $memberSend->password;
                $email = $memberSend->email;
                
                Mail::to($email)->send(new MemberCreated($email,$pass));
                Mail::to(Auth::user()->email)->send(new mailCreatedCs($email,$pass,$member->expired_at,$member->extended_at,$member->gender));
            
                //flash
                $transaction->delete();
                $request->session()->flash('alert-success', 'Member telah di aktivasi');
            
        

        return redirect('/u/members/activate');
    }

    public function getExtend(Request $request)
    {
        return view('dashboard.member.extend');
    }

    public function attendance()
    {
        
    }

    public function upload()
    {
        return view('dashboard.member.upload');
    }

    /**
     * Upload file CSV
     * File Format
     * NAME, NICK_NAME, OLD_MEMBER_ID, ADDRESS_STREET, ADDRESS_REGION, ADDRESS_CITY, PLACE_OF_BIRTH, DATE_OF_BIRTH, GENDER,PHONE, EMAIL, PASSWORD, FACEBOOK_URL, TWITTER_URL, INSTAGRAM_URL, HOBBY, JOB, STATUS, PACKAGE_ID, GYM_ID, EXTENDED_AT, EXPIRED_AT, CREATED_AT, UPDATED_AT
     */
public function ex_member()
    {
        return view('dashboard.member.ex_member');
    }
    public function postUpload(Request $request)
    {
        if(\App\Permission::SubMenu('21',Auth::user()->role_id) == 0){
            return redirect()->back();
      }
        // dd($request->file('file')->path());
       $kosong = 0;
        $number = 0;
        $results=\Excel::load($request->file('file')->path(), function($reader) {})->get();
        foreach($results->toArray() as $row)
            {
                
              if(count($row)!=24){
                
                   $kosong++;
                   continue;
                   
              }
                if( $row[4]==null || $row[5]==null || $row[6]==null || $row[7]==null || $row[8]==null ||
                $row[9]==null || $row[10]==null || $row[12]==null  || $row[17]==null || $row[18]==null || $row[19]==null || $row[20]==null || $row[21]==null || $row[22]==null
                || $row[0]==null
               ){
                  
                     $kosong++;
                    continue;
                   
                }
                if($row[2]==null && $row[3]==null){
                     
                      $kosong++;
                        continue;
                         
                }
                if($row[11] != null){
                    $member = Member::where('email',$row[11])->first();
                    if($member != null){
                       
                         $kosong++;
                        continue;
                       
                    }
                }
                $cardmember = Member::where('card',$row[3])->first();
                 if($cardmember != null){
                     
                      $kosong++;
                        continue;
                        
                 }
                 $gym = Gym::find($row[20]);
                        if(is_null($gym)){
                            
                             $kosong++;
                            continue;
                             
                        }
                $package = PackagePrice::find($row[19]);
                        if(is_null($package)){
                          
                            $kosong++;
                            continue;
                       
                        }
                
                
                $member     =   new Member;
                $member->name               =   $row[0];
                $member->nick_name          =   $row[1];   
                $member->slug               =   ($row[2])?:"";
                $member->address_street     =   $row[4];       
                $member->address_region     =   $row[5];      
                $member->address_city       =   $row[6];     
                $member->place_of_birth     =   $row[7];    
                $member->date_of_birth      =   $row[8];   
                $member->gender             =   $row[9];
                $member->phone              =   $row[10];
                $member->email              =   $row[11];
                $member->password           =   encrypt($row[12]);   
                $member->facebook_url       =   $row[13];      
                $member->twitter_url        =   $row[14];     
                $member->instagram_url      =   $row[15];    
                $member->hobby              =   str_limit($row[16],95);
                $member->job                =   str_limit($row[17],45);
                $member->status             =   $row[18];
                $member->package_id         =   $row[19];   
                $member->gym_id             =   $row[20];
                $member->extended_at        =   $row[21];  
                $member->deleted_at         =   null;     
                $member->expired_at         =   $row[22] ? $row[22] : date("Y-m-d H:i:s");
                $member->registerfrom       =  0;
                $member->created_at         =   $row[23] ? $row[23] : date("Y-m-d H:i:s");
                $member->updated_at         =   date("Y-m-d H:i:s");
                if($row[3]==null){
                    $member->card           =  0;
                }else{
                $member->card               =   $row[3];
                }
                $member->type               =   'extends';
                
                $member->save();
                $history                    = new MemberHistory;
                $history->member_id         = $member->id;
                $history->new_register      =  $member->created_at;
                $history->extends           = $member->extended_at;
                $history->expired           = $row[22] ? $row[22] : date("Y-m-d H:i:s");
                $history->package_price_id  = $row[19];
                $history->gym_id           =  $row[20];
                $history->promo_id = 0;
                $history->save();
                $number=$number+1;
                //Mail::to($member->email)->send(new MemberCreated($member->email,$member->password));
            }

    

        $request->session()->flash('alert-success', $number.' Berhasil di import '.$kosong.' Gagal di import');
        return redirect('/u/members');
    }
    public function postEx_member(Request $request)
    {
        if(\App\Permission::SubMenu('22',Auth::user()->role_id) == 0){
            return redirect()->back();
      }
        $kosong = 0;
        $number = 0;
        $results=\Excel::load($request->file('file')->path(), function($reader) {})->get();
                foreach($results->toArray() as $row)
                { 
                     if(count($row)!=10){
                         dd('tester');
                        $kosong++;
                        continue;
                   
              }
                    if($row[1]==null || $row[2]==null || $row[3]==null || $row[4]==null || $row[5]==null || $row[9]==null || $row[0]==null){
                       
                        $kosong++;
                        continue;
                
                    }else{
                        $id=Member::where('card',$row[0])->orWhere('slug',$row[0])->first();
                        if(is_null($id)){
                            
                            $kosong++;
                            continue;
                        }
                        $gym = Gym::find($row[3]);
                        if(is_null($gym)){
                             
                             $kosong++;
                            continue;
                        }
                        $package = PackagePrice::find($row[2]);
                        if(is_null($package)){
                            
                            $kosong++;
                            continue;
                        
                        }
                        if($row[6] != null){
                            $promo = Promo::where('code',$row[6])->first();
                            if(is_null($promo)){
                               
                                $kosong++;
                                continue;
                            }
                            $check = PromoPackage::where('promo_id',$row[6])->where('package_price_id',$row[2])->first();
                            if(is_null($check)){
                                
                                $kosong++;
                                continue;
                            }
                            if($promo->qty < 0){
                               
                                 $kosong++;
                                continue;
                            }
                        if($promo->end_date <= Carbon::now() || $promo->start_date >= Carbon::now()){
                            
                                $kosong++;
                                continue;
                            }
                            $prom = $row[6];
                            $promo->qty = $promo->qty - 1;
                            $promo->save();
                        }else{
                            $prom = 0;
                        }
                        $member     =    Member::findOrFail($id->id);
                        $member->status             =   $row[1];
                        $member->package_id         =   $row[2];   
                        $member->gym_id             =   $row[3];
                        $member->extended_at        =   $row[4] ? $row[4] : date("Y-m-d H:i:s");
                        $member->expired_at         =   $row[5] ? $row[5] : date("Y-m-d H:i:s");        
                        $member->save();

                       
                            $memberHistory   =    new MemberHistory;
                            $memberHistory->member_id             =   $id->id;
                            $memberHistory->extends               =   $row[4] ? $row[4] : date("Y-m-d H:i:s");
                            $memberHistory->expired               =   $row[5] ? $row[5] : date("Y-m-d H:i:s");          
                            $memberHistory->package_price_id      =   $row[2];   
                            $memberHistory->gym_id                =   $row[3];
                            $memberHistory->save();
                       

                        $transaction     =    new Transaction;
                        $transaction->package_price_id       =   $row[2];
                        $transaction->gym_id                 =   $row[3];   
                        $transaction->member_id              =   $id->id; 
                        $transaction->promo_id               =   $prom;           
                        $transaction->status                 =   $row[1];   
                        $transaction->total                  =   $row[9];
                        $transaction->code                   =   str_random(8);
                        $transaction->save();

                        $payment            = new TrasactionPayment;
                        $payment->transaction_id   = $transaction->id;
                        $payment->pacakge_price_id = $row[2];
                        $payment->promo_id         = $prom;
                        $payment->payment_method    = $row[7];
                        $payment->refrences_payment = $row[8];
                        $payment->save();
                        $number++;
                        //Mail::to($member->email)->send(new extendMember($member->email));
                    }
                }
        $request->session()->flash('alert-success', $number.' Berhasil di import '.$kosong.' Gagal di Import');
        return redirect('/u/members/ex_member');
    }
    public function uptransaksi($id,Request $request)
    {
        
       
        \Validator::make($request->all(),[
            'paket'              =>'required',
            'promo'              =>''
            
        ])->setAttributeNames([
            'paket'              =>'Nama Paket',
            'promo'              =>'Code Promo'
        ])->validate();
        $aktifasi = Aktifasi::find($id);
        $paket = PackagePrice::findOrFail($request->paket);
        $aktifasi->package_price_id = $request->get('paket');
        
        $transacti = new TrasactionPayment;
        $transacti->pacakge_price_id = $request->paket;
        $transaksi  = Transaction::findOrFail($aktifasi->trasaction_id);
       
        if(empty($request->promo)){
           $transacti->promo_id = '0';
           $transaksi->promo_id='0';
           $total = $transaksi->total;
        }else{
            $promo = Promo::find($request->get('promo'));
            $transacti->promo_id = $request->get('promo');
            $transaksi->promo_id = $request->get('promo');
            if($promo->unit="PERCENTAGE"){
                $total = $paket->price - ($paket->price*$promo->value/100);
            }else if($promo->unit="NOMINAL"){
                $total = $paket->price - $promo->value;
            }else{}
            $promo->qty = $promo->qty - 1;
            $promo->save();

        }

        $transacti->transaction_id = $aktifasi->trasaction_id;
        $transacti->payment_method = $aktifasi->get('metode');
        if(!empty($request->get('keterangan'))){
            $transacti->refrences_payment = $request->get('keterangan');
        }
        $transacti->total_bayar = $request->get('bayar');
        
        $transacti->save();
        $transaksi->status = "Active";

        $transaksi->total = $total;

        $transaksi->save();
        $aktifasi->save(); 
        $request->session()->flash('alert-success', 'Data transaksi sukses di update');
        return redirect()->back();
    }
 public function upaktivasi(Request $request,$id)
 {
     \Validator::make($request->all(),[
            'name'              =>'required', 
            'phone'             =>'required',
            'email'             =>'required',
            'hobby'             =>'required',
            'job'               =>'required',
            'gym_id'            =>'required',
            'gender'            =>'required',
           
        ])->setAttributeNames([
            'name'              =>'Nama Lengkap', 
            'phone'             =>'No Telp',
            'email'             =>'Email',
            'hobby'             =>'Hobi',
            'job'               =>'Pekerjaan',
            'gym_id'            =>'Gym',
            'gender'            =>'Jenis Kelamin',
        ])->validate();

        $member                 =   Member::findOrFail($id);
        $member->name           =   $request->get('name');
       
        
        if(!empty($request->get('address_street'))){
        $member->address_street =   $request->get('address_street');
        }
        if(!empty($request->get('address_region'))){
        $member->address_region =   $request->get('address_region');
        }
        if(!empty($request->get('address_city'))){
        $member->address_city   =   $request->get('address_city');
        }
        $member->phone          =   $request->get('phone');
        $member->email          =   $request->get('email');
        if(!empty($request->get('facebook_url'))){
        $member->facebook_url   =   $request->get('facebook_url');
        }
        if(!empty($request->get('twitter_url'))){
        $member->twitter_url    =   $request->get('twitter_url');
        }
        if(!empty($request->get('instagram_url'))){
        $member->instagram_url  =   $request->get('instagram_url');
        }
        $member->hobby          =   $request->get('hobby');
        $member->job            =   $request->get('job');
        $member->gym_id         =   $request->get('gym_id');
        
        $member->gender         =   $request->get('gender');
        if(!empty($request->get('place_of_birth'))){
        $member->place_of_birth =   $request->get('place_of_birth');
        }
        if(!empty($request->get('date_of_birth'))){
        $member->date_of_birth  =   date('Y-m-d',strtotime($request->get('date_of_birth')));
        }
        if(!empty($request->get('package_id'))){
        $member->package_id     =   $request->get('package_id');
        }
        if(!empty($request->get('expired_at'))){
        $member->expired_at     =   date("Y-m-d", strtotime($request->get('expired_at')));
        }
        if(!empty($request->get('registerfrom'))){
        $member->registerfrom = $request->get('registerfrom');
        }
        $member->save();
        $request->session()->flash('alert-success', trans('regym.success_updated', ['name' => 'Member']));
        return redirect()->back();
    }
 
}
