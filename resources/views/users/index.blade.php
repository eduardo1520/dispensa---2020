@extends('layouts.admin')
@section('main-content')

    <div class="col-lg-7 order-lg-1">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Listagens de Usúarios</h6>
            </div>
            <div class="card-body">
                <a href="{{ route('novo_usuario') }}" class="btn btn-success btn-icon-split">
                    <span class="icon text-white-50">
                      <i class="fa fa-user-plus" aria-hidden="true"></i>
                    </span>
                    <span class="text">Novo</span>
                </a>
                <table class="mt-lg-3 table table-striped table-bordered table-hover">
                    <thead>
                    <tr align="center">
                        <th>#</th>
                        <th>Nome</th>
                        <th>Sobrenome</th>
                        <th>E-mail</th>
                        <th>Admin</th>
                        <th>Ação</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($users as $user)
                        <tr>
                            <th scope="row">{{$user->id}}</th>
                            <td align="center">{{$user->name}}</td>
                            <td align="center">{{$user->last_name}}</td>
                            <td align="center">{{$user->email}}</td>
                            <td align="center">{{$user->admin == 'S' ? "Sim" : 'Não'}}</td>
                            <td align="center">
                                <a href="user/{{$user->id}}" class="btn btn-info btn-circle btn-sm" title="Atualizar Usúario" data-id="{{ $user->id }}"><i class="fas fa-info-circle"></i></a>
                                <a href="#" class="btn btn-danger btn-circle btn-sm excluir" title="Excluír Usúario" data-id="{{ $user->id }}"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    @empty
                        <p>No users</p>
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

    function apagarUsuario(codigo) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:'user/'+ codigo,
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
                text: "O item será excluído do sistema.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Apagar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    let codigo = $(this).data('id');
                    apagarUsuario(codigo);
                    Swal.fire(
                        'Apagado!',
                        'O item selecionado foi excluído com sucesso!',
                        'success'
                    )
                }
            })
        });

        $("#admin .btn").on('click', function(){

        });
    });
</script>
