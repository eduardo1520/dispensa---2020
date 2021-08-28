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

function getConsumeproducts() {
    promise('home/getConsumeProductsAjax','post')
        .then(response => {
            return response.json();
        })
        .then(products => {
            let dado = [];

            products.forEach(function(p){
                dado.push([p.name, p.qtde_atual]);
            });
            var chart;
            chart = Highcharts.chart("container", {
                chart: {
                    type: "pie",
                    options3d: {
                        enabled: true,
                        alpha: 45
                    }
                },
                title: {
                    text: "Controle de Consumo de Itens"
                },
                subtitle: {
                    text: "Seus Produtos Dentro do Prazo."
                },
                plotOptions: {
                    pie: {
                        innerSize: 100,
                        depth: 45
                    },
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



getConsumeproducts();








