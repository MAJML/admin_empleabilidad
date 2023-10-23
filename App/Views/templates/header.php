<?php
$link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- <meta http-equiv="refresh" content="5; url=nueva-web.html"> -->
    <title>IAL | Bolsadetrabajo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="Sistema de Empleabilidad Loayza">
    <meta name="msapplication-tap-highlight" content="no">
    <!-- SWEET ALERT 2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- ICONOS -->
    <link rel="stylesheet" href="<?= $baseUrl ?>/css/fontAwesome/all.min.css">
    <link rel="stylesheet" href="<?= $baseUrl ?>/css/fontAwesome/fontawesome.min.css">
    <script src="<?= $baseUrl ?>/js/all.min.js"></script>
    <script src="<?= $baseUrl ?>/js/fontawesome.min.js"></script>
    <link rel="stylesheet" href="<?= $baseUrl ?>/css/cargadores.css">
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>

    <link href="<?= $baseUrl ?>main.d810cf0ae7f39f28f336.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
    
    <!-- datatable -->
<!--     <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css"> -->
    <script>
        var baseurl = "<?=$baseUrl?>";
    </script>
</head>
<style>
    .fancybox__container{
        --fancybox-bg: rgb(21 21 21 / 40%);
    }
    table{
        font-size:12px !important;
        text-transform: uppercase !important;
    }
