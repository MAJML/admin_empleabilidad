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
                                            <i class="fa-solid fa-users"></i>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a>Crear Cuenta Estudiantes / .</a>
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
                            <form action="" id="form_crear_alumno" method="post">
                                <div id="campos_formulario">
                                    <div class="form-row">
                                        <div class="col-md-5">
                                            <div class="position-relative form-group">
                                                <label for="" class="form-label"><b class="text-danger" id="validationDni" >Ingrese su dni para autocompletar su información.</b></label>
                                                <input name="dni" type="text" id="dni_buscar_alumnos" minlength="8" maxlength="9" class="form-control form-control-sm" required>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="position-relative form-group">
                                                <label for="" class="form-label"><b>Nombres.</b></label>
                                                <input name="nombre" type="text" id="nombre" class="form-control form-control-sm" required readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label for="" class="form-label"><b>Apellidos.</b></label>
                                                <input name="apellido" id="apellido" type="text" class="form-control form-control-sm" required readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label for="" class="form-label"><b>Teléfono.</b></label>
                                                <input name="telefono" id="telefono" type="text" class="form-control form-control-sm" required readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label for="" class="form-label"><b>Correo Electrónico.</b></label>
                                                <input name="correo" id="correo" type="email" class="form-control form-control-sm" required readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label for="" class="form-label"><b>Fecha de Nacimiento.</b></label>
                                                <input name="nacimiento" id="nacimiento" type="text" class="form-control form-control-sm" required readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label for="" class="form-label"><b>Departamento.</b></label>
                                                <select name="departamento" id="departamento" class="form-control form-control-sm" required>
                                                    <option value="" hidden>-- Seleccione --</option>
                                                    <?php foreach ($departamento as $row): ?>
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
                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label for="" class="form-label"><b>Programa de Estudios.</b></label>
                                                <select name="programa_estudio" id="programa_estudio" class="form-control form-control-sm" required>
                                                    <option value="" hidden>-- Seleccione --</option>
                                                    <?php foreach ($programaEstudios as $row): ?>
                                                        <option value="<?= $row->id ?>"><?= $row->nombre ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label for="" class="form-label"><b>Grado Académico.</b></label>
                                                <select name="grado_academico" id="grado_academico" class="form-control form-control-sm" required>
                                                    <option value="" hidden>-- Seleccione --</option>
                                                    <?php foreach ($GradoAcademico as $row): ?>
                                                        <option value="<?= $row->id ?>"><?= $row->grado_estado ?></option>
                                                    <?php endforeach; ?>
                                                </select>
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
                <div class="col-md-12 col-lg-4">
                    <div class="main-card mb-3 card">
                        <div class="card-header">Lista de Cuentas Creadas Recientemente</div>
                        <ul class="todo-list-wrapper list-group list-group-flush">
<!--                             <li class="list-group-item">
                                <div class="todo-indicator bg-warning"></div>
                                <div class="widget-content p-0">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left mr-2">
                                            <div class="custom-checkbox custom-control">
                                                <input type="checkbox" id="exampleCustomCheckbox12"
                                                    class="custom-control-input">
                                                <label class="custom-control-label"
                                                    for="exampleCustomCheckbox12">&nbsp;</label>
                                            </div>
                                        </div>
                                        <div class="widget-content-left">
                                            <div class="widget-heading">Wash the car
                                                <div class="badge badge-danger ml-2">Rejected</div>
                                            </div>
                                            <div class="widget-subheading"><i>Written by Bob</i></div>
                                        </div>
                                        <div class="widget-content-right widget-content-actions">
                                            <button class="border-0 btn-transition btn btn-outline-success">
                                                <i class="fa fa-check"></i>
                                            </button>
                                            <button class="border-0 btn-transition btn btn-outline-danger">
                                                <i class="fa fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </li> -->
                        </ul>
                        <div class="d-block text-right card-footer">
<!--                             <button class="mr-2 btn btn-link btn-sm">Cancelar</button>
                            <button class="btn btn-success btn-lg">Ok</button> -->
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
<script src="../js/registro/estudiantes.js"></script>