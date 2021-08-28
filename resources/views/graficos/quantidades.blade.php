<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/cylinder.js"></script>
<script src="https://code.highcharts.com/modules/funnel3d.js"></script>

<link href="{{ asset('css/quantidade.css') }}" rel="stylesheet">

<div class="col-lg-6 mb-4">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-success">Produtos Mais Utilizados</h6>
        </div>
        <div class="card-body">
            <figure class="highcharts-figure">
                <div id="container4"></div>
            </figure>
            <script src="{{asset('js/quantidade.js')}}"></script>
        </div>
    </div>
</div>
