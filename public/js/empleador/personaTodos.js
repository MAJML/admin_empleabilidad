
console.log('esto es la seccion de todos los empleadores')
$(document).ready(function() {
    $('#example2').DataTable({
        "language": {
            "lengthMenu": "Mostrar _MENU_ ",
            "zeroRecords": `
            <div class="text-center my-5">
                <object data='${baseurl}img/busqueda.svg' type=''></object>
                <h6>No se encontraron elementos que concuerden con los valores buscados</h6>
            </div>
            `,
            "info": "Mostrando _PAGE_ pagina de _PAGES_",
            "infoEmpty": "",
            "sSearch": "Buscar :",
            oPaginate: {
                sNext: "Siguiente",
                sPrevious: "Anterior"
            }
        }
    });

    /* BUSQUEDA RAPIDA */
    $(document).ready(function() {
        var inputbuscar = $('#buscarEmpleador');
        var searchResults = $('#searchResults'); 
        inputbuscar.on('keyup', function() {
          var searchTerm = inputbuscar.val();
          $.ajax({
            url: 'BR_empleadores/BusquedaRapidaEmpleador',
            method: 'POST',
            dataType:"json",
            data: { data: searchTerm},
            success: function(response) {
              /* console.log("esto es el dato de la busqueda : ",response); */
              var tabla = ""; var fila=1;
                var oTable = $('.table_dataPJ').dataTable();
                oTable.fnClearTable();
                for(var i = 0; i < response.length; i++) {
                    if(response[i]['aprobado'] == 1){
                        var iconValidacion = '<a href="javascript:void(0)" EstadoEmpleador="0" idEmpleador="'+response[i]['id']+'" class="btn_estado_empleador btn btn-outline-primary btn-sm">Activo</a>'
                    }else{
                        var iconValidacion = '<a href="javascript:void(0)" EstadoEmpleador="1" idEmpleador="'+response[i]['id']+'" class="btn_estado_empleador btn btn-outline-danger btn-sm">Inactivo</a>'
                    }
                    var iconVer = '<a href="javascript:void(0)" onclick=verData("'+ response[i]['id'] +'") class="btn btn-outline-success mx-1" data-fancybox data-src="#modal_ver_data" data-width="3000" data-height="400"><i class="fa-solid fa-eye"></i></a>';
                    
                    if(response[i]["tipo_persona"] == 2){
                        var iconEmail = '<a href="javascript:void(0)" class="btn btn-primary" onclick=EnviarEmail("'+ response[i]['email_contacto'] +'")><i class="fa-solid fa-envelope"></i></a>';
                    }else{
                        var iconEmail = '<a href="javascript:void(0)" class="btn btn-primary" onclick=EnviarEmail("'+ response[i]['email'] +'")><i class="fa-solid fa-envelope"></i></a>';
                    }

                    var iconDelete = '<a href="javascript:void(0)" onclick=AlertaEliminar("'+ response[i]['id'] +'") class="btn btn-outline-danger" ><i class="fa-solid fa-trash"></i></a>';
                    var contenIcon = '<div class="d-flex">'+ iconVer + iconDelete +'</div>'
                    oTable.fnAddData([ fila, 
                                       response[i]['created_at'], 
                                       response[i]['ruc'], 
                                       response[i]['razon_social'], 
                                       response[i]['nombre_comercial'],
                                      /*  response[i]["nombre_distritos"], */
                                       response[i]['nombre_contacto']+' '+response[i]['apellido_contacto'],
                                       response[i]['telefono_contacto'], 
                                       response[i]['email_contacto'],
                                       iconValidacion,
                                       contenIcon
                                    ]);
                    fila++;
                }
            }
          });
        });
    });
    /* END BUSQUEDA RAPIDA */

	$(document).on('submit', "#ConsultaPJ", function(event){
		event.preventDefault();
		var data = $(this).serialize();

        var f1 = $(".fecha1").val();
        var f2 = $(".fecha2").val();
        var validacion = $(".validacion").val();
        var tipoPersona = $(".tipoPersona").val();
        $(".ecxel").attr("href", 'PersonaTodos/EsportarExcel/'+ f1 + '/' + f2 + '/' + validacion + '/' + tipoPersona)
        $(".table_dataPJ tbody").empty();
		$.ajax({
			type:"POST",
			dataType:"json",
			url:'PersonaTodos/ConsultaDataPorFecha',
			data:data,
            beforeSend: function() {
                $(".cargador").html(`
                <td colspan=10>
                    <div class="container-tablita">
                        <div class="cargando">
                            <div class="pelotas"></div>
                            <div class="pelotas"></div>
                            <div class="pelotas"></div>
                            <span class="texto-cargando">Cargando...</span>
                        </div>
                    </div>                
                </td>`)
            },
			success:function(response){
                /* console.log('esto es la rpta : ', response) */
                var tabla = ""; var fila=1;
                var oTable = $('.table_dataPJ').dataTable();
                oTable.fnClearTable();
                for(var i = 0; i < response.length; i++) {
                    if(response[i]['aprobado'] == 1){
                        var iconValidacion = '<a href="javascript:void(0)" EstadoEmpleador="0" idEmpleador="'+response[i]['id']+'" class="btn_estado_empleador btn btn-outline-primary btn-sm">Activo</a>'
                    }else{
                        var iconValidacion = '<a href="javascript:void(0)" EstadoEmpleador="1" idEmpleador="'+response[i]['id']+'" class="btn_estado_empleador btn btn-outline-danger btn-sm">Inactivo</a>'
                    }
                    var iconVer = '<a href="javascript:void(0)" onclick=verData("'+ response[i]['id'] +'") class="btn btn-outline-success mx-1" data-fancybox data-src="#modal_ver_data" data-width="3000" data-height="400"><i class="fa-solid fa-eye"></i></a>';
                    
                    if(response[i]["tipo_persona"] == 2){
                        var iconEmail = '<a href="javascript:void(0)" class="btn btn-primary" onclick=EnviarEmail("'+ response[i]['email_contacto'] +'")><i class="fa-solid fa-envelope"></i></a>';
                    }else{
                        var iconEmail = '<a href="javascript:void(0)" class="btn btn-primary" onclick=EnviarEmail("'+ response[i]['email'] +'")><i class="fa-solid fa-envelope"></i></a>';
                    }

                    var iconDelete = '<a href="javascript:void(0)" onclick=AlertaEliminar("'+ response[i]['id'] +'") class="btn btn-outline-danger" ><i class="fa-solid fa-trash"></i></a>';
                    var contenIcon = '<div class="d-flex">'+ iconVer + iconDelete +'</div>'
                    oTable.fnAddData([ fila, 
                                       response[i]['created_at'], 
                                       response[i]['ruc'], 
                                       response[i]['razon_social'], 
                                       response[i]['nombre_comercial'],
                                      /*  response[i]["nombre_distritos"], */
                                       response[i]['nombre_contacto']+' '+response[i]['apellido_contacto'],
                                       response[i]['telefono_contacto'], 
                                       response[i]['email_contacto'],
                                       iconValidacion,
                                       contenIcon
                                    ]);
                    fila++;
                }


			},error:function(){
			console.log("ERROR GENERAL DEL SISTEMA, POR FAVOR INTENTE MÁS TARDE");
			}
		});
	});
    
});

