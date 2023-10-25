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
                        <div class="page-title-subheading opacity-10">
                            <nav class aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a>
                                            <i class="fa-solid fa-users"></i>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a>Busqueda Rapida Estudiante / .</a>
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
                <form action="" class="d-flex flex-wrap col-12 justify-content-between" role="form" method="post" id="">

                    <div class="mb-2 col-lg-5 col-md-6 col-sm-12">
                        <input type="search" class="form-control form-control-sm fecha1" name='' id="buscarEstudiante" placeholder="Buscar Estudiante por DNI o por Apellido" required>
                    </div>

                    <div class="col-lg-2">
                        <a href="" class="btn btn-outline-primary"><i class="fa fa-plus" aria-hidden="true"></i> Crear cuenta al Estudiante</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class='row col-12'>
            <div class='col-12 mb-5'>
                <table id=""
                    class="display responsive no-wrap table table-bordered table-hover table-condensed table_Estudiantes"
                    width='100%'>
                    <thead class="cabezera_tabla">
                        <tr>
                            <th>N°</th>
                            <th>Fecha Registro</th>
                            <th>DNI</th>
                            <th>APELLIDOS</th>
                            <th>NOMBRES</th>
                            <th>DISTRITO</th>
                            <th>TELÉFONO</th>
                            <th>CORREO</th>
                            <th>PROGRAMA DE ESTUDIO</th>
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


<!-- ESTO ES EL MODAL DE VER DATOS -->
<div id="modal_ver_data" style="display:none;width:1400px;">
    <iframe id="cvViewAlumno" src="" frameborder="0" width="100%" height="700px"></iframe>
</div>

<!-- LIBRERIA DATATABLES -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap4.min.js"></script>

<!-- APP JS -->
<script type="text/javascript" src="<?= $baseUrl ?>assets/scripts/main.d810cf0ae7f39f28f336.js"></script>
<script src="js/estudiantes/estudianteTodos.js"></script>