@extends('layouts.admin')
@section('main-content')

    <div class="col-lg-10 order-lg-1">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Listagens de Usúarios</h6>
            </div>
            <div class="card-body">
{{--                {{ $users }}--}}
                <a href="{{ route('novo_usuario') }}" class="btn btn-success btn-icon-split">
                    <span class="icon text-white-50">
                      <i class="fa fa-user-plus" aria-hidden="true"></i>
                    </span>
                    <span class="text">Novo</span>
                </a>
                <table class="table table-responsive mt-2">
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
                                <a href="#" class="btn btn-info btn-circle btn-sm" title="Atualizar Usúario" data-id="{{ $user->id }}"><i class="fas fa-info-circle"></i></a>
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

    $(document).ready(function(){

        $(".excluir").click(function(){
            Swal.fire({
                title: 'Deseja realmente excluir?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                }
            })
        });

        $("#admin .btn").on('click', function(){

        });
    });
</script>
