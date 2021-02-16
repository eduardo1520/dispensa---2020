
function atualizaQtde(codigo, operacao) {
    let produto = 0;
    document.querySelectorAll(`.pedido`).forEach(function(row){
        if(row.getAttribute('data-codigo') == codigo) {
            let qtde = parseInt(row.querySelector('.qtde').innerHTML);
            if(operacao == '-' && qtde == 0) {
                alert('Não é permitido quantidade negativa!');
            } else if(operacao == '+'){
                qtde++;
                row.querySelector('.qtde').innerHTML = qtde;
            } else {
                qtde--;
                row.querySelector('.qtde').innerHTML = qtde;
            }
            produto = row.querySelector('div.imagem > img').getAttribute('data-id');
            atualizarQtde(codigo, qtde, produto);
        }
    });
}
// TODO
function getCombo(pai, codigo, span, classe, combo) {
    // $(`.${pai}`).each(function () {
    //     if($(this).closest('[data-codigo]').data('codigo') == codigo) {
            // $(this).children('div.classe').children('span').hide();
            // $(`span.${span}`).hide();
            // $(`.${combo}`).removeAttr('style');
            // $(`.${combo}`).removeClass('d-none').show();
    //     }
    // });

    document.querySelectorAll(`.${pai}`).forEach(function(row){
        if(row.getAttribute('data-codigo') == codigo) {
            row.querySelector(`div>span.${span}`).classList.add('d-none');
            row.querySelector(`div>.${combo}`).classList.remove('d-none');
        }
    });
}

function getComboDinamico(pai, codigo, span, classe, combo) {
    document.querySelectorAll(`.${pai}`).forEach(function(row){
        if(row.getAttribute('data-codigo') == codigo) {
            row.querySelector(`div>span.${span}`).classList.add('d-none');
            row.querySelector(`div>.${combo}`).classList.remove('d-none');
        }
    });
}

// TODO trabalhar no carregamento do value para ser gravado no banco de dados.

function transformaComboSpan(tabela, pai, id, nome, campo) {
    document.querySelectorAll(`.${tabela}`).forEach(function(row){

        if(row.getAttribute('data-codigo') == pai) {
            var select = row.querySelector('select');
            var option = select.children[select.selectedIndex];
            var texto = option.textContent;

            if(texto !== "Selecione um Produto") {
                row.querySelector('.combo-produto').classList.add('d-none');
                row.querySelector(`.${campo}`).classList.remove('d-none');
                row.querySelector(`.${campo}`).setAttribute('value',option.value);
                row.querySelector(`.${campo}`).innerHTML = texto;
                let params = {id: pai, product_id: option.value };
                row.querySelectorAll('div > span').forEach(function(r){
                    if(r.classList.contains('marca-nome')) {
                        params['brand_id'] = r.getAttribute('data-filho');
                    }
                    if(r.classList.contains('categoria-nome')) {
                        params['category_id'] = r.getAttribute('data-filho');
                    }
                });
                atualizarProduto(params);
                return;
            }

            // atualiza a medida do produto

            row.querySelectorAll('div').forEach(function(r){
                if(r.classList.contains('medida') != null && r.classList.contains('medida') == true &&  r.querySelector(`.${campo}`) != null) {
                    var select = r.querySelector('select');
                    var option = select.children[select.selectedIndex];
                    var texto = option.textContent;

                    r.querySelector('.combo-medida').classList.add('d-none');
                    r.querySelector(`.${campo}`).classList.remove('d-none');
                    r.querySelector(`.${campo}`).setAttribute('value',option.value);
                    r.querySelector(`.${campo}`).innerHTML = texto;

                    let produto = row.querySelectorAll('div.imagem > img').item(0);
                    let params = {id: pai, measure_id: option.value, product_id: produto.getAttribute('data-id')};

                    atualizarProduto(params);
                    return;
                }
            });
        }
    });
}

