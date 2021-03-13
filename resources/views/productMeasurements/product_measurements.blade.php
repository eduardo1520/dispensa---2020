

@extends('layouts.admin')
@section('main-content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
                    <h6 class="m-0 font-weight-bold text-primary">{{ $titulo }}</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ $active=0 }}" autocomplete="off"  id="frm-produto">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <h6 class="heading-small text-muted mb-4">Informações do produto</h6>
                        <div class="row">
                            <div id="produto_imagem" data-product_id = "{{ $product_measurements[0]['product_id'] }}" data-product_name = "produto"><!-- imagem dinâmico--></div>
                            <div class="col-xl-4 col-md-6 mb-4 ml-5">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Medidas</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <ul style="list-style: none;">
                                                        @forelse($measures as $measure)
                                                            @php
                                                                $flag = $measure['id'];
                                                                $busca = array_filter(array_map(function($product_measurements)use($flag){
                                                                    return $product_measurements['measure_id'] == $flag;
                                                                }, $product_measurements));
                                                            @endphp
                                                            <li data-id="{{ $measure['id'] }}" class = "{{ array_pop($busca) ? 'text-xs font-weight-bold text-danger mb-1' : '' }} " data-existe="{{  array_pop($busca) }}">{{ $measure['nome'] . " - (" . $measure['sigla'] . ")" }}</li>
                                                        @empty

                                                        @endforelse
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6 mb-4 ml-5">
                                <div class="card border-left-warning shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Medidas dos Produtos</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <ul style="list-style: none;">
                                                        @forelse($product_measurements as $product)
                                                            <li data-id="{{ $product['id'] }}" >{{ $product['nome'] . " - (" . $product['sigla'] . ")" }}</li>
                                                        @empty

                                                        @endforelse
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    {{--                    <div class="pl-lg-4">--}}
    {{--                        <div class="row">--}}
    {{--                            <div class="col-lg-12">--}}
    {{--                                <label for="description">Descrição</label>--}}
    {{--                                <textarea name="description" id="description" cols="20" rows="5" class="form-control"></textarea>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
                    </form>

                    <div class="pl-lg-3">
                        <div class="row">
                            <div class="col text-center">
                                <a href="{{ route('product.index') }}" class="btn btn-danger">Cancelar</a>

                                <button type="submit" form="frm-produto" class="btn btn-primary" id="btn-cadastrar" >Atualizar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script src="{{ asset('js/product_measurements.js') }}"></script>
<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        let id = document.querySelector('div#produto_imagem').getAttribute('data-product_id');
        let name =  document.querySelector('div#produto_imagem').getAttribute('data-product_name');
        getImageProduct(id,name);
    });
</script>

