<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductMeasurements extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id','product_id','measure_id','qtde'
    ];

    protected $hidden = [
        'created_at','updated_at','deleted_at'
    ];

    protected  $dates = ['deleted_at'];

//    public function products()
//    {
//        return $this->hasMany('App\Product');
//    }

    public function product()
    {
        return $this->belongsTo('App\Product');
    }


    public function measure()
    {
        return $this->hasMany('App\Measure');
    }

}
