@extends('layouts.admin')
@section('main-content')
    <style>
        .nao_selecionado {
            color: #fff;
            background-color: #f1f1f1;
            border-color: #c7ccda;
        }
    </style>
    @if ($errors->any())
        <div class="alert alert-danger border-left-danger" role="alert">
            <ul class="pl-4 my-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row">
        <div class="col-lg-8 order-lg-1">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Novo usuário</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('user.store') }}" autocomplete="off">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <h6 class="heading-small text-muted mb-4">Informações do usuário</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="name">Nome<span class="small text-danger">*</span></label>
                                        <input type="text" id="name" class="form-control" name="name" placeholder="Nome" value="{{ old('name') }}">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="last_name">Último nome</label>
                                        <input type="text" id="last_name" class="form-control" name="last_name" placeholder="Último nome" value="{{ old('last_name') }}">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div>
                                        <label class="form-control-label" for="admin">Admin</label>
                                    </div>
                                    <input type="hidden" name="admin" id="tipo" value="N">
                                    <div id="admin" class="btn-group" role="group" aria-label="Basic example">
                                        <button type="button" class="btn {{(old('admin') == 'S') ? 'btn-primary' : 'nao_selecionado'}}" value="S">Sim</button>
                                        <button type="button" class="btn {{( empty(old('admin')) || old('admin') == 'N') ? 'btn-primary' : 'nao_selecionado'}}" value="N">Não</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="email">E-mail<span class="small text-danger">*</span></label>
                                        <input type="email" id="email" class="form-control" name="email" placeholder="example@example.com" value="{{ old('email') }}">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="new_password">Nova Senha</label>
                                        <input type="password" id="new_password" class="form-control" name="password" placeholder="Senha nova">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="confirm_password">Confirmar Senha</label>
                                        <input type="password" id="confirm_password" class="form-control" name="password_confirmation" placeholder="Confirmar senha">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col text-center">
                                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
        $("#admin .btn").on('click', function(){
            $("#admin .btn").each(function(){
                $(this).removeClass().addClass('btn nao_selecionado');
            });
            $(this).removeClass('btn nao_selecionado').addClass('btn btn-primary');
            $("#tipo").val($(this).val());
        });
    });
</script>

