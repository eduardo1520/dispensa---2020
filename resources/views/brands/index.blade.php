@extends('layouts.admin')
@section('main-content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="col-lg-10 order-lg-1">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Listagens de Marcas</h6>
            </div>
            <div class="card-body">
                <a href="#" class="btn btn-success btn-icon-split" data-toggle="modal" data-target=".modalMarca"  onclick='abreModalMarca("");'>
                    <span class="icon text-white-50">
                      <i class="fa fa-cubes" aria-hidden="true"></i>
                    </span>
                    <span class="text">Novo</span>
                </a>
                <table class="mt-lg-3 table table-striped table-bordered table-hover">
                    <thead>
                    <tr align="center">
                        <th>#</th>
                        <th>Marca</th>
                        <th>Ação</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($marcas as $marca)
                        <tr align="center">
                            <th scope="row">{{$marca->id}}</th>
                            <td align="center">{{strtoupper($marca->name)}}</td>
                            <td align="center">
                                <a href="#" class="btn btn-info btn-circle btn-sm categoria" title="Atualizar Marca" data-toggle="modal" data-target=".modalMarca"  onclick='abreModalMarca({{ $marca->id }});'>
                                    <i class="fas fa-info-circle"></i>
                                </a>
                                <a href="#" class="btn btn-danger btn-circle btn-sm excluir" title="Excluír Marca" data-id="{{ $marca->id }}"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    @empty
                        <p class="mt-lg-3">Sem Marcas</p>
                    @endforelse
                    </tbody>
                </table>
                <div class="pl-lg-4">
                    <div class="row">
                        <div class="col text-center" style="margin-left:500px;">
                            {{ is_object($marcas) ? $marcas : '' }}
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

    function abreModalMarca(codigo) {
        if(codigo) {
            $("#titulo-marca").text('Atualizar Marca');
            $("#btnMarca").empty().text('Atualizar');
            $.ajax({
                url: `brand/${codigo}`,
                type: 'get',
                dateType: 'json',
                success: function(res) {
                    $("#id").val(res.id);
                    $("#name").val(res.name);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        } else {
            $("#btnMarca").empty().text('Cadastrar');
            $("#btnMarca").attr('disabled','disabled');
            $("#titulo-categoria").empty().text('Cadastrar Marca');
        }
    }

    function atualizaMarca(nome, codigo) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:'brand/'+ codigo,
            type:'put',
            dateType: 'json',
            data:{
                tipo: nome,
                id: codigo
            },
            success: function(res) {
                $('#modalMarca').modal('hide');
                window.location.reload();
            },
            error: function (error) {
                console.log(error);
            }
        });

    }

    function validaMarca() {

        let marca = $("#marca").val();

        if(marca == '') {
            alert('Campo obrigatório');
            $("#marca").focus();
        } else {
            let codigo = $("#id").val();
            atualizaMarca(marca, codigo);
        }
    }

    function apagarMarca(codigo) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:'brand/'+ codigo,
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
                    apagarMarca(codigo);
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
