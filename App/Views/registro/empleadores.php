<div class="main-card mb-3 card">
    <div class="card-header app-page-title text-white pt-5 pb-5">
        <div class="">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div>
                        <div class="page-title-subheading opacity-10">
                            <nav class aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a>
                                            <i class="fa-solid fa-building"></i>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a>Crear Cuenta para Empleadores / .</a>
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
            <div class="row">
                <div class="col-lg-8 col-md-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <div class="card-header card-header-tab-animation">
                                <ul class="nav nav-justified">
                                    <li class="nav-item"><a data-toggle="tab" id="SectPersonaJuridica" href="#SectPersonaJuridica"
                                            class="active nav-link">Persona Jurídica</a></li>
                                    <li class="nav-item"><a data-toggle="tab" id="SectPersonaNatural" href="#SectPersonaNatural"
                                            class="nav-link">Persona Natural</a></li>
                                    <li class="nav-item"><a data-toggle="tab" id="SectPersonaNaturalNegocio" href="#SectPersonaNaturalNegocio"
                                            class="nav-link">Persona Natural con Negocio</a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">

                                    <!-- FORM PERSONA JURIDICA -->
                                    <div class="tab-pane active" id="SectPersonaJuridica" role="tabpanel">
                                        <form action="" id="form_crear_personaJuridica" method="post">
                                            <div id="campos_formulario_personaJuridica">
                                                <div class="form-row">
                                                    <div class="col-md-12" id="titulo_datos_empresa">
                                                        <p><b>DATOS DE LA EMPRESA:</b></p>
                                                    </div>
                                                    <input type="hidden" name="tipo_persona" id="tipo_persona" value="1" required>
                                                    <div class="col-md-5">
                                                        <div class="position-relative form-group">
                                                            <label for="" class="form-label"><b class="text-danger" id="validationRuc" >Ingrese su RUC para autocompletar los datos.</b></label>
                                                            <input name="" type="text" id="dni" minlength="8" maxlength="9" class="form-control form-control-sm buscador_dni" hidden>
                                                            <input name="ruc" type="text" id="ruc" minlength="9" maxlength="15" class="form-control form-control-sm buscador_ruc" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-7" id="input_nombreEmpresa">
                                                        <div class="position-relative form-group">
                                                            <label for="" class="form-label"><b>Nombre de la Empresa.</b></label>
                                                            <input name="nombre_empresa" type="text" id="nombre_empresa" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6" id="input_nombreCormercial">
                                                        <div class="position-relative form-group">
                                                            <label for="" class="form-label"><b>Nombre Comercial.</b></label>
                                                            <input name="nombre_comercial" id="nombre_comercial" type="text" class="form-control form-control-sm" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6" id="input_razonSocial">
                                                        <div class="position-relative form-group">
                                                            <label for="" class="form-label"><b>Razón Social.</b></label>
                                                            <input name="razon_social" id="razon_social" type="text" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6" id="input_actividadEconomica">
                                                        <div class="position-relative form-group">
                                                            <label for="" class="form-label"><b>Actividad Económica de la Empresa.</b></label>
                                                            <select name="actividad_economica" id="actividad_economica" class="form-control form-control-sm js-example-basic-single" required>
                                                                <option value="" hidden>-- Seleccione --</option>
                                                                <?php foreach ($actividadesEconomicas as $row): ?>
                                                                    <option value="<?= $row->id ?>"><?= $row->codigo.' | '.$row->descripcion ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="position-relative form-group">
                                                            <label for="" class="form-label"><b>Fecha de Creación <span class="text-danger">(Campo requerido)</span></b></label>
                                                            <input name="fecha_creacion" id="" type="datetime-local" class="form-control form-control-sm" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <p><b>DATOS DE LA UBICACIÓN:</b></p>
                                                    </div>
                                                    <div class="col-md-6" id="input_direccion">
                                                        <div class="position-relative form-group">
                                                            <label for="" class="form-label"><b>Dirección exacta de la Empresa.</b></label>
                                                            <input name="direccion" id="direccion" type="text" class="form-control form-control-sm" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="position-relative form-group">
                                                            <label for="" class="form-label"><b>Referencia.</b></label>
                                                            <input name="referencia" id="referencia" type="text" class="form-control form-control-sm" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="position-relative form-group">
                                                            <label for="" class="form-label"><b>Ciudad.</b></label>
                                                            <select name="ciudad" id="ciudad" class="form-control form-control-sm" required>
                                                                <option value="" hidden>-- Seleccione --</option>
                                                                <?php foreach ($ciudad as $row): ?>
                                                                    <option value="<?= $row->id ?>"><?= $row->nombre ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="position-relative form-group">
                                                            <label for="" class="form-label"><b>Distrito.</b></label>
                                                            <select name="distrito" id="distrito" class="form-control form-control-sm" required>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6" id="input_telefonoEmpresa">
                                                        <div class="position-relative form-group">
                                                            <label for="" class="form-label"><b>Teléfono Empresa.</b></label>
                                                            <input name="telefono_empresa" id="telefono_empresa" type="text" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6" id="input_correoEmpresa">
                                                        <div class="position-relative form-group">
                                                            <label for="" class="form-label"><b>Correo Electrónico.</b></label>
                                                            <input name="correo" id="correo" type="email" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <p><b>DATOS DEL CONTACTO:</b></p>
                                                    </div>
                                                    <div class="col-md-6" id="input_nombresContacto">
                                                        <div class="position-relative form-group">
                                                            <label for="" class="form-label"><b>Nombre y Apellidos del Contacto.</b></label>
                                                            <input name="nombre_contacto" id="nombre_contacto" type="text" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6" id="input_cargoContacto">
                                                        <div class="position-relative form-group">
                                                            <label for="" class="form-label"><b>Cargo Contácto.</b></label>
                                                            <input name="cargo_contacto" id="cargo_contacto" type="text" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="position-relative form-group">
                                                            <label for="" class="form-label"><b>Teléfono Contacto.</b></label>
                                                            <input name="telefono_contacto" id="telefono_contacto" type="text" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="position-relative form-group">
                                                            <label for="" class="form-label"><b>Correo Electrónico del Contácto.</b></label>
                                                            <input name="correo_contacto" id="correo_contacto" type="email" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12" id="titulo_dataPaciente" hidden>
                                                        <p><b>DATOS DEL PACIENTE:</b></p>
                                                    </div>
                                                    <div class="col-md-6" id="input_nombrePaciente" hidden>
                                                        <div class="position-relative form-group">
                                                            <label for="" class="form-label"><b>Nombre del Paciente.</b></label>
                                                            <input name="nombre_paciente" id="correo_contacto" type="text" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6" id="input_enfermedadPaciente" hidden>
                                                        <div class="position-relative form-group">
                                                            <label for="" class="form-label"><b>Indiqué la enfermedad o discapacidad.</b></label>
                                                            <input name="enfermedad_paciente" id="correo_contacto" type="text" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                <div class="divider"></div>
                                                <div class="clearfix">
                                                    <button type="button" class="btn-shadow float-left btn btn-link" id="btn_reiniciar">Reiniciar</button>
                                                    <button type="submit" class="btn-shadow btn-wide float-right btn-pill btn-hover-shine btn btn-primary">Crear Cuenta</button>
                                                </div>
                                            </div>
                                        </form>  
                                    </div>

                                </div>
                            </div>                        

                        </div>
                    </div>
                </div>



                <div class="col-md-12 col-lg-4">
                    <div class="main-card mb-3 card">
                        <div class="card-header">Lista de Cuentas Creadas Recientemente</div>
                            <ul class="todo-list-wrapper list-group list-group-flush scroll-area-lg" id="lista_cuentas_creadas">
                            </ul>
                        <div class="d-block text-right card-footer">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- LIBRERIA DATATABLES -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap4.min.js"></script>

<!-- APP JS -->
<script type="text/javascript" src="<?= $baseUrl ?>assets/scripts/main.d810cf0ae7f39f28f336.js"></script>
<script src="../js/registro/empleadores.js"></script>
<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
</script>
