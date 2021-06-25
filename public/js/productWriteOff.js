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

function validaStatusCategoria(codigo) {
    // let category = document.querySelectorAll(`.pedido_${codigo} > tbody > tr.p > td > div > input.product_not_found`)[0].getAttribute('value');
    // console.log(document.querySelectorAll(`.pedido_${codigo} > tbody > tr.p > td > div.row > div.demo_${codigo} > div.card`)[0].);
    let dado = null;
    document.querySelectorAll(`.pedido_${codigo} > tbody > tr.p > td > div.row > div.demo_${codigo} > div.card`).forEach(function(prod, index){
        dado = prod;
            // mensagemAlerta('danger');
    });

    if(dado == null) {
        mensagemAlerta('danger');
    }

    //console.log(document.querySelectorAll(`/*.pedido_${codigo} > tbody > tr.p > td > div > input.product_not_found*/`));
    // console.log('click', category);
    // if(category !== '') {
    //     // mensagemAlerta('danger');
    // }
}

function mensagemAlerta(classe) {
    let timerInterval
    Swal.fire({
        title: 'Atenção',
        html: 'Estoque vazio!',
        icon: 'warning',
        timer: 2000,
        timerProgressBar: true,
        didOpen: () => {
            Swal.showLoading()
            timerInterval = setInterval(() => {
                const content = Swal.getContent()
                if (content) {
                    const b = content.querySelector('b')
                    if (b) {
                        b.textContent = Swal.getTimerLeft()
                    }
                }
            }, 100)
        },
        willClose: () => {
            clearInterval(timerInterval)
        }
    }).then((result) => {
        /* Read more about handling dismissals below */
        if (result.dismiss === Swal.DismissReason.timer) {
            window.location.reload();
        }
    })
}




