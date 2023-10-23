<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Curriculum Vitae Alumnos</title>
</head>
<style>
body {
    font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
}

.title_datos_personales {
    padding: 10px 0px;
    margin-bottom: 20px;
    border-bottom: 1px solid rgb(0, 0, 0);
    font-size: 20px;

}

.titulo_exp_laboral {
    padding: 10px 0px;
    margin-bottom: 10px;
    border-bottom: 1px solid rgb(0, 0, 0);
    font-size: 16px;
}

.titulo_educacion {
    padding: 10px 0px;
    margin-bottom: 10px;
    border-bottom: 1px solid rgb(0, 0, 0);
    font-size: 16px;
}

.titulo_cursos {
    margin-top: 0px;
    padding: 10px 0px;
    margin-bottom: 10px;
    border-bottom: 1px solid rgb(0, 0, 0);
    font-size: 16px;
}

.titulo_habilidades {
    margin-top: 0px;
    padding: 10px 0px;
    margin-bottom: 10px;
    border-bottom: 1px solid rgb(0, 0, 0);
    font-size: 16px;
}

.head_cv {
    position:relative;
    display: flex;
    margin-bottom: 0px;
    padding-bottom: 0px;
    flex-wrap: wrap;
}

.sect_datos_personales {
    margin-left: 0px;
    margin-bottom: 0px;
    width: 72%;
}

.img_perfil {
    position: absolute;
    width: 20%;
    top:30;
    height: 10px;
    margin-left: 530px;
}

.img_perfil img {
    width: 100%;
}

.border_bottom {
    margin-bottom: 20px;
    padding-bottom: 20px;
    border-bottom: 2px solid rgba(129, 129, 129, 0.363);
}

.caja_item_esperiencia {
    margin-left: 20px;
    /* display: flex; */
    margin-bottom: 10px;
}

.tipo_letra {
    font-size: 14px !important;
}

.titulo_nombres {
    font-size: 24px !important;
}

.letra_perfil_profesional {
    font-size: 14px !important;
    margin-bottom: -2px;
    text-align: justify;
}

.punto_negro_experiencia {
    margin-right: 15px;
}

.datos_experiencia {
    position: absolute;
    margin-left: 470px;
    margin-top:-108px;
}
.datos_experiencia_cursos{
    position: absolute;
    margin-left: 470px;
    margin-top:-52px;
}
.text_sector_experiencia {
    margin-left: 23px;
    font-size: 14px;
}

.text_puesto_experiencia {
    margin-left: 23px;
    font-size: 14px;
}

.text_empresa_experiencia {
    font-size: 14px;
}

.fin_exp {
    margin-top: 6px;
    margin-left: 24px;
    font-size: 14px;
}

.txt_area_educacion {
    font-size: 14px;
}

.txt_area_intitucion {
    font-size: 14px;
    margin-left: 24px;
}

.txt_fecha_fecha {
    font-size: 14px;
    margin-left: 24px;
}

.txt_estado_estado {
    font-size: 14px;
    margin-left: 26px;
}

.txt_curso_taller {
    font-size: 14px;
    margin-left: 26px;
}

.fecha_educacion {
    position: absolute;
    margin-left: 470px;
    margin-top:-37px;
}
</style>

