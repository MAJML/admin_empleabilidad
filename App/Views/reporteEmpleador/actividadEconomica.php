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
                            <span class="d-inline-block">| Reporte Empleador por Actividad Económica</span>
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
                                        <a>Reporte Empleador / Actividad Económica</a>
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
            <div
                class="col-12 d-flex flex-wrap justify-content-sm-center justify-content-lg-start justify-content-center w-100 p-1">
                <form action="" class="d-flex flex-wrap col-12" role="form" method="post" id="ConsultaActividadEconomica">

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


                    <div class="mb-2 margen-right col-md-3">
                        <label for="" class="achicar-bottom"><b>TIPO DE EMPLEADOR :</b></label>
                        <select class="form-control form-control-sm input-xs validacion" name='validacion' required>
                            <option value="and EM.tipo_persona=1">PERSONA JURÍDICA</option>
                            <option value="and EM.tipo_persona=2">PERSONA NATURAL</option>
                            <option value="and EM.tipo_persona=3">PERSONA NATURAL CON NEGOCIO</option>
                            <option value="and EM.tipo_persona in(1,2,3)" selected>TODOS</option>
                        </select>
                    </div>
                    <div class="mb-1 margen-right ancho_caja_input col-md-3">
                        <label for="" class="achicar-bottom"></label>
                        <div>
                            <button type="submit"
                                class="w-100 btn-square btn btn-primary btn-flat consultar_graficos btn_consultar_form" id="">
                                <i class="fa-solid fa-magnifying-glass"></i> Consultar
                            </button>
                        </div>
                    </div>

                    <div class="mb-1 margen-right ancho_caja_input col-md-3">
                        <div>
                            <a href="javascript:void(0)" class="w-100 btn-square btn btn-success ecxel mb-2" id="btnEcxel">
                                <i class="fa-solid fa-file-excel"></i>
                                Exportar Excel
                            </a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
    
    <div class="card-footer">
        <div class="row col-12">
            <div class="col-12">
                <table id="TableReporte" class="display responsive no-wrap table table-bordered table-hover table-condensed tabladatosREactividadEco"
                    width='100%'>
                    <thead class="cabezera_tabla">
                        <tr>
                            <th>N°</th>
                            <th>FECHA REGISTRO</th>
                            <th>TIPO DE PERSONA</th>
                            <th>RUC</th>
                            <th>RAZON SOCIAL</th>
                            <th>NOMBRE COMERCIAL</th>
                            <th>CIIU</th>
                        </tr>
                    </thead>
                    <tbody class="cargador" style="text-transform: uppercase;">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card-footer">
        <div class="row col-12">
            <div class="col-12">
                <table id="TableCantidadCIIU" class="display responsive no-wrap table table-bordered table-hover table-condensed tablitaContadorCiiu"
                width='100%'>
                    <thead class="cabezera_tabla">
                        <tr>
                            <th>N°</th>
                            <th>ACTIVIDAD ECONOMICA CIIU</th>
                            <th>CANTIDAD POR ACTIVIDAD</th>
                        </tr>
                    </thead>
                    <tbody class="cargadorCIIU">
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan=2 class="text-right">TOTAL : </th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
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
<script src="js/reporteEmpleador/ActividadEconomica.js"></script>