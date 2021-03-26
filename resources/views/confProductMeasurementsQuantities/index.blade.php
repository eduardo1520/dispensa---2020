@extends('layouts.admin')
@section('main-content')
    <div class="col-lg-10 order-lg-1">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="pl-lg-4 mt-lg-5">
                    <form action="{{ route('confProductMeasurementsQuantities.store') }}" name="frm-confProductMeasurementsQuantities-pesquisar" method="post" id="frm-confProductMeasurementsQuantities-pesquisar">
                        <input type="hidden" name="pesquisar" value="true">
                    </form>
                </div>
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Listagens de Medidas por Produtos e Quantidades</h6>
                </div>
                <div class="card-body">
                    <a href="#" class="btn btn-success btn-icon-split" data-toggle="modal" data-target=".confProductMeasurementsQuantities"  onclick=''>
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
                            <th>Medida</th>
                            <th>Ação</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $contador = 0;
                            $cor = '';

                        @endphp
                        @forelse($confProductMeasurementsQuantities as $prod)
                            <tr align="center" class="{{$cor}}">
                                <th scope="row">{{$prod->product_id}}</th>
                                <td>
                                    @if($contador != $prod->product_id && (!empty($prod->image)))
                                        <img src="{{asset($prod->image)}}" width="50" height="50" alt="{{ $prod->name }}"/>
                                        <div style="padding-top: 10px; padding-left: 0px;"><small class="text-muted">{{ $prod->name }}</small></div>
                                        @else
                                            -
                                    @endif
                                </td>
                                <td align="center">{{ $prod->medidas  }}</td>
                                <td align="center">
                                    <a href="{{ route('confProductMeasurementsQuantities.edit',$prod->product_id) }}" class="btn btn-info btn-circle btn-sm produto" title="Atualizar Produto">
                                        <i class="fas fa-info-circle"></i>
                                    </a>
                                </td>
                            </tr>
                            @php
                                $contador = $prod->product_id;
                            @endphp
                        @empty
                            <p class="mt-lg-3">Sem produtos</p>
                        @endforelse
                        </tbody>
                    </table>
                    <div class="pl-lg-4">
                        <div class="row">
                            <div class="col text-center" style="margin-left:500px;">
                                {{ is_object($confProductMeasurementsQuantities) ? $confProductMeasurementsQuantities : '' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

