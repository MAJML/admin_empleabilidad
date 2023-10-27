console.log("esto es la consola registro estudiantes");

busquedaAlumno()
ConsultarListaCuentasCreadas()

$(document).on('submit', "#form_crear_alumno", function(event){
    event.preventDefault();
    var data = $(this).serialize();
    $.ajax({
        type:"POST",
        dataType:"json",
        url: baseurl+'BR_estudiantes/CrearCuentaAlumno',
        data:data,
        success:function(response){
            /* console.log("esto es la consola crear usuario alumno : ", response) */
            if(response == "ok"){
                ConsultarListaCuentasCreadas()
                $("#form_crear_alumno").trigger("reset");
                $("#distrito option").remove();
                $("#form_crear_alumno #campos_formulario").prop('hidden', true)
                $("#form_crear_alumno").append(`
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
                `)
                $("#crear_otra_cuenta").on("click", function(){
                    $("#validationDni").html("Ingrese su dni para autocompletar su información.").removeClass("text-success").addClass("text-danger")
                    $("#form_crear_alumno").trigger("reset");
                    $("#distrito option").remove();
                    $("#form_crear_alumno #alerta_alumno_creado").remove()
                    $("#form_crear_alumno #campos_formulario").prop('hidden', false)
                    console.log("esto es la consola de crear otra cuenta");
                })
            }else{
                console.log('no se ha podido crear');
            }
        }
    });
});

$("#btn_reiniciar").on("click", function(){
    $("#validationDni").html("Ingrese su dni para autocompletar su información.").removeClass("text-success").addClass("text-danger")
    $("#form_crear_alumno").trigger("reset");
    $("#distrito option").remove();
})

$("#departamento").change(function(){
    $.ajax({
        type:"POST",
        dataType:"json",
        url: baseurl+'BR_estudiantes/consultarDistrito',
        data: {id:$("#departamento").val()},
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
        url: baseurl+'BR_estudiantes/ListaCuentaCreadas',
        beforeSend:function(){
            $("#lista_cuentas_creadas li").remove()
        },
        success:function(response){
          /* console.log("response lista cuenta creadas : ", response); */
          for (let i = 0; i < response.length; i++) {
             hora = new Date(response[i]['created_at'])
            if(response[i]['grado'] == 'Estudiante'){
                var alert = '<div class="badge badge-success ml-2">'+response[i]['grado']+'</div>';
            }else if (response[i]['grado'] == 'Egresado'){
                var alert = '<div class="badge badge-info ml-2">'+response[i]['grado']+'</div>';
            }else if(response[i]['grado'] == 'Titulado'){
                var alert = '<div class="badge badge-warning ml-2">'+response[i]['grado']+'</div>';
            }
            html = '<li class="list-group-item">';
            html += '<div class="todo-indicator bg-success"></div>';
            html += '<div class="widget-content p-0">';
            html += '<div class="widget-content-wrapper">';
            html += '<div class="widget-content-left">';
            html += '<div class="widget-heading">'+response[i]['apellidos'];
            html += alert;
            html += '</div>';
            html += '<div class="widget-subheading"><i>'+response[i]['areas']+' | '+response[i]['distritos'].toUpperCase()+'</i></div>';
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


function busquedaAlumno()
{
    $("#dni_buscar_alumnos").keyup(function(){
        const dni = $("#dni_buscar_alumnos");
        if($(dni).val().length >= 8){
            $.ajax({
                url: "https://istalcursos.edu.pe/apirest/alumnos",
                type: "POST",
                data: {
                    documento : $(this).val()
                },
                dataType : "json",
                beforeSend:function(){
                    $("#nombre").val("")
                    $("#apellido").val("")
                    $("#telefono").val("")
                    $("#correo").val("")
                    $("#nacimiento").val("")
                },
                success: function (res) {
                    /* console.log(res) */
                    if(res.message == "consulta satisfactoria"){
                        const data = res.data[0];
                        $("#nombre").val(data.NombreAlumno)
                        $("#apellido").val(data.Apellidos)
                        $("#telefono").val(data.celular.replace(/ /g, ""))                  
                        $("#correo").val(data.email)
                        $("#nacimiento").val( data.nacimiento.substring(0,4)+"-"+data.nacimiento.substring(5,7)+"-"+data.nacimiento.substring(8,10) )
                        $("#validationDni").html("Dni correcto.").removeClass("text-danger").addClass("text-success")
                        verificarAlumnoRepetido(data.DNI)
                    }else if(res.message == "No se encontraron coincidencias con el documento ingresado"){
                        $("#nombre").val("")
                        $("#apellido").val("")
                        $("#telefono").val("")
                        $("#correo").val("")
                        $("#nacimiento").val("")
                        $("#validationDni").html("El dni no existe en nuestros registros.").removeClass("text-success").addClass("text-danger")
                    }
                }
            });
        }
    })
}

function verificarAlumnoRepetido(dni)
{
    $.ajax({
        type:"POST",
        dataType:"json",
        url: baseurl+'BR_estudiantes/verificarAlumno',
        data: {dni:dni},
        success:function(response){
            if(response.length >= 1){
                $("#dni_buscar_alumnos").val("")
                $("#nombre").val("")
                $("#apellido").val("")
                $("#telefono").val("")
                $("#correo").val("")
                $("#nacimiento").val("")
                $("#validationDni").html("El dni ya existe en nuestros registros.").removeClass("text-success").addClass("text-danger")
            }
        }
    });
}