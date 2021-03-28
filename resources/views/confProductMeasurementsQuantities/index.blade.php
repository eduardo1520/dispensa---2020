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
                    <form action="{{ route('confProductMeasurementsQuantities.store') }}" name="frm-confProductMeasurementsQuantities-pesquisar" method="post" id="frm-confProductMeasurementsQuantities-pesquisar">
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
                        </div>
                        <div class="pl-lg-4 mt-lg-5">
                            <div class="row">
                                <div class="col text-center">
                                    <a href="{{ route('confProductMeasurementsQuantities.index') }}" class="btn btn-warning">Limpar</a>
                                    <button type="submit" class="btn btn-primary" id="btn-pesquisar">Pesquisar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Listagens de Medidas por Produtos e Quantidades</h6>
                </div>
                <div class="card-body">
                    <a href="#" class="btn btn-success btn-icon-split" data-toggle="modal" data-target=".confProductMeasurementsQuantities"  onclick=''>
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
                            <th>Medida</th>
                            <th>Ação</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $contador = 0;
                            $cor = '';

                        @endphp
                        @forelse($confProductMeasurementsQuantities as $prod)
                            <tr align="center" class="{{$cor}}">
                                <th scope="row">{{$prod->product_id}}</th>
                                <td>
                                    @if($contador != $prod->product_id && (!empty($prod->image)))
                                        <img src="{{asset($prod->image)}}" width="50" height="50" alt="{{ $prod->name }}"/>
                                        <div style="padding-top: 10px; padding-left: 0px;"><small class="text-muted">{{ $prod->name }}</small></div>
                                        @else
                                            -
                                    @endif
                                </td>
                                <td align="center">{{ $prod->medidas  }}</td>
                                <td align="center">
                                    <a href="{{ route('confProductMeasurementsQuantities.edit',$prod->product_id) }}" class="btn btn-info btn-circle btn-sm produto" title="Atualizar Produto">
                                        <i class="fas fa-info-circle"></i>
                                    </a>
                                </td>
                            </tr>
                            @php
                                $contador = $prod->product_id;
                            @endphp
                        @empty
                            <p class="mt-lg-3">Sem produtos</p>
                        @endforelse
                        </tbody>
                    </table>
                    <div class="pl-lg-4">
                        <div class="row">
                            <div class="col text-center" style="margin-left:500px;">
                                {{ is_object($confProductMeasurementsQuantities) ? $confProductMeasurementsQuantities : '' }}
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
            jQuery('.chosen-select-product').chosen({
            width: '100%',
            no_results_text: "Não encontramos este produto!",
            max_selected_options: 5
        });
        jQuery('.chosen-select-deselect').chosen({ allow_single_deselect: true });
    });
</script>

<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