function transformaComboSpanDinamico(tabela, pai, id, nome, campo) {
    document.querySelectorAll(`.${tabela}`).forEach(function(row){
        if(row.getAttribute('data-codigo') == pai) {
            var select = row.querySelector('select');
            var option = select.children[select.selectedIndex];
            var texto = option.textContent;

            if(texto !== "Selecione um Produto") {
                row.querySelector(`.${campo}`).classList.add('d-none');
                row.querySelector(`.produto-nome`).classList.remove('d-none');
                row.querySelector(`.${campo}`).setAttribute('value',option.value);
                row.querySelector(`.produto-nome`).innerHTML = texto;

                let params = {id: pai, product_id: option.value };

                row.querySelectorAll('div > span').forEach(function(r){
                    if(r.classList.contains('marca-nome')) {
                        params['brand_id'] = r.getAttribute('data-filho');
                    }

                    if(r.classList.contains('categoria-nome')) {
                        params['category_id'] = r.getAttribute('data-filho');
                    }

                });

                atualizarProduto(params);
                return;
            }

            // atualiza a medida do produto

            row.querySelectorAll('div').forEach(function(r){
                if(r.classList.contains('medida') != null && r.classList.contains('medida') == true &&  r.querySelector(`.${campo}`) != null) {
                    var select = r.querySelector('select');
                    var option = select.children[select.selectedIndex];
                    var texto = option.textContent;

                    r.querySelector('.combo-medida').classList.add('d-none');
                    r.querySelector(`.${campo}`).classList.remove('d-none');
                    r.querySelector(`.${campo}`).setAttribute('value',option.value);
                    r.querySelector(`.${campo}`).innerHTML = texto;

                    let produto = row.querySelectorAll('div.imagem > img').item(0);
                    let params = {id: pai, measure_id: option.value, product_id: produto.getAttribute('data-id')};

                    atualizarProduto(params);
                    return;
                }
            });

        }
    });
}

// TODO
function ativaCombo(classe, codigo, campo, combo) {
    $(`.${classe}`).find(`.${campo}`).each(function (x,campo) {
        if($(this).closest('[data-codigo]').data('codigo') == codigo) {
            if($(campo).data('id') > 0) {
                for (const c in combo) {
                    let span = combo[c].split('-');
                    $(`span.${span[1]}-nome`).hide();
                    $(`.${combo[c]}`).show();
                }
            }
        }
    })
}
// TODO
function detectar_mobile() {
    var check = false; //wrapper no check
    (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4)))check = true})(navigator.userAgent||navigator.vendor||window.opera);

    if(check == true) {
        const body = document.querySelectorAll("body#page-top");
        body.forEach(function(value){
            value.classList.remove('sidebar-toggled');
        });
        const accordion = document.querySelectorAll("ul#accordionSidebar");
        accordion.forEach(function(value){
            value.classList.remove('accordion');
            value.classList.add('toggled');
        });

        if(window.screen.width <= 568) {
            const user = document.querySelectorAll('div.user');
            user.forEach(function(div){
                div.classList.add('d-none');
            });
            const detalhe = document.querySelectorAll('div.detalhe');
            detalhe.forEach(function(div){
                div.classList.add('d-none');
            });
            const produto = document.querySelectorAll('div.produto');
            produto.forEach(function(div){
                div.setAttribute('onclick','');
                div.setAttribute('data-toggle','modal');
                div.setAttribute('data-target','.modalRequestProduct');
                div.setAttribute('onclick',"abreModalRequestProduct()");

                if(window.screen.width > 320) {
                    div.setAttribute('class', 'col-2 col-sm-2 col-md-1 col-lg-1 border cabecalho');
                } else {
                    div.setAttribute('class', 'col-4 col-sm-2 col-md-1 col-lg-2 border cabecalho');
                }
            });
            const datepicker = document.querySelectorAll('div.pedido > div.data > div.gj-datepicker');
            datepicker.forEach(function(div){
                div.classList.add('d-none');
            });
            let hoje = new Date();
            const data = document.querySelectorAll('div.data');
            data.forEach(function(div){
                div.setAttribute('onclick','habilitaData()');
                div.setAttribute('data-toggle',"modal");
                div.setAttribute('data-target',".modalData");
                div.insertAdjacentHTML('beforeend',`<span class="selecionado">${hoje.getDate()}/${hoje.getMonth() + 1}/${hoje.getFullYear()}</span>`);
            });
        }

        if(window.screen.width <= 320) {
            const tabela = document.querySelectorAll('#tabela > #filho > div.row > div');
            tabela.forEach(function(value){
                value.style['padding-left'] = '5px';
                value.style['padding-right'] = '5px';
            });
            let hoje = new Date();
            const qtde = document.querySelectorAll('div.qtde');
            qtde.forEach(function(div){
                div.classList.add('d-none');
            });
            const produto = document.querySelectorAll('div.prod');

            produto.forEach(function(div){
                div.setAttribute('class', 'col-4 col-sm-2 col-md-1 col-lg-2 border cabecalho');
            });
            const data = document.querySelectorAll('div.data');
            data.forEach(function(div){
                div.remove();
            });
            document.querySelector('.pedido').insertAdjacentHTML('afterbegin',`<div class="col-4 col-sm-2 col-md-1 col-lg-2 border cabecalho data" onclick="habilitaData()" data-toggle="modal" data-target=".modalData" style="padding-left: 5px; padding-right: 5px;">
                        <div role="wrapper" class="gj-datepicker gj-datepicker-bootstrap gj-unselectable input-group d-none" style="width: auto;">
                            <input class="date desktop form-control" width="auto" value="${("0" + hoje.getDate()).slice(-2)}/${hoje.getFullYear()}" disabled="" onclose="" data-type="datepicker" data-guid="309eaf3c-77d5-4dd5-75dc-cdbbc6d17664" data-datepicker="true" role="input" day="2020-9-29">
                            <span class="input-group-append" role="right-icon">
                                <button class="btn btn-outline-secondary border-left-0" type="button">
                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                </button>
                            </span>
                        </div>
                            <span class="selecionado">${("0" + hoje.getDate()).slice(-2)}/${hoje.getFullYear()}</span>
                        </div>`);

            document.querySelector('.acao').classList.add('d-none');
        }

    } else {
        if(window.screen.width > 568) {
            document.querySelector('.user').classList.add('d-block');
            const produto = document.querySelectorAll('div.produto');
            produto.forEach(function(div){
                div.setAttribute('class', 'col-2 col-sm-2 col-md-1 col-lg-1 border cabecalho');
            });
        }
    }

    setTimeout(() =>{
        document.querySelector('#tabela').classList.add('d-block');
    },0);
}

