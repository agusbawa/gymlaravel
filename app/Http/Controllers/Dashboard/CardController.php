<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Card;
use Auth;
use Carbon\Carbon;
class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        if(\App\Permission::SubMenu('20',Auth::user()->role_id) == 0){
            return redirect()->back();
      }
        Card::bootIndexPage($request->get('keyword'), ['id'],['id'=>'desc']);
        return view('dashboard.card.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.card.create');
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
            'number_card'       =>'required || Numeric | min:1',
        ])->setAttributeNames([
            'number_card'       =>'Jumlah Kartu',
        ])->validate();
        $awal = Carbon::now()->format('ym');
        
        $totalCard = $request->get('number_card');
        $totalList = Card::orderBy('id','desc')->first();
        if(is_null($totalList)){
            $starting = $awal.'0000000';
            $ac = '000000' .(0 + $totalCard);
            // echo 'tidak ada data';

        }else{
            $pecah = substr($totalList->akhir,4);
            
            $starting = $awal.$pecah;
            $ac = '000000' .($pecah + $totalCard);
            // echo 'ada data';
        }
       
       
        //u/barcode/pdf/100/20
            
            
           
            $totalend = $awal.substr($ac,-7);
            $starting += 1;
            //dd($pecah,$starting,$awal);
            $card   =   new Card;
            $card->awal =(string) $starting;
            $card->interval = $totalCard;
            $card->akhir = (string) $totalend;
            $card->save();
            
        
        $request->session()->flash('alert-success', trans('regym.success_added', ['name' => $request->get('number_card').' Kartu']));
        return Redirect('u/barcode/pdf/'.$card->interval.'/'.$card->awal);
    }
    
    protected function cardFormatNumb($numb){
        $no = date('ym');
        
        $long = strlen((string)$numb);
        
        $min = 6;
        $out = '';
        if($long > $min){
            $out = $numb;            
        }else{
            for($d = 0;$d <= ($min - $long);$d++){
                $out.='0';
            }
            $out.=$numb;
        }
        
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
