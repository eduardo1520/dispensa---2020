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
                    // log(value);
                    element.insertAdjacentHTML('beforeend', `<img src="../../${value['image']}" width="150" height="150" alt=""/>`);
                });
            }
        }).catch(error => {
            log('erro:', error);
        });
}

