@extends('layouts.admin')
@section('main-content')
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
                <h6 class="m-0 font-weight-bold text-primary">Listagens de Usuários</h6>
            </div>
            <div class="card-body">
                <table class="mt-lg-3 table table-striped table-bordered table-hover">
                    <thead>
                    <tr align="center">
                        <th>#</th>
                        <th>Nome</th>
                        <th>Sobrenome</th>
                        <th>E-mail</th>
                        <th>Admin</th>
                        <th>Data de Criação</th>
                        <th>Data de Exclusão</th>
                        <th>Status</th>
                        <th>Ação</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($users as $u)
                        <tr align="center" class="{{ $u->deleted_at != '' ? 'table-danger' : ''}}">
                            <th scope="row">{{$u->id}}</th>
                            <td align="center">{{$u->name}}</td>
                            <td align="center">{{$u->last_name}}</td>
                            <td align="center">{{$u->email}}</td>
                            <td align="center">{{$u->admin == 'A' ? 'Administrador' : 'Usuário'}}</td>
                            <td align="center">{{$u->created_at}}</td>
                            <td align="center">{{$u->deleted_at}}</td>
                            <td align="center">{{$u->deleted_at == '' ? 'Ativo' : 'Inativo'}}</td>
                            <td align="center">
                                <a href="#" class="btn btn-info btn-circle btn-sm feedback" title="Atualizar Usuário" data-toggle="modal" data-target="#feedbackModal"  onclick='abreModalFeedback({{ $u->id }});'>
                                    <i class="fas fa-info-circle"></i>
                                </a>
                                <a href="#" class="btn btn-danger btn-circle btn-sm excluir" title="Excluír Usuário" data-id="{{ $u->id }}"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    @empty
                        <p class="mt-lg-3">Sem feedback</p>
                    @endforelse
                    </tbody>
                </table>
                <div class="pl-lg-4">
                    <div class="row">
                        <div class="col text-center" style="margin-left:500px;">
                            {{ $users }}
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

    // Todo
    function validaFeedback() {

        let tipo = $("#tipo").val();

        if(tipo == '') {
            alert('Campo obrigatório');
            $("#tipo").focus();
        } else {
            let codigo = $("#id").val();
            atualizaFeedback(tipo, codigo);
        }
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
