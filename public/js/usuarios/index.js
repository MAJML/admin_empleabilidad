console.log("esta es la consola de usuarios")

$('#tablaUsuarios').DataTable({
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

ListarTablaUsuario()

$(document).on('submit', "#FormUsuarios", function(event){
    event.preventDefault();
    var data = $(this).serialize();
    $.ajax({
        type:"POST",
        dataType:"json",
        url:'Usuario/RegistrarUsuario',
        data:data,
        success:function(response){
    if(response == "ok"){
      Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: 'Registrado',
        showConfirmButton: false,
        timer: 1500
      })
      $("#FormUsuarios")[0].reset();
      $('.is-close-btn').click();
      ListarTablaUsuario()
    }else{
      Swal.fire({
        position: 'top-end',
        icon: 'error',
        title: 'ERROR GENERAL DEL SISTEMA, POR FAVOR INTENTE MÁS TARDE',
        showConfirmButton: false,
        timer: 1500
      })
    }
        },error:function(){
        console.log("ERROR GENERAL DEL SISTEMA, POR FAVOR INTENTE MÁS TARDE");
        }
    });
});

$(document).on('submit', "#FormActualizarUsuarios", function(event){
  event.preventDefault();
  var data = $(this).serialize();
  $.ajax({
      type:"POST",
      dataType:"json",
      url:'Usuario/EditarUsuario',
      data:data,
      success:function(response){
        if(response == "ok"){
          Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Actualizado',
            showConfirmButton: false,
            timer: 1500
          })
          $("#FormActualizarUsuarios")[0].reset();
          $('.is-close-btn').click();
          ListarTablaUsuario()
        }else{
          Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: 'ERROR GENERAL DEL SISTEMA, POR FAVOR INTENTE MÁS TARDE',
            showConfirmButton: false,
            timer: 1500
          })
        }
      },error:function(){
      console.log("ERROR GENERAL DEL SISTEMA, POR FAVOR INTENTE MÁS TARDE");
      }
  });
});



function ListarTablaUsuario()
{
    $(".TablaUsuarios tbody").empty();
    $.ajax({dataType:"json", url:'Usuario/ListarUsuarios',success:function(response){
          var tablaP = ""; var fila=1;
          var oTableUsuario = $('.TablaUsuarios').dataTable();
          oTableUsuario.fnClearTable();
          for(var i = 0; i < response.length; i++) {
                if(response[i]['online'] == 1){
                  var conected = '<a href="javascript:void(0);" class="mr-2 badge badge-success">● Online</a>'
                }else{
                  var conected = '<a href="javascript:void(0);" class="mr-2 badge badge-danger">● Offline</a>'
                }

                var iconDelete = '<a href="javascript:void(0)" onclick=AlertaEliminar("'+ response[i]['id'] +'") class="btn btn-outline-danger" ><i class="fa-solid fa-trash"></i></a>';
                var iconGroup = '<a href="javascript:void(0)" onclick=verData("'+ response[i]['id'] +'") class="btn btn-outline-primary" data-fancybox data-src="#modalEditarData"><i class="fa-solid fa-pen-to-square"></i></a>';     
                var contenIcon = '<div class="d-flex">'+ iconGroup + iconDelete +'</div>'
                oTableUsuario.fnAddData([ fila, 
                                  response[i]['nombre']+" "+response[i]['apellido'], 
                                  response[i]['correo'], 
                                  response[i]['perfil'], 
                                  response[i]['created_at'],
                                  conected,
                                  response[i]['fecha_ingreso'],
                                  response[i]['fecha_desconect'],
                                  contenIcon
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
    $.ajax({
        type:"POST",
        dataType:"json",
        url:'Usuario/TraerDataPorID',
        data: {id:idData},
        success:function(response){
          /* console.log("esto de la data de usuario: ",response) */
          $(".nombresEdit").val(response[0]['nombre'])
          $(".apellidosEdit").val(response[0]['apellido'])
          $(".correoEdit").val(response[0]['correo'])
          $(".perfilEdit").val(response[0]['perfil'])
          $(".idUsuario").val(response[0]["id"])
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
        url:'Usuario/EliminarDataID',
        data: {id:idData},
        success:function(response){
          ListarTablaUsuario();
        },error:function(){
        console.log("ERROR GENERAL DEL SISTEMA, POR FAVOR INTENTE MÁS TARDE");
        }
    });
}
