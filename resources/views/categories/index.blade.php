@extends('layouts.admin')
@section('main-content')

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/categories.css') }}">

    <div class="row">
        <div class="col-lg-5 order-lg-1">
            <div class="card shadow mb-4">
                <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Listagens de Categorias</h6></div>
                <div class="card-body">
                    @section('modal')
                        @include('modal.category')
                    @endsection
                    <a href="#" class="btn  btn-success btn-icon-split btn-sm" data-toggle="modal" data-target=".modalCategoria"  onclick='abreModalCategoria("");'>
                        <span class="icon text-white-50"><i class="fa fa-cubes" aria-hidden="true"></i></span>
                        <span class="text">Novo</span>
                    </a>
                    <div class="row " align="center" id="tabela">
                        <div class="col-8 col-lg-12 my-3 border " id="filho">
                            <div class="row font-weight-bold">
                                <div class="col-4 col-sm-4 col-md-4 col-lg-4 border cabecalho">#</div>
                                <div class="col-4 col-sm-4 col-md-4 col-lg-4 border cabecalho">Tipo</div>
                                <div class="col-4 col-sm-4 col-md-4 col-lg-4 border cabecalho">Ação</div>
                            </div>
                            @forelse($categorias as $idx => $categoria)

                                <div class="row {{ $idx % 2 == 0 ? 'zebrado' : 'cinza' }}">
                                    <div class="col-4 col-sm-4 col-md-4 col-lg-4 border cabecalho">
                                        {{$categoria->id}}
                                    </div>
                                    <div class="col-4 col-sm-4 col-md-4 col-lg-4 border cabecalho">
                                        {{$categoria->tipo}}
                                    </div>
                                    <div class="col-4 col-sm-4 col-md-4 col-lg-4 border cabecalho">
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
                </div>
            </div>
        </div>
    </div>

@endsection

<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="{{ asset('js/categories.js') }}"></script>

