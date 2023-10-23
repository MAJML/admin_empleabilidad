console.log("esto es la consola avisos efectividad")

$('#TableEfectividadAv').DataTable({
    "order": [],
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


$(document).on('submit', "#ConsultEfectividadAviso", function(event){
    event.preventDefault();
    var data = $(this).serialize();
    var f1 = $(".fecha1").val();
    var f2 = $(".fecha2").val();
    var programa_estudio = $(".programa_estudio").val();
    var estado_estudiante = $(".estado_estudiante").val();
    $(".ecxel").attr("href", 'R_A_efectividadAviso/EsportarExcel/'+ f1 + '/' + f2 + '/' + programa_estudio + '/' + estado_estudiante)
    $(".TableValidacion tbody").empty();
    DataREactividadEco(data)

});
                    
function DataREactividadEco(data)
{
    $.ajax({
        type:"POST",
        dataType:"json",
        url:'R_A_efectividadAviso/ConsultaDataPorFecha',
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
        success:function(data){
            $(".cargador").html("")
            $(".btn_consultar_form").attr('disabled', false)
            console.log('esto es la rpta : ', data)
            $('#total_register').html(data.ListadoEfectividad.length)
            graficoContadorAvisoEfec(data.CatindadesEfectividad)

            var fila=1;
            var oTable = $('.TableValidacion').dataTable();
            oTable.fnClearTable();
            for(var i = 0; i < data.ListadoEfectividad.length; i++) {
                oTable.fnAddData([ fila, 
                                   data.ListadoEfectividad[i]['ruc'], 
                                   data.ListadoEfectividad[i]['razon_social'],
                                   data.ListadoEfectividad[i]['nombre_comercial'],
                                   data.ListadoEfectividad[i]['titulo_oferta'],
                                   data.ListadoEfectividad[i]['Cant']+' || '+data.ListadoEfectividad[i]['Estado']
                                ]);
                fila++;
            }
        }
    });
}

function graficoContadorAvisoEfec(variable)
{
    /* console.log("esto es el dato de la funcion :",variable ) */
    const arrayAceptado = []
    const arrayPostulante = []
    const arrayEvaluando = []
    const arrayDescartados = []
    const arrayCantidadAV = []
    const arrayIntermediados = []
    for (let i = 0; i < variable.length; i++) {
        arrayAceptado.push(parseInt(variable[i].Aceptado))
        arrayPostulante.push(parseInt(variable[i].Postulante))
        arrayEvaluando.push(parseInt(variable[i].Evaluando))
        arrayDescartados.push(parseInt(variable[i].Descartado))
        arrayCantidadAV.push(parseInt(variable[i].Cantidad_Avisos))
        arrayIntermediados.push(parseInt(variable[i].sumaIntermediacion))
    }
    Highcharts.chart('container', {
        chart: {
            type: 'column'
        },
        title: {
            text: ''
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'Cantidad Total de Avisos',
            data: arrayCantidadAV
    
        }, {
            name: 'Cantidad Total de Intermediados',
            data: arrayIntermediados
    
        }, {
            name: 'Postulantes',
            data: arrayPostulante
    
        }, {
            name: 'Evaluados',
            data: arrayEvaluando
    
        }, {
            name: 'Colocados',
            data: arrayAceptado
    
        }, {
            name: 'Descartados',
            data: arrayDescartados
    
        }]
    });
    
}
