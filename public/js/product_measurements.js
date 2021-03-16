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

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
            )
        } else {
            // demo1.bootstrapDualListbox('refresh');
            // log($('select[name="duallistbox_demo1[]"]').bootstrapDualListbox('getContainer'));
        }
    });

}
