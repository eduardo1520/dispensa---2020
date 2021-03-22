<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConfProductMeasurements extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id','qtde','product_id','measure_id'
    ];

    protected $hidden = [
        'created_at','updated_at','deleted_at'
    ];

    protected  $dates = ['deleted_at'];
}
