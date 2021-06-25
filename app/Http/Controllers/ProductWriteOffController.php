<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class ProductWriteOffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comboCategorySql = Category::select('id','tipo')->orderby('tipo','asc')->get();
        $productAprovate = $this->getPurchaseOrderAprovate();

        $qtdes = [];

        foreach ($productAprovate as $p) {
            $qtdes[$p->tipo][] = $p;
        }

        return view('productWriteOff.index', compact('comboCategorySql','productAprovate','qtdes'));
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

        if($dados['pesquisar']){
            if(!empty($dados['category'])) {
                $categories = $dados['category'];
                $productAprovate = $this->getPurchaseOrderAprovateFiltro($categories);
            } else {
                return $this->index();
            }
        }

        $qtdes = [];
        $ids = [];
        foreach ($productAprovate as $p) {
            $qtdes[$p->tipo][] = $p;
            $ids[] = $p->cod_categoria;
        }

        $comboCategorySql = Category::select('id','tipo')->orderby('tipo','asc')->get()->toArray();
        $dados = Category::select('id','tipo')->whereIn('id',$ids)->orderby('tipo','asc')->get()->toArray();

        return view('productWriteOff.index', compact('comboCategorySql','productAprovate','qtdes','dados'));
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

    private function getPurchaseOrderAprovate()
    {
        $sql = "
            SELECT
               po.qtde, po.description, p.id, p.name, p.image, c.id as cod_categoria, c.tipo, m.nome, m.sigla, date_format(po.created_at,'%d/%m/%Y %h:%m') as dt
            FROM pantry.purchase_orders po
            INNER JOIN pantry.products p ON po.product_id = p.id
            INNER JOIN pantry.categories c ON po.category_id = c.id
            INNER JOIN pantry.measures m ON po.measure_id = m.id
            WHERE po.status = 'A'
        ";

        $dados = \DB::select(\DB::raw($sql));

        return $dados;
    }

    private function getPurchaseOrderAprovateFiltro($category)
    {

        $cat = "'" . implode("','",$category) . "'";
        $sql = "
            SELECT
               po.qtde, po.description, p.id, p.name, p.image, c.id as cod_categoria, c.tipo, m.nome, m.sigla, date_format(po.created_at,'%d/%m/%Y %h:%m') as dt
            FROM pantry.purchase_orders po
            INNER JOIN pantry.products p ON po.product_id = p.id
            INNER JOIN pantry.categories c ON po.category_id = c.id
            INNER JOIN pantry.measures m ON po.measure_id = m.id
            WHERE po.status = 'A'
            AND po.category_id in ($cat)
        ";

        $dados = \DB::select(\DB::raw($sql));

        return $dados;
    }
}
