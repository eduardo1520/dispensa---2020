@extends('layouts.admin')
@section('main-content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="col-lg-10 order-lg-1">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="pl-lg-4 mt-lg-5">
                    <form action="{{ route('product.store') }}" name="frm-product-pesquisar" method="post" id="frm-product-pesquisar">
                        <input type="hidden" name="pesquisar" value="true">
{{--                        <div class="pl-lg-4 mt-lg-5">--}}
{{--                            <div class="row">--}}
{{--                                <div class="col text-center">--}}
{{--                                    <a href="{{ route('product.index') }}" class="btn btn-warning">Limpar</a>--}}
{{--                                    <button type="submit" class="btn btn-primary" id="btn-pesquisar">Pesquisar</button>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </form>
                </div>
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Listagens de Medidas por Produtos </h6>
                </div>
                <div class="card-body">
                    <a href="{{ route('product.create') }}" class="btn btn-success btn-icon-split">
                        <span class="icon text-white-50">
                          <i class="fa fa-cubes" aria-hidden="true"></i>
                        </span>
                        <span class="text">Novo</span>
                    </a>
                    <table class="mt-lg-3 table table-striped table-bordered table-hover table-responsive-lg">
                        <thead>
                        <tr align="center">
                            <th>#</th>
                            <th>Imagem</th>
                            <th>Produto</th>
                            <th>Medida</th>
                            <th>Ação</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($produtos_measurements as $prod)
                            <tr align="center">
                                <th scope="row">{{$prod->id}}</th>
                                <td align="center">@if(!empty($prod->image))<img src="{{ asset($prod->image) }}" width="50" height="50" alt=""/> @else - @endif</td>
                                <td align="center">{{ $prod->name }}</td>
                                <td align="center">{{ $prod->medidas  }}</td>
                                <td align="center">
                                    <a href="{{ route('productMeasurements.edit',$prod->id) }}" class="btn btn-info btn-circle btn-sm produto" title="Atualizar Produto">
                                        <i class="fas fa-info-circle"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <p class="mt-lg-3">Sem produtos</p>
                        @endforelse
                        </tbody>
                    </table>
                    <div class="pl-lg-4">
                        <div class="row">
                            <div class="col text-center" style="margin-left:500px;">
                                {{ is_object($produtos_measurements) ? $produtos_measurements : '' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



<script src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('js/sweetalert2@10.js') }}"></script>



