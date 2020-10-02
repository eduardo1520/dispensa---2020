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

{{--        <div class="col-lg-4 order-lg-2">--}}

{{--            <div class="card shadow mb-4">--}}
{{--                <div class="card-profile-image mt-4">--}}
{{--                    <figure class="rounded-circle avatar avatar font-weight-bold" style="font-size: 60px; height: 180px; width: 180px;" data-initial="{{ Auth::user()->name[0] }}"></figure>--}}
{{--                </div>--}}
{{--                <div class="card-body">--}}

{{--                    <div class="row">--}}
{{--                        <div class="col-lg-12">--}}
{{--                            <div class="text-center">--}}
{{--                                <h5 class="font-weight-bold">{{  Auth::user()->fullName }}</h5>--}}
{{--                                <p>Administrador</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="row">--}}
{{--                        <div class="col-md-4">--}}
{{--                            <div class="card-profile-stats">--}}
{{--                                <span class="heading">22</span>--}}
{{--                                <span class="description">Amigos</span>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-4">--}}
{{--                            <div class="card-profile-stats">--}}
{{--                                <span class="heading">10</span>--}}
{{--                                <span class="description">Fotos</span>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-4">--}}
{{--                            <div class="card-profile-stats">--}}
{{--                                <span class="heading">89</span>--}}
{{--                                <span class="description">Comentários</span>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--        </div>--}}

        <div class="col-lg-8 order-lg-1">

            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Meu Perfil</h6>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('profile.update',Auth::user()->id ) }}" autocomplete="off">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <input type="hidden" name="_method" value="PUT">
                        <h6 class="heading-small text-muted mb-4">Informações do usuário</h6>

                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="name">Nome<span class="small text-danger">*</span></label>
                                        <input type="text" id="name" class="form-control" name="name" placeholder="Nome" value="{{ old('name', Auth::user()->name) }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="last_name">Último nome</label>
                                        <input type="text" id="last_name" class="form-control" name="last_name" placeholder="Último nome" value="{{ old('last_name', Auth::user()->last_name) }}">
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-lg-9">
                                    <div class="form-group">
                                        <label class="form-control-label" for="email">E-mail<span class="small text-danger">*</span></label>
                                        <input type="email" id="email" class="form-control" name="email" placeholder="example@example.com" value="{{ old('email', Auth::user()->email) }}">
                                    </div>
                                </div>
                                @if(Auth::user()->admin == "S")
                                    <div class="col-lg-3">
                                        <div>
                                            <label class="form-control-label" for="admin">Admin</label>
                                        </div>
                                        <input type="hidden" name="admin" id="tipo">
                                        <div id="admin" class="btn-group" role="group" aria-label="Basic example">
                                            <button type="button" class="btn {{(Auth::user()->admin == 'S') ? 'btn-primary' : 'nao_selecionado'}}" value="S">Sim</button>
                                            <button type="button" class="btn {{(Auth::user()->admin == 'N') ? 'btn-primary' : 'nao_selecionado'}}" value="N">Não</button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="card-header py-3 mt-3">
                                <h6 class="m-0 font-weight-bold text-primary">Mudança de Senha</h6>
                            </div>
                            <div class="card-body">

                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="current_password">Senha atual</label>
                                        <input type="password" id="current_password" class="form-control" name="current_password" placeholder="Senha atual">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="new_password">Nova Senha</label>
                                        <input type="password" id="password" class="form-control" name="password" placeholder="Senha nova">
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

                        <!-- Button -->
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col text-center">
                                    <button type="submit" class="btn btn-primary">Atualizar</button>
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

