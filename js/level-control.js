$( document ).ready(function() {
    var nivel_usuario = document.querySelector('#nivel_usuario').value;
    var usuario_activo = document.querySelector('#emp_activo').value;
    var super_activo = document.querySelector('#sup_activo').value;

    var backButton = $( "#backButton" ),
        seccionLateral = $("#sidePaneAdmin");

    console.log('mi nivel ' + nivel_usuario);

    switch (nivel_usuario){
        case '': 
        case '1':
            backButton.hide();
            seccionLateral.hide();
            break;
        default:
            //**/ */
            break;
    }
});