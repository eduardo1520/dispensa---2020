function mountNotification(dado) {
    /* Extrai da Base64 e converte para JSON.*/
    let note = JSON.parse(atob(dado));

    document.querySelectorAll('form#form-codListModal > *').forEach(function(card){
        card.querySelector('img').setAttribute('src',note.image);
        card.querySelector('h5').innerHTML = note.produto;
        card.querySelector('p.codigo').innerHTML = "Código: " + note.produto_codigo;
        card.querySelector('p.qtde').innerHTML = "Qtde: " + note.qtde_old + "/" + note.qtde;
        card.querySelector('p.up_dinamico').innerHTML = "[" + note.qtde + "] " + card.querySelector('h5').innerHTML;
        card.querySelector('p.categoria').innerHTML = "Categoria: " + note.tipo;
        card.querySelector('p.up_data').innerHTML = "Data: " + note.created_at;
        card.querySelector('textarea.obs').innerHTML = "Obs: O usuário(a) " + note.name + " efetuou a baixa do produto!";
    });

}

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


