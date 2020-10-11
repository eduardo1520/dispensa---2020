@extends('layouts.admin')
@section('main-content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <div class="row">
        <div class="col-lg-5 order-lg-1">
            <div class="card shadow mb-4">
                <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Listagens de Categorias</h6></div>
                <div class="card-body">
                    <a href="#" class="btn btn-success btn-icon-split" data-toggle="modal" data-target=".modalCategoria"  onclick='abreModalCategoria("");'>
                        <span class="icon text-white-50"><i class="fa fa-cubes" aria-hidden="true"></i></span>
                        <span class="text">Novo</span>
                    </a>
                    <div class="row" align="center">
                        <div class="col-8 col-lg-12 my-3 border">
                            <div class="row">
                                <div class="col-4 col-sm-4 col-md-4 col-lg-4 border">#</div>
                                <div class="col-4 col-sm-4 col-md-4 col-lg-4 border">Tipo</div>
                                <div class="col-4 col-sm-4 col-md-4 col-lg-4 border">Ação</div>
                            </div>
                            @forelse($categorias as $categoria)
                                <div class="row">
                                    <div class="col-4 col-sm-4 col-md-4 col-lg-4 border" style="padding-top: 10px;padding-bottom: 5px;">
                                        {{$categoria->id}}
                                    </div>
                                    <div class="col-4 col-sm-4 col-md-4 col-lg-4 border" style="padding-top: 10px;padding-bottom: 5px;">
                                        {{$categoria->tipo}}
                                    </div>
                                    <div class="col-4 col-sm-4 col-md-4 col-lg-4 border" style="padding-top: 10px;padding-bottom: 5px;">
                                        <a href="#" class="btn btn-info btn-circle btn-sm categoria" title="Atualizar Categoria" data-toggle="modal" data-target=".modalCategoria"  onclick='abreModalCategoria({{ $categoria->id }});'>
                                            <i class="fas fa-info-circle"></i>
                                        </a>
                                        <a href="#" class="btn btn-danger btn-circle btn-sm excluir" title="Excluír Categoria" data-id="{{ $categoria->id }}"><i class="fas fa-trash"></i></a>
                                    </div>
                                </div>
                            @empty
                                <p class="mt-lg-3">Sem categorias</p>
                            @endforelse
                        </div>
                    </div>
{{--                    <table class="mt-lg-3 table table-striped table-bordered table-hover">--}}
{{--                        <thead>--}}
{{--                        <tr align="center">--}}
{{--                            <th>#</th>--}}
{{--                            <th>Tipo</th>--}}
{{--                            <th>Ação</th>--}}
{{--                        </tr>--}}
{{--                        </thead>--}}
{{--                        <tbody>--}}
{{--                        @forelse($categorias as $categoria)--}}
{{--                            <tr align="center">--}}
{{--                                <th scope="row">{{$categoria->id}}</th>--}}
{{--                                <td align="center">{{$categoria->tipo}}</td>--}}
{{--                                <td align="center">--}}
{{--                                    <a href="#" class="btn btn-info btn-circle btn-sm categoria" title="Atualizar Categoria" data-toggle="modal" data-target=".modalCategoria"  onclick='abreModalCategoria({{ $categoria->id }});'>--}}
{{--                                        <i class="fas fa-info-circle"></i>--}}
{{--                                    </a>--}}
{{--                                    <a href="#" class="btn btn-danger btn-circle btn-sm excluir" title="Excluír Categoria" data-id="{{ $categoria->id }}"><i class="fas fa-trash"></i></a>--}}
{{--                                </td>--}}
{{--                            </tr>--}}
{{--                        @empty--}}
{{--                            <p class="mt-lg-3">Sem categorias</p>--}}
{{--                        @endforelse--}}
{{--                        </tbody>--}}
{{--                    </table>--}}
                </div>
            </div>
        </div>
    </div>


@endsection

<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>

    function abreModalCategoria(codigo) {
        if(codigo) {
            $("#titulo-categoria").text('Atualizar Categoria');
            $("#btnCategoria").empty().text('Atualizar');
            $.ajax({
                url: `category/${codigo}`,
                type: 'get',
                dateType: 'json',
                success: function(res) {
                    $("#id").val(res.id);
                    $("#tipo").val(res.tipo);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        } else {
            $("#btnCategoria").empty().text('Cadastrar');
            $("#btnCategoria").attr('disabled','disabled');
            $("#titulo-categoria").empty().text('Cadastrar Categoria');
        }
    }

    function atualizaCategoria(nome, codigo) {
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
                $('#modalCategoria').modal('hide');
                window.location.reload();
            },
            error: function (error) {
                console.log(error);
            }
        });

    }

    function validaCategoriaTipo() {

        let tipo = $("#tipo").val();

        if(tipo == '') {
            alert('Campo obrigatório');
            $("#tipo").focus();
        } else {
            let codigo = $("#id").val();
            atualizaCategoria(tipo, codigo);
        }
    }

    function apagarCatalogo(codigo) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:'category/'+ codigo,
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
                    apagarCatalogo(codigo);
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
