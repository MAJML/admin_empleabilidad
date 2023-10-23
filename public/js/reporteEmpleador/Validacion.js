console.log("esto es la consola de reporte Empleador - Validacion")

$('#TableValidacion').DataTable({
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


$(document).on('submit', "#ConsultaEmpleadorValidacion", function(event){
    event.preventDefault();
    var data = $(this).serialize();
    var f1 = $(".fecha1").val();
    var f2 = $(".fecha2").val();
    var validacion = $(".validacion").val();
    $(".ecxel").attr("href", 'RE_validacion/EsportarExcel/'+ f1 + '/' + f2 + '/' + validacion)
    $(".TableValidacion tbody").empty();
    DataREactividadEco(data)

});

function DataREactividadEco(data)
{
    $.ajax({
        type:"POST",
        dataType:"json",
        url:'RE_validacion/ConsultaDataPorFecha',
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
            response = data.ConsultaFecha
            ContValidacion = data.ContadorValidacion
            ContadorValidacionTipoPersona = data.ContadorValidacionTipoPersona


            graficoBarraConValidacion(ContValidacion)
            graficoBarratipoPersona(ContadorValidacionTipoPersona)

            /* console.log('esto es la rpta ContadorValidacion : ', data.ContadorValidacion) */
            var fila=1;
            var oTable = $('.TableValidacion').dataTable();
            oTable.fnClearTable();
            for(var i = 0; i < response.length; i++) {
                if(response[i]['aprobado'] == 0){
                    var validacion = '<span class="badge text-bg-danger">No Validado</span>';
                }else{
                    var validacion = '<span class="badge text-bg-success">Validado</span>';
                }
                oTable.fnAddData([ fila, 
                                   response[i]['created_at'], 
                                   response[i]['tipo'],
                                   response[i]['ruc'], 
                                   response[i]['razon_social'], 
                                   response[i]['nombre_comercial'],
                                   validacion,
                                ]);
                fila++;
            }

        }
    });
}


function graficoBarratipoPersona(ContadorValidacionTipoPersona)
{

    /* console.log("ContadorValidacionTipoPersona: ", ContadorValidacionTipoPersona) */
    const arrayAprobado = [];
    const arrayDesaprobado = [];
    const arrayTipoP = [];
    const arraySum = [];

    for (let i = 0; i < ContadorValidacionTipoPersona.length; i++) {
        arrayTipoP.push(ContadorValidacionTipoPersona[i].TipoPersona);
        arrayAprobado.push(parseInt(ContadorValidacionTipoPersona[i].Aprobado));
        arrayDesaprobado.push(parseInt(ContadorValidacionTipoPersona[i].Desaprobado));
        arraySum.push(parseInt(ContadorValidacionTipoPersona[i].Aprobado)+parseInt(ContadorValidacionTipoPersona[i].Desaprobado));
    }


    Tj = (arraySum[0] !== undefined && arraySum[0] !== null) ? arraySum[0] : 0
    Tn = (arraySum[1] !== undefined && arraySum[1] !== null) ? arraySum[1] : 0
    Tng = (arraySum[2] !== undefined && arraySum[2] !== null) ? arraySum[2] : 0

    $(".total_juridica").html('<b>● Total Persona Juridica: </b>' + Tj)
    $(".total_natural").html('<b>● Total Persona Natural: </b>' + Tn)
    $(".total_negocio").html('<b>● Total Persona con Negocio: </b>' + Tng)

    Highcharts.chart('container', {
        chart: {
            type: 'column'
        },
        title: {
            text: ''
        },
        xAxis: {
            categories: arrayTipoP,
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Empresas'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'Aprobado',
            data: arrayAprobado
        },
        {
            name: 'Desaprobado',
            data: arrayDesaprobado
        }]
    });
    
}

function graficoBarraConValidacion(ContValidacion)
{
    var sum = parseInt(ContValidacion[0].validado) + parseInt(ContValidacion[0].no_validado);
    var datatotal = '<b>● Suma Total: </b>'+ sum;
    $("#total_empresas").html(datatotal)

    Highcharts.chart('containertotal', {
        chart: {
            type: 'bar'
        },
        title: {
            text: ''
        },
        xAxis: {
            categories: ['Validados', 'No Validados'],
            title: {
                text: null
            },
            gridLineWidth: 1,
            lineWidth: 0
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Grafico total de los tres tipo de personas',
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            },
            gridLineWidth: 0
        },
        tooltip: {
            valueSuffix: ' Empresas'
        },
        plotOptions: {
            bar: {
                borderRadius: '0%',
                dataLabels: {
                    enabled: true
                },
                groupPadding: 0.1
            }
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'hay : ',
            data: [parseInt(ContValidacion[0].validado), parseInt(ContValidacion[0].no_validado)]
        }]
    });
}

