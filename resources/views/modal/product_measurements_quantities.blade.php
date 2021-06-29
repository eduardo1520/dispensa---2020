<div class="modal fade confProductMeasurementsQuantities" id="confProductMeasurementsQuantities" tabindex="-1" aria-labelledby="modalConfProductMeasurementsQuantities" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="medidas-produto">Quantidade de Produto por Medidas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div id="confProductMeasurementsQuantities_pai">
                            <script>
                                try{
                                    let conf = document.querySelector('#confProductMeasurementsQuantities_pai');
                                    let image = document.querySelector('#produto_imagem > img');
                                    let div = document.querySelector('div#produto_nome');
                                    let small =  document.querySelector('div#produto_nome > small');
                                    let nome = document.querySelector('div#produto_nome > small').innerHTML;
                                    let img2 = document.createElement('img');

                                    let dv0 = document.createElement('div');
                                    dv0.setAttribute('class','row');

                                    let dv1 = document.createElement('div');

                                    dv1.setAttribute('class','col-md-2');

                                    img2.src = image.getAttribute('src');
                                    img2.alt = image.getAttribute('alt');
                                    img2.width = image.getAttribute('width');
                                    img2.height = image.getAttribute('height');
                                    img2.style = 'margin-top:20px;';

                                    dv0.appendChild(dv1);
                                    dv1.appendChild(img2);
                                    conf.appendChild(dv0);

                                    let div2 = document.createElement('div');
                                    div2.style = 'padding-left:5px;padding-top:10px';

                                    let small2 = document.createElement('small');
                                    small2.setAttribute('class',small.getAttribute('class'));
                                    small2.innerText = nome;
                                    small2.style = 'margin-left:55px;';

                                    div2.appendChild(small2);
                                    conf.appendChild(div2);

                                    let div3 = document.createElement('div');
                                    div3.style = 'padding-left:50px; padding-top:35px';
                                    div3.setAttribute('class','col-md-8 col-md-6 mb-4 ml-5');

                                    let div4 = document.createElement('div');
                                    div4.setAttribute('class','card border-left-success shadow h-100 py-2');

                                    let div5 = document.createElement('div');
                                    div5.setAttribute('class','card-body');

                                    let div6 = document.createElement('div');
                                    div6.setAttribute('class','row no-gutters align-items-center');

                                    let div7 = document.createElement('div');
                                    div7.setAttribute('class','col mr-2');

                                    let div8 = document.createElement('div');
                                    div8.setAttribute('class','text-xs font-weight-bold text-success text-uppercase mb-1');
                                    div8.innerText = 'Quantidades';

                                    let div9 = document.createElement('div');
                                    div7.setAttribute('class','h5 mb-0 font-weight-bold text-gray-800');

                                    let table = document.createElement('table');
                                    table.setAttribute('class','mt-lg-3 table table-bordered table-responsive-lg');

                                    let thead = document.createElement('thead');
                                    let tr = document.createElement('tr');
                                    tr.setAttribute('align','center');

                                    let th = document.createElement('th');
                                    th.innerText = 'Medidas';

                                    let th2 = document.createElement('th');
                                    th2.style = 'text-align:center';
                                    th2.innerText = 'Qtde';

                                    let tbody = document.createElement('tbody');
                                    let tr2 = document.createElement('tr');
                                    let td = document.createElement('td');
                                    td.setAttribute('id', 'medida');
                                    let td2 = document.createElement('td');
                                    td2.setAttribute('id', 'qtde');
                                    td.innerText = document.querySelector('tbody > tr').getAttribute('data.measure_nome');

                                    let input = document.createElement('input');
                                    input.setAttribute('class', 'form-control qtde');
                                    input.setAttribute('onkeypress', 'return event.charCode >= 48 && event.charCode <= 57');
                                    input.setAttribute('onblur', `parseInt(document.querySelector(".qtde").value) > 100 ? mensagemAlerta('qtde') : document.querySelector('#btnAtualizarQtde').removeAttribute('disabled');`);
                                    td2.appendChild(input);

                                    thead.appendChild(th);
                                    thead.appendChild(th2);

                                    tr2.appendChild(td);
                                    tr2.appendChild(td2);
                                    tbody.appendChild(tr2);
                                    table.appendChild(tbody);

                                    table.appendChild(thead);

                                    dv1.appendChild(div2);

                                    div3.appendChild(div4);
                                    div4.appendChild(div5);
                                    div5.appendChild(div6);
                                    div6.appendChild(div7);
                                    div7.appendChild(div8);

                                    div7.appendChild(table);

                                    dv0.appendChild(div3);
                                } catch(error) {
                                    //
                                }

                            </script>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnAtualizarQtde" data-dismiss="modal"
                        onclick="AtualizarQtdeProdutosPorMedidas(document.querySelector('td#medida').getAttribute('data-product_id'),
                                                             document.querySelector('td#medida').getAttribute('data-measure_id'),
                                                             document.querySelector('#qtde > input.qtde').value)" disabled>Atualizar</button>
            </div>
        </div>
    </div>
</div>
