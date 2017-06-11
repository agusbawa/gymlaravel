<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromoPackage extends Model
{
    //
    protected $table = "package_price_promo";

    public function promo()
    {
        return $this->belongsToMany('App\Promo');
    }
    public function packageprice()
    {
        return $this->belongsToMany('App\PackagePrice');
    }
}
