<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id','tipo'
    ];

    protected $hidden = [
        'created_at','updated_at','deleted_at'
    ];

    protected  $dates = ['deleted_at'];

    public function products()
    {
        return $this->hasMany('App\Product');
    }
}
