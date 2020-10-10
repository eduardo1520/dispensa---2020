@extends('layouts.admin')
@section('main-content')

    {{--    versão 1.11.2--}}
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">
    <link href="{{ asset('css/gijgo.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .nao_selecionado {
            color: #fff;
            background-color: #f1f1f1;
            border-color: #c7ccda;
        }

        .table-condensed {
            top: 55px;
            left: 342px;
            z-index: 10;
            display: block;
            padding-left: 15px;
            padding-right: 15px;
            padding-top: 10px;
            padding-bottom: 10px;
        }

        td.today.active.day {
            color: #fff;
            background-color: #4e73df;
            border-color: #4e73df;
        }

    </style>

    <meta name="csrf-token" content="{{ csrf_token() }}">
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


                <table class="mt-lg-3 table table-striped table-bordered table-hover table-responsive-lg">
                    <thead>
                    <tr align="center">
                        <th>#</th>
                        <th>Data</th>
                        <th>Usuário</th>
                        <th>Qtde</th>
                        <th>Imagem</th>
                        <th>Produto</th>
                        <th>Medidas</th>
                        <th>Marca</th>
                        <th>Categoria</th>
                        <th>Ação</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr align="center" class="pedido" data-codigo="1">
                            <th scope="row"></th>
                            <td align="center">
                                <input id="date" width="auto"  value="{{ date('d/m/Y') }}" />
                            </td>
                            <td align="center">{{ Auth::user()->name }}</td>
                            <td align="center" class="qtde">0</td>
                            <td align="center">@if(!empty($produto->image))<img src="{{ asset($produto->image) }}" width="50" height="50"/> @else - @endif</td>
                            <td align="center" style="cursor: pointer" onclick="produtoCombo($(this).closest('[data-codigo]').data('codigo'))" class="produto">
                                <span class="produto-nome" data-product_id>Produto</span>
                                <select data-placeholder="Selecione um produto" class="form-control combo-produto" tabindex="3" name="produto_id" style="display: none" onchange="transformaProdutoComboSpan($(this).closest('[data-codigo]').data('codigo'), $(this).val(), $('.combo-produto option:selected').text())">
                                    @if(!empty($comboProductSql))
                                        <option value="">Selecione um produto</option>
                                        @foreach($comboProductSql as $value => $produto)
                                            <option value="{{$value}}" {{ !empty($pesquisa['id']) && in_array($value,$pesquisa['id'])  ? 'selected' : '' }}>{{ $produto }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </td>
                            <td align="center" style="cursor: pointer">Medidas</td>
                            <td align="center" style="cursor: pointer">Marca</td>
                            <td align="center" style="cursor: pointer">Categoria</td>
                            <td align="center">
                                <a href="javascript:void(0);" onclick="event.preventDefault(); atualizaQtde($(this).closest('[data-codigo]').data('codigo'), '+');" class="btn btn-primary btn-circle btn-sm produto" title="Adicionar Produto"><i class="fas fa-cart-plus"></i></a>
                                <a href="javascript:void(0);" onclick="event.preventDefault(); atualizaQtde($(this).closest('[data-codigo]').data('codigo'), '-');" class="btn btn-danger btn-circle btn-sm produto"  title="Excluír Produto"><i class="fa fa-cart-arrow-down"></i></a>
                                <a href="javascript:void(0);" class="btn btn-success btn-circle btn-sm excluir" title="Novo Produto"      data-id=" "><i class="fas fa-cart-plus"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="pl-lg-4">
                    <div class="row">
                        <div class="col text-center" style="margin-left:500px;">
{{--                            {{ solicitacao }}--}}
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
                    $('#date').datepicker({
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


            </div>
        </div>
    </div>
@endsection

<script src="{{ asset('js/sweetalert2@10.js') }}"></script>
{{-- versão 1.9.1 --}}
<script src="{{ asset('js/jquery.js') }}"></script>



<script>

    function abreModalFeedback(codigo) {
        if(codigo) {
            $.ajax({
                url:'feedback/'+ codigo,
                type:'get',
                dateType: 'json',
                success: function(res) {
                    $("#descricao").val(res.descricao);
                    $("#feedback .btn").removeClass().addClass('btn nao_selecionado');
                    if(res.tipo == 'R') {
                        $("#feedback .btn").each(function(){
                            if($(this).data('id') == 'R') {
                                $(this).removeClass('btn nao_selecionado').addClass('btn btn-danger');
                            }
                        });
                        $("#prioridade_selecionada").show();
                        $("#prioridade").val(res.prioridade);
                    } else {
                        $("#feedback .btn").each(function(){
                            if($(this).data('id') == 'S') {
                                $(this).removeClass('btn nao_selecionado').addClass('btn btn-success');
                            }
                        });
                        $("#prioridade_selecionada").hide();
                    }
                    $("#form-feedback").append('<input type="hidden" name="tipo" id="tipo" value="'+ res.tipo +'">');
                    $("#form-feedback").append('<input type="hidden" id="id" value="'+ res.id +'">');
                    $("#btnFeedback").text('Atualizar Feedback');
                    $('#feedbackModal').modal('show');
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }
    }

    function atualizaFeedback(nome, codigo) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:'category/'+ codigo,
            type:'put',
            dateType: 'json',
            data:{
                tipo: nome,
                id: codigo
            },
            success: function(res) {
                $('#modalFeedback').modal('hide');
                window.location.reload();
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    function apagarFeedback(codigo) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:'feedback/'+ codigo,
            type:'delete',
            dateType: 'json',
            success: function(res) {
                window.location.reload();
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    function atualizaQtde(codigo, operacao)
    {
        $('.pedido').each(function (x,y) {
            if($(this).closest('[data-codigo]').data('codigo') == codigo) {
                let qtde = parseInt($(this).children('td.qtde').text());
                if(operacao == '-' && qtde == 0) {
                    alert('Não é permitido quantidade negativa!');
                } else if(operacao == '+'){
                    qtde++;
                    $(this).children('td.qtde').empty().text(qtde);
                } else {
                    qtde--;
                    $(this).children('td.qtde').empty().text(qtde);
                }
            }
        })
    }

    function produtoCombo(codigo) {
        $('.pedido').each(function (x,y) {
            if($(this).closest('[data-codigo]').data('codigo') == codigo) {
                $(this).children('td.produto').children('span').hide();
                $(".combo-produto").show();
            }
        })
    }

    function transformaProdutoComboSpan(pai, id, nome) {
        if($('.pedido').closest('[data-codigo]').data('codigo') == pai) {
            $('.produto-nome').attr('data-product_id',id);
            $('.produto-nome').text(nome);
            $('.produto-nome').show();
            $(".combo-produto").hide();
        }
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
                    apagarFeedback(codigo);
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






