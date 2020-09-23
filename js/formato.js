//IMPORTAR URL DEL BACKEND
let backendURL = 'http://187.188.159.205:8090/web_serv/empService/controller_.php';
//VARIABLE QUE GUARADARA LOS PARAMETROS DE LA URL
let searchParams = new URLSearchParams(window.location.search);
let check = searchParams.has('emp'); // SI ALGUN PARAMETRO ES IGUAL A emp LA VARIABLE SERA true


if (check) {
    let param = searchParams.get('emp'), //GUARDAR EL VALOR DE PARAMETRO
        action = 'datos-formato';
    $.ajax({
        type: 'POST',
        url: backendURL, 
        data: { action: action, nomina : param }
    }).done(function(response){
        let respuesta = JSON.parse(response);
        let informacionCantidad = respuesta.informacion.length;
        if(informacionCantidad > 0){
            let informacion = respuesta.informacion[0];
            let empStatus = informacion.status,
                empCambioPuesto = informacion.cambio_puesto,
                empClasificacion = informacion.clasificacion,
                tipoNominaEmpleado = informacion.nomina,
                registroPatronal = informacion.registro_patronal,
                empGenero = informacion.sexo,
                empEstadoCivil = informacion.estado_civil,
                nombreCompletoMadre = informacion.nombre_madre,
                infonavit = informacion.infonavit,
                fonacot = informacion.fonacot,
                cuenta = informacion.cuenta,
                lote = informacion.lote,
                nombreCompletoPadre = informacion.nombre_padre,
                correo = informacion.correo,
                calle = informacion.calle,
                fraccionamiento = informacion.fraccionamiento,
                planta = informacion.planta,
                tabulador = '';

            console.log(informacion);

            if(informacion.tabulador === undefined || informacion.tabulador === null){
                tabulador = '000|XXX'
            }else{
                tabulador = informacion.tabulador
            }
            let vTabulador = tabulador.split('|');

            let nombrePadre = nombreCompletoPadre.split('|');
            let nombreMadre = nombreCompletoMadre.split('|');

            if(lote === 'NULL')
                lote = '';

            $('#formatoFecha').html(informacion.fechaAlta);
            $('#nombreSucursal').html(informacion.sucursal);
            $('#claveSocio').html(informacion.clave_socio);
            $('#empLote').html(lote);
            $('#empNomina').html(informacion.numero_nomina);
            $('#empNombre').html(informacion.nombreEmpleado);
            $('#empApellidoPaterno').html(informacion.apellidoPaterno);
            $('#empApellidoMaterno').html(informacion.apellidoMaterno);
            $('#empTabulador').html(vTabulador[0]+vTabulador[1]);
            $('#empPuesto').html(informacion.puesto);
            $('#empCategoria').html(`$${informacion.salario_diario}`);
            $('#empRFC').html(informacion.RFC);
            $('#empCURP').html(informacion.CURP);
            $('#empNSS').html((informacion.nss).substr(0, 10));
            $('#empDV').html(informacion.dv);
            $('#empID').html(informacion.numero_identificacion);
            $('#empFechaAlta').html(informacion.fechaAlta);
            $('#empNacimiento').html(informacion.fechaNacimiento);
            $('#empLugarNacimiento').html(informacion.lugar_nacimiento);
            $('#empEscolaridad').html(informacion.escolaridad);
            $('#apellidoPaternoPadre').html(nombrePadre[0]);
            $('#apellidoMaternoPadre').html(nombrePadre[1]);
            $('#nombrePadre').html(nombrePadre[2]);
            $('#apellidoPaternoMadre').html(nombreMadre[0]);
            $('#apellidoMaternoMadre').html(nombreMadre[1]);
            $('#nombreMadre').html(nombreMadre[2]);
            $('#numeroExterior').html(informacion.numero_exterior.replace(/\s/g, ""));
            $('#numeroInterior').html(informacion.numero_interior.replace(/\s/g, ""));
            $('#codigoPostal').html(informacion.codigo_postal);
            $('#localidad').html(informacion.localidad);
            $('#municipio').html(informacion.municipio);
            $('#estado').html(informacion.estado);
            $('#numeroInfonavit').html(informacion.numero_infonavit);
            $('#numeroFonacot').html(informacion.numero_fonacot);
            $('#telefonoCelular').html(informacion.celular);
            $('#telefonoCasa').html(informacion.telefono);
            $('#numeroCuenta').html(informacion.numero_cuenta);

            $("#empFoto").attr("src","assets/files/" + informacion.numero_nomina + "/" + informacion.numero_nomina + ".jpg");

            if (empGenero === 'F')
                $('#empGenero').html('Femenino');
            else
                $('#empGenero').html('Masculino');

            if(empCambioPuesto === 1)
            {
                $('#empTipo').css('left','240');
            } else {
                if (empStatus === 'A')
                    $('#empTipo').css('left','90');
                else
                    $('#empTipo').css('left','145');
            }
            
            
            if (empClasificacion === 'O')
                $('#formatoTipo').css('left','185');
            else if (empClasificacion === 'AO')
                $('#formatoTipo').css('left','280');
            else if (empClasificacion === 'A')
                $('#formatoTipo').css('left','400');
            else if (empClasificacion === 'E')
                $('#formatoTipo').css('left','535');

            if (tipoNominaEmpleado === 'S')
                $('#tipoNomina').css('left','548');
            else
                $('#tipoNomina').css('left','642');

            if (registroPatronal === 'SAC')
                $('#empRegistro').css('left','640');
            else
                $('#empRegistro').css('left','698');
            
            if (empEstadoCivil === 'S')
                $('#empCivil').html('Soltero(a)');
            else if (empEstadoCivil === 'C')
                $('#empCivil').html('Casado(a)');
            else if (empEstadoCivil === 'D'){
                $('#empCivil').html('Divorciado(a)');
                $('#empCivil').css('font-size','73%');
            }else if (empEstadoCivil === 'V')
                $('#empCivil').html('Viudo(a)');

            //AJUSTAR TEXTO CORREO A CELDA
            if (correo.length <= 30){
                $('#correoElectronico').html(correo);
                $('#correoElectronico').css('font-size','68%');
                $('#correoElectronico').css('top','585px');
            } else {
                $('#correoElectronico').html(correo);
                $('#correoElectronico').css('font-size','58%');
                $('#correoElectronico').css('top','590px');
            }

            //AJUSTAR TEXTO CALLE A CELDA
            if (calle.length <= 22){
                $('#nombreCalle').html(calle);
                $('#nombreCalle').css('font-size','100%');
                $('#nombreCalle').css('top','510');
            } else {
                $('#nombreCalle').html(calle);
                $('#nombreCalle').css('font-size','63%');
                $('#nombreCalle').css('top','517');
            }
            
            //AJUSTAR TEXTO FACCIONAMIENTO A CELDA
            $('#fraccionamiento').html(informacion.fraccionamiento);
            if (fraccionamiento.length <= 22){
                $('#fraccionamiento').css('font-size','100%');
                $('#fraccionamiento').css('top','510');
            } else {
                $('#fraccionamiento').css('font-size','50%');
                $('#fraccionamiento').css('top','517');
            }
            
            //AJUSTAR TEXTO PLANTA A CELDA
            $('#nombrePlanta').html(informacion.planta);
            if (planta.length <= 12){
                $('#nombrePlanta').css('font-size','100%');
                $('#nombrePlanta').css('top','128');
            } else {
                $('#nombrePlanta').css('font-size','50%');
                $('#nombrePlanta').css('top','132');
            }


            if (infonavit.toLowerCase() === 'si')
                $('#infonavit').css('left','225');
            else
                $('#infonavit').css('left','185');

            if (fonacot.toLowerCase() === 'si')
                $('#fonacot').css('left','225');
            else
                $('#fonacot').css('left','185');

            if (cuenta.toLowerCase() === 'no')
                $('#cuentaBancaria').css('left','387');
            else
                $('#cuentaBancaria').css('left','332');



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