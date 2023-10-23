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
</style>

<div class="main-card mb-3 card">
    <div class="card-header app-page-title text-white pt-5 pb-5">
        <div class="">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div>
                        <div class="page-title-head center-elem">
                            <span class="d-inline-block">| Reporte del Seguimiento al Postulante</span>
                        </div>
                        <div class="page-title-subheading opacity-10">
                            <nav class aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a>
                                            <i class="fa-solid fa-building"></i>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a>Reporte / Seguimiento al Postulante</a>
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
                <form action="" class="d-flex flex-wrap col-12" role="form" method="post" id="ConsultaEmpleadorValidacion">

                    <div class="mb-2 margen-right col-md-3">
                        <label for="" class="achicar-bottom"><b>DESDE :</b></label>
                        <input type="date" class="form-control form-control-sm fecha1" name='fecha_inicial'
                            value="<?= date('Y-m-d'); ?>" required>
                    </div>

                    <div class="mb-2 margen-right col-md-3">
                        <label for="" class="achicar-bottom"><b>HASTA :</b></label>
                        <input type="date" class="form-control form-control-sm fecha2" name='fecha_final'
                            value="<?= date('Y-m-d'); ?>" required>
                    </div>

                    <!-- PROGRAMA DE ESTUDIO -->
                    <div class="mb-2 margen-right col-md-3">
                        <label for="" class="achicar-bottom"><b>PROGRAMA DE ESTUDIO :</b></label>
                        <select class="form-control form-control-sm input-xs programa_estudio" name='programa_estudio' required>
                            <option value="and AL.area_id in(1)">ENFERMERIA TÉCNICA</option>
                            <option value="and AL.area_id in(2)">TÉCNICA EN FARMACIA</option>
                            <option value="and AL.area_id in(3)">TÉCNICA EN FISIOTERAPIA</option>
                            <option value="and AL.area_id in(4)">LABORATORIO CLÍNICO</option>
                            <option value="and AL.area_id in(5)">PRÓTESIS DENTAL</option>
                            <option value="and AL.area_id in(1,2,3,4,5)" selected>TODOS</option>
                        </select>
                    </div>

                    <!-- GRADO ACADEMICO -->
                    <div class="mb-2 margen-right col-md-3">
                        <label for="" class="achicar-bottom"><b>GRADO ACADÉMICO :</b></label>
                        <select class="form-control form-control-sm input-xs grado_academico" name='grado_academico' required>
                            <option value=" and AL.egresado in(0)">ESTUDIANTE</option>
                            <option value=" and AL.egresado in(1)">EGRESADOS</option>
                            <option value=" and AL.egresado in(2)">TITULADOS</option>
                            <option value=" and AL.egresado in(0,1,2)" selected>TODOS</option>
                        </select>
                    </div>

                    <div class="mb-1 margen-right ancho_caja_input col-md-3">
                        <div>
                            <button type="submit"
                                class="w-100 btn-square btn btn-primary btn-flat consultar_graficos btn_consultar_form" id="">
                                <i class="fa-solid fa-magnifying-glass"></i> Consultar
                            </button>
                        </div>
                    </div>

                    <div class="margen-right ancho_caja_input col-md-3">
                        <div>
                            <a href="javascript:void(0)" class="w-100 btn-square btn btn-success ecxel" id="btnEcxel">
                                <i class="fa-solid fa-file-excel"></i>
                                Exportar Excel
                            </a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <div class="card-footer justify-content-center">
        <div class="row col-md-12">
            <div class="col-md-12 mb-3">
                <div class="card">
                    <div class="card-header app-page-title text-white">
                        GRÁFICO POSTULANTE POR ACTIVIDAD ECONÓMICA
                    </div>
                    <div class="card-body">
                        <figure class="highcharts-figure">
                            <div id="container"></div>
                            <div class="total_juridica"></div>
                            <div class="total_natural"></div>
                            <div class="total_negocio"></div>
                        </figure>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="card-footer justify-content-center">
        <div class="row col-md-12">
            <div class="p-0 card col-md-12">

                <div class="card-header app-page-title text-white">
                    DETALLE DE LOS ESTUDIANTES QUE POSTULARON A LOS AVISOS
                </div>

                <div class="card-body">
                    <table id="TableValidacion" class="display responsive no-wrap table table-bordered table-hover table-condensed TableValidacion"
                    width='100%'>
                        <thead class="cabezera_tabla">
                            <tr>
                                <th style="width:10px;">N°</th>
                                <th>APELLIDOS</th>
                                <th>NOMBRES</th>
                                <th>DISTRITO DEL POSTULANTE</th>
                                <th>VER POSTULACIONES</th>
                            </tr>
                        </thead>
                        <tbody class="cargador" style="text-transform: uppercase;">
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2"><b>TOTAL DE REGISTROS : </b><span id="total_register"></span></th>
                            </tr> 
                        </tfoot>
                    </table>                    
                </div>
                
            </div>
        </div>
    </div>
</div>



<!-- ESTO ES EL MODAL PARA VER LAS POSTULACIONES DEL ESTUDIANTE-->
<div id="modal_seguiminetoPostulacion" style="display:none;width:1400px;">
    <h5 class="text-start m-3" id="titulo_modal_Post" style="text-transform: uppercase;"></h5>
    <hr>
    <div class='row'>
        <div class='col-12 mb-5'>
            <table id="TablePostulaciones"
                class="TablePostulaciones display responsive no-wrap table table-bordered table-hover table-condensed"
                width='100%'>
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>FECHA DE POSTULACIÓN</th>
                        <th>TÍTULO DE OFERTA</th>
                        <th>RUC / DNI</th>
                        <th>RAZÓN SOCIAL / NOMBRE COMPLETO</th>
                        <th>NOMBRE COMERCIAL</th>
                        <th>ESTADO</th>
                    </tr>
                </thead>
                <tbody style="text-transform: uppercase;">
                </tbody>
            </table>
        </div>
    </div>
</div>




<!-- LIBRERIA DATATABLES -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap4.min.js"></script>

<!-- APP JS -->
<script type="text/javascript" src="<?= $baseUrl ?>assets/scripts/main.d810cf0ae7f39f28f336.js"></script>
<script src="js/reporteEstudiantes/seguimientoPostulante.js"></script>