function getProductImage(pai, id, name) {
    if(id == '' && name == '') {
        document.querySelectorAll('.pedido').forEach(function(image) {
            if(image.getAttribute('data-codigo') == pai) {
                id = image.querySelector('select.dinamico').value;
                name = image.querySelector('div.produto > span.produto-nome').innerHTML;
            }
        });
    }

    promise(`product/productImageAjax`,'post', {id:id, name:name})
        .then(response => {
            return response.json();
        })
        .then(produto => {
            const imagem = document.querySelectorAll('.pedido');
            imagem.forEach(function(value){
                if(value.getAttribute('data-codigo') == pai) {
                    value.querySelector('div.imagem').innerHTML = "";
                    value.querySelector('div.imagem').insertAdjacentHTML('beforeend', `<img src="${produto[0].image}" alt="${produto[0].description}" data-id="${produto[0].id}" width="100px;" height="75px;">`);
                }
            });
            document.querySelector('.imagem-produto').classList.remove('d-none');
            const imagem_produto = document.querySelectorAll('.imagem-produto > .cabecalho > .imagem');
            imagem_produto.forEach(function(value){
                value.classList.remove('d-none');
                value.innerHTML = "";
                value.insertAdjacentHTML('beforeend', `<img src="${produto[0].image}" alt="${produto[0].description}" data-id="${produto[0].id}" width="100px;" height="75px;">`);
            });
           document.querySelector('.imagem-nome').innerHTML = produto[0].name;
           document.querySelector('.imagem-descricao').innerHTML = produto[0].description;
        });
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

function comboBrand() {
    $promessa = promise(`brand/brandAjax`, 'post')
        .then(response => {
            return response.json();
        }).then(combo => {
            let element = document.querySelector(".combo-brand");
            combo.forEach(function(value){
                element.insertAdjacentHTML('beforeend', `<option value="${value['id']}">${value['name']}</option>`);
            });
        }).catch(error => {
            console.log('erro:', error);
        });
}

function comboMeasure() {
    $promessa = promise(`measure/measureAjax`, 'post')
        .then(response => {
            return response.json();
        }).then(combo => {
            let element = document.querySelector(".combo-measure");
            combo.forEach(function(value){
                element.insertAdjacentHTML('beforeend', `<option value="${value['id']}">${value['nome']} - (${value['sigla']})</option>`);
            });
        }).catch(error => {
            console.log('Deu erro,', error);
        });
}

function comboProduto(pai) {
    $promessa = promise(`product/productAjax`, 'post')
        .then(response => {
            return response.json();
        }).then(combo => {
            let produto = document.querySelectorAll(`.pedido`);
            produto.forEach(function(value){
                if(value.getAttribute('data-codigo') == pai) {
                    let t = value.querySelectorAll('div.produto > select.dinamico').item(0);
                    combo.forEach(function(value){
                        t.insertAdjacentHTML('beforeend', `<option value="${value['id']}">${value['name']}</option>`);
                    });
                }
            });
        }).catch(error => {
            console.log('Deu erro,', error);
        });
}

function getCategory(classe, pai,produto,campo) {
    $promessa = promise(`product/productCategoryAjax`, 'post', {id:produto})
        .then(response => {
            return response.json();
        }).then(categoria => {
            let cat = document.querySelectorAll(`.${classe}`);
            cat.forEach(function(value){
                if(value.getAttribute('data-codigo') == pai) {
                    value.querySelector(`.${campo}`).innerHTML="";
                    value.querySelector(`.${campo}`).insertAdjacentHTML('beforeend', `<span data-filho="${categoria.category_id}" >${categoria.tipo}</span>`);
                }
            });
        }).catch(error => {
            log('Deu erro:',error);
        });
}

function getBrand(classe, pai,produto,campo) {
    $promessa = promise(`product/productBrandAjax`, 'post', {id:produto})
        .then(response => {
            return response.json();
        }).then(marca => {
            let marcas = document.querySelectorAll(`.${classe}`);
            marcas.forEach(function(value){
                if(value.getAttribute('data-codigo') == pai) {
                    value.querySelector(`.${campo}`).innerHTML="";
                    value.querySelector(`.${campo}`).insertAdjacentHTML('beforeend', `<span data-filho="${marca.brand_id}" >${marca.name}</span>`);
                }
            });
        }).catch(error => {
            log('Deu erro:',error);
        });
}

function setData() {
    let d = new Date();
    let hoje = `${d.getDate()}/${d.getMonth() +1}/${d.getFullYear()}`;
    const data = document.querySelector('.date');
    data.setAttribute('value', (document.querySelector('#datetimepicker1').value != '') ? document.querySelector('#datetimepicker1').value : hoje);
    const selecionado = document.querySelector('.selecionado');
    selecionado.insertAdjacentHTML('beforeend', (document.querySelector('#datetimepicker1').value != '') ? document.querySelector('#datetimepicker1').value : hoje);
}

function addRows(pai) {
    let element = document.querySelector(`.date`);
    let data = element.value;
    pai = parseInt(document.querySelectorAll("#filho > .pedido").length) + 1;
    let botoes;
    if (window.screen.width > 320) {
        botoes = `<div class="col-4 col-sm-2 col-md-1 col-lg-2 border cabecalho ">
                        <a href="javascript:void(0);" onclick="event.preventDefault(); atualizaQtde(${pai}, '+');" class="btn btn-primary btn-circle btn-sm" title="Adicionar Produto"><i class="fas fa-cart-plus"></i></a>
                        <a href="javascript:void(0);" onclick="event.preventDefault(); atualizaQtde(${pai}, '-');" class="btn btn-warning btn-circle btn-sm" title="Excluír Produto"><i class="fa fa-cart-arrow-down"></i></a>
                        <a href="javascript:void(0);" class="btn btn-success btn-circle btn-sm novo" title="Novo Produto" onclick="addRows(${pai})"><i class="fas fa-cart-plus"></i></a>
                        <a href="javascript:void(0);" class="btn btn-danger btn-circle btn-sm remove" title="Remove Produto" onclick="removeRows('pedido',${pai})"><i class="fas fa-trash"></i></a>
                    </div>`;
    } else {
        botoes = `<div class="btn-group drop dropleft">
                         <a href="javascript:void(0);" class="btn btn-danger btn-circle btn-sm remove" title="Remove Produto" onclick="removeRows('pedido',${pai})"><i class="fas fa-trash"></i></a>
                        <button type="button" class="btn btn-sm btn-success" onclick="addRows($(this).closest('[data-codigo]').data('codigo'))"><i class="fas fa-cart-plus"></i></button>
                        <button type="button" class="btn btn-sm btn-success dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu">
                            <div>
                                <a class="dropdown-item" href="#"><i class="fas fa-cart-plus" > </i> Aumentar Quantidade</a>
                            </div>
                            <div>
                                <a class="dropdown-item" href="#"><i class="fa fa-cart-arrow-down"></i> Diminuir Quantidade</a>
                            </div>
                        </div>
                    </div>`;
    }

    mountRow(pai);

    document.querySelector(`#filho`).insertAdjacentHTML('beforeend', `<div class="row pedido" data-codigo="${pai}">
        <div class="col-4 col-sm-2 col-md-1 col-lg-2 border cabecalho data">${data}</div>
        <div class="col-1 col-sm-2 col-md-1 col-lg-2 border cabecalho user ${window.screen.width <= 568 ? 'd-none' : ''}">${document.querySelector(`.usuario`).innerText}</div>
        <div class="col-2 col-sm-2 col-md-1 col-lg-1 border cabecalho qtde ${window.screen.width < 568 ? 'd-none' : ''}">0</div>
        <div class="col-1 col-sm-2 col-md-1 col-lg-1 border cabecalho detalhe imagem ${window.screen.width <= 320 || window.screen.width == 568 ? 'd-none' : ''}">-</div>
        <div class="${window.screen.width == 320 ? 'col-3 col-sm-2 col-md-1 col-lg-1' : 'col-2 col-sm-2 col-md-1 col-lg-1'}  border cabecalho produto   gj-cursor-pointer" onchange="getComboDinamico('pedido',${pai},'produto-nome','produto','combo-produto')">
            <span class="produto-nome" data-produto_id="">${window.screen.width == 320 ? 'Prod.' : 'Produto'}</span>
            <select name="" id="produto_id" class="form-control combo-produto dinamico" tabindex="3" onchange='transformaComboSpanDinamico("pedido","${pai}","", "","dinamico");getProductImage("${pai}","","")'></select>
        </div>
        <div class="col-2 col-sm-2 col-md-1 col-lg-1 border cabecalho medida  detalhe gj-cursor-pointer ${window.screen.width <= 320 || window.screen.width == 568 ? 'd-none' : ''}" onchange="getComboDinamico('pedido',${pai},'medida-nome','medida','combo-medida')">
            <span class="medida-nome" data-medida_id="">Medida</span>
        </div>
        <div class="col-2 col-sm-2 col-md-1 col-lg-1 border cabecalho marca  detalhe gj-cursor-pointer ${window.screen.width <= 320 || window.screen.width == 568 ? 'd-none' : ''}" onchange="getComboDinamico('pedido',${pai},'marca-nome','marca','combo-marca')">
            <span class="marca-nome" data-marca_id="">Marca</span>
        </div>
        <div class="col-1 col-sm-2 col-md-1 col-lg-1 border cabecalho detalhe  categoria ${window.screen.width <= 320 || window.screen.width == 568 ? 'd-none' : ''}">
            <span class="categoria-nome" data-category_id="">-</span>
        </div>
            ${botoes}
      </div>`
    );
}

function mountRow(pai) {

    // montar o combo de produtos
    comboProduto(pai);
    // montar o combo de medidas
    comboBrand();

}

function removeRows(classe, pai) {
    let produto = '';
    document.querySelectorAll(`.${classe}`).forEach(function(div){
        if(div.getAttribute('data-codigo') == pai) {
            produto = div.querySelector(`div > span.produto-nome`).innerHTML;
        }
    });

    Swal.fire({
        title: "Deseja realmente excluir o produto " + (produto != '') ? produto.toLowerCase() : '' + "?",
        text: "O item escolhido será apagado!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Apagar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            document.querySelectorAll(`.${classe}`).forEach(function(div){
                div.getAttribute('data-codigo') == pai ? div.remove() : '';
            });

            removeProduto(pai);

            Swal.fire(
                'Sucesso!',
                'O item selecionado foi apagado.',
                'success'
            )
        }
    });
}

