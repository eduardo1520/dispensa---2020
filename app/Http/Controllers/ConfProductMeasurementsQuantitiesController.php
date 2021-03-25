<?php

namespace App\Http\Controllers;

use App\ConfProductMeasurementsQuantities;
use Illuminate\Http\Request;

class ConfProductMeasurementsQuantitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $confProductMeasurementsQuantities = \DB::table('pantry.conf_product_measurements_quantities')
            ->select('conf_product_measurements_quantities.product_id','products.name','products.image',
            \DB::raw("GROUP_CONCAT(CONCAT_WS('] ', CONCAT(' [',conf_product_measurements_quantities.qtde), measures.nome) order by 1 desc) as `medidas`"))
            ->join("measures","measures.id","=","conf_product_measurements_quantities.measure_id")
            ->join("products","products.id","=","conf_product_measurements_quantities.product_id")
            ->groupby('conf_product_measurements_quantities.product_id','products.name','products.image')
            ->orderby('products.name','asc')
            ->paginate('5');
        return view('confProductMeasurementsQuantities.index', compact('confProductMeasurementsQuantities'));

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
