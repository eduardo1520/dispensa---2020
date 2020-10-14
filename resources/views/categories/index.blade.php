@extends('layouts.admin')
@section('main-content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <div class="row">
        <div class="col-lg-5 order-lg-1">
            <div class="card shadow mb-4">
                <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Listagens de Categorias</h6></div>
                <div class="card-body">
                    <a href="#" class="btn  btn-success btn-icon-split btn-sm" data-toggle="modal" data-target=".modalCategoria"  onclick='abreModalCategoria("");'>
                        <span class="icon text-white-50"><i class="fa fa-cubes" aria-hidden="true"></i></span>
                        <span class="text">Novo</span>
                    </a>
                    <div class="row " align="center" id="tabela">
                        <div class="col-8 col-lg-12 my-3 border " id="filho">
                            <div class="row font-weight-bold">
                                <div class="col-4 col-sm-4 col-md-4 col-lg-4 border">#</div>
                                <div class="col-4 col-sm-4 col-md-4 col-lg-4 border">Tipo</div>
                                <div class="col-4 col-sm-4 col-md-4 col-lg-4 border">Ação</div>
                            </div>
                            @forelse($categorias as $idx => $categoria)

                                <div class="row" style="{{ $idx % 2 == 1 ? 'background-color:e9e9e9' : '' }}">
                                    <div class="col-4 col-sm-4 col-md-4 col-lg-4 border" style="padding-top: 10px;padding-bottom: 5px;">
                                        {{$categoria->id}}
                                    </div>
                                    <div class="col-4 col-sm-4 col-md-4 col-lg-4 border" style="padding-top: 10px;padding-bottom: 5px;">
                                        {{$categoria->tipo}}
                                    </div>
                                    <div class="col-4 col-sm-4 col-md-4 col-lg-4 border" style="padding-top: 10px;padding-bottom: 5px;">
                                        <a href="#" class="btn btn-info btn-circle btn-sm categoria" title="Atualizar Categoria" data-toggle="modal" data-target=".modalCategoria"  onclick='abreModalCategoria({{ $categoria->id }});'>
                                            <i class="fas fa-info-circle"></i>
                                        </a>
                                        <a href="#" class="btn btn-danger btn-circle btn-sm excluir" title="Excluír Categoria" data-id="{{ $categoria->id }}"><i class="fas fa-trash"></i></a>
                                    </div>
                                </div>
                            @empty
                                <p class="mt-lg-3">Sem categorias</p>
                            @endforelse
                        </div>
                    </div>
{{--                    <table class="mt-lg-3 table table-striped table-bordered table-hover">--}}
{{--                        <thead>--}}
{{--                        <tr align="center">--}}
{{--                            <th>#</th>--}}
{{--                            <th>Tipo</th>--}}
{{--                            <th>Ação</th>--}}
{{--                        </tr>--}}
{{--                        </thead>--}}
{{--                        <tbody>--}}
{{--                        @forelse($categorias as $categoria)--}}
{{--                            <tr align="center">--}}
{{--                                <th scope="row">{{$categoria->id}}</th>--}}
{{--                                <td align="center">{{$categoria->tipo}}</td>--}}
{{--                                <td align="center">--}}
{{--                                    <a href="#" class="btn btn-info btn-circle btn-sm categoria" title="Atualizar Categoria" data-toggle="modal" data-target=".modalCategoria"  onclick='abreModalCategoria({{ $categoria->id }});'>--}}
{{--                                        <i class="fas fa-info-circle"></i>--}}
{{--                                    </a>--}}
{{--                                    <a href="#" class="btn btn-danger btn-circle btn-sm excluir" title="Excluír Categoria" data-id="{{ $categoria->id }}"><i class="fas fa-trash"></i></a>--}}
{{--                                </td>--}}
{{--                            </tr>--}}
{{--                        @empty--}}
{{--                            <p class="mt-lg-3">Sem categorias</p>--}}
{{--                        @endforelse--}}
{{--                        </tbody>--}}
{{--                    </table>--}}
                </div>
            </div>
        </div>
    </div>


@endsection

<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>

    function abreModalCategoria(codigo) {
        if(codigo) {
            $("#titulo-categoria").text('Atualizar Categoria');
            $("#btnCategoria").empty().text('Atualizar');
            $.ajax({
                url: `category/${codigo}`,
                type: 'get',
                dateType: 'json',
                success: function(res) {
                    $("#id").val(res.id);
                    $("#tipo").val(res.tipo);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        } else {
            $("#btnCategoria").empty().text('Cadastrar');
            $("#btnCategoria").attr('disabled','disabled');
            $("#titulo-categoria").empty().text('Cadastrar Categoria');
        }
    }

    function atualizaCategoria(nome, codigo) {
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
                $('#modalCategoria').modal('hide');
                window.location.reload();
            },
            error: function (error) {
                console.log(error);
            }
        });

    }

    function validaCategoriaTipo() {

        let tipo = $("#tipo").val();

        if(tipo == '') {
            alert('Campo obrigatório');
            $("#tipo").focus();
        } else {
            let codigo = $("#id").val();
            atualizaCategoria(tipo, codigo);
        }
    }

    function apagarCatalogo(codigo) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:'category/'+ codigo,
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
        }
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
                    apagarCatalogo(codigo);
                    Swal.fire(
                        'Sucesso!',
                        'O item selecionado foi apagado.',
                        'success'
                    )
                }
            })
        });

        $("#admin .btn").on('click', function(){

        });
    });

</script>
