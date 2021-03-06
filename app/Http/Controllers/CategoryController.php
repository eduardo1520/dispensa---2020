<?php

namespace App\Http\Controllers;

use App\Brand;
use App\User;
use Illuminate\Http\Request;
use App\Category;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorias = Category::all();
        return view('categories.index', compact('categorias'));
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
        foreach ($request->all() as $categoria) {
            foreach ($categoria as $c) {
                $data[$c['name']] = $c['value'];
            }
        }

        $validacao = \Validator::make($data,[
            'tipo' => 'required|string|max:50'
        ]);

        if($validacao->fails()){
            return redirect()->back()->withErrors($validacao)->withInput();
        }

        $resultado = Category::create($data);

        if($resultado) {
            return response($resultado,200);
        } else {
            return response('Erro ao cadastrar a categoria',500);
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
        $data = Category::find($id);
        return response($data);
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
        $data = $request->all();
        $validacao = \Validator::make($data,[
            'tipo' => 'required|string|max:50'
        ]);

        if($validacao->fails()){
            return redirect()->back()->withErrors($validacao)->withInput();
        }

        $resultado = Category::find($id)->update($data);
        return response($resultado);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $resultado = Category::find($id)->delete();
        return response($resultado);
    }

    public function novo()
    {
        return view('categories.category');
    }

    public function categoryAjax()
    {
        $comboCategorySql = Category::select('id','tipo')->orderby('tipo','asc')->get();
        return response($comboCategorySql,200);
    }
}
