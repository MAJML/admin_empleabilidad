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

<div class="app-page-title app-page-title-simple">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div>
                <div class="page-title-head center-elem">
                    <span class="d-inline-block">| Usuarios</span>
                </div>
                <div class="page-title-subheading opacity-10">
                    <nav class aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a>
                                    <i class="fa-solid fa-graduation-cap"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a> / Usuarios</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>
<div class="d-flex justify-content-end mb-1"> 
    <button type="buttom" class="btn btn-primary" data-fancybox data-src="#modalRegistrarUsuario">Registrar Usuario</button>
</div>
<div class='row card'>
    <div class='col-12 mb-5 card-body'>
        <table id="tablaUsuarios" class="display responsive no-wrap table table-bordered table-hover table-condensed TablaUsuarios" width='100%'>
            <thead class="cabezera_tabla">
                <tr>
                    <th style="width:1px;">N°</th>
                    <th>NOMBRE Y APELLIDO</th>
                    <th>CORREO</th>
                    <th>PERFIL</th>
                    <th>FECHA DE REGISTRO</th>
                    <th>CONECTADOS</th>
                    <th>INICIO DE SESIÓN</th>
                    <th>ULTIMO CIERRE DE SESIÓN</th>
                    <th>*</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<!-- ESTO ES EL MODAL PARA ACTUALIZAR USUARIO -->
<div id="modalEditarData" style="display:none;width:700px;">
    <h5 class="text-center m-3">ACTUALIZAR USUARIO</h5>
    <form action="" class="row" role="form" method="post" id="FormActualizarUsuarios">
        <div class="col-md-6 form-group mt-2">
            <input type="text" class="form-control nombresEdit" name="nombresEdit" placeholder="Nombres" required>
            <input type="hidden" name="idUsuario" class="idUsuario">
        </div>
        <div class="col-md-6 form-group mt-2">
            <input type="text" class="form-control apellidosEdit" name="apellidosEdit" placeholder="Apellidos" required>
        </div>
        <div class="col-md-6 form-group mt-2">
            <input type="email" class="form-control correoEdit" name="correoEdit" placeholder="Correo" required>
        </div>
        <div class="col-md-6 form-group mt-2">
            <select class="form-control perfilEdit" name="perfilEdit" required>
                <option value="" hidden>Perfil</option>
                <option value="Administrador">Administrador</option>
                <option value="Encargado">Encargado</option>
                <option value="Asistente">Asistente</option>
            </select>
        </div>
        <div class="col-md-6 form-group mt-2">
            <input type="password" class="form-control passwordEdit" name="passwordEdit" placeholder="Ingrese nueva Contraseña">
        </div>
        <div class="col-md-12 mt-2 text-center">
            <button type="submit" class="btn btn-success">Actualizar</button>
        </div>
    </form>
</div>

<!-- ESTO ES EL MODAL PARA REGISTRAR USUARIO -->
<div id="modalRegistrarUsuario" style="display:none;width:700px;">
    <h5 class="text-center m-3">REGISTRAR USUARIO</h5>
    <form action="" class="row" role="form" method="post" id="FormUsuarios">
        <div class="col-md-6 form-group mt-2">
            <input type="text" class="form-control" name="nombres" placeholder="Nombres" required>
        </div>
        <div class="col-md-6 form-group mt-2">
            <input type="text" class="form-control" name="apellidos" placeholder="Apellidos" required>
        </div>
        <div class="col-md-6 form-group mt-2">
            <input type="email" class="form-control" name="correo" placeholder="Correo" required>
        </div>
        <div class="col-md-6 form-group mt-2">
            <select class="form-control" name="perfil" id="" required>
                <option value="" hidden>Perfil</option>
                <option value="Administrador">Administrador</option>
                <option value="Encargado">Encargado</option>
                <option value="Asistente">Asistente</option>
            </select>
        </div>
        <div class="col-md-6 form-group mt-2">
            <input type="password" class="form-control" name="password" placeholder="Ingrese una Contraseña" required>
        </div>
        <div class="col-md-12 mt-2 text-center">
            <button type="submit" class="btn btn-success">Registrar</button>
        </div>
    </form>
</div>

<!-- LIBRERIA DATATABLES -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap4.min.js"></script>

<!-- APP JS -->
<script type="text/javascript" src="<?= $baseUrl ?>assets/scripts/main.d810cf0ae7f39f28f336.js"></script>
<script src="js/usuarios/index.js"></script>



