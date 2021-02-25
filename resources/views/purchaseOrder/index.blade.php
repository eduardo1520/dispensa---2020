@extends('layouts.admin')
@section('main-content')

<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ asset('css/iconselect.css') }}">
<script src="{{ asset('js/iconselect.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/iscroll.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/productsRequest.js') }}" type="text/javascript"></script>

{{--<link rel="stylesheet" href="{{ asset('css/bootstrap-duallistbox.min.css') }}">--}}
{{--<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap4-duallistbox/4.0.2/jquery.bootstrap-duallistbox.min.js"></script>--}}

    <div class="row">
        <div class="col-lg-10 order-lg-1">
            <div class="card shadow mb-4">
                <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Pedido de Compras</h6></div>
                <div class="card-body">
{{--                    <div class="row " align="center" id="tabela">--}}
{{--                        <form id="demoform" action="#" method="post">--}}
{{--                            <select multiple="multiple" size="10" name="duallistbox_demo1[]">--}}
{{--                                @forelse($produtos as $p)--}}
{{--                                    <option value="{{ $p['id'] }}"><img src="{{ $p['image'] }}" alt="{{ $p['description'] }}"> {{ $p['name'] }}</option>--}}
{{--                                @empty--}}
{{--                                    Vazio--}}
{{--                                @endforelse--}}
{{--                            </select>--}}
{{--                            <br>--}}
{{--                            <button type="submit" class="btn btn-default btn-block">Submit data</button>--}}
{{--                        </form>--}}
{{--                        <script>--}}
{{--                            var demo1 = $('select[name="duallistbox_demo1[]"]').bootstrapDualListbox();--}}
{{--                            $("#demoform").submit(function() {--}}
{{--                                alert($('[name="duallistbox_demo1[]"]').val());--}}
{{--                                return false;--}}
{{--                            });--}}
{{--                        </script>--}}
{{--                    </div>--}}

                        <script>
                            var iconSelect;
                            window.onload = function(){
                                promise(`puchase-order/productImageAjax`,'post')
                                    .then(response => {
                                        return response.json();
                                    })
                                    .then(produtos => {
                                        var icons = [];
                                        let horizontal = Math.ceil(produtos.length / 10);
                                        iconSelect = new IconSelect("my-icon-select",
                                            {'selectedIconWidth':96,
                                                'selectedIconHeight':96,
                                                'selectedBoxPadding':5,
                                                'iconsWidth':96,
                                                'iconsHeight':96,
                                                'boxIconSpace':6,
                                                'vectoralIconNumber':10,
                                                'horizontalIconNumber':horizontal});
                                        produtos.forEach(function(p){
                                            icons.push({'iconFilePath': p.image, 'iconValue':p.id});
                                        });

                                        iconSelect.refresh(icons);
                                });

                            };
                        </script>

                    <h2>Produtos</h2>

                    <div id="my-icon-select"></div>
                    </div>
                </div>
            </div>
        </div>
{{--    </div>--}}



@endsection

<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
