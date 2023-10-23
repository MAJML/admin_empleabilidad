console.log("esto es la consola de reporte avisos - Cantidad")

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

$('#TablePostulaciones').DataTable({
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
    $(".ecxel").attr("href", 'R_A_cantidades/EsportarExcel/'+ f1 + '/' + f2 + '/' + programa_estudio + '/' + grado_academico)
    $(".TableValidacion tbody").empty();
    DataREactividadEco(data)

});
                    
function DataREactividadEco(data)
{
    $.ajax({
        type:"POST",
        dataType:"json",
        url:'R_A_cantidades/ConsultaDataPorFecha',
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
            $('#total_register').html(data.ListaCantidadesAvisos.length)
            graficoContadorTipoPerson(data.CantidadTipoEm)

            var fila=1;
            var oTable = $('.TableValidacion').dataTable();
            oTable.fnClearTable();
            for(var i = 0; i < data.ListaCantidadesAvisos.length; i++) {
                oTable.fnAddData([ fila, 
                                   data.ListaCantidadesAvisos[i]['ruc'], 
                                   data.ListaCantidadesAvisos[i]['razon_social'],
                                   data.ListaCantidadesAvisos[i]['nombre_comercial'],
                                   data.ListaCantidadesAvisos[i]['cantidades'],
                                ]);
                fila++;
            }
        }
    });
}

function graficoContadorTipoPerson(variable)
{
    /* console.log("esto es el dato de la funcion :",variable ) */
    const arrayTipoPerson = []
    const arrayCantAvisos = []
    for (let i = 0; i < variable.length; i++) {
        arrayTipoPerson.push(variable[i].Tipo)
        arrayCantAvisos.push(parseInt(variable[i].cantidad))
    }
    Highcharts.chart('container', {
        chart: {
            type: 'bar'
        },
        title: {
            text: ''
        },
        xAxis: {
            categories: arrayTipoPerson
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
            name: 'Cantidad de Avisos',
            data: arrayCantAvisos
        }]
    });
    
}
