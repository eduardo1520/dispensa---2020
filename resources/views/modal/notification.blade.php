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
                <form id="form-codListModal">
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">{{$subTitle ?? ''}}</label>
                        <div class="card border-left-danger shadow h-100 py-2" id="cardModal">
                            <div class="col-sm">
                                <div class="card mb-3" style="max-width: 400px;">
                                    <div class="row g-0">
                                        <div class="col-md-4">
                                            <img src="#" width="150" height="150" alt="" style="margin-top:10px ;padding:10px;">
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-body m">
                                                <h5 class="card-title title">titulo</h5>
                                                <p class="card-text codigo">Código: <span>codigo</span></p>
                                                <p class="card-text qtde">Qtde: <span> qtde</span></p>
                                                <p class="card-text up_dinamico"><small class="text-muted">[qtde] titulo</small></p>
                                                <p class="card-text categoria"><small class="text-muted">Categoria : <span>categoria</span></small></p>
                                                <p class="card-text up_data"><small class="text-muted">Data : <span>data</span></small></p>
                                                <textarea class="form-control obs" name="descricao" id="descricao" style="height: 100px; margin-top: 0px; margin-bottom: 0px;">
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
        {{--let url = '{{ $action ?? ''}}';--}}
        {{--if(url) {--}}
        {{--    promise(`${url}`, 'post')--}}
        {{--        .then(response => {--}}
        {{--            return response.json();--}}
        {{--        }).then(queries => {--}}
        {{--            let element = document.querySelector("#descricao");--}}
        {{--            queries.forEach(function(value){--}}
        {{--                element.insertAdjacentHTML('beforeend', `${value}\n\n`);--}}
        {{--            });--}}
        {{--        }).catch(error => {--}}
        {{--            console.log('erro:', error);--}}
        {{--        }--}}
        {{--    );--}}
        {{--}--}}
    });

</script>
