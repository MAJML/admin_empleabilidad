console.log("esto es la consola registro empleadores");

busquedaRucEmpleadores()
busquedaDniEmpleador()
ConsultarListaCuentasCreadas()

$("#form_crear_personaJuridica").on("submit", function(event) {
    event.preventDefault();
    var data = $(this).serialize();
    $.ajax({
        type:"POST",
        dataType:"json",
        url: baseurl+'BR_empleadores/CrearCuentaEmpleadores',
        data:data,
        success:function(response){
            console.log("esto es la consola crear BR_empleadores  : ", response)
            if(response == "ok"){
                ConsultarListaCuentasCreadas()
                location.reload();
                $("#form_crear_personaJuridica").trigger("reset");
                $("#distrito option").remove();
/*                 $("#form_crear_personaJuridica #campos_formulario_personaJuridica").prop('hidden', true)
                $("#form_crear_personaJuridica").append(`
                <div id="alerta_alumno_creado">
                <div class="no-results">
                    <div class="swal2-icon swal2-success swal2-animate-success-icon">
                        <div class="swal2-success-circular-line-left"
                            style="background-color: rgb(255, 255, 255);"></div>
                        <span class="swal2-success-line-tip"></span>
                        <span class="swal2-success-line-long"></span>
                        <div class="swal2-success-ring"></div>
                        <div class="swal2-success-fix"
                            style="background-color: rgb(255, 255, 255);"></div>
                        <div class="swal2-success-circular-line-right"
                            style="background-color: rgb(255, 255, 255);"></div>
                    </div>
                    <div class="results-subtitle mt-4">Listo!</div>
                    <div class="results-title">Cuenta Creada</div>
                    <div class="mt-3 mb-3"></div>
                    <div class="text-center">
                        <a class="btn-shadow btn-wide btn btn-success btn-lg text-white" id="crear_otra_cuenta">Crear otra cuenta</a>
                    </div>
                </div>
                </div>
                `) */
/*                 $("#crear_otra_cuenta").on("click", function(){
                    $("#validationRuc").html("Ingrese su RUC para autocompletar los datos.").removeClass("text-success").addClass("text-danger")
                    $("#form_crear_personaJuridica").trigger("reset");
                    $("#distrito option").remove();
                    $("#form_crear_personaJuridica #alerta_alumno_creado").remove()
                    $("#form_crear_personaJuridica #campos_formulario_personaJuridica").prop('hidden', false)
                    console.log("esto es la consola de crear otra cuenta");
                }) */
            }else{
                console.log('no se ha podido crear');
            }
        }
    });
});

$("#SectPersonaNatural").on("click", function(){
    $("#actividad_economica").prop('required', false)
    $("#form_crear_personaJuridica").trigger("reset");
    $("#ruc").prop('hidden', true).prop('required', false).prop('name','')
    $("#dni").prop('hidden', false).prop('required', true).prop('name','ruc')
    $("#tipo_persona").val(2)
    $("#titulo_datos_empresa p b").html('DATOS GENERALES:')
    $("#validationRuc").html("Ingrese su DNI para autocompletar los datos.").removeClass("text-success").addClass("text-danger")

    $("#input_nombreCormercial").removeClass("col-md-6").addClass("col-md-7")
    $("#input_nombreCormercial label b").html('Nombre de la Persona Natural')
    $("#input_direccion label b").html('Dirección.')

    $("#input_nombreEmpresa").prop('hidden', true).prop('required', false)
    $("#input_razonSocial").prop('hidden', true).prop('required', false)
    $("#input_actividadEconomica").prop('hidden', true).prop('required', false)
    $("#input_telefonoEmpresa").prop('hidden', true).prop('required', false)
    $("#input_correoEmpresa").prop('hidden', true).prop('required', false)
    $("#input_nombresContacto").prop('hidden', true).prop('required', false)
    $("#input_cargoContacto").prop('hidden', true).prop('required', false)

    $("#titulo_dataPaciente").prop('hidden', false).prop('required', true)
    $("#input_nombrePaciente").prop("hidden", false).prop('required', true)
    $("#input_enfermedadPaciente").prop("hidden", false).prop('required', true)
})

