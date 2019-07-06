//IMPORTAR URL DEL BACKEND
let backendURL = 'http://187.188.159.205:8090/web_serv/empService/controller.php';
//VARIABLE QUE GUARADARA LOS PARAMETROS DE LA URL
let searchParams = new URLSearchParams(window.location.search);
let check = searchParams.has('emp'); // SI ALGUN PARAMETRO ES IGUAL A emp LA VARIABLE SERA true


if (check) {
    let param = searchParams.get('emp'), //GUARDAR EL VALOR DE PARAMETRO
        action = 'datos-gafete';
    $.ajax({
        type: 'POST',
        url: backendURL, 
        data: { action: action, nomina : param },
        success: function(response) {
            var respuesta = JSON.parse(response);
            var informacion = respuesta.informacion[0];
            var nomina = $.trim(informacion.no_trab);
            var url = 'http://barcode.tec-it.com/barcode.ashx?data='+ nomina +'&code=Code128&dpi=210';
            $("#empFoto").attr("src","assets/files/" + nomina + "/" + nomina + ".jpg");
            $("#empNombre").html(informacion.nombre);
            $("#empPuesto").html(informacion.puesto);
            $("#empAlta").html(informacion.empAlta);
            $("#empNS").html('IMSS: ' + informacion.no_imss);
            $("#empDireccion").html(informacion.calle + ' #' + informacion.numero + ' <br/>' + informacion.fraccionamiento + ' <br/> CP: ' + informacion.cp + ', ' + informacion.estado);
            $("#empNomina").attr("src",url);
        }
    });

} else {
    // SI NO EXISTE UN  PARAMETRO CIERRA LA PESTAÑA
    window.close();
}