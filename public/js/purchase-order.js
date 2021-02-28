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

function getProductIcon(produto) {
   let icon = document.querySelector('.icon');
}

function removeProdutoLista(id) {
    document.querySelectorAll(`.pedido > tbody > tr`).forEach(function(v){
        if(v.getAttribute('id') == id) {
            v.remove();
        }
    });

    if(document.querySelectorAll(`.pedido > tbody > tr`).length == 0) {
        document.querySelector('#enviar_pedido').setAttribute('style','display:none');
    }
}

function getProductOne(codigo) {
    let encontrou = false;
    document.querySelectorAll(`.pedido > tbody > tr`).forEach(function (p) {

        if(p.getAttribute('id') == codigo) {
            encontrou = true;
            // log(p.querySelector('td'));
            alert(`O produto ${p.querySelector('td').innerHTML.toLowerCase()} já foi adicionado na lista!`);
            return;
        }
    });

    if (encontrou === false) {
        promise(`product/getProductOneAjax`, 'post', {'id': codigo})
            .then(response => {
                return response.json();
            })
            .then(produto => {
                produto = produto[0];
                let pedido = `<tr align="center" id='${produto.id}'>
                                <th scope="row" >
                                    <select name="qtde" class="qtde form-control">
                                        ${Array.from({length:12}, (_,i) => '<option value=' + i + '>' + (i+1) + '</option>')}
                                    </select>
                                </th>
                                <td align="center">${produto.name}</td>
                                <td align="center">${produto.description}</td>
                                <td align="center">${produto.tipo}</td>
                                <td>
                                    <a href="#" class="btn btn-danger btn-circle btn-sm excluir" title="Excluír Produto" data-id="{{ $produto->id }}" onclick="removeProdutoLista(${produto.id})"><i class="fas fa-trash"></i></a>
                                </td>
                             </tr>`;

            document.querySelector('.pedido > tbody').insertAdjacentHTML('beforeend', pedido);
            document.querySelector('#enviar_pedido').setAttribute('style','display:block');

        });
    }

}

var iconSelect;

window.onload = function(){
    promise(`puchase-order/productImageAjax`,'post')
        .then(response => {
            return response.json();
        })
        .then(produtos => {
            var icons = [];
            let horizontal = Math.ceil(produtos.length / 10);
            iconSelect = new IconSelect("my-icon-select",
                {'selectedIconWidth':96,
                    'selectedIconHeight':96,
                    'selectedBoxPadding':5,
                    'iconsWidth':96,
                    'iconsHeight':96,
                    'boxIconSpace':6,
                    'vectoralIconNumber':10,
                    'horizontalIconNumber':horizontal});

            icons.push({'iconFilePath': '../img/compras-shopping.png', 'iconValue':0});

            produtos.forEach(function(p){
                icons.push({'iconFilePath': p.image, 'iconValue':p.id});
            });

            iconSelect.refresh(icons);
        });

};

// $(function(){
//     $(document).ready(function(){
//
//     });
// });


