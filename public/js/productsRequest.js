
function atualizaQtde(codigo, operacao)
{
    $(".load").addClass("loading");
    $('.pedido').each(function (x,y) {
        if($(this).closest('[data-codigo]').data('codigo') == codigo) {
            let qtde = parseInt($(this).children('div.qtde').text());
            if(operacao == '-' && qtde == 0) {
                alert('Não é permitido quantidade negativa!');
            } else if(operacao == '+'){
                qtde++;
                $(this).children('div.qtde').empty().text(qtde);
            } else {
                qtde--;
                $(this).children('div.qtde').empty().text(qtde);
            }
        }
    });
    $("body").removeClass("loading");
}

function getCombo(pai, codigo, span, classe, combo) {
    $(`.${pai}`).each(function () {
        if($(this).closest('[data-codigo]').data('codigo') == codigo) {
            $(this).children('div.classe').children('span').hide();
            $(`.${span}`).hide();
            $(`.${combo}`).removeClass('d-none').show();
        }
    });
}

function transformaComboSpan(classe, pai, id, nome, campo, combo) {
    if($(`.${classe}`).closest('[data-codigo]').data('codigo') == pai) {
        $(`.${campo}`).remove();
        $(`.${combo}`).closest('div').append(`<span data-id="${id}" class="${campo}">${nome}</span>`);
        $(`.${combo}`).hide();
    }
}

function ativaCombo(classe, codigo, campo, combo) {
    $(`.${classe}`).find(`.${campo}`).each(function (x,campo) {
        if($(this).closest('[data-codigo]').data('codigo') == codigo) {
            if($(campo).data('id') > 0) {
                $(campo).remove();
            }
            $(`.${combo}`).show();
        }
    })
}

function detectar_mobile() {
    var check = false; //wrapper no check
    (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4)))check = true})(navigator.userAgent||navigator.vendor||window.opera);
    if(check == true) {
        $("#page-top").addClass();
        $("#accordionSidebar").removeClass('accordion').addClass('toggled');
        if($(window).width() <= 320) {
            $("#filho").removeClass().addClass('col-12 border mt-3');
            $("#tabela").find('div.row').children('div').each(function () {
                $(this).css('padding-left','5px');
                $(this).css('padding-right','5px');
            });
        }

        if($(window).width() <= 568) {
            $('.user').hide();
            $('.detalhe').hide();
            $('.produto').removeAttr('onclick')
                          .attr('data-toggle',"modal")
                          .attr('data-target',".modalRequestProduct")
                          .attr('onclick',"abreModalRequestProduct()");
            $(".gj-datepicker").hide();

            let hoje = new Date();

            $(".data").attr('data-toggle',"modal").attr('data-target',".modalData");
            $(".data").append(`<span class="selecionado">${hoje.getDate()}/${hoje.getMonth() + 1}/${hoje.getFullYear()}</span>`);

        }

        if($(window).width() > 568) {
            $('.user').show();
            $('.detalhe').remove();
        }
    }
}

function abreModalRequestProduct() {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: `product/productAjax`,
        type: 'post',
        dateType: 'json',
        success: function(res) {
            let HTML = "";
            $.each(res, function(codigo, valor) {
               HTML += `<option value="${valor['id']}">${valor['name']}</option>`;
            });

            $(".combo-prod").append(HTML);
            comboMeasure();
            comboBrand();
            comboBrandCategory();
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function comboMeasure() {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: `measure/measureAjax`,
        type: 'post',
        dateType: 'json',
        success: function(res) {
            let HTML = "";
            $.each(res, function(codigo, valor) {
               HTML += `<option value="${valor['id']}">${valor['nome']} - (${valor['sigla']})</option>`;
            });

            $(".combo-measure").append(HTML);

        },
        error: function (error) {
            console.log(error);
        }
    });
}

function comboBrand() {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: `brand/brandAjax`,
        type: 'post',
        dateType: 'json',
        success: function(res) {
            let HTML = "";
            $.each(res, function(codigo, valor) {
               HTML += `<option value="${valor['id']}">${valor['name']}</option>`;
            });

            $(".combo-brand").append(HTML);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function comboBrandCategory() {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: `category/categoryAjax`,
        type: 'post',
        dateType: 'json',
        success: function(res) {
            let HTML = "";
            $.each(res, function(codigo, valor) {
               HTML += `<option value="${valor['id']}">${valor['tipo']}</option>`;
            });

            $(".combo-category").append(HTML);

        },
        error: function (error) {
            console.log(error);
        }
    });
}

function getProductImage(id, name) {

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: `product/productImageAjax`,
        type: 'post',
        dateType: 'json',
        data:{
          id: id,
          name: name
        },
        success: function(res) {
            $(".imagem").empty().append(`<img src="${res[0].image}" alt="${res[0].description}" data-id="${res[0].id}" width="100px;" height="75px;">`);
            $(".imagem-produto").removeClass('d-none');
            $(".imagem-nome").text(res[0].name);
            $(".imagem-descricao").text(res[0].description);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function getCategory(classe, pai,produto,campo) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: `product/productCategoryAjax`,
        type: 'post',
        dateType: 'json',
        data:{
          id: produto
        },
        success: function(res) {
            if($(`.${classe}`).closest('[data-codigo]').data('codigo') == pai) {
                $(`.${campo}`).closest('div').empty().append(`<span class="${campo}">${res}</span>`);
            }
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function setData()
{
    $(".date").val($("#datetimepicker1").val()).hide();
    $(".selecionado").append($("#datetimepicker1").val());
    $(".gj-datepicker").hide();
    $('.modalData').hide();
    $('.modalData').modal('hide');
}

function habilitaData() {
    $(".input-group-append").hide();
    $(".selecionado").empty().val($("#datetimepicker1").val());
    $(".gj-datepicker").show();
}

$(document).ready(function(){
    detectar_mobile();
    $(".excluir").click(function(){
        Swal.fire({
            title: 'Deseja realmente excluir?',
            text: "O item escolhido será apagado!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Apagar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                let codigo = $(this).data('id');
                apagarFeedback(codigo);
                Swal.fire(
                    'Sucesso!',
                    'O item selecionado foi apagado.',
                    'success'
                )
            }
        })
    });
});