$("#SectPersonaJuridica").on("click", function(){
    $("#actividad_economica").prop('required', true)
    $("#ruc").prop('hidden', false).prop('required', true).prop('name','ruc')
    $("#dni").prop('hidden', true).prop('required', false).prop('name','')
    $("#form_crear_personaJuridica").trigger("reset");
    $("#tipo_persona").val(1)
    $("#titulo_datos_empresa p b").html('DATOS DE LA EMPRESA:')
    $("#validationRuc").html("Ingrese su RUC para autocompletar los datos.").removeClass("text-success").addClass("text-danger")

    $("#input_nombreCormercial").removeClass("col-md-7").addClass("col-md-6")
    $("#input_nombreCormercial label b").html('Nombre Comercial.')
    $("#input_direccion label b").html('Dirección exacta de la Empresa.')

    $("#input_nombreEmpresa").prop('hidden', false).prop('required', true)
    $("#input_razonSocial").prop('hidden', false).prop('required', true)
    $("#input_actividadEconomica").prop('hidden', false).prop('required', true)
    $("#input_telefonoEmpresa").prop('hidden', false).prop('required', true)
    $("#input_correoEmpresa").prop('hidden', false).prop('required', false)
    $("#input_nombresContacto").prop('hidden', false).prop('required', true)
    $("#input_cargoContacto").prop('hidden', false).prop('required', true)

    $("#titulo_dataPaciente").prop('hidden', true).prop('required', false)
    $("#input_nombrePaciente").prop("hidden", true).prop('required', false)
    $("#input_enfermedadPaciente").prop("hidden", true).prop('required', false)
})

$("#SectPersonaNaturalNegocio").on("click", function(){
    $("#actividad_economica").prop('required', true)
    $("#ruc").prop('hidden', false).prop('required', true).prop('name','ruc')
    $("#dni").prop('hidden', true).prop('required', false).prop('name','')
    $("#tipo_persona").val(3)
    $("#form_crear_personaJuridica").trigger("reset");
    $("#titulo_datos_empresa p b").html('DATOS GENERALES:')
    $("#validationRuc").html("Ingrese su RUC para autocompletar los datos.").removeClass("text-success").addClass("text-danger")

    $("#input_nombreCormercial").removeClass("col-md-7").addClass("col-md-6")
    $("#input_nombreCormercial label b").html('Nombre Comercial.')
    $("#input_direccion label b").html('Dirección exacta de la Empresa.')

    $("#input_nombreEmpresa").prop('hidden', false).prop('required', true)
    $("#input_razonSocial").prop('hidden', false).prop('required', true)
    $("#input_actividadEconomica").prop('hidden', false).prop('required', true)
    $("#input_telefonoEmpresa").prop('hidden', true).prop('required', false)
    $("#input_correoEmpresa").prop('hidden', true).prop('required', false)
    $("#input_nombresContacto").prop('hidden', false).prop('required', true)
    $("#input_cargoContacto").prop('hidden', true).prop('required', false)

    $("#titulo_dataPaciente").prop('hidden', true).prop('required', false)
    $("#input_nombrePaciente").prop("hidden", true).prop('required', false)
    $("#input_enfermedadPaciente").prop("hidden", true).prop('required', false)
})


$("#btn_reiniciar").on("click", function(){
    $("#validationRuc").html("Ingrese su RUC para autocompletar los datos.").removeClass("text-success").addClass("text-danger")
    $("#form_crear_personaJuridica").trigger("reset");
    $("#distrito option").remove();
})

$("#ciudad").change(function(){
    $.ajax({
        type:"POST",
        dataType:"json",
        url: baseurl+'BR_estudiantes/consultarDistrito',
        data: {id:$("#ciudad").val()},
        beforeSend:function(){
            $("#distrito option").remove()
        },
        success:function(response){
          for (let i = 0; i < response.length; i++) {
            $("#distrito").append('<option value='+response[i]['id']+'>'+response[i]['nombre']+'</option>');
          }
        }
    });
});


