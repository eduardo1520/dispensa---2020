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
        <div class="col-lg-7 order-lg-1">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ isset($user) && !empty($user->id) ? "Atualizar Usúario" : "Novo usuário"}}</h6>
                </div>
                <div class="card-body">
                    @php
                        if(isset($user)) {
                            $active = empty($user->id) ? route('user.store') : route('user.update',$user->id);
                        } else {
                            $active = route('user.store');
                        }
                    @endphp
                    <form method="POST" action="{{ $active  }}" autocomplete="off"  id="frm-user" onchange="validaCampos();">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        @if(isset($user) && !empty($user->id))
                            <input type="hidden" name="_method" value="PUT">
                        @endif
                        <h6 class="heading-small text-muted mb-4">Informações do usuário</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="name">Nome<span class="small text-danger">*</span></label>
                                        <input type="text" id="name" class="form-control" name="name" placeholder="Nome" value="{{ isset($user) && !empty($user->name) ? $user->name : old('name') }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="last_name">Último nome</label>
                                        <input type="text" id="last_name" class="form-control" name="last_name" placeholder="Último nome" value="{{ isset($user) && !empty($user->last_name) ? $user->last_name : old('last_name') }}">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <strong><label class="form-control-label" for="email">E-mail<span class="small text-danger">*</span></label></strong>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-at"></i>
                                            </span>
                                        </div>
                                        <input type="email" id="email" class="form-control" name="email" placeholder="example@example.com" value="{{ isset($user) && !empty($user->email) ? $user->email : old('email') }}" required>
                                    </div>
                                </div>
                            </div>
                            <h6 class="heading-small text-muted mb-4 mt-lg-2">Credênciais de acesso</h6>
                            @php
                                $requerido = isset($user) && !empty($user->id) ? '': 'required';
                                $obrigatorio = empty($user->id) ? '<span class="small text-danger">*</span>' : '';
                            @endphp
                            <div class="row">
                                <div class="col-lg-6">
                                    <strong><label class="form-control-label" for="new_password">Senha{!!  $obrigatorio !!}</label></strong>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-lock"></i>
                                            </span>
                                        </div>

                                        <input type="password" id="new_password" class="form-control" name="password" placeholder="Senha" {{ $requerido }}>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <strong><label class="form-control-label" for="confirm_password">Confirmar Senha{!!  $obrigatorio !!}</label></strong>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-lock"></i>
                                            </span>
                                        </div>
                                        <input type="password" id="confirm_password" class="form-control" name="password_confirmation" placeholder="Confirmar senha" {{ $requerido }}>
                                    </div>
                                </div>
                            </div>
                            <h6 class="heading-small text-muted mb-4 mt-lg-4">Perfil de Acesso</h6>
                            <div class="row">
                                <div class="col-lg-2">
                                    <div>
                                        <strong><label class="form-control-label" for="admin">Admin</label></strong>
                                    </div>
                                    <input type="hidden" name="admin" id="tipo" value="N">
                                    <div id="admin" class="btn-group" role="group" aria-label="Basic example">
                                        @php
                                            $e_admin = old('admin') == 'S' || empty(old('admin')) && isset($user) && $user->admin == "S" ? 'btn-primary' : 'nao_selecionado';
                                            $n_admin = old('admin') == 'N' || empty(old('admin')) && isset($user) && $user->admin == "N" || (empty(old('admin')) && empty($user)) ? 'btn-primary' : 'nao_selecionado';
                                        @endphp
                                        <button type="button" class="btn {{$e_admin}}" value="S">Sim</button>
                                        <button type="button" class="btn {{$n_admin}}" value="N">Não</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col text-center">
                                    <a href="{{ route('user.index') }}" class="btn btn-danger">Cancelar</a>
                                    @php
                                        $ativo = isset($user) && !empty($user->id) ? '': 'disabled';
                                        $titulo = isset($user) && $user->id ? "Atualizar" : "Cadastrar";
                                    @endphp
                                    <button type="submit" class="btn btn-primary" id="btn-cadastrar" {{ $ativo }}>{{ $titulo }}</button>
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
    function validaCampos() {
        let cont = 0;
        $("#frm-user input[required]").each((x,filhos) => { ($(filhos).val() != "") ? cont++ : 0 });
        (cont == $("#frm-user input[required]").length) ? $("#btn-cadastrar").removeAttr('disabled') : $("#btn-cadastrar").attr('disabled','disabled');
    }

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

