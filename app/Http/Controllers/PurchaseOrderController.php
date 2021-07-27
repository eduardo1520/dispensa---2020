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
        $status = ['status' => 'P'];
        $datas = $this->getPurchaseDate($status);
        $qtdes = [];
        $purchase_orders = null;

        $now = Carbon::now();

        foreach ($datas as $d) {
            $dt_create = Carbon::parse($d['created_at']);
            $diff = $now->diffInDays($dt_create);
            if($diff >= 0 && $diff <= 10) {
                $order = $this->getListPurchase([$d['dt']],["P"]);
                foreach ($order as $o) {
                    $purchase_orders[$o['user_id'] . "_" .strtotime($d['dt']). "_{$d['status']}"][strtotime($d['dt'])][$o['id']]= $o;
//                    $qtdes[$o['user_id']][$o['id']] = $o;
                    $qtdes[$o['user_id']][$o['created_at']][$o['id']] = $o;
                }
            }
        }
        $this->removeListaPurchaseOld($now, $datas);

        return view('PurchaseOrder.index', compact('produtos','purchase_orders','datas','comboPeriodSql','qtdes'));
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
            $qtdes = null;
            if (isset($dados['id']) && count($dados['id']) >= 1 && empty($dados['status'])) {
                #dd($dados['id']);
                foreach ($dados['id'] as $d) {
                    $order = $this->getListPurchase([$d], ['A','C','P']);
                    #dd($order);
                    if(count($order) > 0) {
                        foreach ($order as $o) {
                            if($o['status'] == 'A' || $o['status'] == 'P') {
//                                $arr = [];
//                                foreach ($order as $i) {
//                                    if($i['status'] != 'C') {
//                                        $arr[] = $i;
//                                    }
//                                }
//                                $purchase_orders[$o['user_id'] . "_" . strtotime($d) . "_{$this->getTextSigle($o['status'])}"][strtotime($d)] = $o;
////                                $qtdes[$o['user_id']][$o['id']] = $o;
//                                $qtdes[$o['user_id']][strtotime($o['created_at'])][$o['id']] = $o;
                            } else {
//                              $arr = [];
//                              foreach ($order as $i) {
//                                if($i['status'] == 'C') {
//                                    $arr[] = $i;
//                                }
//                              }
//
//                              $purchase_orders[$o['user_id'] . "_" . strtotime($arr[0]['deleted_at']) . "_{$this->getTextSigle($o['status'])}"][strtotime($arr[0]['deleted_at'])] = $o;
////                              $qtdes[$o['user_id']][$o['id']] = $o;
//                              $qtdes[$o['user_id']][strtotime($o['deleted_at'])][$o['id']] = $o;
                            }
                        }
                    }
                }
            } elseif (isset($dados['status']) && count($dados['status']) >= 1 && empty($dados['id'])) {
                foreach ($dados['status'] as $k => $s) {
                    $datas = $this->getPurchaseDate([$s]);
                    foreach ($datas as $idx => $d) {
                        $order = $this->getListPurchase([$d['dt']], [$s]);
                        if (count($order) > 0) {
                            foreach ($order as $o) {
                                if ($s == 'A') {
                                    $data_ini = Carbon::parse($order[0]['created_at'])->format('Y-m-d');
                                    $purchase_orders[$o['user_id'] . "_" . strtotime($data_ini) . "_{$this->getTextSigle($s)}"][strtotime($data_ini)][$o['id']] = $o;
//                                    $qtdes[$o['user_id']][$o['id']] = $o;
                                    $qtdes[$o['user_id']][strtotime($data_ini)][$o['id']] = $o;
                                }elseif($s == 'C'){
                                    $purchase_orders[$o['user_id'] . "_" . strtotime($order[0]['deleted_at']) . "_{$this->getTextSigle($s)}"][strtotime($order[0]['deleted_at'])][$o['id']] = $o;
                                    $qtdes[$o['user_id']][strtotime($o['deleted_at'])][$o['id']] = $o;
                                } else {
                                    $purchase_orders[$o['user_id'] . "_" . strtotime($d['dt']) . "_{$this->getTextSigle($s)}"][strtotime($d['dt'])][$o['id']] = $o;
//                                    $qtdes[$o['user_id']][$o['id']] = $o;
                                    $qtdes[$o['user_id']][strtotime($o['created_at'])][$o['id']] = $o;
                                }
                            }
                        }
                    }
                }
//                dd($purchase_orders);
            } elseif (isset($dados['id']) && count($dados['id']) >= 1 && isset($dados['status']) && count($dados['status']) >= 1) {
                // Validar este cenário....
                $dts = '';
                foreach ($dados['id'] as $dt) {
                    $dts .= $dt . ",";
                }

                $dts = array_filter(explode(',', $dts));

                $status = '';
                foreach ($dados['status'] as $t) {
                    $status .= $t . ",";
                }

                $status = array_filter(explode(',', $status));

                $order = $this->getListPurchase($dts, $status);

                if (count($order) > 0) {
                    foreach ($dts as $dt) {
                        foreach ($order as $p) {
                            $data_ini = Carbon::parse($p['created_at'])->format('Y-m-d');
                            $data_fim = Carbon::parse($p['created_at'])->format('Y-m-d H:i:s');
                            if ($dt == $data_ini) {
                                if ($p['status'] == 'A' || $p['status'] == 'C') {
                                    $purchase_orders[strtotime($data_fim) . "_{$this->getTextSigle($p['status'])}"][strtotime($data_fim)][] = $p;
                                    $qtdes[strtotime($data_fim)] = count($purchase_orders[strtotime($data_fim) . "_{$this->getTextSigle($p['status'])}"][strtotime($data_fim)]);
//                                    $qtdes[$p['user_id']][$p['created_at']][$p['id']] = $p;
                                } else {
                                    $purchase_orders[strtotime($data_ini) . "_{$this->getTextSigle($p['status'])}"][strtotime($data_ini)][] = $p;
                                    $qtdes[strtotime($data_ini)] = count($purchase_orders[strtotime($data_ini) . "_{$this->getTextSigle($p['status'])}"][strtotime($data_ini)]);
//                                    $qtdes[$p['user_id']][$p['created_at']][$p['id']] = $p;
                                }
                            }
                        }
                    }
                    $qtdes = array_values($qtdes);
                }
            } else {
                return $this->index();
            }
        }
        return view('purchaseOrder.index', compact('purchase_orders', 'comboPeriodSql','qtdes'));
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
        $remove = '';
        if($id == '999999') {
            $data = date('Y-m-d', $dados['created_at']);
            $lists = PurchaseOrder::select('id')->whereRaw("cast(purchase_orders.created_at as date) ='{$data}'")->get();
            foreach ($lists as $l) {
                $product = PurchaseOrder::where('id',$l->id)->whereRaw("cast(created_at as date) = '{$data}'");
                if($product) {
                    $product->update(['status' => 'C']);
                    $remove= $product->delete();
                }
            }
            return response($remove, 200);
        } else {
            $data = date('Y-m-d', $dados['created_at']);
            $product = PurchaseOrder::where('id',$id)->whereRaw("cast(created_at as date) = '{$data}'");
            if($product) {
                $product->update(['status' => 'C']);
                $result= $product->delete();
            }
            return response($result, 200);
        }
    }

    public function getProductImages()
    {
        return response()->json(Product::orderBy('name', 'ASC')->get());
    }

    public function savePurchaseOrder(Request $request)
    {
        $dados = $request->all();
        $result = null;

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

    // A data tem que vim no formato americano
    // Aceita várias datas separadas por virgulas

    protected function getCountForDate($data)
    {
        $sql = "
            select
                count(po.created_at) as qtde, po.created_at, po.deleted_at
            from pantry.purchase_orders po
            inner join pantry.products p on po.product_id = p.id
            inner join pantry.measures m on po.measure_id = m.id
            inner join pantry.categories c on po.category_id = c.id
            inner join conf_product_measurements_quantities cp on cp.measure_id = po.measure_id and cp.product_id = po.product_id
            where 1 = 1
            and cast(po.created_at as date) IN ($data)
            group by po.created_at
            order by po.status desc
        ";

        $dados = \DB::select(\DB::raw($sql));

        foreach ($dados as $d) {
            $qtdes[isset($d->deleted_at) ? strtotime($d->deleted_at) : strtotime($d->created_at)][] = (array) $d;
        }

        return $qtdes;

    }

    protected function getTextSigle($sigle)
    {

        if($sigle == 'A') {
            $sigle_text = 'Aprovado';
        } elseif($sigle == 'P') {
            $sigle_text = 'Aguardando aprovação';
        } else {
            $sigle_text = 'Cancelado';
        }

        return $sigle_text;

    }

    protected function getPurchaseDate($tipo)
    {
        $datas = PurchaseOrder::withTrashed()->select(\DB::raw("case purchase_orders.status
                                                    when 'P' then 'Aguardando aprovação'
                                                    when 'C' then 'Cancelado'
                                                    when 'A' then 'Aprovado'
                                                    end as status, cast( purchase_orders.created_at as date) as dt, purchase_orders.created_at"))
                ->whereIn('purchase_orders.status',$tipo)
                ->distinct()->get()->toArray();
        return $datas;
    }

    protected  function getListPurchase($data,$status)
    {

        $data = "'" . implode("','", $data) . "'";
        $status = "'" . implode("','", $status) . "'";

        $usuario = \Auth::user();
//        dd(\Auth::check());
        if($usuario['admin'] == 'N') {
            $id = " AND `users`.`id` = {$usuario['id']}";
        } else {
            $id = '';
        }

        $sql = "
            SELECT
              purchase_orders.id,purchase_orders.description,purchase_orders.qtde,purchase_orders.created_at,purchase_orders.deleted_at,
              purchase_orders.status,measures.nome as measure_nome,products.name as product_name,concat(users.name,' ', users.last_name) as nome_completo, users.id as user_id,users.sexo,
              products.image,categories.tipo as categories_nome,
              measures.sigla,conf_product_measurements_quantities.qtde as qtde_default
            FROM `purchase_orders`
            INNER JOIN `measures` ON `measures`.`id` = `purchase_orders`.`measure_id`
            INNER JOIN `products` ON `products`.`id` = `purchase_orders`.`product_id`
            INNER JOIN `categories` ON `categories`.`id` = `purchase_orders`.`category_id`
            INNER JOIN `users` ON `users`.`id` = `purchase_orders`.`user_id`
            INNER JOIN `conf_product_measurements_quantities`
            ON `conf_product_measurements_quantities`.`measure_id` = `purchase_orders`.`measure_id`
            AND `conf_product_measurements_quantities`.`product_id` = `purchase_orders`.`product_id`
            WHERE DATE(purchase_orders.created_at) IN ($data)
            AND `purchase_orders`.`status` IN ($status)
            $id
            GROUP BY `purchase_orders`.`product_id`
        ";

        $order =   \DB::select(\DB::raw($sql));

        $order = array_map(function($obj) {
            return $obj = (array) $obj;
        }, $order);

        return $order;

    }

    private function removeListaPurchaseOld($now, $datas)
    {
        \DB::statement("SET SQL_MODE=''");
        foreach ($datas as $d) {
            $dt_create = Carbon::parse($d['created_at']);
            $diff = $now->diffInDays($dt_create);
            if($diff < 0 || $diff > 10) {
                $remove = "
                    UPDATE pantry.purchase_orders SET deleted_at = now(), status = 'C'
                    WHERE cast(purchase_orders.created_at as date) = '{$d['dt']}' and id <> '0'
                ";
                \DB::select(\DB::raw($remove));
            }
        }
    }

    public function aprovaListaPedidosAjax(Request $request, $id)
    {
        $dados = current($request->all());
        if($dados['codigo'] == '111111') {
            $dt_create = Carbon::parse($dados['data'])->format('Y-m-d');
            $dt_atual = Carbon::now()->format('Y-m-d H:i:s');
            $aprovados = PurchaseOrder::whereRaw("cast(created_at as date) = '{$dt_create}'")->where('user_id',$dados['user']);

            // Atualiza a lista de pedidos
            $resultado = $aprovados->update(['updated_at' => $dt_atual,'status' => 'A']);

            return response($resultado, 200);
        }
    }
}
