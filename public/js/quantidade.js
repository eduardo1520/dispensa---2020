function promise(url, method, params) {
    // const params = { username: 'example' };
    return fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN':  document.head.querySelector("meta[name=csrf-token]").content
        },
        body: (params != undefined) ? JSON.stringify(params) : '',
    });
}

function quantidadePorProdutos() {

    promise('home/getQuantidadesMesAjax','post')
        .then(response => {
            return response.json();
        })
        .then(measurements => {

            let dado = [];
            measurements.forEach(function(m){
                dado.push([m.name, m.qtde]);
            });

            console.log(measurements);
            Highcharts.chart("container4", {
                chart: {
                    type: "funnel3d",
                    options3d: {
                        enabled: true,
                        alpha: 10,
                        depth: 50,
                        viewDistance: 50
                    }
                },
                title: {
                    text: "Quantidade de Produtos por Mês"
                },
                plotOptions: {
                    series: {
                        dataLabels: {
                            enabled: true,
                            format: "<b>{point.name}</b> ({point.y:,.0f})",
                            allowOverlap: true,
                            y: 10
                        },
                        neckWidth: "30%",
                        neckHeight: "25%",
                        width: "80%",
                        height: "80%"
                    }
                },
                credits: {
                    enabled: false
                },
                series: [
                    {
                        name: "Qtde",
                        data: dado
                    }
                ]
            });
        });


}

quantidadePorProdutos();

