function abreModalFeedback(codigo) {
    if(codigo) {
        $.ajax({
            url:'feedback/'+ codigo,
            type:'get',
            dateType: 'json',
            success: function(res) {
                $("#descricao").val(res.descricao);
                $("#feedback .btn").removeClass().addClass('btn nao_selecionado');
                if(res.tipo == 'R') {
                    $("#feedback .btn").each(function(){
                        if($(this).data('id') == 'R') {
                            $(this).removeClass('btn nao_selecionado').addClass('btn btn-danger');
                        }
                    });
                    $("#prioridade_selecionada").show();
                    $("#prioridade").val(res.prioridade);
                } else {
                    $("#feedback .btn").each(function(){
                        if($(this).data('id') == 'S') {
                            $(this).removeClass('btn nao_selecionado').addClass('btn btn-success');
                        }
                    });
                    $("#prioridade_selecionada").hide();
                }
                $("#form-feedback").append('<input type="hidden" name="tipo" id="tipo" value="'+ res.tipo +'">');
                $("#form-feedback").append('<input type="hidden" id="id" value="'+ res.id +'">');
                $("#btnFeedback").text('Atualizar Feedback');
                $('#feedbackModal').modal('show');
            },
            error: function (error) {
                console.log(error);
            }
        });
    }
}

function atualizaFeedback(nome, codigo) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url:'category/'+ codigo,
        type:'put',
        dateType: 'json',
        data:{
            tipo: nome,
            id: codigo
        },
        success: function(res) {
            $('#modalFeedback').modal('hide');
            window.location.reload();
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function apagarFeedback(codigo) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url:'feedback/'+ codigo,
        type:'delete',
        dateType: 'json',
        success: function(res) {
            window.location.reload();
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function atualizaQtde(codigo, operacao)
{
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
    })
}

function produtoCombo(codigo) {
    $('.pedido').each(function (x,y) {
        if($(this).closest('[data-codigo]').data('codigo') == codigo) {
            $(this).children('div.produto').children('span').hide();
            $(".combo-produto").removeClass('d-none');
            $(".combo-produto").show();
        }
    })
}

function transformaProdutoComboSpan(pai, id, nome) {
    if($('.pedido').closest('[data-codigo]').data('codigo') == pai) {
        $('.produto-nome').attr('data-product_id',id);
        $('.produto-nome').text(nome);
        $('.produto-nome').show();
        $(".combo-produto").hide();
    }
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
            $('.produto ').removeAttr('onclick')
                          .attr('data-toggle',"modal")
                          .attr('data-target',".modalRequestProduct")
                          .attr('onclick',"abreModalRequestProduct()");
            // data-toggle="modal" data-target=".modalRequestProduct"  onclick='abreModalCategoria("");'
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

            $(".combo-produto").append(HTML);

        },
        error: function (error) {
            console.log(error);
        }
    });
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
