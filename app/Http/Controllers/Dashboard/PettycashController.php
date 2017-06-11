<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Pettycash;
use App\Transaction;
use App\Gym;
use App\Personaltrainer;
use App\Pengeluaran;
use Carbon\Carbon;
use App\Setoranbank;
use App\Kantin;
use App\Memberharian;
use App\GymUser;
use Auth;
use View;
class PettycashController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(\App\Permission::SubMenu('227',Auth::user()->role_id) == 0){
            return redirect()->back();
      }
        if(\App\Permission::CheckGym(Auth::user()->id)==1){
           $result =  Gym::orderBy('title','asc');
             $users = GymUser::where('user_id',Auth::user()->id)->get();
           foreach($users as $user){
                     $result->orWhere('id',$user->gym_id);
                        }
                        $gyms = $result->get()
                    ;
        }else{
        $gyms    = Gym::orderBy('title','asc')->get();
        }
         if(!empty($request->get('gym'))||!empty($request->get('month'))){
             View::share('keyword','');
              $range = cal_days_in_month ( CAL_GREGORIAN, $request->get('month'), $request->get('year'));
              
             $this->store($request);
             
             $table = Pettycash::orderBy('id','desc')->where('gym_id',$request->get('gym'))->limit(30)->get();
             
         }else{
             View::share('keyword','');
             $table=null;
         }
        
        View::share('table',$table);
        return view('dashboard.pettycash.index')->with('gyms',$gyms);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
        
        $gyms = Gym::orderBy('id','asc')->get();
       $table= Pettycash::get();
        return redirect('/u/pettycash');
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
            'month'              =>'required',
            'gym'             =>'required',
            'year'          =>'required'
        ])->setAttributeNames([
            'month'              =>'Bulan',
            'gym'             =>'Gym',
            'year'              =>'Tahun'
        ])->validate();

       
       
        
        $gyms = Gym::get();
        $range = cal_days_in_month ( CAL_GREGORIAN, $request->get('month'), $request->get('year'));
        $go =  "";
        $first = Pettycash::orderBy('created_at','asc')->where('gym_id',$request->get('gym'))->first();
        for($i = 1; $i<=$range; $i++){
           
           $tanggal = $request->get('year').'-'.$request->get('month').'-'.$i;
           
            $checkpetty= Pettycash::orderBy('id','DESC')->where('gym_id',$request->get('gym'))->where('tanggal_petty', $request->get('year').'-'.$request->get('month').'-'.$i)->first();
            if(is_null($checkpetty)){
                $lastpetty = Pettycash::orderBy('id','DESC')->where('gym_id',$request->get('gym'))->first();
                
            }else{
                if($i == 1){
                    $lastpetty = Pettycash::orderBy('id','DESC')->where('gym_id',$request->get('gym'))->where('tanggal_petty', $request->get('year').'-'.$request->get('month').'-'.$i)->first();
                }else{
                    $lastpetty = Pettycash::orderBy('id','DESC')->where('gym_id',$request->get('gym'))->where('tanggal_petty', $request->get('year').'-'.$request->get('month').'-'.($i-1))->first();
                    
                    
                }
            }
            
            
            if($lastpetty == null){
           
            }else{
            $membergymharian = Memberharian::where('members_harian.gym_id',$request->get('gym'))
            ->join('package_prices','package_prices.id','=','members_harian.package_id')
            ->where('members_harian.tgl_bayar',$request->get('year').'-'.$request->get('month').'-'.$i)
            ->where('members_harian.payment_method','CASH')->get();
            $transaction = Transaction::where('gym_id',$request->get('gym'))->where('transactions.created_at','=', $request->get('year').'-'.$request->get('month').'-'.$i)->where('transactions.status','Active')
            ->join('transaksi_payments','transaksi_payments.transaction_id','=','transactions.id')->where('payment_method','CASH')->get();
            $personal = PersonalTrainer::where('gym_id',$request->get('gym'))->where('tgl_bayar','=', $request->get('year').'-'.$request->get('month').'-'.$i)->where('payment_method','CASH')->get();
            $pengeluaran = Pengeluaran::where('gym_id',$request->get('gym'))->where('tgl_keluar','=', $request->get('year').'-'.$request->get('month').'-'.$i)->get();
            $kantin = Kantin::where('gym_id',$request->get('gym'))->where('tgl_bayar','=', $request->get('year').'-'.$request->get('month').'-'.$i)->where('payment_method','CASH')->get();
            $storan = Setoranbank::where('gym_id',$request->get('gym'))->where('tgl_stor','=', $request->get('year').'-'.$request->get('month').'-'.$i)->get();
             $totaltransaksi = 0;
            foreach ($transaction as $trans) {
                $totaltransaksi = $totaltransaksi + $trans->total;
                
            }
            
            $totalmemberharian = 0;
            foreach($membergymharian as $keyharian){
                $totalmemberharian =+ $keyharian->price;
                
            }
           
            $totalpersonal = 0;
            foreach ($personal as $keypersonal) {
                $totalpersonal = $totalpersonal + $keypersonal->fee_gym;
            }
            
            $totalpengeluaran  = 0;
            foreach ($pengeluaran as $keypengeluaran) {
                $totalpengeluaran = $totalpengeluaran + $keypengeluaran->total;
                
            }
            
            $totalkantin = 0;
            foreach ($kantin as $keykantin) {
                $totalkantin = $totalkantin + $keykantin->total;
                
            }
            $totalstor = 0;
             foreach ($storan as $keykantin) {
                $totalstor = $totalstor + $keykantin->total;
            }
           
            $totalpety = ($lastpetty->total+$totaltransaksi+$totalpersonal+$totalkantin+$totalmemberharian)-$totalpengeluaran-$totalstor;
            $petty = new Pettycash;
            $petty->total = $totalpety;
            $petty->tanggal_petty = $request->get('year').'-'.$request->get('month').'-'.$i;
            $petty->gym_id = $request->get('gym');
            
            $petty->save();
            }
        }
        
       // $request->session()->flash('alert-success', trans('regym.success_added', ['name' => 'Petty Cash']));
        return redirect('/u/pettycash');
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
        $petty    = Pettycash::findOrFail($id);
        $gyms    = Gym::orderBy('title','asc')->get();
        return view('dashboard.pettycash.edit')->with('petty',$petty)->with('gyms',$gyms);
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
            'total'              =>'required',
            'gym_id'             =>'required'
        ])->setAttributeNames([
            'total'              =>'Total',
            'gym_id'             =>'Gym'
        ])->validate();

        $petty                  = Pettycash::findOrFail($id);
        $petty->total            =   $request->get('total');
        $petty->gym_id            =   $request->get('gym_id');
        $petty->save();

        $request->session()->flash('alert-success', trans('regym.success_updated', ['name' => 'Petty Cash']));
        return redirect('/u/pettycash');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $petty    =   Pettycash::findOrFail($id);
        $petty->delete();
        request()->session()->flash('alert-success', trans('regym.success_deleted', ['name' => 'Petty Cash']));
        return redirect('/u/pettycash');
    }
}
