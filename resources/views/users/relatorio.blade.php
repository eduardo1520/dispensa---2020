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
                <table class="mt-lg-3 table table-striped table-bordered table-hover table-responsive-lg">
                    <thead>
                    <tr align="center">
                        <th>#</th>
                        <th>Nome</th>
                        <th>Sobrenome</th>
                        <th>E-mail</th>
                        <th>Admin</th>
                        <th>Data de Criação</th>
                        <th>Data de Atualização</th>
                        <th>Status</th>
                        <th>Data de Exclusão</th>
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
                            <td align="center">{{ date('d/m/Y H:m', strtotime($u->created_at))}}</td>
                            <td align="center">{{ date('d/m/Y H:m', strtotime($u->updated_at))}}</td>
                            <td align="center">{{$u->deleted_at == '' ? 'Ativo' : 'Inativo'}}</td>
                            <td align="center">{{ !empty($u->deleted_at) ? date('d/m/Y H:m', strtotime($u->deleted_at)): '-'}}</td>
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



