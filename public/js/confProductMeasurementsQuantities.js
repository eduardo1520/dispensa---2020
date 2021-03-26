function carregaConfProductMeasurementsQuantitiesModal(product, measure, measure_id) {
    document.querySelector('td#medida').innerHTML = '';
    document.querySelector('td#medida').insertAdjacentHTML('afterbegin',measure);
    document.querySelector('td#medida').setAttribute('data-product_id',product);
    document.querySelector('td#medida').setAttribute('data-measure_id',measure_id);
}

function mensagemAlerta(classe) {
    let timerInterval
    Swal.fire({
        title: 'Atenção',
        html: 'Número não permitido!',
        timer: 2000,
        timerProgressBar: true,
        didOpen: () => {
            Swal.showLoading()
            timerInterval = setInterval(() => {
                const content = Swal.getContent()
                if (content) {
                    const b = content.querySelector('b')
                    if (b) {
                        b.textContent = Swal.getTimerLeft()
                    }
                }
            }, 100)
        },
        willClose: () => {
            clearInterval(timerInterval)
        }
    }).then((result) => {
        /* Read more about handling dismissals below */
        if (result.dismiss === Swal.DismissReason.timer) {
            document.querySelector('#btnAtualizarQtde').setAttribute('disabled','disabled');
            document.querySelector(`.${classe}`).value = '';
            document.querySelector(`.${classe}`).focus();
        }
    })
}

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

function AtualizarQtdeProdutosPorMedidas(produto, medida, qtde) {
    $promessa = promise(`/confProductMeasurementsQuantities/upConfProductMeasurementsQuantitiesAjax`, 'post', {'product_id': produto, 'measure_id': medida,'qtde':qtde})
        .then(response => {
            return response.json();
        }).then(product => {

            let titulo = '';
            let mensagem = '';
            let icone = '';

            if(product) {
                titulo = "Sucesso";
                mensagem = "Quantidade atualizada!";
                icone = "success";
            } else {
                titulo = "Oops...";
                mensagem = "Erro ao atualizar a quantidade!";
                icone = "error";
            }
            let timerInterval
            Swal.fire({
                title: titulo,
                html: mensagem,
                icon: icone,
                timer: 2000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading()
                    timerInterval = setInterval(() => {
                        const content = Swal.getContent()
                        if (content) {
                            const b = content.querySelector('b')
                            if (b) {
                                b.textContent = Swal.getTimerLeft()
                            }
                        }
                    }, 100)
                },
                willClose: () => {
                    clearInterval(timerInterval)
                }
            }).then((result) => {
                /* Read more about handling dismissals below */
                if (result.dismiss === Swal.DismissReason.timer) {
                    window.location.reload();
                }
            });

        }).catch(error => {
            console.log('erro:', error);
        });
}