// ACTIVAR Y DESACTIVAR EMPLEADOR
$(document).on("click", ".btn_estado_empleador", function(){
    var idEmpleador =$(this).attr("idEmpleador");
    var EstadoEmpleador =$(this).attr("EstadoEmpleador");
    $.ajax({
        type:"POST",
        dataType:"json",
        url:'PersonaTodos/validacionEmpleador',
        data: {id:idEmpleador, estado:EstadoEmpleador},
        success:function(response){
            console.log('esta es la vlaidacion : ',response)
        },error:function(){
        console.log("ERROR GENERAL DEL SISTEMA, POR FAVOR INTENTE MÁS TARDE");
        }
    });
    if(EstadoEmpleador == 0){
        $(this).removeClass('btn-outline-primary');
        $(this).addClass('btn-outline-danger');
        $(this).html('Inactivo');
        $(this).attr('EstadoEmpleador', 1);
    }else{
        $(this).removeClass('btn-outline-danger');
        $(this).addClass('btn-outline-primary');
        $(this).html('Activo');
        $(this).attr('EstadoEmpleador', 0);
    }

})





function verData(idData)
{
    $.ajax({
        type:"POST",
        dataType:"json",
        url:'PersonaTodos/TraerDataPorID',
        data: {id:idData},
        success:function(response){
            $('#ruc').val(response.ruc)
            $('#razon_social').val(response.razon_social)
            $('#nombre_empresa').val(response.nombre_comercial)
            $('#ciudad').val(response.nombre_provincia)
            $('#distrito').val(response.nombre_distritos)
            $('#direcion').val(response.direccion)
            $('#telefono').val(response.telefono)
            $('#e-mail').val(response.email)
            $('#nombre_contacto').val(response.nombre_contacto +' '+ response.apellido_contacto)
            $('#telefono_contacto').val(response.telefono_contacto)
            $('#cargo_contacto').val(response.cargo_contacto)
            $('#e-mail_contacto').val(response.email_contacto)
            $('#nombre_paciente').val(response.nombre_paciente)
            $('#enfermedad_paciente').val(response.enfermedad_paciente)
        },error:function(){
        console.log("ERROR GENERAL DEL SISTEMA, POR FAVOR INTENTE MÁS TARDE");
        }
    });
}

