<!doctype html>
<html lang="en">

<!-- Mirrored from demo.dashboardpack.com/architectui-html-pro/pages-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 04 Jul 2023 19:17:37 GMT -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Admin IAL- Bolsa de Trabajo</title>
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="Sistema de Empleabilidad Loayza">

    <meta name="msapplication-tap-highlight" content="no">
    <link href="<?= $baseUrl ?>main.d810cf0ae7f39f28f336.css" rel="stylesheet">
</head>
<style>
    .fondo_negro{
        background-image: linear-gradient(120deg, #000000 0%, #000000 100%)!important
    }
</style>
<body>
    <div class="app-container app-theme-white body-tabs-shadow">
        <div class="app-container">
            <div class="h-100">
                <div class="h-100 no-gutters row">
                    <div class="d-none d-lg-block col-lg-4">
                        <div class="slider-light">
                            <div class="slick-slider">
                                <div>
                                    <div class="position-relative h-100 d-flex justify-content-center align-items-center fondo_negro" tabindex="-1">
                                        <div class="slide-img-bg"
                                            style="background-image: url('https://img.freepik.com/fotos-premium/analistas-financieros-analizan-informes-financieros-negocios-proyecto-inversion-planificacion-tabletas-digitales-discusion-reunion-empresas-que-muestran-resultados-su-exitoso-trabajo-equipo_265022-24874.jpg');"></div>
                                        <div class="slider-content">
                                            <h3>SISTEMA EMPLEABILIDAD</h3>
                                            <p>
                                            Nuestro sistema ha sido diseñado pensando en las necesidades de las empresas 
                                            que buscan analizar y evaluar la empleabilidad de los candidatos de manera eficiente 
                                            y precisa. Con una amplia gama de funciones y herramientas, proporcionamos una plataforma 
                                            integral que simplifica y agiliza el proceso de evaluación de los candidatos.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="position-relative h-100 d-flex justify-content-center align-items-center fondo_negro"
                                        tabindex="-1">
                                        <div class="slide-img-bg"
                                            style="background-image: url('https://img.freepik.com/fotos-premium/analistas-financieros-analizan-informes-financieros-negocios-proyecto-inversion-planificacion-tabletas-digitales-discusion-reunion-empresas-que-muestran-resultados-su-exitoso-trabajo-equipo_265022-24613.jpg');">
                                        </div>
                                        <div class="slider-content">
                                            <h3>PERSONALIZA TUS REPORTES</h3>
                                            <p>
                                                Nuestra plataforma te permite generar reportes detallados y personalizados sobre las habilidades, 
                                                experiencia y competencias de los candidatos, brindando a los empleadores una visión completa de su 
                                                idoneidad para el puesto. Podrás analizar de manera rápida y precisa la información relevante, como 
                                                la formación académica, las habilidades técnicas, la experiencia laboral y las referencias.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="position-relative h-100 d-flex justify-content-center align-items-center fondo_negro"
                                        tabindex="-1">
                                        <div class="slide-img-bg"
                                            style="background-image: url('https://img.freepik.com/fotos-premium/grupo-jovenes-empresarios-asiaticos-presentando-reunion-intercambio-ideas-discutiendo-estrategia-planificacion-desarrollo-nuevos-negocios-trabajando-nuevo-proyecto-puesta-marcha-cargo_1645-822.jpg');">
                                        </div>
                                        <div class="slider-content">
                                            <h3>INFORMES GENERALES</h3>
                                            <p>
                                            La generación de informes es intuitiva y personalizable, permitiendo adaptarlos 
                                            a tus propias necesidades y preferencias. Podrás visualizar de manera clara y concisa 
                                            los datos relevantes y presentarlos de forma profesional a los demás miembros del equipo 
                                            de selección o a las áreas gerenciales.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="h-100 d-flex bg-white justify-content-center align-items-center col-md-12 col-lg-8">
                        <div class="mx-auto app-login-box col-sm-12 col-md-10 col-lg-9">
                            <div class="app-logo"></div>
                            <h4 class="mb-0">
                                <div>
                                    <img src="https://www.ial.edu.pe/assets/img_min/logo_ial.min.png" alt="">
                                </div>
                                <span>Inicie sesión en su cuenta nueva.</span>
                            </h4>
                            <div class="divider row"></div>
                            <div>
                                <!-- FORMULARIO LOGIN -->
                                <form class="" method="post" action="Home/IngresarSistema">
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label for="exampleEmail" class>Correo</label>
                                                <input name="email" id="exampleEmail" placeholder="Ingrese su Correo Electronico" type="email" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label for="examplePassword" class>Contraseña</label>
                                                <input name="password" id="examplePassword" placeholder="Ingrese su Contraseña" type="password" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="divider row"></div>
                                    <div class="d-flex align-items-center">
                                        <div class="ml-auto">
                                            <a href="javascript:void(0);" class="btn-lg btn btn-link">Recuperar Contraseña</a>
                                            <button class="btn btn-primary btn-lg">Ingresar al Sistema</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="assets/scripts/main.d810cf0ae7f39f28f336.js"></script>
</body>


</html>

<!-- 
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="<?= $baseUrl ?>js/usuarios/index.js"></script> -->