$( document ).ready(function() {
    /***NIVELES DE USUARIO
     * 
     * 1 - USUARIO NBORMAL
     * 2 - ADMINISTRADOR
     * 3 - RH
     * 4 - DH
     */
    let nivel_usuario = document.querySelector('#nivel_usuario').value;
    let usuario_activo = document.querySelector('#emp_activo').value;
    let super_activo = document.querySelector('#sup_activo').value;
    let usuario_correo = document.querySelector('#usuario_correo').value;

    let backButton = $( "#backButton" ),
        seccionLateral = $("#sidePaneAdmin"),
        transportes = $(".transportes"),
        dh = $(".dh"),
        dh1 = $(".dh1"),
        rh = $(".rh"),
        rh1 = $(".rh1"),
        rh2 = $(".rh2");

    console.log('mi correo ' + usuario_correo + '@mexq.com.mx');

    switch (nivel_usuario){
        case '': 
            rh.hide();
            rh1.hide();
            rh2.hide();
            break;
        case '1':
            
            break;
        case '2':
        
            break;
        case '3':
            transportes.hide();
            break;
        case '4':
            transportes.hide();
            rh1.hide();
            rh2.hide();
            break;
        case '5':
            transportes.hide();
            dh.hide();
            break;
        default:
            //**/ */
            break;
    }
});