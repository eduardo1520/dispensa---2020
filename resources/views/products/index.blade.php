@extends('layouts.admin')
@section('main-content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="col-lg-10 order-lg-1">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="pl-lg-4 mt-lg-5">
                    <form action="{{ route('product.store') }}" name="frm-product-pesquisar" method="post" id="frm-product-pesquisar">
                        <input type="hidden" name="pesquisar" value="true">
                        <input type="hidden" name="_token" value="{{ @csrf_token() }}">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="form-control-label" for="name">Produto</label>
                                    <input type="text" id="name" class="form-control" name="name" placeholder="Nome" value="{{ !empty($pesquisa['name']) ? $pesquisa['name'] : old('name') }}">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="form-control-label" for="description">Descrição</label>
                                    <input type="text" id="description" class="form-control" name="description" placeholder="Descrição" value="{{ !empty($pesquisa['description']) ? $pesquisa['description'] : old('description') }}">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="form-control-label" for="brand">Marca</label>
                                    <select name="brand_id" id="brand_id" class="form-control" value="{{ !empty($pesquisa['brand_id']) ? $pesquisa['brand_id'] : old('brand_id') }}">
                                        <option value="" {{ empty($pesquisa['brand_id']) ? 'selected' : ''}}>Selecione</option>
                                        @if(!empty($marcas))
                                            @foreach($marcas as $marca)
                                                <option value="{{$marca->id}}" {{ !empty($pesquisa['brand_id']) && $pesquisa['brand_id'] == $marca->id  ? 'selected' : '' }}>{{ $marca->name }}</option>
                                            @endforeach
                                        @endif
                                        <option value="999">Outros</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="pl-lg-4 mt-lg-5">
                            <div class="row">
                                <div class="col text-center">
                                    <a href="{{ route('product.index') }}" class="btn btn-warning">Limpar</a>
                                    <button type="submit" class="btn btn-primary" id="btn-pesquisar">Pesquisar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Listagens de Produtos</h6>
                </div>
                <div class="card-body">
                    <a href="{{ route('product.create') }}" class="btn btn-success btn-icon-split">
                        <span class="icon text-white-50">
                          <i class="fa fa-cubes" aria-hidden="true"></i>
                        </span>
                        <span class="text">Novo</span>
                    </a>
                    <table class="mt-lg-3 table table-striped table-bordered table-hover table-responsive-lg">
                        <thead>
                        <tr align="center">
                            <th>#</th>
                            <th>Imagem</th>
                            <th>Produto</th>
                            <th>Descrição</th>
                            <th>Marca</th>
                            <th>Ação</th>
                        </tr>
                        </thead>
                        <tbody>

                        @forelse($produtos as $produto)
                            <tr align="center">
                                <th scope="row">{{$produto->id}}</th>
                                <td align="center">@if(!empty($produto->image))<img src="{{ asset($produto->image) }}" width="50" height="50"/> @else - @endif</td>
                                <td align="center">{{$produto->name}}</td>
                                <td align="center">{{$produto->description}}</td>
                                <td align="center">{{($produto->brand_id && !empty($produto->brand->name)) ? $produto->brand->name : (!empty($produto->marca) ? $produto->marca : '-')}}</td>
                                <td align="center">
                                    <a href="{{ route('product.edit',$produto->id) }}" class="btn btn-info btn-circle btn-sm produto" title="Atualizar Produto">
                                        <i class="fas fa-info-circle"></i>
                                    </a>
                                    <a href="#" class="btn btn-danger btn-circle btn-sm excluir" title="Excluír Produto" data-id="{{ $produto->id }}"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                        @empty
                            <p class="mt-lg-3">Sem produtos</p>
                        @endforelse
                        </tbody>
                    </table>
                    <div class="pl-lg-4">
                        <div class="row">
                            <div class="col text-center" style="margin-left:500px;">
                                {{ is_object($produtos) ? $produtos : '' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>

    function apagarProduto(codigo) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:'product/'+ codigo,
            type:'delete',
            dateType: 'json',
            success: function(res) {
                window.location.href="{{route('product.index')}}";
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    $(document).ready(function(){
        $(".excluir").click(function(){
            Swal.fire({
                title: 'Deseja realmente excluir?',
                text: "O item escolhido será apagado!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Apagar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    let codigo = $(this).data('id');
                    apagarProduto(codigo);
                    Swal.fire(
                        'Sucesso!',
                        'O item selecionado foi apagado.',
                        'success'
                    )
                }
            })
        });
    });

</script>
