
@extends('layouts.admin')
@section('main-content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{{asset('dropzone-5.7.0/dist/min/dropzone.min.css')}}">
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <link href="{{ asset('vendor/harvesthq/chosen/chosen.min.css') }}" rel="stylesheet">

    <style>
        .nao_selecionado {
            color: #fff;
            background-color: #f1f1f1;
            border-color: #c7ccda;
        }
        .btn-upload{
            border-radius:0;
            background-color:#29add0;
            padding-left:0;
            border:0 none;
        }
        .btn-upload > span{
            padding:6px 12px;
            margin-right:12px;
            background-color:#098ab1;
        }
        .btn-upload:hover,
        .btn-upload:active,
        .btn-upload:focus{
            background:#098ab1;
        }
        .btn-upload:hover > span,
        .btn-upload:active > span,
        .btn-upload:focus > span{
            background:#098ab1;
        }

        .slow .toggle-group { transition: left 0.7s; -webkit-transition: left 0.7s; }

        .chosen-container-multi .chosen-choices {
            border: 1px solid #cbd5e0;
            height: 40px !important;
            cursor: text;
            padding-left: 15px;
            border-bottom: 1px solid #ddd;
            text-indent: 0;
            border-radius: .35rem;
            padding-top: 6px;
        }
    </style>
    @if ($errors->any())
        <div class="alert alert-danger border-left-danger" role="alert">
            <ul class="pl-4 my-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row">
        <div class="col-lg-5 order-lg-1">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $titulo }}</h6>
                </div>
                <div class="card-body">
                    @php
                        if(isset($produto)) {
                            $active = empty($produto->id) ? route('product.store') : route('product.update',$produto->id);
                        } else {
                            $active = route('product.store');
                        }
                    @endphp
                    <form method="POST" action="{{ $active }}" autocomplete="off"  id="frm-produto" onchange="validaCampos('frm-produto','btn-cadastrar',['input']);">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        @if(isset($produto) && !empty($produto->id))
                            <input type="hidden" name="_method" value="PUT">
                        @endif

                        <h6 class="heading-small text-muted mb-4">Informações do produto</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <label class="form-control-label" for="name">Nome<span class="small text-danger">*</span></label>
                                        <input type="text" id="name" class="form-control" name="name" placeholder="Nome" value="{{ isset($produto) && !empty($produto->name) ? $produto->name : old('name') }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <div class="form-group">
                                        <label class="form-control-label" for="brand_id">Marca</label>
                                        <select data-placeholder="Selecione uma marca" class="chosen-select-brand" multiple tabindex="3" name="brand_id" id="brand_id" value="">
                                            @if(!empty($comboBrandSql))
                                                @foreach($comboBrandSql as $value => $marca)
                                                    <option value="{{$value}}" {{ !empty($pesquisa['brand_id']) && in_array($value,$pesquisa['brand_id'])  ? 'selected' : '' }}>{{ $marca }}</option>
                                                @endforeach
                                            @endif
                                            <option value="999">Outros</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <label for="description">Descrição</label>
                                    <textarea name="description" id="description" cols="20" rows="5" class="form-control">{{ isset($produto) && !empty($produto->description) ? $produto->description : old('description') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div id="alert"></div>
                    <div class="card-body">
                        <input type="checkbox"  onchange="mostraUpload();" id="toggle" checked data-toggle="toggle" data-off="<i class='fas fa-file-upload'></i> Com imagem" data-on="<i class='fas fa-ban'></i> Sem imagem"  data-onstyle="danger" data-offstyle="success" data-style="slow" data-width="150" data-height="20" >
                    </div>
                    <div class="row" id="upload-produto" style="display: none">
                        <div class="col-lg-12">
                            <div class='content'>
                                <h6 class="heading-small text-muted mb-4 mt-lg-5">Imagem do produto</h6>
                                <div class="dropzone" id="dropzoneFileUpload"></div>
                                <div class="col-lg-4 mt-2 p-0">
                                    <a href="javascript:void(0);" onclick="event.preventDefault();" title="" class="btn btn-primary btn-upload" id="uploadPhoto">
                                        <span class="icon"><i class="fas fa-file-upload"></i></span> Upload
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pl-lg-3">
                        <div class="row">
                            <div class="col text-center">
                                <a href="{{ route('product.index') }}" class="btn btn-danger" onclick="removerProduto()">Cancelar</a>
                                @php
                                    $ativo = isset($produto) && !empty($produto->id) ? '': 'disabled';
                                    $titulo = isset($produto) && $produto->id ? "Atualizar" : "Cadastrar";
                                @endphp
                                    <button type="submit" form="frm-produto" class="btn btn-primary" id="btn-cadastrar" {{ $ativo }}>{{ $titulo }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="{{asset('dropzone-5.7.0/dist/min/dropzone.min.js')}}" type="text/javascript"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="crossorigin="anonymous"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="{{ asset('vendor/harvesthq/chosen/chosen.jquery.min.js') }}"></script>
<script src="{{ asset('js/default.js') }}"></script>

<script>

    function mostraUpload() {
        $("#upload-produto").toggle();
    }

    function removerProduto(){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: "{{route('prod_cancelados')}}",
            sucess: function(data){
                console.log('success: ' + data);
            }
        });
    }

    Dropzone.autoDiscover = false;

    $(document).ready(function(){

        $("#admin .btn").on('click', function(){
            $("#admin .btn").each(function(){
                $(this).removeClass().addClass('btn nao_selecionado');
            });
            $(this).removeClass('btn nao_selecionado').addClass('btn btn-primary');
            $("#tipo").val($(this).val());
        });

        var myDropzone = new Dropzone("div#dropzoneFileUpload", {
            url: "{{route('fileupload')}}",
            init: function() {
                this.on("sending", function(file, xhr, formData){
                    formData.append("request", "1");
                    formData.append("name", $('#name').val());
                });
            },
            maxFilesize: 2, // MB
            maxFiles: 1,
            addRemoveLinks: true,
            autoProcessQueue:false,
            params: {
                _token: "{{csrf_token()}}"
            },
        });

        myDropzone.on("success", function(file,resp){
            if(resp=="success"){
                $("#alert").append('<div class="alert alert-'+resp+' alert-block">\n' +
                '<button type="button" class="close" data-dismiss="alert">×</button><strong>Produto carregado com sucesso!</strong></div>');
            } else {
                alert("Erro ao carregar a imagem!");
                $("#alert").append('<div class="alert alert-danger alert-block">\n' +
                    '<button type="button" class="close" data-dismiss="alert">×</button><strong>Erro ao carregar o produto</strong></div>');
            }
            setTimeout(() => {
                $("#alert").empty();
            }, 2000);
        });

        jQuery("#uploadPhoto").click(function(){
            myDropzone.processQueue();
        });

        $("#btn-upload").click(function(){
            if($(this).val()) {
                $("#upload-produto").show();
            } else {
                $("#upload-produto").hide();
                $(".dz-preview").remove();
            }
        })

        $("#btn-cadastrar").click(function(){
           $('form').submit();
        });

    });
</script>

<script>
    let jQuery = $.noConflict();
    jQuery(function() {
        jQuery('.chosen-select-brand').chosen({
            width: '100%',
            no_results_text: "Não encontramos está marca!",
            max_selected_options: 1
        });
        jQuery('.chosen-select-deselect').chosen({ allow_single_deselect: true });
    });
</script>

