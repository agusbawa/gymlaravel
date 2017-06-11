<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Promo;
use PDF;

class BarcodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        return view('dashboard.barcode.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.promo.create');
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
        return $out;
    }
    
    public function pdfview( $total,$start){
        
        $kartu = array();
        $starting = $start;
    //    /dd($total,$start,$starting);
        $d = 0;
        $listKartu = 1;
        for($a = $starting; $a <= $starting + (int)$total - 1; $a++){
            $kartu[$listKartu][] = $this->cardFormatNumb($a);
            
            if($a == ($starting + $total)){
                $totalKartuCheck = count($kartu[$listKartu]);
                if($totalKartuCheck < 10){
                    for($b = $totalKartuCheck; $b <=10;$b++){
                        $kartu[$listKartu][] = '';
                    }
                }
            }
            
            $d++;
            if($d == 10){
                $listKartu++;
                $d = 0;
            }
            
            
        }
        
        $data['kartu'] = $kartu;
        
        
//        
        $pdf = PDF::loadView('dashboard.barcode.pdf', $data);
        return $pdf->setPaper('a4', 'potrait')->stream('download.pdf');
        
//        return view('dashboard.barcode.pdf')->with('kartu',$kartu);
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
            'title'             =>'required',
            'code'              =>'required',
            'range'             =>'required',
            'unit'              =>'required|min:1',
            'qty'               =>'required|min:0'
        ])->setAttributeNames([
            'title'             =>'Judul',
            'code'              =>'Kode Promo',
            'range'             =>'Masa Berlaku',
            'unit'              =>'Diskon',
            'qty'               =>'Jumlah',
        ])->validate();

        $promo                  =   new Promo;
        $promo->title           =   $request->get('title');
        $promo->code            =   $request->get('code');

        $range                  =   explode(" - ", $request->get('range'));
        $promo->start_date      =   date("Y-m-d", strtotime($range[0]));
        $promo->end_date        =   date("Y-m-d", strtotime($range[1]));
        $promo->unit            =   $request->get('unit');
        $promo->value           =   $request->get('value');
        $promo->qty             =   $request->get('qty',0);
        $promo->is_enabled      =   $request->get('is_enabled',0);
        $promo->save();

        $request->session()->flash('alert-success', trans('regym.success_added', ['name' => 'News']));
        return redirect('/u/promos');
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
        $promo    =   Promo::findOrFail($id);
        return view('dashboard.promo.edit')->with('promo',$promo);
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
            'title'             =>'required',
            'code'              =>'required',
            'range'             =>'required',
            'unit'              =>'required|min:1',
            'qty'               =>'required|min:0'
        ])->setAttributeNames([
            'title'             =>'Judul',
            'code'              =>'Kode Promo',
            'range'             =>'Masa Berlaku',
            'unit'              =>'Diskon',
            'qty'               =>'Jumlah',
        ])->validate();

        $promo                  =   Promo::findOrFail($id);
        $promo->title           =   $request->get('title');
        $promo->code            =   $request->get('code');

        $range                  =   explode(" - ", $request->get('range'));
        $promo->start_date      =   date("Y-m-d", strtotime($range[0]));
        $promo->end_date        =   date("Y-m-d", strtotime($range[1]));
        $promo->unit            =   $request->get('unit');
        $promo->value           =   $request->get('value');
        $promo->qty             =   $request->get('qty',0);
        $promo->is_enabled      =   $request->get('is_enabled',0);
        $promo->save();

        $request->session()->flash('alert-success', trans('regym.success_updated', ['name' => 'News']));
        return redirect('/u/promos');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $promo    =   Promo::findOrFail($id);
        $promo->delete();
        request()->session()->flash('alert-success', trans('regym.success_deleted', ['name' => 'Promo']));
        return redirect('/u/promos');
    }
}
