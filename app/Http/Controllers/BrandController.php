<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\Brand;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $marcas = Brand::paginate(10);
        return view('brands.index', compact('marcas'));
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
        foreach ($request->all() as $marca) {
            foreach ($marca as $m) {
                $data[$m['name']] = $m['value'];
            }
        }

        $validacao = \Validator::make($data,[
            'name' => 'required|string|max:50'
        ]);

        if($validacao->fails()){
            return redirect()->back()->withErrors($validacao)->withInput();
        }

        //Validar caso exista a marca e esteja inativada no sistema.
        $brand = Brand::withTrashed()->where('name', $data['name'])->restore();
        if(!empty($brand)) {
            return response(true,200);
        }

        $resultado = Brand::create($data);

        if($resultado) {
            return response($resultado,200);
        } else {
            return response('Erro ao cadastrar a marca',500);
        }
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


        $resposta = Brand::find($id)->delete();
        if($resposta) {
            return response($resposta,200);
        } else {
            return response('Erro ao excluir a marca',500);
        }
    }
}
