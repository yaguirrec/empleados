document.addEventListener("DOMContentLoaded", function(event) {  

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
    console.log(user + ' ' + password + ' ' + action);
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
            xhr.open('POST', 'http://187.188.159.205:8090/web_serv/empService/controller.php', true);
            
            // retorno de datos
            xhr.onload = function(){
                if(this.status === 200 && this.readyState === 4) {
                    var respuesta = JSON.parse(xhr.responseText);
                    console.log(respuesta);
                    // Si la respuesta es correcta
                    if(respuesta.estado === 'OK') 
                    {
                        var tipo = respuesta.tipo,
                            mensaje = respuesta.mensaje,
                            informacion = respuesta.informacion,
                            usuario_activo = respuesta.usuario_activo,
                            usuario_departamento = respuesta.usuario_departamento,
                            ubicacion = respuesta.ubicacion,
                            usuario_nombre = respuesta.usuario_nombre,
                            sesion = respuesta.sesion;
                            if(sesion)
                            {
                                //INICIAR SESION METODO (SEGURA)
                                asignarSesion(usuario_activo, usuario_nombre, usuario_departamento);
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
                                    // location.reload();
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
                        Swal.fire({
                            position: 'center',
                            type: 'error',
                            title: 'Hay un problema con la Base de datos!',
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

function asignarSesion( id, name, depto ){

    var u_nombre = name,
        u_depto = depto;
        u_activo = id;

    $.ajax({
        url: 'inc/model/nueva-sesion.php',
        type: 'GET',
        data: 'id=' + u_activo + '&name=' + u_nombre + '&depto_id=' + u_depto,
        error: function(xhr, status, error) {
            alert("error");
        }
    });
}
});