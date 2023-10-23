
console.log('esto es consola de avisos')
var arraySelectAlumno = []
$(document).ready(function() {
    $('.tablaPostulantesDT').DataTable({
        "language": {
            "lengthMenu": "Mostrar _MENU_ ",
            "zeroRecords": `
            <div class="text-center my-5">
                <object data='${baseurl}img/icon_search.svg' type='' width='18%'></object>
                <h6>No hay ningun dato</h6>
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
              }]
        }
    });
    $('.TableLibrary').DataTable({
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
              }]
        }
    });

  
  /* BUSQUEDA RAPIDA */
  $(document).ready(function() {
    var inputbuscar = $('#buscarAviso');
    inputbuscar.on('keyup', function() {
        var searchTerm = inputbuscar.val();
        $.ajax({
        url: 'BR_avisos/BusquedaRapidaAviso',
        method: 'POST',
        dataType:"json",
        data: { data: searchTerm},
        success: function(response) {
            /* console.log("esto es el dato de la busqueda del aviso : ",response); */
            var tabla = ""; var fila=1;
            var oTable = $('.table_Estudiantes').dataTable();
            oTable.fnClearTable();
            for(var i = 0; i < response.length; i++) {
                var iconDelete = '<a href="javascript:void(0)" onclick=AlertaEliminar("'+ response[i]['id'] +'") class="btn btn-outline-danger" ><i class="fa-solid fa-trash"></i></a>';
                var iconCuadro = '<a href="javascript:void(0)" class="btn btn-outline-primary" onclick=verAviso("'+ response[i]['id'] +'") data-fancybox data-src="#modal_seguiminetoIntermediacion" data-width="3000" data-height="400"><i class="fa-solid fa-users-rectangle"></i></a>';         
                var iconGroup = '<a href="javascript:void(0)" onclick=verData("'+ response[i]['id'] +'") class="btn btn-outline-success mx-1" data-fancybox data-src="#modal_ver_data" data-width="3000" data-height="400"><i class="fa-solid fa-users"></i></a>';     
                var editGroup = '<a href="javascript:void(0)" onclick=editAviso("'+ response[i]['id'] +'") class="btn btn-outline-warning mr-1" data-fancybox data-src="#modal_modificar_aviso" data-width="3000" data-height="400"><i class="fa-solid fa-edit"></i></a>';
                var contenIcon = '<div class="d-flex">'+ iconCuadro + iconGroup + editGroup + iconDelete +'</div>'
                
                oTable.fnAddData([ fila, 
                                    response[i]['created_at'], 
                                    response[i]['tipo_persona'],
                                    response[i]['rucEmpresa'], 
                                    response[i]['razon_social'], 
                                    response[i]['nombre_comercial'],
                                    response[i]['titulo'],
                                    response[i]['nombre_distrito'], 
                                    response[i]['vacantes'],
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
        $(".ecxel").attr("href", 'Avisos/EsportarExcel/'+ f1 + '/' + f2 + '/' + validacion)
        $(".table_Estudiantes tbody").empty();
		$.ajax({
			type:"POST",
			dataType:"json",
			url:'Avisos/ConsultaDataPorFecha',
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
               /*  console.log('esto es la rpta : ', response) */
                var tabla = ""; var fila=1;
                var oTable = $('.table_Estudiantes').dataTable();
                oTable.fnClearTable();
                for(var i = 0; i < response.length; i++) {
                    var iconDelete = '<a href="javascript:void(0)" onclick=AlertaEliminar("'+ response[i]['id'] +'") class="btn btn-outline-danger" ><i class="fa-solid fa-trash"></i></a>';
                    var iconCuadro = '<a href="javascript:void(0)" class="btn btn-outline-primary" onclick=verAviso("'+ response[i]['id'] +'") data-fancybox data-src="#modal_seguiminetoIntermediacion" data-width="3000" data-height="400"><i class="fa-solid fa-users-rectangle"></i></a>';         
                    var iconGroup = '<a href="javascript:void(0)" onclick=verData("'+ response[i]['id'] +'") class="btn btn-outline-success mx-1" data-fancybox data-src="#modal_ver_data" data-width="3000" data-height="400"><i class="fa-solid fa-users"></i></a>';     
                    var editGroup = '<a href="javascript:void(0)" onclick=editAviso("'+ response[i]['id'] +'") class="btn btn-outline-warning mr-1" data-fancybox data-src="#modal_modificar_aviso" data-width="3000" data-height="400"><i class="fa-solid fa-edit"></i></a>';
                    var contenIcon = '<div class="d-flex">'+ iconCuadro + iconGroup + editGroup + iconDelete +'</div>'
                    
                    oTable.fnAddData([ fila, 
                                       response[i]['created_at'], 
                                       response[i]['tipo_persona'],
                                       response[i]['rucEmpresa'], 
                                       response[i]['razon_social'], 
                                       response[i]['nombre_comercial'],
                                       response[i]['titulo'],
                                       response[i]['nombre_distrito'], 
                                       response[i]['vacantes'],
                                       contenIcon
                                    ]);
                    fila++;
                }

			},error:function(){
			console.log("ERROR GENERAL DEL SISTEMA, POR FAVOR INTENTE MÁS TARDE");
			}
		});
	});
  
  $(document).on('submit', "#form_modificar_aviso", function(event){
		event.preventDefault();
		var datos = $(this).serialize();
		$.ajax({
			type:"POST",
			dataType:"json",
			url:'Avisos/ModificarAviso',
			data:datos,
			success:function(response){
        /* console.log('esto es la rpta : ', response) */
        if(response == "ok"){
          Swal.fire({
            icon: 'success',
            title: 'El registro ha sido modificado',
            showConfirmButton: false,
            timer: 1500
          })
          $('.btn_consulta_pj').click();
        }else{
          Swal.fire({
            icon: 'Error',
            title: 'Intentelo mas tarde',
            showConfirmButton: false,
            timer: 1500
          })
        }
			},error:function(){
			  console.log("ERROR GENERAL DEL SISTEMA, POR FAVOR INTENTE MÁS TARDE");
			}
		});

	});

  $(document).on('submit', "#form_modificar_estadoPost", function(event){
    event.preventDefault();
    var datos = $(this).serialize();
    $.ajax({
      type:"POST",
      dataType:"json",
      url:'Avisos/EditarEstadoPost',
      data:datos,
      success:function(response){
        console.log('esto es la rpta : ', response)
        if(response == "ok"){
          Swal.fire({
            icon: 'success',
            title: 'El Estado del Postulante ha sido modificado',
            showConfirmButton: false,
            timer: 1500
          })
          verData($("#idAviso").val())
        }else{
          Swal.fire({
            icon: 'Error',
            title: 'Intentelo mas tarde',
            showConfirmButton: false,
            timer: 1500
          })
        }
      },error:function(){
        console.log("ERROR GENERAL DEL SISTEMA, POR FAVOR INTENTE MÁS TARDE");
      }
    });
  
  });

});

function editAviso(idData)
{
  $.ajax({
    type:"POST",
    dataType:"json",
    url:'Avisos/TraeDataAvisoModific',
    data: {id:idData},
    success:function(response){
      /*  console.log("esto de la data : ",response) */
      $("#id_aviso").val(response[0]["id"])
      $("#mod_form_titulo").val(response[0]["titulo"])
      $("#mod_form_distrito").val(response[0]["distrito_id"])
      $("#mod_form_vacantes").val(response[0]["vacantes"])
      $("#mod_form_carrera").val(response[0]["solicita_carrera"])
      $("#mod_form_estado").val(response[0]["solicita_grado_a"])
      $("#mod_form_vigencia").val(response[0]["periodo_vigencia"])
      $("#mod_form_descripcion").val(response[0]["descripcion"])
      $("#mod_form_salario").val(response[0]["salario"])
      $("#mod_form_grado").val(response[0]["ciclo_cursa"])  
      inputs_validation()

    },error:function(){
    console.log("ERROR GENERAL DEL SISTEMA, POR FAVOR INTENTE MÁS TARDE");
    }
  });
}

function inputs_validation(){
  $("#mod_form_grado").hide();
  var txt = $('#mod_form_estado').val()
  if(txt == 0){
    $("#mod_form_grado").show();   
    $("#mod_form_grado").attr('required', true);
  }else{
    $("#mod_form_grado").hide();   
    $("#mod_form_grado").attr('required', false);
  }
}

$(document).on('change', '#mod_form_estado', function(event) {
  inputs_validation()
});

function verAviso(idData)
{
  $.ajax({
      type:"POST",
      dataType:"json",
      url:'Avisos/verAviso',
      data: {id:idData},
      success:function(response){
        /* console.log("esto de la data de la tabla seguimiento: ",response) */
        $("#title_aviso").html(response[0]["titulo"])
        $("#descripcion_aviso").html(response[0]["descripcion"])
        $("#empresa_aviso").html(response[0]["nombre_comercial"])
        $("#publicacion_aviso").html(response[0]["publicado"])
        $("#distrito_aviso").html(response[0]["distrito"])
        $("#area_aviso").html(response[0]["carrera"])
        $("#salario_aviso").html(response[0]["salario"])
      },error:function(){
      console.log("ERROR GENERAL DEL SISTEMA, POR FAVOR INTENTE MÁS TARDE");
      }
  });
}

function DataTablaPostulantesManual(idData)
{
  $(".tablaListarPostlantesManual tbody").empty();
  $.ajax({
      type:"POST",
      dataType:"json",
      url:'Avisos/ListarTablaPostulantesManual',
      data: {id:idData},
      success:function(response){
        /* console.log("esto de la data tabla manual avisos alumnos: ",response) */
        var tablaP = ""; var fila=1;
        var oTablePostulante = $('.tablaListarPostlantesManual').dataTable();
        oTablePostulante.fnClearTable();
        for(var i = 0; i < response.length; i++) {
            oTablePostulante.fnAddData([ fila, 
                                response[i]['nombres'], 
                                response[i]['dni'], 
                                response[i]['telefono'], 
                                response[i]['grado_academico'],
                                response[i]['estado'],
                                response[i]['correo'], 
                                response[i]['fecha_registro']
                            ]);
            fila++;
        }
      },error:function(){
      console.log("ERROR GENERAL DEL SISTEMA, POR FAVOR INTENTE MÁS TARDE");
      }
  });
}

function verData(idData)
{
    DataTablaPostulantesManual(idData)
    $('#lista_alumno_agre tr').remove()
    $(".aviso_id_form").val(idData);
    $('#buscadorAlumno').val('')
    $(".TablaListadoPostulantes tbody").empty();
    $.ajax({
        type:"POST",
        dataType:"json",
        url:'Avisos/TraerDataPorID',
        data: {id:idData},
        success:function(response){
          /* console.log("esto de la data avisos alumnos: ",response) */
          var tablaP = ""; var fila=1;
          var oTablePostulante = $('.TablaListadoPostulantes').dataTable();
          oTablePostulante.fnClearTable();
          for(var i = 0; i < response.length; i++) {
              var iconEditEstado = '<a href="javascript:void(0)" class="btn btn-outline-primary" onclick=EditarEstadoPost("'+ response[i]['estado_id'] +'","'+response[i]['aviso_id']+'","'+response[i]['alumno_id']+'") data-fancybox data-src="#modal_edit_estado" data-width="3000" data-height="400"><i class="fa-solid fa-edit"></i></a>'; 
              oTablePostulante.fnAddData([ fila, 
                                  response[i]['nombres']+" "+response[i]['apellidos'], 
                                  response[i]['dni'], 
                                  response[i]['telefono'], 
                                  response[i]['estado'],
                                  response[i]['email'],
                                  response[i]['created_at'],
                                  iconEditEstado
                              ]);
              fila++;
          }
        },error:function(){
        console.log("ERROR GENERAL DEL SISTEMA, POR FAVOR INTENTE MÁS TARDE");
        }
    });
}

function EditarEstadoPost(idEstado, idAviso, idAlumno)
{
  $("#idAviso").val(idAviso)
  $("#idAlumno").val(idAlumno)
  $("#estado_postulante").val(idEstado)  
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
        url:'Avisos/EliminarDataID',
        data: {id:idData},
        success:function(response){
            $('.btn_consulta_pj').click();
        },error:function(){
        console.log("ERROR GENERAL DEL SISTEMA, POR FAVOR INTENTE MÁS TARDE");
        }
    });
}

$("#modal_ver_data").click(function(){
  $('#searchResults li').remove()
})
$(".fancybox__slide").click(function(){
  $('#buscadorAlumno').val('')
  $('#searchResults li').remove()
})
$(".is-close-btn").click(function(){
  $('#buscadorAlumno').val('')
  $('#searchResults li').remove()
})

$(document).ready(function() {
  $("#btn_agregar_potulantes").attr('hidden', true)
  
  var searchBox = $('#buscadorAlumno');
  var searchResults = $('#searchResults'); 
  searchBox.on('keyup', function() {
    var idAviso = $(".aviso_id_form").val();
    var searchTerm = searchBox.val();
    $.ajax({
      url: 'Avisos/ConsultarAlumno',
      method: 'POST',
      dataType:"json",
      data: { data: searchTerm, idAviso:idAviso },
      success: function(results) {
        /* console.log("esto es el dato : ",results); */
        searchResults.empty();
        results.forEach(function(result) {
          var li = $('<li>').html('<div onclick="validarAlumno('+result['id']+', '+idAviso+')" width="100%"><a href="javascript:void(0)">'+result['nombres']+' '+result['apellidos']+' / '+result['dni']+'</a></div>');
          searchResults.append(li);
        });
      }
    });
  });
});

function validarAlumno(idAlumno, idAviso)
{
  $.ajax({
    url: 'Avisos/ValidarAlumnoID',
    method: 'POST',
    dataType:"json",
    data: { id:idAlumno, idAviso:idAviso },
    success: function(res) {
      if(res.length > 0){
        Swal.fire({
          position: 'center',
          icon: 'error',
          title: 'Este alumno ya esta postulado en este aviso',
          showConfirmButton: false,
          timer: 1500
        })
      }else{
        selectAlumno(idAlumno)
      }
    }
  });
}

function selectAlumno(idAlumno)
{
  f_valida_repetido(idAlumno)
  $.ajax({
    url: 'Avisos/SelectAlumnoID',
    method: 'POST',
    dataType:"json",
    data: { id:idAlumno },
    success: function(res) {
      arraySelectAlumno.push(idAlumno)
      $("#lista_alumno_agre").html();
      nuevaFila  = '<tr id="'+idAlumno+'">';
      nuevaFila  += '<td>'+idAlumno+'</td>';
      nuevaFila  += '<td>'+res[0]['nombres']+' '+res[0]['apellidos']+'</td>';
      nuevaFila  += '<td>'+res[0]['dni']+'</td>';
      nuevaFila  += '<td>'+res[0]['telefono']+'</td>';
      nuevaFila  += '<td>'+res[0]['email']+'</td>';
      nuevaFila  += '<td class="text-center"><button class="btn btn-outline-danger btn-sm" onclick="eliminarSelectAlumno('+idAlumno+')"><i class="fa-solid fa-xmark"></i></button></td>';
      nuevaFila  += '</tr>';
      $("#lista_alumno_agre").append(nuevaFila);
      /* console.log("esto es el array primer dato : ",arraySelectAlumno) */
    }
  });
  var nrows = 1;
  $("#lista_alumno_agre tr").each(function() {
      nrows++;
  })
  if(nrows == 0){
    $("#btn_agregar_potulantes").attr('hidden', true)
  }else{
    $("#btn_agregar_potulantes").attr('hidden', false)
  }
}

function eliminarSelectAlumno(idAlumno)
{
  $('#'+idAlumno).remove()
  var indice = arraySelectAlumno.indexOf(idAlumno);
  arraySelectAlumno.splice(indice, 1);  
  /* console.log("esto es el array : ",arraySelectAlumno) */
  var nrows = 0;
  $("#lista_alumno_agre tr").each(function() {
      nrows++;
  })
  if(nrows == 0){
    $("#btn_agregar_potulantes").attr('hidden', true)
  }else{
    $("#btn_agregar_potulantes").attr('hidden', false)
  }

}

function AgregarAumnosPostulantes()
{
  var alumnos = arraySelectAlumno;
  var idAviso = $(".aviso_id_form").val();
  $.ajax({
    url: 'Avisos/AgregarAlumnoPostulante',
    method: 'POST',
    dataType:"json",
    data: { alumnos: alumnos, idAviso:idAviso },
    success: function(results) {
      /* console.log("esto es al funcion de agregar alumns postulantes : ",results); */
      if(results == "ok"){
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Postulaciones Agregadas',
          showConfirmButton: false,
          timer: 1500
        })
        verData(idAviso)
        arraySelectAlumno = []
        $('#lista_alumno_agre tr').remove()
        $("#btn_agregar_potulantes").attr('hidden', true)
        $('#buscadorAlumno').val('')
        $('#searchResults li').remove()
      }else{
        Swal.fire({
          position: 'center',
          icon: 'error',
          title: 'Intentelo mas tarde',
          showConfirmButton: false,
          timer: 1500
        })
      }
    }
  });
}


function f_valida_repetido(idAlumno){
  if ($('#tabla_agre_alumno tbody tr').length > 0){
      $('#tabla_agre_alumno tbody tr').each(function(){
          if ($(this).find('td').html() == idAlumno){
            /* console.log("el valor repetido es : ", idAlumno) */
            Swal.fire({
              position: 'center',
              icon: 'error',
              title: 'Este alumno ya se encuentra en cola',
              showConfirmButton: false,
              timer: 1500
            })
            eliminarSelectAlumno(idAlumno)
          }
      });
  }else{
    return true;
  }           
}























