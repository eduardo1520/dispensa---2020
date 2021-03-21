<?php

namespace App\Http\Controllers;

use App\Measure;
use App\Product;
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
                else {
                    $resposta = $this->forceDelete($request->all());
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
        $produtos = ProductMeasurements::select('qtde','measure_id')->where('product_id',$request['product_id'])->get()->toArray();

        // Unidade, Caixa, Outros, Pacote

        $padrao = [1,2,3,4,6,9,10];

        if(in_array($dados['measure_id'], $padrao)) {
            return response($dados['qtde'] * 1);
        } elseif($dados['measure_id'] == 11) { // Dúzia
            return response($dados['qtde'] * 12);
        } else {
            foreach ($produtos as $key => $produto) {
                if(in_array($dados['product_id'], $produto) && $produto['measure_id'] == $dados['measure_id']) {
                    return response($produto['qtde'] * $dados['qtde']);
                }
            }
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
                $prod = ProductMeasurements::withTrashed()->where('product_id',$product['product_id'])->where('measure_id', '<>','6');
                $prod->forceDelete();
            }

        } catch(\Exception $error) {
            dd($error);
        }

        return $prod;
    }

    public function getProductImages()
    {

        \DB::statement("SET SQL_MODE=''");

        $product = ProductMeasurements::select('product_measurements.id', 'product_measurements.qtde', 'product_measurements.product_id', 'product_measurements.measure_id', 'products.image')
            ->leftJoin('products', function ($join) {
                $join->on('product_measurements.product_id', '=', 'products.id');
       })->groupBy('products.id')
         ->havingRaw('count(product_measurements.measure_id) <= ?', [1])
         ->get();

        return response($product,200);

    }

    public function createProductMeasurements(Request $request)
    {
        date_default_timezone_set('America/Sao_Paulo');

        $prod = ProductMeasurements::find($request->id);

        $dados['product_id'] = $prod->product_id;
        $dados['qtde'] = $prod->qtde;
        $dados['measure_id'] = $request->measure_id;
        $dados['created_at'] = date('Y-m-d H:i:s', time());

        $resultado = ProductMeasurements::create($dados);

        return response($resultado,200);

    }

}
