<?php

namespace App\Http\Controllers;
use App\Category;
use App\Product;
use App\Brand;
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
        $marcas = Brand::orderBy('name','asc')->get();
        $comboBrandSql = Brand::orderby('name','asc')->pluck('name', 'id');
        $comboProductSql = Product::orderby('name','asc')->pluck('name', 'id');


        return view('products.index',compact('produtos','marcas','comboBrandSql','comboProductSql'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $titulo = "Cadastrar Produto";
        $marcas = Brand::orderBy('name','asc')->get();
        $comboBrandSql = Brand::orderby('name','asc')->pluck('name', 'id');
        $comboCategorySql = Category::orderby('tipo','asc')->pluck('tipo', 'id');
        return view('products.product', compact('titulo', 'marcas','comboBrandSql','comboCategorySql'));
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

        if(!empty($data['pesquisar'])) {
            $filtros = $this->getFiltros($data);
            $produtos = \DB::select("select p.id, p.name, p.description, p.image, p.brand_id, p.category_id, b.name as marca, c.tipo from products p
                                    left join brands b on b.id = p.brand_id left join categories c on c.id = p.category_id {$filtros}" . " order by p.name asc");
            $pesquisa = $request->all();
            $comboBrandSql = Brand::orderby('name','asc')->pluck('name', 'id');
            $comboProductSql = Product::orderby('name','asc')->pluck('name', 'id');
            return view('products.index',compact('produtos','pesquisa','comboBrandSql','comboProductSql'));
        }

        $validacao = \Validator::make($data,[
            'name' => 'required|string|max:50'
        ]);

        if(!empty($data->category_id)) {
            $data->category_id = Product::OUTROS;
        }
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
                    } else {
                        $data['image'] = '';
                    }
                } else {
                    $data['image'] = '';
                }
            }
        } else {
            $data['image'] = '';
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
        $produto = Product::find($id);
        $titulo = 'Atualizar Produto';
        $marcas = Brand::orderBy('name','asc')->get();
        $comboBrandSql = Brand::orderby('name','asc')->pluck('name', 'id');
        $comboCategorySql = Category::orderby('tipo','asc')->pluck('tipo', 'id');
        return view('products.product', compact('produto','titulo','marcas','comboBrandSql','comboCategorySql'));
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
            'name' => 'required|string|max:50'
        ]);

        if($validacao->fails()){
            return redirect()->back()->withErrors($validacao)->withInput();
        }

//      Verificando se o usuário atualizou a imagem
        $product = Product::find($id);
        $produto = strtolower(trim(str_replace(' ', '', $this->removeAcentuacao($product->name))));
        $images = scandir("files/");
        if ($images){
            foreach ($images as $index => $image) {
                if(!in_array($image,['.','..'])) {
                      $arr = array_filter(explode($produto,$image));
                    if(!empty($arr)) {
                        $filename = "files/{$image}";
                        $imagem_formatada = trim(str_replace(' ', '', $this->removeAcentuacao($image)));
                        $resposta = @rename($filename, 'files/products/'.strtolower("{$imagem_formatada}"));
                        if($resposta) {
                            if(file_exists($product->image)) {
                                unlink($product->image);
                            }
                            $data['image'] = 'files/products/'.strtolower($imagem_formatada);
                            $resposta = $product->update($data);
                            if($resposta)
                                return redirect()->route('product.index')->with('success','Produto atualizado com sucesso!');
                            return back()->with('error','Erro ao atualizar o produto!');
                        }
                    }
                }
            }
        }

        if($data['name']) {
            $images = scandir("files/products");
            $extensao = substr($product->image, -4);
            $imagem_old = preg_replace("/[^0-9]/", "", $product->image);
            $imagem_new = "files/products/{$data['name']}{$imagem_old}{$extensao}";
            $novo = strtolower(trim(str_replace(' ', '', $this->removeAcentuacao($imagem_new))));
            if(!empty($images)) {
                foreach ($images as $image) {
                    if(!in_array($image,['.','..'])) {
                        $arr = array_filter(explode($product->name,$image));
                        if(!empty($arr)) {
                            @rename($product->image,$novo);
                            $data['image'] = $novo;
                        }
                    }
                }
            }
        }

        if(empty($data['category_id'])) {
            $data['category_id'] = Product::getFieldDefault();
        }

        $resposta = $product->update($data);

        if($resposta)
            return redirect()->route('product.index')->with('success','Produto atualizado com sucesso!');
        return back()->with('error','Erro ao atualizar o produto!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);

//      Remove a imagem associada ao produto
        if($product->image) {
            unlink($product->image);
        }

        $produto = $product->delete();
        if($produto) {
            return response($produto,200);
        } else {
            return response('Erro ao excluir o produto!',500);
        }
    }

    /**
     * Requisição: ajax
     */
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
                    $fileName = trim(str_replace(' ', '', $this->removeAcentuacao($request['name']))).time() .'.' . $extension;
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
        }
    }

    private function removeAcentuacao($string)
    {
        return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/", "/(Ç)/","/(ç)/"),explode(" ","a A e E i I o O u U n N C c"),$string);
    }

    /**
     * Requisição: ajax
     */
    public function removeProdutos()
    {
        $images = scandir("files");
        if(!empty($images)) {
            foreach ($images as $image) {
                if(!in_array($image,['.','..','products'])) {
                    $filename = "files/{$image}";
                    if(file_exists($filename)) {
                        unlink($filename);
                    }
                }
            }
        }
    }

    protected function getFiltros($dados)
    {
        $sql[] = 'WHERE 1 = 1';
        if(!empty($dados)) {
            foreach ($dados as $campo => $dado) {
                if(!in_array($campo,['_token','pesquisar'])){
                    switch ($campo){
                        case 'name':
                        case 'description':
                            if($dado) {
                                $sql[] = "AND (p.{$campo} like '%{strtolower($dado)}%' OR p.{$campo} like '%{$dado}%')";
                            }
                            break;
                        default:
                            if(is_array($dado)) {
                                $sql[] = "AND p.{$campo} IN ('" . implode("','",$dado) . "')";
                            } else {
                                $sql[] = "AND p.{$campo} = '{$dado}'";
                            }
                    }
                }
            }
        }
        return implode(' ', $sql);
    }

    public function productAjax()
    {
        $comboProductSql = Product::select('id','name')->orderby('name','asc')->get();
        return response($comboProductSql,200);
    }

    public function productImageAjax(Request $request)
    {
        if($request->id && $request->name) {
            $productSql = Product::select('id','name','image','description')->where('id','=',$request->id)->orWhere('name','like',"%{$request->name}%")->orderby('name','asc')->get();
            return response($productSql,200);
        }

        return response('Imagem não encontrada!',500);
    }

    public function productCategoryAjax(Request $request)
    {
        if(!empty($request['id'])) {
            $produto = Product::find($request['id']);
            if($produto) {
                $dados = $produto->category->tipo;
                return response($dados,200);
            }
            return response('Categoria não encontrada!',200);
        }
        return response('Erro:',500);
    }
}
