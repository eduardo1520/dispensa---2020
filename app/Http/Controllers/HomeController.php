<?php

namespace App\Http\Controllers;

use App\Brand;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::count();
        $termMeasure = \DB::select('CALL sp_prazo_pedidos()');

//        \DB::statement("SET SQL_MODE=''");
//
//        $categories_products = \DB::select('select * from vw_categorias_produtos');

        $widget = [
            'users' => $users,
            'termMeasure' => $termMeasure,
//            'categories_products' => $categories_products
        ];

        return view('home', compact('widget'));
    }

    public function getConsumeProductsAjax()
    {
        \DB::statement("SET SQL_MODE=''");

        $consume_products = \DB::select('select * from vw_quantidade_produtos');

        return response($consume_products,200);

    }

    public function getCategoriasProductsAjax()
    {
        \DB::statement("SET SQL_MODE=''");

        $categories_products = \DB::select('select * from vw_categorias_produtos');

        return response($categories_products,200);
    }

    public function getMarcasProductsAjax()
    {
        \DB::statement("SET SQL_MODE=''");

        $marcas_products = Brand::select('name')->get()->toArray();
        $texto = null;
        foreach($marcas_products as $marcas) {
            $texto .= $marcas['name'] . " ";

        }
        $texto = rtrim($texto, ' ');

        return response($texto,200);
    }

    public function getQuantidadesMesAjax()
    {
        \DB::statement("SET SQL_MODE=''");

        $categories_products = \DB::select('select * from vw_quantidade_produtos_mes vw order by vw.qtde desc');

        return response($categories_products,200);

    }
}
