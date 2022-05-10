//IMPORTAR URL DEL BACKEND
let backendURL = 'http://187.188.159.205:8090/web_serv/empService/controller.php';
//VARIABLE QUE GUARADARA LOS PARAMETROS DE LA URL
let searchParams = new URLSearchParams(window.location.search);
let check = searchParams.has('emp'); // SI ALGUN PARAMETRO ES IGUAL A emp LA VARIABLE SERA true
let botonImprimir = $('#btnPrint');
let seccionBotonImprimir = $('.seccionBotonImprimir');
const uppercaseWords = str => str.replace(/^(.)|\s+(.)/g, c => c.toUpperCase());


if (check) {
    let param = searchParams.get('emp'), //GUARDAR EL VALOR DE PARAMETRO
        action = 'datos-gafete';
    $.ajax({
        type: 'POST',
        url: backendURL, 
        data: { action: action, nomina : param }
    }).done(function(response){
        let respuesta = JSON.parse(response);
        let informacionCantidad = respuesta.informacion.length;
        if(informacionCantidad > 0){
            let informacion = respuesta.informacion[0];
            let nomina = $.trim(informacion.numero_nomina);
            let fechaAlta = (informacion.fecha_alta.date).substr(0, 10);
            let imss = $.trim(informacion.nss);
            let telefonoEmergencia = informacion.contacto_emergencia_numero;
            imss = `${imss.substr(0, 4)}-${imss.substr(4, 2)}-${imss.substr(6, 4)}-${$.trim(informacion.dv)}`;
            telefonoEmergencia = `${telefonoEmergencia.substr(0, 3)} - ${telefonoEmergencia.substr(3, 3)} - ${telefonoEmergencia.substr(6, 4)}`;
            $("#empFoto").attr("src","assets/files/" + nomina + "/" + nomina + ".jpg");
            $("#empNombre").html(uppercaseWords(informacion.nuevo_nombre));
            $("#empNumero").html(nomina);
            $("#empPuesto").html(informacion.puesto);
            $("#empAlta").html('Ingreso: ' + fechaAlta);
            $("#empNS").html(imss);
            $("#empEmergencia").html(telefonoEmergencia);
            $("#empDireccion").html(`Calle ${informacion.calle} #${informacion.numero_exterior}  <br/> Fracc. ${informacion.fraccionamiento} <br/> C.P. ${informacion.codigo_postal} ${informacion.estado}`);
            // $("#empNomina").attr("src",url);
            //JsBarcode("#empNomina", nomina,{lineColor: "#052467", font: "arial",displayValue: false});
        } else {
            // window.close();
            let timerInterval
            Swal.fire({
            title: 'No hay información',
            html: '<strong>No hay información del empleado disponible.</strong>',
            timer: 3500,
            onBeforeOpen: () => {
                Swal.showLoading()
                timerInterval = setInterval(() => {
                Swal.getContent().querySelector('')
                    .textContent = Swal.getTimerLeft()
                }, 100)
            },
            onClose: () => {
                clearInterval(timerInterval)
                window.close();
            }
            }).then((result) => {
            if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.timer
            ) {
                // console.log('I was closed by the timer')
                window.close();
            }
            })
        }
    }).fail(function(response) {
        console.log('ERR');
    });

} else {
    // SI NO EXISTE UN  PARAMETRO CIERRA LA PESTAÑA
    window.close();
}

botonImprimir.on('click',function(){
    // console.log('dsadasdasd');
    botonImprimir.addClass('d-none');
    window.print();
});
