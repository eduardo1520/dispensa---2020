<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Laravel SB Admin 2">
    <meta name="author" content="Eduardo Oliveira">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <!-- Favicon -->
    <link href="{{ asset('img/favicon.png') }}" rel="icon" type="image/png">

    <style>
        .nao_selecionado {
            color: #fff;
            background-color: #f1f1f1;
            border-color: #c7ccda;
        }

        .gj-picker {
            margin-top:-50px;
            margin-left: 80px;
            margin-bottom:0px;
            position:absolute;
            z-index:1000;
        }

        .modal-body {
            padding-top: 0px;
            padding-bottom: 6px;
        }

        .modal-footer {
            padding-top: 0px;
            padding-bottom: 0px;
        }

        .modal-header {
            padding-top: 10px;
            padding-bottom: 0px;
        }

    </style>
</head>
<body id="page-top">
<!-- Page Wrapper -->
<div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
        </a>
        <!-- Divider -->
        <hr class="sidebar-divider my-0">
        <!-- Nav Item - Dashboard -->
        <li class="nav-item {{ Nav::isRoute('home') }}">
            <a class="nav-link" href="{{ route('home') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>{{ __('Dashboard') }}</span></a>
        </li>
        @if(Auth::user()->admin == 'S')
            <hr class="sidebar-divider my-0">
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-desktop"></i>
                    <span>Cadastros do Sistema</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Páginas:</h6>
                        <a class="collapse-item" href="{{ route('category.index') }}">Categorias</a>
                        <a class="collapse-item" href="{{ route('measure.index') }}">Medidas</a>
                        <a class="collapse-item" href="{{ route('brand.index') }}">Marcas</a>
                        <a class="collapse-item" href="{{ route('product.index') }}">Produtos</a>
                        <a class="collapse-item" href="{{ route('user.index') }}">Usuários</a>

                    </div>
                </div>
            </li>
        @endif
        <!-- Divider -->
        <hr class="sidebar-divider">
        <li class="nav-item {{ Nav::isRoute('puchase-order.index') }}">
            <a class="nav-link" href="{{ route('puchase-order.index') }}">
                <i class="fas fa-file-upload"></i>
                <span>{{ __('Pedido de Compras') }}</span>
            </a>
        </li>
        <li class="nav-item {{ Nav::isRoute('profile.index') }}">
            <a class="nav-link" href="{{ route('profile.index') }}">
                <i class="fas fa-file-download"></i>
                <span>{{ __('Baixa de Produtos') }}</span>
            </a>
        </li>
        <li class="nav-item {{ Nav::isRoute('product-request.index') }}">
            <a class="nav-link" href="{{ route('product-request.index') }}">
                <i class="fas fa-fw fa-user"></i>
                <span>{{ __('Solicitação de Produtos') }}</span>
            </a>
        </li>
        @if(Auth::user()->admin == 'S')
            <hr class="sidebar-divider">
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#relatorio" aria-expanded="true" aria-controls="relatorio">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Relatórios do Sistema</span>
                </a>
                <div id="relatorio" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Páginas:</h6>
                        <a class="collapse-item" href="categorias.html">Categorias</a>
                        <a class="collapse-item" href="produtos.html">Produtos</a>
                        <a class="collapse-item" href="{{ route('feedback.index') }}">Feedback</a>
                        <a class="collapse-item" href="{{ route('relatorio') }}">Usuários</a>
                        <a class="collapse-item" href="logs.html">Logs</a>
                        <a class="collapse-item" href="erros.html">Erros</a>
                    </div>
                </div>
            </li>
        @endif
        <hr class="sidebar-divider">
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#feedback" aria-expanded="true" aria-controls="feedback">
                <i class="fas fa-bullhorn"></i>
                <span>FeedBack</span>
            </a>
            <div id="feedback" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Informações:</h6>
                    <a class="collapse-item" href="#" data-toggle="modal" data-target="#feedbackModal" onclick="atualizaTitulo('Reclamações');">Reclamações</a>
                    <a class="collapse-item" href="#" data-toggle="modal" data-target="#feedbackModal" onclick="atualizaTitulo('Sugestões');">Sugestões</a>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#settings" aria-expanded="true" aria-controls="settings">
                <i class="fas fa-cogs"></i>
                <span>Configurações</span>
            </a>
            <div id="settings" class="collapse {{ Nav::isRoute('profile.index') }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Informações:</h6>
                    <a class="collapse-item" href="{{ route('profile.index') }}">Perfil</a>
                    <a class="collapse-item" href="{{ route('about') }}">Sobre</a>
                </div>
            </div>
        </li>
        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">
        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
    </ul>
    <!-- End of Sidebar -->
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>
                <!-- Topbar Search -->
                <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                    <li class="nav-item dropdown no-arrow d-sm-none">
                        <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-search fa-fw"></i>
                        </a>
                        <!-- Dropdown - Messages -->
                        <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                            <form class="form-inline mr-auto w-100 navbar-search">
                                <div class="input-group">
                                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button">
                                            <i class="fas fa-search fa-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </li>
                    <!-- Nav Item - Alerts -->
                    <li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bell fa-fw"></i>
                            <!-- Counter - Alerts -->
                            <span class="badge badge-danger badge-counter">3+</span>
                        </a>
                        <!-- Dropdown - Alerts -->
                        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                            <h6 class="dropdown-header">
                                Alerts Center
                            </h6>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="mr-3">
                                    <div class="icon-circle bg-primary">
                                        <i class="fas fa-file-alt text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">December 12, 2019</div>
                                    <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                </div>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="mr-3">
                                    <div class="icon-circle bg-success">
                                        <i class="fas fa-donate text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">December 7, 2019</div>
                                    $290.29 has been deposited into your account!
                                </div>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="mr-3">
                                    <div class="icon-circle bg-warning">
                                        <i class="fas fa-exclamation-triangle text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">December 2, 2019</div>
                                    Spending Alert: We've noticed unusually high spending for your account.
                                </div>
                            </a>
                            <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                        </div>
                    </li>
                    <!-- Nav Item - Messages -->
                    <li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-envelope fa-fw"></i>
                            <!-- Counter - Messages -->
                            <span class="badge badge-danger badge-counter">7</span>
                        </a>
                        <!-- Dropdown - Messages -->
                        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                            <h6 class="dropdown-header">
                                Message Center
                            </h6>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="dropdown-list-image mr-3">
{{--                                    <img class="rounded-circle" src="https://source.unsplash.com/fn_BT9fwg_E/60x60" alt="">--}}
                                    <div class="status-indicator bg-success"></div>
                                </div>
                                <div class="font-weight-bold">
                                    <div class="text-truncate">Hi there! I am wondering if you can help me with a problem I've been having.</div>
                                    <div class="small text-gray-500">Emily Fowler · 58m</div>
                                </div>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="dropdown-list-image mr-3">
                                    <img class="rounded-circle" src="https://source.unsplash.com/AU4VPcFN4LE/60x60" alt="">
                                    <div class="status-indicator"></div>
                                </div>
                                <div>
                                    <div class="text-truncate">I have the photos that you ordered last month, how would you like them sent to you?</div>
                                    <div class="small text-gray-500">Jae Chun · 1d</div>
                                </div>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="dropdown-list-image mr-3">
{{--                                    <img class="rounded-circle" src="https://source.unsplash.com/CS2uCrpNzJY/60x60" alt="">--}}
                                    <div class="status-indicator bg-warning"></div>
                                </div>
                                <div>
                                    <div class="text-truncate">Last month's report looks great, I am very happy with the progress so far, keep up the good work!</div>
                                    <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                                </div>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="dropdown-list-image mr-3">
{{--                                    <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60" alt="">--}}
                                    <div class="status-indicator bg-success"></div>
                                </div>
                                <div>
                                    <div class="text-truncate">Am I a good boy? The reason I ask is because someone told me that people say this to all dogs, even if they aren't good...</div>
                                    <div class="small text-gray-500">Chicken the Dog · 2w</div>
                                </div>
                            </a>
                            <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                        </div>
                    </li>
                    <div class="topbar-divider d-none d-sm-block"></div>
                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                            <figure class="img-profile rounded-circle avatar font-weight-bold" data-initial="{{ Auth::user()->name[0] }}"></figure>
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="{{ route('profile.index') }}">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                {{ __('Perfil') }}
                            </a>
                            <a class="dropdown-item" href="javascript:void(0)">
                                <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                {{ __('Settings') }}
                            </a>
                            <a class="dropdown-item" href="javascript:void(0)">
                                <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                {{ __('Activity Log') }}
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                {{ __('Logout') }}
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
            <!-- End of Topbar -->
            <!-- Begin Page Content -->
            <div class="container-fluid">
                @include('flash-message')
                @yield('main-content')
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->
        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; Eduardo Oliveira 2020</span>
                </div>
            </div>
        </footer>
        <!-- End of Footer -->
    </div>
    <!-- End of Content Wrapper -->
</div>
<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>
<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Ready to Leave?') }}</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-link" type="button" data-dismiss="modal">{{ __('Cancel') }}</button>
                <a class="btn btn-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tituloFeedback"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-feedback" onchange="validaCampos('form-feedback','btnFeedback',['select','textarea']);">
                    <input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}">

                    <div class="row">
                        <div class="col-lg-6">
                            <div>
                                <label class="form-control-label" for="feedback">Tipo:</label>
                            </div>

                            <div id="feedback" class="btn-group" role="group" aria-label="Tipo">
                                <button type="button" data-id="R" class="btn {{(empty(old('tipo')) || old('tipo') == 'R') ? 'btn-danger' : 'nao_selecionado'}}" value="R">Reclamação</button>
                                <button type="button" data-id="S" class="btn {{(old('tipo') == 'S') ? 'btn-success' : 'nao_selecionado'}}" value="S">Sugestão</button>
                            </div>
                        </div>
                        <div class="col-lg-6" id="prioridade_selecionada">
                            <div>
                                <label class="form-control-label" for="admin">Prioridade:<span class="small text-danger">*</span></label>
                            </div>
                            <select name="prioridade" id="prioridade" class="form-control" required>
                                <option value="">Selecione:</option>
                                <option value="A">Alta</option>
                                <option value="B">Baixa</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Descrição:<span class="small text-danger">*</span></label>
                        <textarea class="form-control" name="descricao" id="descricao" required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"  onclick="cancelar()">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="salvarFeedback()" id="btnFeedback" disabled>Cadastrar Feedback</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="medidaModal" tabindex="-1" aria-labelledby="medidaModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo-medida">Cadastro de Unidade de Medidas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-medida" onchange="validaCampos('form-medida','btnMedida',['input']);">
                    <div class="row">
                        <div class="col-lg-8">
                            <div>
                                <label class="form-control-label" for="nome">Nome:<span class="small text-danger">*</span></label>
                                <input type="text" class="form-control" name="nome" id="nome" required>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div>
                                <label class="form-control-label" for="sigla">Sigla:<span class="small text-danger">*</span></label>
                                <input type="text" class="form-control" name="sigla" id="sigla" required>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"  onclick="cancelar()">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="salvarMedida()" id="btnMedida" disabled>Cadastrar Medida</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modalCategoria" tabindex="-1" aria-labelledby="modalCategoria" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo-categoria">Atualizar Categoria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-categoria" onchange="validaCampos('form-categoria','btnCategoria',['input']);">
                    <input type="hidden" id="id">
                    <div class="form-group">
                        <label for="tipo" class="col-form-label">Tipo:<span class="small text-danger">*</span></label>
                        <input type="text" class="form-control" id="tipo" name="tipo" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="cancelar();">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnCategoria" onclick="salvarCategoria()">Cadastrar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade modalMarca" tabindex="-1" aria-labelledby="modalMarca" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo-marca">Cadastrar Marca</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-marca" onchange="validaCampos('form-marca','btnMarca',['input']);">
                    <div class="form-group">
                        <label for="name" class="col-form-label">Nome:<span class="small text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="cancelar();">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnMarca" onclick="salvarMarca()">Cadastrar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade modalRequestProduct" tabindex="-1" aria-labelledby="modalRequestProduct" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo-produto">Detalhe do Produto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row " align="center" id="tabela">
                    <div class="col-12 col-lg-12 my-3 border " id="filho">
                        <div class="row font-weight-bold">
                            <div class="col-3 col-sm-2 col-md-2 col-lg-2 border cabecalho">Produto</div>
                            <div class="col-2 col-sm-2 col-md-2 col-lg-2 border cabecalho">Medida</div>
                            <div class="col-3 col-sm-2 col-md-2 col-lg-2 border cabecalho">Marca</div>
                            <div class="col-2 col-sm-2 col-md-2 col-lg-2 border cabecalho">Categoria</div>
                            <div class="col-2 col-sm-2 col-md-2 col-lg-2 border cabecalho">Ação</div>
                        </div>
                        <div class="row pedido-modal" data-codigo="1">
                            <div class="col-3 col-sm-2 col-md-1 col-lg-2 border cabecalho prod-nome">
                                <select data-placeholder="Selecione um produto" class="form-control combo-prod" tabindex="3" name="produto_id" onchange="transformaComboSpan('pedido-modal',$(this).closest('[data-codigo]').data('codigo'), $(this).val(), $('.combo-prod option:selected').text(),'prod-nome','combo-prod','data-product_id','produto');getProductImage($(this).val(), $('.combo-produto option:selected').text());getCategory('pedido-modal',$(this).closest('[data-codigo]').data('codigo'), $(this).val(),'categoria');">
                                    <option value="">Selecione um produto</option>
                                </select>
                            </div>
                            <div class="col-2 col-sm-2 col-md-1 col-lg-2 border cabecalho measure-nome">
                                <select data-placeholder="Selecione uma medida" class="form-control combo-measure" tabindex="3" name="unidade_id" onchange="transformaComboSpan('pedido-modal',$(this).closest('[data-codigo]').data('codigo'), $(this).val(), $('.combo-measure option:selected').text(),'measure-nome','combo-measure','data-measure_id','medida')">
                                    <option value="">Selecione uma medida</option>
                                </select>
                            </div>
                            <div class="col-3 col-sm-2 col-md-1 col-lg-2 border cabecalho brand-nome">
                                <select data-placeholder="Selecione uma marca" class="form-control combo-brand" tabindex="3" name="marca_id" onchange="transformaComboSpan('pedido-modal',$(this).closest('[data-codigo]').data('codigo'), $(this).val(), $('.combo-brand option:selected').text(),'brand-nome','combo-brand','data-brand_id','marca')">
                                    <option value="">Selecione uma marca</option>
                                </select>
                            </div>
                            <div class="col-2 col-sm-2 col-md-1 col-lg-2 border cabecalho categoria">
                                <span class="categoria-nome" data-category_id>-</span>
                            </div>
                            <div class="col-2 col-sm-2 col-md-1 col-lg-2 border cabecalho">
                                <a href="javascript:void(0)" class="btn btn-warning btn-circle btn-sm atualizar-produto" title="Atualizar Produtos"  onclick="event.preventDefault(); ativaCombo('pedido-modal',$(this).closest('[data-codigo]').data('codigo'),'prod-nome',['combo-prod','combo-measure','combo-brand'])">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-2 d-none imagem-produto">
                    <div class="col-3 col-sm-2 col-md-1 col-lg-2 border cabecalho">
                        <div class="imagem" align="center"><!--JS --></div>
                    </div>
                    <div class="col-6 col-sm-2 col-md-1 col-lg-2 border cabecalho">
                        <div class="row">
                            <div class="col-12 col-sm-2 col-md-1 col-lg-2 cabecalho imagem-nome"><!--JS --></div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-2 col-md-1 col-lg-2 cabecalho imagem-descricao"><!--JS --></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="cancelar();">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnRequestProduto" onclick="">Cadastrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modalData" tabindex="-1" aria-labelledby="modalData" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo-categoria">Calendário</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="setData()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12" id="admin">
                        <input id="datetimepicker1"  data-format="dd/MM/yyyy hh:mm:ss" type="text"/>
                        <span class="add-on"><i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="cancelar();">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnData" onclick="setData()" data-dismiss="modal">Cadastrar</button>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="{{asset('js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{ asset('js/gijgo.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    let dt = $.noConflict();
    var yesterday = new Date();
    yesterday.setDate(yesterday.getDate() -1);
    var hoje = new Date();
    var ano = hoje.getFullYear();
    var ultimoDia = new Date(ano, 12, 0);
    dt('#datetimepicker1').datepicker({
        uiLibrary: 'bootstrap4',
        iconsLibrary: 'fontawesome',
        locale: 'pt-br',
        weekStart: 1,
        daysOfWeekHighlighted: "6,0",
        autoclose: true,
        todayHighlight: true,
        format: 'd/m/yyyy',
        minDate: yesterday,
        maxDate: new Date(ultimoDia),
        onSelect: function(date) {
            dt('#datetimepicker1').html(date);$.noConflict();
        }
    });

</script>

<!-- Scripts -->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('js/default.js') }}"></script>
<script>
    setTimeout(() => {
        $(".alert").remove();
    }, 2000);

    function atualizaTitulo(titulo) {
        $("#tituloFeedback").empty().append(titulo);

        if(titulo == 'Sugestões') {
            $("#prioridade_selecionada").hide();
            $("#feedback .btn").each(function(){
                $(this).removeClass().addClass('btn nao_selecionado');
            });

            $("#feedback .btn").each(function(){
                if($(this).data('id') == 'S') {
                    $(this).removeClass('btn nao_selecionado').addClass('btn btn-success');
                }
            });
            $("#form-feedback").append('<input type="hidden" name="tipo" id="tipo" value="S">');
            $("#prioridade").removeAttr('required');
        } else {
            $("#feedback .btn").each(function(){
                if($(this).data('id') == 'N') {
                    $(this).removeClass('btn nao_selecionado').addClass('btn btn-danger');
                }
            });
            $("#form-feedback").append('<input type="hidden" name="tipo" id="tipo" value="R">');
            $("#prioridade").attr('required','required');
        }
    }

    function cancelar() {
        window.location.reload();
    }

    function salvarFeedback() {
        let formulario = $("#form-feedback").serializeArray();
        let id = $('#id').val() != '' ? $('#id').val() : '';
        let url = id == undefined || id == '' ? 'feedback' : 'feedback/'+id;
        let tipo = id == undefined || id == '' ? 'post' : 'put';
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:url,
            type:tipo,
            dateType: 'json',
            data:{
                form: formulario
            },
            success: function(res) {
                window.location.reload();
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    function salvarMedida() {
        let formulario = $("#form-medida").serializeArray();
        let id = $('#measure').val() != '' ? $('#measure').val() : '';
        let url = id == undefined  || id == '' ? 'measure' : 'measure/'+id;
        let tipo = id == undefined  || id == '' ? 'post' : 'put';

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:url,
            type:tipo,
            dateType: 'json',
            data:{
                form: formulario
            },
            success: function(res) {
                window.location.reload();
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    function salvarCategoria() {

        let formulario = $("#form-categoria").serializeArray();
        let id = $('#category').val() != '' ? $('#category').val() : '';
        let url = id == undefined  || id == '' ? 'category' : 'category/'+id;
        let tipo = id == undefined  || id == '' ? 'post' : 'put';

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:url,
            type:tipo,
            dateType: 'json',
            data:{
                form: formulario
            },
            success: function(res) {
                window.location.reload();
            },
            error: function (error) {
                console.log(error);
            }
        });

    }

    function salvarMarca() {

            let formulario = $("#form-marca").serializeArray();
            let id = $('#brand').val() != '' ? $('#brand').val() : '';
            let url = id == undefined  || id == '' ? 'brand' : 'brand/'+id;
            let tipo = id == undefined  || id == '' ? 'post' : 'put';

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:url,
                type:tipo,
                dateType: 'json',
                data:{
                    form: formulario
                },
                success: function(res) {
                    window.location.reload();
                },
                error: function (error) {
                    console.log(error);
                }
            });

        }

    $(document).ready(function(){
        $("#feedback .btn").on('click', function(){
            $("#feedback .btn").each(function(){
                $(this).removeClass().addClass('btn nao_selecionado');
            });

            let tipo = $(this).val();

            if(tipo == "R") {
                $(this).removeClass('btn nao_selecionado').addClass('btn btn-danger');
                $("#prioridade_selecionada").show();
                $("#tituloFeedback").empty().append('Reclamações');
            } else {
                $(this).removeClass('btn nao_selecionado').addClass('btn btn-success');
                $("#prioridade_selecionada").hide();
                $("#tituloFeedback").empty().append('Sugestões');
            }
            $("#form-feedback").append('<input type="hidden" name="tipo" id="tipo" value="'+ $(this).val() +'">');
        });
    });

</script>

<script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
<script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
</body>
</html>
