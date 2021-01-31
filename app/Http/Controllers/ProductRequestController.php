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

        $comboMeasureSql = array_map(function ($combo) {
            return $combo[$combo['id']][] = $combo['nome'] . " - (" . $combo['sigla'] . ")";
        }, Measure::select('id','nome','sigla')->orderby('nome','asc')->get()->toArray());

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
        }
        $resultado = ProductRequest::find($dados['id'])->update($dados);

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
