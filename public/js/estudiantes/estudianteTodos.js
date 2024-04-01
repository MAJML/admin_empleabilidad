
console.log('esto a consola de Todos los Estudiantes alumno ya esta actualizado')
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
            "oPaginate": {
                sNext: "Siguiente",
                sPrevious: "Anterior"
            },
            "columnDefs": [{
                "defaultContent": "-",
                "targets": "_all"
              }],
        }
    });

    /* BUSQUEDA RAPIDA */
    $(document).ready(function() {
        var inputbuscar = $('#buscarEstudiante');
        var searchResults = $('#searchResults'); 
        inputbuscar.on('keyup', function() {
            var searchTerm = inputbuscar.val();
            $.ajax({
            url: 'BR_estudiantes/BusquedaRapidaEstudiantes',
            method: 'POST',
            dataType:"json",
            data: { data: searchTerm},
            success: function(response) {
                /* console.log("esto es el dato de la busqueda del estudiante : ",response); */
                var tabla = ""; var fila=1;
                var oTable = $('.table_Estudiantes').dataTable();
                oTable.fnClearTable();
                for(var i = 0; i < response.length; i++) {
                    var iconVer = '<a href="javascript:void(0)" onclick=verDataCV("'+ response[i]['id'] +'") class="btn btn-outline-primary mx-1" data-fancybox data-src="#modal_ver_data" data-width="3000" data-height="400"><i class="fa-solid fa-file"></i></a>';
                    var iconDelete = '<a href="javascript:void(0)" onclick=AlertaEliminar("'+ response[i]['id'] +'") class="btn btn-outline-danger" ><i class="fa-solid fa-trash"></i></a>';
                    oTable.fnAddData([ fila, 
                                       response[i]['created_at'], 
                                       response[i]['dni'], 
                                       response[i]['apellidos'], 
                                       response[i]['nombres'],
                                       response[i]['nombre_distritos'],
                                       response[i]['telefono'], 
                                       response[i]['email'],
                                       response[i]['nombre_area'],
                                       '<div class="d-flex">'+iconVer + iconDelete+'</div>'
                                    ]);
                    fila++;
                }
            }
            });
        });
    });
    /* END BUSQUEDA RAPIDA */

    $(document).on('submit', "#ConsultaPJ", function(event) {
        event.preventDefault();
        var $fecha1 = $(".fecha1"),
            $fecha2 = $(".fecha2"),
            $validacion = $(".validacion"),
            $tipoEstudiante = $(".tipoEstudiante"),
            $ecxel = $(".ecxel"),
            $tableEstudiantes = $(".table_Estudiantes"),
            $cargador = $(".cargador");
        var data = $(this).serialize();
        var f1 = $fecha1.val(),
            f2 = $fecha2.val(),
            validacion = $validacion.val(),
            tipoEstudiante = $tipoEstudiante.val();
        $ecxel.attr("href", 'EstudianteTodos/EsportarExcel/' + f1 + '/' + f2 + '/' + tipoEstudiante + '/' + validacion);
        $tableEstudiantes.find('tbody').empty();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: 'EstudianteTodos/ConsultaDataPorFecha',
            data: data,
            beforeSend: function() {
                $cargador.html(`
                    <td colspan=10>
                        <div class="container-tablita">
                            <div class="cargando">
                                <div class="pelotas"></div>
                                <div class="pelotas"></div>
                                <div class="pelotas"></div>
                                <span class="texto-cargando">Cargando...</span>
                            </div>
                        </div>                
                    </td>`);
            },
            success: function(response) {
                /* console.log('esto es la rpta a: ', response); */
                var oTable = $tableEstudiantes.DataTable();
                oTable.clear().draw();
                var fila = 1;
                response.forEach(function(item) {
                    var iconVer = `<a href="javascript:void(0)" onclick=verDataCV("${item.id}") class="btn btn-outline-primary mx-1" data-fancybox data-src="#modal_ver_data" data-width="3000" data-height="400"><i class="fa-solid fa-file"></i></a>`;
                    var iconDelete = `<a href="javascript:void(0)" onclick=AlertaEliminar("${item.id}") class="btn btn-outline-danger" ><i class="fa-solid fa-trash"></i></a>`;
                    // Agregar datos a la tabla utilizando el método DataTables row.add()
                    oTable.row.add([
                        fila,
                        item.created_at,
                        item.dni,
                        item.apellidos,
                        item.nombres,
                        item.nombre_distritos,
                        item.telefono,
                        item.email,
                        item.nombre_area,
                        `<div class="d-flex">${iconVer}${iconDelete}</div>`
                    ]);
                    fila++;
                });
                oTable.draw();  
            },
            error: function() {
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
        url:'EstudianteTodos/validacionEmpleador',
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


function verDataCV(idData)
{
    $("#cvViewAlumno").attr('src','EstudianteTodos/PdfCV/'+idData)
/*     $.ajax({
        type:"POST",
        dataType:"json",
        url:'EstudianteTodos/PdfCV',
        data: {id:idData},
        success:function(response){
            console.log("este es el Modal del cv ", response)
        }
    }); */
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
        url:'EstudianteTodos/EliminarDataID',
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
        url:'EstudianteTodos/enviarEmail',
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