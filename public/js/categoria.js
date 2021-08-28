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

function getCategoriaProdutos() {
    promise('home/getCategoriasProductsAjax','post')
        .then(response => {
            return response.json();
        })
        .then(categories => {
            let temp = {};
            let dado = [{}];
            let nome = ['Categorias'];
            categories.forEach(function(c,idx){
                let cor = '';
                let qtde = parseInt(c.medida);

                if(qtde == 0 || qtde == 100){
                    cor = 'red';
                } else if(qtde > 0 && qtde <= 20) {
                    cor = 'green';
                } else {
                    cor = 'yellow';
                }

                temp.name = c.name;
                temp.color = cor;
                temp.y = parseInt(c.medida) == 0 ? 100 : parseInt(c.medida);
                dado[idx+1] = temp;
                nome[idx+1] = c.tipo;

                temp = {};
            });

            Highcharts.chart("container2", {
                chart: {
                    type: "bar"
                },
                title: {
                    text: "Controle de Produtos"
                },
                subtitle: {
                    text:
                        'Baixa Média de Produtos'
                },
                xAxis: {
                    categories: nome
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: null,
                        align: "high"
                    },
                    labels: {
                        overflow: "justify"
                    }
                },
                tooltip: {
                    valueSuffix: "% consumidos"
                },
                plotOptions: {
                    bar: {
                        dataLabels: {
                            enabled: true
                        }
                    }
                },
                credits: {
                    enabled: false
                },
                series:
                [
                    {
                        name: "Baixa Média",
                        data: dado
                    }
                ]
            });
        });
}

getCategoriaProdutos();