function atualizaCampoDataAll(tabela, codigo, data) {
    let hoje = new Date();
    let dado = data.split('/');
    let m  = dado[1].split('0').filter((el) =>{
        if(el != null) return el;
    });
    let dt_antiga = new Date(`${dado[2]}-${m}-${dado[0]}` );
    let d = `${hoje.getDate()}-${hoje.getMonth()+1}-${hoje.getFullYear()}`;

    if(dataDiff(dt_antiga, hoje) === 'menor') {
        document.querySelectorAll(`.${tabela}`).forEach(function(row){
            row.querySelector('div.data').classList.add('gj-cursor-pointer');
            row.querySelector('div.data > .gj-datepicker').classList.add('d-none');
            row.querySelector('div.data').setAttribute('onclick',"habilitaData2('" + tabela +"')");
            row.querySelector('div.data > .dt_dinamica').classList.remove('d-none');
            row.querySelector('div.data > .dt_dinamica').innerHTML = dataBR(d, '-');
        });
        atualizaData(codigo, dataBD(d, '-'));
    } else if(dataDiff(dt_antiga, hoje) === 'maior') {
        document.querySelectorAll(`.${tabela}`).forEach(function(row){
            row.querySelector('div.data').classList.add('gj-cursor-pointer');
            row.querySelector('div.data > .gj-datepicker').classList.add('d-none');
            row.querySelector('div.data').setAttribute('onclick',"habilitaData2('" + tabela +"')");
            row.querySelector('div.data > .dt_dinamica').classList.remove('d-none');
            row.querySelector('div.data > .dt_dinamica').innerHTML = dataBR(data, '/');
        });
    } else {
        document.querySelectorAll(`.${tabela}`).forEach(function(row){
            row.querySelector('div.data').classList.add('gj-cursor-pointer');
            row.querySelector('div.data > .gj-datepicker').classList.add('d-none');
            row.querySelector('div.data').setAttribute('onclick',"habilitaData2('" + tabela +"')");
            row.querySelector('div.data > .dt_dinamica').classList.remove('d-none');
            row.querySelector('div.data > .dt_dinamica').innerHTML = dataBR(d, '-');
        });
    }
}

