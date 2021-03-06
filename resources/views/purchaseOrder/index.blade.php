@extends('layouts.admin')
@section('main-content')

<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ asset('css/iconselect.css') }}">
<script src="{{ asset('js/iconselect.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/iscroll.js') }}" type="text/javascript"></script>

    <div class="col-lg-10 order-lg-1">
        <div class="card shadow mb-4">
            <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Pedido de Compras</h6></div>
            <div class="card-body">
                <button class="btn btn-success" id="pedido" data-toggle="modal" data-target="#pedidoModal">Produtos</button>
                <button class="btn btn-primary float-right" id="enviar_pedido" style="display: none">Enviar Pedidos</button>
            </div>
            <div class="card-body" style="margin-top: auto;">
                <div class="row " align="center" id="tabela">
                    <div class="col-8 col-lg-12 my-3 border " id="filho">
                        @php $produtos = []; @endphp
                        <table class="mt-lg-3 table table-striped table-bordered  table-responsive-lg pedido">
                            <thead>
                            <tr align="center">
                                <th>Medida</th>
                                <th>Qtde</th>
                                <th>Produto</th>
                                <th>Descrição</th>
                                <th>Categoria</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody><!-- Dinâmico --></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script src="{{ asset('js/purchase-order.js') }}" type="text/javascript"></script>
