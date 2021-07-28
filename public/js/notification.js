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

function visualizar(notification) {
    promise('notification/viewNotificationsAjax','post',{'id':notification})
        .then(response => {
            return response.json();
        })
        .then(notification => {
            window.location.reload();
        });
}

function mountNotification(dado) {
    /* Extrai da Base64 e converte para JSON.*/
    let note = JSON.parse(atob(dado));

    document.querySelector('[data-img]').setAttribute('src',note.image);
    document.querySelector('[data-title]').innerHTML = note.produto;
    document.querySelector('[data-codigo] > span').innerHTML = "Código: " + note.produto_codigo;
    document.querySelector('[data-qtde]').innerHTML = "Qtde: " + note.qtde_old + "/" + note.qtde;
    document.querySelector('[data-qtde-titulo]').innerHTML = "[" + note.qtde + "] " + note.produto;
    document.querySelector('[data-categoria]').innerHTML ="Categoria: " + note.tipo;
    document.querySelector('[data-created_at]').innerHTML = "Data: " + note.created_at;
    document.querySelector('[data-obs]').innerHTML = "Obs: O usuário(a) " + note.name + " efetuou a baixa do produto!";
    document.querySelector('[data-notificationOK]').setAttribute('onclick',`visualizar(${note.id})`);
}



