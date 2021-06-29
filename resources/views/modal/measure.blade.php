<div class="modal fade" id="medidaModal" tabindex="-1" aria-labelledby="medidaModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo-medida">Cadastro de Unidade de Medidas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-medida" onchange="validaCampos('form-medida','btnMedida',['input']);">
                    <div class="row">
                        <div class="col-lg-8">
                            <div>
                                <label class="form-control-label" for="nome">Nome:<span class="small text-danger">*</span></label>
                                <input type="text" class="form-control" name="nome" id="nome" required>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div>
                                <label class="form-control-label" for="sigla">Sigla:<span class="small text-danger">*</span></label>
                                <input type="text" class="form-control" name="sigla" id="sigla" required>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"  onclick="cancelar()">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="salvarMedida()" id="btnMedida" disabled>Cadastrar Medida</button>
            </div>
        </div>
    </div>
</div>
