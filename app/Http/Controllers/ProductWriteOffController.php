<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\ProductWriteOff;
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
        $comboCategorySql = Category::select('id','tipo')->orderby('tipo')->get();

        $arr = ProductWriteOff::select(\DB::raw("product_id,category_id, qtde, IFNULL(updated_at,'0') as dt"))->orderby('category_id')->distinct()->get()->toArray();
        foreach ($arr as $p) {
            $status_product[$p['category_id']][] = $p;
        }

        $productAprovate = $this->getPurchaseOrderAprovate();

        $qtdes = [];
        foreach ($productAprovate as $p) {
            $qtdes[$p->tipo][] = $p;
        }

        return view('productWriteOff.index', compact('comboCategorySql','productAprovate','qtdes','status_product'));
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

        \DB::statement("SET SQL_MODE=''");
        $comboCategorySql = Category::select('categories.id','categories.tipo','product_write_offs.updated_at', 'product_write_offs.qtde')
            ->leftjoin("product_write_offs","categories.id","=","product_write_offs.category_id")
            ->groupby('categories.id')
            ->get()->toArray();

        $dados = Category::select('id','tipo')->whereIn('id',$ids)->orderby('tipo','asc')->get()->toArray();

        $arr = ProductWriteOff::select(\DB::raw("product_id,category_id, qtde, IFNULL(updated_at,'0') as dt"))->whereIn('category_id',$ids)->orderby('category_id')->distinct()->get()->toArray();
        foreach ($arr as $p) {
            $status_product[$p['category_id']][] = $p;
        }

        return view('productWriteOff.index', compact('comboCategorySql','productAprovate','qtdes','dados','status_product'));
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
        $dados = $request->all();
        $result = false;
        if(count($dados) == 1 && $id == '999999'){
            $categoria = $dados['category_id'];
            $sql = "
                UPDATE pantry.product_write_offs set qtde = '0', updated_at = now()
                WHERE category_id = $categoria
                AND id > 0
            ";
            $result = \DB::select(\DB::raw($sql));
            ### Insere a notificação
            (new NotificationController())->createNotifications($dados);
        } else {
            $product = ProductWriteOff::where('product_id',$id);
            if(!empty($product)) {
              $result = $product->update($dados);
              ### Insere a notificação
              (new NotificationController())->createNotifications($dados);
            }
        }

        return response($result, 200);
    }

    private function getPurchaseOrderAprovate()
    {
        $sql = "
            SELECT
               off.qtde, p.description, p.id, p.name, p.image, c.id as cod_categoria, c.tipo, m.nome, m.sigla, IFNULL(date_format(off.updated_at,'%d/%m/%Y %H:%m'),date_format(off.created_at,'%d/%m/%Y %H:%m')) as dt
            FROM pantry.product_write_offs off
            INNER JOIN pantry.products p ON off.product_id = p.id
            INNER JOIN pantry.categories c ON off.category_id = c.id
            INNER JOIN pantry.measures m ON off.measure_id = m.id
        ";

        $dados = \DB::select(\DB::raw($sql));

        return $dados;
    }

    private function getPurchaseOrderAprovateFiltro($category)
    {
        $cat = "'" . implode("','",$category) . "'";
        $sql = "
            SELECT
               off.qtde, p.description, p.id, p.name, p.image, c.id as cod_categoria, c.tipo, m.nome, m.sigla, date_format(off.created_at,'%d/%m/%Y %H:%m') as dt
            FROM pantry.product_write_offs off
            INNER JOIN pantry.products p ON off.product_id = p.id
            INNER JOIN pantry.categories c ON off.category_id = c.id
            INNER JOIN pantry.measures m ON off.measure_id = m.id
            WHERE off.category_id in ($cat)
        ";

        $dados = \DB::select(\DB::raw($sql));

        return $dados;
    }
}
