@extends('layouts.admin')
@section('main-content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="col-lg-5 order-lg-1">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Listagens de Medidas</h6>
            </div>
            <div class="card-body">
                <a href="" class="btn btn-success btn-icon-split" data-toggle="modal" data-target="#medidaModal">
                    <span class="icon text-white-50">
{{--                      <i class="fa fa-cubes" aria-hidden="true"></i>--}}
                        <i class="fa fa-book" aria-hidden="true"></i>
                    </span>
                    <span class="text">Novo</span>
                </a>
                <table class="mt-lg-3 table table-striped table-bordered table-hover table-responsive-lg">
                    <thead>
                    <tr align="center">
                        <th>#</th>
                        <th>Nome</th>
                        <th>Sigla</th>
                        <th>Ação</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($unidades as $unidade)
                        <tr align="center">
                            <th scope="row">{{$unidade->id}}</th>
                            <td align="center">{{$unidade->nome}}</td>
                            <td align="center">{{strtoupper($unidade->sigla)}}</td>
                            <td align="center">
                                <a href="#" class="btn btn-info btn-circle btn-sm unidade" title="Atualizar Medida" data-toggle="modal" data-target="#medidaModal"  onclick='abreModalMedida({{ $unidade->id }});'>
                                    <i class="fas fa-info-circle"></i>
                                </a>
                                <a href="#" class="btn btn-danger btn-circle btn-sm excluir" title="Excluír Medida" data-id="{{ $unidade->id }}"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    @empty
                        <p class="mt-lg-3">Sem unidades</p>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>

    function abreModalMedida(codigo) {
        if(codigo) {
            $.ajax({
                url:'measure/'+ codigo,
                type:'get',
                dateType: 'json',
                success: function(res) {

                    $("#form-medida").append(`<input type="hidden"  id="measure" value="${res.id}">`);
                    $("#nome").val(res.nome);
                    $("#sigla").val(res.sigla);
                    $("#titulo-medida").empty().text('Atualizar Unidade de Medidas');
                    $("#btnMedida").text('Atualizar Medida');
                    $("#btnMedida").removeAttr('disabled');
                    // $('#medidaModal').modal('hide');
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }
    }

    function atualizaMedida(nome, codigo) {

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
            atualizaMedida(tipo, codigo);
        }
    }

    function apagarMedida(codigo) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:'measure/'+ codigo,
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
                    apagarMedida(codigo);
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
