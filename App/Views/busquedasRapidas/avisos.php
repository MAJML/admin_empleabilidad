<style type="text/css">
.label-as-badge {
    border-radius: 1em;
    font-size: 12px;
    cursor: pointer !important;
}

table.dataTable th,
table.dataTable td {
    white-space: wrap !important;
}
#searchResults{
    z-index: 19;
    background: #fff;
    border: 0.1px solid #F2F4F4;
    padding-left : 10px !important;
    position:absolute !important;
}
#searchResults li{
    list-style-type: none;
    margin-left: -5px;
}
#searchResults li a{
    /* background: red !important; */
    width: 100% !important;
    color:#2E4053 !important;
    text-decoration: none;
}
#searchResults li:hover{
    background:#D6EAF8;
}
#DataTables_Table_1_filter{
    display:none !important;
}
</style>

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
                                            <i class="fa-solid fa-graduation-cap"></i>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a>Búsqueda Rápida Avisos /</a>
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
        <div class="row">
            <div class="col-12 d-flex flex-wrap justify-content-sm-center justify-content-lg-start justify-content-center w-100 p-1">
                <form action="" class="d-flex flex-wrap col-12 justify-content-between" role="form" method="post">
                    <div class="mb-2 margen-right col-md-5">
                        <input type="search" class="form-control form-control-sm fecha1" name='' id="buscarAviso" placeholder="Buscar por Titulo de Aviso o por ruc/dni" required>
                    </div>
                    <div class="col-lg-2">
                        <a href="BR_avisos/crearCuenta" class="btn btn-outline-primary"><i class="fa fa-plus" aria-hidden="true"></i> Crear Aviso</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class='row col-12'>
            <div class='col-12 mb-5'>
                <table id=""
                    class="TableLibrary display responsive no-wrap table table-bordered table-hover table-condensed table_Estudiantes"
                    width='100%'>
                    <thead class="cabezera_tabla">
                        <tr>
                            <th>N°</th>
                            <th>FECHA REGISTRO</th>
                            <th>TIPO DE PERSONA</th>
                            <th>RUC / DNI</th>
                            <th>RAZON SOCIAL / NOBRE COMPLETO</th>
                            <th>NOMBRE COMERCIAL</th>
                            <th>TITULO DE PUESTO</th>
                            <th>DISTRITO</th>
                            <th>CANTIDAD DE VACANTES</th>
                            <th>*</th>
                        </tr>
                    </thead>
                    <tbody class="cargador">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- ESTO ES EL OTRA MODAL PARA MODIFCAR EL AVISO -->
<div id="modal_modificar_aviso" style="display:none;width:1400px;">
    <h5 class="p-3 bg-success"><b style="color:#fff;">MODIFICAR AVISO</b></h5>
    <hr>
    <div class="row">
        <form id="form_modificar_aviso" class="row col-md-12" action="" method="post">
            <input type="hidden" name="id_aviso" id="id_aviso" required>
            <div class="col-md-3 mb-3">
                <label for="">Fecha de Publicación</label>
                <input type="date" class="form-control form-control-sm" name="mod_form_fecha_publicacion" id="mod_form_fecha_publicacion" required>
            </div>
            <div class="col-md-3 mb-3">
                <label for="">Hora de Publicaión</label>
                <input type="time" class="form-control form-control-sm" name="mod_form_hora_publicacion" id="mod_form_hora_publicacion" required>
            </div>
            <div class="col-md-3 mb-3">
                <label for="">Fecha de Vigencia</label>
                <input type="date" class="form-control form-control-sm" name="mod_form_fecha_vigencia" id="mod_form_fecha_vigencia" required>
            </div>
            <div class="col-md-12 mb-3">
                <input type="text" id="mod_form_titulo" name="mod_form_titulo" class="form-control form-control-sm" placeholder="Ingrese titulo de la Oferta" required>
            </div>
            <div class="col-md-6 mb-3">
                <select name="mod_form_distrito" id="mod_form_distrito" class="form-control form-control-sm" required>
                    <option value="">-- Distrito --</option>
                    <?php foreach ($distrito as $row): ?>
                        <option value="<?= $row->id ?>"><?= $row->nombre ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <input type="text" id="mod_form_vacantes" name="mod_form_vacantes" class="form-control form-control-sm" placeholder="Cantidad de Vacantes" required>
            </div>
            <div class="col-md-6 mb-3">
                <select name="mod_form_carrera" id="mod_form_carrera" class="form-control form-control-sm" required>
                    <option value="">-- Carrera que solicita --</option>
                    <?php foreach ($carrera as $row): ?>
                        <option value="<?= $row->id ?>"><?= $row->nombre ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <select name="mod_form_estado" id="mod_form_estado" class="form-control form-control-sm" required>
                    <option value="">-- Estado --</option>
                    <?php foreach ($grado_academico as $row): ?>
                        <option value="<?= $row->id ?>"><?= $row->grado_estado ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6 mb-3" hidden>
                <input type="text" name="mod_form_vigencia" id="mod_form_vigencia" class="form-control form-control-sm" placeholder="Periodo de vigencia">
            </div>
            <div class="col-md-6 mb-3">
                <select name="mod_form_grado" id="mod_form_grado" class="form-control form-control-sm">
                    <option value="" hidden>-- Grado Academico que solicita --</option>
                    <option value="I">I</option>
                    <option value="II">II</option>
                    <option value="III">III</option>
                    <option value="IV">IV</option>
                    <option value="V">V</option>
                    <option value="VI">VI</option>
                </select>
            </div>
            <div class="col-md-12 mb-3">
                <textarea name="mod_form_descripcion" id="mod_form_descripcion" class="form-control form-control-sm" cols="30" rows="10" contenteditable="true" required>
                </textarea>
            </div>
            <div class="col-md-3 mb-3">
                <input type="text" id="mod_form_salario" name="mod_form_salario" class="form-control form-control-sm" required>
            </div>
            <div class="col-md-6 mb-3">
            </div>
            <div class="col-md-3 mb-3">
                <button type="submit" class="btn btn-success w-100">Modificar Aviso</button>
            </div>
        </form>
    </div>
