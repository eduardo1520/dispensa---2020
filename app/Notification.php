<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id','product_id','qtde', 'category_id','user_id','created_at','deleted_at','updated_at','view'
    ];

    protected $dates = [
        'created_at','deleted_at'
    ];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }


}
