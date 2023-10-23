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
#example2_filter{
    display:none !important;
}
</style>


<div class="main-card mb-3 card">
    <div class="card-header app-page-title text-white pt-5 pb-5">
        <div class="">
            <div class="page-title-wrapper">
                <div class="">
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
                                        <a>Busqueda Rapida Empleadores / .</a>
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
                <form action="" class="col-12 d-flex flex-wrap" role="form" method="post" id="">

                    <div class="mb-2 margen-right col-lg-5 col-md-6 col-sm-12">
                        <input type="search" id="buscarEmpleador" class="form-control form-control-sm fecha1" name='' placeholder="Buscar Empleador por ruc/dni o por nombre Comercial" required>
                    </div>

<!--                     <div class="mb-1 margen-right col-lg-3 col-md-6 col-sm-12">
                        <div>
                            <a href="javascript:void(0)" class="w-100 btn-square btn btn-success ecxel mb-2"
                                id="btnEcxel">
                                <i class="fa-solid fa-file-excel"></i>
                                Exportar Excel
                            </a>
                        </div>
                    </div> -->

                </form>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class='row col-12'>
            <div class='col-12 card-body'>
                <table id=""
                    class="display responsive no-wrap table table-bordered table-hover table-condensed table_dataPJ"
                    width='100%'>
                    <thead class="cabezera_tabla">
                        <tr>
                            <th>N°</th>
                            <th>FECHA REGISTRO</th>
                            <th>RUC/DNI </th>
                            <th>RAZÓN SOCIAL</th>
                            <th>NOMBRE COMERCIAL</th>
                            <th>NOMBRES Y APELLIDOS DEL CONTACTO</th>
                            <th>TELÉFONO DEL CONTACTO</th>
                            <th>EMAIL DEL CONTACTO</th>
                            <th>ESTADO</th>
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
    <h5><b>DATOS DE LA EMPRESA</b></h5>
    <div class='row'>
        <div class="col-4 mb-3">
            <label class="form-label">RUC</label>
            <input type="text" id='ruc' class="form-control form-control-sm" readonly>
        </div>
        <div class="col-4 mb-3">
            <label class="form-label">RAZON SOCIAL</label>
            <input type="text" id='razon_social' class="form-control form-control-sm" readonly>
        </div>
        <div class="col-4 mb-3">
            <label class="form-label">NOMBRE EMPRESA</label>
            <input type="text" id='nombre_empresa' class="form-control form-control-sm" readonly>
        </div>
    </div>
    <div class='row'>
        <div class="col-6 mb-3">
            <label class="form-label">CIUDAD</label>
            <input type="text" id='ciudad' class="form-control form-control-sm" readonly>
        </div>
        <div class="col-6 mb-3">
            <label class="form-label">DISTRITO</label>
            <input type="text" id='distrito' class="form-control form-control-sm" readonly>
        </div>
    </div>
    <div class='row'>
        <div class="col-8 mb-3">
            <label class="form-label">DIRECCION</label>
            <input type="text" id='direcion' class="form-control form-control-sm" readonly>
        </div>
        <div class="col-4 mb-3">
            <label class="form-label">TELEFONO</label>
            <input type="text" id='telefono' class="form-control form-control-sm" readonly>
        </div>
    </div>
    <div class='row'>
        <div class="col-6 mb-3">
            <label class="form-label">E-MAIL</label>
            <input type="text" id='e-mail' class="form-control form-control-sm" readonly>
        </div>
    </div>
    <hr>
    <div class='row'>
        <div class="col-4 mb-3">
            <label class="form-label">NOMRE CONTACTO</label>
            <input type="text" id='nombre_contacto' class="form-control form-control-sm" readonly>
        </div>
        <div class="col-4 mb-3">
            <label class="form-label">TELEFONO CONTACTO</label>
            <input type="text" id='telefono_contacto' class="form-control form-control-sm" readonly>
        </div>
        <div class="col-4 mb-3">
            <label class="form-label">CARGO CONTACTO</label>
            <input type="text" id='cargo_contacto' class="form-control form-control-sm" readonly>
        </div>
    </div>
    <div class='row'>
        <div class="col-4 mb-3">
            <label class="form-label">E-MAIL CONTACTO</label>
            <input type="text" id='e-mail_contacto' class="form-control form-control-sm" readonly>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-6 mb-3">
            <label class="form-label">NOMBRE COMPLETO DEL PACIENTE</label>
            <input type="text" id='nombre_paciente' class="form-control form-control-sm" readonly>
        </div>
        <div class="col-6 mb-3">
            <label class="form-label">ENFERMEDAD DEL PACIENTE</label>
            <input type="text" id='enfermedad_paciente' class="form-control form-control-sm" readonly>
        </div>
    </div>

</div>

<!-- LIBRERIA DATATABLES -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap4.min.js"></script>

<!-- APP JS -->
<script type="text/javascript" src="<?= $baseUrl ?>assets/scripts/main.d810cf0ae7f39f28f336.js"></script>
<script src="js/empleador/personaTodos.js"></script>