function AlertaEliminar(idData)
{
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          confirmButton: 'btn btn-success',
          cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
      })
      
      swalWithBootstrapButtons.fire({
        title: '¿Desea eliminar este Registro?',
        text: "Se eliminara el Registro y no se podra recuperar",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si, Eliminar',
        cancelButtonText: 'No, Cancelar!',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed){
          swalWithBootstrapButtons.fire(
            'Eliminado!',
            'Se ha eliminado un registro',
            'success'
          )
          EliminarData(idData)
        } else if (result.dismiss === Swal.DismissReason.cancel){
          swalWithBootstrapButtons.fire(
            'Cancelado',
            'Tu registro está a salvo :)',
            'error'
          )
        }
    })
}

function EliminarData(idData)
{
    $.ajax({
        type:"POST",
        dataType:"json",
        url:'PersonaTodos/EliminarDataID',
        data: {id:idData},
        success:function(response){
            $('.btn_consulta_pj').click();
        },error:function(){
        console.log("ERROR GENERAL DEL SISTEMA, POR FAVOR INTENTE MÁS TARDE");
        }
    });
}

function EnviarEmail(Email)
{
    $.ajax({
        type:"POST",
        dataType:"json",
        url:'PersonaTodos/enviarEmail',
        data: {email:Email},     
        beforeSend: function() {
            let timerInterval
            Swal.fire({
            title: 'Enviando',
            html: 'Espere un momento, por favor',
            didOpen: () => {
                Swal.showLoading()
            },
            willClose: () => {
                clearInterval(timerInterval)
            }
            }).then((result) => {
            if (result.dismiss === Swal.DismissReason.timer) {
                console.log('I was closed by the timer')
            }
            })
        },
        success:function(response){
            console.log('esta es la respuesta : ',response)
            if(response == 'enviado'){
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Enviado correctamente',
                    showConfirmButton: false,
                    timer: 1500
                })
            }else{
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'No se pudo enviar el correo',
                    showConfirmButton: false,
                    timer: 1500
                })
            }
        },error:function(){
        console.log("ERROR GENERAL DEL SISTEMA, POR FAVOR INTENTE MÁS TARDE");
        }
    });
}