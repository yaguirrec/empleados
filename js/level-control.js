$( document ).ready(function() {
    /***NIVELES DE USUARIO
     * 
     * 1 - USUARIO NBORMAL
     * 2 - ADMINISTRADOR
     * 3 - RH
     * 4 - DH
     * 5 - LABORALES
     * 6 - NOMINAS
     */
    let nivel_usuario = document.querySelector('#nivel_usuario').value;
    let usuario_activo = document.querySelector('#emp_activo').value;
    let super_activo = document.querySelector('#sup_activo').value;
    let usuario_correo = document.querySelector('#usuario_correo').value;

    let backButton = $( "#backButton" ),
        seccionLateral = $("#sidePaneAdmin"),
        seccionPanel = $(".seccionPanel"),
        transportes = $(".transportes"),
        general = $(".nav-item"),
        dh = $(".dh"),
        laborales = $(".laborales"),
        rh = $(".rh"),
        nominas = $(".nominas");

    console.log('mi correo ' + usuario_correo     + '@mexq.com.mx');

    switch (nivel_usuario){
        case '': 
            // DO NOTHING
            break;
        case '1':
            
            break;
        case '2':
            general.removeClass('d-none');
            break;
        case '3':
            seccionLateral.removeClass('d-none');
            seccionPanel.removeClass('d-none');
            rh.removeClass('d-none');
            break;
        case '4':
            seccionLateral.removeClass('d-none');
            seccionPanel.removeClass('d-none');
            dh.removeClass('d-none');
            break;
        case '5':
            seccionLateral.removeClass('d-none');
            seccionPanel.removeClass('d-none');
            laborales.removeClass('d-none');
            // gafetes.removeClass('d-none');
            break;
        case '6':
            seccionLateral.removeClass('d-none');
            seccionPanel.removeClass('d-none');
            nominas.removeClass('d-none');
            break;
        default:
            //**/ */
            break;
    }
});