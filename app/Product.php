<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id','name', 'description', 'image','brand_id','category_id'
    ];

    protected $hidden = [
        'created_at','updated_at','deleted_at'
    ];

    protected  $dates = ['deleted_at'];

    public function brand()
    {
        return $this->belongsTo('App\Brand');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function productMeasurements()
    {
        return $this->belongsTo('App\ProductMeasurements');
    }

    public static function getFieldDefault()
    {
        $dados = \DB::select('select id from pantry.categories where tipo like "%Outros%"');
        return $dados[0]->id;
    }


}
