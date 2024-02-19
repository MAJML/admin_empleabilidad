setTimeout(function(){
    $('.highcharts-credits').html('<a href="https://majml.github.io/portafolio/">Desarrollado por Marco</a>');
},1000);
/* ya se que solo esta configurado para el 2023, para el 2024 dejara de funcionar esta operación */
$(document).ready(function(){
    ReporteEmpleadorMes()
    ReporteEstudiantesMes()
    DatosGenerales()
    $(document).on("click", ".consultar_data_fecha", function(){
        DatosGenerales()
    })
})


function ReporteEstudiantesMes(){
    $.ajax({
        url:"Inicio/ReporteEstudiante",
        method:"POST",
        cache: false,
        contentType: false,
        processData: false,
        success: function(respuesta){
            /* console.log("esto es el reporte del estudiante: ",respuesta); */
            Highcharts.chart('container_line_estudiantes', {
                chart: {
                    type: 'spline'
                },
                title: {
                    text: ''
                },
                xAxis: {
                    categories: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                        'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                    accessibility: {
                        description: ''
                    }
                },
                yAxis: {
                    title: {
                        text: ''
                    },
                    labels: {
                        format: '{value}'
                    }
                },
                tooltip: {
                    crosshairs: true,
                    shared: true
                },
                plotOptions: {
                    spline: {
                        marker: {
                            radius: 4,
                            lineColor: '#666666',
                            lineWidth: 1
                        }
                    }
                },
                series: [{
                    name: respuesta[0]['area'],
                    marker: {
                        symbol: 'square'
                    },
                    data: [parseInt(respuesta[0]['Enero']),
                           parseInt(respuesta[0]['Febrero']),
                           parseInt(respuesta[0]['Marzo']),
                           parseInt(respuesta[0]['Abril']),
                           parseInt(respuesta[0]['Mayo']),
                           parseInt(respuesta[0]['Junio']),
                           parseInt(respuesta[0]['Julio']),
                           parseInt(respuesta[0]['Agosto']),
                           parseInt(respuesta[0]['Setiembre']),
                           parseInt(respuesta[0]['Octubre']),
                           parseInt(respuesta[0]['Noviembre']),
                           parseInt(respuesta[0]['Diciembre'])]
            
                }, {
                    name: respuesta[1]['area'],
                    marker: {
                        symbol: 'diamond'
                    },
                    data: [parseInt(respuesta[1]['Enero']),
                           parseInt(respuesta[1]['Febrero']),
                           parseInt(respuesta[1]['Marzo']),
                           parseInt(respuesta[1]['Abril']),
                           parseInt(respuesta[1]['Mayo']),
                           parseInt(respuesta[1]['Junio']),
                           parseInt(respuesta[1]['Julio']),
                           parseInt(respuesta[1]['Agosto']),
                           parseInt(respuesta[1]['Setiembre']),
                           parseInt(respuesta[1]['Octubre']),
                           parseInt(respuesta[1]['Noviembre']),
                           parseInt(respuesta[1]['Diciembre'])]
                }, {
                    name: respuesta[2]['area'],
                    marker: {
                        symbol: 'circle'
                    },
                    data: [parseInt(respuesta[2]['Enero']),
                           parseInt(respuesta[2]['Febrero']),
                           parseInt(respuesta[2]['Marzo']),
                           parseInt(respuesta[2]['Abril']),
                           parseInt(respuesta[2]['Mayo']),
                           parseInt(respuesta[2]['Junio']),
                           parseInt(respuesta[2]['Julio']),
                           parseInt(respuesta[2]['Agosto']),
                           parseInt(respuesta[2]['Setiembre']),
                           parseInt(respuesta[2]['Octubre']),
                           parseInt(respuesta[2]['Noviembre']),
                           parseInt(respuesta[2]['Diciembre'])]
                }, {
                    name: respuesta[3]['area'],
                    marker: {
                        symbol: 'circle'
                    },
                    data: [parseInt(respuesta[3]['Enero']),
                           parseInt(respuesta[3]['Febrero']),
                           parseInt(respuesta[3]['Marzo']),
                           parseInt(respuesta[3]['Abril']),
                           parseInt(respuesta[3]['Mayo']),
                           parseInt(respuesta[3]['Junio']),
                           parseInt(respuesta[3]['Julio']),
                           parseInt(respuesta[3]['Agosto']),
                           parseInt(respuesta[3]['Setiembre']),
                           parseInt(respuesta[3]['Octubre']),
                           parseInt(respuesta[3]['Noviembre']),
                           parseInt(respuesta[3]['Diciembre'])]
                }, {
                    name: respuesta[4]['area'],
                    marker: {
                        symbol: 'circle'
                    },
                    data: [parseInt(respuesta[4]['Enero']),
                           parseInt(respuesta[4]['Febrero']),
                           parseInt(respuesta[4]['Marzo']),
                           parseInt(respuesta[4]['Abril']),
                           parseInt(respuesta[4]['Mayo']),
                           parseInt(respuesta[4]['Junio']),
                           parseInt(respuesta[4]['Julio']),
                           parseInt(respuesta[4]['Agosto']),
                           parseInt(respuesta[4]['Setiembre']),
                           parseInt(respuesta[4]['Octubre']),
                           parseInt(respuesta[4]['Noviembre']),
                           parseInt(respuesta[4]['Diciembre'])]
                }]
            });

        }
    })
}


