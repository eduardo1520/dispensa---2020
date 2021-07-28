<div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="margin-left: 200px;" id="tituloCodListModal">{{ $title ?? '' }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-codListModal" data-form-list>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">{{$subTitle ?? ''}}</label>
                        <div class="card border-left-danger shadow h-100 py-2" id="cardModal">
                            <div class="col-sm">
                                <div class="card mb-3" style="max-width: 400px;">
                                    <div class="row g-0">
                                        <div class="col-md-4">
                                            <img src="#" data-img width="150" height="150" alt="" style="margin-top:10px ;padding:10px;">
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-body" data-card-body>
                                                <h5 class="card-title" data-title>titulo</h5>
                                                <p class="card-text" data-codigo>Código: <span>codigo</span></p>
                                                <p class="card-text" data-qtde>Qtde: <span> qtde</span></p>
                                                <p class="card-text" data-qtde-titulo><small class="text-muted">[qtde] titulo</small></p>
                                                <p class="card-text" data-categoria><small class="text-muted">Categoria : <span>categoria</span></small></p>
                                                <p class="card-text" data-created_at><small class="text-muted">Data : <span>data</span></small></p>
                                                <textarea class="form-control" data-obs name="descricao" id="descricao" style="height: 100px; margin-top: 0px; margin-bottom: 0px;">
                                                </textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal" data-notificationOK>Ok</button>
            </div>
        </div>
    </div>
</div>

