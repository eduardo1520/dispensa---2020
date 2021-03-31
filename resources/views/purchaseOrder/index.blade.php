@extends('layouts.admin')
@section('main-content')

<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ asset('css/iconselect.css') }}">

<script src="{{ asset('js/iconselect.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/iscroll.js') }}" type="text/javascript"></script>

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

    <div class="col-lg-12 order-lg-1">
        <div class="card shadow mb-4">
            <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Pedido de Compras</h6></div>
            <div class="card-body">
                <div class="pl-lg-4 mt-lg-5">
                    <form action="{{ route('purchase-order.store') }}" name="frm-purchaseOrder-pesquisar" method="post" id="frm-purchaseOrder-pesquisar">
                        <input type="hidden" name="pesquisar" value="true">
                        <input type="hidden" name="_token" value="{{ @csrf_token() }}">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="form-control-label" for="name">Período</label>
                                    <select data-placeholder="Selecione um período" class="chosen-select-period" multiple tabindex="3" name="id[]" id="id" value="">
                                        @if(!empty($comboPeriodSql))
                                            @foreach($comboPeriodSql as $value => $p)
                                                <option value="{{$p->dt}}" {{ !empty($pesquisa['id']) && in_array($value,$pesquisa['id'])  ? 'selected' : '' }}>{{ date("d/m/Y", strtotime($p->dt)) }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="pl-lg-4 mt-lg-5">
                            <div class="row">
                                <div class="col text-center">
                                    <a href="{{ route('purchase-order.index') }}" class="btn btn-warning">Limpar</a>
                                    <button type="submit" class="btn btn-primary" id="btn-pesquisar">Pesquisar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <button class="btn btn-success" id="pedido" data-toggle="modal" data-target="#pedidoModal">Produtos</button>
                <button class="btn btn-primary float-right" id="enviar_pedido" style="display: none" onclick="sendPurchase({{ Auth::user()->id }})">Enviar Pedidos</button>
            </div>
            <div class="card-body" style="margin-top: auto;">
                <div class="row " align="center" id="tabela">
                    <div class="col-8 col-lg-12 my-3 border " id="filho">
                        @php $produtos = []; @endphp
                        <table class="mt-lg-3 table table-striped table-bordered  table-responsive-lg pedido" style="border-collapse:collapse;">
                            <tbody>
                                @forelse($purchase_orders as $data => $listas)
                                    @php
                                        $arr = explode('_', $data);
                                        $n = 1;
                                    @endphp
                                        <style>
                                            .pedido tbody tr:nth-of-type({{ $n = $n +2 }}) { background-color: #f6c23e; }
                                            /*.pedido tbody tr:nth-of-type(2n+1) { background-color: #f6c23e; }*/

                                            {{--.pedido tbody tr:nth-of-type(odd){--}}
                                            {{-- @if($arr[1] == 'Aguardando aprovação')--}}
                                            {{--        background-color: #f6c23e;--}}
                                            {{-- @elseif($arr[1] == 'Cancelado')--}}
                                            {{--         background-color: #e83e8c;--}}
                                            {{--  @endif--}}
                                            /*  cursor:pointer;*/
                                            /*}*/
                                        </style>
                                        <tr colspan="6" data-toggle="collapse" data-target=".demo_{{$arr[0]}}" class="accordion-toggle">
                                            <td>Lista de Pedidos - Data: {{ date('d/m/Y',$arr[0]) }} - ({{ $arr[1] }})</td>
                                            <td >
                                                <div style="float: right; margin-right: 5px; margin-bottom: 5px; {{ $arr[1] == 'Cancelado' ? 'display:none' : 'cursor:wait;'}}">
                                                    <a href="#" class="btn btn-danger btn-circle btn-sm excluir" title="Excluír Produto" onclick="removePedidoLista({{ $arr[0] }},'999999','')"><i class="fas fa-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="p" id = "{{ $arr[0] }}">
                                            <td colspan="6" class="hiddenRow">
                                                <div class="">
                                                    <div class="row">
                                                         @forelse($listas as $p)
{{--                                                             {{ dd($p) }}--}}
                                                            <div class="accordian-body collapse p-3 demo_{{$arr[0]}}" id="{{ $p['id'] }}">
                                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">{{ $p['product_name'] }}</div>
                                                                <div class="card border-left-success shadow h-100 py-2">
                                                                    <div class="col-sm">
                                                                        <div class="card mb-3" style="max-width: 400px;">
                                                                            <div class="row g-0">
                                                                                <div class="col-md-4">
                                                                                    @if(!empty($p['image']))<img src="{{ asset($p['image']) }}" width="150" height="150" alt="" style="margin-top:10px ;margin-left:0px;"/> @else - @endif
                                                                                </div>
                                                                                <div class="col-md-8">
                                                                                    <div class="card-body">
                                                                                        <h5 class="card-title">{{ $p['product_name'] }}</h5>
                                                                                        <p class="card-text">Código: <span>{{ $p['id'] }}</span></p>
                                                                                        <p class="card-text">Qtde: <span> {{ $p['qtde'] / $p['qtde_default'] }}</span></p>
                                                                                        <p class="card-text">Medida: <span> {{ $p['measure_nome'] }} - {{ $p['sigla'] }}</span></p>
                                                                                        <p class="card-text"><small class="text-muted">[{{ $p['qtde'] }}] {{ $p['product_name'] }}</small></p>
                                                                                        <p class="card-text"><small class="text-muted">Categoria : <span>{{ $p['categories_nome'] }}</span></small></p>
                                                                                        <p class="card-text"><small class="text-muted">Data : <span>{{ date('d/m/Y H:s:i',strtotime($p['created_at'])). ' hs' }}</span></small></p>
                                                                                        <p class="card-text">{{ $p['description'] }}</p>
                                                                                    </div>
                                                                                    <!-- Lista de Compras tem durabilidade de 5 dias após esse período os produtos não poderam ser removidos -->
                                                                                    <div style="float: right; margin-right: 5px; margin-bottom: 5px;{{ strtotime(date('Y-m-d', strtotime('-5 day'))) >= $arr[0] || $p['status'] == 'C' ? 'display:none' : ''}}" >
                                                                                        <a href="#" class="btn btn-danger btn-circle btn-sm excluir" title="Excluír Produto" data-id="{{ $p['id'] }}" onclick="removePedidoLista({{ $arr[0] }},{{ $p['id'] }}, '{{ $p['product_name'] }}')"><i class="fas fa-trash"></i></a>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                         @empty
                                                         @endforelse
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                @empty
                                @endforelse
                                <!-- Dinâmico -->
                            </tbody>

                        </table>
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
        jQuery('.chosen-select-period').chosen({
            width: '100%',
            no_results_text: "Não encontramos este período!",
            max_selected_options: 5
        });
        jQuery('.chosen-select-deselect').chosen({ allow_single_deselect: true });
    });
</script>

<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script src="{{ asset('js/purchase-order.js') }}" type="text/javascript"></script>
