console.log("esto es la consola de crear avisos");
ConsultarListaAvisosCreados()

/* $(document).ready(function(){
    $("#form_crear_aviso").on("submit", function(event) {
        event.preventDefault();
        $.ajax({
            type:"POST",
            dataType:"json",
            url: baseurl+'BR_avisos/CrearAviso',
            data:new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success:function(response){
                console.log("esto es la consola crear BR_AVISOS  : ", response)
                if(response == "ok"){
                    ConsultarListaAvisosCreados()
                    location.reload();
                    $("#form_crear_aviso").trigger("reset");
                }else{
                    console.log('no se ha podido crear');
                }
            }
        });
    });
}) */



function ConsultarListaAvisosCreados()
{
    $.ajax({
        dataType:"json",
        url: baseurl+'BR_avisos/ListaAvisosCreados',
        beforeSend:function(){
            $("#lista_cuentas_creadas li").remove()
        },
        success:function(response){
          console.log("response lista cuenta creadas empleadores : ", response);
          for (let i = 0; i < response.length; i++) {
            hora = new Date(response[i]['created_at'])
            html = '<li class="list-group-item">';
            html += '<div class="todo-indicator bg-success"></div>';
            html += '<div class="widget-content p-0">';
            html += '<div class="widget-content-wrapper">';
            html += '<div class="widget-content-left">';
            html += '<div class="widget-heading">'+response[i]['ruc'];
            html += '<div class="badge badge-warning ml-2">'+response[i]['distritos']+'</div>';
            html += '</div>';
            html += '<div class="widget-subheading"><i>'+response[i]['titulo']+'</i></div>';
            html += '</div>';
            html += '<div class="widget-content-right">';
            html += '<div class="widget-subheading"><i>hoy a las '+hora.getHours()+':'+hora.getMinutes()+'</i></div>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '</li>';
            $("#lista_cuentas_creadas").append(html)
          }
        }
    });
}