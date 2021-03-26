{{--{{ dd($confProductMeasurementsQuantities) }}--}}


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
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <form id="frm-product_measurements" action="{{route('confProductMeasurementsQuantities.update',$id) }}" method="post">
                                <input type="hidden" name="_method" value="PUT">
                                <input type="hidden" name="product_id" value="{{ $id }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <h6 class="heading-small text-muted mb-4">Informações do produto</h6>
                                <div class="row">
                                    <div id="produto_imagem" data-product_id = "{{ $confProductMeasurementsQuantities[0]['product_id'] ?? '' }}" data-product_name = "produto">
                                        <img src="../../{{$confProductMeasurementsQuantities[0]['image']}}" width="150" height="150" alt="" style="{{ count($confProductMeasurementsQuantities) > 2 ? 'margin-top:150px' : 'margin-top:50px' }} ;margin-left:10px;"/>
                                        <div style="padding-top: 10px; padding-left: 60px;" id="produto_nome"><small class="text-muted">{{ $confProductMeasurementsQuantities[0]['produto_nome'] }}</small></div>
                                    </div>
                                    <div class="col-xl-8 col-md-6 mb-4 ml-5">
                                        <div class="card border-left-success shadow h-100 py-2">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Quantidades</div>
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                            <table class="mt-lg-3 table table-striped table-bordered table-hover table-responsive-lg">
                                                                <thead>
                                                                <tr align="center">
                                                                    <th>Medidas</th>
                                                                    <th>Qtde</th>
                                                                    <th>Ação</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @forelse($confProductMeasurementsQuantities as $prod)
                                                                    <tr align="center" data-measure_nome = "{{ $prod['medida_nome'] }}">
                                                                        <td align="center">{{ $prod['medida_nome']  }}</td>
                                                                        <td align="center">{{ $prod['qtde']  }}</td>
                                                                        <td align="center">
                                                                            <a href="#" onclick="carregaConfProductMeasurementsQuantitiesModal('{{ $id }}','{{ $prod['medida_nome'] }}', '{{ $prod['measure'] }}')" data-measure_nome = "{{ $prod['medida_nome'] }}"
                                                                                    data-product_id = "{{ $id }}" data-toggle="modal" data-target="#confProductMeasurementsQuantities" class="btn btn-info btn-circle btn-sm produto" title="Atualizar Produto">
                                                                                <i class="fas fa-info-circle"></i>
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                @empty
                                                                    <p class="mt-lg-3">Sem produtos</p>
                                                                @endforelse
                                                                </tbody>
                                                            </table>

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
                                            <a href="{{ route('confProductMeasurementsQuantities.index') }}" class="btn btn-danger">Cancelar</a>
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

<script src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('js/sweetalert2@10.js') }}"></script>

<script src="{{ asset('js/confProductMeasurementsQuantities.js') }}"></script>