function ConsultarListaCuentasCreadas()
{
    $.ajax({
        dataType:"json",
        url: baseurl+'BR_empleadores/ListaCuentaCreadas',
        beforeSend:function(){
            $("#lista_cuentas_creadas li").remove()
        },
        success:function(response){
          /* console.log("response lista cuenta creadas empleadores : ", response); */
          for (let i = 0; i < response.length; i++) {
            hora = new Date(response[i]['created_at'])

            if(response[i]['tipo_persona'] == 'Persona Juridica'){
                var alert = '<div class="badge badge-success ml-2">'+response[i]['tipo_persona']+'</div>';
            }else if (response[i]['tipo_persona'] == 'Persona Natural'){
                var alert = '<div class="badge badge-info ml-2">'+response[i]['tipo_persona']+'</div>';
            }else if(response[i]['tipo_persona'] == 'Persona Natural con Empresa'){
                var alert = '<div class="badge badge-warning ml-2">'+response[i]['tipo_persona']+'</div>';
            }
            html = '<li class="list-group-item">';
            html += '<div class="todo-indicator bg-success"></div>';
            html += '<div class="widget-content p-0">';
            html += '<div class="widget-content-wrapper">';
            html += '<div class="widget-content-left">';
            html += '<div class="widget-heading">'+response[i]['ruc'];
            html += alert;
            html += '</div>';
            html += '<div class="widget-subheading"><i>'+response[i]['nombre_comercial']+'</i></div>';
            html += '</div>';
            html += '<div class="widget-content-right">';
            html += '<div class="widget-subheading"><i>hoy a las '+hora.getHours()+':'+hora.getMinutes()+'</i></div>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '</li>';
            $("#lista_cuentas_creadas").append(html)
          }
        }
    });
}

function busquedaDniEmpleador()
{
    $("#dni").keyup(function(){
        const dni = $(".buscador_dni");
        if($(dni).val().length >= 8){
            $.ajax({
                type:"POST",
                dataType:"json",
                url: baseurl+'BR_empleadores/BuscarEmpleadorDni',
                data: {dni:$(dni).val()},
                beforeSend:function(){
                    $("#nombre_empresa").val("")
                    $("#nombre_comercial").val("")
                    $("#razon_social").val("")
                    $("#direccion").val("")
                    $("#referencia").val("")
                },
                success:function(response){
                    if(response.success == true){
                        $("#nombre_comercial").val(response.data['nombre_completo'])
                        $("#validationRuc").html("DNI correcto.").removeClass("text-danger").addClass("text-success")
                        verificarRucRepetido($(dni).val())
                    }else{
                        $("#nombre_empresa").val("")
                        $("#nombre_comercial").val("")
                        $("#razon_social").val("")
                        $("#direccion").val("")
                        $("#referencia").val("")
                        $("#validationRuc").html("El DNI no existe.").removeClass("text-success").addClass("text-danger")
                    }
                    /* console.log("estyo es el response busqueda dni : ",response); */
                }
            });
        }
    })
}

function busquedaRucEmpleadores()
{
    $("#ruc").keyup(function(){
        const ruc = $(".buscador_ruc");
        if($(ruc).val().length >= 11){
            $.ajax({
                type:"POST",
                dataType:"json",
                url: baseurl+'BR_empleadores/BuscarEmpleadorRuc',
                data: {ruc:$(ruc).val()},
                beforeSend:function(){
                    $("#nombre_empresa").val("")
                    $("#nombre_comercial").val("")
                    $("#razon_social").val("")
                    $("#direccion").val("")
                    $("#referencia").val("")
                },
                success:function(response){
                    if(response.success == true){
                        /* console.log("consulta satisfactoria"); */
                        $("#nombre_empresa").val(response.data['nombre_o_razon_social'])
                        $("#nombre_comercial").val(response.data['nombre_o_razon_social'])
                        $("#razon_social").val(response.data['nombre_o_razon_social'])
                        $("#direccion").val(response.data['direccion_completa'])
                        $("#referencia").val(response.data['direccion'])
                        $("#validationRuc").html("RUC correcto.").removeClass("text-danger").addClass("text-success")
                        verificarRucRepetido($(ruc).val())
                    }else{
                        /* console.log("no se encontro la consulta"); */
                        $("#nombre_empresa").val("")
                        $("#nombre_comercial").val("")
                        $("#razon_social").val("")
                        $("#direccion").val("")
                        $("#referencia").val("")
                        $("#validationRuc").html("El RUC no existe.").removeClass("text-success").addClass("text-danger")
                    }
                    /* console.log("estyo es el response busqueda ruc : ",response); */
                }
            });
        }
    })
}

function verificarRucRepetido(ruc)
{
    $.ajax({
        type:"POST",
        dataType:"json",
        url: baseurl+'BR_empleadores/VerificarRucRepetido',
        data: {ruc:ruc},
        success:function(response){
            /* console.log("response : ",response); */
            if(response.length >= 1){
                $("#nombre_empresa").val("")
                $("#nombre_comercial").val("")
                $("#razon_social").val("")
                $("#direccion").val("")
                $("#referencia").val("")
                $("#validationRuc").html("El documento ya se encuentra en nuestros registros.").removeClass("text-success").addClass("text-danger")
            }
        }
    });
}