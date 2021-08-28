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

function getMarcasProdutos() {
    promise('home/getMarcasProductsAjax','post')
        .then(response => {
            return response.text();
        })
        .then(breads => {
            var lines = breads.split(/[,\. ]+/g),
                data = Highcharts.reduce(
                    lines,
                    function (arr, word) {
                        var obj = Highcharts.find(arr, function (obj) {
                            return obj.name === word;
                        });
                        if (obj) {
                            obj.weight += 1;
                        } else {
                            obj = {
                                name: word,
                                weight: 1
                            };
                            arr.push(obj);
                        }
                        return arr;
                    },
                    []
                );

            Highcharts.chart("container3", {
                accessibility: {
                    screenReaderSection: {
                        beforeChartFormat:
                            "<h5>{chartTitle}</h5>" +
                            "<div>{chartSubtitle}</div>" +
                            "<div>{chartLongdesc}</div>" +
                            "<div>{viewTableButton}</div>"
                    }
                },
                credits: {
                    enabled: false
                },
                series: [
                    {
                        type: "wordcloud",
                        data: data,
                        name: "Marcas"
                    }
                ],
                title: {
                    text: "Marcas de Produtos"
                }
            });
        });
}



getMarcasProdutos();
