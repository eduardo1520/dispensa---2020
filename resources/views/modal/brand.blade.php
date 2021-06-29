<div class="modal fade modalMarca" tabindex="-1" aria-labelledby="modalMarca" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo-marca">Cadastrar Marca</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-marca" onchange="validaCampos('form-marca','btnMarca',['input']);">
                    <div class="form-group">
                        <label for="name" class="col-form-label">Nome:<span class="small text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="cancelar();">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnMarca" onclick="salvarMarca()">Cadastrar</button>
            </div>
        </div>
    </div>
</div>
