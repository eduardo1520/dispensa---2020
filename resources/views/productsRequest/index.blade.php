@extends('layouts.admin')
@section('main-content')

    {{--    versão 1.11.2--}}
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">
    <link href="{{ asset('css/gijgo.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/productsRequest.css') }}" rel="stylesheet" type="text/css" />
    <link href='https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en' rel='stylesheet' type='text/css'>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="row">
        <div class="col-lg-10 order-lg-1">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Solicitação de Produtos</h6>
                </div>
                <div class="card-body">
                    <div class="row d-none" align="center" id="tabela">
                        <div class="col-12 col-lg-12 my-3 border " id="filho">
                            <div class="row font-weight-bold">
                                <div class="col-4 col-sm-2 col-md-1 col-lg-2 border cabecalho">Data</div>
                                <div class="col-1 col-sm-2 col-md-2 col-lg-2 border cabecalho user">Usuário</div>
                                <div class="col-2 col-sm-2 col-md-1 col-lg-1 border cabecalho qtde">Qtde</div>
                                <div class="col-1 col-sm-2 col-md-1 col-lg-1 border cabecalho detalhe">Imagem</div>
                                <div class="col-2 col-sm-2 col-md-1 col-lg-1 border cabecalho prod">Produto</div>
                                <div class="col-1 col-sm-2 col-md-1 col-lg-1 border cabecalho detalhe">Medidas</div>
                                <div class="col-1 col-sm-2 col-md-1 col-lg-1 border cabecalho detalhe">Marca</div>
                                <div class="col-1 col-sm-2 col-md-1 col-lg-1 border cabecalho detalhe">Categoria</div>
                                <div class="col-4 col-sm-2 col-md-2 col-lg-2 border cabecalho">Ação</div>
                            </div>
                            <div class="row pedido" data-codigo="1">
                                <div class="col-4 col-sm-2 col-md-1 col-lg-2 border cabecalho data" >
                                    <input class="date desktop" width="auto"   value="{{ date('d/m/Y') }}" disabled  onclose=""/>
                                </div>
                                <div class="col-1 col-sm-2 col-md-1 col-lg-2 border cabecalho user usuario">
                                    {{ Auth::user()->name }}
                                </div>
                                <div class="col-2 col-sm-2 col-md-1 col-lg-1 border cabecalho qtde">0</div>
                                <div class="col-1 col-sm-2 col-md-1 col-lg-1 border cabecalho detalhe imagem">-</div>
                                @php
                                    $i = 0;
                                @endphp
                                @while($cont > $i)
                                    <div class="{{ array_keys($arr)[$i] == 'produto' ? 'col-4 col-sm-2 col-md-1 col-lg-2' : 'col-2 col-sm-2 col-md-1 col-lg-1'}}  border cabecalho {{ array_keys($arr)[$i] }}  {{ array_keys($arr)[$i] != 'produto' ? 'detalhe' : ''}} gj-cursor-pointer" onclick="getCombo('pedido',$(this).closest('[data-codigo]').data('codigo'),'{{ array_keys($arr)[$i] }}-nome','{{ array_keys($arr)[$i] }}','combo-{{ array_keys($arr)[$i] }}')">
                                        <span class="{{ array_keys($arr)[$i] }}-nome" data-{{ array_keys($arr)[$i] }}_id>{{ ucfirst(array_keys($arr)[$i]) }}</span>
                                        <select class="form-control combo-{{ array_keys($arr)[$i] }} d-none" tabindex="3" name="{{ array_keys($arr)[$i] }}_id"  onchange="transformaComboSpan('pedido',$(this).closest('[data-codigo]').data('codigo'), $(this).val(), $('.combo-{{ array_keys($arr)[$i] }} option:selected').text(), '{{ array_keys($arr)[$i] }}-nome','combo-{{ array_keys($arr)[$i] }}');{{ array_keys($arr)[$i] == 'produto' ? "getProductImage($(this).val(),$('.combo-". array_keys($arr)[$i] ." option:selected').text());getCategory('pedido',$(this).closest('[data-codigo]').data('codigo'), $(this).val(),'categoria');" : ""}};">
                                            <option value="">Selecione {{ substr(array_keys($arr)[$i], -1) == 'a' ? 'uma ' : 'um ' }}{{ ucfirst(array_keys($arr)[$i]) }}</option>
                                            @foreach($arr[array_keys($arr)[$i]] as $idx => $valor)
                                                <option value="{{$idx}}" {{ !empty($pesquisa['id']) && in_array($value,$pesquisa['id'])  ? 'selected' : '' }}>{{ $valor }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @php
                                        $i++;
                                    @endphp
                                @endwhile

                                <div class="col-1 col-sm-2 col-md-1 col-lg-1 border cabecalho detalhe  categoria">
                                    <span class="categoria-nome" data-category_id>-</span>
                                </div>

                                <div class="col-4 col-sm-2 col-md-1 col-lg-2 border cabecalho acao">
                                    <a href="javascript:void(0);" onclick="event.preventDefault(); atualizaQtde($(this).closest('[data-codigo]').data('codigo'), '+');" class="btn btn-primary btn-circle btn-sm" title="Adicionar Produto"><i class="fas fa-cart-plus"></i></a>
                                    <a href="javascript:void(0);" onclick="event.preventDefault(); atualizaQtde($(this).closest('[data-codigo]').data('codigo'), '-');" class="btn btn-warning btn-circle btn-sm"  title="Excluír Produto"><i class="fa fa-cart-arrow-down"></i></a>
                                    <a href="javascript:void(0);" class="btn btn-success btn-circle btn-sm" title="Novo Produto" onclick="addRows($(this).closest('[data-codigo]').data('codigo'))"><i class="fas fa-cart-plus"></i></a>
                                </div>
                                <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
                                <style>
                                    .drop {
                                        margin-top: 5px;
                                        margin-left: 10px;
                                        margin-bottom: 5px;
                                    }
                                </style>

                                <div class="btn-group drop dropleft d-none">
                                    <button type="button" class="btn btn-sm btn-success" onclick="addRows($(this).closest('[data-codigo]').data('codigo'))"><i class="fas fa-cart-plus"></i></button>
                                    <button type="button" class="btn btn-sm btn-success dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu">
                                        <div>
                                            <a class="dropdown-item" href="#"><i class="fas fa-cart-plus" > </i> Aumentar Quantidade</a>
                                        </div>
                                        <div>
                                            <a class="dropdown-item" href="#"><i class="fa fa-cart-arrow-down"></i> Diminuir Quantidade</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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

        $(".date").datepicker().on('close', function() {
            // console.log("changed", $(this).val(),$(this).closest('[data-codigo]').data('codigo'));
            atualizaCampoData('pedido',$(this).closest('[data-codigo]').data('codigo'), $(this).val());
        });

    </script>


@endsection

<script src="{{ asset('js/sweetalert2@10.js') }}"></script>
{{-- versão 1.9.1 --}}
<script src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('js/productsRequest.js') }}"></script>










