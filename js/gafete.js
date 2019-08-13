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
            let respuesta = JSON.parse(response);
            let informacion = respuesta.informacion[0];
            let nomina = $.trim(informacion.no_trab);
            let url = 'http://barcode.tec-it.com/barcode.ashx?data='+ nomina +'&code=Code128&dpi=210&color=%23000000';
            let imss = $.trim(informacion.no_imss);
            let telefonoEmergencia = informacion.telefono_emergencia;
            imss = `${imss.substr(0, 4)}-${imss.substr(4, 2)}-${imss.substr(6, 4)}-${$.trim(informacion.dv)}`;
            telefonoEmergencia = `${telefonoEmergencia.substr(0, 3)} - ${telefonoEmergencia.substr(3, 3)} - ${telefonoEmergencia.substr(6, 4)}`;
            $("#empFoto").attr("src","assets/files/" + nomina + "/" + nomina + ".jpg");
            $("#empNombre").html(informacion.nombre);
            $("#empPuesto").html(informacion.puesto);
            $("#empAlta").html('Ingreso: ' + informacion.empAlta);
            $("#empNS").html(imss);
            $("#empEmergencia").html(telefonoEmergencia);
            $("#empDireccion").html(`Calle ${informacion.calle} #${informacion.numero}  <br/> Fracc. ${informacion.fraccionamiento} <br/> C.P. ${informacion.cp} ${informacion.estado}`);
            // $("#empNomina").attr("src",url);
            JsBarcode("#empNomina", nomina,{lineColor: "#052467", font: "arial"});
        }
    });

} else {
    // SI NO EXISTE UN  PARAMETRO CIERRA LA PESTAÑA
    window.close();
}