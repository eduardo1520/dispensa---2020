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
            ->whereNull('product_measurements.deleted_at')
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
    public function create(Request $request)
    {
        $resposta = $request->create($request->all());

        if($resposta)
            return redirect()->route('productMeasurements.index')->with('success','Medida do Produto cadastrada com sucesso!');
        return back()->with('error','Erro ao cadastrar o produto!');
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

        return view('productMeasurements.product_measurements', compact('product_measurements','titulo', 'measures','id'));
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

        try {
            $produts_measurements = ProductMeasurements::where('product_id',$id)->get()->toarray();
            if(!empty($produts_measurements)) {
                $qtde = $produts_measurements[0]['qtde'];
                $lista = $request->duallistbox_demo1;
                //Apaga o produto e cadastra novamente com as suas novas medidas.
                if(!empty($lista)) {
                    foreach ($produts_measurements as $key => $p) {
                        $prod = ProductMeasurements::find($p['id']);
                        $this->forceDelete($prod);
                    }
                    //Insere nos novos produtos com as suas medidas.
                    foreach ($lista as $measure) {
                        $data = [
                            'product_id' => $id,
                            'measure_id' => $measure,
                            'qtde' => $qtde,
                            '_token' => $request->_token
                        ];
                        $resposta = ProductMeasurements::create($data);
                    }

                    if($resposta)
                        return redirect()->route('productMeasurements.index')->with('success','Medida do Produto atualizado com sucesso!');
                    return back()->with('error','Erro ao atualizar o produto!');
                }
            }

        } catch(\Exception $error) {
            dd($error);
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
                ->whereNull('product_measurements.deleted_at')
                ->get()->toarray();
        }

        return $resultado;
    }

    // Metodo de delete permanente
    public function forceDelete($product)
    {
        $prod = null;

        // Encontre entre os excluidos o $product de id = ao passado
        try {
            if(!empty($product)) {
                $prod = ProductMeasurements::withTrashed()->where('product_id',$product['product_id']);
                $prod->forceDelete();
            }

        } catch(\Exception $error) {
            dd($error);
        }

        return $prod;
    }

}