<body>

    <div class="head_cv">

        <div class="sect_datos_personales">
            <h2 class="titulo_nombres">Marco Antonio Muñoz Lopez</h2>
            <div class="tipo_letra">
                <b>DNI:</b> <?php echo "esto es el DNI"; ?>,
                <b>Dirección:</b> Chorriillos - San Genaro,
                <b>Distrito:</b> Chorrillos
                <b>Celular: 983347365</b>,
                <b>Email: marco.antonio.9956@gmail.com</b>
            </div>

            </p>
            <p class='letra_perfil_profesional'>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae accusamus praesentium 
                doloremque corporis ipsum, reprehenderit porro cupiditate possimus inventore nemo 
                aspernatur voluptatibus doloribus accusantium sint facere debitis non ex delectus qui
                busdam autem odio. Recusandae assumenda unde possimus similique, sint corporis, tempor
                e temporibus quia obcaecati ab saepe quo, iste sit nam?
            </p>
        </div>
        <div class="img_perfil">
            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAJ1BMVEXt7e3V1dXW1tbm5ubs7Ozg4ODc3NzS0tLw8PDo6OjZ2dnj4+Pe3t5T9WAhAAAEmklEQVR4nO2ciXKsIBBFsQUB9f+/9+EuKjPEpe2X3FOVSTJlAmdaWRpUKQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP8Pbnh9mr4Uza+nnSpbChTTy0M/hNfKeNeXyIshW/BReaVZ4+h8zSY3lESG008rz+a30LIqFpbYDa1huxC1qovQDHAbUuG5DF3Tl8cmORdTs/Ua9VxuzUHXaA+WnsnQD90EUa1ZPlRtChoMuRobs5w0PLiGphJ5YlgNxVnGHrgeTlOuIkdD4imtx/B+qKNhzThOLF8xJE5D+4ohT2k9MLwZGD4ADG8Ghg8Aw5uB4QPINRxqdH14J9awmyG7summ5tfqJthQO1NY21wtUrKh7zJW9mqWTLLhcPDV9INYQ6XHqhXGXaqcXEM1L2/4S2k5qYbaNfP61LXEnFRDpWhJize/MIbrEAau1E6qoV75FfZKwlqmoVYmWiWmUp1ex5VpqKIQdhdkOG9/l2EcwuDYnu4UZRrq7frihSVOgYahKm2xUzw9eBNoqJy3O8Pi9CRDoqGqhv0+UQzpbKco0bAs9iEMVOeKlGeoVWpH0bnBmzxD5VMbbuhUJQUapkJI9tR5Ks+w+bBnqnRxXqr7razMx30d8gzTu4nI1nE1O8HWfkl0SDN0TXq7lKUwyYgqqrvDw9uftq1JM9RftoP57eF09PYaYYbOpNRG6vUIXLtqrH6bPk+FGX4LYdcpLripVSJbupSjMMNvISyiwZsu5sFdOlsly1Afa8Xn6Xzw9N96geTAXJShazMMi3I4WOsmejtlIMowbws4jRmbOOA2tV1dkGFoGbMMu9O0q24VZzpSSziCDKfttV8iSGOSv9wODRKjVkGGrs7Z/G0b1w/XdDy6Cz/b8rBIQYal3U7sj6j70WhoR+12AEt02CVKMdTpWVNk0TeZ4as5SgM0R8NTIYZDnTMYL7bjjpOO8uJCDFVeCKebX1Kt7tEcQ4xhXgjH/dPJgw96DCmGuyz3MdQ1pc4nj632QRRi+HXWNNJNghvz4cPwO0Uhht9nTeMfhqp+PGCf0BBimBnC8a8/fRzNdpFKhmFuCDOoZcYwa9aUyXZFXIThrTfO0qbHeN1QL+/exKbHeN1QZc6a8tnMMV431GHWdPM9s3W07/Z1Q+XKgxXfS8RZqfcN84bcP4LW6zfvG2YOuX9EGwavk9HrhvqBEEYbNt82/LTWdIFVVuptwweuwp6l23/bUD/zHJfVbsa3Df3nmcJpltP0bcPwziNR9GJaGqUbU91LG1g9BeN9w2v3GiSR0x8+9AAQSWOap4Hhzfx6Q1eNzxdiKU1F6yFshn0ILdPjcPoUCU2GLGVOeVG2p4u5aZWK68Lw/Vkavswdt/jmFDiN7A9WNB5hSf3WhoPpFKXrd9tmCi63irA8sI3mb+f2F58xvDF/n6VIwytXCFW/2Y7zyZ6TJVv3pPpnxPGzW655Ere9a+tpqLAVp2D/BNOa1TG54+1JfMXW4JDhDeCM9r5kwL+k92d4/vNFBAEAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD4Y/wDpoY2HBKwqLIAAAAASUVORK5CYII=" alt="">
        </div>

    </div>

    <!-- EXPERIENCIA LABORAL -->
    <div class="titulo_exp_laboral"><b>EXPERIENCIA LABORAL</b></div>

        <?php echo "jejejej hola como estan todos aq    uiaa"; ?>

    <div class="caja_item_esperiencia">
        <div class="data_experiencia1"><b class="punto_negro_experiencia">.</b> 
            <b class="text_empresa_experiencia">Inka Farma</b> <br>
            <span class="text_sector_experiencia">Sector Saluud</span> <br>
            <b class="text_puesto_experiencia">Enfermeria Tecnica</b> 
            <p class='fin_exp'>
                - Apoyo- Confort- Aseo
            </p>    
        </div>
        <div class="datos_experiencia">
            <p> ( 06/2022  -  04/2023 )</p>         
        </div>
    </div>
    <div class="caja_item_esperiencia">
        <div class="data_experiencia1"><b class="punto_negro_experiencia">.</b> 
            <b class="text_empresa_experiencia">Inka Farma</b> <br>
            <span class="text_sector_experiencia">Sector Saluud</span> <br>
            <b class="text_puesto_experiencia">Enfermeria Tecnica</b> 
            <p class='fin_exp'>
                - Apoyo- Confort- Aseo
            </p>    
        </div>
        <div class="datos_experiencia">
            <p> ( 06/2022  -  04/2023 )</p>         
        </div>
    </div>
    <div class="caja_item_esperiencia">
        <div class="data_experiencia1"><b class="punto_negro_experiencia">.</b> 
            <b class="text_empresa_experiencia">Inka Farma</b> <br>
            <span class="text_sector_experiencia">Sector Saluud</span> <br>
            <b class="text_puesto_experiencia">Enfermeria Tecnica</b> 
            <p class='fin_exp'>
                - Apoyo- Confort- Aseo
            </p>    
        </div>
        <div class="datos_experiencia">
            <p> ( 06/2022  -  04/2023 )</p>         
        </div>
    </div>

   <!--  EDUCACIÓN Y FORMACIÓN -->
    <div class="titulo_educacion"><B>EDUCACIÓN Y FORMACIÓN</B> </div>
    
    <div class="info-content">
        <div class="caja_item_esperiencia">
            <div class="data_experiencia1"><b class="punto_negro_experiencia">.</b>
                <b class="txt_area_educacion">TECNICA EN FISIOTERAPIA Y REHABILITACION </b> <br>
                <b class="txt_area_intitucion">INSTITUTO ARZOBISPO LOAYZA</b> <br>
                    <span class="fecha_educacion"> ( 06/2023 - 07/2023 )</span>
                    <span class="txt_estado_estado">Titulado</span>
            </div><br>
        </div>
    </div>

    <div class="info-content">
        <div class="caja_item_esperiencia">
            <div class="data_experiencia1"><b class="punto_negro_experiencia">.</b>
                <b class="txt_area_educacion">TECNICA EN FISIOTERAPIA Y REHABILITACION </b> <br>
                <b class="txt_area_intitucion">INSTITUTO ARZOBISPO LOAYZA</b> <br>
                    <span class="fecha_educacion"> ( 04/2021 - En Curso )</span>
                    <span class="txt_estado_estado">Estudiante del V ciclo</span>          
            </div><br>
        </div>
    </div>

    <!-- CURSOS -->
    <div class="titulo_cursos"><b>CURSOS</b></div>
    <div class="caja_item_esperiencia">
        <div class="data_experiencia1"><b class="punto_negro_experiencia">.</b> 
            <b class="text_empresa_experiencia">Inyectables</b> <br>
            <b class="text_sector_experiencia">INSTITUTO ARZOBISPO LOAYZA</b>
        </div>
        <div class="datos_experiencia_cursos">
            <p> ( 03/2023 - 06/2023 )</p>         
        </div>
    </div>
    <div class="caja_item_esperiencia">
        <div class="data_experiencia1"><b class="punto_negro_experiencia">.</b> 
            <b class="text_empresa_experiencia">Inyectables</b> <br>
            <b class="text_sector_experiencia">INSTITUTO ARZOBISPO LOAYZA</b>
        </div>
        <div class="datos_experiencia_cursos">
            <p> ( 03/2023 - 06/2023 )</p>         
        </div>
    </div>
    <div class="caja_item_esperiencia">
        <div class="data_experiencia1"><b class="punto_negro_experiencia">.</b> 
            <b class="text_empresa_experiencia">Inyectables</b> <br>
            <b class="text_sector_experiencia">INSTITUTO ARZOBISPO LOAYZA</b>
        </div>
        <div class="datos_experiencia_cursos">
            <p> ( 03/2023 - 06/2023 )</p>         
        </div>
    </div>

    <div class="titulo_habilidades"><b>OTRAS HABILIDADES</b> </div>
    Lorem ipsum dolor sit amet consectetur adipisicing elit. Placeat laudantium vita
    e tempora praesentium quos deserunt voluptates consequatur ex eligendi, sequi il
    lum, alias illo enim nostrum, nesciunt eius. Nesciunt maiores voluptatibus nobis 
    accusantium ea quia, quasi aut natus laboriosam repudiandae, corrupti rerum veri
    tatis delectus dolor magni. Nam, quisquam. Esse, sint nemo.


</body>

</html>