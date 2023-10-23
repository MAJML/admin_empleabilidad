console.log("esto es la consola de reporte Empleador - Actividad Economica")

$('#TableReporte').DataTable({
    "order": [],
    "language": {
        "lengthMenu": "Mostrar _MENU_ ",
        "zeroRecords": `
        <div class="">
            No se encontraron datos
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
$('#TableCantidadCIIU').DataTable({
    "order": [],
    "language": {
        "lengthMenu": "Mostrar _MENU_ ",
        "zeroRecords": `
        <div class="">
            No se encontraron datos
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
    },
    "paging": false
});


$(document).on('submit', "#ConsultaActividadEconomica", function(event){
    event.preventDefault();
    var data = $(this).serialize();
    var f1 = $(".fecha1").val();
    var f2 = $(".fecha2").val();
    var validacion = $(".validacion").val();
    $(".ecxel").attr("href", 'RE_actividadEconomica/EsportarExcel/'+ f1 + '/' + f2 + '/' + validacion)
    $(".tabladatosREactividadEco tbody").empty();
    $(".tablitaContadorCiiu tbody").empty();


    const esperar = tiempo => {
        return new Promise((resolve, reject) => {
          setTimeout(() => {
            resolve('ok');
          }, tiempo);
        })
      } 
    esperar(550).then((res) => DataREactividadEco(data));
    esperar(500).then((res) => DataContadorCIIU(data));


});

function DataREactividadEco(data)
{
    $.ajax({
        type:"POST",
        dataType:"json",
        url:'RE_actividadEconomica/ConsultaDataPorFecha',
        data:data,
        beforeSend: function() {
            $(".btn_consultar_form").attr('disabled', true)
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
            $(".cargador").html("")
            $(".btn_consultar_form").attr('disabled', false)
            /* console.log('esto es la rpta : ', response) */
            var fila=1;
            var oTable = $('.tabladatosREactividadEco').dataTable();
            oTable.fnClearTable();
            for(var i = 0; i < response.length; i++) {

                if(response[i]['tipo'] == "Persona Natural"){
                    var cciu = "DOMICILIO"
                }else{
                    var cciu = response[i]['codigo_actividad_eco']+" "+response[i]['nombre_actividad_eco']
                }

                oTable.fnAddData([ fila, 
                                   response[i]['created_at'], 
                                   response[i]['tipo'],
                                   response[i]['ruc'], 
                                   response[i]['razon_social'], 
                                   response[i]['nombre_comercial'],
                                   cciu
                                ]);
                fila++;
            }

        }
    });
}

function DataContadorCIIU(data)
{
    $.ajax({
        type:"POST",
        dataType:"json",
        url:'RE_actividadEconomica/ContarActividadEcoPorFechas',
        data:data,
        beforeSend: function() {
            $(".btn_consultar_form").attr('disabled', true)
            $(".cargadorCIIU").html(`
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
            $(".cargador").html("")
            $(".btn_consultar_form").attr('disabled', false)
            console.log('esto es la rpta : ', response)
            var fila=1;
            var oTableConCIIU = $('.tablitaContadorCiiu').dataTable();
            oTableConCIIU.fnClearTable();
            for(var i = 0; i < response.length; i++) {
                oTableConCIIU.fnAddData([ fila, 
                                   response[i]['codigo_actividad_eco']+" - "+response[i]['nombre_actividad_eco'], 
                                   response[i]['Cta']
                                ]);
                fila++;
            }
            var total_col1 = 0;
            $('#TableCantidadCIIU tbody').find('tr').each(function (i, el) {  
                total_col1 += parseFloat($(this).find('td').eq(2).text());
            });
            $('#TableCantidadCIIU tfoot tr th').eq(1).text(total_col1);

        }
    });
}

function ejecutarFuncion(data){
    return new Promise((resolve, reject) => {
        resolve(DataREactividadEco(data), DataContadorCIIU(data))
    })
}