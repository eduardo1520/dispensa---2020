@extends('layouts.admin')
@section('main-content')

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">








    <style>
        .nao_selecionado {
            color: #fff;
            background-color: #f1f1f1;
            border-color: #c7ccda;
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
                        <tr align="center" class="">
                            <th scope="row"></th>
                            <td align="center"><input class="form-control"  id="datepicker" type="text"></td>
                            <td align="center">{{ Auth::user()->name }}</td>
                            <td align="center">5</td>
                            <td align="center">Imagem</td>
                            <td align="center">Produto</td>
                            <td align="center">Medidas</td>
                            <td align="center">Marca</td>
                            <td align="center">Categoria</td>
                            <td align="center">Ação</td>
                        </tr>
{{--                    @forelse(solicitacao as $f)--}}
{{--                        <tr align="center" class="{{ $f->tipo == 'R' ? 'table-danger': 'table-primary'}}">--}}
{{--                            <th scope="row">{{$f->id}}</th>--}}
{{--                            <td align="center">{{date('d/m/Y',strtotime($f->created_at))}}</td>--}}
{{--                            <td align="center">{{ !empty($f->deleted_at) ? date('d/m/Y',strtotime($f->deleted_at)) : '-'}}</td>--}}
{{--                            <td align="center">{{$f->tipo == 'R' ? 'Reclamação' : 'Sugestão'}}</td>--}}
{{--                            <td align="center">{{Str::limit($f->descricao,100,'...')}}</td>--}}
{{--                            <td align="center">{{$f->prioridade == 'A' ? 'Alta' : 'Baixa'}}</td>--}}
{{--                            <td align="center">{{$f->user->name}}</td>--}}
{{--                            <td align="center">--}}
{{--                                <a href="#" class="btn btn-info btn-circle btn-sm feedback" title="Atualizar Feedback" data-toggle="modal" data-target="#feedbackModal"  onclick='abreModalFeedback({{ $f->id }});'>--}}
{{--                                    <i class="fas fa-info-circle"></i>--}}
{{--                                </a>--}}
{{--                                <a href="#" class="btn btn-danger btn-circle btn-sm excluir" title="Excluír Feedback" data-id="{{ $f->id }}"><i class="fas fa-trash"></i></a>--}}
{{--                            </td>--}}
{{--                        </tr>--}}
{{--                    @empty--}}
{{--                        <p class="mt-lg-3">Sem Solicitação de Produtos</p>--}}
{{--                    @endforelse--}}
                    </tbody>
                </table>
                <div class="pl-lg-4">
                    <div class="row">
                        <div class="col text-center" style="margin-left:500px;">
{{--                            {{ solicitacao }}--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{--<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="crossorigin="anonymous"></script>--}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

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

        $("#admin .btn").on('click', function(){

        });
    });

</script>


<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script src="https://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<script>
    $(function() {
        $( "#datepicker" ).datepicker();
    });
</script>