</div>

<!-- ESTO ES EL MODAL DE EDITAR ESTADO DE POSTULANTE -->
<div id="modal_edit_estado" style="display:none;width:400px;">
    <form action="" method="post" id="form_modificar_estadoPost">
        <input type="hidden" id="idAviso" name="idAviso" required>
        <input type="hidden" id="idAlumno" name="idAlumno" required>
        <div class="mb-3 col-md-12">
            <label for=""><b>Estado del Postulante</b></label>
            <select name="estado_postulante" class="form-control form-control-sm" id="estado_postulante">
                <?php foreach ($estadoPost as $row): ?>
                    <option value="<?= $row->id ?>"><?= $row->nombre ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3 col-md-12">
            <label for=""><b>Fecha de Postulación <span class="text-danger">Obligatorio</span></b></label>
            <input class="form-control form-control-sm" type="datetime-local" name="fecha_registro_postulante" id="fecha_registro_postulante" required>
        </div>
        <div class="col-md-12">
            <button type="submit" class="btn btn-success w-100">Modificar</button>
        </div>
    </form>
</div>

<!-- ESTO ES EL MODAL VER AVISO -->
<div id="modal_seguiminetoIntermediacion" style="display:none;width:1400px;">
    <h5 class="p-3 bg-success"><b style="color:#fff;">AVISO</b></h5>
    <hr>
    <div class="row">
        <div class="col-md-8">
            <h3 id="title_aviso"></h3>
            <p id="descripcion_aviso"></p>
        </div>
        <div class="col-md-4">
            <h3 id="empresa_aviso"></h3>
            <b>Publicado: </b><span id="publicacion_aviso"></span><br>
            <b>Distrito: </b><span id="distrito_aviso"></span><br>
            <b>Carrera: </b><span id="area_aviso"></span><br>
            <b>Salario: </b><span id="salario_aviso"></span>
        </div>
    </div>
</div>

<!-- ESTO ES EL MODAL DE VER DATOS DE LOS POSTULANTES -->
<div id="modal_ver_data" style="display:none;width:1400px;">
    <h6>Postular Alumnos</h3>
    <div class="row">
        <div class="mb-3 col-md-6">
            <input type="hidden" class="aviso_id_form">
            <input autocomplete="off" type="search" class="form-control form-control-sm" id="buscadorAlumno" name="buscadorAlumno" placeholder="Buscar alumno por dni o por apellido">
            <ul id="searchResults" class="col-md-10"></ul>
        </div>
        <div class="mb-3 col-md-4">
            <button type="submit" id="btn_agregar_potulantes" onclick="AgregarAumnosPostulantes()" class="w-100 btn btn-success btn-sm">Agregar Postulantes</button>
        </div>
    </div>
    <hr>
    <div class="col-ms-12">
        <table class="display responsive no-wrap table table-bordered table-hover table-condensed" width='100%' id='tabla_agre_alumno'>
            <thead>
                <tr>
                    <th>N°</th>
                    <th>ALUMNO</th>
                    <th>DNI</th>
                    <th>TELÉFONO</th>
                    <th>CORREO</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="lista_alumno_agre">
            </tbody>
        </table>
    </div>

    <hr>

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                aria-selected="true">LISTADO DE CANDIDATOS</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">

        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div class="col-12">
                <table
                    class="tablaPostulantesDT display responsive no-wrap table table-bordered table-hover table-condensed TablaListadoPostulantes"
                    width='100%'>
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>ALUMNO</th>
                            <th>DNI</th>
                            <th>TELÉFONO</th>
                            <th>ESTADO</th>
                            <th>CORREO</th>
                            <th>FECHA DE REGISTRO</th>
                            <th>*</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
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
<script src="js/avisos/index.js"></script>
<script>
    $(document).ready(function() {
        /* CKEDITOR.replace( 'mod_form_descripcion' ); */
        /* CKEDITOR.inline( 'mod_form_descripcion' ); */
    });
</script>