function atualizaCampoData(tabela, codigo, data) {
    document.querySelectorAll(`.${tabela}`).forEach(function(row){
        row.querySelector('div.data').classList.add('gj-cursor-pointer');
        row.querySelector('div.data > .gj-datepicker').classList.add('d-none');
        row.querySelector('div.data').setAttribute('onclick',"habilitaData2('" + tabela +"')");
        row.querySelector('div.data > .dt_dinamica').classList.remove('d-none');
        row.querySelector('div.data > .dt_dinamica').innerHTML = dataBR(data, '/');
        atualizaData(row.getAttribute('data-codigo'), dataBD(data.replaceAll('/','-'),'-'));
    });
}

function habilitaData2(tabela) {
    document.querySelectorAll(`.${tabela}`).forEach(function(row){
        row.querySelector('div.data > .dt_dinamica').classList.add('d-none');
        row.querySelector('div.data > .gj-datepicker').classList.remove('d-none');
    });
}

function salvaRequesicaoProduto(produto, medida, marca) {
    let params = {product_id: produto, measure_id: medida ,brand_id: marca};
    $promessa = promise(`productRequest/productRequestAjax`, 'post', params)
        .then(response => {
            return response.text();
        }).then(resultado => {
            let modalproduto = document.querySelector('.modalRequestProduct ');
            modalproduto.classList.remove('show');
            modalproduto.setAttribute('style','display:none');
            let backdrop = document.querySelector('.modal-backdrop');
            backdrop.classList.remove('show');
            alert(resultado);
        }).catch(error => {
            console.log('erro:', error);
        });
}

