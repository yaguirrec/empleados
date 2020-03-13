$( document ).ready(function() {
    /***NIVELES DE USUARIO
     * 
     * 1 - USUARIO NBORMAL
     * 2 - ADMINISTRADOR
     * 3 - RH
     * 4 - DH
     * 5 - LABORALES
     * 6 - NOMINAS
     * 7 - TRANSPORTES
     * 8 - LABORALES SUPERVISOR  
     */
    let nivel_usuario = document.querySelector('#nivel_usuario').value;
    let usuario_activo = document.querySelector('#emp_activo').value;
    let super_activo = document.querySelector('#sup_activo').value;
    let usuario_correo = document.querySelector('#usuario_correo').value;
    let empleado_activo = document.querySelector('#empleado_activo').value;
    let seccionEnvioAltas = $('#seccionEnvioAltas');
    let seccionAcuseAltas = $('#seccionAcuseAltas');

    localStorage.setItem('nominaEmpleado', empleado_activo);

    let backButton = $( "#backButton" ),
        seccionLateral = $("#sidePaneAdmin"),
        seccionPanel = $(".seccionPanel"),
        administrador = $(".administrador"),
        dashboard = $(".dashboard"),
        transportes = $(".transportes"),
        general = $(".nav-item"),
        dh = $(".dh"),
        laborales = $(".laborales"),
        rh = $(".rh"),
        coordinadora = $(".coordinadora"),
        nominas = $(".nominas");

    console.log('Nivel usuario ' + nivel_usuario);


    switch (nivel_usuario){
        case '': 
            // DO NOTHING
            break;
        case '1':
            
            break;
        case '2':
            general.removeClass('d-none');
            laborales.removeClass('d-none');
            laborales.removeAttr('disabled');
            laborales.removeAttr('readonly');
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
            seccionEnvioAltas.removeClass('d-none');
            // gafetes.removeClass('d-none');
            break;
        case '6':
            seccionLateral.removeClass('d-none');
            seccionPanel.removeClass('d-none');
            nominas.removeClass('d-none');
            seccionAcuseAltas.removeClass('d-none');
            break;
        case '7':
            seccionLateral.removeClass('d-none');
            seccionPanel.removeClass('d-none');
            transportes.removeClass('d-none');
            break;
        case '8':
            seccionLateral.removeClass('d-none');
            seccionPanel.removeClass('d-none');
            laborales.removeClass('d-none');
            seccionEnvioAltas.removeClass('d-none');
            // laborales.removeAttr('disabled');
            // laborales.removeAttr('readonly');
            // gafetes.removeClass('d-none');
            break;
        case '99':
            coordinadora.removeClass('d-none');
            dashboard.addClass('d-none');
        break;
        default:
            seccionLateral.removeClass('d-none');
            break;
    }
});