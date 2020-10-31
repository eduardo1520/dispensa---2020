// TODO
function atualizaQtde(codigo, operacao) {
    $('.pedido').each(function (x,y) {
        if($(this).closest('[data-codigo]').data('codigo') == codigo) {
            let qtde = parseInt($(this).children('div.qtde').text());
            if(operacao == '-' && qtde == 0) {
                alert('Não é permitido quantidade negativa!');
            } else if(operacao == '+'){
                qtde++;
                $(this).children('div.qtde').empty().text(qtde);
            } else {
                qtde--;
                $(this).children('div.qtde').empty().text(qtde);
            }
        }
    });
}
// TODO
function getCombo(pai, codigo, span, classe, combo) {
    $(`.${pai}`).each(function () {
        if($(this).closest('[data-codigo]').data('codigo') == codigo) {
            $(this).children('div.classe').children('span').hide();
            $(`span.${span}`).hide();
            $(`.${combo}`).removeAttr('style');
            $(`.${combo}`).removeClass('d-none').show();
        }
    });
}
// TODO
function transformaComboSpan(tabela, pai, id, nome, campo, combo,classe) {
    if($(`.${tabela}`).closest('[data-codigo]').data('codigo') == pai) {
        $(`.${combo}`).closest('div').append(`<span data-id="${id}" class="${campo}">${nome}</span>`);
        $(`div.${campo}`).attr('onclick',`getCombo('${tabela}','${pai}','${campo}','${classe}','${combo}')`);
        $(`.${combo}`).hide();
    }
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
                div.setAttribute('class', 'col-2 col-sm-2 col-md-1 col-lg-1 border cabecalho');
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
                            <input class="date desktop form-control" width="auto" value="29/10/2020" disabled="" onclose="" data-type="datepicker" data-guid="309eaf3c-77d5-4dd5-75dc-cdbbc6d17664" data-datepicker="true" role="input" day="2020-9-29">
                            <span class="input-group-append" role="right-icon">
                                <button class="btn btn-outline-secondary border-left-0" type="button">
                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                </button>
                            </span>
                        </div>
                            <span class="selecionado">${hoje.getDate()}/${hoje.getFullYear()}</span>
                        </div>`);

            document.querySelector('.acao').classList.add('d-none');
            document.querySelector('.drop').classList.remove('d-none');

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

function getProductImage(id, name) {
    promise(`product/productImageAjax`,'post', {id:id, name:name})
        .then(response => {
            return response.json();
        })
        .then(produto => {
            const imagem = document.querySelectorAll('.pedido > div.imagem');
            imagem.forEach(function(value){
                value.innerHTML = "";
                value.insertAdjacentHTML('beforeend', `<img src="${produto[0].image}" alt="${produto[0].description}" data-id="${produto[0].id}" width="100px;" height="75px;">`);
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

function comboProduto() {
    $promessa = promise(`product/productAjax`, 'post')
        .then(response => {
            return response.json();
        }).then(combo => {
            let element = document.querySelector(".combo-prod");
            combo.forEach(function(value){
                element.insertAdjacentHTML('beforeend', `<option value="${value['id']}">${value['name']}</option>`);
            });
        }).catch(error => {
            console.log('Deu erro,', error);
        });
}

function getCategory(classe, pai,produto,campo) {
    $promessa = promise(`product/productCategoryAjax`, 'post', {id:produto})
        .then(response => {
            return response.text();
        }).then(categoria => {
            if (document.querySelector(`.${classe}`).getAttribute('data-codigo') == pai) {
                let element = document.querySelector(`.${campo}`);
                element.innerHTML="";
                element.insertAdjacentHTML('beforeend', `<span class="${campo}">${categoria}</span>`);
            }
        }).catch(error => {
            console.log('Deu erro,', error);
        });
}

function setData() {
    let d = new Date();
    let hoje = `${d.getDate()}/${d.getMonth() +1}/${d.getFullYear()}`
    const data = document.querySelector('.date');
    data.setAttribute('value', (document.querySelector('#datetimepicker1').value != '') ? document.querySelector('#datetimepicker1').value : hoje);
    const selecionado = document.querySelector('.selecionado');
    selecionado.insertAdjacentHTML('beforeend', (document.querySelector('#datetimepicker1').value != '') ? document.querySelector('#datetimepicker1').value : hoje);
}

function addRows(pai) {
    let element = document.querySelector(`.date`);
    let data = element.value;
    pai = parseInt(document.querySelectorAll("#filho > .pedido").length) + 1;
    document.querySelector(`#filho`).insertAdjacentHTML('beforeend',`<div class="row pedido" data-codigo="${pai}">
                    <div class="col-4 col-sm-2 col-md-1 col-lg-2 border cabecalho data">${data}</div>
                    <div class="col-1 col-sm-2 col-md-1 col-lg-2 border cabecalho user">${document.querySelector(`.usuario`).innerText}</div>
                    <div class="col-2 col-sm-2 col-md-1 col-lg-1 border cabecalho qtde">0</div>
                    <div class="col-1 col-sm-2 col-md-1 col-lg-1 border cabecalho detalhe imagem">-</div>
                    <div class="col-2 col-sm-2 col-md-1 col-lg-1 border cabecalho produto   gj-cursor-pointer" onclick="getCombo('pedido',${pai},'produto-nome','produto','combo-produto')">
                        <span class="produto-nome" data-produto_id="">Produto</span>
                    </div>
                    <div class="col-2 col-sm-2 col-md-1 col-lg-1 border cabecalho medida  detalhe gj-cursor-pointer" onclick="getCombo('pedido',${pai},'medida-nome','medida','combo-medida')">
                        <span class="medida-nome" data-medida_id="">Medida</span>
                    </div>
                    <div class="col-2 col-sm-2 col-md-1 col-lg-1 border cabecalho marca  detalhe gj-cursor-pointer" onclick="getCombo('pedido',${pai},'marca-nome','marca','combo-marca')">
                        <span class="marca-nome" data-marca_id="">Marca</span>
                    </div>
                    <div class="col-1 col-sm-2 col-md-1 col-lg-1 border cabecalho detalhe  categoria">
                        <span class="categoria-nome" data-category_id="">-</span>
                    </div>
                    <div class="col-4 col-sm-2 col-md-1 col-lg-2 border cabecalho ">
                        <a href="javascript:void(0);" onclick="event.preventDefault(); atualizaQtde(${pai}, '+');" class="btn btn-primary btn-circle btn-sm" title="Adicionar Produto"><i class="fas fa-cart-plus"></i></a>
                        <a href="javascript:void(0);" onclick="event.preventDefault(); atualizaQtde(${pai}, '-');" class="btn btn-warning btn-circle btn-sm" title="Excluír Produto"><i class="fa fa-cart-arrow-down"></i></a>
                        <a href="javascript:void(0);" class="btn btn-success btn-circle btn-sm novo" title="Novo Produto" onclick="addRows(${pai})"><i class="fas fa-cart-plus"></i></a>
                        <a href="javascript:void(0);" class="btn btn-danger btn-circle btn-sm remove" title="Remove Produto" onclick="removeRows('pedido',${pai})"><i class="fas fa-trash"></i></a>
                    </div>
                  </div>`);
}

function removeRows(classe, pai) {
    document.querySelectorAll(`.${classe}`).forEach(function(div){
        div.getAttribute('data-codigo') == pai ? div.remove() : '';
    });
}

function atualizaCampoData(tabela, codigo, data) {
    document.querySelectorAll(`.${tabela}`).forEach(function(row){
        if(row.getAttribute('data-codigo') > codigo) {
            row.querySelector('div.data').innerHTML= data;
        }
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
}
