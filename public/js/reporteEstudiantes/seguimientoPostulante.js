console.log("esto es la consola de reporte Estudiante - Seguimiento Postulante")

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
    $(".ecxel").attr("href", 'R_EST_seguimientoPostulante/EsportarExcel/'+ f1 + '/' + f2 + '/' + programa_estudio + '/' + grado_academico)
    $(".TableValidacion tbody").empty();
    DataREactividadEco(data)

});

function DataREactividadEco(data)
{
    $.ajax({
        type:"POST",
        dataType:"json",
        url:'R_EST_seguimientoPostulante/ConsultaDataPorFecha',
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
            /* console.log('esto es la rpta : ', data) */
            $('#total_register').html(data.ListarSeguimientoPostulante.length)
            graficoContadorActividadEco(data.ContadorAEPostulante)

            var fila=1;
            var oTable = $('.TableValidacion').dataTable();
            oTable.fnClearTable();
            for(var i = 0; i < data.ListarSeguimientoPostulante.length; i++) {

                var btnVerPost = '<a class="btn btn-info text-center btn_seguimientoPost" idEstudiante="'+ data.ListarSeguimientoPostulante[i]['id_estudiante'] +'" data-fancybox data-src="#modal_seguiminetoPostulacion" data-width="3000" data-height="400"><i class="fa-solid fa-eye" style="color: #fff;"></i></a>'
                oTable.fnAddData([ fila, 
                                   data.ListarSeguimientoPostulante[i]['apellidos'], 
                                   data.ListarSeguimientoPostulante[i]['nombres'],
                                   data.ListarSeguimientoPostulante[i]['distrito_estudiante'],
                                   btnVerPost,
                                ]);
                fila++;
            }

        }
    });
}

$(document).on("click", ".btn_seguimientoPost", function(){
    $.ajax({
        type:"POST",
        dataType:"json",
        url:'R_EST_seguimientoPostulante/TraerDataSegunID',
        data:{idEst : $(this).attr('idEstudiante')},
        success:function(res){
            $('#titulo_modal_Post').html(res[0].nombres+' '+res[0].apellidos)
            /* console.log('esto es la rpta : ', res) */
            var num=1;
            var oTablePost = $('.TablePostulaciones').dataTable();
            oTablePost.fnClearTable();
            for(var i = 0; i < res.length; i++) {
                oTablePost.fnAddData([ num, 
                                   res[i]['fecha_postulacion'], 
                                   res[i]['titulo_oferta'],
                                   res[i]['ruc_dni'],
                                   res[i]['razon_social'],
                                   res[i]['nombre_comercial'],
                                   res[i]['estado_postulacion'],
                                ]);
                num++;
            }

        }
    });

})

function graficoContadorActividadEco(e)
{
    console.log("dato de la funcion graficoContadorActividadEco: ", e)
    const arrayActEco = [];
    const arrayContEco = [];
    for (let i = 0; i < e.length; i++) {
        arrayActEco.push(e[i].actividad_eco)
        arrayContEco.push(parseInt(e[i].cantidad_eco))
    }
    console.log('actividad_eco: ',arrayActEco)

    Highcharts.chart('container', {
        chart: {
            type: 'bar'
        },
        title: {
            text: ''
        },
        xAxis: {
            categories: arrayActEco
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
            name: 'Postulantes',
            data: arrayContEco
        }]
    });
    

}