function ReporteEmpleadorMes(){
    $.ajax({
        url:"Inicio/ReporteEmpleador",
        method:"POST",
        cache: false,
        contentType: false,
        processData: false,
        success: function(respuesta){
            console.log("esto es el reporte del empleador: ",respuesta);
            Highcharts.chart('container_line', {
                chart: {
                    type: 'spline'
                },
                title: {
                    text: ''
                },
                xAxis: {
                    categories: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                        'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                    accessibility: {
                        description: ''
                    }
                },
                yAxis: {
                    title: {
                        text: ''
                    },
                    labels: {
                        format: '{value}'
                    }
                },
                tooltip: {
                    crosshairs: true,
                    shared: true
                },
                plotOptions: {
                    spline: {
                        marker: {
                            radius: 4,
                            lineColor: '#666666',
                            lineWidth: 1
                        }
                    }
                },
                series: [{
                    name: respuesta[4]['TipoPer']+' - '+respuesta[4]['Año'],
                    marker: {
                        symbol: 'square'
                    },
                    data: [parseInt(respuesta[4]['Enero']),
                           parseInt(respuesta[4]['Febrero']),
                           parseInt(respuesta[4]['Marzo']),
                           parseInt(respuesta[4]['Abril']),
                           parseInt(respuesta[4]['Mayo']),
                           parseInt(respuesta[4]['Junio']),
                           parseInt(respuesta[4]['Julio']),
                           parseInt(respuesta[4]['Agosto']),
                           parseInt(respuesta[4]['Setiembre']),
                           parseInt(respuesta[4]['Octubre']),
                           parseInt(respuesta[4]['Noviembre']),
                           parseInt(respuesta[4]['Diciembre'])]
                }, {
                    name: respuesta[6]['TipoPer']+' - '+respuesta[6]['Año'],
                    marker: {
                        symbol: 'diamond'
                    },
                    data: [parseInt(respuesta[6]['Enero']),
                           parseInt(respuesta[6]['Febrero']),
                           parseInt(respuesta[6]['Marzo']),
                           parseInt(respuesta[6]['Abril']),
                           parseInt(respuesta[6]['Mayo']),
                           parseInt(respuesta[6]['Junio']),
                           parseInt(respuesta[6]['Julio']),
                           parseInt(respuesta[6]['Agosto']),
                           parseInt(respuesta[6]['Setiembre']),
                           parseInt(respuesta[6]['Octubre']),
                           parseInt(respuesta[6]['Noviembre']),
                           parseInt(respuesta[6]['Diciembre'])]
                }, {
                    name: respuesta[11]['TipoPer']+' - '+respuesta[11]['Año'],
                    marker: {
                        symbol: 'circle'
                    },
                    data: [parseInt(respuesta[11]['Enero']),
                           parseInt(respuesta[11]['Febrero']),
                           parseInt(respuesta[11]['Marzo']),
                           parseInt(respuesta[11]['Abril']),
                           parseInt(respuesta[11]['Mayo']),
                           parseInt(respuesta[11]['Junio']),
                           parseInt(respuesta[11]['Julio']),
                           parseInt(respuesta[11]['Agosto']),
                           parseInt(respuesta[11]['Setiembre']),
                           parseInt(respuesta[11]['Octubre']),
                           parseInt(respuesta[11]['Noviembre']),
                           parseInt(respuesta[11]['Diciembre'])]
                }]
            });

        }
    })
}


