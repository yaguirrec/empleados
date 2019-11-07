$( document ).ready(function() {
eventListener();

function eventListener()
{
    document.querySelector('#loginForm').addEventListener('submit', checkIN);
}

function checkIN (e) 
{
    e.preventDefault();
    var user = document.querySelector('#txtNomina').value,
        password = document.querySelector('#txtClave').value,
        action = document.querySelector('#type').value;

    if(user === '' || password === '')
    {
        // la validación falló
        Swal.fire(
            'Error, campos vacios!',
            'Ambos campos son obligatorios!',
            'error'
          )
    }
    else
    {
            // datos que se envian al servidor
            var datos = new FormData();
            datos.append('usuario', user);
            datos.append('clave', password);
            datos.append('action', action);
            
            // crear el llamado a ajax
            var xhr = new XMLHttpRequest();
            
            // abrir la conexión.
            xhr.open('POST', 'http://187.188.159.205:8090/web_serv/empService/controller_.php', true);
            
            // retorno de datos
            xhr.onload = function(){
                if(this.status === 200 && this.readyState === 4) {
                    var respuesta = JSON.parse(xhr.responseText);
                    // console.log(respuesta);
                    // Si la respuesta es correcta
                    if(respuesta.estado === 'OK') 
                    {
                        var tipo = respuesta.tipo,
                            mensaje = respuesta.mensaje,
                            informacion = respuesta.informacion,
                            usuario_activo = respuesta.usuario_activo,
                            ubicacion = respuesta.ubicacion,
                            usuario_nombre = respuesta.usuario_nombre,
                            usuario_correo = respuesta.usuario_correo,
                            usuario_nivel = respuesta.usuario_nivel;
                            sesion = respuesta.sesion;
                            if(sesion)
                            {
                                //INICIAR SESION METODO (SEGURA)
                                asignarSesion(usuario_activo, usuario_nombre, usuario_nivel, usuario_correo);
                                Swal.fire({
                                    type: tipo,
                                    title: informacion,
                                    text: mensaje + ' ' + usuario_nombre,
                                    timer: 1800,
                                    showConfirmButton: false,
                                    backdrop: `
                                        rgba(13, 63, 114, 0.6)
                                        center top
                                        no-repeat
                                    `
                                }).then(function(){ 
                                    window.location.href = 'index.php?request=' + ubicacion;
                                })
                            }else
                            {
                                Swal.fire({
                                    type: tipo,
                                    title: informacion,
                                    text: mensaje,
                                    timer: 1800,
                                    showConfirmButton: false,
                                    backdrop: `
                                        rgba(13, 63, 114, 0.6)
                                        center top
                                        no-repeat
                                    `
                                }).then(function(){ 
                                    location.reload();
                                })
                            }
                            
                    }
                    else if(respuesta.estado === 'NOK')
                    {
                        var tipo = respuesta.tipo,
                            mensaje = respuesta.mensaje,
                            informacion = respuesta.informacion;
                        Swal.fire({
                            position: 'center',
                            type: 'error',
                            title: mensaje,
                            text: informacion,
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                }
            }
            // Enviar la petición
            xhr.send(datos);
    }
}

function asignarSesion( id, name, nivel, correo ){

    var u_nombre = name,
        u_nivel = nivel,
        u_correo = correo,
        u_activo = id;

    $.ajax({
        url: 'inc/model/nueva-sesion.php',
        type: 'GET',
        data: 'id=' + u_activo + '&name=' + u_nombre + '&nivel=' + u_nivel + '&correo=' + u_correo,
        error: function(xhr, status, error) {
            alert("error");
        }
    });
}
});