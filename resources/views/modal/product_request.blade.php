<div class="modal fade modalRequestProduct" tabindex="-1" aria-labelledby="modalRequestProduct" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo-produto">Detalhe do Produto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row " align="center" id="tabela">
                    <div class="col-12 col-lg-12 my-3 border " id="filho">
                        <div class="row font-weight-bold">
                            <div class="col-3 col-sm-2 col-md-2 col-lg-2 border cabecalho">Produto</div>
                            <div class="col-2 col-sm-2 col-md-2 col-lg-2 border cabecalho">Medida</div>
                            <div class="col-3 col-sm-2 col-md-2 col-lg-2 border cabecalho">Marca</div>
                            <div class="col-2 col-sm-2 col-md-2 col-lg-2 border cabecalho">Categoria</div>
                            <div class="col-2 col-sm-2 col-md-2 col-lg-2 border cabecalho">Ação</div>
                        </div>
                        <div class="row pedido-modal" data-codigo="1">
                            <div class="col-3 col-sm-2 col-md-1 col-lg-2 border cabecalho prod-nome">
                                <select data-placeholder="Selecione um produto" class="form-control combo-prod" tabindex="3" name="produto_id" onchange="transformaComboSpan('pedido-modal',$(this).closest('[data-codigo]').data('codigo'), $(this).val(), $('.combo-prod option:selected').text(),'prod-nome','combo-prod','data-product_id','produto');getProductImage($(this).val(), $('.combo-produto option:selected').text());getCategory('pedido-modal',$(this).closest('[data-codigo]').data('codigo'), $(this).val(),'categoria');">
                                    <option value="">Selecione um produto</option>
                                </select>
                            </div>
                            <div class="col-2 col-sm-2 col-md-1 col-lg-2 border cabecalho measure-nome">
                                <select data-placeholder="Selecione uma medida" class="form-control combo-measure" tabindex="3" name="unidade_id" onchange="transformaComboSpan('pedido-modal',$(this).closest('[data-codigo]').data('codigo'), $(this).val(), $('.combo-measure option:selected').text(),'measure-nome','combo-measure','data-measure_id','medida')">
                                    <option value="">Selecione uma medida</option>
                                </select>
                            </div>
                            <div class="col-3 col-sm-2 col-md-1 col-lg-2 border cabecalho brand-nome">
                                <select data-placeholder="Selecione uma marca" class="form-control combo-brand" tabindex="3" name="marca_id" onchange="transformaComboSpan('pedido-modal',$(this).closest('[data-codigo]').data('codigo'), $(this).val(), $('.combo-brand option:selected').text(),'brand-nome','combo-brand','data-brand_id','marca')">
                                    <option value="">Selecione uma marca</option>
                                </select>
                            </div>
                            <div class="col-2 col-sm-2 col-md-1 col-lg-2 border cabecalho categoria">
                                <span class="categoria-nome" data-category_id>-</span>
                            </div>
                            <div class="col-2 col-sm-2 col-md-1 col-lg-2 border cabecalho">
                                <a href="javascript:void(0)" class="btn btn-warning btn-circle btn-sm atualizar-produto" title="Atualizar Produtos"  onclick="event.preventDefault(); ativaCombo('pedido-modal',$(this).closest('[data-codigo]').data('codigo'),'prod-nome',['combo-prod','combo-measure','combo-brand'])">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-2 d-none imagem-produto">
                    <div class="col-3 col-sm-2 col-md-1 col-lg-2 border cabecalho">
                        <div class="imagem" align="center"><!--JS --></div>
                    </div>
                    <div class="col-6 col-sm-2 col-md-1 col-lg-2 border cabecalho">
                        <div class="row">
                            <div class="col-12 col-sm-2 col-md-1 col-lg-2 cabecalho imagem-nome"><!--JS --></div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-2 col-md-1 col-lg-2 cabecalho imagem-descricao"><!--JS --></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="cancelar();">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnRequestProduto" onclick="">Cadastrar</button>
            </div>
        </div>
    </div>
</div>
