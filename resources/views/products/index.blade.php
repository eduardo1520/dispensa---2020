@extends('layouts.admin')
@section('main-content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('vendor/harvesthq/chosen/chosen.min.css') }}" rel="stylesheet">

    <style>
        .chosen-container-multi .chosen-choices {
            border: 1px solid #cbd5e0;
            height: 40px !important;
            cursor: text;
            padding-left: 15px;
            border-bottom: 1px solid #ddd;
            text-indent: 0;
            border-radius: .35rem;
            padding-top: 6px;
        }

        [class*="col-"] .chosen-container {
            width:98%!important;
        }
        [class*="col-"] .chosen-container .chosen-search input[type="text"] {
            padding:2px 4%!important;
            width:90%!important;
            margin:5px 2%;
        }
        [class*="col-"] .chosen-container .chosen-drop {
            width: 100%!important;
        }
    </style>
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
                                    <select data-placeholder="Selecione um produto" class="chosen-select-product" multiple tabindex="3" name="id[]" id="id" value="">
                                        @if(!empty($comboProductSql))
                                            @foreach($comboProductSql as $value => $produto)
                                                <option value="{{$value}}" {{ !empty($pesquisa['id']) && in_array($value,$pesquisa['id'])  ? 'selected' : '' }}>{{ $produto }}</option>
                                            @endforeach
                                        @endif
                                    </select>
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
                                    <label class="form-control-label" for="brand_id">Marca</label>
                                    <select data-placeholder="Selecione uma marca" class="chosen-select-brand" multiple tabindex="3" name="brand_id[]" id="brand_id" value="">
                                        @if(!empty($comboBrandSql))
                                            @foreach($comboBrandSql as $value => $marca)
                                                <option value="{{$value}}" {{ !empty($pesquisa['brand_id']) && in_array($value,$pesquisa['brand_id'])  ? 'selected' : '' }}>{{ $marca }}</option>
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
    </div>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="{{ asset('vendor/harvesthq/chosen/chosen.jquery.min.js') }}"></script>
<script>
    let jQuery = $.noConflict();
    jQuery(function() {
        jQuery('.chosen-select-brand').chosen({
            width: '100%',
            no_results_text: "Não encontramos está marca!",
            max_selected_options: 5
        });

        jQuery('.chosen-select-product').chosen({
            width: '100%',
            no_results_text: "Não encontramos este produto!",
            max_selected_options: 5
        });
        jQuery('.chosen-select-deselect').chosen({ allow_single_deselect: true });
    });
</script>
<script src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('js/sweetalert2@10.js') }}"></script>


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
