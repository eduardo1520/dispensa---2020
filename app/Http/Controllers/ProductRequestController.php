<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Category;
use App\Product;
use App\Measure;
use App\ProductRequest;
use Illuminate\Http\Request;

class ProductRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $solicitacao = ProductRequest::withTrashed()->get();
        $comboProductSql = Product::orderby('name','asc')->pluck('name', 'id');
        $comboBrandSql = Brand::orderby('name','asc')->pluck('name', 'id');
        $comboCategorySql = Category::orderby('tipo','asc')->pluck('tipo', 'id');
        $combo = Measure::select('id','nome','sigla')->orderby('nome','asc')->get()->toArray();

        foreach ($combo as $c) {
            $comboMeasureSql[$c['id']] = $c['nome'] . " - (" . $c['sigla'] . ")";
        }

        $arr = [];
        $arr['produto'] =  $comboProductSql;
        $arr['medida'] =  $comboMeasureSql;
        $arr['marca'] = $comboBrandSql;
        $arr['categoria'] = $comboCategorySql;

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
        $dados = $request->all();
        $categoria = Product::find($dados['product_id']);
        $dados['category_id'] = $categoria->category_id;
        $dados['user_id'] = \Auth::user()->id;
        $dados['data'] = !empty($dados['data']) ? $dados['data'] : date('Y-m-d');

        $resposta = ProductRequest::create($dados);

        if($resposta)
            return response('Requisição do Produto criado com sucesso!',200);
        return response('Erro ao criar a requisição do produto!',500);

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
    public function destroy(Request $request)
    {

        $dados = $request->all();

        if($dados['id']) {
            $resultado = ProductRequest::find($dados['id']);
            if($resultado) {
                $resultado->delete();
            }
        }

        if($resultado) {
            return true;
        } else {
            return false;
        }
    }

    public function atualiza(Request $request)
    {
        $dados = $request->all();

        if(!empty($dados['data'])) {
            $dados['data'] = $this->trataDataBanco($dados['data']);
            $data = date('Y-m-d');
            if(!empty(ProductRequest::find($dados['id'])) && $dados['data'] >= $data) {
                $resultado = ProductRequest::find($dados['id'])->update($dados);
                if($resultado) {
                    return true;
                } else {
                    return false;
                }
            }
        }

        $dados['data'] = date('Y-m-d');
        $dados['user_id'] = \Auth::user()->id;

        $resultado = ProductRequest::updateOrCreate([
            'id'   => $dados['id'],
        ],[
            'brand_id'    => isset($dados['brand_id']) ? $dados['brand_id'] : 30,
            'category_id' => isset($dados['category_id']) ? $dados['category_id'] : 5,
            'data'        => $dados['data'],
            'measure_id'  => isset($dados['measure_id']) ? $dados['measure_id'] : 10 ,
            'product_id'  => $dados['product_id'],
            'qtde'        => isset($dados['qtde']) ? $dados['qtde'] : 0,
            'user_id'     => $dados['user_id']
        ]);

        if($resultado) {
            return true;
        } else {
            return false;
        }

    }

    protected function trataDataBanco($data)
    {
        if($data) {
            return implode("-",array_reverse(explode("/",$data)));
        } else {
            return '';
        }
    }

}
