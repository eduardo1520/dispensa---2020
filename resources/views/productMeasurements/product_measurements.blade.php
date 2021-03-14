

@extends('layouts.admin')
@section('main-content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-duallistbox.min.css') }}">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap4-duallistbox/4.0.2/jquery.bootstrap-duallistbox.min.js"></script>
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
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <form id="frm-product_measurements" action="{{route('productMeasurements.update',$id) }}" method="post">
                                <input type="hidden" name="_method" value="PUT">
                                <input type="hidden" name="product_id" value="{{ $id }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <h6 class="heading-small text-muted mb-4">Informações do produto</h6>
                                <div class="row">
                                    <div id="produto_imagem" data-product_id = "{{ $product_measurements[0]['product_id'] ?? '' }}" data-product_name = "produto"><!-- imagem dinâmico--></div>
                                    <div class="col-xl-8 col-md-6 mb-4 ml-5">
                                        <div class="card border-left-success shadow h-100 py-2">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Produtos por Medidas</div>
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                            <select multiple="multiple" size="10" name="duallistbox_demo1[]" class="medidas">
                                                                @forelse($measures as $measure)
                                                                    @php
                                                                        $flag = $measure['id'];
                                                                            $selected = '';
                                                                            $busca = array_filter(array_map(function($product_measurements)use($flag){
                                                                                return $product_measurements['measure_id'] == $flag;
                                                                            }, $product_measurements));
                                                                            $selected = in_array($measure['id'], $busca) ? "selected" : '';
                                                                    @endphp
                                                                    <option {{ $selected ?? '' }} data-id="{{ $measure['id'] }}" value="{{$measure['id']}}">{{ $measure['nome'] . " - (" . strtoupper($measure['sigla']) . ")" }}</option>
                                                                @empty
                                                                    Vazio
                                                                @endforelse
                                                            </select>
                                                            <br>
                                                            <script>
                                                                var demo1 = $('select[name="duallistbox_demo1[]"]').bootstrapDualListbox({
                                                                    filterPlaceHolder:'Pesquisar',
                                                                    infoText: false,
                                                                    moveAllLabel: 'Mover todos',
                                                                    removeAllLabel: 'Remover todos'
                                                                });
                                                                $("#demoform").submit(function() {
                                                                    alert($('[name="duallistbox_demo1[]"]').val());
                                                                    return false;
                                                                });
                                                            </script>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="pl-lg-3">
                                    <div class="row">
                                        <div class="col text-center">
                                            <a href="{{ route('productMeasurements.index') }}" class="btn btn-danger">Cancelar</a>
                                            <button type="submit" class="btn btn-primary" id="btn-cadastrar" >Atualizar</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
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
        document.querySelector('.moveall').setAttribute('class', 'btn btn-outline-success');
        document.querySelector('.removeall').setAttribute('class', 'btn btn-outline-danger');
        document.querySelector('div.row > div#produto_imagem').setAttribute('style', 'margin-top: 90px;');
        document.querySelector('div.box1 > select').setAttribute('style', 'height: 257px;padding-top: 10px;padding-left: 5px;border-color:#1cc88a');
        document.querySelector('div.box2 > select').setAttribute('style', 'height: 257px;padding-top: 10px;padding-left: 5px;border-color:#e74a3b');
        let id = document.querySelector('div#produto_imagem').getAttribute('data-product_id');
        let name =  document.querySelector('div#produto_imagem').getAttribute('data-product_name');
        getImageProduct(id,name);

    });

    // document.addEventListener("click", function() {
    //     log(document.querySelector('div.box2 > select'));
    //     document.getElementById("frm-product_measurements").submit();
    // });

</script>

