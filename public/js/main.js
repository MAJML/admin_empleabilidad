console.log('esto es el main');

$.ajax({
    /* type:"POST", */
    dataType:"json",
    url:'Usuario/TraerDataPorID',
    /* data: {id:idData}, */
    success:function(response){
      console.log("esto de la data de usuario: ",response)
    }
});