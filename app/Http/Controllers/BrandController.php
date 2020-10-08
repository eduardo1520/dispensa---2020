<?php

namespace App\Http\Controllers;

use App\Category;
use App\Measure;
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
        $marca = Brand::find($id);
        return response($marca,200);
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
        foreach ($request->all() as $marcas) {
            foreach ($marcas as $marca) {
                $data[$marca['name']] = $marca['value'];
            }
        }

        $validacao = \Validator::make($data,[
            'name' => 'required|string|max:50'
        ]);

        if($validacao->fails()){
            return redirect()->back()->withErrors($validacao)->withInput();
        }

        //Verifica se a marca já existe e está inativa
        //Caso a marca exista inativa a atual e ativa a inativada.

        $brand = Brand::withTrashed()->where('name','=',$data['name'])->first();
        if(!empty($brand->name)) {
            $brand = Brand::withTrashed()->where('name', $data['name'])->restore();
            if(!empty($brand)) {
                $brand_atual = Brand::where('name','=',$data['name-old'])->first();
                $resultado = Brand::find($brand_atual->id)->delete();
                if($resultado) {
                    return response(true,200);
                } else {
                    return response('Erro ao atualizar a marca',500);
                }
            }
        }

        $resultado = Brand::find($id)->update($data);
        if($resultado) {
            return response($resultado,200);
        } else {
            return response('Erro ao atualizar a marca',500);
        }
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

    public function marcas()
    {
        return Brand::all()->pluck('id', 'name')->toJson();
    }
}
