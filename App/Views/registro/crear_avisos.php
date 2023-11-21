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
                                        <a>Crear Avisos de los Empleadores / .</a>
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
                    <div class="card-body">
                        <div class="tab-content">
                            <!-- FORM CREAR AVISO -->
                            <div class="tab-pane active" role="tabpanel">
                                <form action="<?= $baseUrl ?>BR_avisos/CrearAviso" id="form_crear_aviso" method="post" enctype="multipart/form-data" >
                                    <div id="">
                                        <div class="form-row">
                                            <div class="col-md-12" id="titulo_datos_empresa">
                                                <p><b>DATOS DE LA EMPRESA:</b></p>
                                            </div>
                                            <div class="col-md-6" id="">
                                                <div class="position-relative form-group">
                                                    <label for="" class="form-label"><b>Buscar Empresa que desea publicar el aviso</b></label>
                                                    <select name="id_empresa" id=""
                                                        class="form-control form-control-sm js-example-basic-single" required>
                                                        <option value="" hidden>-- Seleccione --</option>
                                                        <?php foreach ($empresas as $row): ?>
                                                        <option value="<?= $row->id ?>"><?= $row->ruc.' | '.$row->nombre_comercial ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label for="" class="form-label"><b>Programa de Estudio.</b></label>
                                                    <select name="id_carrera" id=""
                                                        class="form-control form-control-sm" required>
                                                        <option value="" hidden>-- Seleccione --</option>
                                                        <?php foreach ($carrera as $row): ?>
                                                        <option value="<?= $row->id ?>"><?= $row->nombre ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label for="" class="form-label"><b>Ciudad.</b></label>
                                                    <select name="id_distrito" id=""
                                                        class="form-control form-control-sm js-example-basic-single" required>
                                                        <option value="" hidden>-- Seleccione --</option>
                                                        <?php foreach ($distrito as $row): ?>
                                                        <option value="<?= $row->id ?>"><?= $row->nombre ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6" id="">
                                                <div class="position-relative form-group">
                                                    <label for="" class="form-label"><b>Título de Aviso.</b></label>
                                                    <input name="titulo_aviso" id="" type="text"
                                                        class="form-control form-control-sm" required>
                                                </div>
                                            </div>
                                            <div class="col-md-12" id="input_correoEmpresa">
                                                <div class="position-relative form-group">
                                                    <label for="" class="form-label"><b>Descripcion del Aviso</b></label>
                                                    <textarea name="descripcion_aviso" id="descripcion_aviso" rows="3">
                                                        <b>REQUISITOS: </b><br><br><br><br>
                                                        <b>FUNCIONES: </b><br><br><br><br>
                                                        <b>HORARIO: </b><br><br><br><br>
                                                        <b>BENEFICIOS: </b><br><br><br><br>
                                                    </textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6" id="input_nombresContacto">
                                                <div class="position-relative form-group">
                                                    <label for="" class="form-label"><b>Dirección</b></label>
                                                    <input required name="direccion_aviso" id="" type="text"
                                                        class="form-control form-control-sm">
                                                </div>
                                            </div>
                                            <div class="col-md-6" id="input_cargoContacto">
                                                <div class="position-relative form-group">
                                                    <label for="" class="form-label"><b>Referencia Dirección</b></label>
                                                    <input required name="referencia_aviso" id="" type="text"
                                                        class="form-control form-control-sm">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="position-relative form-group">
                                                    <label for="" class="form-label"><b>Salario</b></label>
                                                    <input required name="salario_aviso" id="" type="text" class="form-control form-control-sm">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="position-relative form-group">
                                                    <label for="" class="form-label"><b>Vacantes</b></label>
                                                    <input required name="vacantes_aviso" id="" type="text" class="form-control form-control-sm">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="position-relative form-group">
                                                    <label for="" class="form-label"><b>Periodo de Vigencia</b></label>
                                                    <input required name="vigencia_aviso" id="" type="date" class="form-control form-control-sm">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="position-relative form-group">
                                                    <label for="" class="form-label"><b>Grado Académico.</b></label>
                                                    <select name="grado_academic_aviso" id=""
                                                        class="form-control form-control-sm" required>
                                                        <option value="" hidden>-- Seleccione --</option>
                                                        <?php foreach ($grado_academico as $row): ?>
                                                        <option value="<?= $row->id ?>"><?= $row->grado_estado ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="position-relative form-group">
                                                    <label for="" class="form-label"><b>Ciclo.</b></label>
                                                    <select name="ciclo_aviso" id=""
                                                        class="form-control form-control-sm" required>
                                                        <option value="" hidden>-- Seleccione --</option>
                                                        <option value="I">I</option>
                                                        <option value="II">II</option>
                                                        <option value="III">III</option>
                                                        <option value="IV">IV</option>
                                                        <option value="V">V</option>
                                                        <option value="VI">VI</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="position-relative form-group">
                                                    <label for="" class="form-label"><b>Fecha de Creación.</b></label>
                                                    <input required name="creacion_aviso" id="" type="datetime-local"
                                                        class="form-control form-control-sm">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="divider"></div>
                                        <div class="clearfix">
                                            <button type="button" class="btn-shadow float-left btn btn-link"
                                                id="btn_reiniciar">Reiniciar</button>
                                            <button type="submit"
                                                class="btn-shadow btn-wide float-right btn-pill btn-hover-shine btn btn-primary">Crear Aviso</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>



                <div class="col-md-12 col-lg-4">
                    <div class="main-card mb-3 card">
                        <div class="card-header">Lista de Avisos Creados Recientemente</div>
                        <ul class="todo-list-wrapper list-group list-group-flush scroll-area-lg"
                            id="lista_cuentas_creadas">
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
<script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap4.min.js"></script>
<!-- APP JS -->
<script type="text/javascript" src="<?= $baseUrl ?>assets/scripts/main.d810cf0ae7f39f28f336.js"></script>
<script src="../js/registro/crear_avisos.js"></script>
<script>
$(document).ready(function() {
    $('.js-example-basic-single').select2();

    CKEDITOR.replace( 'descripcion_aviso' );
/*     ClassicEditor
    .create( document.querySelector( '#editor' ) )
    .catch( error => {
        console.error( error );
    } ); */
});
</script>

