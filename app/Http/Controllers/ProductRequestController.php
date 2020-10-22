<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Category;
use App\Product;
use App\Measure;
use Illuminate\Http\Request;

use App\ProductRequest;

class ProductRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $solicitacao = ProductRequest::all();
        $comboProductSql = Product::orderby('name','asc')->pluck('name', 'id');
        $comboBrandSql = Brand::orderby('name','asc')->pluck('name', 'id');
//        $comboCategorySql = Category::orderby('tipo','asc')->pluck('tipo', 'id');

        $comboMeasureSql = array_map(function ($combo) {
            return $combo[$combo['id']][] = $combo['nome'] . " - (" . $combo['sigla'] . ")";
        }, Measure::select('id','nome','sigla')->orderby('nome','asc')->get()->toArray());

        $arr = [];
        $arr['produto'] =  $comboProductSql;
        $arr['medida'] =  $comboMeasureSql;
        $arr['marca'] = $comboBrandSql;

        $cont = count($arr);

        return view('productsRequest.index', compact('solicitacao','cont','arr'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
