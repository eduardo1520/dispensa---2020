<?php

namespace App\Http\Controllers;

use App\ConfProductMeasurementsQuantities;
use App\Product;
use App\PurchaseOrder;
use Illuminate\Http\Request;
Use Carbon\Carbon;


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

        \DB::statement("SET SQL_MODE=''");

        $comboPeriodSql = PurchaseOrder::select(\DB::raw('id, cast( created_at as date) as dt'))->withTrashed()->groupBy('dt')->get();

        $produtos = Product::orderBy('name', 'ASC')->get();
        $datas = PurchaseOrder::select(\DB::raw("case purchase_orders.status
                                                    when 'P' then 'Aguardando aprovação'
                                                    when 'C' then 'Cancelado'
                                                    when 'A' then 'Aprovado'
                                                    end as status, cast( purchase_orders.created_at as date) as dt"))->distinct()->get();

        foreach ($datas as $k => $d) {
            $order = PurchaseOrder::select('purchase_orders.*','measures.nome as measure_nome', 'products.name as product_name',
                                           'products.image','categories.tipo as categories_nome',
                                           'measures.sigla','conf_product_measurements_quantities.qtde as qtde_default')
                ->join('measures','measures.id','purchase_orders.measure_id')
                ->join('products','products.id','purchase_orders.product_id')
                ->join('categories','categories.id','purchase_orders.category_id')
                ->join('conf_product_measurements_quantities', function($join){
                    $join->on('conf_product_measurements_quantities.measure_id','=','purchase_orders.measure_id');
                    $join->on('conf_product_measurements_quantities.product_id','=','purchase_orders.product_id');
                })->whereRaw("cast(purchase_orders.created_at as date) ='{$d['dt']}'")->distinct()->get();
            $purchase_orders[strtotime($d['dt']). "_{$d['status']}"] = $order;
        }

        return view('PurchaseOrder.index', compact('produtos','purchase_orders','datas','comboPeriodSql'));
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
        $purchase_orders = [];

        if($dados['pesquisar']) {
            if(isset($dados['id']) && count($dados['id']) >= 1) {
                \DB::statement("SET SQL_MODE=''");
                $data = " IN ('" . implode("','", $dados['id']). "')";
                $resultado = PurchaseOrder::withTrashed()
                    ->select(\DB::raw("case purchase_orders.status
                                            when 'P' then 'Aguardando aprovação'
                                            when 'C' then 'Cancelado'
                                            when 'A' then 'Aprovado'
                                            end as status_name, status, cast(created_at as date) as dt"))
                    ->whereRaw("cast(created_at as date) {$data}")->groupBy('dt')->get()->toArray();
                foreach ($resultado as $index => $item) {
                    $purchase = PurchaseOrder::withTrashed()
                        ->select('purchase_orders.*','measures.nome as measure_nome','measures.sigla','products.name as product_name','products.image','categories.tipo as categories_nome','conf_product_measurements_quantities.qtde as qtde_default')
                        ->join('measures','measures.id','purchase_orders.measure_id')
                        ->join('products','products.id','purchase_orders.product_id')
                        ->join('categories','categories.id','purchase_orders.category_id')
                        ->join('conf_product_measurements_quantities', function($join){
                            $join->on('conf_product_measurements_quantities.measure_id','=','purchase_orders.measure_id');
                            $join->on('conf_product_measurements_quantities.product_id','=','purchase_orders.product_id');
                        })
                        ->whereRaw("cast(purchase_orders.created_at as date) = '{$item['dt']}'")->where('status','P')
                        ->union(PurchaseOrder::withTrashed()
                            ->select('purchase_orders.*','measures.nome as measure_nome','measures.sigla','products.name as product_name','products.image','categories.tipo as categories_nome','conf_product_measurements_quantities.qtde as qtde_default')
                            ->join('measures','measures.id','purchase_orders.measure_id')
                            ->join('products','products.id','purchase_orders.product_id')
                            ->join('categories','categories.id','purchase_orders.category_id')
                            ->join('conf_product_measurements_quantities', function($join){
                                $join->on('conf_product_measurements_quantities.measure_id','=','purchase_orders.measure_id');
                                $join->on('conf_product_measurements_quantities.product_id','=','purchase_orders.product_id');
                            })
                            ->whereRaw("cast(purchase_orders.created_at as date) = '{$item['dt']}'")->where('status','C')->groupBy('purchase_orders.product_id'))
                        ->get()->toArray();
                    foreach ($purchase as $idx => $p) {
                        if($p['created_at'] && $p['status'] == 'P') {
                            $date = Carbon::parse($p['created_at'])->setTimezone('America/Sao_Paulo');
                            $p['created_at'][$idx+1] = $date->format('d/m/Y H:i:s');
                            $purchase_orders[strtotime($p['created_at']) . "_". $item['status_name']][] = $p;
                        }

                        if($p['deleted_at'] && $item['status'] == 'C') {
                            $date2 = Carbon::parse($p['deleted_at'])->setTimezone('America/Sao_Paulo');
                            $p['deleted_at'][$idx] = $date2->format('d/m/Y H:i:s');
                            $purchase_orders[strtotime($p['deleted_at']) . "_". $item['status_name']][] = $p;
                        }

                    }

                }
            } else {
                return $this->index();
            }
        }

        return view('purchaseOrder.index', compact('purchase_orders'));
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
    public function destroy(Request $request, $id)
    {
        $dados = $request->all();
        $result = '';

        if($id == '999999') {
            $data = date('Y-m-d', $dados['created_at']);
            $product = PurchaseOrder::whereRaw("cast(created_at as date) = '{$data}'");
            if($product) {
                $result = $product->delete();
            }
            return response($result, 200);
        }

        $dados['created_at'] = date('Y-m-d', $dados['created_at']);

        $product = PurchaseOrder::where('id',$id)->whereRaw("cast(created_at as date) = {$dados['created_at']}");

        if($product) {
            $result= $product->delete();
        }

        return response($result, 200);
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
