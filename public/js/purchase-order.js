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

function getProductIcon(produto) {
   let icon = document.querySelector('.icon');
}

function removeProdutoLista(id) {
    document.querySelectorAll(`.pedido > tbody > tr`).forEach(function(v){
        if(v.getAttribute('id') == id) {
            v.remove();
        }
    });

    if(document.querySelectorAll(`.pedido > tbody > tr`).length == 0) {
        document.querySelector('#enviar_pedido').setAttribute('style','display:none');
    }
}

function getComboMedidas(produto) {
    let combo = [];
    let selected = '';
    promise(`measure/measureAjax`, 'post',{product_id:produto})
        .then(response => {
            return response.json();
        })
        .then(medidas => {
            medidas.forEach(function(m){
                selected = m.id == 6 ? 'selected' : '';
                combo.push(`<option value="${m.id}" ${selected}>${m.nome} - ${m.sigla}</option>`);
        }).catch(error => {
           //
        });
    });

    return combo;
}

function getTextCombo(objeto, componente) {
    let select = objeto.querySelector(`${componente}`);
    let option = select.children[select.selectedIndex];
    let texto  = option.textContent;
    return texto;
}

function getValueCombo(objeto, componente) {
    let select = objeto.querySelector(`${componente}` );
    let option = select.children[select.selectedIndex];
    return parseInt(option.value);
}

function getProductMeasurements(produto, qtde = 1) {
    let medida = '';
    let qtd = '';
    document.querySelectorAll('.pedido > tbody > tr').forEach(function (prod) {
        if(prod.getAttribute('id') == produto) {
            medida = getValueCombo(prod, 'select.medida');
        }
    });

    document.querySelectorAll('.pedido > tbody > tr').forEach(function (qt) {
        if(qt.getAttribute('id') == produto) {
            qtd = getTextCombo(qt, 'select.qtde') > 1 ? getTextCombo(qt, 'select.qtde') : qtde;
        }
    });


    let combo = getComboMedidas();

    promise(`productMeasurements/getProductMeasuresAjax`, 'post', {product_id: produto, measure_id: medida, qtde: qtd})
        .then(response => {
            return response.json();
        })
        .then(valor => {
            document.querySelectorAll('.pedido > tbody > tr').forEach(function (prod) {
                if(prod.getAttribute('id') == produto) {
                    let produto_nome = prod.querySelector('div >.produto').innerHTML;
                    let arr = produto_nome.split('- ');
                    let nome = arr.length > 1 ? arr[1] : arr[0];
                    prod.querySelector('div >.produto').innerHTML = `[${valor}] - ` + nome;
                }
            })

        }).catch(error => {
            let timerInterval;
            Swal.fire({
                icon: 'error',
                title: 'Erro',
                html: 'Medida não permitida!',
                timer: 2000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading()
                    timerInterval = setInterval(() => {

                    }, 100)
                },
                willClose: () => {

                    document.querySelectorAll('.pedido > tbody > tr').forEach(function (pro) {

                        if(pro.getAttribute('id') == produto) {

                            pro.querySelectorAll('select.medida > option').forEach(function (prod) {
                                prod.remove();
                            });

                            pro.querySelectorAll('select.qtde > option').forEach(function (qt) {
                                qt.remove();
                            });

                            pro.querySelector('select.qtde').insertAdjacentHTML("afterbegin", `${Array.from({length:12}, (_,i) => '<option value=' + i + '>' + (i+1) + '</option>').join('')}`);

                            pro.querySelector('select.medida').insertAdjacentHTML("afterbegin", `${combo.join('')}`);

                            document.querySelectorAll('.pedido > tbody > tr').forEach(function (prod) {
                                if(prod.getAttribute('id') == produto) {
                                    let produto_nome = prod.querySelector('div >.produto').innerHTML;
                                    let arr = produto_nome.split('- ');
                                    let nome = arr.length > 1 ? arr[1] : arr[0];
                                    prod.querySelector('div >.produto').innerHTML = nome;
                                }
                            });
                        }
                    });
                    clearInterval(timerInterval)
                },
                footer: 'Tente novamente...'
            })
    });
}

function  atualizaQtdeProduto(id) {
    document.querySelectorAll('.pedido > tbody > tr').forEach(function (prod) {
        if(prod.getAttribute('id') == id) {
            var texto  = getTextCombo(prod, 'select.qtde');
            getProductMeasurements(id, parseInt(texto));

        }
    });
}


function getProductOne(codigo) {

    let encontrou = false;

    document.querySelectorAll(`.pedido > tbody > tr`).forEach(function (p) {

        if(p.getAttribute('id') == codigo) {
            encontrou = true;

            Swal.fire({
                title: 'Atenção!',
                text: `O produto ${p.querySelector('td > div > small.produto').innerHTML.toLowerCase()} já foi adicionado na lista!`,
                imageUrl: `${p.querySelector('td > div > img').getAttribute('src')}`,
                imageWidth: 400,
                imageHeight: 200,
                imageAlt: `${p.querySelector('td > div > small.produto').innerHTML.toLowerCase()}`,
            });

            return;
        }
    });

    if (encontrou === false) {
        let combo = getComboMedidas(codigo);

        promise(`product/getProductOneAjax`, 'post', {'id': codigo})
            .then(response => {
                return response.json();
            })
            .then(produto => {
                produto = produto[0];
                let pedido = `<tr align="center" id='${produto.id}'>
                                <th scope="row" >
                                    <select name="medida" class="medida form-control" onchange="getProductMeasurements(${produto.id})">
                                        ${combo}
                                    </select>
                                </th>
                                <th scope="center">
                                    <select name="qtde" class="qtde form-control" onchange="atualizaQtdeProduto(${produto.id})">
                                        ${Array.from({length:12}, (_,i) => '<option value=' + i + '>' + (i+1) + '</option>')}
                                    </select>
                                </th>
                                <td align="center">
                                    <div><img src="${produto.image}" alt="${produto.description}" data-id="${produto.id}" width="100px;" height="75px;"></div>
                                    <div class="mt-1"><small class="text-muted produto">${produto.name}</small></div>
                                </td>
                                <td align="center">${produto.description}</td>
                                <td align="center">${produto.tipo}</td>
                                <td>
                                    <a href="#" class="btn btn-danger btn-circle btn-sm excluir" title="Excluír Produto" data-id="{{ $produto->id }}" onclick="removeProdutoLista(${produto.id})"><i class="fas fa-trash"></i></a>
                                </td>
                             </tr>`;

            document.querySelector('.pedido > tbody').insertAdjacentHTML('beforeend', pedido);
            document.querySelector('#enviar_pedido').setAttribute('style','display:block');

        });
    }
}



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

            icons.push({'iconFilePath': '../img/compras-shopping.png', 'iconValue':0});

            produtos.forEach(function(p){
                icons.push({'iconFilePath': p.image, 'iconValue':p.id});
            });

            iconSelect.refresh(icons);
        });

};