</style>
<body>
    <div id="cargadorLoading" class="loading show">
        <div class="spin"></div>
    </div>

    
    <div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar">
        
        <!-- HEADER NAVBAR -->
        <div class="app-header header-shadow">
            <div class="app-header__logo">
                <div class="logo-src">
                    <img src="<?= $baseUrl ?>assets/images/logo_ial_nuev.png" alt="" width="150px" height="50px" style="margin-top:-11px;">
                </div>
                <div class="header__pane ml-auto">
                    <div>
                        <button type="button" class="hamburger close-sidebar-btn hamburger--elastic"
                            data-class="closed-sidebar">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="app-header__mobile-menu">
                <div>
                    <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </div>
            </div>
            <div class="app-header__menu">
                <span>
                    <button type="button"
                        class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                        <span class="btn-icon-wrapper">
                            <i class="fa fa-ellipsis-v fa-w-6"></i>
                        </span>
                    </button>
                </span>
            </div>
            <div class="app-header__content">
                <div class="app-header-left">
                    <ul class="header-megamenu nav">
                        <li class="nav-item">
                            <a href="javascript:void(0);" data-placement="bottom" rel="popover-focus" data-offset="300"
                                data-toggle="popover-custom" class="nav-link">
                                <i class="fa fa-th" style="margin-right:5px; color:#A3E4D7;"></i> Mega Menu
                                <i class="fa fa-angle-down ml-2 opacity-5"></i>
                            </a>
                            <div class="rm-max-width">
                                <div class="d-none popover-custom-content">
                                    <div class="dropdown-mega-menu">
                                        <div class="grid-menu grid-menu-2col">
                                            <div class="no-gutters row">
                                                <div class="col-sm-6 col-xl-6">
                                                    <ul class="nav flex-column">
                                                        <li class="nav-item-header nav-item"> Busquedas Rápidas</li>
                                                        <li class="nav-item">
                                                            <a href="BR_empleadores" class="nav-link">
                                                                <span> Empleadores</span>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="BR_estudiantes" class="nav-link">
                                                                <span> Estudiantes</span>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="BR_avisos" class="nav-link">
                                                                <span> Avisos</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="col-sm-6 col-xl-6">
                                                    <ul class="nav flex-column">
                                                        <li class="nav-item-header nav-item"> Notificaciones</li>
                                                        <li class="nav-item">
                                                            <a href="javascript:void(0);" class="nav-link"> Nuevos Empleadores</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="javascript:void(0);" class="nav-link"> Nuevos Estudiantes
                                                                <div class="ml-auto badge badge-success">New</div>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="javascript:void(0);" class="nav-link">Nuevos Avisos</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="app-header-right">
                    <div class="header-btn-lg pr-0">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left">
                                    <div class="btn-group">
                                        <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                            class="p-0 btn">
                                            <img width="42" class="rounded-circle" src="https://img.favpng.com/17/1/20/user-interface-design-computer-icons-default-png-favpng-A0tt8aVzdqP30RjwFGhjNABpm.jpg"
                                                alt>
                                            <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                        </a>
                                        <div tabindex="-1" role="menu" aria-hidden="true"
                                            class="rm-pointers dropdown-menu-lg dropdown-menu dropdown-menu-right">
                                            <div class="dropdown-menu-header">
                                                <div class="dropdown-menu-header-inner bg-info">
                                                    <div class="menu-header-image opacity-2"
                                                        style="background-image: url('https://img.favpng.com/17/1/20/user-interface-design-computer-icons-default-png-favpng-A0tt8aVzdqP30RjwFGhjNABpm.jpg">
                                                    </div>
                                                    <div class="menu-header-content text-left">
                                                        <div class="widget-content p-0">
                                                            <div class="widget-content-wrapper">
                                                                <div class="widget-content-left mr-3">
                                                                    <img width="42" class="rounded-circle"
                                                                        src="https://img.favpng.com/17/1/20/user-interface-design-computer-icons-default-png-favpng-A0tt8aVzdqP30RjwFGhjNABpm.jpg" alt>
                                                                </div>
                                                                <div class="widget-content-left">
                                                                    <div class="widget-heading"> <?= $_SESSION['username']; ?> </div>
                                                                    <div class="widget-subheading opacity-8"> <?= $_SESSION['correo']; ?> </div>
                                                                </div>
                                                                <div class="widget-content-right mr-2">
                                                                    <a class="btn-pill btn-shadow btn-shine btn btn-focus" href="Home/cerrar_sesion">Salir</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="scroll-area-xs" style="height: 150px;">
                                                <div class="scrollbar-container ps">
                                                    <ul class="nav flex-column">
                                                        <li class="nav-item-header nav-item">Mi Perfil</li>
                                                        <li class="nav-item">
                                                            <a href="javascript:void(0);" class="nav-link"><span class="text-success" style="margin-right:10px; font-size:20px;">●</span> En linea </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="javascript:void(0);" class="nav-link">Cambiar Contraseña </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content-left  ml-3 header-user-info">
                                    <div class="widget-heading"> <?= $_SESSION['username']; ?> </div>
                                    <div class="widget-subheading"> <?= $_SESSION['perfil'] ?> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END HEADER NAVBAR -->

        <div class="app-main">
            <div class="app-sidebar sidebar-shadow bg-night-sky sidebar-text-light">
                <div class="app-header__logo">
                    <div class="logo-src">
                        <!-- <img src="<?= $baseUrl ?>img/logo_ial.pmg" alt=""> -->
                    </div>
                    <div class="header__pane ml-auto">
                        <div>
                            <button type="button" class="hamburger close-sidebar-btn hamburger--elastic"
                                data-class="closed-sidebar">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="app-header__mobile-menu">
                    <div>
                        <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
                <div class="app-header__menu">
                    <span>
                        <button type="button"
                            class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                            <span class="btn-icon-wrapper">
                                <i class="fa fa-ellipsis-v fa-w-6"></i>
                            </span>
                        </button>
                    </span>
                </div>
                <div class="scrollbar-sidebar">
                    <div class="app-sidebar__inner">
                        <ul class="vertical-nav-menu">
                            <li class="app-sidebar__heading">Menu</li>
                            <!-- MENU INICIO -->
                            <li>
                                <a href="Inicio" class="<?= ($link == $baseUrl.'Inicio') ? 'mm-active' : '' ; ?>"><i class="fa-solid fa-house" width="23px"></i> Inicio</a>
                            </li>
                            <!-- MENU EMPLEADOR -->
                            <li>
                                <a class="<?= ($link == $baseUrl.'PersonaTodos') ? 'mm-active' : '' ; ?>" href="PersonaTodos"><i class="fa-solid fa-building-user" width="23px"></i> Empleador</a>
                            </li>
                            <!-- MENU ESTUDIANTES -->
                            <li>
                                <a class="<?= ($link == $baseUrl.'EstudianteTodos') ? 'mm-active' : '' ; ?>" href="EstudianteTodos"><i class="fa-solid fa-users" width="23px"></i> Estudiantes</a>
                            </li>
                            <!-- MENU AVISOS -->
                            <li>
                                <a class="<?= ($link == $baseUrl.'Avisos') ? 'mm-active' : '' ; ?>" href="Avisos"><i class="fa-solid fa-building-user" width="23px"></i> Avisos</a>
                            </li>
                            <!-- MENU USUARIOS -->
                            <li <?= ($_SESSION['perfil'] == 'Encargado' || $_SESSION['perfil'] == 'Asistente')? 'hidden':'' ?>>
                                <a class="<?= ($link == $baseUrl.'Usuario') ? 'mm-active' : '' ; ?>" href="Usuario"><i class="fa-solid fa-user" width="23px"></i> Usuarios</a>
                            </li>
                            <!-- MENU REPORTES -->
                            <li class="app-sidebar__heading" <?= ($_SESSION['perfil'] == 'Asistente')? 'hidden':'' ?>>Reportes</li>
                            <li class='<?= ($link == $baseUrl.'RE_actividadEconomica' || $link == $baseUrl.'RE_validacion' || $link == $baseUrl.'RE_requerimiento') ? 'mm-active' : ' ' ; ?>' <?= ($_SESSION['perfil'] == 'Asistente')? 'hidden':'' ?>>
                                <a href="#">
                                    <i class="fa-solid fa-chart-simple" width="23px"></i> Reporte Empleador
                                    <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                </a>
                                <ul>
                                    <li>
                                        <a class="<?= ($link == $baseUrl.'RE_actividadEconomica') ? 'mm-active' : '' ; ?>" href="RE_actividadEconomica">
                                            <i class="metismenu-icon"></i> Actividad Económica
                                        </a>
                                    </li>
                                    <li>
                                        <a class="<?= ($link == $baseUrl.'RE_validacion') ? 'mm-active' : '' ; ?>" href="RE_validacion">
                                            <i class="metismenu-icon"></i> Empleadores Validados
                                        </a>
                                    </li>
                                    <li hidden>
                                        <a class="<?= ($link == $baseUrl.'RE_requerimiento') ? 'mm-active' : '' ; ?>" href="RE_requerimiento">
                                            <i class="metismenu-icon"></i> Requerimiento
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class='<?= ($link == $baseUrl.'R_EST_intermediacion' || $link == $baseUrl.'R_EST_seguimientoPostulante')? 'mm-active' : ''; ?>' <?= ($_SESSION['perfil'] == 'Asistente')? 'hidden':'' ?>>
                                <a href="#">
                                    <i class="fa-solid fa-chart-simple" width="23px"></i> Reporte Estudiantes
                                    <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                </a>
                                <ul>
                                    <li>
                                        <a class="<?= ($link == $baseUrl.'R_EST_intermediacion') ? 'mm-active' : '' ; ?>" href="R_EST_intermediacion">
                                            <i class="metismenu-icon"></i> Intermediados
                                        </a>
                                    </li>
                                    <li>
                                        <a class="<?= ($link == $baseUrl.'R_EST_seguimientoPostulante') ? 'mm-active' : '' ; ?>" href="R_EST_seguimientoPostulante">
                                            <i class="metismenu-icon"></i> Seguimiento al Postulante
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class='<?= ($link == $baseUrl.'R_A_cantidades' || $link == $baseUrl.'R_A_efectividadAviso')? 'mm-active' : ''; ?>' <?= ($_SESSION['perfil'] == 'Asistente')? 'hidden':'' ?>>
                                <a href="#">
                                    <i class="fa-solid fa-chart-simple" width="23px"></i> Reporte Avisos
                                    <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                </a>
                                <ul>
                                    <li>
                                        <a class="<?= ($link == $baseUrl.'R_A_cantidades') ? 'mm-active' : '' ; ?>" href="R_A_cantidades">
                                            <i class="metismenu-icon"></i> Cantidades
                                        </a>
                                    </li>
                                    <li>
                                        <a class="<?= ($link == $baseUrl.'R_A_efectividadAviso') ? 'mm-active' : '' ; ?>" href="R_A_efectividadAviso">
                                            <i class="metismenu-icon"></i> Efectividad por Aviso
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="app-main__outer">

                <div class="app-main__inner">