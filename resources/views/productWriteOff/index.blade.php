@extends('layouts.admin')
@section('main-content')

<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ asset('css/iconselect.css') }}">

<script src="{{ asset('js/iconselect.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/iscroll.js') }}" type="text/javascript"></script>

<link href="{{ asset('vendor/harvesthq/chosen/chosen.min.css') }}" rel="stylesheet">

<style>
    .botao {
        background-image:url("public/img/sql.png");
    }
    .chosen-container-multi .chosen-choices {
        border: 1px solid #cbd5e0;
        height: auto !important;
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
        <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Baixa de Produtos</h6></div>
        <div class="card-body">
            <div class="pl-lg-4 mt-lg-5">
                <form action="{{ route('product-write-off.store') }}" name="frm-productWriteOff-pesquisar" method="post" id="frm-productWriteOff-pesquisar">
                    <input type="hidden" name="pesquisar" value="true">
                    <input type="hidden" name="_token" value="{{ @csrf_token() }}">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="form-control-label" for="name">Categoria</label>
                                <select data-placeholder="Selecione uma categoria" class="chosen-select-status" multiple tabindex="3" name="category[]" id="category" value="">
                                    @foreach($comboCategorySql as $value => $t)
                                        <option value="{{$t['id']}}" {{ !empty($_POST['category']) && in_array($t['id'],$_POST['category'])  ? 'selected' : '' }}>{{ $t['tipo'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="pl-lg-4 mt-lg-5">
                        <div class="row">
                            <div class="col text-center">
                                <a href="{{ route('product-write-off.index') }}" class="btn btn-warning">Limpar</a>
                                <button type="submit" class="btn btn-primary" id="btn-pesquisar">Pesquisar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            {{--            <button class="btn btn-success" id="pedido" data-toggle="modal" data-target="#pedidoModal" style="margin-left: 20px;">Novo Produto</button>--}}
            {{--            <button class="btn btn-primary float-right" id="enviar_pedido" style="display: none" onclick="sendPurchase({{ Auth::user()->id }})">Enviar Pedidos</button>--}}
        </div>
        <div class="card-body" style="margin-top: auto;padding-top: 0px;">
            <div class="row " align="center" id="tabela">
                <div class="col-md-12 my-3 border " id="filho">
                    @php
                        $num = 0;
                        if(isset($_POST['pesquisar']) && $_POST['pesquisar'] == true) {
                            if(!empty($dados)){
                                $comboCategorySql = $dados;
                            } else {
                                $comboCategorySql = [];
                            }
                        }
                    @endphp
                    @forelse($comboCategorySql as $data => $c)
                        <style>
                            .pedido_{{$c['id']}} tbody tr:nth-of-type(odd){
                                @if($c['tipo'] == 'Limpeza')
                                    background-color: #90EE90;
                                @elseif($c['tipo'] == 'Higiene Pessoal')
                                    background-color: #36b9cc;
                                @elseif($c['tipo'] == 'Mercearia')
                                    background-color: #f6c23e;
                                @elseif($c['tipo'] == 'Perecíveis')
                                    background-color: #FF6347;
                                @endif
                                cursor:pointer;
                            }
                        </style>

                        @switch($c['tipo'])
                            @case('Limpeza')
                                @php $color = '#90EE90'; @endphp
                            @break
                            @case('Higiene Pessoal')
                                @php $color = '#36b9cc'; @endphp
                            @break
                            @case('Mercearia')
                                @php $color = '#f6c23e'; @endphp
                            @break
                            @case('Perecíveis')
                                @php $color = '#FF6347'; @endphp
                            @break
                            @default
                            @php $color = '#e6edf4'; @endphp
                        @endswitch

                        <table class="mt-lg-3 table table-striped table-bordered  table-responsive-lg pedido_{{$c['id']}}" style="border-collapse:collapse;">
                            <tbody>
                                <tr colspan="6" data-toggle="collapse" data-target=".demo_{{$c['id']}}" class="accordion-toggle" aria-expanded="false" onclick="validaStatusCategoria({{$c['id']}})">
                                    @php
                                        $card = '';
                                        $classe = '';
                                        if($c['tipo'] == 'Limpeza') {
                                            $card = 'fas fa-broom';
                                        } elseif($c['tipo'] == 'Higiene Pessoal') {
                                            $card = 'fas fa-restroom';
                                        } elseif($c['tipo'] == 'Mercearia') {
                                            $card = 'fas fa-store';
                                        } elseif($c['tipo'] == 'Perecíveis') {
                                            $card = 'fas fa-temperature-high';
                                        } else {
                                            $card = 'fas fa-box-open';
                                        }
                                    @endphp
                                    @switch($c['tipo'])
                                        @case('Higiene Pessoal')
                                            @php $stilo = "margin-left: -67;
                                                           padding-left: 0px;
                                                           padding-top: 0px;
                                                           padding-right: 0px;
                                                           border-right-width: 0px;
                                                           margin-right: 0px;
                                                           margin-top: -74;
                                                           padding-bottom: -;
                                                           border-bottom-width: 1px;
                                                           height: 25px;
                                                           width: 28px;
                                                   ";
                                            @endphp
                                            @break
                                        @case('Limpeza')
                                            @php $stilo = "margin-left: -67;
                                                               padding-left: 0px;
                                                               padding-top: 0px;
                                                               padding-right: 0px;
                                                               border-right-width: 0px;
                                                               margin-right: 0px;
                                                               margin-top: -74;
                                                               padding-bottom: -;
                                                               border-bottom-width: 1px;
                                                               height: 25px;
                                                               width: 28px;
                                                       ";
                                            @endphp
                                            @break
                                        @case('Mercearia')
                                            @php $stilo = "margin-left: -47;
                                                           padding-left: 0px;
                                                           padding-top: 0px;
                                                           padding-right: 0px;
                                                           border-right-width: 0px;
                                                           margin-right: 0px;
                                                           margin-top: -5;
                                                           padding-bottom: -;
                                                           border-bottom-width: 1px;
                                                           height: 25px;
                                                           width: 28px;
                                                       ";
                                            @endphp
                                            @break
                                        @case('Outros')
                                            @php $stilo = "margin-left: -47;
                                                               padding-left: 0px;
                                                               padding-top: 0px;
                                                               padding-right: 0px;
                                                               border-right-width: 0px;
                                                               margin-right: 0px;
                                                               margin-top: -65;
                                                               padding-bottom: -;
                                                               border-bottom-width: 1px;
                                                               height: 25px;
                                                               width: 28px;
                                                           ";
                                            @endphp
                                        @break
                                        @case('Perecíveis')
                                            @php $stilo = "margin-left: -25;
                                                                   padding-left: 0px;
                                                                   padding-top: 0px;
                                                                   padding-right: 0px;
                                                                   border-right-width: 0px;
                                                                   margin-right: 0px;
                                                                   margin-top: -65;
                                                                   padding-bottom: -;
                                                                   border-bottom-width: 1px;
                                                                   height: 25px;
                                                                   width: 28px;
                                                               ";
                                            @endphp
                                            @break
                                    @default
                                    @endswitch
                                    <td>
                                        <div class="row">
                                            <div class="col-md-1">
                                                <i class="fas {{ $card ?? '' }}" style="font-size: 48px;"></i>
                                                <span class="btn  btn-info btn-circle btn-sm" style="{{$stilo}}background-color: {{$color}}">
                                                    {{isset($qtdes[$c['tipo']]) && count($qtdes[$c['tipo']]) > 0 ? count($qtdes[$c['tipo']]) : ":("}}
                                                </span>
                                            </div>
                                            <div class="col-md-5 mt-2">
                                                {{$c['tipo']}}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="remover d-none" id="id_{{$c['id']}}" style="float: right; margin-right: 5px; margin-bottom: 5px; {{ $c['tipo'] == 'Cancelado' ||  $c['tipo'] == 'Aprovado' ? 'display:none' : 'cursor:wait;'}}">
                                            <a href="#" class="btn btn-danger btn-circle btn-sm excluir" title="Dar baixa em todos os Produtos dessa Categoria" onclick="removePedidoLista({{ $c['id'] }},'999999','')"><i class="fas fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="p" id = "{{ $c['id'] ?? '' }}">
                                    <td colspan="6" class="hiddenRow">
                                        <div class="row">
                                            @forelse($productAprovate as $ap)
                                                @php
                                                    $tipo = [
                                                        '1' => 'success',
                                                        '2' => 'info',
                                                        '3' => 'warning',
                                                        '4' => 'danger',
                                                        '5' => '',
                                                    ];
                                                @endphp
                                                @if($ap->cod_categoria == $c['id'])
                                                    <script>
                                                        if({{$ap->cod_categoria == $c['id']}}) {
                                                            document.querySelector("#id_{{$c['id']}}").classList.remove('d-none');
                                                        }
                                                    </script>
                                                    <div class="accordian-body p-3 demo_{{$c['id']}} collapse " id="{{$ap->id}}" aria-expanded="false" >
                                                        <div class="text-xs font-weight-bold text-{{$tipo[$c['id']]}} text-uppercase mb-1">{{$c['tipo']}}</div>
                                                        <div class="card border-left-{{$tipo[$c['id']]}} shadow h-100 py-2">
                                                            <div class="col-sm">
                                                                <div class="card mb-3" style="max-width: 400px;">
                                                                    <div class="row g-0">
                                                                        <div class="col-md-4">
                                                                            <img src="{{ asset($ap->image) }}" width="150" height="150" alt="" style="margin-top:10px ;padding:10px;">
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <div class="card-body">
                                                                                <h5 class="card-title">{{$ap->name}}</h5>
                                                                                <p class="card-text">Código: <span>{{$ap->id}}</span></p>
                                                                                <p class="card-text">Qtde: <span> {{$ap->qtde}}</span></p>
                                                                                <p class="card-text">Medida: <span> {{$ap->nome}} - ({{strtoupper($ap->sigla)}})</span></p>
                                                                                <p class="card-text"><small class="text-muted">[{{$ap->qtde}}] {{$ap->name}}</small></p>
                                                                                <p class="card-text"><small class="text-muted">Categoria : <span>{{$ap->tipo}}</span></small></p>
                                                                                <p class="card-text"><small class="text-muted">Data : <span>{{$ap->dt}} hs</span></small></p>
                                                                                <p class="card-text">{{$ap->description}}</p>
                                                                            </div>
                                                                            <div style="float: right; margin-right: 5px; margin-bottom: 5px;{{$disabled ?? ''}}" >
                                                                                <a href="#" class="btn btn-danger btn-circle btn-sm excluir" title="Baixa de Produtos" data-id="{{ $ap->id }}" onclick=""><i class="fa fa-cart-arrow-down"></i></a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @empty
                                            @endforelse
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    @empty
                        <div class="alert alert-danger" role="alert">
                            Não foi encontrado lista de produtos!
                        </div>
                    @endforelse
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

        jQuery('.chosen-select-status').chosen({
            width: '100%',
            no_results_text: "Não encontramos este status!",
            max_selected_options: 5
        });
        jQuery('.chosen-select-deselect').chosen({ allow_single_deselect: true });
    });
</script>

<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script src="{{ asset('js/productWriteOff.js') }}" type="text/javascript"></script>
