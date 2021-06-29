<div class="modal fade modalCategoria" tabindex="-1" aria-labelledby="modalCategoria" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo-categoria">Atualizar Categoria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-categoria" onchange="validaCampos('form-categoria','btnCategoria',['input']);">
                    <input type="hidden" id="id">
                    <div class="form-group">
                        <label for="tipo" class="col-form-label">Tipo:<span class="small text-danger">*</span></label>
                        <input type="text" class="form-control" id="tipo" name="tipo" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="cancelar();">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnCategoria" onclick="salvarCategoria()">Cadastrar</button>
            </div>
        </div>
    </div>
</div>
