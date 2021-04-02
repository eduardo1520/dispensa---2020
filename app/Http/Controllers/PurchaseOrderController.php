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
                                                    end as status, cast( purchase_orders.created_at as date) as dt"))
                                ->where('purchase_orders.status','P')->distinct()->get();

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
                })->whereRaw("cast(purchase_orders.created_at as date) ='{$d['dt']}'")->where('purchase_orders.status','P')
                ->union(PurchaseOrder::select('purchase_orders.*','measures.nome as measure_nome', 'products.name as product_name',
                    'products.image','categories.tipo as categories_nome',
                    'measures.sigla','conf_product_measurements_quantities.qtde as qtde_default')
                    ->join('measures','measures.id','purchase_orders.measure_id')
                    ->join('products','products.id','purchase_orders.product_id')
                    ->join('categories','categories.id','purchase_orders.category_id')
                    ->join('conf_product_measurements_quantities', function($join){
                        $join->on('conf_product_measurements_quantities.measure_id','=','purchase_orders.measure_id');
                        $join->on('conf_product_measurements_quantities.product_id','=','purchase_orders.product_id');
                    })->whereRaw("cast(purchase_orders.created_at as date) ='{$d['dt']}'")->where('purchase_orders.status','A'))
                ->distinct()->get()->toArray();
            $purchase_orders[strtotime($d['dt']). "_{$d['status']}"][strtotime($d['dt'])] = $order;
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

        \DB::statement("SET SQL_MODE=''");

        $comboPeriodSql = PurchaseOrder::select(\DB::raw('id, cast( created_at as date) as dt'))->withTrashed()->groupBy('dt')->get();

        if($dados['pesquisar']) {

            if(isset($dados['id']) && count($dados['id']) >= 1 || isset($dados['status']) && count($dados['status']) >= 1) {

                if(isset($dados['id']) && count($dados['id']) >= 1) {
                    $dt = " and cast(po.created_at as date)  IN ('" . implode("','", $dados['id']). "')";
                } else {
                    $dt = null;
                }

                if(isset($dados['status']) && count($dados['status']) >= 1) {
                    $status = " and po.status IN ('" . implode("','", $dados['status']). "')";
                } else {
                    $status = " and po.status IN ('P','A')";
                }

                if(isset($dados['status']) && count($dados['status']) >= 1) {
                    $status2 = " and po.status IN ('" . implode("','", $dados['status']). "')";
                } else {
                    $status2 = " and po.status IN ('C')";
                }

                $purchase =  \DB::select(\DB::raw("
                    (select
                        case po.status when 'P' then 'Aguardando aprovação' when 'C' then 'Cancelado' when 'A' then 'Aprovado' end as status_name,
                        po.status, cast(po.created_at as date) as dt, po.created_at, po.deleted_at, po.id, po.qtde, po.description, m.nome as measure_nome,
                        m.sigla, p.name as product_name, p.image, c.tipo as categories_nome, cpm.qtde as qtde_default
                    from pantry.purchase_orders po
                    inner join measures m on po.measure_id = m.id
                    inner join products p on po.product_id = p.id
                    inner join categories c on po.category_id = c.id
                    inner join conf_product_measurements_quantities cpm on cpm.measure_id = m.id and cpm.product_id = p.id
                    where 1 = 1
                    $dt
                    $status
                    )union(
                        select
                            case po.status when 'P' then 'Aguardando aprovação' when 'C' then 'Cancelado' when 'A' then 'Aprovado' end as status_name,
                            po.status, cast(po.created_at as date) as dt, po.created_at, po.deleted_at, po.id, po.qtde, po.description, m.nome as measure_nome,
                            m.sigla, p.name as product_name, p.image, c.tipo as categories_nome, cpm.qtde as qtde_default
                        from pantry.purchase_orders po
                        inner join measures m on po.measure_id = m.id
                        inner join products p on po.product_id = p.id
                        inner join categories c on po.category_id = c.id
                        inner join conf_product_measurements_quantities cpm on cpm.measure_id = m.id and cpm.product_id = p.id
                        where 1 = 1
                        $dt
                        $status2
                        group by po.product_id
                    )
                "));

                foreach ($purchase as $idx => $p) {
                    if($p->status == 'A') {
                        $date = Carbon::parse($p->deleted_at)->setTimezone('America/Sao_Paulo');
                        $p->deleted_at_br = $date->format('d/m/Y H:i:s');
                        $purchase_orders[strtotime($date->format('Y-m-d H:i:s')) . "_". $p->status_name][strtotime($p->dt)][] = (array) $p;
                    } else {
                        $date = Carbon::parse($p->created_at)->setTimezone('America/Sao_Paulo');
                        $p->created_at_br = $date->format('d/m/Y H:i:s');
                        $purchase_orders[strtotime($date->format('Y-m-d')) . "_". $p->status_name][strtotime($p->dt)][] = (array) $p;
                    }

                }

            } else {
                return $this->index();
            }
        }

        return view('purchaseOrder.index', compact('purchase_orders', 'comboPeriodSql'));
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
                $product->update(['status' => 'C']);
                $result = $product->delete();
            }
            return response($result, 200);
        }

        $dados['created_at'] = date('Y-m-d', $dados['created_at']);

        $product = PurchaseOrder::where('id',$id)->whereRaw("cast(created_at as date) = '{$dados['created_at']}'");

        if($product) {
            $product->update(['status' => 'C']);
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
                    if(isset($dados['lista_produtos'][$key]['qtde']) && isset($confPrd[0]['qtde'])) {
                        $dados['lista_produtos'][$key]['qtde'] = $dado['qtde'] * $confPrd[0]['qtde'];
                    }
                    $dados['lista_produtos'][$key]['created_at'] = $this->data_atual;
                }
            }

            if(isset($dados['lista_produtos'][0]['created_at'])) {
                $result = PurchaseOrder::insert($dados['lista_produtos']);
            }
        }

        return response($result, 200);
    }

    public function getQueryListAjax()
    {
        $dados = [];

        $obj = PurchaseOrder::select(\DB::raw("case purchase_orders.status
                                                    when 'P' then 'Aguardando aprovação'
                                                    when 'C' then 'Cancelado'
                                                    when 'A' then 'Aprovado'
                                                    end as status, cast( purchase_orders.created_at as date) as dt"))->where('purchase_orders.status',['P'])->distinct();

        $dados[] = $obj->toSql();

        $datas = $obj->get();

        $dados[] = PurchaseOrder::select('purchase_orders.*','measures.nome as measure_nome', 'products.name as product_name',
            'products.image','categories.tipo as categories_nome',
            'measures.sigla','conf_product_measurements_quantities.qtde as qtde_default')
            ->join('measures','measures.id','purchase_orders.measure_id')
            ->join('products','products.id','purchase_orders.product_id')
            ->join('categories','categories.id','purchase_orders.category_id')
            ->join('conf_product_measurements_quantities', function($join){
                $join->on('conf_product_measurements_quantities.measure_id','=','purchase_orders.measure_id');
                $join->on('conf_product_measurements_quantities.product_id','=','purchase_orders.product_id');
            })->whereRaw("cast(purchase_orders.created_at as date) ='?'")->where('purchase_orders.status','P')
            ->union(PurchaseOrder::select('purchase_orders.*','measures.nome as measure_nome', 'products.name as product_name',
                'products.image','categories.tipo as categories_nome',
                'measures.sigla','conf_product_measurements_quantities.qtde as qtde_default')
                ->join('measures','measures.id','purchase_orders.measure_id')
                ->join('products','products.id','purchase_orders.product_id')
                ->join('categories','categories.id','purchase_orders.category_id')
                ->join('conf_product_measurements_quantities', function($join){
                    $join->on('conf_product_measurements_quantities.measure_id','=','purchase_orders.measure_id');
                    $join->on('conf_product_measurements_quantities.product_id','=','purchase_orders.product_id');
                })->whereRaw("cast(purchase_orders.created_at as date) ='?'")->where('purchase_orders.status','A'))
                ->distinct()->toSql();

        return response($dados, 200);

    }

}