function atualizaData(codigo, data) {
    let params = {id: codigo, data: data };
    $promessa = promise(`productRequest/atualiza`, 'post', params)
        .then(response => {
            return response.text();
        }).then(mensagem => {

        }).catch(error => {
            console.log('erro', error);
        });

}

function atualizarQtde(codigo, qtde, produto) {
    let params = {id: codigo, qtde: qtde, product_id: produto };
    $promessa = promise(`productRequest/atualiza`, 'post', params)
        .then(response => {
            return response.text();
        }).then(mensagem => {

        }).catch(error => {
            console.log('erro', error);
        });
}

function atualizarProduto(data) {
    // let params = {id: codigo, product_id: produto };
    $promessa = promise(`productRequest/atualiza`, 'post', data)
        .then(response => {
            return response.text();
        }).then(mensagem => {

        }).catch(error => {
            console.log('erro', error);
        });
}

function removeProduto(id) {
    $promessa = promise(`productRequest/remover`, 'post', {'id':id})
        .then(response => {
            return response.text();
        }).then(mensagem => {

        }).catch(error => {
            console.log('erro', error);
        });
}

// Funções Utilizadas Dinamicamente.

function habilitaData() {
    const elemento = document.querySelectorAll('.desktop , .input-group-append');
    elemento.forEach(function(value){
        value.classList.add("d-none");
    });
    const selecionado = document.querySelector('.selecionado');
    selecionado.innerHTML = "";
    selecionado.setAttribute('value',document.querySelector('#datetimepicker1'));
    const datepicker = document.querySelector('#admin > .gj-datepicker');
    datepicker.setAttribute('style','');
    const admin = document.querySelectorAll('#admin > div.gj-datepicker > span');
    admin.forEach(function(value){
        value.classList.remove('d-none');
    });
}

