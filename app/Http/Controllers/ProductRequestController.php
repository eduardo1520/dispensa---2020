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
        $this->atualizaProductRequest();

        $solicitacao = ProductRequest::withTrashed()->select('product_requests.*','products.name','products.image','products.description')
            ->join('products', function($join){
            $join->on('product_requests.product_id', '=', 'products.id');
        })->get();

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
        $produto = Product::find($dados['product_id']);
        $dados['category_id'] = $produto->category_id;
        $dados['user_id'] = \Auth::user()->id;
        $dados['brand_id'] = 30;
        $dados['measure_id'] = 10;
        $dados['produto_id'] = $produto->id;
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
        if(!empty($request['data'])) {
            $dados['data'] = $this->trataDataBanco($request['data']);
            $data = date('Y-m-d');
            if(!empty(ProductRequest::find($id)) && $dados['data'] >= $data) {
                $resultado = ProductRequest::find($id)->update($dados);
                if($resultado) {
                    return true;
                } else {
                    return false;
                }
            }
        }

        if(ProductRequest::find($id)) {
            $resultado = ProductRequest::find($id)->update($request->all());
            if($resultado) {
                return true;
            } else {
                return false;
            }
        }
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
        return $request['id'] && ProductRequest::find($request['id']) ? $this->update($request, $request['id']) : $this->store($request);
    }

    private function trataCampoProdRequest($dados)
    {

        $prod= new ProductRequest();
        $campos = $prod->pegaCampos();

//        $table = $prod->getTable();
//        $columns  = \Schema::getColumnListing($table);
        dd($campos);

        dd($dados);
        return [];

    }

    protected function trataDataBanco($data)
    {
        if($data) {
            return implode("-",array_reverse(explode("/",$data)));
        } else {
            return '';
        }
    }

    public function atualizaProductRequest()
    {
        $prod_req = ProductRequest::select('id','product_id')->get();
        foreach ($prod_req as $p) {
            $produto = Product::select('id', 'brand_id', 'category_id')->where('id', $p['product_id'])->first();
            try {
                if($p['id']) {
                    $obj = $p->find($p['id']);
                    if($obj) {
                        $obj->find($p['id'])->update(['brand_id' => $produto['brand_id'], 'category_id' => $produto['category_id']]);
                    }
                }
            } catch(\Exception $ex) {
                continue;
            }
        }
    }
}
