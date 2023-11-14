console.log("esto es la consola de reporte Estudiante - intermediacion")

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
    var programa_estudio = $(".programa_estudio").val();
    var grado_academico = $(".grado_academico").val();
    var estado_estudiante = $(".estado_estudiante").val();
    $(".ecxel").attr("href", 'R_EST_intermediacion/EsportarExcel/'+ f1 + '/' + f2 + '/' + programa_estudio + '/' + grado_academico + '/' + estado_estudiante)
    $(".TableValidacion tbody").empty();
    DataREactividadEco(data)

});

function DataREactividadEco(data)
{
    $.ajax({
        type:"POST",
        dataType:"json",
        url:'R_EST_intermediacion/ConsultaDataPorFecha',
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

            graficoContadorGradoAcademico(data.contadorGradoAcademico)


            var fila=1;
            var oTable = $('.TableValidacion').dataTable();
            oTable.fnClearTable();
            for(var i = 0; i < data.ListarIntermediacion.length; i++) {
                oTable.fnAddData([ fila, 
                                   data.ListarIntermediacion[i]['fecha_postulacion'], 
                                   data.ListarIntermediacion[i]['apellido_postulante'],
                                   data.ListarIntermediacion[i]['nombre_postulante'], 
                                   data.ListarIntermediacion[i]['distrito'], 
                                   data.ListarIntermediacion[i]['titulo_oferta'],
                                   data.ListarIntermediacion[i]['ruc'],
                                   data.ListarIntermediacion[i]['razon_social'],
                                   data.ListarIntermediacion[i]['nombre_comercial'],
                                ]);
                fila++;
            }

        }
    });
}


function graficoContadorGradoAcademico(dataContador)
{
/*     console.log("dataContador: ", dataContador) */
    const arrayAreas = [];
    const arrayEstudiantes = [];
    const arrayEgresado = [];
    const arrayTitulado = [];

    for (let i = 0; i < dataContador.length; i++) {
        arrayAreas.push(dataContador[i].Area);
        arrayEstudiantes.push(parseInt(dataContador[i].Estudiante));
        arrayEgresado.push(parseInt(dataContador[i].Egresado));
        arrayTitulado.push(parseInt(dataContador[i].Titulado));
    }

    let totalEstudiante = arrayEstudiantes.reduce((a, b) => a + b, 0);
    let totalEgresado = arrayEgresado.reduce((a, b) => a + b, 0);
    let totalTitulado = arrayTitulado.reduce((a, b) => a + b, 0);

    $(".total_estudiantes").html('<b>● Total de Insertados Estudiantes: </b>' + totalEstudiante)
    $(".total_egresados").html('<b>● Total de Insertados Egresados: </b>' + totalEgresado)
    $(".total_titulados").html('<b>● Total de Insertados Títulados: </b>' + totalTitulado)

    Highcharts.chart('container', {
        chart: {
            type: 'bar'
        },
        title: {
            text: ''
        },
        xAxis: {
            categories: arrayAreas
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Goals'
            }
        },
        legend: {
            reversed: true
        },
        plotOptions: {
            series: {
                stacking: 'normal',
                dataLabels: {
                    enabled: true
                }
            }
        },
        series: [{
            name: 'Estudiantes',
            data: arrayEstudiantes
        }, {
            name: 'Egresados',
            data: arrayEgresado
        }, {
            name: 'Titulado',
            data: arrayTitulado
        }]
    });    

}
