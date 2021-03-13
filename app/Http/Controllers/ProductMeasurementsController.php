<?php

namespace App\Http\Controllers;

use App\Measure;
use App\ProductMeasurements;
use Illuminate\Http\Request;

class ProductMeasurementsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

//        $items = DB::table('items')
//            ->select("items.id","items.name"
//                ,DB::raw("(GROUP_CONCAT(items_city.name SEPARATOR '@')) as `cities`"))
//            ->leftjoin("items_city","items_city.item_id","=","items.id")
//            ->groupBy('items.id')
//            ->get();

        $produtos_measurements = \DB::table('pantry.product_measurements')
            ->select("products.id","products.name","products.image"
                ,\DB::raw("(GROUP_CONCAT(CONCAT(measures.nome, ' - (', measures.sigla, ')') SEPARATOR ', ')) as `medidas`"))
            ->join("measures","measures.id","=","product_measurements.measure_id")
            ->join('pantry.products', 'products.id', '=', 'product_measurements.product_id')
            ->groupBy('products.id','products.name','products.image')
            ->orderby('products.name','asc')
            ->paginate(10);
        return view('productMeasurements.index', compact('produtos_measurements'));
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
        $product_measurements = $this->getProductMeasurementForProductID($id);
        $measures = Measure::all()->toArray();
        $titulo = "Edição de Produtos por Medidas";
        return view('productMeasurements.product_measurements', compact('product_measurements','titulo', 'measures'));
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
        // Atenção a tabela de listagem está utilizando o pantry.products.id devido a regra de negócio de agrupamento de medidas,
        // utilizar um filtro para efetuar as trocas de ids nas atualizações da tabela pantry.product_measurements
        // ( pantry.products.id --> pantry.product_measurements.id )
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

    public function getProductMeasuresAjax(Request $request)
    {
        $dados = $request->all();
        $produto = ProductMeasurements::select('qtde','measure_id')->where('product_id',$request['product_id'])->first();

        if($dados['measure_id'] == 6) {
            return response($dados['qtde'] * 1);
        }
        elseif($produto['measure_id'] == $dados['measure_id']) {
            return response($produto['qtde'] * $dados['qtde']);
        }
        else {
            return false;
        }
    }

    public function getProductMeasurementForProductID($id)
    {
        if($id) {
            $resultado = ProductMeasurements::where('product_id',$id)
                ->join('measures', 'product_measurements.measure_id', '=', 'measures.id')
                ->select('product_measurements.*', 'measures.nome', 'measures.sigla')
                ->get()->toarray();
        }

        return $resultado;
    }
}
