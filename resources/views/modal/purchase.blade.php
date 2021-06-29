<div class="modal fade" id="pedidoModal2" tabindex="-1" aria-labelledby="pedidoModal2" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tituloCodListModal">{{ $title ?? '' }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-codListModal">
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Query</label>
                        <textarea class="form-control" name="descricao" id="descricao" style="height: 570px; margin-top: 0px; margin-bottom: 0px;"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal"  onclick="cancelar()">Ok</button>
            </div>
        </div>
    </div>
</div>

<script>
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

    document.addEventListener("DOMContentLoaded", function(event) {
        let url = '{{ $action ?? ''}}';
        if(url) {
            promise(`${url}`, 'post')
                .then(response => {
                    return response.json();
                }).then(queries => {
                let element = document.querySelector("#descricao");
                queries.forEach(function(value){
                    element.insertAdjacentHTML('beforeend', `${value}\n\n`);
                });
            }).catch(error => {
                    console.log('erro:', error);
                }
            );
        }
    });

</script>
