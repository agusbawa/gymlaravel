<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Trialmember;
use App\Gym;
use App\PackagePrice;
use App\Promo;
use App\Vote;
use App\Member;
use App\Transaction;
use App\TrasactionPayment;
use Carbon\Carbon;
use App\MemberVote;
use App\Mail\MemberCreated;
use App\Mail\mailCreatedCs;
use App\Mail\freeTrial;
use Illuminate\Support\Facades\Mail;
use Auth;
use App\MemberHistory;
class TrialmemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    protected $kedatangan = ['datang' => 'Datang','tidakdatang'=>'Tidak Datang'];
    
    public function index(Request $request)
    {
        if(\App\Permission::SubMenu('19',Auth::user()->role_id) == 0){
            return redirect()->back();
      }
        $gyms    = Gym::orderBy('title','asc')->get();
        Trialmember::authIndexPage($request->get('keyword'), ['name','nick_name','folow_up_by','tanggal_kedatangan','status'],['created_at'=>'asc']);
        
        return view('dashboard.trialmember.index')->with('gyms',$gyms)->with('status' ,$this->kedatangan);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $gyms    = Gym::orderBy('title','asc')->get();
        return view('dashboard.trialmember.create')->with('gyms',$gyms)->with('status' ,$this->kedatangan);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        \Validator::make($request->all(),[
            'name'             =>'required',
            'nick_name'              =>'required',
            'gym_id'             =>'required'
        ])->setAttributeNames([
            'name'             =>'Nama',
            'nick_name' => 'Panggilan',
            'gym_id'             =>'Gym'
        ])->validate();

        $trialmember                  =   new Trialmember;
        $trialmember->name           =   $request->get('name');
        $trialmember->nick_name            =   $request->get('nick_name');
        $trialmember->address_street            =   $request->get('address_street');
        $trialmember->address_region            =   $request->get('address_region');
        $trialmember->address_city            =   $request->get('address_city');
        $trialmember->place_of_birth            =   $request->get('place_of_birth');
        $trialmember->date_of_birth            =   date('Y-m-d',strtotime($request->get('date_of_birth')));
        $trialmember->gender            =   $request->get('gender');
        $trialmember->phone            =   $request->get('phone');
        if($request->get('folow_up')){
            $trialmember->folow_up            =   date('Y-m-d',strtotime($request->get('folow_up')));
        }
        
        $trialmember->folow_up_by            =   $request->get('folow_up_by');
        if($request->get('tanggal_kedatangan')){
            $trialmember->tanggal_kedatangan            =   date('Y-m-d',strtotime($request->get('tanggal_kedatangan')));
        }
        if($request->get('status')){
            $trialmember->status            =   $request->get('status');
        }
        
        $trialmember->remark            =   $request->get('remark');
        $trialmember->gym_id            =   $request->get('gym_id');
        $trialmember->save();

        $request->session()->flash('alert-success', trans('regym.success_added', ['name' => 'Free Trial']));
        return redirect('/u/trial');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if($request->ajax() && $request->get('action')=="VALIDATE"){
            $promo = Promo::isValid($request->get('code'));
            if (is_null($promo)) {
                return response()->json(['status'=>false]);
            }
            return response()->json(['status'=>true]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $trial    = Trialmember::findOrFail($id);
        $gyms    = Gym::orderBy('title','asc')->get();
        return view('dashboard.trialmember.edit')->with('status' ,$this->kedatangan)->with('gyms',$gyms)->with('trial',$trial);
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
            'name'             =>'required',
            'nick_name'              =>'required',
            'gym_id'             =>'required',
            'folow_up_by'       => 'required',
            'folow_up'          => 'required',
           
        ])->setAttributeNames([
            'name'             =>'Nama',
            'nick_name' => 'Panggilan',
            'gym_id'             =>'Gym',
            'folow_up_by'       =>'Dihubungi Oleh',
            'folow_up'          =>'Dihubungi Pada',
           
        ])->validate();

        $trialmember                  =   Trialmember::findOrFail($id);
        $trialmember->name           =   $request->get('name');
        $trialmember->nick_name            =   $request->get('nick_name');
        $trialmember->address_street            =   $request->get('address_street');
        $trialmember->address_region            =   $request->get('address_region');
        $trialmember->address_city            =   $request->get('address_city');
        $trialmember->place_of_birth            =   $request->get('place_of_birth');
        $trialmember->date_of_birth            =   date('Y-m-d',strtotime($request->get('date_of_birth')));
        $trialmember->gender            =   $request->get('gender');
        $trialmember->phone            =   $request->get('phone');
        if($request->get('folow_up')){
            $trialmember->folow_up            =   date('Y-m-d',strtotime($request->get('folow_up')));
        }
        
        $trialmember->folow_up_by            =   $request->get('folow_up_by');
        if($request->get('tanggal_kedatangan')){
            $trialmember->tanggal_kedatangan            =   date('Y-m-d',strtotime($request->get('tanggal_kedatangan')));
        }
        if($request->get('status')){
            $trialmember->status            =   $request->get('status');
        }
        
        $trialmember->remark            =   $request->get('remark');
        $trialmember->gym_id            =   $request->get('gym_id');
        $trialmember->save();


        $request->session()->flash('alert-success', trans('regym.success_updated', ['name' => 'Free Trial']));
        return redirect('/u/trial');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $trialmember    =   Trialmember::findOrFail($id);
        $trialmember->delete();
        request()->session()->flash('alert-success', trans('regym.success_deleted', ['name' => 'Trial Member']));
        return redirect('/u/trial');
    }
    public function addmember($id)
    {
        $trial = Trialmember::find($id);
         $gyms    =   Gym::orderBy('title','asc')->get();
        $pakets = PackagePrice::get();
        $promos = Promo::get();
        $vote = Vote::where('enableregister','=',1)->get();
        return view('dashboard.trialmember.addmember')->with('trial',$trial)->with('promos',$promos)->with('pakets',$pakets)->with('gyms',$gyms)->with('vote',$vote);
    }
    public function postaddmember(Request $request)
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
        if(!empty($request->get('foto'))){
         $type = file_get_contents($request->file('foto'));
        $base64 = base64_encode($type);
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
        $member->status       = "Aktif";
        $member->card = $request->get('card');
        $member->type = 'new';
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
        Mail::to($email)->send(new MemberCreated($email,$pass));
        }

        $trialmember =  Trialmember::where('email',$request->get('email'))->first();
        $trialmember->delete();

        Mail::to(Auth::user()->email)->send(new mailCreatedCs($email,$pass));
        MemberHistory::DataAktifasiMasuk($member->id,$request->get('gym_id'),$request->get('paket'),$request->get('promo'),'new');
        $request->session()->flash('alert-success', trans('regym.success_added', ['name' => 'Member']));
        return redirect('/u/trial');
    }
}
