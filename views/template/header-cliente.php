<!doctype html>
<html lang="es">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="<?php echo RUTA_PRINCIPAL . 'assets/'; ?>img/iniciologo.jpg" type="image/png" />
    <link href="<?php echo RUTA_PRINCIPAL . 'assets/admin/'; ?>plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <link href="<?php echo RUTA_PRINCIPAL . 'assets/admin/'; ?>plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
    <!-- loader-->
    <link href="<?php echo RUTA_PRINCIPAL . 'assets/admin/'; ?>css/pace.min.css" rel="stylesheet" />
    <script src="<?php echo RUTA_PRINCIPAL . 'assets/admin/'; ?>js/pace.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="<?php echo RUTA_PRINCIPAL . 'assets/admin/'; ?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo RUTA_PRINCIPAL . 'assets/admin/'; ?>css/bootstrap-extended.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="<?php echo RUTA_PRINCIPAL . 'assets/admin/'; ?>css/app.css" rel="stylesheet">
    <link href="<?php echo RUTA_PRINCIPAL . 'assets/admin/'; ?>css/icons.css" rel="stylesheet">
    <!-- Theme Style CSS -->
    <link rel="stylesheet" href="<?php echo RUTA_PRINCIPAL . 'assets/admin/'; ?>css/dark-theme.css" />
    <link rel="stylesheet" href="<?php echo RUTA_PRINCIPAL . 'assets/admin/'; ?>css/semi-dark.css" />
    <link rel="stylesheet" href="<?php echo RUTA_PRINCIPAL . 'assets/admin/'; ?>css/header-colors.css" />
    <title><?php echo $data['title']; ?></title>
</head>

<body>
    <!--wrapper-->
    <div class="wrapper">
        <!--sidebar wrapper -->
        <div class="sidebar-wrapper" data-simplebar="true">
            <div class="sidebar-header">
                <div>
                    <a href="<?php echo RUTA_PRINCIPAL; ?>"> <img src="<?php echo RUTA_PRINCIPAL . 'assets/'; ?>img/logo.jpg" class="logo-icon" alt="logo icon"> </a>
                </div>
                <div>
                    <h4 class="logo-text">ClienteCC</h4>
                </div>
                <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
                </div>
            </div>
            <!--navigation-->
            <ul class="metismenu" id="menu">
                <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class="bx bx-category"></i>
                        </div>
                        <div class="menu-title">Reservas</div>
                    </a>
                    <ul>
                        <li> <a href="<?php echo RUTA_PRINCIPAL . 'reserva/pendiente'; ?>"><i class="bx bx-right-arrow-alt"></i>Pendiente</a>
                        </li>
                        <li> <a href="<?php echo RUTA_PRINCIPAL . 'reserva/mostrarReservas'; ?>"><i class="bx bx-right-arrow-alt"></i>Mis Reservas</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!--end navigation-->
        </div>
        <!--end sidebar wrapper -->
        <!--start header -->
        <header>
            <div class="topbar d-flex align-items-center">
                <nav class="navbar navbar-expand">
                    <div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
                    </div>
                    <div class="search-bar flex-grow-1">

                    </div>
                    <div class="user-box dropdown">
                        <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="<?php echo RUTA_PRINCIPAL . 'assets/'; ?>img/iniciologo.jpg" class="user-img" alt="user avatar">
                            <div class="user-info ps-3">
                                <p class="user-name mb-0"><?php echo $_SESSION['nombre_usuario']; ?></p>
                                <p class="designattion mb-0"><?php echo $_SESSION['usuario']; ?></p>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="javascript:;" onclick="cerrarSesion()"><i class='bx bx-log-out-circle'></i><span>Cerrar Sesión</span></a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </header>
        <!--end header -->
        <!--start page wrapper -->
        <div class="page-wrapper">
            <div class="page-content">