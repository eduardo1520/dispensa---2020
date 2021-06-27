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
    let dado = null;
    document.querySelectorAll(`.pedido_${codigo} > tbody > tr.p > td > div.row > div.demo_${codigo} > div.card`).forEach(function(prod, index){
        dado = prod;
    });

    if(dado == null) {
        mensagemAlerta('danger');
    }
}

function mensagemAlerta(classe, html='Estoque vazio!', titulo='Atenção', icon='warning') {
    let timerInterval
    Swal.fire({
        title: titulo,
        html: html,
        icon: icon,
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

function getDateHoursAtualBR() {
    const dt_atual = new Date();
    data = `${dt_atual.getDate() < 10 ? '0' + dt_atual.getDate() : dt_atual.getDate()}/${dt_atual.getMonth() < 10 ? "0" + (dt_atual.getMonth() +1) : (dt_atual.getMonth() +1)}/${dt_atual.getFullYear()} ${dt_atual.getHours()}:${dt_atual.getMinutes()}hs`.trim();
    // data = data.replace(/\s+/g, '');
    return data;
}

function baixaProduto(codigo,pedido) {
    let dados = {};
    dados.product_id = codigo;
    dados.category_id = pedido;
    document.querySelectorAll('div.accordian-body').forEach(function (produto){

        if(produto.getAttribute('id') == codigo) {
            produto.querySelectorAll('div.card > div.row > div').forEach(function(prod){
                prod.querySelectorAll('div.card-body > p.qtde > span').forEach(function(q){
                    let qtde_atual = 0;
                    let texto = q.innerHTML;
                    let qtde = parseInt(texto);
                    if(qtde > 0) {
                        qtde_atual = qtde -1;
                        texto = texto.replace(`${qtde}`, `${qtde_atual}`);
                        q.innerHTML = texto;
                        dados.qtde = qtde_atual;
                    }
                });

                prod.querySelectorAll('div.card-body > p.up_data > small').forEach(function(dt){
                    let data = getDateHoursAtualBR();
                    dt.innerHTML = data;
                });

                prod.querySelectorAll('div.card-body > p.up_dinamico > small').forEach(function(s){
                    let qtde_atual = 0;
                    let texto = s.innerHTML;
                    let qtde = parseInt(texto.substr(1,texto.indexOf("]") + 1));

                    if(qtde > 0) {
                        qtde_atual = qtde -1;
                        texto = texto.replace(`[${qtde}]`, `[${qtde_atual}]`);
                        s.innerHTML = texto;
                    }

                    if(qtde_atual === 0) {
                        prod.querySelectorAll('div.baixar').forEach(function(b){
                            b.classList.add('d-none');
                        });
                    }
                });
            });
        }

    });

    promise(`product-write-off/${dados.product_id}`, 'PUT',{product_id:dados.product_id, category_id: dados.category_id, qtde:dados.qtde})
        .then(response => {
            return response.json();
        })
        .then(product => {
            if(product != null) {
                mensagemAlerta('success', 'Produto atualizado!', 'Sucesso','success');
            }
        });

    baixaProdutoPorPedidoAll(pedido);
}

function baixaProdutoPorPedidoAll(pedido) {
    let products = [];
    document.querySelectorAll(`table.pedido_${pedido} > tbody > tr.p > td > div.row > div.accordian-body >
        div.card > div > div.card > div.row > div > div.card-body > p.qtde >
        span`).forEach(function (produto){
        products.push(parseInt(produto.innerHTML));
    });

    let qtde = products.filter(function(value){
            return value === 0;
        }).length;

    if(products.length == qtde) {
        document.querySelectorAll(`table.pedido_${pedido} > tbody > tr > td > div.remover`).forEach(function(e){
            e.classList.add('d-none')}
        );
    }
}

function baixaPedidosAll(pedido, codigo, flag) {
    Swal.fire({
        title: 'Deseja realmente dar baixa em todos os produtos dessa categoria?',
        text: "O item escolhido será apagado!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Dar baixa',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            removePedidosAll(pedido,codigo);
            Swal.fire(
                'Sucesso!',
                'A lista selecionada foi apagado.',
                'success'
            )
        }
    })
}

function removePedidosAll(pedido,codigo) {
    document.querySelectorAll(`table.pedido_${pedido} > tbody > tr.p > td > div.row > div.demo_${pedido} > div.card > div >
        div.card > div.row > div`).forEach(function(card){
            card.querySelectorAll('div.card-body > p.qtde > span').forEach(function(qt){
                qt.innerHTML='0';
            });

            card.querySelectorAll('div.card-body > p.up_data > small').forEach(function(dt){
                data = getDateHoursAtualBR();
                dt.innerHTML = data;
            });

            card.querySelectorAll('div.card-body > p.up_dinamico > small').forEach(function(s){
                let texto = s.innerHTML;
                let qtde = parseInt(texto.substr(1,texto.indexOf("]") + 1));
                let qtde_atual = 0;

                if(qtde > 0) {
                    texto = texto.replace(`[${qtde}]`, `[${qtde_atual}]`);
                    s.innerHTML = texto;
                }

                if(qtde_atual === 0) {
                    card.querySelectorAll('div.baixar').forEach(function(b){
                        b.classList.add('d-none');
                    });
                }
            });
    });

    promise(`product-write-off/${codigo}`, 'PUT',{category_id: pedido})
        .then(response => {
            return response.json();
        })
        .then(product => {
            if(product != null) {
                mensagemAlerta('success', 'Produtos atualizados!', 'Sucesso','success');
            }
    });

    document.querySelectorAll(`table.pedido_${pedido} > tbody > tr > td > div.remover`).forEach(function(e){
        e.classList.add('d-none')}
    );
}