function DatosGenerales(){
    datito = $(".data_input_fecha").val()
    let arr = datito.split(' ');
    var datos = new FormData();
    datos.append("fecha_ini", arr[0])
    datos.append("fecha_final", arr[2])
    $.ajax({
        url:"Inicio/DatosGenerale",
        method:"POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function(respuesta){
            /* console.log(respuesta) */
            data_empleador = respuesta.empleadores["COUNT(*)"]
            data_estudiante = respuesta.estudiantes["COUNT(*)"]
            data_aviso = respuesta.avisos["COUNT(*)"]
            if(datito.length > 4){
                $(".title_fechas").html("del "+datito)
            }else{
                $(".title_fechas").html("de este Mes")
            }
            /* console.log("esto es empleadores : ", respuesta.empleadores["COUNT(*)"] ); */
            $("#cuadro_contador_empleador").html(respuesta.empleadores["COUNT(*)"])
            $("#cuadro_contador_estudiante").html(respuesta.estudiantes["COUNT(*)"])
            $("#cuadro_contador_aviso").html(respuesta.avisos["COUNT(*)"])
            if(respuesta.empleadores["COUNT(*)"] >= 150){
                $("#status_empleador").removeClass('text-danger')
                $("#status_empleador").addClass('text-success')
                $("#status_empleador span").html('<i class="fa fa-angle-up"></i> mayor al promedio')
            }else{
                $("#status_empleador").removeClass('text-success')
                $("#status_empleador").addClass('text-danger')
                $("#status_empleador span").html('<i class="fa fa-angle-down"></i> menor del promedio')
            }
            if(respuesta.estudiantes["COUNT(*)"] >= 200){
                $("#status_alumnos").removeClass('text-danger')
                $("#status_alumnos").addClass('text-success')
                $("#status_alumnos span").html('<i class="fa fa-angle-up"></i> mayor al promedio')
            }else{
                $("#status_alumnos").removeClass('text-success')
                $("#status_alumnos").addClass('text-danger')
                $("#status_alumnos span").html('<i class="fa fa-angle-down"></i> menor del promedio')
            }
            if(respuesta.avisos["COUNT(*)"] >= 150){
                $("#status_avisos").removeClass('text-danger')
                $("#status_avisos").addClass('text-success')
                $("#status_avisos span").html('<i class="fa fa-angle-up"></i> mayor al promedio')
            }else{
                $("#status_avisos").removeClass('text-success')
                $("#status_avisos").addClass('text-danger')
                $("#status_avisos span").html('<i class="fa fa-angle-down"></i> menor del promedio')
            }
            var dataEmpleador = new Array();
            dataEmpleador.push(
                {name:'Persona Juridica',y:parseInt(respuesta.empPersonaJ["COUNT(*)"])}, 
                {name:'Persona Natural', y:parseInt(respuesta.empPersonaN["COUNT(*)"])},
                {name:'Persona Natural con Negocio', y:parseInt(respuesta.empPersonaNnegocio["COUNT(*)"])}
                );
            var dataEstudiante = new Array();
            dataEstudiante.push(
                {name: 'Enfermeria Técnica', y:parseInt(respuesta.estEnfermeria["COUNT(*)"])},
                {name: 'Técnica en Farmacia', y:parseInt(respuesta.estFarmacia["COUNT(*)"])},
                {name: 'Técnica en Fisioterapia y Rehabilitación', y:parseInt(respuesta.estFisioterapia["COUNT(*)"])},
                {name: 'Técnica en Laboratorio Clínico', y:parseInt(respuesta.estLaboratorio["COUNT(*)"])},
                {name: 'Prótesis Dental', y:parseInt(respuesta.estProtesis["COUNT(*)"])}
            );
            var dataAvisos = new Array();
            dataAvisos.push(
                {name: 'Enfermeria Técnica', y:parseInt(respuesta.avisoEnfermeria["COUNT(*)"])},
                {name: 'Técnica en Farmacia', y:parseInt(respuesta.avisoFarmacia["COUNT(*)"])},
                {name: 'Técnica en Fisioterapia y Rehabilitación', y:parseInt(respuesta.avisoFisioterapia["COUNT(*)"])},
                {name: 'Técnica en Laboratorio Clínico', y:parseInt(respuesta.avisoLaboratorio["COUNT(*)"])},
                {name: 'Prótesis Dental', y:parseInt(respuesta.avisoProtesis["COUNT(*)"])}
            );
            Highcharts.chart('graficEmpleadores', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: 'Empleadores',
                    align: 'left'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.y}</b>'
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.y}'
                        }
                    }
                },
                series: [{
                    name: 'Registro',
                    colorByPoint: true,
                    data: dataEmpleador
                }]
            });

            Highcharts.chart('graficEstudiantes', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: 'Estudiantes',
                    align: 'left'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.y}</b>'
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.y}'
                        }
                    }
                },
                series: [{
                    name: 'Registro',
                    colorByPoint: true,
                    data: dataEstudiante
                }]
            });

            Highcharts.chart('graficAvisos', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: 'Avisos',
                    align: 'left'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.y}</b>'
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.y}'
                        }
                    }
                },
                series: [{
                    name: 'Registro',
                    colorByPoint: true,
                    data: dataAvisos
                }]
            });
            
        }

    })
}

// para contar cuantos datos repetidos hay dentro de un array
data = ["Saab", "Volvo", "BMW","Saab","Saab"]

const unique = Array.from(new Set(data));
const newData = unique.map((element) => {
  const key = element;
  let count = 0;
  data.forEach((e) => {
    if (element === e) {
      count++;
    }
  });
  return {
    key,
    count,
  };
});
/* console.log("neww data : ", newData) */