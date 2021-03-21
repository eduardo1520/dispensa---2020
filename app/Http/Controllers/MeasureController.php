<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductMeasurements;
use Illuminate\Http\Request;
use App\Measure;

class MeasureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $unidades = Measure::all();
        return view('measures.index', compact('unidades'));
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

        $data = [];
        foreach ($request->all() as  $valor) {
            foreach ($valor as $index => $v) {
                $data[$v['name']] = $v['value'];
            }
        }

        $validacao = \Validator::make($data,[
            'nome' => 'required|string|max:50',
            'sigla' => 'required|string|max:10'
        ]);

        if($validacao->fails()){
            return redirect()->back()->withErrors($validacao)->withInput();
        }

        $resposta = Measure::create($data);

        if($resposta) {
            return response($resposta,200);
        } else {
            return response('Erro ao cadastrar a unidade de medida',500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Measure::find($id);
        return response($data);
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
        foreach ($request->all() as $medidas) {
            foreach ($medidas as $medida) {
                $data[$medida['name']] = $medida['value'];
            }
        }

        $validacao = \Validator::make($data,[
            'nome' => 'required|string|max:50',
            'sigla' => 'required|string|max:10'
        ]);

        if($validacao->fails()){
            return redirect()->back()->withErrors($validacao)->withInput();
        }

        $resultado = Measure::find($id)->update($data);

        if($resultado) {
            return response($resultado,200);
        } else {
            return response('Erro ao atualizar a unidade de medida',500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $resultado = Measure::find($id)->delete();

        if($resultado) {
            return response($resultado,200);
        } else {
            return response('Erro ao excluir a unidade de medida',500);
        }
    }

    public function measureAjax(Request $request)
    {
        \DB::statement("SET SQL_MODE=''");

        $comboMeasureSql = Measure::select('measures.id','measures.nome','measures.sigla')
            ->leftJoin('product_measurements', function($join){
                $join->on('product_measurements.measure_id', '=', 'measures.id');
            })->groupBy('product_measurements.product_id','product_measurements.measure_id')
            ->where('product_id','=',$request->product_id)
            ->orderby('measures.nome','asc')->get();

        return response($comboMeasureSql,200);
    }
}
