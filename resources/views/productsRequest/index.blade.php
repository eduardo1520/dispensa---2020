@extends('layouts.admin')
@section('main-content')

    {{--    versão 1.11.2--}}
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">
    <link href="{{ asset('css/gijgo.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/productsRequest.css') }}" rel="stylesheet" type="text/css" />
    <link href='https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en' rel='stylesheet' type='text/css'>
    <link href="{{ asset('css/mdDateTimePicker.min.css') }}" rel="stylesheet" type="text/css" />

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="row">
        <div class="col-lg-10 order-lg-1">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Solicitação de Produtos</h6>
                </div>
                <div class="card-body">
                    <a href="{{ route('product.create') }}" class="btn btn-success btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                        </span>
                        <span class="text">Novo</span>
                    </a>
                    <div class="row " align="center" id="tabela">
                        <div class="col-12 col-lg-12 my-3 border " id="filho">
                            <div class="row font-weight-bold">
                                <div class="col-4 col-sm-2 col-md-1 col-lg-2 border cabecalho">Data</div>
                                <div class="col-1 col-sm-2 col-md-2 col-lg-2 border cabecalho user">Usuário</div>
                                <div class="col-2 col-sm-2 col-md-1 col-lg-1 border cabecalho">Qtde</div>
                                <div class="col-1 col-sm-2 col-md-1 col-lg-1 border cabecalho detalhe">Imagem</div>
                                <div class="col-2 col-sm-2 col-md-1 col-lg-1 border cabecalho">Produto</div>
                                <div class="col-1 col-sm-2 col-md-1 col-lg-1 border cabecalho detalhe">Medidas</div>
                                <div class="col-1 col-sm-2 col-md-1 col-lg-1 border cabecalho detalhe">Marca</div>
                                <div class="col-1 col-sm-2 col-md-1 col-lg-1 border cabecalho detalhe">Categoria</div>
                                <div class="col-4 col-sm-2 col-md-2 col-lg-2 border cabecalho">Ação</div>
                            </div>
                            <div class="row pedido" data-codigo="1">
                                <div class="col-4 col-sm-2 col-md-1 col-lg-2 border cabecalho">
                                    <input class="date" width="auto"  value="{{ date('d/m/Y') }}" />
                                    <i class="fa fa-calendar d-none calendario" aria-hidden="true"></i>
                                </div>
                                <div class="col-1 col-sm-2 col-md-1 col-lg-2 border cabecalho user">
                                    {{ Auth::user()->name }}
                                </div>
                                <div class="col-2 col-sm-2 col-md-1 col-lg-1 border cabecalho qtde">0</div>
                                <div class="col-1 col-sm-2 col-md-1 col-lg-1 border cabecalho detalhe">0</div>
                                <div class="col-2 col-sm-2 col-md-1 col-lg-1 border cabecalho produto gj-cursor-pointer" onclick="produtoCombo($(this).closest('[data-codigo]').data('codigo'))">
                                    <span class="produto-nome" data-product_id>Produto</span>
                                    <select data-placeholder="Selecione um produto" class="form-control combo-produto d-none" tabindex="3" name="produto_id"  onchange="transformaProdutoComboSpan($(this).closest('[data-codigo]').data('codigo'), $(this).val(), $('.combo-produto option:selected').text())">--}}
                                        @if(!empty($comboProductSql))
                                            <option value="">Selecione um produto</option>
                                            @foreach($comboProductSql as $value => $produto)
                                                <option value="{{$value}}" {{ !empty($pesquisa['id']) && in_array($value,$pesquisa['id'])  ? 'selected' : '' }}>{{ $produto }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-1 col-sm-2 col-md-1 col-lg-1 border cabecalho detalhe">0</div>
                                <div class="col-1 col-sm-2 col-md-1 col-lg-1 border cabecalho detalhe">0</div>
                                <div class="col-1 col-sm-2 col-md-1 col-lg-1 border cabecalho detalhe">0</div>
                                <div class="col-4 col-sm-2 col-md-1 col-lg-2 border cabecalho ">
                                    <a href="javascript:void(0);" onclick="event.preventDefault(); atualizaQtde($(this).closest('[data-codigo]').data('codigo'), '+');" class="btn btn-primary btn-circle btn-sm produto" title="Adicionar Produto"><i class="fas fa-cart-plus"></i></a>
                                    <a href="javascript:void(0);" onclick="event.preventDefault(); atualizaQtde($(this).closest('[data-codigo]').data('codigo'), '-');" class="btn btn-danger btn-circle btn-sm produto"  title="Excluír Produto"><i class="fa fa-cart-arrow-down"></i></a>
                                    <a href="javascript:void(0);" class="btn btn-success btn-circle btn-sm excluir" title="Novo Produto"      data-id=" "><i class="fas fa-cart-plus"></i></a>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
                                    {{--    <div class="col-lg-10 order-lg-1">--}}
{{--        <div class="card shadow mb-4">--}}
{{--            <div class="card-header py-3">--}}
{{--                <h6 class="m-0 font-weight-bold text-primary">Solicitação de Produtos</h6>--}}
{{--            </div>--}}
{{--            <div class="card-body">--}}
{{--                <a href="{{ route('product.create') }}" class="btn btn-success btn-icon-split">--}}
{{--                        <span class="icon text-white-50">--}}
{{--                          <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>--}}
{{--                        </span>--}}
{{--                    <span class="text">Novo</span>--}}
{{--                </a>--}}
{{--                <table class="mt-lg-3 table table-striped table-bordered table-hover table-responsive-lg">--}}
{{--                    <thead>--}}
{{--                    <tr align="center">--}}
{{--                        <th>#</th>--}}
{{--                        <th>Data</th>--}}
{{--                        <th>Usuário</th>--}}
{{--                        <th>Qtde</th>--}}
{{--                        <th>Imagem</th>--}}
{{--                        <th>Produto</th>--}}
{{--                        <th>Medidas</th>--}}
{{--                        <th>Marca</th>--}}
{{--                        <th>Categoria</th>--}}
{{--                        <th>Ação</th>--}}
{{--                    </tr>--}}
{{--                    </thead>--}}
{{--                    <tbody>--}}
{{--                        <tr align="center" class="pedido" data-codigo="1">--}}
{{--                            <th scope="row"></th>--}}
{{--                            <td align="center">--}}
{{--                                <input id="date" width="auto"  value="{{ date('d/m/Y') }}" />--}}
{{--                                    </td>--}}

{{--                                    <td align="center">{{ Auth::user()->name }}</td>--}}
{{--                                    <td align="center" class="qtde">0</td>--}}
{{--                                    <td align="center">@if(!empty($produto->image))<img src="{{ asset($produto->image) }}" width="50" height="50"/> @else - @endif</td>--}}
{{--                                    <td align="center" onclick="produtoCombo($(this).closest('[data-codigo]').data('codigo'))" class="produto gj-cursor-pointer">--}}
{{--                                        <span class="produto-nome" data-product_id>Produto</span>--}}
{{--                                        <select data-placeholder="Selecione um produto" class="form-control combo-produto d-none" tabindex="3" name="produto_id"  onchange="transformaProdutoComboSpan($(this).closest('[data-codigo]').data('codigo'), $(this).val(), $('.combo-produto option:selected').text())">--}}
{{--                                            @if(!empty($comboProductSql))--}}
{{--                                                <option value="">Selecione um produto</option>--}}
{{--                                                @foreach($comboProductSql as $value => $produto)--}}
{{--                                                    <option value="{{$value}}" {{ !empty($pesquisa['id']) && in_array($value,$pesquisa['id'])  ? 'selected' : '' }}>{{ $produto }}</option>--}}
{{--                                                @endforeach--}}
{{--                                            @endif--}}
{{--                                        </select>--}}
{{--                                    </td>--}}
{{--                                    <td align="center" class="produto gj-cursor-pointer">Medidas</td>--}}
{{--                                    <td align="center" class="produto gj-cursor-pointer">Marca</td>--}}
{{--                                    <td align="center" class="produto gj-cursor-pointer">Categoria</td>--}}
{{--                                    <td align="center">--}}
{{--                                        <a href="javascript:void(0);" onclick="event.preventDefault(); atualizaQtde($(this).closest('[data-codigo]').data('codigo'), '+');" class="btn btn-primary btn-circle btn-sm produto" title="Adicionar Produto"><i class="fas fa-cart-plus"></i></a>--}}
{{--                                        <a href="javascript:void(0);" onclick="event.preventDefault(); atualizaQtde($(this).closest('[data-codigo]').data('codigo'), '-');" class="btn btn-danger btn-circle btn-sm produto"  title="Excluír Produto"><i class="fa fa-cart-arrow-down"></i></a>--}}
{{--                                        <a href="javascript:void(0);" class="btn btn-success btn-circle btn-sm excluir" title="Novo Produto"      data-id=" "><i class="fas fa-cart-plus"></i></a>--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
{{--                            </tbody>--}}
{{--                        </table>--}}
{{--                        <div class="pl-lg-4">--}}
{{--                            <div class="row">--}}
{{--                                <div class="col text-center m-left500">--}}
{{--        --}}{{--                            {{ solicitacao }}--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

                <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
                <script src="{{ asset('vendor/harvesthq/chosen/chosen.jquery.min.js') }}"></script>
                <script src="{{asset('js/bootstrap-datepicker.min.js')}}"></script>
                <script src="{{ asset('js/gijgo.min.js') }}" type="text/javascript"></script>

                <script type="text/javascript">
                    var yesterday = new Date();
                    yesterday.setDate(yesterday.getDate() -1);
                    var hoje = new Date();
                    var ano = hoje.getFullYear();
                    var ultimoDia = new Date(ano, 12, 0);
                    $('.date').datepicker({
                        uiLibrary: 'bootstrap4',
                        iconsLibrary: 'fontawesome',
                        locale: 'pt-br',
                        weekStart: 1,
                        daysOfWeekHighlighted: "6,0",
                        autoclose: true,
                        todayHighlight: true,
                        format: 'd/m/yyyy',
                        minDate: yesterday,
                        maxDate: new Date(ultimoDia),
                    });
                </script>
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
@endsection

<script src="{{ asset('js/sweetalert2@10.js') }}"></script>
{{-- versão 1.9.1 --}}
<script src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('js/productsRequest.js') }}"></script>










