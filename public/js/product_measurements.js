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

function log(dado) {
    console.log(dado);
}

function getImageProduct(id, name) {
    $promessa = promise(`/product/productImageAjax`, 'post', {'id': id, 'name':name})
        .then(response => {
            return response.json();
        }).then(imagem => {
            if(imagem) {
                let element = document.querySelector("div#produto_imagem");

                imagem.forEach(function(value){
                    element.insertAdjacentHTML('beforeend', `<img src="../../${value['image']}" width="150" height="150" alt=""/>`);
                    element.insertAdjacentHTML('beforeend', `<div style="padding-top: 10px; padding-left: 45px;"><small class="text-muted">${value['name']}</small></div>`);
                });
            }
        }).catch(error => {
            log('erro:', error);
        });
}

function confirmar() {

    if(document.querySelector('div.box2 > select')) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary ml-1',
                cancelButton: 'btn btn-danger',

            },
            buttonsStyling: true
        });

        swalWithBootstrapButtons.fire({
            title: 'Você realmente que remover todas as medidas desse produto?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Remover',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (!result.isConfirmed) {
                let sel = document.querySelector('select');
                let opt;
                try{
                    for ( var i = 0, len = sel.options.length; i < len; i++ ) {
                        opt = sel.options[i];
                        if (opt.getAttribute('selected') == 'selected') {
                            document.querySelector('div.box2 > select').append(opt);
                        }
                    }

                } catch(error) {
                    //
                }
            } else {
                document.querySelector('#apagarTodos').setAttribute('disabled','disabled');
            }
        })

    }

}
