<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductRequest extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id','qtde', 'user_id', 'product_id','brand_id', 'category_id','measure_id'
    ];

    protected $hidden = [
        'created_at','updated_at','deleted_at'
    ];

    protected  $dates = ['deleted_at'];

    public function brand()
    {
        return $this->belongsTo('App\Brand');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function measure()
    {
        return $this->belongsTo('App\Measure');
    }

}
