<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductWriteOff extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id','product_id','measure_id','qtde', 'category_id','brand_id','user_id','created_at','deleted_at'
    ];

    protected $hidden = [
        'updated_at'
    ];

    protected $dates = [
        'created_at','deleted_at',
    ];
}
