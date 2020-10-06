<?php

namespace App\Http\Controllers;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produtos = Product::paginate(10);
        return view('products.index',compact('produtos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $titulo = "Cadastrar Produto";
        return view('products.product', compact('titulo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $validacao = \Validator::make($data,[
            'name' => 'required|string|max:50'
        ]);

        if($validacao->fails()){
            return redirect()->back()->withErrors($validacao)->withInput();
        }

        $images = scandir("files");
        if($images) {
            foreach($images as $img){
                if(!in_array($img, array(".", "..","products"))){
                    $filename = "files/{$img}";
                    $info = pathinfo($filename);
                    if(file_exists($filename)) {
                        $resposta = rename($filename, 'files/products/'.strtolower($info['basename']));
                    }
                    if($resposta) {
                        $data['image'] = 'files/products/'. strtolower($info['basename']);
                    }
                }
            }
        }

        $resposta = Product::create($data);

        if($resposta)
            return redirect()->route('product.index')->with('success','Produto criado com sucesso!');
        return back()->with('error','Erro ao criar o produto!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $produto = Product::find($id);
        return response($produto);
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
        $produto = Product::find($id)->delete();
        if($produto) {
            return response($produto,200);
        } else {
            return response('Erro ao excluir o produto!',500);
        }
    }

    public function uploadFiles(Request $request){

        // Upload path
        $destinationPath = 'files/';
        if($request['request'] == '1'){
            if($request->hasFile('file')) {
                // Create directory if not exists
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                // Get file extension
                $extension = $request->file('file')->getClientOriginalExtension();
                // Valid extensions
                $validextensions = array("jpeg","jpg","png","pdf");
                // Check extension
                if(in_array(strtolower($extension), $validextensions)){
                    // Rename file
                    $fileName = $request['name'].time() .'.' . $extension;
                    // Uploading file to given path
                    $resposta = $request->file('file')->move($destinationPath, $fileName);
                }

                if($resposta) {
                    return response('success',200);
                }
                else {
                    return response('error',500);
                }
            }
        } else {

//            $filename = "{$destinationPath}{$request->name}";
//            unlink($filename);
        }
    }
}
