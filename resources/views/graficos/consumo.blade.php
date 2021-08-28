
<link href="{{ asset('css/consumo.css') }}" rel="stylesheet">

<div class="col-lg-6 mb-4">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-success">Consumo de Produtos</h6>
        </div>
        <div class="card-body">
            <figure class="highcharts-figure">
                <div id="container"></div>
            </figure>
            <script src="{{asset('js/consumo.js')}}"></script>
        </div>
    </div>
</div>


