<?php
namespace App\Http\Traits;
use View;
use App\Gym;
use App\GymUser;
use Auth;
trait RegymEloquentTrait {
    public static function bootIndexPage($keyword=null, $fields=array(), $orderBy=array('id'=>'asc'), $with=null, $otherFunction=null)
    {
        View::share('keyword', $keyword);
        $model          =   static::class;
        $modelObject    =   call_user_func_array(array($model, 'orderBy'), [key($orderBy), $orderBy[key($orderBy)]]);
        if($keyword)
        {
            foreach($fields as $field)
            {
                $modelObject->orWhere($field,'like','%'.$keyword.'%');
            }
        }
        
        if($with)
        {
            $modelObject->with($with);
        }


        if( is_callable($otherFunction) )
        {
            $modelObject = $otherFunction($modelObject);
        }
        
        $result     = $modelObject->paginate(15);
        View::share('table', $result);
        return $result;
    }
     public static function authIndexPage($keyword=null, $fields=array(), $orderBy=array('id'=>'asc'), $with=null, $otherFunction=null)
    {
        View::share('keyword', $keyword);
        $model          =   static::class;
        $modelObject    =   call_user_func_array(array($model, 'orderBy'), [key($orderBy), $orderBy[key($orderBy)]]);
        if($keyword)
        {
            foreach($fields as $field)
            {
                $modelObject->orWhere($field,'like','%'.$keyword.'%');
            }
        }
        
        if($with)
        {
            $modelObject->with($with);
        }


        if( is_callable($otherFunction) )
        {
            $modelObject = $otherFunction($modelObject);
        }
        if(\App\Permission::CheckGym(Auth::user()->id)==1){
             $users = GymUser::where('user_id',Auth::user()->id)->get();
           foreach($users as $user){
                     $modelObject->orWhere('gym_id',$user->gym_id);
                        
                }
        }
        $result     = $modelObject->paginate(15);
        View::share('table', $result);
        return $result;
    }
     public static function filIndexboot($keyword=null, $fields=array(), $tablejoin = null ,$join = array(null), $orderBy=array('id'=>'asc'),$tanggal = null , $filter = null , $with=null, $otherFunction=null)
    {
        View::share('keyword', $keyword);
        $model          =   static::class;
        $modelObject    =   call_user_func_array(array($model, 'orderBy'), [key($orderBy), $orderBy[key($orderBy)]]);
        if($filter && $keyword == null ){
            foreach($fields as $field)
            {
                $modelObject->orWhere($field,'like','%'.$keyword.'%');
            }
        }
        if($keyword)
        {
            foreach($fields as $field)
            {
            if($tablejoin){
                $modelObject->join($tablejoin,$tablejoin.'.id','=',$model);
            }
                $modelObject->orWhere($field,'like','%'.$keyword.'%');
            }
        }
        
        if($with)
        {
            $modelObject->with($with);
        }


        if( is_callable($otherFunction) )
        {
            $modelObject = $otherFunction($modelObject);
        }

        $result     = $modelObject->paginate(15);
        View::share('table', $result);
        return $result;
    }
    
    public static function remakeIndexPage($filter = array(), $search = null, $fields=array(), $orderBy=array('id'=>'asc')){
        View::share('keyword', $search);
        $model          =   static::class;
        $modelObject    =   call_user_func_array(array($model, 'orderBy'), [key($orderBy), $orderBy[key($orderBy)]]);
        
        
        if(count($filter) > 0){
            foreach($filter as $filterKey => $filterVal){
                if(!empty($filterVal['value'])){
                    if($filterKey == "expired"){
                        switch ($filterVal['value']){
                            case 'active':
                                 $modelObject->whereDate('expired_at', '>=', date('Y-m-d'));   
                            break;
                            case 'notactive':
                                $modelObject->whereDate('expired_at', '<', date('Y-m-d')); 
                            break;
                            case 'will':
                                $modelObject->whereDate('expired_at', '>=', date('Y-m-d'));
                                $modelObject->whereDate('expired_at', '<', date('Y-m-d',strtotime('+2 weeks'))); 
                            break;
                        }
                    }else if($filterKey == "memberonline"){
                        if(!empty($filterVal['value'])){
                            //$modelObject->doesntHave('transactions');
                            $modelObject->where('registerfrom','=','1');
                            $modelObject->where('status','!=','ACTIVE');
                        }
                    }else if($filterKey == "expiredRange"){
                        
                        $range = str_replace(' ', '', $filterVal['value']);
                        $rangeExp = explode('-', $range);
                        $from = $rangeExp[2].'-'.$rangeExp[1].'-'.$rangeExp[0];
                        $to = $rangeExp[5].'-'.$rangeExp[4].'-'.$rangeExp[3];
                        $modelObject->whereDate('expired_at', '>=', $from);
                        $modelObject->whereDate('expired_at', '<=', $to); 
                    }else if($filterKey == "gym_id"){
                        if(count($filterVal['value']) > 0){
                            $modelObject->whereIn('gym_id', $filterVal['value']);
                        }
                        
                    }else{
                        $modelObject->where($filterKey,$filterVal['command'],$filterVal['value']);                        
                    }                    
                }
                
                
                
                View::share($filterKey, $filterVal['value']);
            }            
        }
        
        if($search)
        {
            
                $modelObject->Where('name','like','%'.$search.'%')->orWhere('nick_name','like','%'.$search.'%');
            
        }
        
        $result     = $modelObject->paginate(15);
        View::share('table', $result);
        return $result;
    }
}