function dataBD(data, separador) {
    let mes = '';
    if(separador == '/') {
        data = data.split('/');
        mes = data[1] < 10 ? "0" + parseInt(data[1]) : data[1]
        data = `${data[2]}/${mes}/${data[0]}`;
    }
    else if(separador == '-') {
        data = data.split('-');
        mes = data[1] < 10 ? "0" + parseInt(data[1]) : data[1]
        data = `${data[2]}-${mes}-${data[0]}`;
    }
    return data;
}

function dataBR(data, separador) {
    let mes = '';
    if(separador == '/') {
        data = data.split('/');
        mes = data[1] < 10 ? "0" + parseInt(data[1]) : data[1];
        data = `${data[0]}/${mes}/${data[2]}`;
    }
    else if(separador == '-') {
        data = data.split('-');
        mes = data[1] < 10 ? "0" + parseInt(data[1]) : data[1];
        data = `${data[0]}-${mes}-${data[2]}`;
    }
    return data;
}

function dataDiff(data1, data2) {

        let d1 = new Date(data1);
        let d2 = new Date(data2);
        let resultado = 0;

        if(`${d1.getDate()}${d1.getMonth()}${d1.getFullYear()}` > `${d2.getDate()}${d2.getMonth()}${d2.getFullYear()}`) {
            resultado = 'maior';
        } else if(`${d1.getDate()}${d1.getMonth()}${d1.getFullYear()}` < `${d2.getDate()}${d2.getMonth()}${d2.getFullYear()}`) {
            resultado = 'menor';
        } else {
            resultado = 'igual';
        }

        return resultado;
}

function abreModalRequestProduct() {
    comboProduto();
    comboMeasure();
    comboBrand();
}

function log(dado) {
    console.log(dado);
}

window.onload=function() {
    detectar_mobile();
    document.addEventListener('click', function (event) {
        // If the clicked element doesn't have the right selector, bail
        if (!event.target.matches('#btnRequestProduto')) return;
        // Don't follow the link
        event.preventDefault();
        // Log the clicked element in the console
        // console.log(event.target);
        let produto = document.querySelector('.prod-nome > span');
        let medida = document.querySelector('.measure-nome > span');
        let marca = document.querySelector('.brand-nome > span');

        salvaRequesicaoProduto(produto.getAttribute('data-id'), medida.getAttribute('data-id'), marca.getAttribute('data-id'));
    }, false);

}
