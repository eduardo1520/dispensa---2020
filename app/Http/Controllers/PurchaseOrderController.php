<?php

namespace App\Http\Controllers;

use App\ConfProductMeasurementsQuantities;
use App\Product;
use App\PurchaseOrder;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{

    protected  $data_atual;


    public function __construct()
    {
        date_default_timezone_set('America/Sao_Paulo');
        $this->data_atual = date('Y-m-d H:i:s', time());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produtos = Product::orderBy('name', 'ASC')->get();
        $datas = PurchaseOrder::select(\DB::raw("case purchase_orders.status
                                                            when 'P' then 'Aguardando aprovação'
                                                            when 'C' then 'Cancelado'
                                                            when 'A' then 'Aprovado'
                                                            end as status"),'purchase_orders.created_at')->distinct()->get();

        $purchase_orders = PurchaseOrder::select('purchase_orders.*','measures.nome as measure_nome', 'products.name as product_name'
                                                , 'products.image','categories.tipo as categories_nome',
                                                 'measures.sigla','conf_product_measurements_quantities.qtde as qtde_default')
            ->join('measures','measures.id','purchase_orders.measure_id')
            ->join('products','products.id','purchase_orders.product_id')
            ->join('categories','categories.id','purchase_orders.category_id')
            ->join('conf_product_measurements_quantities', function($join){
                $join->on('conf_product_measurements_quantities.measure_id','=','purchase_orders.measure_id');
                $join->on('conf_product_measurements_quantities.product_id','=','purchase_orders.product_id');
            })
            ->paginate(5);

        return view('PurchaseOrder.index', compact('produtos','purchase_orders','datas'));
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

    public function getProductImages()
    {
        return response()->json(Product::orderBy('name', 'ASC')->get());
    }

    public function savePurchaseOrder(Request $request)
    {

        $dados = $request->all();

        if(!empty($dados['lista_produtos'])) {
            foreach ($dados['lista_produtos'] as $key => $dado) {
                if($dado['product_id'] && $dado['measure_id']) {
                    $confPrd = ConfProductMeasurementsQuantities::where('product_id',$dado['product_id'])->where('measure_id',$dado['measure_id'])->get()->toarray();
                    if($dados['lista_produtos'][$key]['qtde']) {
                        $dados['lista_produtos'][$key]['qtde'] = $dado['qtde'] * $confPrd[0]['qtde'];
                    }
                    $dados['lista_produtos'][$key]['created_at'] = $this->data_atual;
                }
            }

            if($dados['lista_produtos'][0]['created_at']) {
                $result = PurchaseOrder::insert($dados['lista_produtos']);
            }
        }

        return response($result, 200);
    }

}
