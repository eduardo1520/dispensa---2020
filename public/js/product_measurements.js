
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

function log(dado) {
    console.log(dado);
}

function getImageProduct(id, name) {
    $promessa = promise(`/product/productImageAjax`, 'post', {'id': id, 'name':name})
        .then(response => {
            return response.json();
        }).then(imagem => {
            if(imagem) {
                let element = document.querySelector("div#produto_imagem");

                imagem.forEach(function(value){
                    element.insertAdjacentHTML('beforeend', `<img src="../../${value['image']}" width="150" height="150" alt=""/>`);
                    element.insertAdjacentHTML('beforeend', `<div style="padding-top: 10px; padding-left: 45px;"><small class="text-muted">${value['name']}</small></div>`);
                });
            }
        }).catch(error => {
            log('erro:', error);
        });
}

function confirmar() {

    if(document.querySelector('div.box2 > select')) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary ml-1',
                cancelButton: 'btn btn-danger',

            },
            buttonsStyling: true
        });

        swalWithBootstrapButtons.fire({
            title: 'Você realmente que remover todas as medidas desse produto?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Remover',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (!result.isConfirmed) {
                let sel = document.querySelector('select');
                let opt;
                try{
                    for ( var i = 0, len = sel.options.length; i < len; i++ ) {
                        opt = sel.options[i];
                        if (opt.getAttribute('selected') == 'selected') {
                            document.querySelector('div.box2 > select').append(opt);
                        }
                    }

                } catch(error) {
                    //
                }
            } else {
                document.querySelector('#apagarTodos').setAttribute('disabled','disabled');
            }
        })

    }

}

function gravarProductMeasurements(medida, combo) {

    let select = document.querySelector(medida);
    let option = select.children[select.selectedIndex];
    // var texto = option.textContent;

    let codigo = document.querySelector(combo).getAttribute('icon-value');

    let dado = {
        measure_id: option.value,
        id: codigo
    };

    promise(`/productMeasurements/productMeasurementsAjax`,'post', dado)
        .then(response => {
            return response.json();
        })
        .then(resultado => {
            let timerInterval
            Swal.fire({
                title: 'Medidas por Produtos',
                icon: 'success',
                html: 'Produto Cadastrado com sucesso!',
                timer: 1000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading()
                    timerInterval = setInterval(() => {
                        window.location.reload();
                    }, 100)
                },
                willClose: () => {
                    clearInterval(timerInterval)
                }
            })
        })
}

function validarCampos()
{
    let select = document.querySelector('select#product_measurements_combo');
    let option = select.children[select.selectedIndex];

    let medida_selecionado = option.value;
    let produto_selecionado = document.querySelector('div#my-product-measurements-select-box-scroll > div > div.selected > img').getAttribute('icon-value');

    if(medida_selecionado != '' && produto_selecionado > 0) {
        gravarProductMeasurements('select#product_measurements_combo', 'div#my-product-measurements-select-box-scroll > div > div.selected > img');
    } else {
        let timerInterval;
        Swal.fire({
            icon: 'error',
            title: 'Dados Inválidos!',
            html: 'Informe a medida e o produto para serem gravados no sistema.',
            timer: 2000,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading()
                timerInterval = setInterval(() => {

                }, 100)
            },
            willClose: () => {
                clearInterval(timerInterval)
            },
            footer: 'Tente novamente...'
        })
    }


}
var iconSelect;

window.onload = function(){

    promise(`../../productMeasurements/productImageAjax`,'post')
        .then(response => {
            return response.json();
        })
        .then(produtos => {
            var icons = [];
            let horizontal = Math.ceil(produtos.length / 10);
            try {
                iconSelect = new IconSelect("my-product-measurements-select",
                    {'selectedIconWidth':96,
                        'selectedIconHeight':96,
                        'selectedBoxPadding':5,
                        'iconsWidth':96,
                        'iconsHeight':96,
                        'boxIconSpace':6,
                        'vectoralIconNumber':10,
                        'horizontalIconNumber':horizontal});

                icons.push({'iconFilePath': '../img/compras-shopping.png', 'iconValue':0});

                produtos.forEach(function(p){
                    icons.push({'iconFilePath': p.image, 'iconValue':p.id});
                });

                iconSelect.refresh(icons);

            } catch(error) {
                //
            }
    });
    try{
        $promessa = promise(`../../measure/measureAjax`, 'post')
            .then(response => {
                return response.json();
            }).then(combo => {
                let element = document.querySelector("#product_measurements_combo");
                combo.forEach(function(value){
                    element.insertAdjacentHTML('beforeend', `<option value="${value['id']}">${value['nome']} - (${value['sigla'].toUpperCase()})</option>`);
                });
            }).catch(error => {
                console.log('Deu erro,', error);
            });

    } catch(error) {
        //
    }


};
