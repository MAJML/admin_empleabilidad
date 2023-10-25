console.log("hola main de js");
alumnosOnline()

function alumnosOnline()
{
    $.ajax({
        dataType:"json",
        url:'Inicio/alumnosOnline',
        success:function(response){
            $("#alumnos_online").html(response['conectados'])

        },error:function(){
            console.log("ERROR GENERAL DEL SISTEMA, POR FAVOR INTENTE MÁS TARDE");
        }
    });
}