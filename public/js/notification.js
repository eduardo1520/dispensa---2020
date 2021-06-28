function mountNotification(dado) {
    let note = JSON.parse(atob(dado));
    console.log(note);

    document.querySelectorAll('div > form#form-codListModal > div > div > div > div.card > div.row').forEach(function(card){
        card.querySelectorAll('div.col-md-4 > img').forEach(function (img){
           img.innerHTML = '';
           img.setAttribute('src',note.image);
        });

        card.querySelectorAll('div.col-md-8 > div.m').forEach(function (prod){
           prod.querySelector('h5').innerHTML = note.produto;
           prod.querySelector('p.codigo').innerHTML = "Código: " + note.produto_codigo;
           prod.querySelector('p.qtde').innerHTML = "Qtde: " + note.qtde_old + "/" + note.qtde;
           prod.querySelector('p.up_dinamico').innerHTML = "[" + note.qtde + "] " + prod.querySelector('h5').innerHTML;
           prod.querySelector('p.categoria').innerHTML = "Categoria: " + note.tipo;
           prod.querySelector('p.up_data').innerHTML = "Data: " + note.created_at;
           prod.querySelector('textarea.obs').innerHTML = "Obs: O usuário(a) " + note.name + " efetuou a baixa do produto!";
        });

    });

}
