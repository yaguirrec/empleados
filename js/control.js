//GENERAL
$(document).ready(function () {

    // VALUE OF THE ACTUAL SECTION
    let searchParams = new URLSearchParams(window.location.search)
    let seccionActual = searchParams.get('request');
    let seccionBuscar = $(".seccionBuscar");
    let seccionEnvioAltas = $('.seccionEnvioAltas');
    let seccionAcuseAltas = $('.seccionAcuseAltas');
    let seccionExportar = $('.seccionExportar');
    let backendURL = 'http://187.188.159.205:8090/web_serv/empService/controller_.php';
    let localBackend = 'inc/model/';
    let senderLocal = 'inc/model/sender.php';
    let url_final = 'http://mexq.mx/';
    let url_dev = 'http://localhost/';
    let nivel_usuario = document.querySelector('#nivel_usuario').value;
    let empleado_activo = document.querySelector('#empleado_activo').value;

    let version = 'DEV041220';

    $('#version').html(version);

    // console.log(empleado_activo);

    $('#searchBox').keyup(function (event) {
        event.preventDefault();
        var code = (event.keyCode ? event.keyCode : event.which);
        if (code == 13) event.preventDefault();
        if (code == 32 || code == 13 || code == 188 || code == 186) {
            var txtBuscado = this.value,
                prop = (seccionActual === 'empleado' ? 'activos' : 'bajas');
            action = 'buscar-texto';
            // console.log(txtBuscado);
            $('#dataTable').empty();
            var consulta_parametros = new FormData();
            consulta_parametros.append('txtBuscado', txtBuscado);
            consulta_parametros.append('prop', prop);
            consulta_parametros.append('action', action);
            var xmlhr = new XMLHttpRequest();
            xmlhr.open('POST', backendURL, true);
            xmlhr.onload = function () {
                if (this.status === 200) {
                    var respuesta = JSON.parse(xmlhr.responseText);
                    // console.log(respuesta);
                    if (respuesta.estado === 'OK') {
                        var informacion = respuesta.informacion,
                            datos = respuesta.informacion.length;
                        if (datos < 1) {
                            $('#alertaM').removeClass('d-none');
                        } else {
                            for (var i in informacion) {
                                tablaEmpleados(informacion[i]);
                                $('#alertaM').addClass('d-none');
                                // $('#avisoR').hide();
                            }
                        }

                    } else if (respuesta.estado === 'NOK') {
                        var informacion = respuesta.informacion;
                        $('#alertaM').removeClass('d-none');
                        // $('#avisoR').hide();
                    }
                }
            }
            xmlhr.send(consulta_parametros);
        }
    });

    //TOGGLE BARSIDE
    $("#menu-toggle").click(function (e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });

    //VACIAR TABLA DE DATOS
    let limpiarTabla = () => {
        $('#dataTable').empty();
    }

    $("#btnSync").click(function (e) { 
        e.preventDefault();
        location.reload();
     });

    /**EXPORTAR A EXCEL */
    $('.exportTable').click(function () {
        $(".table").table2excel({
            containerid: ".table",
            datatype: 'table',
            name: "report",
            filename: "Reporte " + seccionActual, // Here, you can assign exported file name
            fileext: ".xls"
        });
    });

    /***BUSQUEDAD DE TEXTO GENERICA */
    $(document).ready(function () {
        $(".searchBox").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $("#dataTable tr").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });


    /**CERRAR SESION */
    $('.btnSalir').click(function () {
        localStorage.removeItem('codigoEmpleado');
        cerrarSesion();
    });

    function cerrarSesion() {
        // console.log('Cerrar sesion');
        var action = 'salir';
        var cerrar_sesion = new FormData();
        cerrar_sesion.append('action', action);
        var xmlhr = new XMLHttpRequest();
        xmlhr.open('POST', 'inc/model/control.php', true);
        xmlhr.onload = function () {
            if (this.status === 200) {
                var respuesta = JSON.parse(xmlhr.responseText);
                // console.log(respuesta);
                var tipo = respuesta.tipo,
                    titulo = respuesta.mensaje,
                    mensaje = respuesta.informacion;
                Swal.fire({
                    type: tipo,
                    title: titulo,
                    text: mensaje,
                    timer: 1800,
                    showConfirmButton: false,
                    backdrop: `
                                    rgba(13, 63, 114, 0.6)
                                    center top
                                    no-repeat
                                `
                }).then(function () {
                    // location.reload();
                    window.location.href = '../empleados/';
                })
            } else {
                swal({
                    title: 'Error!',
                    text: 'Hubo un error',
                    type: 'error'
                })
            }
        }
        xmlhr.send(cerrar_sesion);
    }

    let obtenerDatosEmpleados = () => {
        var nomina = $('#txtNomina').val(),
            jefenomina = $('#txtJefe').val(),
            tipoNomina = $('#txtTipoNomina').val(),
            tipo = $('#txtTipo').val(),
            lote = $("#txtLote").val(),
            sucursal = $('#txtSucursal').val(),
            clasificacion = $('#txtClasificacion').val(),
            salarioDiario = $('#txtSalarioDiario').val(),
            salarioMensual = $('#txtSalarioMensual').val(),
            celula = $('#txtCelula').val(),
            fechaAlta = $('#txtfechaAlta').val(),
            registro = $('#txtRegistro').val(),
            puesto = $('#txtPuesto').val(),
            comentario = $('#txtComentario').val(),
            nombre = $('#txtNombre').val(),
            aPaterno = $('#txtPaterno').val(),
            aMaterno = $('#txtMaterno').val(),
            curp = $('#txtCURP').val(),
            rfc = $('#txtRFC').val(),
            nss = $('#txtNSS').val(),
            dv = $('#txtDV').val(),
            fechaNacimiento = $('#txtfechaNacimiento').val(),
            lNacimiento = $('#txtLnacimiento').val(),
            genero = $('#txtGenero').val(),
            tIdentificacion = $('#txtTI').val(),
            id = $('#txtID').val(),
            eCivil = $('#txtCivil').val(),
            escolaridad = $('#txtEscolaridad').val(),
            cEscolaridad = $('#txtStescolaridad').val(),
            nPadre = $('#txtNombrePadre').val(),
            nMadre = $('#txtNombreMadre').val(),
            calle = $('#txtCalle').val(),
            numE = $('#txtNume').val(),
            numI = $('#txtNumi').val(),
            cp = $('#txtCP').val(),
            edo = $('#txtEdo').val(),
            municipio = $('#txtMunicipio').val(),
            localidad = $('#txtLocalidad').val(),
            fraccionamiento = $('#txtFraccionamiento').val(),
            infonavit = $('#txtInfonavit').val(),
            nInfonavit = $('#txtNinfonavit').val(),
            fonacot = $('#txtFonacot').val(),
            nFonacot = $('#txtNfonacot').val(),
            banco = $('#txtBanco').val(),
            cuenta = $('#txtCuenta').val(),
            correo = $('#txtCorreo').val(),
            telefono = $('#txtTelefono').val(),
            celular = $('#txtCelular').val(),
            contacto = $('#txtContacto').val(),
            nContacto = $('#txtNcontacto').val(),
            curpini = curp.substr(0, 4),
            curpfin = curp.substr(10, 8);
        rfcini = rfc.substr(0, 4);
        rfcfin = rfc.substr(10, 3);
        domicilio = `${calle} #${numE} Int.${numI} ${fraccionamiento}`;
        return {
            numero_nomina: nomina,
            nomina_jefe: jefenomina,
            tipo_nomina: tipoNomina,
            tipo_registro: tipo,
            lote: lote,
            id_sucursal: sucursal,
            clasificacion_empleado: clasificacion,
            salario_diario: salarioDiario,
            salario_mensual: salarioMensual,
            departamento: celula,
            fecha_alta: fechaAlta,
            registro_patronal: registro,
            puesto: puesto,
            comentario: comentario,
            nombre_emplead: nombre,
            apellido_paterno: aPaterno,
            apellido_materno: aMaterno,
            CURP: curp,
            CURPINI: curpini,
            CURPFIN: curpfin,
            RFC: rfc,
            RFCINI: rfcini,
            RFCINI: rfcfin,
            NSS: nss,
            DV: dv,
            fecha_nacimiento: fechaNacimiento,
            lugar_nacimiento: lNacimiento,
            sexo: genero,
            tipo_identificacion: tIdentificacion,
            numero_identificacion: id,
            estado_civil: eCivil,
            nivel_escolaridad: escolaridad,
            constancia: cEscolaridad,
            nombre_padre: nPadre,
            nombre_madre: nMadre,
            calle: calle,
            numero_exterior: numE,
            numero_interior: numI
        };
    };

    //LLENAR SUCURSAL TABULADOR
    let sucursalTabulador = () => {
        $.ajax({
            type: 'POST',
            url: backendURL,
            data: { action: 'sucursalTabulador' },
            success: function (response) {
                let respuesta = JSON.parse(response);
                let sucursalTab = respuesta.informacion,
                    campo = '<option value="">Selecciona un Sucursal...</option>';
                for (var i in sucursalTab) {
                    campo += '<option value="' + sucursalTab[i].code_value + '">' + sucursalTab[i].code_value + '</option>';
                }
                $('#txtTabSucursal').html(campo);
            }
        });
    }

    let listarDatosEmpleados = (numero_nomina) => {
        listarSucursales();
        $.ajax({
            type: 'POST',
            url: backendURL,
            data: { action: 'datos-empleado', numero_nomina: numero_nomina }
        }).done(function (response) {
            let respuesta = JSON.parse(response);
            if (respuesta.estado === 'OK') {
                var datos = respuesta.informacion[0];
                let nombreCompletoMadre = datos.nombre_madre,
                    nombreCompletoPadre = datos.nombre_padre,
                    tabulador = datos.tabulador;

                if (tabulador === null) {
                    tabulador = '00|X'
                }
                let vTabulador = tabulador.split('|');

                sucursalTabulador();

                let nombrePadre = nombreCompletoPadre.split('|');
                let nombreMadre = nombreCompletoMadre.split('|');

                $("#txtNomina").val(datos.numero_nomina);
                $("#txtTipo").val(datos.status);
                $("#txtLote").val(datos.lote);
                $("#txtClasificacion").val(datos.clasificacion);
                $("#txtSalarioDiario").val(datos.salario_diario);
                $("#txtSalarioMensual").val(datos.salario_mensual);
                $("#txtTipoNomina").val(datos.nomina);
                listarDepartamentos(datos.id_sucursal, datos.clasificacion);
                $("#txtfechaAlta").val((datos.fecha_alta.date).substr(0, 10));
                $("#txtRegistro").val(datos.registro_patronal);
                listarPuestos(datos.id_celula, datos.clasificacion);
                listarJefes(datos.id_puesto, datos.id_celula);
                $("#txtComentario").val(datos.comentarios);
                $("#txtNombre").val(datos.nombre);
                $("#txtPaterno").val(datos.apellido_paterno);
                $("#txtMaterno").val(datos.apellido_materno);
                $("#txtCURP").val(datos.CURP);
                $("#txtRFC").val(datos.RFC);
                $("#txtNSS").val(datos.nss);
                $("#txtDV").val(datos.dv);
                $("#txtfechaNacimiento").val((datos.fecha_nacimiento.date).substr(0, 10));
                $("#txtLnacimiento").val(datos.lugar_nacimiento);
                $("#txtGenero").val(datos.sexo);
                $("#txtTI").val(datos.identificacion);
                $("#txtID").val(datos.numero_identificacion);
                $("#txtCivil").val(datos.estado_civil);
                $("#txtEscolaridad").val(datos.escolaridad);
                $("#txtStescolaridad").val(datos.constancia);

                $("#txtNombrePadre").val(nombrePadre[2]);
                $("#txtApeMatPadre").val(nombrePadre[1]);
                $("#txtApePatPadre").val(nombrePadre[0]);

                $("#txtNombreMadre").val(nombreMadre[2]);
                $("#txtApeMatMadre").val(nombreMadre[1]);
                $("#txtApePatMadre").val(nombreMadre[0]);

                $("#txtCalle").val(datos.calle);
                $("#txtNume").val(datos.numero_exterior);
                $("#txtNumi").val(datos.numero_interior);
                $("#txtCP").val(datos.codigo_postal);
                listarFraccionamientos(datos.codigo_postal)
                $("#txtInfonavit").val(datos.infonavit);
                $("#txtNinfonavit").val(datos.numero_infonavit);
                $("#txtFonacot").val(datos.fonacot);
                $("#txtNfonacot").val(datos.numero_fonacot);
                $("#txtBanco").val(datos.cuenta);
                $("#txtCuenta").val(datos.numero_cuenta);
                $("#txtCorreo").val(datos.correo);
                $("#txtTelefono").val(datos.telefono);
                $("#txtCelular").val(datos.celular);
                $("#txtContacto").val(datos.contacto_emergencia_nombre);
                $("#txtNcontacto").val(datos.contacto_emergencia_numero);

                setTimeout(function () {
                    $("#txtSucursal").val(datos.id_sucursal);
                    $("#txtCelula").val(datos.id_celula);
                    $("#txtPuesto").val(datos.id_puesto);
                    $("#txtJefe").val(datos.jefe_nomina);
                    $("#txtEdo").val(datos.estado);
                    $("#txtMunicipio").val(datos.municipio);
                    $("#txtLocalidad").val(datos.localidad);
                    $("#txtTabClave").val(vTabulador[0]);
                    $("#txtTabSucursal").val(vTabulador[1]);
                }, 280);

                setTimeout(function () {
                    $("#txtFraccionamiento").val(datos.fraccionamiento.toUpperCase());
                }, 1000);

                $("#txtClasificacion").focusout(function () {
                    listarDepartamentos($("#txtSucursal").val(), $("#txtClasificacion").val());
                });

                $("#txtCelula").focusout(function () {
                    listarPuestos($("#txtCelula").val(), $("#txtClasificacion").val());
                });

                $("#txtCP").focusout(function () {
                    listarFraccionamientos($("#txtCP").val());
                });

                $("#txtClasificacion").focusout(function () {
                    listarJefes($("#txtClasificacion").val());
                });
            }
        });
    }

    let listarSucursales = () => {
        //LLENAR SUCURSALES
        var listaSUC = new FormData(),
            action = 'buscarSucursal';
        listaSUC.append('action', action);
        var xmlSUC = new XMLHttpRequest();
        xmlSUC.open('POST', backendURL, true);
        xmlSUC.onload = function () {
            if (this.status === 200) {
                var respuesta = JSON.parse(xmlSUC.responseText);
                if (respuesta.estado === 'OK') {
                    var informacion = respuesta.informacion;
                    var s = '<option value="" selected>Seleccionar una Sucursal</option>';
                    for (var i in informacion) {
                        s += '<option value="' + informacion[i].id_sucursal + '">' + informacion[i].nombre + '</option>';
                    }
                    $('#txtSucursal').html(s);
                } else if (respuesta.status === 'error') {
                    var informacion = respuesta.informacion;
                }
            }
        }
        xmlSUC.send(listaSUC);
    }

    let listarDepartamentos = (sucursal, clasificacion) => {
        var listaCEL = new FormData(),
            action = 'buscarCelula';
        listaCEL.append('action', action);
        listaCEL.append('sucursal', sucursal);
        listaCEL.append('clasificacion', clasificacion);
        var xmlCEL = new XMLHttpRequest();
        xmlCEL.open('POST', backendURL, true);
        xmlCEL.onload = function () {
            if (this.status === 200) {
                var respuesta = JSON.parse(xmlCEL.responseText);
                if (respuesta.estado === 'OK') {
                    var informacion = respuesta.informacion;
                    var s = '<option value="">Seleccionar celula</option>';
                    for (var i in informacion) {
                        s += '<option value="' + informacion[i].id_celula + '">' + informacion[i].nombre + ' - ' + informacion[i].codigo + '</option>';
                    }
                    $('#txtCelula').html(s);
                } else if (respuesta.status === 'error') {
                    var informacion = respuesta.informacion;
                }
            }
        }
        xmlCEL.send(listaCEL);
    }

    let listarPuestos = (paramCel, clasificacion) => {
        var listaP = new FormData(),
            action = 'buscarP';
        listaP.append('action', action);
        listaP.append('param', paramCel);
        listaP.append('clasificacion', clasificacion);
        var xmlP = new XMLHttpRequest();
        xmlP.open('POST', backendURL, true);
        xmlP.onload = function () {
            if (this.status === 200) {
                var respuesta = JSON.parse(xmlP.responseText);
                if (respuesta.estado === 'OK') {
                    var informacion = respuesta.informacion;
                    var s = '<option value="-1">Seleccionar tipo de puesto</option>';
                    for (var i in informacion) {
                        s += '<option value="' + informacion[i].id_puesto + '">' + informacion[i].nombre + '</option>';
                    }
                    $('#txtPuesto').html(s);
                } else if (respuesta.status === 'error') {
                    var informacion = respuesta.informacion;
                }
            }
        }
        xmlP.send(listaP);
    }

    let listarJefes = (paramClasificacion) => {
        var listaJefe = new FormData(),
            action = 'buscarJefe';
        listaJefe.append('action', action);
        listaJefe.append('param', paramClasificacion);
        var xmlJefe = new XMLHttpRequest();
        xmlJefe.open('POST', backendURL, true);
        xmlJefe.onload = function () {
            if (this.status === 200) {
                var respuesta = JSON.parse(xmlJefe.responseText);
                if (respuesta.estado === 'OK') {
                    var informacion = respuesta.informacion;
                    var s = '<option value="-1">Seleccionar al jefe</option>';
                    for (var i in informacion) {
                        s += '<option class="text-uppercase" value="' + informacion[i].numero_nomina + '">' + informacion[i].numero_nomina + ' - ' + informacion[i].nombre_largo + '</option>';
                    }
                    $('#txtJefe').html(s);
                } else if (respuesta.status === 'error') {
                    var informacion = respuesta.informacion;
                }
            }
        }
        xmlJefe.send(listaJefe);
    }


    let listarFraccionamientos = (cp) => {
        if (cp.length === 5) {
            $.ajax({
                type: "GET",
                url: "http://mexq.mx/devweb/webServices/cpmx/control.php?param=" + cp,
                success: function (data) {
                    let datos = JSON.parse(data),
                    s = '';
                    for (var i in datos) {
                        $("#txtEdo").val(datos[i].estado);
                        $("#txtMunicipio").val(datos[i].municipio);
                        $("#txtLocalidad").val(datos[i].ciudad);
                        s += '<option class="text-uppercase" value="' + datos[i].asentamiento.toUpperCase() + '">' + datos[i].asentamiento.toUpperCase() + '</option>';
                    }
                    $("#txtFraccionamiento").html(s);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR.status);
                }
            });
        } else {
            Swal.fire({
                position: 'center',
                type: 'warning',
                title: 'EL CP debe tener 5 digitos',
                showConfirmButton: false,
                timer: 1000
            })
        }
    }

    $("#exportInfo").click(function () {
        var action = 'json-empleados';
        var prop = (seccionActual === 'empleado' ? 'activos' : 'bajas');
        var encabezados = (seccionActual === 'empleado' ? ["NOMINA", "NOMBRE", "TABULADOR", "PUESTO", "FECHA ALTA", "SUCURSAL", "AREA", "CELULA", "WEB", "ERP", "NOMIPAQ"] : ["NOMINA", "NOMBRE", "TABULADOR", "PUESTO", "FECHA ALTA", "FECHA BAJA", "SUCURSAL", "AREA", "CELULA", "WEB", "ERP", "NOMIPAQ"]);
        var titulo = (seccionActual === 'empleado' ? 'Empleados activos' : 'Empleados inactivos');
        $('.seccionTitulo').text(titulo);
        if (seccionActual === 'empleado') {
            $('.columna-baja').addClass('d-none');
        } else {
            $('.columna-baja').removeClass('d-none');
        }
        var dataTable = new FormData();
        dataTable.append('action', action);
        dataTable.append('prop', prop);
        var xmlhr = new XMLHttpRequest();
        xmlhr.open('POST', backendURL, true);
        xmlhr.onload = function () {
            if (this.status === 200) {
                var respuesta = JSON.parse(xmlhr.responseText);
                console.log(respuesta);
                if (respuesta.estado === 'OK') {
                    var informacion = respuesta.informacion;

                    crearExcel(encabezados, informacion);

                } else if (respuesta.status === 'error') {
                    var informacion = respuesta.informacion;
                }
            }
        }
        xmlhr.send(dataTable);

        var createXLSLFormatObj = [];

        function crearExcel(encabezados, informacion) {
            var xlsHeader = encabezados;
            var xlsRows = informacion;

            createXLSLFormatObj.push(xlsHeader);
            $.each(xlsRows, function (index, value) {
                var innerRowData = [],
                    numeroNomina = value.numero_nomina;
                $("tbody").append('<tr><td>' + numeroNomina + '</td><td>' + value.Nombre + '</td><td>' + value.tabulador + '</td><td>' + value.Puesto + '</td><td>' + '</td><td>' + value.fechaAlta + '</td><td>' + value.Sucursal + '</td><td>' + value.Celula + '</td><td>' + value.status + '</td><td>' + value.emp_status + '</td><td>' + value.nominas_status +   '</td></tr>');
                $.each(value, function (ind, val) {
                    innerRowData.push(val);
                });
                createXLSLFormatObj.push(innerRowData);
            });


            /* File Name */
            var filename = "reporte-empleados-" + prop + ".xlsx";

            /* Sheet Name */
            var ws_name = "Empleados";

            // if (typeof console !== 'undefined') console.log(new Date());
            var wb = XLSX.utils.book_new(),
                ws = XLSX.utils.aoa_to_sheet(createXLSLFormatObj);

            /* Add worksheet to workbook */
            XLSX.utils.book_append_sheet(wb, ws, ws_name);

            /* Write workbook and Download */
            // if (typeof console !== 'undefined') console.log(new Date());
            XLSX.writeFile(wb, filename);
            // if (typeof console !== 'undefined') console.log(new Date());
        }

    });

    //REPORTE LABORALES
    $("#infoLaborales").click(function () {
        var action = 'reporteLaborales';
        var headers = ["NOMINA", "NOMBRE", "GENERO", "ALTA", "FECHA NACIMIENTO", "CURP", "RFC", "NSS", "SUCURSAL", "DEPARTAMENTO", "TABULADOR", "SALARIO DIARIO", "SALARIO MENSUAL", "CLASIFICACION", "ESTADO CIVIL", "LUGAR NACIMIENTO", "NUMERO IDENTIFICACION", "ESCOLARIDAD", "NOMBRE PADRE", "NOMBRE MADRE", "CP", "DOMICILIO", "ESTADO", "MUNICIPIO", "LOCALIDAD", "INFONAVIT", "NUMERO INFONAVIT", "FONACOT", "NUMERO FONACOT", "CUENTA", "NUMERO CUENTA", "CORREO", "TELEFONO", "CELULAR", "CONTACTO EMERGENCIA", "NUMERO EMERGENCIA"];
        var data_Table = new FormData();
        data_Table.append('action', action);
        var xmlhr = new XMLHttpRequest();
        xmlhr.open('POST', backendURL, true);
        xmlhr.onload = function () {
            if (this.status === 200) {
                var respuesta = JSON.parse(xmlhr.responseText);
                
                if (respuesta.estado === 'OK') {
                    var informacion = respuesta.informacion;

                    crear_Excel(headers, informacion);

                } else if (respuesta.status === 'error') {
                    var informacion = respuesta.informacion;
                }
            }
        }
        xmlhr.send(data_Table);
    });

        var createXLSLFormatObj_ = [];

        function crear_Excel(encabezados, informacion) {
            var xlsHeader = encabezados;
            var xlsRows = informacion;

            createXLSLFormatObj_.push(xlsHeader);
            $.each(xlsRows, function (index, value) {
                var innerRowData_ = [],
                    numeroNomina = value.numero_nomina;
                $("tbody").append('<tr><td>' + numeroNomina + '</td><td>' + value.nombre_largo + '</td><td>' + value.sexo + '</td><td>' + value.fechaAlta + '</td><td>' + 
                                value.fechaNacimiento + '</td><td>' + value.CURP + '</td><td>' + value.RFC + '</td><td>' + value.NSS + '</td><td>' + value.Sucursal + '</td><td>' + 
                                value.Departamento + '</td><td>' + value.tabulador + '</td><td>' + value.salario_diario + '</td><td>' + value.salario_mensual + '</td><td>' + 
                                value.Clasificacion + '</td><td>' + value.estado_civil + '</td><td>' + value.lugar_nacimiento + '</td><td>' + value.numero_identificacion + '</td><td>' + 
                                value.escolaridad +'</td><td>' + value.nombre_padre +'</td><td>' + value.nombre_madre +'</td><td>' + value.codigo_postal +'</td><td>' + value.domicilio_completo + '</td><td>' + 
                                value.estado +'</td><td>' + value.municipio + '</td><td>' + value.localidad + '</td><td>' + value.infonavit + '</td><td>' + value.numero_infonavit + '</td><td>' + 
                                value.fonacot +'</td><td>' + value.numero_fonacot + '</td><td>' + value.cuenta + '</td><td>' + value.numero_cuenta + '</td><td>' + value.correo + '</td><td>' + 
                                value.telefono +'</td><td>' + value.celular + '</td><td>' + value.contacto_emergencia_nombre + '</td><td>' + value.contacto_emergencia_numero + '</td></tr>');
                $.each(value, function (ind, val) {
                    innerRowData_.push(val);
                });
                createXLSLFormatObj_.push(innerRowData_);
            });


            /* File Name */
            var filename_ = "reporte_laborales_activos.xlsx";

            /* Sheet Name */
            var ws_name_ = "Empleados Activos";

            // if (typeof console !== 'undefined') console.log(new Date());
            var wb_ = XLSX.utils.book_new(),
                ws_ = XLSX.utils.aoa_to_sheet(createXLSLFormatObj_);

            /* Add worksheet to workbook */
            XLSX.utils.book_append_sheet(wb_, ws_, ws_name_);

            /* Write workbook and Download */
            // if (typeof console !== 'undefined') console.log(new Date());
            XLSX.writeFile(wb_, filename_);
            // if (typeof console !== 'undefined') console.log(new Date());
            setTimeout(function () {
                location.reload();
            }, 2000);
            
        }

    

    switch (seccionActual) {
        /**CARGAR TABLA EMPLEADOS COORDINADORAS*/
        case 'altasc': case 'bajasc':
            seccionExportar.removeClass('d-none');
            $('.columna-primer-jefe').addClass('d-none');
            $('.columna-actual-jefe').addClass('d-none');
            var action = 'empleados-sucursal',
                prop = (seccionActual === 'altasc' ? 'activos' : 'bajas');
                var titulo = (seccionActual === 'altasc' ? 'Empleados activos' : 'Empleados inactivos');
                $('.seccionTitulo').text(titulo);
                if (seccionActual === 'altasc') {
                    $('.columna-baja').addClass('d-none');
                } else {
                    $('.columna-baja').removeClass('d-none');
                }
            $.ajax({
                type: 'POST',
                url: backendURL,
                data: { action: action, nomina: empleado_activo, prop: prop},
                success: function (response) {
                    let respuesta = JSON.parse(response);
                    // seccionExportar
                    if (respuesta.estado === 'OK') {
                        var datos = respuesta.informacion.length;
                        var informacion = respuesta.informacion;
                        if (datos < 1) {
                            $('#alertaM').removeClass('d-none');
                        }
                        else {
                            $('#alertaM').addClass('d-none');
                            for (var i in informacion) {
                                tablaEmpleados(informacion[i]);
                            }
                        }
                    }
                }
            });

        break;
        case 'empleado': case 'bajas':
            seccionBuscar.removeClass('d-none');
            var action = 'lista-empleados';
            var prop = (seccionActual === 'empleado' ? 'activos' : 'bajas');
            var titulo = (seccionActual === 'empleado' ? 'Empleados activos' : 'Empleados inactivos');
            $('.seccionTitulo').text(titulo);
            if (seccionActual === 'empleado') {
                $('.columna-baja').addClass('d-none');
                $('.columna-primer-jefe').addClass('d-none');
            } else {
                $('.columna-baja').removeClass('d-none');
                $('.columna-primer-jefe').removeClass('d-none');
                $("#infoLaborales").addClass('d-none');
            }
            var dataTable = new FormData();
            dataTable.append('action', action);
            dataTable.append('prop', prop);
            var xmlhr = new XMLHttpRequest();
            xmlhr.open('POST', backendURL, true);
            xmlhr.onload = function () {
                if (this.status === 200) {
                    var respuesta = JSON.parse(xmlhr.responseText);
                    console.log(respuesta);
                    if (respuesta.estado === 'OK') {
                        var informacion = respuesta.informacion;
                        for (var i in informacion) {
                            tablaEmpleados(informacion[i]);
                        }
                    } else if (respuesta.status === 'error') {
                        var informacion = respuesta.informacion;
                    }
                }
            }
            xmlhr.send(dataTable);

            function tablaEmpleados(rowInfo) {
                var stEW = rowInfo.status,
                    stERP = rowInfo.emp_status,
                    stNOM = rowInfo.nominas_status,
                    vEW = 'fas fa-check',
                    vERP = 'fas fa-check',
                    vNOM = 'fas fa-check',
                    estado = '',
                    classEW = 'alert-success', 
                    classERP = 'alert-success', 
                    classNOM = 'alert-success';

                $('#loadingIndicator').addClass('d-none');

                if (stEW === 'B') {classEW = 'alert-danger'; vEW = 'fas fa-times';}
                if (stEW === null) {classEW = 'alert-danger'; vEW = 'fas fa-times';}
                if (stERP === 'I') {classERP = 'alert-danger'; vERP = 'fas fa-times';}
                if (stERP === null) {classERP = 'alert-danger'; vERP = 'fas fa-times';}
                if (stNOM === 'B') {classNOM = 'alert-danger'; vNOM = 'fas fa-times';}
                if (stNOM === null) {classNOM = 'alert-danger'; vNOM = 'fas fa-times';}
                
                if (stEW === 'B') {
                    estado = "alert-secondary";
                    status = 'Baja';
                }
                if (stEW === 'R') {
                    estado = "text-secondary";
                    status = 'Re-ingreso';
                }
                var row = $("<tr class='" + estado + " text-secondary'>");

                $("#dataTable").append(row); //this will append tr element to table... keep its reference for a while since we will add cels into it id_empleado
                // NUMERO DE EQUIPO
                // row.append($("<td class='trCode'>" + rowInfo.numero_nomina + " </td>"));
                row.append($("<td class='trCode'><button type='button' class='btn btnConsulta btn-link' data-id=" + rowInfo.numero_nomina + "' title='Ver información'>'" + rowInfo.numero_nomina + "</button></td>"));
                // NOMINA DEL EMPLEADO
                row.append($("<td class='text-left'> " + rowInfo.Nombre + " </td>"));
                row.append($("<td class='text-left'> " + rowInfo.tabulador + " </td>"));
                row.append($("<td class='text-left'> " + rowInfo.Puesto + " </td>"));
                row.append($("<td> " + rowInfo.fechaAlta + " </td>"));
                row.append($("<td> " + rowInfo.jefeActual + " </td>"));
                if (stEW === 'B') {
                    row.append($("<td> " + rowInfo.primerJefe + " </td>"));
                    row.append($("<td> " + rowInfo.fechaBaja + " </td>"));
                }
                row.append($("<td> " + rowInfo.Sucursal + " </td>"));
                row.append($("<td> " + rowInfo.Celula + " </td>"));
                row.append($("<td> <i class='" + vEW +" "+ classEW + "'></i></td>"));
                row.append($("<td> <i class='" + vERP +" "+ classERP + "'></i></td>"));
                row.append($("<td> <i class='" + vNOM +" "+ classNOM + "'></i> </td>"));
                // COLUMNA ACCION
                // row.append($("<td class='text-center'>"
                // + "<a class='btn btnConsulta text-white btn-primary' data-id='" + rowInfo.numero_nomina + "' role='button' title='Ver información'><i class='fas fa-info'></i> Ver</a>"
                //   + "</td>"));

                $(".btnConsulta").unbind().click(function () {
                    var employeeID = $((this)).data('id'),
                        url = "index.php?request=datos";
                    var newTab = window.open(url, '_blank');

                    //SAVE EMPLOYEE ID ON LOCAL STORAGE AS codigoEmpleado
                    localStorage.setItem('codigoEmpleado', employeeID);

                    // OPEN ON CURRENT TAB
                    //$(location).attr('href', url);

                    // OPEN ON NEW TAB
                    newTab.focus();
                });
            }
            break;
        //SECCION BECARIOS
        case 'becarios':
            seccionBuscar.removeClass('d-none');
            var action = 'lista-becarios';
            var titulo = 'Becarios';
            $('.seccionTitulo').text(titulo);
            if (seccionActual === 'becarios') {
                $('.columna-baja').addClass('d-none');
            } else {
                $('.columna-baja').removeClass('d-none');
            }
            var dataTable = new FormData();
            dataTable.append('action', action);
            var xmlhr = new XMLHttpRequest();
            xmlhr.open('POST', backendURL, true);
            xmlhr.onload = function () {
                if (this.status === 200) {
                    var respuesta = JSON.parse(xmlhr.responseText);
                    if (respuesta.estado === 'OK') {
                        var informacion = respuesta.informacion;
                        for (var i in informacion) {
                            tablaBecarios(informacion[i]);
                        }
                    } else if (respuesta.status === 'error') {
                        var informacion = respuesta.informacion;
                    }
                }
            }
            xmlhr.send(dataTable);

            function tablaBecarios(rowInfo) {
                var st = rowInfo.status,
                    status = 'Activo',
                    estado = '';

                $('#loadingIndicator').addClass('d-none');

                if (st === 'B') {
                    estado = "alert-secondary";
                    status = 'Baja';
                }
                if (st === 'R') {
                    estado = "text-secondary";
                    status = 'Re-ingreso';
                }
                var row = $("<tr class='" + estado + " text-secondary'>");

                $("#dataTable").append(row); //this will append tr element to table... keep its reference for a while since we will add cels into it id_empleado
                // NUMERO DE EQUIPO
                row.append($("<td><a href='formato.php?emp=" + rowInfo.numero_nomina + "' title='Formato de Alta' target='_blank'>" + rowInfo.numero_nomina + "</a></td>"));
                // NOMINA DEL EMPLEADO
                row.append($("<td class='text-left'> " + rowInfo.Nombre + " </td>"));
                row.append($("<td class='text-left'> " + rowInfo.Puesto + " </td>"));
                row.append($("<td> " + rowInfo.fechaAlta + " </td>"));
                if (st === 'B') {
                    row.append($("<td> " + rowInfo.fechaBaja + " </td>"));
                }
                row.append($("<td> " + rowInfo.Sucursal + " </td>"));
                row.append($("<td> " + rowInfo.Celula + " </td>"));
                row.append($("<td> " + status + " </td>"));
                // COLUMNA ACCION
                row.append($("<td class='text-center'>"
                    + "<a class='btn btnConsulta text-white btn-facebook btn-circle btn-sm' data-id='" + rowInfo.numero_nomina + "' role='button' title='Ver información'><i class='fas fa-info'></i></a>"
                    + "</td>"));

                $(".btnConsulta").unbind().click(function () {
                    var employeeID = $((this)).data('id'),
                        url = "index.php?request=datos";
                    // newTab = window.open(url, '_blank');

                    //SAVE EMPLOYEE ID ON LOCAL STORAGE AS codigoEmpleado
                    localStorage.setItem('codigoEmpleado', employeeID);

                    // OPEN ON CURRENT TAB
                    $(location).attr('href', url);

                    // OPEN ON NEW TAB
                    // newTab.focus();
                });
            }
            break;

        //SECCION CI
        case 'ci':
            seccionExportar.removeClass('d-none');
            var action = 'listar-ci';
            var titulo = 'Reporte CI';
            $('.seccionTitulo').text(titulo);
            var dataTable = new FormData();
            dataTable.append('action', action);
            dataTable.append('prop', prop);
            var xmlhr = new XMLHttpRequest();
            xmlhr.open('POST', backendURL, true);
            xmlhr.onload = function () {
                if (this.status === 200) {
                    var respuesta = JSON.parse(xmlhr.responseText);
                    // console.log(respuesta);
                    if (respuesta.estado === 'OK') {
                        var informacion = respuesta.informacion;
                        for (var i in informacion) {
                            tablaCI(informacion[i]);
                        }
                    } else if (respuesta.status === 'error') {
                        var informacion = respuesta.informacion;
                    }
                }
            }
            xmlhr.send(dataTable);

            function tablaCI(rowInfo) {
                

                $('#loadingIndicator').addClass('d-none');

                var row = $("<tr class='text-secondary'>");

                $("#dataTable").append(row); //this will append tr element to table... keep its reference for a while since we will add cels into it id_empleado
                // NUMERO DE EQUIPO
                row.append($("<td>" + rowInfo.numero_nomina + " </td>"));
                // NOMINA DEL EMPLEADO
                row.append($("<td> " + rowInfo.nombre_largo + " </td>"));
                row.append($("<td> " + rowInfo.Puesto + " </td>"));
                row.append($("<td> " + rowInfo.Clasificacion + " </td>"));
                row.append($("<td> " + rowInfo.Sucursal + " </td>"));
                row.append($("<td> " + rowInfo.Departamento + " </td>"));
                row.append($("<td> " + rowInfo.fechaAlta + " </td>"));
                row.append($("<td> " + rowInfo.fecha_nacimiento + " </td>"));
                row.append($("<td> " + rowInfo.NSS + " </td>"));
                if (nivel_usuario === '6' || nivel_usuario === '2'){
                    row.append($("<td> " + rowInfo.RFC + " </td>"));
                    row.append($("<td> " + rowInfo.numero_cuenta + " </td>"));
                }
                
            }
            break;
        //SECCION CI
        

        //SECCION BAJAS POR PUESTO
        case 'bajaPuesto':
            seccionBuscar.removeClass('d-none');
            var action = 'listaBajasPuesto';
            var titulo = 'Bajas por cambio de puesto';
            $('.seccionTitulo').text(titulo);

            var dataTable = new FormData();
            dataTable.append('action', action);
            var xmlhr = new XMLHttpRequest();
            xmlhr.open('POST', backendURL, true);
            xmlhr.onload = function () {
                if (this.status === 200) {
                    var respuesta = JSON.parse(xmlhr.responseText);
                    if (respuesta.estado === 'OK') {
                        var informacion = respuesta.informacion;
                        for (var i in informacion) {
                            tablaBajasPuesto(informacion[i]);
                        }
                    } else if (respuesta.status === 'error') {
                        var informacion = respuesta.informacion;
                    }
                }
            }
            xmlhr.send(dataTable);

            function tablaBajasPuesto(rowInfo) {
                var st = rowInfo.status,
                    status = 'Activo',
                    estado = '';

                $('#loadingIndicator').addClass('d-none');

                if (st === 'B') {
                    estado = "alert-secondary";
                    status = 'Baja';
                }
                if (st === 'R') {
                    estado = "text-secondary";
                    status = 'Re-ingreso';
                }
                var row = $("<tr class='" + estado + " text-secondary'>");

                $("#dataTable").append(row); //this will append tr element to table... keep its reference for a while since we will add cels into it id_empleado
                // NUMERO DE EQUIPO
                // row.append($("<td><a href='formato.php?emp=" + rowInfo.numero_nomina + "' title='Formato de Alta' target='_blank'>" + rowInfo.numero_nomina + "</a></td>"));
                // NOMINA DEL EMPLEADO
                row.append($("<td class='text-left'> " + rowInfo.numero_nomina + " </td>"));
                row.append($("<td class='text-left'> " + rowInfo.Nombre + " </td>"));
                row.append($("<td class='text-left'> " + rowInfo.Puesto + " </td>"));
                row.append($("<td> " + rowInfo.fechaAlta + " </td>"));
                if (st === 'B') {
                    row.append($("<td> " + rowInfo.fechaBaja + " </td>"));
                }
                row.append($("<td> " + rowInfo.Sucursal + " </td>"));
                row.append($("<td> " + rowInfo.Celula + " </td>"));
                row.append($("<td> " + status + " </td>"));
                // COLUMNA ACCION
                row.append($("<td class='text-center'>"
                    + "<a class='btn btnConsulta text-white btn-facebook btn-circle btn-sm' data-id='" + rowInfo.numero_nomina + "' role='button' title='Ver información'><i class='fas fa-info'></i></a>"
                    + "</td>"));

                $(".btnConsulta").unbind().click(function () {
                    var employeeID = $((this)).data('id'),
                        url = "index.php?request=datos";
                    // newTab = window.open(url, '_blank');

                    //SAVE EMPLOYEE ID ON LOCAL STORAGE AS codigoEmpleado
                    localStorage.setItem('codigoEmpleado', employeeID);

                    // OPEN ON CURRENT TAB
                    $(location).attr('href', url);

                    // OPEN ON NEW TAB
                    // newTab.focus();
                });
            }
            break;
        // ENVIAR ALTAS A NOMINAS
        case 'altas':
            let btnConsultarAltas = $('#btnConsultaAltas'),
                btnEnviarAltas = $('#btnEnviarAltas'),
                btnEnviarAcuse = $('#btnEnviarAcuse'),
                btnEnviarProcesada = $('#btnEnviarProcesada'),
                radioAcuse = $('#radioAcuse'),
                radioProcesadas = $('#radioProcesada'),
                divAcuses = $('#divAcuses'),
                divProcesadas = $('#divProcesadas'),
                datosEmpleados = [];
            obtenerAltas();
            btnConsultarAltas.click(function (e) {
                e.preventDefault();
                $('#dataTable').empty();
                obtenerAltas();
            });

            radioAcuse.click(function (e) {
                divAcuses.removeClass('d-none');
                divProcesadas.addClass('d-none');
            });

            radioProcesadas.click(function (e) {
                divProcesadas.removeClass('d-none');
                divAcuses.addClass('d-none');
            });

            function obtenerAltas() {
                var action = 'altas',
                    fecha = $('#txtFechaAltas').val();
                var dataTable = new FormData();
                dataTable.append('action', action);
                dataTable.append('prop', fecha);
                var xmlhr = new XMLHttpRequest();
                xmlhr.open('POST', backendURL, true);
                xmlhr.onload = function () {
                    if (this.status === 200) {
                        var respuesta = JSON.parse(xmlhr.responseText);
                        if (respuesta.estado === 'OK') {
                            var datos = respuesta.informacion.length;
                            var informacion = respuesta.informacion;
                            if (datos < 1) {
                                $('#alertaM').removeClass('d-none');
                                seccionEnvioAltas.addClass('d-none');
                                seccionAcuseAltas.addClass('d-none');
                            }
                            else {
                                $('#alertaM').addClass('d-none');

                                for (var i in informacion) {
                                    tablaAltas(informacion[i]);
                                    datosEmpleados[i] = `${informacion[i].numero_nomina} - ${informacion[i].nombre_largo}.`;
                                }
                            }
                        } else if (respuesta.status === 'error') {
                            var informacion = respuesta.informacion;
                            $('#alertaM').removeClass('d-none');
                        }
                    }
                }
                xmlhr.send(dataTable);

                function tablaAltas(rowInfo) {
                    var row = $("<tr>"),
                        acuse = rowInfo.lote_acuse,
                        procesada = rowInfo.lote;

                    if (acuse == null || acuse == '') {
                        acuse = '';
                    }
                    if (procesada == null || procesada == '') {
                        procesada = '';
                    }

                    seccionExportar.removeClass('d-none');

                    $("#dataTable").append(row); //this will append tr element to table... keep its reference for a while since we will add cels into it id_empleado

                    row.append($("<td><input class='form-check-input position-static ml-2 text-center' name='noNomina' type='checkbox' id='blankCheckbox' value='" + rowInfo.numero_nomina + "'>" + "</td>"));
                    row.append($("<td><a href='formato.php?emp=" + rowInfo.numero_nomina + "' title='Formato de Alta' target='_blank'>" + rowInfo.numero_nomina + "</a></td>"));
                    row.append($("<td> " + rowInfo.nss + " </td>"));
                    row.append($("<td> " + rowInfo.nombre_largo + " </td>"));
                    row.append($("<td> " + rowInfo.salario_diario + " </td>"));
                    row.append($("<td> " + rowInfo.sucursal + " </td>"));
                    row.append($("<td> " + rowInfo.planta + " </td>"));
                    row.append($("<td> " + rowInfo.fechaAlta + " </td>"));
                    row.append($("<td> " + rowInfo.registro_patronal + " </td>"));
                    row.append($("<td> " + rowInfo.registro_patronal + ' ' + rowInfo.tipo_nomina + " </td>"));
                    row.append($("<td><a href='assets/attached/Acuses/" + rowInfo.lote_acuse + ".zip' target='_blank'>" + acuse + "</a></td>"));
                    row.append($("<td><a href='assets/attached/Procesadas/" + rowInfo.lote + ".zip' target='_blank'>" + procesada + "</a></td>"));
                }
            }

            btnEnviarAltas.click(function (e) {
                e.preventDefault();
                var action = 'envioAltas',
                    fecha = $('#txtFechaAltas').val(),
                    cc = $('#usuario_correo').val();

                $.ajax({
                    type: 'POST',
                    url: localBackend + 'sender.php',
                    data: { action: action, fecha: fecha, datos: datosEmpleados, cc: cc },
                    success: function (response) {
                        // let respuesta = JSON.parse(response);
                    }
                });
                Swal.fire({
                    position: 'center',
                    type: 'success',
                    title: 'Informe de altas enviado a Nominas',
                    showConfirmButton: false,
                    timer: 1800
                })
            });

            btnEnviarAcuse.click(function (e) {
                e.preventDefault();
                var action = 'envioAcuse';

                let numerosNomina = [];
                $.each($("input[name='noNomina']:checked"), function () {
                    numerosNomina.push($(this).val());
                });
                let adjunto_Acuse = document.getElementById('txtAcuse');
                let adjuntoAcuse = adjunto_Acuse.files[0];
                let nombreAdjuntoAcuse = adjunto_Acuse.files[0].name;
                nombreAdjuntoAcuse = nombreAdjuntoAcuse.substr(23, 9);

                var datosAcuse = new FormData();
                datosAcuse.append('action', action);
                datosAcuse.append('arrNomina', numerosNomina.join("|"));
                datosAcuse.append('nombreAdjuntoAcuse', nombreAdjuntoAcuse);

                var xhr = new XMLHttpRequest();
                xhr.open('POST', backendURL, true);
                xhr.send(datosAcuse);
                xhr.onload = function () {
                    if (this.status === 200 && this.readyState == 4) {
                        var respuesta = JSON.parse(xhr.responseText);
                        if (respuesta.estado === 'OK') {
                            Swal.fire({
                                title: 'Alta exitosa!',
                                text: 'Alta de acuse exitosa!',
                                type: 'success'
                            })
                                .then(resultado => {
                                    if (resultado.value) {
                                        location.reload();
                                    }
                                })
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Hubo un error',
                                type: 'error'
                            })
                        }
                    }
                }

                var archivoAcuse = new FormData();
                archivoAcuse.append('action', action);
                archivoAcuse.append('adjuntoAcuse', adjuntoAcuse);
                archivoAcuse.append('nombreAdjuntoAcuse', nombreAdjuntoAcuse);

                var xhtr = new XMLHttpRequest();
                xhtr.open('POST', localBackend + 'control.php', true);
                xhtr.send(archivoAcuse);
                xhtr.onload = function () {
                    if (this.status === 200 && this.readyState == 4) {
                        // var respuesta = JSON.parse(xhtr.responseText);
                        // console.log(respuesta);
                    }
                }
            });

            btnEnviarProcesada.click(function (e) {
                e.preventDefault();
                let action = 'envioProcesada';
                let numerosNomina = [];
                $.each($("input[name='noNomina']:checked"), function () {
                    numerosNomina.push($(this).val());
                });

                let adjunto_Procesada = document.getElementById('txtProcesada');
                let adjuntoProcesada = adjunto_Procesada.files[0];
                let nombreAdjuntoProcesada = adjunto_Procesada.files[0].name;
                nombreAdjuntoProcesada = nombreAdjuntoProcesada.substr(21, 9);

                var datosProcesada = new FormData();
                datosProcesada.append('action', action);
                datosProcesada.append('arrNomina', numerosNomina.join("|"));
                datosProcesada.append('nombreAdjuntoProcesada', nombreAdjuntoProcesada);

                var xhr = new XMLHttpRequest();
                xhr.open('POST', backendURL, true);
                xhr.send(datosProcesada);
                xhr.onload = function () {
                    if (this.status === 200 && this.readyState == 4) {
                        var respuesta = JSON.parse(xhr.responseText);
                        if (respuesta.estado === 'OK') {
                            Swal.fire({
                                title: 'Alta exitosa!',
                                text: 'Alta de procesada exitosa!',
                                type: 'success'
                            })
                                .then(resultado => {
                                    if (resultado.value) {
                                        location.reload();
                                    }
                                })
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Hubo un error',
                                type: 'error'
                            })
                        }
                    }
                }

                var archivoProcesada = new FormData();
                archivoProcesada.append('action', action);
                archivoProcesada.append('adjuntoProcesada', adjuntoProcesada);
                archivoProcesada.append('nombreAdjuntoProcesada', nombreAdjuntoProcesada);

                var xhtr = new XMLHttpRequest();
                xhtr.open('POST', localBackend + 'control.php', true);
                xhtr.send(archivoProcesada);
                xhtr.onload = function () {
                    if (this.status === 200 && this.readyState == 4) {
                        // var respuesta = JSON.parse(xhtr.responseText);
                        // console.log(respuesta);
                    }
                }

            });



            break;
        case 'administrarBajas':
            let btnConsultaBajas = $('#btnConsultaBajas'),
                btnEnviarBajas = $('#btnEnviarBajas'),
                btnEnviarAcuseBaja = $('#btnEnviarAcuseBaja'),
                btnEnviarProcesadaBaja = $('#btnEnviarProcesadaBaja'),
                radioAcuseBaja = $('#radioAcuseBaja'),
                radioProcesadasBaja = $('#radioProcesadasBaja'),
                divAcusesBaja = $('#divAcusesBaja'),
                divProcesadasBaja = $('#divProcesadasBaja'),
                btnFechaBaja = $('#btnFechaBaja'),
                datosEmpleadosBajas = [];

            let obtenerBajas = () => {
                var action = 'bajas',
                    fecha = $('#txtFechaBajas').val();
                var dataTable = new FormData();
                dataTable.append('action', action);
                dataTable.append('prop', fecha);
                var xmlhr = new XMLHttpRequest();
                xmlhr.open('POST', backendURL, true);
                xmlhr.onload = function () {
                    if (this.status === 200) {
                        var respuesta = JSON.parse(xmlhr.responseText);
                        // console.log(respuesta);
                        if (respuesta.estado === 'OK') {
                            var datos = respuesta.informacion.length;
                            var informacion = respuesta.informacion;
                            if (datos < 1) {
                                $('#alertaM').removeClass('d-none');
                                seccionEnvioAltas.addClass('d-none');
                                seccionAcuseAltas.addClass('d-none');
                            }
                            else {
                                $('#alertaM').addClass('d-none');

                                for (var i in informacion) {
                                    tablaBajas(informacion[i]);
                                    datosEmpleadosBajas[i] = `${informacion[i].numero_nomina} - ${informacion[i].nombre_largo}.`;
                                }
                            }
                        } else if (respuesta.status === 'error') {
                            var informacion = respuesta.informacion;
                            $('#alertaM').removeClass('d-none');
                        }
                    }
                }
                xmlhr.send(dataTable);

                function tablaBajas(rowInfo) {
                    var row = $("<tr>"),
                        motivoBaja = rowInfo.bajaMotivo,
                        acuse = rowInfo.baja_acuse,
                        procesada = rowInfo.baja_procesada;

                    if (motivoBaja == null)
                        motivoBaja = 'No especificado';

                    if (acuse == null || acuse == '') {
                        acuse = '';
                    }
                    if (procesada == null || procesada == '') {
                        procesada = '';
                    }

                    seccionExportar.removeClass('d-none');

                    $("#dataTable").append(row); //this will append tr element to table... keep its reference for a while since we will add cels into it id_empleado

                    row.append($("<td><input class='form-check-input position-static ml-2 text-center' name='noNomina' type='checkbox' id='blankCheckbox' value='" + rowInfo.numero_nomina + "'>" + "</td>"));
                    // row.append($("<td><a href='formato.php?emp=" + rowInfo.numero_nomina + "' title='Formato de Alta' target='_blank'>" + rowInfo.numero_nomina + "</a></td>"));
                    row.append($("<td>" + rowInfo.numero_nomina + "</td>"));
                    row.append($("<td> " + rowInfo.nss + " </td>"));
                    row.append($("<td> " + rowInfo.nombre_largo + " </td>"));
                    row.append($("<td> " + rowInfo.salario_diario + " </td>"));
                    row.append($("<td> " + rowInfo.sucursal + " </td>"));
                    row.append($("<td> " + rowInfo.planta + " </td>"));
                    row.append($("<td> " + rowInfo.fechaBaja + " </td>"));
                    row.append($("<td> " + rowInfo.registro_patronal + " </td>"));
                    row.append($("<td> " + rowInfo.registro_patronal + ' ' + rowInfo.tipo_nomina + " </td>"));
                    row.append($("<td> " + motivoBaja + " </td>"));
                    row.append($("<td><a href='assets/attached/Bajas/Acuses/" + rowInfo.baja_acuse + ".zip' target='_blank'>" + acuse + "</a></td>"));
                    row.append($("<td><a href='assets/attached/Bajas/Procesadas/" + rowInfo.baja_procesada + ".zip' target='_blank'>" + procesada + "</a></td>"));
                }
            }

            obtenerBajas();

            btnConsultaBajas.click(function (e) {
                e.preventDefault();
                $('#dataTable').empty();
                obtenerBajas();
            });

            radioAcuseBaja.click(function (e) {
                divAcusesBaja.removeClass('d-none');
                divProcesadasBaja.addClass('d-none');
            });

            radioProcesadasBaja.click(function (e) {
                divProcesadasBaja.removeClass('d-none');
                divAcusesBaja.addClass('d-none');
            });


            btnEnviarBajas.click(function (e) {
                e.preventDefault();
                var action = 'envioBajas',
                    fecha = $('#txtFechaBajas').val(),
                    cc = $('#usuario_correo').val();

                $.ajax({
                    type: 'POST',
                    url: localBackend + 'sender.php',
                    data: { action: action, fecha: fecha, datos: datosEmpleadosBajas, cc: cc },
                    success: function (response) {
                        let respuesta = JSON.parse(response);
                    }
                });
                Swal.fire({
                    position: 'center',
                    type: 'success',
                    title: 'Informe de altas enviado a Nominas',
                    showConfirmButton: false,
                    timer: 1800
                })
            });

            btnEnviarAcuseBaja.click(function (e) {
                e.preventDefault();
                var action = 'envioAcuseBaja';

                let numerosNominaBaja = [];
                $.each($("input[name='noNomina']:checked"), function () {
                    numerosNominaBaja.push($(this).val());
                });

                if (numerosNominaBaja.length === 0) {
                    Swal.fire({
                        type: 'error',
                        title: 'Selección Nula!',
                        html: 'Debe seleccionar al menos un empleado',
                        timer: 1300
                    })
                } else {

                    let adjunto_AcuseBaja = document.getElementById('txtAcuseBaja');
                    let adjuntoAcuseBaja = adjunto_AcuseBaja.files[0];
                    let nombreAdjuntoAcuseBaja = adjunto_AcuseBaja.files[0].name;
                    nombreAdjuntoAcuseBaja = nombreAdjuntoAcuseBaja.substr(23, 9);

                    var datosAcuseBaja = new FormData();
                    datosAcuseBaja.append('action', action);
                    datosAcuseBaja.append('arrNomina', numerosNominaBaja.join("|"));
                    datosAcuseBaja.append('nombreAdjuntoAcuse', nombreAdjuntoAcuseBaja);

                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', backendURL, true);
                    xhr.send(datosAcuseBaja);
                    xhr.onload = function () {
                        if (this.status === 200 && this.readyState == 4) {
                            var respuesta = JSON.parse(xhr.responseText);

                            if (respuesta.estado === 'OK') {
                                Swal.fire({
                                    title: 'Alta exitosa!',
                                    text: 'Alta de acuse exitosa!',
                                    type: 'success'
                                })
                                    .then(resultado => {
                                        if (resultado.value) {
                                            location.reload();
                                        }
                                    })
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Hubo un error',
                                    type: 'error'
                                })
                            }
                        }
                    }


                    var archivoAcuseBaja = new FormData();
                    archivoAcuseBaja.append('action', action);
                    archivoAcuseBaja.append('adjuntoAcuse', adjuntoAcuseBaja);
                    archivoAcuseBaja.append('nombreAdjuntoAcuse', nombreAdjuntoAcuseBaja);

                    var xhtr = new XMLHttpRequest();
                    xhtr.open('POST', localBackend + 'control.php', true);
                    xhtr.send(archivoAcuseBaja);
                    xhtr.onload = function () {
                        if (this.status === 200 && this.readyState == 4) {
                            // var respuesta = JSON.parse(xhtr.responseText);
                            // console.log(respuesta);
                        }
                    }
                }
            });

            btnFechaBaja.click(async function (e) {
                e.preventDefault();
                var action = 'cambioFechaBaja';
                let numerosNominaBaja = [];
                $.each($("input[name='noNomina']:checked"), function () {
                    numerosNominaBaja.push($(this).val());
                });

                if (numerosNominaBaja.length === 0) {
                    Swal.fire({
                        title: 'Selección Nula!',
                        html: 'Debe seleccionar al menos un empleado',
                        timer: 1300
                    })
                } else {

                    const { value: fechaBaja } = await Swal.fire({
                        title: 'Fecha de baja',
                        html:
                            '<input type="date" class="form-control" id="txtfechaBaja" value="<?php echo date("Y-m-d");?>',
                        showCancelButton: true,
                        preConfirm: () => {
                            return [
                                document.getElementById('txtfechaBaja').value
                            ]
                        }
                    })
                    let fecha_Baja = JSON.stringify(fechaBaja);
                    if (fecha_Baja[2] !== '"') {
                        // let fecha_Baja = JSON.stringify(fechaBaja);
                        fecha_Baja = fecha_Baja.substr(2, 10);
                        $.ajax({
                            type: 'POST',
                            url: backendURL,
                            data: {
                                action: 'cambioFechaBaja',
                                arrNomina: numerosNominaBaja.join("|"),
                                fechaBaja: fecha_Baja,
                                empleadoControl: empleado_activo
                            }
                        }).done(function (response) {
                            respuesta = JSON.parse(response);
                            let estadoRespuesta = respuesta.estado;
                            if (estadoRespuesta === 'OK') {
                                Swal.fire({
                                    title: 'Baja Actualizada',
                                    text: 'La fecha de baja fue actualizada',
                                    type: 'info'
                                })
                                    .then(resultado => {
                                        if (resultado.value) {
                                            location.reload();
                                        }
                                    })
                            } else {
                                Swal.fire({
                                    title: 'Error',
                                    text: 'Ocurrio un error al procesar los datos',
                                    type: 'error'
                                })
                            }
                        });
                    } else {
                        return false;
                    }

                }
            });

            btnEnviarProcesadaBaja.click(function (e) {
                e.preventDefault();
                let action = 'envioProcesadaBaja';
                let numerosNominaBaja = [];
                $.each($("input[name='noNomina']:checked"), function () {
                    numerosNominaBaja.push($(this).val());
                });

                if (numerosNominaBaja.length === 0) {
                    Swal.fire({
                        type: 'error',
                        title: 'Selección Nula!',
                        html: 'Debe seleccionar al menos un empleado',
                        timer: 1300
                    })
                } else {

                    let adjunto_ProcesadaBaja = document.getElementById('txtProcesadaBaja');
                    let adjuntoProcesadaBaja = adjunto_ProcesadaBaja.files[0];
                    let nombreAdjuntoProcesadaBaja = adjunto_ProcesadaBaja.files[0].name;
                    nombreAdjuntoProcesadaBaja = nombreAdjuntoProcesadaBaja.substr(21, 9);

                    var datosProcesadaBaja = new FormData();
                    datosProcesadaBaja.append('action', action);
                    datosProcesadaBaja.append('arrNomina', numerosNominaBaja.join("|"));
                    datosProcesadaBaja.append('nombreAdjuntoProcesada', nombreAdjuntoProcesadaBaja);

                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', backendURL, true);
                    xhr.send(datosProcesadaBaja);
                    xhr.onload = function () {
                        if (this.status === 200 && this.readyState == 4) {
                            var respuesta = JSON.parse(xhr.responseText);
                            if (respuesta.estado === 'OK') {
                                Swal.fire({
                                    title: 'Alta exitosa!',
                                    text: 'Alta de procesada exitosa!',
                                    type: 'success'
                                })
                                    .then(resultado => {
                                        if (resultado.value) {
                                            location.reload();
                                        }
                                    })
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Hubo un error',
                                    type: 'error'
                                })
                            }
                        }
                    }

                    var archivoProcesadaBaja = new FormData();
                    archivoProcesadaBaja.append('action', action);
                    archivoProcesadaBaja.append('adjuntoProcesada', adjuntoProcesadaBaja);
                    archivoProcesadaBaja.append('nombreAdjuntoProcesada', nombreAdjuntoProcesadaBaja);

                    var xhtr = new XMLHttpRequest();
                    xhtr.open('POST', localBackend + 'control.php', true);
                    xhtr.send(archivoProcesadaBaja);
                    xhtr.onload = function () {
                        if (this.status === 200 && this.readyState == 4) {
                            // var respuesta = JSON.parse(xhtr.responseText);
                            // console.log(respuesta);
                        }
                    }
                }

            });
            break;
        /**ALTAS SEMANALES */
        case 'semanales':
            let btnMostrarAltas = $('#btnMostrarAltas'),
                txtFechaINI = $('#txtFechaINI'),
                txtFechaFIN = $('#txtFechaFIN'),
                txtPeriodo = $('#txtPeriodo');

            action = 'altas-semanales';

            btnMostrarAltas.on('click', function (e) {
                e.preventDefault();
                $('#dataTable').empty();
                txtPeriodo.text(`Periodo del ${txtFechaINI.val()} al ${txtFechaFIN.val()}`);

                $.ajax({
                    type: 'POST',
                    url: backendURL,
                    data: { action: action, fechaINI: txtFechaINI.val(), fechaFIN: txtFechaFIN.val() },
                    success: function (response) {
                        let respuesta = JSON.parse(response);
                        if (respuesta.estado === 'OK') {
                            var datos = respuesta.informacion.length;
                            var informacion = respuesta.informacion;
                            if (datos < 1) {
                                $('#alertaM').removeClass('d-none');
                            }
                            else {
                                $('#alertaM').addClass('d-none');
                                for (var i in informacion) {
                                    tablaAltasSemanales(informacion[i]);
                                }
                            }
                        }
                    }
                });
            });

            function tablaAltasSemanales(rowInfo) {
                var row = $("<tr>");
                seccionExportar.removeClass('d-none');

                $("#dataTable").append(row); //this will append tr element to table... keep its reference for a while since we will add cels into it id_empleado
                row.append($("<td>" + rowInfo.cve_sucursal + " </td>"));
                row.append($("<td>" + rowInfo.sucursal + " </td>"));
                row.append($("<td>" + rowInfo.planta + " </td>"));
                row.append($("<td class='d-none'>" + rowInfo.claveSocio + " </td>"));
                row.append($("<td>" + rowInfo.fechaAlta + " </td>"));
                row.append($("<td class='d-none'>" + rowInfo.tabulador + " </td>"));
                row.append($("<td class='d-none'>" + rowInfo.puesto + " </td>"));
                row.append($("<td class='d-none'>" + rowInfo.clasificacion + " </td>"));
                row.append($("<td class='d-none'>" + rowInfo.nomina + " </td>"));
                row.append($("<td class='d-none'>" + rowInfo.registro_patronal + " </td>"));
                row.append($("<td class='d-none'>" + rowInfo.salario_diario + " </td>"));
                row.append($("<td class='d-none'>" + rowInfo.salario_mensual + " </td>"));
                row.append($("<td class='d-none'>" + rowInfo.lote + " </td>"));
                row.append($("<td class='d-none'>" + rowInfo.status + " </td>"));
                row.append($("<td>" + rowInfo.numero_nomina + " </td>"));
                row.append($("<td>" + rowInfo.apellidoPaterno + " </td>"));
                row.append($("<td>" + rowInfo.apellidoMaterno + " </td>"));
                row.append($("<td>" + rowInfo.nombreEmpleado + " </td>"));
                row.append($("<td>" + rowInfo.fechaNacimiento.date.substr(0, 10) + " </td>"));
                row.append($("<td class='d-none'>" + rowInfo.lugar_nacimiento + " </td>"));
                row.append($("<td class='d-none'>" + rowInfo.sexo + " </td>"));
                row.append($("<td>" + rowInfo.RFC + " </td>"));
                row.append($("<td>" + rowInfo.CURP + " </td>"));
                row.append($("<td class='d-none'>" + rowInfo.nss + " </td>"));
                row.append($("<td class='d-none'>" + rowInfo.numero_identificacion + " </td>"));
                row.append($("<td class='d-none'>" + rowInfo.estado_civil + " </td>"));
                row.append($("<td class='d-none'>" + rowInfo.escolaridad + " </td>"));
                row.append($("<td class='d-none'>" + rowInfo.nombre_padre + " </td>"));
                row.append($("<td class='d-none'>" + rowInfo.nombre_madre + " </td>"));
                row.append($("<td class='d-none'>" + rowInfo.calle + " </td>"));
                row.append($("<td class='d-none'>" + rowInfo.numero_exterior + " </td>"));
                row.append($("<td class='d-none'>" + rowInfo.numero_interior + " </td>"));
                row.append($("<td class='d-none'>" + rowInfo.fraccionamiento + " </td>"));
                row.append($("<td class='d-none'>" + rowInfo.codigo_postal + " </td>"));
                row.append($("<td class='d-none'>" + rowInfo.localidad + " </td>"));
                row.append($("<td class='d-none'>" + rowInfo.municipio + " </td>"));
                row.append($("<td class='d-none'>" + rowInfo.estado + " </td>"));
                row.append($("<td class='d-none'>" + rowInfo.cuenta + " </td>"));
                row.append($("<td class='d-none'>" + rowInfo.numero_cuenta + " </td>"));
                row.append($("<td class='d-none'>" + rowInfo.infonavit + " </td>"));
                row.append($("<td class='d-none'>" + rowInfo.numero_infonavit + " </td>"));
                row.append($("<td class='d-none'>" + rowInfo.fonacot + " </td>"));
                row.append($("<td class='d-none'>" + rowInfo.numero_fonacot + " </td>"));
                row.append($("<td class='d-none'>" + rowInfo.correo + " </td>"));
                row.append($("<td class='d-none'>" + rowInfo.celular + " </td>"));
                row.append($("<td class='d-none'>" + rowInfo.telefono + " </td>"));
            }

            break;
        //PERFIL DEL EMPLEADO
        case 'datos':
            let btnBaja = $('#btnBaja'),
                btnModificar = $('#btnModificar'),
                statusEmpleado = $('#txtStatus'),
                btnSeguimiento = $('#btnSeguimiento');
            //GET VALUE FROM LS
            var codigoEmpleado = localStorage.getItem('codigoEmpleado'),
                action = 'mostrar-empleado';
            //REMOVE VALUE FROM LS
            // localStorage.removeItem('codigoEmpleado');
            var dataEmp = new FormData();
            dataEmp.append('action', action);
            dataEmp.append('prop', codigoEmpleado);
            var xmlhr = new XMLHttpRequest();
            xmlhr.open('POST', backendURL, true);
            xmlhr.onload = function () {
                if (this.status === 200) {
                    var respuesta = JSON.parse(xmlhr.responseText);
                    if (respuesta.estado === 'OK') {
                        var informacion = respuesta.informacion;
                        for (var i in informacion) {
                            imprimirEmpleado(informacion[i]);
                        }
                    } else if (respuesta.status === 'error') {
                        var informacion = respuesta.informacion;
                    }
                }
            }
            xmlhr.send(dataEmp);

            function imprimirEmpleado(rowInfo) {
                let statusEmpleadoR = rowInfo.status,
                    labelSt = '',
                    labelClasificacion = rowInfo.clasificacion,
                    labelNomina = rowInfo.nomina,
                    labelRegistro = rowInfo.registro_patronal,
                    labelGenero = rowInfo.sexo,
                    labelEstadoCivil = rowInfo.estado_civil,
                    labelEscolaridad = rowInfo.escolaridad,
                    valueReingreso = rowInfo.bajaReingreso,
                    labelReingreso,
                    tabulador = rowInfo.tabulador;

                if (tabulador === null) {
                    tabulador = '000|XXX'
                }
                let vTabulador = tabulador.split('|');

                if (statusEmpleadoR === 'B') {
                    statusEmpleado.addClass('text-danger');
                    statusEmpleado.removeClass('text-success');
                    labelSt = 'BAJA';
                    btnBaja.addClass('d-none');
                    $('#btnCambioPuesto').addClass('d-none');
                } else {
                    statusEmpleado.removeClass('text-danger');
                    statusEmpleado.addClass('text-success');
                    labelSt = 'ACTIVO';
                }

                if (labelClasificacion === 'O')
                    labelClasificacion = 'Operativo';
                else if (labelClasificacion === 'AO')
                    labelClasificacion = 'Administrativo operativo';
                else if (labelClasificacion === 'A')
                    labelClasificacion = 'Administrativo';
                else if (labelClasificacion === 'E')
                    labelClasificacion = 'Especial';
                else if (labelClasificacion === 'B')
                    labelClasificacion = 'Becario';

                labelNomina = (labelNomina === 'S' ? 'Sem' : 'Quin');
                if (valueReingreso === '0' || valueReingreso === null) labelReingreso ='PERMITIR REINGRESO'; else labelReingreso ='NO PERMITIR REINGRESO';
                labelGenero = (labelGenero === 'F' ? 'Femenino' : 'Masculino');
                labelEscolaridad = (labelEscolaridad === 'B_TECNICO' ? 'Bachillerato' : labelEscolaridad);

                if (labelEstadoCivil === 'S')
                    labelEstadoCivil = 'Soltero(a)';
                else if (labelEstadoCivil === 'C')
                    labelEstadoCivil = 'Casado(a)';
                else if (labelEstadoCivil === 'D')
                    labelEstadoCivil = 'Divorciado(a)';
                else if (labelEstadoCivil === 'V')
                    labelEstadoCivil = 'Viudo(a)';

                if (valueReingreso === '0' || valueReingreso === null) $('#txtReingreso').addClass('text-success'); else $('#txtReingreso').addClass('text-danger');

                if(rowInfo.sucursal === 'COR'){
                    $('.fOperaciones').addClass('d-none');
                    $('#lsegEntregaOp').html('Contrato de confidencialidad');
                    $('#lsegEntregaFecha').html('Fecha de entrega de Check list Corp. por Staff de Dirección y capacitación');
                    $('#lsegOnboarding').html('SDC');
                }


                var nomina = rowInfo.numero_nomina,
                    urlFoto = 'assets/files/' + nomina + '/' + nomina + '.jpg',
                    action = 'revisarImagen';
                $("#empImagen").attr('src', urlFoto);
                $('#txtTitulo').html('DATOS GENERALES DEL EMPLEADO <strong>' + rowInfo.numero_nomina + '</strong>');
                $('#txtNomina').html(rowInfo.numero_nomina);
                $('#txtNombre').text(rowInfo.nombre_largo);
                $('#txtPuesto').text(rowInfo.puesto);
                $('#txtSucursal').text(rowInfo.sucursal);
                $('#txtCelula').text(rowInfo.planta);
                $('#txtStatus').text(labelSt);
                $('#txtSalario').text('$' + rowInfo.salario_diario);
                $('#txtClasificacion').text(labelClasificacion);
                $('#txtTipoNomina').text(labelNomina);
                $('#txtRegistro').text(labelRegistro);
                $('#txtAlta').text(rowInfo.fechaAlta);
                $('#txtCURP').html('<strong> CURP: </strong>' + rowInfo.CURP);
                $('#txtRFC').html('<strong> RFC: </strong>' + rowInfo.RFC);
                $('#txtNSS').html('<strong> IMSS: </strong>' + rowInfo.nss + rowInfo.dv);
                $('#txtGenero').html('<strong> Genero: </strong>' + labelGenero);
                $('#txtFechaN').html('<strong> Fecha de Nacimiento: </strong>' + rowInfo.fechaNacimiento);
                $('#txtLugarN').html('<strong> Lugar de Nacimiento: </strong>' + rowInfo.lugar_nacimiento);
                $('#txtEstadoCivil').html('<strong> Estado Civil: </strong>' + labelEstadoCivil);
                $('#txtEducacion').html('<strong> Escolaridad: </strong>' + labelEscolaridad);

                $('#txtTabulador').html('<strong> Tabulador: </strong>' + vTabulador[0] + vTabulador[1]);
                $('#txtID').html('<strong> Identificacion: </strong>' + rowInfo.identificacion);
                $('#txtIDN').html('<strong> Numero Identificacion: </strong>' + rowInfo.numero_identificacion);

                $('#txtNombrePadre').html('<strong> Nombre del padre: </strong>' + rowInfo.nombrePadre + ' ' + rowInfo.apellidoPaternoPadre + ' ' + rowInfo.apellidoMaternoPadre);
                $('#txtNombreMadre').html('<strong> Nombre de la madre: </strong>' + rowInfo.nombreMadre + ' ' + rowInfo.apellidoPaternoMadre + ' ' + rowInfo.apellidoMaternoMadre);

                $('#txtEstado').html('<strong> Estado: </strong>' + rowInfo.estado);
                $('#txtMunicipio').html('<strong> Municipio: </strong>' + rowInfo.municipio);
                $('#txtLocalidad').html('<strong> Localidad: </strong>' + rowInfo.localidad);
                $('#txtCP').html('<strong> CP: </strong>' + rowInfo.codigo_postal);
                $('#txtCalle').html('<strong> Calle: </strong>' + rowInfo.calle);
                $('#txtNumero').html('<strong> Numero exterior: </strong>' + rowInfo.numero_exterior + '<strong>     Numero interior: </strong>' + rowInfo.numero_interior);
                $('#txtFraccionamiento').html('<strong> Fraccionamiento: </strong>' + rowInfo.fraccionamiento);

                $('#txtCuenta').html('<strong> Cuenta bancaria: </strong>' + rowInfo.numero_cuenta);
                $('#txtInfonavit').html('<strong> Infonavit: </strong>' + rowInfo.numero_infonavit);
                $('#txtFonacot').html('<strong> Fonacot: </strong>' + rowInfo.numero_fonacot);

                $('#txtTelefono').html('<strong> Telefono: </strong>' + rowInfo.telefono);
                $('#txtCelular').html('<strong> Celular: </strong>' + rowInfo.celular);
                $('#txtCorreo').html('<strong> Email: </strong>' + rowInfo.correo);

                $('#txtAltaAcuse').html('<strong> Acuse Alta: </strong> <a href="assets/attached/Acuses/' + rowInfo.lote_acuse + '.zip" target="_blank">' + rowInfo.lote_acuse + '</a>');
                $('#txtAltaProcesada').html('<strong> Procesada Alta: </strong> <a href="assets/attached/Procesadas/' + rowInfo.lote + '.zip" target="_blank">' + rowInfo.lote + '</a>');

                if (statusEmpleadoR === 'B') {
                    $('#txtBajaAcuse').html('<strong> Acuse Baja: </strong> <a href="assets/attached/Acuses/' + rowInfo.baja_acuse + '.zip" target="_blank">' + rowInfo.baja_acuse + '</a>');
                    $('#txtBajaProcesada').html('<strong> Acuse Baja: </strong> <a href="assets/attached/Acuses/' + rowInfo.baja_procesada + '.zip" target="_blank">' + rowInfo.baja_procesada + '</a>');
                    $('#txtseccionBaja').html('<strong> INFORMACION DE LA BAJA DEL EMPLEADO </strong>');
                    $('#txtReingreso').html('<strong> ' + labelReingreso + ' </strong>');
                    $('#txtclasificacionBaja').html('<strong> Clasificacion: </strong>' + rowInfo.bajaClasficacion);
                    $('#txtmotivoBaja').html('<strong> Motivo: </strong>' + rowInfo.bajaMotivo);
                    $('#txtexplicacionBaja').html('<strong> Explicacion: </strong>' + rowInfo.bajaExplicacion);
                    $('#txtcomentarioBaja').html('<strong> Comentarios: </strong>' + rowInfo.bajaComentario);
                }

                //BLOQUEAR GENERACION  DE GAFETE SI EL EMPLEADO NO TIENE PROCESADA
                /*
                if(rowInfo.lote == '' || rowInfo.lote == null){
                    $("#btnGafete").addClass('d-none');
                    $("#txtFoto").addClass('d-none');
                    $("#txtGafeteAlerta").removeClass('d-none');
                }
                */
                //BLOQUEAR GENERACION  DE GAFETE SI EL EMPLEADO NO TIENE PROCESADA



                $.ajax({
                    type: 'POST',
                    url: localBackend + 'control.php',
                    data: { action: action, nomina: nomina },
                    success: function (response) {
                        var respuesta = JSON.parse(response);
                        if (respuesta.estado === 0) {
                            $("#empImagen").attr('src', 'img/gafete/no-image.png');
                            $("#btnGafete").prop('disabled', true);
                            $("#lblImagen").hide();
                        }
                        else {
                            $("#btnGafete").prop('disabled', false);
                            $("#lblImagen").show();
                        }
                    }
                });
            }




            var archivoImagen = $("#txtFoto")[0].files.length;
            $("#txtFoto").on('click', function () {
                if (archivoImagen === 0) {
                    $("#btnGafete").prop('disabled', false);
                } else {
                    $("#btnGafete").prop('disabled', true);
                }
            });


            //GENERAR GAFETE
            $("#btnGafete").click(function () {
                var numero_nomina = $('#txtNomina').html(),
                    invoiceAttach = document.getElementById('txtFoto'),
                    empFoto = invoiceAttach.files[0],
                    action = 'guardarFoto';


                var datosGafete = new FormData();
                datosGafete.append('empNomina', numero_nomina);
                datosGafete.append('empFoto', empFoto);
                datosGafete.append('action', action);
                var xhr = new XMLHttpRequest();
                xhr.open('POST', localBackend + 'control.php', true);
                xhr.send(datosGafete);
                xhr.onload = function () {
                    if (this.status === 200) {
                        var respuesta = JSON.parse(xhr.responseText);
                    } else {
                        var respuesta = JSON.parse(xhr.responseText);
                    }
                }

                var url = url_final + "empleados/gafete.php?emp=" + numero_nomina,
                    newTab = window.open(url, '_blank');
                newTab.focus();
            });

            //MODIFICAR DATOS DEL EMPLEADO
            btnModificar.click(function () {
                var url = "index.php?request=modificar-empleado";
                $(location).attr('href', url);
                // newTab.focus();
            });

            //DAR DE BAJA EMPLEADO
            $('#btnCambioPuesto').click(async function () {
                var action = 'bajaEmpleado';
                const { value: razonBaja } = await Swal.fire({
                    title: 'Razón de la baja',
                    input: 'select',
                    inputOptions: {
                        bpcdp: 'Baja por cambio de puesto'
                    },
                    inputPlaceholder: 'Causa de la baja',
                })

                if (razonBaja) {
                    const { value: comentariosBaja } = await Swal.fire({
                        input: 'text',
                        title: 'Comentarios',
                        inputPlaceholder: 'Comentarios de la baja del empleado...',
                        inputValue: 'Baja por cambio de puesto',
                        inputAttributes: {
                            'aria-label': 'Comentarios de la baja del empleado'
                        },
                        showCancelButton: true
                    })

                    if (comentariosBaja) {
                        const { value: fechaBaja } = await Swal.fire({
                            title: 'Fecha de baja',
                            html:
                                '<input type="date" class="form-control" id="txtfechaBaja" value="<?php echo date("Y-m-d");?>',
                            showCancelButton: true,
                            preConfirm: () => {
                                return [
                                    document.getElementById('txtfechaBaja').value
                                ]
                            }
                        })

                        if (fechaBaja) {
                            let fecha_Baja = JSON.stringify(fechaBaja);
                            fecha_Baja = fecha_Baja.substr(2, 10);
                            $.ajax({
                                type: 'POST',
                                url: backendURL,
                                data: {
                                    action: action,
                                    nominaEmpleado: codigoEmpleado,
                                    razonBaja: razonBaja+'|0|0|1',
                                    comentariosBaja: comentariosBaja,
                                    fechaBaja: fecha_Baja,
                                    empleadoControl: empleado_activo
                                }
                            }).done(function (response) {
                                respuesta = JSON.parse(response);
                                let estadoRespuesta = respuesta.estado;
                                if (estadoRespuesta === 'OK') {
                                    Swal.fire({
                                        title: 'Baja Exitosa',
                                        text: 'La persona fue dada de baja en el sistema',
                                        type: 'info'
                                    })
                                        .then(resultado => {
                                            if (resultado.value) {
                                                location.reload();
                                            }
                                        })
                                } else {
                                    Swal.fire({
                                        title: 'Error',
                                        text: 'Ocurrio un error al procesar los datos',
                                        type: 'error'
                                    })
                                }
                            });
                        }

                    }
                }

            });

            btnBaja.click(function () {
                let empleadoBaja = $('#txtNomina').html()
                localStorage.setItem('empleadoBaja', $('#txtNomina').html());
                var url = "index.php?request=empleadoBaja";
                // newTab = window.open(url, '_blank');
                $(location).attr('href', url);
            });

            //SEGUIMIENTO AL EMPLEADO
            btnSeguimiento.on('click',function(){
                var numero_nomina = localStorage.getItem('codigoEmpleado').substr(0, 5);
                $(".panelLaborales").addClass("d-none");
                $(".panelSeguimiento").removeClass("d-none");


                let segSucursales = () => {
                    //LLENAR SUCURSALES
                    var listaSUC = new FormData(),
                        action = 'buscarSucursal';
                    listaSUC.append('action', action);
                    var xmlSUC = new XMLHttpRequest();
                    xmlSUC.open('POST', backendURL, true);
                    xmlSUC.onload = function () {
                        if (this.status === 200) {
                            var respuesta = JSON.parse(xmlSUC.responseText);
                            if (respuesta.estado === 'OK') {
                                var informacion = respuesta.informacion;
                                var s = '<option value="" selected>Seleccionar una Sucursal</option>';
                                for (var i in informacion) {
                                    s += '<option value="' + informacion[i].id_sucursal + '">' + informacion[i].nombre + '</option>';
                                }
                                $('#segSucursal').html(s);
                            } else if (respuesta.status === 'error') {
                                var informacion = respuesta.informacion;
                            }
                        }
                    }
                    xmlSUC.send(listaSUC);
                }

                let datosSeguimiento = (numero_nomina) => {
                    segSucursales();
                    var listaSUC = new FormData(),
                        action = 'datosSeguimiento';
                    var cdt = new Date();
                    var current_year =cdt.getFullYear();

                    listaSUC.append('action', action);
                    listaSUC.append('numero_nomina', numero_nomina);
                    var xmlSUC = new XMLHttpRequest();
                    xmlSUC.open('POST', backendURL, true);
                    xmlSUC.onload = function () {
                        if (this.status === 200) {
                            var respuesta = JSON.parse(xmlSUC.responseText);
                            var informacion = respuesta.informacion[0];
                            // console.log(informacion);
                            if(informacion.comision === 1){
                                $("#segComision").prop("checked", true);
                                $("#segFechaLlegada").prop("disabled", false);
                                $("#segChecklist").prop("disabled", false);
                                $("#segSucursal").prop("disabled", false);
                                $("#segPoliticas").prop("disabled", false);
                                $("#segReglamento").prop("disabled", false);
                                $("#segCarta").prop("disabled", false);
                            } else {
                                $("#segComision").prop("checked", false);
                            }

                            $('#segEntregaOp').change(function() {
                                console.log($(this).val());
                                if($(this).val() === 'OK'){
                                    $('#segEntregaFechacol').removeClass('d-none');
                                } else {
                                    $('#segEntregaFechacol').addClass('d-none');
                                    $('#segEntregaFecha').val(current_year+'-01-01');
                                }
                            });
                
                
                            
                            
                            $("#segFechaLlegada").val(informacion.llegada_comision.date.substr(0, 10));
                            $("#segChecklist").val(informacion.checklist_comision.date.substr(0, 10));
                            $("#segPoliticas").val(informacion.politicas_comision);
                            $("#segReglamento").val(informacion.reglamento_comision);
                            $("#segCarta").val(informacion.carta_comision);
                            $("#segContrato").val(informacion.contrato);
                            $("#segDGP").val(informacion.dgp);
                            $("#segDisciplica").val(informacion.disciplina);
                            $("#segEtica").val(informacion.etica);
                            $("#segFechaentregapersonal").val(informacion.primera_incidencia);
                            $("#segFechaentregachecklist").val(informacion.checklist_laborales);
                            $("#segEntregaOp").val(informacion.entrega_operaciones);
                            $("#segEntregaFecha").val(informacion.entrega_planta.date.substr(0, 10));
                            $("#segComentario").val(informacion.comentario_seguimiento);

                            $("#segJefe").val(informacion.jefeDirecto);
                            $("#segDaltonismo").val(informacion.daltonismo);
                            $("#segAgudeza").val(informacion.agudeza);
                            $("#segTarjeta").val(informacion.numero_cuenta);
                            $("#segFechafincontrato").val(informacion.finContrato.date.substr(0, 10));
                            $("#segFechatarjeta").val(informacion.entrega_tarjeta.date.substr(0, 10));
                            $("#segFechacontrato").val(informacion.entrega_contrato.date.substr(0, 10));
                            $("#segGuia").val(informacion.guia);
                            setTimeout(function () {
                                $("#segSucursal").val(informacion.sucursal_comision);

                                if($("#segEntregaOp").val() === 'SI'){
                                    $('#segEntregaFechacol').removeClass('d-none');
                                } else {
                                    $('#segEntregaFechacol').addClass('d-none');
                                }
                            }, 150);
                        }
                    }
                    xmlSUC.send(listaSUC);
                }

                
                datosSeguimiento(numero_nomina);

                $("#btnSalvarseguimiento").click(function(event){
                    var action = 'guardarSeguimiento',
                        segComision = 0,
                        segFechaLlegada = $("#segFechaLlegada").val(),
                        segChecklist = $("#segChecklist").val(),
                        segSucursal = $("#segSucursal").val(),
                        segPoliticas = $("#segPoliticas").val(),
                        segReglamento = $("#segReglamento").val(),
                        segCarta = $("#segCarta").val(),
                        segDaltonismo = $("#segDaltonismo").val(),
                        segAgudeza = $("#segAgudeza").val(),
                        segTarjeta = $("#segTarjeta").val(),
                        segFechatarjeta = $("#segFechatarjeta").val(),
                        segFechacontrato = $("#segFechacontrato").val(),
                        segContrato = $("#segContrato").val(),
                        segDGP = $("#segDGP").val(),
                        segGuia = $("#segGuia").val(),
                        segOnboarding = $("#segOnboarding").val(),
                        segDisciplica = $("#segDisciplica").val(),
                        segEtica = $("#segEtica").val(),
                        segFechaentregapersonal = $("#segFechaentregapersonal").val()
                        segFechaentregachecklist = $("#segFechaentregachecklist").val()
                        segFechafincontrato = $("#segFechafincontrato").val(),
                        segEntregaOp = $("#segEntregaOp").val(),
                        segEntregaFecha = $("#segEntregaFecha").val(),
                        segComentario = $("#segComentario").val();
                        
                        if ($('#segComision').is(':checked'))
                            segComision = 1;
                    
                        $.ajax({
                            type: 'POST',
                            url: backendURL,
                            data: {
                                action: action,
                                segFechaLlegada: segFechaLlegada,
                                segChecklist: segChecklist,
                                segComision: segComision,
                                segSucursal: segSucursal,
                                segPoliticas: segPoliticas,
                                segReglamento: segReglamento,
                                segCarta: segCarta,
                                segDaltonismo: segDaltonismo,
                                segAgudeza: segAgudeza,
                                segTarjeta: segTarjeta,
                                segFechatarjeta: segFechatarjeta,
                                segFechacontrato: segFechacontrato,
                                segContrato: segContrato,
                                segDGP: segDGP,
                                segGuia: segGuia,
                                segOnboarding: segOnboarding,
                                segDisciplica: segDisciplica,
                                segEtica: segEtica,
                                segFechaentregapersonal: segFechaentregapersonal,
                                segFechaentregachecklist: segFechaentregachecklist,
                                segFechafincontrato: segFechafincontrato,
                                segEntregaOp: segEntregaOp,
                                segEntregaFecha: segEntregaFecha,
                                segComentario: segComentario,
                                empleado_activo: empleado_activo,
                                numero_nomina: numero_nomina
                            }
                        }).done(function (response) {
                            respuesta = JSON.parse(response);
                            // console.log(respuesta);
                            let estadoRespuesta = respuesta.estado;
                            if (estadoRespuesta === 'OK') {
                                Swal.fire({
                                    title: 'Guardado Exitoso',
                                    text: 'Información guardada exitosamente',
                                    type: 'info'
                                })
                                    .then(resultado => {
                                        if (resultado.value) {
                                            $(".panelLaborales").removeClass("d-none");
                                            $(".panelSeguimiento").addClass("d-none");
                                        }
                                    })
                            } else {
                                Swal.fire({
                                    title: 'Error',
                                    text: 'Ocurrio un error al guardar los datos',
                                    type: 'error'
                                })
                            }
                        });
                    
                });

            });

            $("#segComision").click(function(event){
                if ($("#segComision").is(':checked')){
                    $("#segSucursal").prop("disabled", false);
                    $("#segFechaLlegada").prop("disabled", false);
                    $("#segChecklist").prop("disabled", false);
                    $("#segPoliticas").prop("disabled", false);
                    $("#segReglamento").prop("disabled", false);
                    $("#segCarta").prop("disabled", false);
                } else {
                    $("#segSucursal").prop("disabled", true);
                    $("#segFechaLlegada").prop("disabled", true);
                    $("#segChecklist").prop("disabled", true);
                    $("#segPoliticas").prop("disabled", true);
                    $("#segReglamento").prop("disabled", true);
                    $("#segCarta").prop("disabled", true);
                }
            });

            $("#btncerrarSeguimiento").click(function(event){
                $(".panelLaborales").removeClass("d-none");
                $(".panelSeguimiento").addClass("d-none");
            });

            break;
        case 'seguimiento':
            seccionExportar.removeClass('d-none');
            var action = 'tabla-seguimiento';
            var titulo = 'Seguimiento al empleado';  

            $(".seccionTitulo").html(titulo);
            
            var dataTable = new FormData();
            dataTable.append('action', action);

            if(empleado_activo.startsWith("999")){
                dataTable.append('numero_nomina', empleado_activo);
            }

            var xmlhr = new XMLHttpRequest();
            xmlhr.open('POST', backendURL, true);
            xmlhr.onload = function () {
                if (this.status === 200) {
                    var respuesta = JSON.parse(xmlhr.responseText);
                    // console.log(respuesta);
                    if (respuesta.estado === 'OK') {
                        var informacion = respuesta.informacion;
                        for (var i in informacion) {
                            tablaSeguimiento(informacion[i]);
                        }
                    } else if (respuesta.status === 'error') {
                        var informacion = respuesta.informacion;
                    }
                }
            }
            xmlhr.send(dataTable);

            function tablaSeguimiento(rowInfo) {
                var comision = 'No';
                $('#loadingIndicator').addClass('d-none');

                var row = $("<tr class='text-secondary'>");
                
                if(rowInfo.comision === 1){
                    comision = 'Si';
                }

                $("#dataTable").append(row); //this will append tr element to table... keep its reference for a while since we will add cels into it id_empleado
                // NUMERO DE EQUIPO
                // row.append($("<td class='trCode'>" + rowInfo.numero_nomina + " </td>"));
                row.append($("<td><button type='button' class='btn btnConsulta btn-link' data-id=" + rowInfo.numero_nomina + "' title='Ver información'>" + rowInfo.numero_nomina + "</button></td>"));
                // NOMINA DEL EMPLEADO
                row.append($("<td class='text-left'> " + rowInfo.nombre_largo + " </td>"));
                row.append($("<td class='text-left'> " + rowInfo.Departamento + " </td>"));
                row.append($("<td class='text-left'> " + rowInfo.Puesto + " </td>"));
                row.append($("<td class='text-left'> " + rowInfo.Sucursal + " </td>"));
                row.append($("<td class='text-left'> " + rowInfo.status + " </td>"));
                row.append($("<td class='text-left'> " + rowInfo.fecha_alta.date.substr(0, 10) + " </td>"));
                row.append($("<td class='text-left'> " + rowInfo.fecha_baja + " </td>"));
                row.append($("<td> " + comision + " </td>"));
                row.append($("<td> " + rowInfo.llegada_comision.date.substr(0, 10) + " </td>"));
                row.append($("<td> " + rowInfo.checklist_comision.date.substr(0, 10) + " </td>"));
                row.append($("<td> " + rowInfo.sucursal_comision + " </td>"));
                row.append($("<td> " + rowInfo.politicas_comision + " </td>"));
                row.append($("<td> " + rowInfo.reglamento_comision + " </td>"));
                row.append($("<td> " + rowInfo.carta_comision + " </td>"));
                row.append($("<td> " + rowInfo.daltonismo + " </td>"));
                row.append($("<td> " + rowInfo.agudeza + " </td>"));
                row.append($("<td> " + rowInfo.numero_cuenta + " </td>"));
                row.append($("<td> " + rowInfo.entrega_tarjeta.date.substr(0, 10) + " </td>"));
                row.append($("<td> " + rowInfo.entrega_contrato.date.substr(0, 10) + " </td>"));
                row.append($("<td> " + rowInfo.contrato + " </td>"));
                row.append($("<td> " + rowInfo.guia + " </td>"));
                row.append($("<td> " + rowInfo.fecha_onboarding.date.substr(0, 10) + " </td>"));
                row.append($("<td> " + rowInfo.disciplina + " </td>"));
                row.append($("<td> " + rowInfo.etica + " </td>"));
                row.append($("<td> " + rowInfo.primera_incidencia + " </td>"));
                row.append($("<td> " + rowInfo.checklist_laborales + " </td>"));
                row.append($("<td> " + rowInfo.entrega_operaciones + " </td>"));
                row.append($("<td> " + rowInfo.jefeDirecto + " </td>"));
                row.append($("<td> " + rowInfo.entrega_planta.date.substr(0, 10) + " </td>"));
                row.append($("<td> " + rowInfo.finContrato.date.substr(0, 10) + " </td>"));

                $(".btnConsulta").unbind().click(function () {
                    var employeeID = $((this)).data('id'),
                        url = "index.php?request=datos";
                    var newTab = window.open(url, '_blank');

                    //SAVE EMPLOYEE ID ON LOCAL STORAGE AS codigoEmpleado
                    localStorage.setItem('codigoEmpleado', employeeID);

                    // OPEN ON CURRENT TAB
                    //$(location).attr('href', url);

                    // OPEN ON NEW TAB
                    newTab.focus();
                });
            }
        break;
        case 'empleadoBaja':
            let empleado_baja = localStorage.getItem('empleadoBaja');
            var action = 'mostrar-empleado';
            localStorage.removeItem('empleadoBaja');
            var dataEmp = new FormData();
            dataEmp.append('action', action);
            dataEmp.append('prop', empleado_baja);
            var xmlhr = new XMLHttpRequest();
            xmlhr.open('POST', backendURL, true);
            xmlhr.onload = function () {
                if (this.status === 200) {
                    var respuesta = JSON.parse(xmlhr.responseText);
                    if (respuesta.estado === 'OK') {
                        var informacion = respuesta.informacion;
                        for (var i in informacion) {
                            imprimir_Empleado(informacion[i]);
                        }
                    } else if (respuesta.status === 'error') {
                        var informacion = respuesta.informacion;
                    }
                }
            }
            xmlhr.send(dataEmp);

            function imprimir_Empleado(rowInfo) {
                $('#txtNomina').html('Nómina: ' + rowInfo.numero_nomina);
                $('#txtNombre').html('Nombres: ' + rowInfo.nombre_largo);
                $('#txtSucursal').html('Sucursal: ' + rowInfo.sucursal);
                $('#txtAlta').html('Fecha Alta: ' + rowInfo.fechaAlta);
                $('#txtJefe').html('Jefe: ' + rowInfo.jefeActual);
            }

            let clasificacionBajas = () => {
                var bajaCla = new FormData(),
                    action = 'claBajas',
                    param = 'clasificacion';
                bajaCla.append('action', action);
                bajaCla.append('param', param);
                var xmlBCla = new XMLHttpRequest();
                xmlBCla.open('POST', backendURL, true);
                xmlBCla.onload = function () {
                    if (this.status === 200) {
                        var respuesta = JSON.parse(xmlBCla.responseText);
                        if (respuesta.estado === 'OK') {
                            var informacion = respuesta.informacion;
                            console.log(informacion);
                            var s = '<option value="" selected>Seleccionar Clasificacion</option>';
                            for (var i in informacion) {
                                s += '<option value="' + informacion[i].codigo + '">' + informacion[i].descripcion.toUpperCase() + '</option>';
                            }
                            $('#txtClasificacion').html(s);
                        } else if (respuesta.status === 'error') {
                            var informacion = respuesta.informacion;
                        }
                    }
                }
                xmlBCla.send(bajaCla);
            }

            let motivoBajas = (key) => {
                var bajaMot = new FormData(),
                    action = 'claBajas',
                    param = 'motivo';
                bajaMot.append('action', action);
                bajaMot.append('param', param);
                bajaMot.append('key', key);
                var xmlBMot = new XMLHttpRequest();
                xmlBMot.open('POST', backendURL, true);
                xmlBMot.onload = function () {
                    if (this.status === 200) {
                        var respuesta = JSON.parse(xmlBMot.responseText);
                        if (respuesta.estado === 'OK') {
                            var informacion = respuesta.informacion;
                            var s = '<option value="" selected>Seleccionar Motivo</option>';
                            for (var i in informacion) {
                                s += '<option value="' + informacion[i].codigo + '">' + informacion[i].descripcion.toUpperCase() + '</option>';
                            }
                            $('#txtMotivo').html(s);
                        } else if (respuesta.status === 'error') {
                            var informacion = respuesta.informacion;
                        }
                    }
                }
                xmlBMot.send(bajaMot);
            }

            let explicacionBajas = (key) => {
                var expMot = new FormData(),
                    action = 'claBajas',
                    param = 'explicacion';
                expMot.append('action', action);
                expMot.append('param', param);
                expMot.append('key', key);
                var xmlBExp = new XMLHttpRequest();
                xmlBExp.open('POST', backendURL, true);
                xmlBExp.onload = function () {
                    if (this.status === 200) {
                        var respuesta = JSON.parse(xmlBExp.responseText);
                        if (respuesta.estado === 'OK') {
                            var informacion = respuesta.informacion;
                            var s = '<option value="" selected>Seleccionar Explicacion de la baja</option>';
                            for (var i in informacion) {
                                s += '<option value="' + informacion[i].codigo + '">' + informacion[i].descripcion.toUpperCase() + '</option>';
                            }
                            $('#txtExplicacion').html(s);
                        } else if (respuesta.status === 'error') {
                            var informacion = respuesta.informacion;
                        }
                    }
                }
                xmlBExp.send(expMot);
            }

            clasificacionBajas();

            $('#txtClasificacion').focusout(function () {
                let key = ($('#txtClasificacion').val()).substr(0, 3);
                if (key.length !== 0)
                    motivoBajas(key);
                else
                    $('#txtMotivo').empty().append('<option selected="" value="">Selecciona una Clasificacion</option>');
            });

            $('#txtMotivo').focusout(function () {
                let key = ($('#txtMotivo').val()).substr(6, 2);
                if (key.length !== 0)
                    explicacionBajas(key);
                else
                    $('#txtExplicacion').empty().append('<option selected="" value="">Selecciona un Motivo</option>');
            });

            $("#btnBajaEmpleado").click(function (e) {
                let fechaBaja = $('#txtFechaBaja').val(),
                    claBaja = $('#txtClasificacion').val(),
                    motBaja = $('#txtMotivo').val(),
                    expBaja = $('#txtExplicacion').val(),
                    ctrlBaja = 0,
                    comBaja = $('#txtComentario').val();
                e.preventDefault();
                let empleado_Baja = $('#txtNomina').html();
                if ($('#cbReingreso').is(':checked'))
                    ctrlBaja = 1;
                if (claBaja.length === 0) {
                    Swal.fire(
                        'Seleccionar opcion!',
                        'La Clasificacion de la baja esta vacia, favor de elegir una opcion!',
                        'warning'
                    )
                } else if (motBaja.length === 0) {
                    Swal.fire(
                        'Seleccionar opcion!',
                        'El Motivo de la baja esta vacia, favor de elegir una opcion!',
                        'warning'
                    )
                } else if (expBaja.length === 0) {
                    Swal.fire(
                        'Seleccionar opcion!',
                        'La Explicacion de la baja esta vacia, favor de elegir una opcion!',
                        'warning'
                    )
                } else {
                    let paramBaja = `${claBaja}|${motBaja}|${expBaja}|${ctrlBaja}`;
                    action = 'bajaEmpleado';
                    $.ajax({
                        type: 'POST',
                        url: backendURL,
                        data: {
                            action: action,
                            nominaEmpleado: empleado_baja,
                            razonBaja: paramBaja,
                            comentariosBaja: comBaja,
                            fechaBaja: fechaBaja,
                            empleadoControl: empleado_activo
                        }
                    }).done(function (response) {
                        respuesta = JSON.parse(response);
                        let estadoRespuesta = respuesta.estado;
                        if (estadoRespuesta === 'OK') {
                            Swal.fire({
                                title: 'Baja Exitosa',
                                text: 'La persona fue dada de baja en el sistema',
                                type: 'info'
                            })
                                .then(resultado => {
                                    if (resultado.value) {
                                        history.back();
                                    }
                                })
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: 'Ocurrio un error al procesar los datos',
                                type: 'error'
                            })
                        }
                    });
                }
            });


            break;
        //PERFIL DEL EMPLEADO
        case 'perfil':
            let estadoEmpleado = $('#txtStatus');
            //GET VALUE FROM LS
            var codigoEmpleado = localStorage.getItem('nominaEmpleado'),
                action = 'mostrar-empleado';
            //REMOVE VALUE FROM LS
            var dataEmp = new FormData();
            dataEmp.append('action', action);
            dataEmp.append('prop', codigoEmpleado);
            var xmlhr = new XMLHttpRequest();
            xmlhr.open('POST', backendURL, true);
            xmlhr.onload = function () {
                if (this.status === 200) {
                    var respuesta = JSON.parse(xmlhr.responseText);
                    if (respuesta.estado === 'OK') {
                        var informacion = respuesta.informacion;
                        for (var i in informacion) {
                            mostrarEmpleado(informacion[i]);
                        }
                    } else if (respuesta.status === 'error') {
                        var informacion = respuesta.informacion;
                    }
                }
            }
            xmlhr.send(dataEmp);

            function mostrarEmpleado(rowInfo) {
                let estadoEmpleadoR = rowInfo.status;
                if (estadoEmpleadoR.substr(0, 1) === 'B') {
                    estadoEmpleado.addClass('text-danger');
                    estadoEmpleado.removeClass('text-success');
                } else {
                    estadoEmpleado.removeClass('text-danger');
                    estadoEmpleado.addClass('text-success');
                }
                var nomina = rowInfo.numero_nomina,
                    urlFoto = 'assets/files/' + nomina + '/' + nomina + '.jpg',
                    action = 'revisarImagen';
                $("#empImagen").attr('src', urlFoto);
                $('#txtNomina').text(rowInfo.numero_nomina);
                $('#txtNombre').text(rowInfo.nombre_largo);
                $('#txtPuesto').text(rowInfo.Puesto);
                $('#txtSucursal').text(rowInfo.Sucursal);
                $('#txtDepartamento').text(rowInfo.Departamento);
                $('#txtCelula').text(rowInfo.Celula);
                $('#txtStatus').text(rowInfo.status);


                $.ajax({
                    type: 'POST',
                    url: localBackend + 'control.php',
                    data: { action: action, nomina: nomina },
                    success: function (response) {
                        var respuesta = JSON.parse(response);
                        if (respuesta.estado === 0) {
                            $("#empImagen").attr('src', 'img/gafete/no-image.png');
                            $("#btnGafete").prop('disabled', true);
                            $("#lblImagen").hide();
                        }
                        else {
                            $("#btnGafete").prop('disabled', false);
                            $("#lblImagen").show();
                        }
                    }
                });
            }

            var archivoImagen = $("#txtFoto")[0].files.length;
            $("#txtFoto").on('click', function () {
                if (archivoImagen === 0) {
                    $("#btnGafete").prop('disabled', false);
                } else {
                    $("#btnGafete").prop('disabled', true);
                }
            });

            break;
        //LLENAR FORMULARIO DATOS DEL EMPLEADO
        case 'modificar-empleado':
            // let btnModificarEmpleado = $('#btnModificarEmpleado');
            listarSucursales();
            var action = 'datos-empleado',
                numero_nomina = localStorage.getItem('codigoEmpleado');
            $.ajax({
                type: 'POST',
                url: backendURL,
                data: { action: action, numero_nomina: numero_nomina }
            }).done(function (response) {
                let respuesta = JSON.parse(response);
                if (respuesta.estado === 'OK') {
                    let datos = respuesta.informacion[0];
                    let nombreCompletoMadre = datos.nombre_madre,
                        nombreCompletoPadre = datos.nombre_padre,
                        tabulador = '';

                    let nombrePadre = nombreCompletoPadre.split('|');
                    let nombreMadre = nombreCompletoMadre.split('|');
                    if (datos.tabulador === null) {
                        tabulador = '###|XXX';
                    } else {
                        tabulador = datos.tabulador;
                    }
                    let vTabulador = tabulador.split('|');

                    sucursalTabulador();

                    //Validar el puesto ingresado
                    $('#txtPuesto').focusout(function () {
                        var pto = $('#txtPuesto').val();
                        // console.log(pto);
                        if(pto < 1)
                        {
                            Swal.fire({
                                position: 'center',
                                type: 'warning',
                                title: 'Favor de verificar el puesto nuevamente',
                                showConfirmButton: false,
                                timer: 2500
                            })
                        
                            $('#txtPuesto').addClass('btn-outline-danger');

                            setTimeout(function () {
                                $('#txtPuesto').removeClass('btn-outline-danger');
                            }, 3500);

                        }
                    });

                    //Validar el jefe ingresado
                    $('#txtJefe').focusout(function () {
                        var vJefe = $('#txtJefe').val();
                        // console.log(pto);
                        if(vJefe < 1)
                        {
                            Swal.fire({
                                position: 'center',
                                type: 'warning',
                                title: 'Favor de verificar el jefe nuevamente',
                                showConfirmButton: false,
                                timer: 2500
                            })
                        
                            $('#txtJefe').addClass('btn-outline-danger');

                            setTimeout(function () {
                                $('#txtJefe').removeClass('btn-outline-danger');
                            }, 3500);

                        }
                    });

                    $("#txtNomina").val(datos.numero_nomina);
                    $("#txtTipo").val(datos.status);
                    $("#txtLote").val(datos.lote);
                    $("#txtClasificacion").val(datos.clasificacion);
                    $("#txtSalarioDiario").val(datos.salario_diario);
                    $("#txtSalarioMensual").val(datos.salario_mensual);
                    $("#txtTipoNomina").val(datos.nomina);
                    listarDepartamentos(datos.id_sucursal, datos.clasificacion);
                    $("#txtfechaAlta").val((datos.fecha_alta.date).substr(0, 10));
                    $("#txtRegistro").val(datos.registro_patronal);
                    listarPuestos(datos.id_celula, datos.clasificacion);
                    setTimeout(function () {
                        listarJefes(datos.clasificacion);
                    }, 100);
                    $("#txtComentario").val(datos.comentarios);
                    $("#txtNombre").val(datos.nombre);
                    $("#txtPaterno").val(datos.apellido_paterno);
                    $("#txtMaterno").val(datos.apellido_materno);
                    $("#txtCURP").val(datos.CURP);
                    $("#txtRFC").val(datos.RFC);
                    $("#txtNSS").val(datos.nss);
                    $("#txtDV").val(datos.dv);
                    $("#txtfechaNacimiento").val((datos.fecha_nacimiento.date).substr(0, 10));
                    $("#txtLnacimiento").val(datos.lugar_nacimiento);
                    $("#txtGenero").val(datos.sexo);
                    $("#txtTI").val(datos.identificacion);
                    $("#txtID").val(datos.numero_identificacion);
                    $("#txtCivil").val(datos.estado_civil);
                    $("#txtEscolaridad").val(datos.escolaridad);
                    $("#txtStescolaridad").val(datos.constancia);

                    $("#txtNombrePadre").val(nombrePadre[2]);
                    $("#txtApeMatPadre").val(nombrePadre[1]);
                    $("#txtApePatPadre").val(nombrePadre[0]);

                    $("#txtNombreMadre").val(nombreMadre[2]);
                    $("#txtApeMatMadre").val(nombreMadre[1]);
                    $("#txtApePatMadre").val(nombreMadre[0]);


                    $("#txtCalle").val(datos.calle);
                    $("#txtNume").val(datos.numero_exterior);
                    $("#txtNumi").val(datos.numero_interior);
                    $("#txtCP").val(datos.codigo_postal);
                    listarFraccionamientos(datos.codigo_postal)
                    $("#txtInfonavit").val(datos.infonavit);
                    $("#txtNinfonavit").val(datos.numero_infonavit);
                    $("#txtFonacot").val(datos.fonacot);
                    $("#txtNfonacot").val(datos.numero_fonacot);
                    $("#txtBanco").val(datos.cuenta);
                    $("#txtCuenta").val(datos.numero_cuenta);
                    $("#txtCorreo").val(datos.correo);
                    $("#txtTelefono").val(datos.telefono);
                    $("#txtCelular").val(datos.celular);
                    $("#txtContacto").val(datos.contacto_emergencia_nombre);
                    $("#txtNcontacto").val(datos.contacto_emergencia_numero);

                    setTimeout(function () {
                        $("#txtSucursal").val(datos.id_sucursal);
                        $("#txtCelula").val(datos.id_celula);
                        $("#txtPuesto").val(datos.id_puesto);
                        $("#txtJefe").val(datos.jefe_nomina);
                        
                        $("#txtEdo").val(datos.estado);
                        $("#txtMunicipio").val(datos.municipio);
                        $("#txtLocalidad").val(datos.localidad);
                        $("#txtTabClave").val(vTabulador[0]);
                        $("#txtTabSucursal").val(vTabulador[1]);
                    }, 280);

                    setTimeout(function () {
                        $("#txtFraccionamiento").val(datos.fraccionamiento.toUpperCase());
                    }, 1000);


                }
            });

            //EDITAR CP
            $("#txtCP").focusout(function () {
                listarFraccionamientos($("#txtCP").val());
            });

            $("#txtClasificacion").focusout(function () {
                listarDepartamentos($("#txtSucursal").val(), $("#txtClasificacion").val());
            });

            $("#txtCelula").focusout(function () {
                listarPuestos($("#txtCelula").val(), $("#txtClasificacion").val());
            });

            $("#txtClasificacion").focusout(function () {
                listarJefes($("#txtClasificacion").val());
            });

            $('#btnModificarEmpleado').click(function (e) {
                e.preventDefault();
                let nomina = $('#txtNomina').val(),
                    jefenomina = $('#txtJefe').val(),
                    claveTabulador = `${$('#txtTabClave').val()}|${$('#txtTabSucursal').val()}`,
                    tipoNomina = $('#txtTipoNomina').val(),
                    tipo = $('#txtTipo').val(),
                    lote = $("#txtLote").val(),
                    sucursal = $('#txtSucursal').val(),
                    clasificacion = $('#txtClasificacion').val(),
                    salarioDiario = $('#txtSalarioDiario').val(),
                    salarioMensual = $('#txtSalarioMensual').val(),
                    celula = $('#txtCelula').val(),
                    fechaAlta = $('#txtfechaAlta').val(),
                    registro = $('#txtRegistro').val(),
                    puesto = $('#txtPuesto').val(),
                    comentario = $('#txtComentario').val(),
                    nombre = $('#txtNombre').val(),
                    aPaterno = $('#txtPaterno').val(),
                    aMaterno = $('#txtMaterno').val(),
                    curp = $('#txtCURP').val(),
                    rfc = $('#txtRFC').val(),
                    nss = $('#txtNSS').val(),
                    dv = $('#txtDV').val(),
                    fechaNacimiento = $('#txtfechaNacimiento').val(),
                    lNacimiento = $('#txtLnacimiento').val(),
                    genero = $('#txtGenero').val(),
                    tIdentificacion = $('#txtTI').val(),
                    id = $('#txtID').val(),
                    eCivil = $('#txtCivil').val(),
                    escolaridad = $('#txtEscolaridad').val(),
                    cEscolaridad = $('#txtStescolaridad').val(),
                    nPadre = `${$('#txtApePatPadre').val()}|${$('#txtApeMatPadre').val()}|${$('#txtNombrePadre').val()}`,
                    nMadre = `${$('#txtApePatMadre').val()}|${$('#txtApeMatMadre').val()}|${$('#txtNombreMadre').val()}`,
                    calle = $('#txtCalle').val(),
                    numE = $('#txtNume').val(),
                    numI = $('#txtNumi').val(),
                    cp = $('#txtCP').val(),
                    edo = $('#txtEdo').val(),
                    municipio = $('#txtMunicipio').val(),
                    localidad = $('#txtLocalidad').val(),
                    fraccionamiento = $('#txtFraccionamiento').val(),
                    infonavit = $('#txtInfonavit').val(),
                    nInfonavit = $('#txtNinfonavit').val(),
                    fonacot = $('#txtFonacot').val(),
                    nFonacot = $('#txtNfonacot').val(),
                    banco = $('#txtBanco').val(),
                    cuenta = $('#txtCuenta').val(),
                    correo = $('#txtCorreo').val(),
                    telefono = $('#txtTelefono').val(),
                    celular = $('#txtCelular').val(),
                    contacto = $('#txtContacto').val(),
                    nContacto = $('#txtNcontacto').val(),
                    curpini = curp.substr(0, 4),
                    curpfin = curp.substr(10, 8),
                    rfcini = rfc.substr(0, 4),
                    rfcfin = rfc.substr(10, 3);
                domicilio = `${calle} #${numE} Int.${numI} ${fraccionamiento}`;
                if
                    (
                    jefenomina.trim() === '-1' ||
                    salarioDiario.trim() === '' || celula.trim() === '' ||
                    registro.trim() === '' || puesto.trim() === '-1' ||
                    nombre.trim() === '' || aPaterno.trim() === '' ||
                    aMaterno.trim() === '' || id.trim() === '' || nPadre.trim() === '' ||
                    nMadre.trim() === '' || calle.trim() === '' ||
                    numE.trim() === '' ||
                    cp.trim() === '' || nInfonavit.trim() === '' ||
                    nFonacot.trim() === '' || cuenta.trim() === '' ||
                    correo.trim() === '' || telefono.trim() === '' ||
                    celular.trim() === '' || contacto.trim() === '' ||
                    nContacto.trim() === ''
                ) {
                    Swal.fire({
                        position: 'center',
                        type: 'warning',
                        title: 'Debe llenar todos los datos',
                        showConfirmButton: false,
                        timer: 1000
                    })
                }
                else {
                    var nombreLargo = `${aPaterno} ${aMaterno} ${nombre}`;
                    $.ajax({
                        type: 'POST',
                        url: backendURL,
                        data: {
                            action: 'modificarEmpleado',
                            nomina: nomina,
                            jefenomina: jefenomina,
                            claveTabulador: claveTabulador,
                            tipoNomina: tipoNomina,
                            empleado_status: tipo,
                            lote: lote,
                            sucursal: sucursal,
                            clasificacion: clasificacion,
                            salarioDiario: salarioDiario,
                            salarioMensual: salarioMensual,
                            celula: celula,
                            fechaAlta: fechaAlta,
                            registro: registro,
                            puesto: puesto,
                            nss: nss,
                            dv: dv,
                            comentario: comentario,
                            nombre: nombre,
                            aPaterno: aPaterno,
                            aMaterno: aMaterno,
                            curpini: curpini,
                            curpfin: curpfin,
                            rfcini: rfcini,
                            rfcfin: rfcfin,
                            genero: genero,
                            fechaNacimiento: fechaNacimiento,
                            nombreLargo: nombreLargo,
                            lNacimiento: lNacimiento,
                            tIdentificacion: tIdentificacion,
                            id: id,
                            eCivil: eCivil,
                            escolaridad: escolaridad,
                            cEscolaridad: cEscolaridad,
                            nPadre: nPadre,
                            nMadre: nMadre,
                            calle: calle,
                            numE: numE,
                            numI: numI,
                            cp: cp,
                            edo: edo,
                            municipio: municipio,
                            localidad: localidad,
                            fraccionamiento: fraccionamiento,
                            domicilio: domicilio,
                            infonavit: infonavit,
                            nInfonavit: nInfonavit,
                            fonacot: fonacot,
                            nFonacot: nFonacot,
                            banco: banco,
                            cuenta: cuenta,
                            correo: correo,
                            telefono: telefono,
                            celular: celular,
                            contacto: contacto,
                            nContacto: nContacto,
                            empleado_activo: empleado_activo
                        },
                        success: function (response) {
                            var respuesta = JSON.parse(response);
                            if (respuesta.estado === 'OK') {
                                Swal.fire({
                                    title: 'Correcto',
                                    text: 'Guardado exitoso!',
                                    type: 'success'
                                })
                                    .then(resultado => {
                                        if (resultado.value) {
                                            location.reload();
                                            // window.location.href = 'index.php?request=empleado';
                                        }
                                    })
                            } else {
                                Swal.fire({
                                    title: 'Error',
                                    text: 'No se realizo el guardado',
                                    type: 'error'
                                })
                                    .then(resultado => {
                                        if (resultado.value) {
                                            // location.reload();
                                        }
                                    })
                            }
                        }
                    });
                }
            });

            break;
        case 'main':
            if( nivel_usuario == 99 ){
                
                
                    var action = 'panelCoordinadoras',
                    totalEmpleados = $("#txtEmpleadosc"),
                    empleadosM = $("#txtEmpleadosm"),
                    empleadosH = $("#txtEmpleadosh"),
                    totalPlantas = $("#txtPlantasc");
                    //REMOVE VALUE FROM LS
                    // localStorage.removeItem('codigoEmpleado');
                    var dataEmp = new FormData();
                    dataEmp.append('action', action);
                    dataEmp.append('param', empleado_activo);
                    var xmlhr = new XMLHttpRequest();
                    xmlhr.open('POST', backendURL, true);
                    xmlhr.onload = function () {
                        if (this.status === 200) {
                            var respuesta = JSON.parse(xmlhr.responseText);
                            //console.log(respuesta);
                            if (respuesta.estado === 'OK') {
                                var informacion = respuesta.informacion;
                                totalEmpleados.text(informacion[0].cifras);
                                empleadosM.text(informacion[1].cifras);
                                empleadosH.text(informacion[2].cifras);
                                totalPlantas.text(informacion[3].cifras);
                            } else if (respuesta.status === 'error') {
                                var informacion = respuesta.informacion;
                            }
                        }
                    }
                    xmlhr.send(dataEmp);
                                   
               

            } else {
                var action = 'highlights',
                totalEmpleados = $("#txtEmpleados"),
                totalEmpleadosA = $("#txtEmpleadosA"),
                totalEmpleadosAO = $("#txtEmpleadosAO"),
                totalEmpleadosO = $("#txtEmpleadosO"),
                totalEmpleadosE = $("#txtEmpleadosE"),
                totalEmpleadosB = $("#txtEmpleadosB");
                //REMOVE VALUE FROM LS
                // localStorage.removeItem('codigoEmpleado');
                var dataEmp = new FormData();
                dataEmp.append('action', action);
                var xmlhr = new XMLHttpRequest();
                xmlhr.open('POST', backendURL, true);
                xmlhr.onload = function () {
                    if (this.status === 200) {
                        var respuesta = JSON.parse(xmlhr.responseText);
                        // console.log(respuesta);
                        if (respuesta.estado === 'OK') {
                            var informacion = respuesta.informacion;
                            totalEmpleados.text(informacion[0].cifras);
                            totalEmpleadosA.text(informacion[1].cifras);
                            totalEmpleadosAO.text(informacion[2].cifras);
                            totalEmpleadosO.text(informacion[3].cifras);
                            totalEmpleadosE.text(informacion[4].cifras);
                            totalEmpleadosB.text(informacion[5].cifras);
                        } else if (respuesta.status === 'error') {
                            var informacion = respuesta.informacion;
                        }
                    }
                }
                xmlhr.send(dataEmp);
            }

            break;
        case 'direcciones':
            $('.toolsDH').removeClass('d-none');
            var action = 'lista-direcciones';
            var prop = (seccionActual === 'empleado' ? 'activos' : 'bajas');
            var titulo = 'Direcciones del personal';
            $('.seccionTitulo').text(titulo);
            var dataTable = new FormData();
            dataTable.append('action', action);
            // dataTable.append('prop', prop);
            var xmlhr = new XMLHttpRequest();
            xmlhr.open('POST', backendURL, true);
            xmlhr.onload = function () {
                if (this.status === 200) {
                    var respuesta = JSON.parse(xmlhr.responseText);
                    if (respuesta.estado === 'OK') {
                        var informacion = respuesta.informacion;
                        for (var i in informacion) {
                            tablaDirecciones(informacion[i]);
                        }
                    } else if (respuesta.status === 'error') {
                        var informacion = respuesta.informacion;
                    }
                }
            }
            xmlhr.send(dataTable);

            function tablaDirecciones(rowInfo) {

                var st = rowInfo.status,
                    status = 'Activo',
                    estado = '';

                $('#loadingIndicator').addClass('d-none');
                seccionExportar.removeClass('d-none');

                if (st === 'B') {
                    estado = "alert-secondary";
                    status = 'Baja';
                }
                if (st === 'R') {
                    estado = "text-secondary";
                    status = 'Re-ingreso';
                }
                var row = $("<tr class='" + estado + " text-secondary'>");

                $("#dataTable").append(row); //this will append tr element to table... keep its reference for a while since we will add cels into it id_empleado
                row.append($("<td class='trCode'>" + rowInfo.numero_nomina + " </td>"));
                row.append($("<td class='text-uppercase'> " + rowInfo.nombre_largo + " </td>"));
                row.append($("<td> " + rowInfo.fecha_alta.date.substr(0, 10) + " </td>"));
                row.append($("<td> " + rowInfo.Area + " </td>"));
                row.append($("<td> " + rowInfo.estado + " </td>"));
                row.append($("<td> " + rowInfo.localidad + " </td>"));
                row.append($("<td> " + rowInfo.codigo_postal + " </td>"));
                row.append($("<td> " + rowInfo.Domicilio + " </td>"));

            }


            break;

        //NOTIFICACIONES
        case 'notificaciones':
            var titulo = 'Notificaciones al empleado';
            $('.seccionTitulo').text(titulo);
        break;
        //IMAGENES DE EMPLEADOS
        case 'imagenes-empleados':
            seccionExportar.removeClass('d-none');

            var titulo = 'Imagenes del empleado';
            $('.seccionTitulo').text(titulo);

            $(".btnimg").on('click', function () {
                Swal.fire({
                    title: 'Numero empleado',
                    text: 'Nombre del empleado',
                    imageUrl: 'https://unsplash.it/400/200',
                    imageWidth: 400,
                    imageHeight: 200,
                    imageAlt: 'Custom image'
                  })
            });

        break
        // CUMPLEAÑOS / ANTIGUEDAD
        case 'fecha1': case 'fecha2':
            var titulo = (seccionActual === 'fecha1' ? 'Fechas de cumpleaños' : 'Antigüedad del personal');
            var columna = (seccionActual === 'fecha1' ? 'Fecha Nacimiento' : 'Fecha Alta');
            var columna2 = (seccionActual === 'fecha1' ? 'Edad' : 'Antigüedad');
            let btnObtener = $("#btnObtener");

            $('.seccionTitulo').text(titulo);
            $('#colType').text(columna);
            $('#colKind').text(columna2);

            btnObtener.on('click', function () {
                var mes = $("#txtMes").val();
                if (mes != '0') {
                    obtenerFechas(mes);
                    $('#dataTable').empty();
                }
            });

            function obtenerFechas(mes) {
                var action = 'fecha';
                var prop = (seccionActual === 'fecha1' ? 'cumple' : 'antig');
                var dataTable = new FormData();
                dataTable.append('action', action);
                dataTable.append('prop', prop);
                dataTable.append('mes', mes);
                var xmlhr = new XMLHttpRequest();
                xmlhr.open('POST', backendURL, true);
                xmlhr.onload = function () {
                    if (this.status === 200) {
                        var respuesta = JSON.parse(xmlhr.responseText);
                        if (respuesta.estado === 'OK') {
                            var informacion = respuesta.informacion;
                            // console.log(respuesta);
                            for (var i in informacion) {
                                tablaFechas(informacion[i]);
                            }
                        } else if (respuesta.status === 'error') {
                            var informacion = respuesta.informacion;
                        }
                    }
                }
                xmlhr.send(dataTable);
            }

            function tablaFechas(rowInfo) {

                $('#loadingIndicator').addClass('d-none');
                seccionExportar.removeClass('d-none');

                var row = $("<tr class='text-center'>");

                $("#dataTable").append(row); //this will append tr element to table... keep its reference for a while since we will add cels into it id_empleado
                row.append($("<td class='trCode'>" + rowInfo.numero_nomina + " </td>"));
                row.append($("<td class='text-uppercase'> " + rowInfo.nombre_largo + " </td>"));
                row.append($("<td class='text-uppercase'> " + rowInfo.Puesto + " </td>"));
                row.append($("<td> " + rowInfo.Sucursal + " </td>"));
                row.append($("<td> " + rowInfo.Celula + " </td>"));
                row.append($("<td> " + rowInfo.fecha + " </td>"));
                row.append($("<td> " + rowInfo.field1 + ' años' + " </td>"));
                row.append($("<td> " + rowInfo.diasFaltantes + " </td>"));
            }

            break;
        //REINGREO DE EMPLEADO
        case 'reingreso-empleado':
            let btnReingresarEmpleado = $('#btnReingresarEmpleado');
            var codigoEmpleado = localStorage.getItem('codigoEmpleado');
            listarDatosEmpleados(codigoEmpleado);
            setTimeout(function () {
                $('#txtTipo').val('R');
            }, 530);

            //CONTROL CODIGO POSTAL
            $("#txtCP").focusout(function () {
                var cp = $('#txtCP').val();
                listarFraccionamientos(cp);
            });

            //Validar el puesto ingresado
            $('#txtPuesto').focusout(function () {
                var pto = $('#txtPuesto').val();
                // console.log(pto);
                if(pto < 1)
                {
                    Swal.fire({
                        position: 'center',
                        type: 'warning',
                        title: 'Favor de verificar el puesto nuevamente',
                        showConfirmButton: false,
                        timer: 2500
                    })
                
                    $('#txtPuesto').addClass('btn-outline-danger');

                    setTimeout(function () {
                        $('#txtPuesto').removeClass('btn-outline-danger');
                    }, 3500);

                }
            });

            //Validar el jefe ingresado
            $('#txtJefe').focusout(function () {
                var vJefe = $('#txtJefe').val();
                // console.log(pto);
                if(vJefe < 1)
                {
                    Swal.fire({
                        position: 'center',
                        type: 'warning',
                        title: 'Favor de verificar el jefe nuevamente',
                        showConfirmButton: false,
                        timer: 2500
                    })
                
                    $('#txtJefe').addClass('btn-outline-danger');

                    setTimeout(function () {
                        $('#txtJefe').removeClass('btn-outline-danger');
                    }, 3500);

                }
            });
            

            btnReingresarEmpleado.click(function (e) {
                e.preventDefault();
                nomina = $('#txtNomina').val(),
                    jefenomina = $('#txtJefe').val(),
                    claveTabulador = `${$('#txtTabClave').val()}|${$('#txtTabSucursal').val()}`,
                    tipoNomina = $('#txtTipoNomina').val(),
                    tipo = $('#txtTipo').val(),
                    lote = $("#txtLote").val(),
                    sucursal = $('#txtSucursal').val(),
                    clasificacion = $('#txtClasificacion').val(),
                    salarioDiario = $('#txtSalarioDiario').val(),
                    salarioMensual = $('#txtSalarioMensual').val(),
                    celula = $('#txtCelula').val(),
                    fechaAlta = $('#txtfechaAlta').val(),
                    registro = $('#txtRegistro').val(),
                    puesto = $('#txtPuesto').val(),
                    comentario = $('#txtComentario').val(),
                    nombre = $('#txtNombre').val(),
                    aPaterno = $('#txtPaterno').val(),
                    aMaterno = $('#txtMaterno').val(),
                    curp = $('#txtCURP').val(),
                    rfc = $('#txtRFC').val(),
                    nss = $('#txtNSS').val(),
                    dv = $('#txtDV').val(),
                    fechaNacimiento = $('#txtfechaNacimiento').val(),
                    lNacimiento = $('#txtLnacimiento').val(),
                    genero = $('#txtGenero').val(),
                    tIdentificacion = $('#txtTI').val(),
                    id = $('#txtID').val(),
                    eCivil = $('#txtCivil').val(),
                    escolaridad = $('#txtEscolaridad').val(),
                    cEscolaridad = $('#txtStescolaridad').val(),
                    ///DATOS PADRES
                    nPadre = `${$('#txtApePatPadre').val()}|${$('#txtApeMatPadre').val()}|${$('#txtNombrePadre').val()}`,
                    nMadre = `${$('#txtApePatMadre').val()}|${$('#txtApeMatMadre').val()}|${$('#txtNombreMadre').val()}`,
                    calle = $('#txtCalle').val(),
                    numE = $('#txtNume').val(),
                    numI = $('#txtNumi').val(),
                    cp = $('#txtCP').val(),
                    edo = $('#txtEdo').val(),
                    municipio = $('#txtMunicipio').val(),
                    localidad = $('#txtLocalidad').val(),
                    fraccionamiento = $('#txtFraccionamiento').val(),
                    infonavit = $('#txtInfonavit').val(),
                    nInfonavit = $('#txtNinfonavit').val(),
                    fonacot = $('#txtFonacot').val(),
                    nFonacot = $('#txtNfonacot').val(),
                    banco = $('#txtBanco').val(),
                    cuenta = $('#txtCuenta').val(),
                    correo = $('#txtCorreo').val(),
                    telefono = $('#txtTelefono').val(),
                    celular = $('#txtCelular').val(),
                    contacto = $('#txtContacto').val(),
                    nContacto = $('#txtNcontacto').val(),
                    curpini = curp.substr(0, 4),
                    curpfin = curp.substr(10, 8),
                    rfcini = rfc.substr(0, 4),
                    rfcfin = rfc.substr(10, 3);
                domicilio = `${calle} #${numE} Int.${numI} ${fraccionamiento}`;
                if
                    (
                    jefenomina.trim() === '-1' ||
                    salarioDiario.trim() === '' || celula.trim() === '' ||
                    registro.trim() === '' || puesto.trim() === '-1' ||
                    nombre.trim() === '' || aPaterno.trim() === '' ||
                    aMaterno.trim() === '' || id.trim() === '' || nPadre.trim() === '' ||
                    nMadre.trim() === '' || calle.trim() === '' ||
                    numE.trim() === '' || puesto < 1 ||
                    cp.trim() === '' || nInfonavit.trim() === '' ||
                    nFonacot.trim() === '' || cuenta.trim() === '' ||
                    correo.trim() === '' || telefono.trim() === '' ||
                    celular.trim() === '' || contacto.trim() === '' ||
                    nContacto.trim() === ''
                ) {
                    Swal.fire({
                        position: 'center',
                        type: 'warning',
                        title: 'Debe llenar todos los datos',
                        showConfirmButton: false,
                        timer: 1000
                    })
                }
                else {
                    var nombreLargo = `${aPaterno} ${aMaterno} ${nombre}`;
                    $.ajax({
                        type: 'POST',
                        url: backendURL,
                        data: {
                            action: 'modificarEmpleado',
                            nomina: nomina,
                            jefenomina: jefenomina,
                            claveTabulador: claveTabulador,
                            tipoNomina: tipoNomina,
                            empleado_status: tipo,
                            lote: lote,
                            sucursal: sucursal,
                            clasificacion: clasificacion,
                            salarioDiario: salarioDiario,
                            salarioMensual: salarioMensual,
                            celula: celula,
                            fechaAlta: fechaAlta,
                            registro: registro,
                            puesto: puesto,
                            nss: nss,
                            dv: dv,
                            comentario: comentario,
                            nombre: nombre,
                            aPaterno: aPaterno,
                            aMaterno: aMaterno,
                            curpini: curpini,
                            curpfin: curpfin,
                            rfcini: rfcini,
                            rfcfin: rfcfin,
                            genero: genero,
                            fechaNacimiento: fechaNacimiento,
                            nombreLargo: nombreLargo,
                            lNacimiento: lNacimiento,
                            tIdentificacion: tIdentificacion,
                            id: id,
                            eCivil: eCivil,
                            escolaridad: escolaridad,
                            cEscolaridad: cEscolaridad,
                            nPadre: nPadre,
                            nMadre: nMadre,
                            calle: calle,
                            numE: numE,
                            numI: numI,
                            cp: cp,
                            edo: edo,
                            municipio: municipio,
                            localidad: localidad,
                            fraccionamiento: fraccionamiento,
                            domicilio: domicilio,
                            infonavit: infonavit,
                            nInfonavit: nInfonavit,
                            fonacot: fonacot,
                            nFonacot: nFonacot,
                            banco: banco,
                            cuenta: cuenta,
                            correo: correo,
                            telefono: telefono,
                            celular: celular,
                            contacto: contacto,
                            nContacto: nContacto,
                            empleado_activo: empleado_activo
                        },
                        success: function (response) {
                            var respuesta = JSON.parse(response);
                            if (respuesta.estado === 'OK') {
                                Swal.fire({
                                    title: 'Correcto',
                                    text: 'Guardado exitoso!',
                                    type: 'success'
                                })
                                    .then(resultado => {
                                        if (resultado.value) {
                                            // location.reload();
                                            window.location.href = 'index.php?request=empleado';
                                        }
                                    })
                            } else {
                                Swal.fire({
                                    title: 'Error',
                                    text: 'No se realizo el guardado',
                                    type: 'error'
                                })
                                    .then(resultado => {
                                        if (resultado.value) {
                                            // location.reload();
                                        }
                                    })
                            }
                        }
                    });
                }
            });
            break;
        //GUARDAR EMPLEADO  
        case 'alta-empleado':
            var botonValidar = $("#btnValidar"),
                vcurp = $(".validaCurp"),
                altaEmpleado = $(".altaEmpleado"),
                reingresarEmpleado = $(".reingresarEmpleado"),
                txtSucursal = $("#txtSucursal"),
                txtClasificacion = $("#txtClasificacion"),
                txtNomina = $("#txtNomina"),
                txtCelula = $("#txtCelula"),
                txtPuesto = $("#txtPuesto"),
                txtJefe = $("#txtJefe"),
                txtCURP = $("#txtCURP"),
                txtTipo = $('#txtTipo'),
                txtFraccionamiento = $("#txtFraccionamiento"),
                txtComentario = $("#txtComentario"),
                txtSalarioMensual = $("#txtSalarioMensual"),
                sucursal = '',
                clasificacion = '',
                ccurp = $("#campo-curp"),
                genero = '';



            ccurp.focusout(function () {
                textocurp = $("#campo-curp").val();
                //ASIGNAR FECHA NACIMIENTO DESDE CURP


            });

            //EVITAR ACCION AL PRESIONAR LA TECLA ENTER
            ccurp.keypress(function (event) {
                if (event.keyCode == 13) return false;
            });

            //VALIDAR SI LA CURP TIENE 18 CARACTERES HABILITA BOTON DE ENVIO
            ccurp.keyup(function (e) {
                if (ccurp.val().length === 18) {
                    textocurp = $("#campo-curp").val();
                    botonValidar.removeClass('d-none');
                } else if (ccurp.val().length < 18 || e.keyCode == 46) {
                    botonValidar.addClass('d-none');
                }
            });

            //VALIDAR EL REINGRESO DEL EMPLEADO
            let validarReingreso = (curp) => {
                $.ajax({
                    type: 'POST',
                    url: backendURL,
                    data: { action: 'validaReingreso', curp: curp },
                    success: function (response) {
                        var respuesta = JSON.parse(response);
                        if (respuesta.informacion.length === 0) {
                            vcurp.addClass('d-none');
                            camposClave();
                            obtenerNomina();
                            txtTipo.val('Alta');
                            altaEmpleado.removeClass('d-none');
                        } else {
                            let ctrlReingreso = respuesta.informacion[0].controlReingreso;
                            let ctrlEmpleado = respuesta.informacion[0].numero_nomina;
                            let ctrlNombre = respuesta.informacion[0].nombre_largo;
                            if (ctrlReingreso === '1') {
                                Swal.fire({
                                    position: 'center',
                                    type: 'warning',
                                    title: 'Reingreso NO Permitido!',
                                    text: 'No es posible reingresar a: ' + ctrlNombre + ' con Numero de nomina: ' + ctrlEmpleado + ', ya que asi se definio durante su baja en Recursos Humanos.',
                                    showConfirmButton: false,
                                    timer: 10000
                                })
                            } else {
                                localStorage.setItem('codigoEmpleado', ctrlEmpleado);
                                vcurp.addClass('d-none');
                                Swal.fire({
                                    position: 'top-end',
                                    type: 'info',
                                    title: 'El CURP ya existe en la base de datos',
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                                window.location.href = 'index.php?request=reingreso-empleado';
                            }
                        }
                    }
                });
            };


            //VALIDAR CURP
            botonValidar.on("click", function (e) {
                e.preventDefault();
                txtCURP.val(textocurp);
                let curp = txtCURP.val();
                validarReingreso(curp);
            });

            //VALIDAR CATEGORIA $$$
            txtSalarioMensual.focusout(function () {
                let salarioMensual = parseFloat(txtSalarioMensual.val());
                if (txtClasificacion.val() === 'A') {
                    if (salarioMensual < 2250 || salarioMensual > 20000 || !($.isNumeric(salarioMensual))) {
                        txtSalarioMensual.val('');
                        txtSalarioMensual.addClass('btn-outline-danger');
                        Swal.fire({
                            title: 'Aviso',
                            text: 'El salario debe estar en el rango de $2,250.00 a $20,000.00.',
                            type: 'error'
                        });
                    } else {
                        txtSalarioMensual.removeClass('btn-outline-danger');
                    }
                }
            });


            //LLENAR CAMPOS CLAVE SI NO EXISTE EN LA BD
            let camposClave = () => {
                genero = (textocurp.charAt(10) === 'M') ? 'F' : 'M';
                $("#txtGenero").val(genero);
                let extractRFC = textocurp.substr(0, 10);
                var aNacimiento = textocurp.substr(4, 2),
                    mNacimiento = textocurp.substr(6, 2),
                    dNacimiento = textocurp.substr(8, 2);
                /**WORK IT */
                if (aNacimiento.substr(0, 1) === '0') {
                    aNacimiento = '200' + aNacimiento.substr(1, 1);
                }
                var now = new Date(aNacimiento, mNacimiento - 1, dNacimiento);
                var nyear = now.getFullYear();

                var fNacimiento = nyear + '-' + mNacimiento + '-' + dNacimiento;

                $("#txtfechaNacimiento").val(fNacimiento);
                $('#txtRFC').val(extractRFC);

                //ASIGNAR ENTIDAD DE NACIMIENTO DESDE CURP
                var url = 'inc/model/entidades.json',
                    entidad = textocurp.substr(11, 2);
                $.getJSON(url, function (data) {
                    var clave = '';
                    for (var e in data.entidades) {
                        clave = data.entidades[e].clave;
                        if (clave === entidad) {
                            $("#txtLnacimiento").val(data.entidades[e].nombre);
                        }
                    }
                });
            }

            let obtenerNomina = () => {
                var action = 'obtenerNomina';
                var numeroNomina = 'error!';
                $.ajax({
                    type: 'POST',
                    url: backendURL,
                    data: { action: action },
                    success: function (response) {
                        var respuesta = JSON.parse(response);
                        if (respuesta.informacion.length === 1) {
                            numeroNomina = respuesta.informacion[0].numeroNomina;
                            txtNomina.val(numeroNomina + 1);
                        }
                    }
                });
            }

            //LLENAR SUCURSALES
            var listaSUC = new FormData(),
                action = 'buscarSucursal';
            listaSUC.append('action', action);
            var xmlSUC = new XMLHttpRequest();
            xmlSUC.open('POST', backendURL, true);
            xmlSUC.onload = function () {
                if (this.status === 200) {
                    var respuesta = JSON.parse(xmlSUC.responseText);
                    if (respuesta.estado === 'OK') {
                        var informacion = respuesta.informacion;
                        var s = '<option value="" selected>Seleccionar una Sucursal</option>';
                        for (var i in informacion) {
                            s += '<option value="' + informacion[i].id_sucursal + '">' + informacion[i].nombre + '</option>';
                        }
                        txtSucursal.html(s);
                    } else if (respuesta.status === 'error') {
                        var informacion = respuesta.informacion;
                    }
                }
            }
            xmlSUC.send(listaSUC);

            //LLENAR NOMINA
            var listaNOM = new FormData(),
                action = 'buscarNomina';
            listaNOM.append('action', action);
            var xmlNOM = new XMLHttpRequest();
            xmlNOM.open('POST', backendURL, true);
            xmlNOM.onload = function () {
                if (this.status === 200) {
                    var respuesta = JSON.parse(xmlNOM.responseText);
                    // console.log(respuesta);
                    if (respuesta.estado === 'OK') {
                        var informacion = respuesta.informacion;
                        var s = '<option value="">Seleccionar nomina</option>';
                        for (var i in informacion) {
                            s += '<option value="' + informacion[i].code_value + '">' + informacion[i].code_value_desc + '</option>';
                        }
                        txtNomina.html(s);
                    } else if (respuesta.status === 'error') {
                        var informacion = respuesta.informacion;
                    }
                }
            }
            xmlNOM.send(listaNOM);

            txtClasificacion.focusout(function () {
                clasificacion = $(this).val();
                llenarCelulas();
            });

            txtSucursal.focusout(function () {
                sucursal = $(this).val();
            });

            function llenarCelulas() {
                //LLENAR CELULAS
                var listaCEL = new FormData(),
                    action = 'buscarCelula';
                listaCEL.append('action', action);
                listaCEL.append('sucursal', sucursal);
                listaCEL.append('clasificacion', clasificacion);
                var xmlCEL = new XMLHttpRequest();
                xmlCEL.open('POST', backendURL, true);
                xmlCEL.onload = function () {
                    if (this.status === 200) {
                        var respuesta = JSON.parse(xmlCEL.responseText);
                        // console.log(respuesta);
                        if (respuesta.estado === 'OK') {
                            var informacion = respuesta.informacion;
                            var s = '<option value="">Seleccionar celula</option>';
                            for (var i in informacion) {
                                s += '<option value="' + informacion[i].id_celula + '">' + informacion[i].nombre + ' - ' + informacion[i].codigo + '</option>';
                            }
                            txtCelula.html(s);
                        } else if (respuesta.status === 'error') {
                            var informacion = respuesta.informacion;
                        }
                    }
                }
                xmlCEL.send(listaCEL);
            }



            //LLENAR PUESTOS POR CELULA SELECCIONADA
            $('#txtCelula').focusout(function () {
                var listaP = new FormData(),
                    action = 'buscarP',
                    paramCel = $('#txtCelula option:selected').val();
                listaP.append('action', action);
                listaP.append('param', paramCel);
                listaP.append('clasificacion', clasificacion);
                var xmlP = new XMLHttpRequest();
                xmlP.open('POST', backendURL, true);
                xmlP.onload = function () {
                    if (this.status === 200) {
                        var respuesta = JSON.parse(xmlP.responseText);
                        if (respuesta.estado === 'OK') {
                            var informacion = respuesta.informacion;
                            var s = '<option value="-1">Seleccionar tipo de puesto</option>';
                            for (var i in informacion) {
                                s += '<option value="' + informacion[i].id_puesto + '">' + informacion[i].nombre + '</option>';
                            }
                            txtPuesto.html(s);
                        } else if (respuesta.status === 'error') {
                            var informacion = respuesta.informacion;
                        }
                    }
                }
                xmlP.send(listaP);
            });


            //LLENAR JEFE DIRECTO POR NIVEL DE PUESTO SELECCIONADO
            $("#txtClasificacion").focusout(function () {
                listarJefes($("#txtClasificacion").val());
            });

            $('#txtTabClave').keypress(function (e) {
                $('#txtTabClave').css("border", "");
            });

            $('#txtTabSucursal').focus(function (e) {
                $('#txtTabSucursal').css("border", "");
            });


            //VALIDAR CODIGO TABULADOR
            $('#txtTabClave').focusout(function (e) {
                if (parseInt($("#txtTabClave").val()) > 100) {
                    Swal.fire({
                        position: 'center',
                        type: 'warning',
                        tittle: 'Error',
                        text: 'EL codigo del tabulador debe ser menor a 100',
                        showConfirmButton: false,
                        timer: 1000
                    });
                    $('#txtTabClave').val('');
                }
            });

            //LLENAR SUCURSAL TABULADOR
            sucursalTabulador();


            //CONTROL CODIGO POSTAL
            $("#txtCP").focusout(function () {
                var cp = $('#txtCP').val();
                listarFraccionamientos(cp);
            });

            $("#txtPaterno").focusout(function () {
                var ap = $("#txtPaterno").val();
                $("#txtAPp").val(ap);
            });

            $("#txtMaterno").focusout(function () {
                var ap = $("#txtMaterno").val();
                $("#txtAPm").val(ap);
            });
            //VALIDAR NUMERO INFONAVIT
            $("#txtInfonavit").change(function () {
                var infonavit = $("#txtInfonavit").val();
                if (infonavit === 'NO') {
                    $("#txtNinfonavit").attr('disabled', 'disabled');
                    $("#txtNinfonavit").val('NA');
                } else {
                    $("#txtNinfonavit").removeAttr('disabled', 'disabled');
                    $("#txtNinfonavit").val('Retenido');
                }
            });

            //VALIDAR NUMERO FONACOT
            $("#txtFonacot").change(function () {
                var infonavit = $("#txtFonacot").val();
                if (infonavit === 'NO') {
                    $("#txtNfonacot").attr('disabled', 'disabled');
                    $("#txtNfonacot").val('NA');
                } else {
                    $("#txtNfonacot").removeAttr('disabled', 'disabled');
                    $("#txtNfonacot").val('Retenido');
                }
            });

            //VALIDAR NUMERO CUENTA BANCO
            $("#txtBanco").change(function () {
                var infonavit = $("#txtBanco").val();
                if (infonavit !== 'NO') {
                    $("#txtCuenta").attr('disabled', 'disabled');
                    $("#txtCuenta").val('NA');
                } else {
                    $("#txtCuenta").removeAttr('disabled', 'disabled');
                    $("#txtCuenta").val('');
                }
            });

            //Validar el puesto ingresado
            $('#txtPuesto').focusout(function () {
                var pto = $('#txtPuesto').val();
                // console.log(pto);
                if(pto < 1)
                {
                    Swal.fire({
                        position: 'center',
                        type: 'warning',
                        title: 'Favor de verificar el puesto nuevamente',
                        showConfirmButton: false,
                        timer: 2500
                    })
                
                    $('#txtPuesto').addClass('btn-outline-danger');

                    setTimeout(function () {
                        $('#txtPuesto').removeClass('btn-outline-danger');
                    }, 3500);

                }
            });

            //Validar el jefe ingresado
            $('#txtJefe').focusout(function () {
                var vJefe = $('#txtJefe').val();
                // console.log(pto);
                if(vJefe < 1)
                {
                    Swal.fire({
                        position: 'center',
                        type: 'warning',
                        title: 'Favor de verificar el jefe nuevamente',
                        showConfirmButton: false,
                        timer: 2500
                    })
                
                    $('#txtJefe').addClass('btn-outline-danger');

                    setTimeout(function () {
                        $('#txtJefe').removeClass('btn-outline-danger');
                    }, 3500);

                }
            });

            // DESHABILITAR CAMPOS
            function lockFields() {
                if ($("#txtGenerp").val().trim() === 0) $("#txtGenero").attr('disabled', 'disabled');
            }

            let btnGuardarEmpleado = $('#btnGuardarEmpleado');

            //BOTON GUARDAR EMPLEADO
            btnGuardarEmpleado.on('click', function (e) {
                e.preventDefault();
                let nomina = $('#txtNomina').val(),
                    jefenomina = txtJefe.val(),
                    claveTabulador = `${$('#txtTabClave').val()}|${$('#txtTabSucursal').val()}`,
                    tipoNomina = $('#txtTipoNomina').val(),
                    tipo = $('#txtTipo').val(),
                    sucursal = $('#txtSucursal').val(),
                    clasificacion = $('#txtClasificacion').val(),
                    salarioDiario = $('#txtSalarioDiario').val(),
                    salarioMensual = txtSalarioMensual.val(),
                    celula = $('#txtCelula').val(),
                    fechaAlta = $('#txtfechaAlta').val(),
                    registro = $('#txtRegistro').val(),
                    puesto = $('#txtPuesto').val(),
                    comentario = txtComentario.val(),
                    nombre = $('#txtNombre').val(),
                    aPaterno = $('#txtPaterno').val(),
                    aMaterno = $('#txtMaterno').val(),
                    curp = $('#txtCURP').val(),
                    rfc = `${$('#txtRFC').val()}${$('#txtHClave').val()}`,
                    nss = $('#txtNSS').val(),
                    dv = $('#txtDV').val(),
                    fechaNacimiento = $('#txtfechaNacimiento').val(),
                    lNacimiento = $('#txtLnacimiento').val(),
                    genero = $('#txtGenero').val(),
                    tIdentificacion = $('#txtTI').val(),
                    id = $('#txtID').val(),
                    eCivil = $('#txtCivil').val(),
                    escolaridad = $('#txtEscolaridad').val(),
                    cEscolaridad = $('#txtStescolaridad').val(),
                    nPadre = `${$('#txtAPp').val()}|${$('#txtAMp').val()}|${$('#txtNomp').val()}`,
                    nMadre = `${$('#txtAPm').val()}|${$('#txtAMm').val()}|${$('#txtNomm').val()}`,
                    calle = $('#txtCalle').val(),
                    numE = $('#txtNume').val(),
                    numI = $('#txtNumi').val(),
                    cp = $('#txtCP').val(),
                    edo = $('#txtEdo').val(),
                    municipio = $('#txtMunicipio').val(),
                    localidad = $('#txtLocalidad').val(),
                    fraccionamiento = $('#txtFraccionamiento').val(),
                    infonavit = $('#txtInfonavit').val(),
                    nInfonavit = $('#txtNinfonavit').val(),
                    fonacot = $('#txtFonacot').val(),
                    nFonacot = $('#txtNfonacot').val(),
                    banco = $('#txtBanco').val(),
                    cuenta = $('#txtCuenta').val(),
                    correo = $('#txtCorreo').val(),
                    telefono = $('#txtTelefono').val(),
                    celular = $('#txtCelular').val(),
                    contacto = $('#txtContacto').val(),
                    nContacto = $('#txtNcontacto').val(),
                    curpini = curp.substr(0, 4),
                    curpfin = curp.substr(10, 8);
                rfcini = rfc.substr(0, 4);
                rfcfin = rfc.substr(10, 3);
                domicilio = `${calle} #${numE} Int.${numI} ${fraccionamiento}`;
                //VALIDAR SI EL TABULADOR ES MANDATORIO
                if ($('#txtTabSucursal').val() === '' && $('#txtTabClave').val().trim() === '') {
                    if (tipoNomina.trim() === 'S' && (clasificacion === 'O' || clasificacion === 'AO')) {
                        Swal.fire({
                            position: 'center',
                            type: 'warning',
                            title: 'El tabulador es necesario',
                            showConfirmButton: false,
                            timer: 3500
                        });
                        $('#txtTabSucursal').css("border", "1px solid red");
                        $('#txtTabSucursal').focus();
                        $('#txtTabClave').css("border", "1px solid red");
                        $('#txtTabClave').focus();
                        $("html, body").animate({ scrollTop: 0 }, 500);
                    }
                }
                else if
                    (
                    jefenomina.trim() === '-1' ||
                    salarioDiario.trim() === '' || celula.trim() === '' ||
                    registro.trim() === '' || puesto.trim() === '-1' ||
                    nombre.trim() === '' || aPaterno.trim() === '' ||
                    aMaterno.trim() === '' || rfc.trim() === '' ||
                    nss.trim() === '' || dv.trim() === '' ||
                    id.trim() === '' || nPadre.trim() === '' ||
                    nMadre.trim() === '' || calle.trim() === '' ||
                    numE.trim() === '' ||
                    cp.trim() === '' || nInfonavit.trim() === '' ||
                    nFonacot.trim() === '' || cuenta.trim() === '' ||
                    correo.trim() === '' || telefono.trim() === '' ||
                    celular.trim() === '' || contacto.trim() === '' ||
                    nContacto.trim() === ''
                ) {
                    Swal.fire({
                        position: 'center',
                        type: 'warning',
                        title: 'Debe llenar todos los datos',
                        showConfirmButton: false,
                        timer: 1000
                    })
                }
                else {
                    var nombreLargo = `${aPaterno} ${aMaterno} ${nombre}`;
                    $.ajax({
                        type: 'POST',
                        url: backendURL,
                        data: {
                            action: 'guardarEmpleado',
                            nomina: nomina,
                            jefenomina: jefenomina,
                            claveTabulador: claveTabulador,
                            tipoNomina: tipoNomina,
                            tipo: tipo,
                            sucursal: sucursal,
                            clasificacion: clasificacion,
                            salarioDiario: salarioDiario,
                            salarioMensual: salarioMensual,
                            celula: celula,
                            fechaAlta: fechaAlta,
                            registro: registro,
                            puesto: puesto,
                            comentario: comentario,
                            nombre: nombre,
                            aPaterno: aPaterno,
                            aMaterno: aMaterno,
                            nombreLargo: nombreLargo,
                            curpini: curpini,
                            curpfin: curpfin,
                            rfcini: rfcini,
                            rfcfin: rfcfin,
                            nss: nss,
                            dv: dv,
                            fechaNacimiento: fechaNacimiento,
                            lNacimiento: lNacimiento,
                            genero: genero,
                            tIdentificacion: tIdentificacion,
                            id: id,
                            eCivil: eCivil,
                            escolaridad: escolaridad,
                            cEscolaridad: cEscolaridad,
                            nPadre: nPadre,
                            nMadre: nMadre,
                            calle: calle,
                            numE: numE,
                            numI: numI,
                            cp: cp,
                            edo: edo,
                            municipio: municipio,
                            localidad: localidad,
                            fraccionamiento: fraccionamiento,
                            domicilio: domicilio,
                            infonavit: infonavit,
                            nInfonavit: nInfonavit,
                            fonacot: fonacot,
                            nFonacot: nFonacot,
                            banco: banco,
                            cuenta: cuenta,
                            correo: correo,
                            telefono: telefono,
                            celular: celular,
                            contacto: contacto,
                            nContacto: nContacto,
                            empleado_activo: empleado_activo
                        },
                        success: function (response) {
                            var respuesta = JSON.parse(response);
                            if (respuesta.estado === 'OK') {
                                Swal.fire({
                                    title: 'Correcto',
                                    text: 'Guardado exitoso!',
                                    type: 'success'
                                })
                                    .then(resultado => {
                                        if (resultado.value) {
                                            // location.reload();
                                            window.location.href = 'index.php?request=empleado';
                                        }
                                    })
                            } else {
                                Swal.fire({
                                    title: 'Error',
                                    text: 'No se realizo el guardado',
                                    type: 'error'
                                })
                                    .then(resultado => {
                                        if (resultado.value) {
                                            // location.reload();
                                        }
                                    })
                            }
                        }
                    });
                }




            });
            break;
        case 'puestos':
            seccionExportar.removeClass('d-none');
            let btnNuevo = $('#btnnPuesto'),
                panelNuevo = $('#nuevo-puesto'),
                btnCancelar = $('#btnCancelar'),
                form_nPuesto = $('#form_nPuesto'),
                btnGuardarPuesto = $('#btnGuardarPuesto'),
                btnActualizarPuesto = $('#btnActualizarPuesto'),
                txtPuestoL = $('#txttPuesto'),
                txtCelulaL = $('#txtnDepartamento');


            btnNuevo.on('click', function () {
                // limpiarCampos();
                panelNuevo.removeClass('d-none');
                btnGuardarPuesto.removeClass('d-none');
                btnNuevo.addClass('d-none');
                btnActualizarPuesto.addClass('d-none');
                llenarTipoPuesto();
                llenarDepartamento();
            });

            btnCancelar.on('click', function () {
                panelNuevo.addClass('d-none');
                btnNuevo.removeClass('d-none');
                form_nPuesto.trigger("reset");
            });

            let llenarTipoPuesto = () => {
                let action = 'obtenerTipoPuesto';
                $.ajax({
                    type: 'POST',
                    url: backendURL,
                    data: { action: action },
                    success: function (response) {
                        let respuesta = JSON.parse(response);
                        let puestoTipo = respuesta.informacion,
                            campo = '';
                        for (var i in puestoTipo) {
                            campo += '<option value="' + puestoTipo[i].id_puesto + '">' + puestoTipo[i].nivel + ' - ' + puestoTipo[i].nombre + '</option>';
                        }
                        txtPuestoL.html(campo);
                    }
                });
            }

            

            let limpiarCampos = () => {
                $('#txttPuesto').val(''),
                    $('#txtnPuesto').val(''),
                    $('#txtnDepartamento').val(''),
                    $('#txtdPuesto').val('');
            }

            let llenarTablaPuestos = () => {
                let action = 'obtenerPuestos';
                $.ajax({
                    type: 'POST',
                    url: backendURL,
                    data: { action: action },
                    success: function (response) {
                        let respuesta = JSON.parse(response);
                        // console.log(respuesta);
                        let puesto = respuesta.informacion;
                        for (var i in puesto) {
                            $('#dataTable').append
                                ("<tr><td class='trCode'>" + puesto[i].codigo + " </td>" +
                                    "<td>" + puesto[i].departamento + " </td>" +
                                    "<td>" + puesto[i].nombre + " </td>" +
                                    "<td>" + puesto[i].descripcion + " </td>" +
                                    "<td class='d-none'>" + puesto[i].id_nivel + " </td>" +
                                    "<td>" + (puesto[i].created_at.date).substr(0, 10) + " </td>" +
                                    "<td>" + (puesto[i].updated_at.date).substr(0, 10) + " </td>" +
                                    "<td>" + puesto[i].updated_by + " </td>" +
                                    "<td><a class='btn btn-primary btnEditarRegistro text-white btn-block'" +
                                    "data-codigo='" + puesto[i].codigo + "'" +
                                    "data-id_nivel='" + puesto[i].id_nivel + "'" +
                                    "data-nombre='" + puesto[i].nombre + "'" +
                                    "data-departamento='" + puesto[i].id_celula + "'" +
                                    "data-descripcion='" + puesto[i].descripcion + "'" +
                                    "role='button' title='Editar Registro'><i class='fas fa-edit'></i></a> </td></tr>");
                        }
                        $(".btnEditarRegistro").click(function () {
                            llenarTipoPuesto();
                            llenarDepartamento();
                            btnGuardarPuesto.addClass('d-none');
                            $("html, body").animate({ scrollTop: 0 }, 500);
                            let codigoPuesto = $((this)).data('codigo'),
                                id_nivel = $((this)).data('id_nivel'),
                                departamento = $((this)).data('departamento'),
                                descripcion = $((this)).data('descripcion'),
                                nombre = $((this)).data('nombre'),
                                codigo = $((this)).data('codigo');
                            btnNuevo.addClass('d-none');
                            btnActualizarPuesto.removeClass('d-none');
                            panelNuevo.removeClass('d-none');
                            setTimeout(function () {
                                $("#txttPuesto").val(id_nivel).attr('selected', true);
                            }, 150);
                            $('#txtnPuesto').val(nombre);
                            setTimeout(function () {
                                if (departamento === 0)
                                    $("#txtnDepartamento").val(5).attr('selected', true);
                                else
                                    $("#txtnDepartamento").val(departamento).attr('selected', true);
                            }, 150);
                            $('#txtdPuesto').val(descripcion);
                            $('#txtCodigoPuesto').val(codigo);
                        });
                    }
                });
            }


            llenarTablaPuestos();

            btnActualizarPuesto.on('click', function (e) {
                e.preventDefault();
                let puestoNivel = $('#txttPuesto').val(),
                    puestoNombre = $('#txtnPuesto').val(),
                    puestoDepartamento = $('#txtnDepartamento').val(),
                    puestoDescripcion = $('#txtdPuesto').val(),
                    puestoCodigo = $('#txtCodigoPuesto').val(),
                    puestoCorto = (puestoNombre.split(/\s/).reduce((response, word) => response += word.slice(0, 1), '')).toUpperCase();

                if (puestoNombre.trim() === '' || puestoDescripcion.trim() === '') {
                    Swal.fire({
                        position: 'center',
                        type: 'warning',
                        title: 'Debe llenar todos los datos',
                        showConfirmButton: false,
                        timer: 1000
                    })
                } else {
                    $.ajax({
                        type: 'POST',
                        url: backendURL,
                        data: { action: 'actualizarPuesto', puestoCodigo: puestoCodigo, puestoNivel: puestoNivel, puestoNombre: puestoNombre, puestoCorto: puestoCorto, puestoDepartamento: puestoDepartamento, puestoDescripcion: puestoDescripcion, empleadoControl: empleado_activo },
                        success: function (response) {
                            let respuesta = JSON.parse(response);
                            if (respuesta.estado === 'OK') {
                                Swal.fire({
                                    title: 'Correcto',
                                    text: 'Puesto actualizado correctamente!',
                                    type: 'success'
                                })
                                    .then(resultado => {
                                        if (resultado.value) {
                                            // location.reload();
                                            window.location.href = 'index.php?request=puestos';
                                        }
                                    })
                            } else {
                                Swal.fire({
                                    title: 'Error',
                                    text: respuesta.informacion,
                                    type: 'error'
                                })
                                    .then(resultado => {
                                        if (resultado.value) {
                                            // location.reload();
                                        }
                                    })
                            }
                        }
                    });
                }
            });

            btnGuardarPuesto.on('click', function (e) {
                e.preventDefault();

                let puestoNivel = $('#txttPuesto').val(),
                    puestoNombre = $('#txtnPuesto').val(),
                    puestoDepartamento = $('#txtnDepartamento').val(),
                    puestoDescripcion = $('#txtdPuesto').val(),
                    puestoCorto = (puestoNombre.split(/\s/).reduce((response, word) => response += word.slice(0, 1), '')).toUpperCase();

                if (puestoNombre.trim() === '' || puestoDescripcion.trim() === '') {
                    Swal.fire({
                        position: 'center',
                        type: 'warning',
                        title: 'Debe llenar todos los datos',
                        showConfirmButton: false,
                        timer: 1000
                    })
                } else {
                    $.ajax({
                        type: 'POST',
                        url: backendURL,
                        data: { action: 'guardarPuesto', puestoNivel: puestoNivel, puestoNombre: puestoNombre, puestoCorto: puestoCorto, puestoDepartamento: puestoDepartamento, puestoDescripcion: puestoDescripcion, empleadoControl: empleado_activo },
                        success: function (response) {
                            let respuesta = JSON.parse(response);
                            if (respuesta.estado === 'OK') {
                                Swal.fire({
                                    title: 'Correcto',
                                    text: 'Guardado exitoso!',
                                    type: 'success'
                                })
                                    .then(resultado => {
                                        if (resultado.value) {
                                            // location.reload();
                                            window.location.href = 'index.php?request=puestos';
                                        }
                                    })
                            } else {
                                Swal.fire({
                                    title: 'Error',
                                    text: respuesta.informacion,
                                    type: 'error'
                                })
                                    .then(resultado => {
                                        if (resultado.value) {
                                            // location.reload();
                                        }
                                    })
                            }
                        }
                    });

                }
            });
            break;
        case 'admin-roles':

            let eliminarRolEmpleado = (nomina) => {
                let numero_nomina = nomina.data('nomina'),
                    idRol = $('#txtidRol').html(),
                    action = 'eliminarempleadoRol';
                Swal.fire({
                    title: 'Estas seguro?',
                    text: "El rol sera eliminado para el empleado " + numero_nomina,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, eliminar rol!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            type: 'POST',
                            url: backendURL,
                            data: { action: action, numero_nomina: numero_nomina },
                            success: function (response) {
                                let respuesta = JSON.parse(response);
                                console.log(respuesta);
                                if (respuesta.estado === 'OK') {
                                    Swal.fire({
                                        title: 'Eliminado!',
                                        text: respuesta.informacion,
                                        type: respuesta.tipo
                                    })
                                        .then(resultado => {
                                            if (resultado.value) {
                                                //location.reload();
                                                $('#tableRolEmployee').empty();
                                                listarempRoles(idRol);
                                            }
                                        })
                                } else {
                                    Swal.fire({
                                        title: 'Error',
                                        text: respuesta.informacion,
                                        type: respuesta.tipo
                                    })
                                        .then(resultado => {
                                            if (resultado.value) {
                                                //location.reload();
                                                $('#tableRolEmployee').empty();
                                                listarempRoles(idRol);
                                            }
                                        })
                                }
                            }
                        });
                    }
                })
            }

            let listarempRoles = (idRol) => {
                let action = 'obtenerempRoles';
                $.ajax({
                    type: 'POST',
                    url: backendURL,
                    data: { action: action, idrol: idRol },
                    success: function (response) {
                        let respuesta = JSON.parse(response);
                        let reg = respuesta.informacion;
                        for (var i in reg) {
                            $('#tableRolEmployee').append
                                (
                                    "<tr><td class='trCode'>" + reg[i].numero_nomina + " </td>" +
                                    "<td>" + reg[i].nombre_largo + "</td>" +
                                    "<td>" + reg[i].status + " </td>" +
                                    "<td>" + reg[i].Sucursal + " </td>" +
                                    "<td>" + reg[i].Departamento + " </td>" +
                                    "<td>" + reg[i].fechaCreado + " </td>" +
                                    "<td>" + reg[i].created_by + " </td>" +
                                    "<td><a class='btn btn-sm btn-danger text-white deleteRole' data-nomina='" + reg[i].numero_nomina + "' role='button'>Borrar <i class='fas fa-backspace'></i></a></td></tr>");
                        }
                        $(".deleteRole").click(function () {
                            eliminarRolEmpleado($(this));
                        });
                    }
                });
            }

            let listarRoles = () => {
                let action = 'obtenerRoles';
                $.ajax({
                    type: 'POST',
                    url: backendURL,
                    data: { action: action },
                    success: function (response) {
                        let respuesta = JSON.parse(response);
                        let rol = respuesta.informacion;
                        for (var i in rol) {
                            $('#tableRoles').append
                                (
                                    "<tr><td class='trCode'>" + rol[i].id + " </td>" +
                                    "<td>" + rol[i].tipo + "</td>" +
                                    "<td>" + rol[i].fecha + " </td>" +
                                    "<td><a class='btn btn-sm btn-success text-white selectRole' data-id='" + rol[i].id + "' data-nombre='" + rol[i].tipo + "' data-descripcion='" + rol[i].descripcion + "' data-fecha='" + rol[i].fecha + "' role='button'>IR <i class='fas fa-arrow-circle-right'></i></a></td></tr>");
                        }
                        $(".selectRole").click(function () {
                            let idRol = $((this)).data('id'),
                                nombreRol = $((this)).data('nombre'),
                                descripcion = $((this)).data('descripcion'),
                                fecha = $((this)).data('fecha');
                            listarempRoles(idRol);
                            $('.lista-roles').addClass('d-none');
                            $('.rol-selecionado').removeClass('d-none');
                            $("#txtidRol").html(idRol);
                            $("#txtRol").html("<b>Rol: </b>" + nombreRol);
                            $('#txtFechaRol').html("<b>Fecha creacion: </b>" + fecha);
                            $('#txtRolDescripcion').html("<b>Descripcion: </b>" + descripcion);
                        });
                    }
                });
            }

            let listarEmpleados = () => {
                let action = 'obtenerEmpleadosRoles';
                $.ajax({
                    type: 'POST',
                    url: backendURL,
                    data: { action: action },
                    success: function (response) {
                        let respuesta = JSON.parse(response);
                        let emp = respuesta.informacion,
                            emprow = '<option value="" selected>Seleccionar Empleado</option>';
                        for (var i in emp) {
                            emprow += '<option value="' + emp[i].numero_nomina + '">' + emp[i].numero_nomina + ' ' + emp[i].nombre_largo + '</option>';
                        }
                        $('#txtDatosEmpleado').html(emprow);
                    }
                });
            }

            listarRoles();

            $('#cancelarRol').click(function () {
                $('.lista-roles').removeClass('d-none');
                $('.rol-selecionado').addClass('d-none');
                $('.empleadoRol').addClass('d-none');
                $('#tableRoles').empty();
                $('#tableRolEmployee').empty();
                $('#txtNombreEmpleado').val('');
                listarRoles();
            });

            $('#asignarRol').click(async function () {
                $('.empleadoRol').removeClass('d-none');
                listarEmpleados();
            });

            $('#btnAgregarEmpleadoRol').click(async function () {
                let empRol = $('#txtNombreEmpleado').val().trim(),
                    idRol = $('#txtidRol').html(),
                    action = 'agregarempleadoRol';
                if (empRol.length < 5 || empRol.trim() === '') {
                    Swal.fire({
                        position: 'center',
                        type: 'warning',
                        title: 'Favor de elegir un empleado de la lista mostrada',
                        showConfirmButton: false,
                        timer: 2000
                    })
                } else {
                    $.ajax({
                        type: 'POST',
                        url: backendURL,
                        data: { action: action, numero_nomina: empRol, idrol: idRol, empleadoControl: empleado_activo },
                        success: function (response) {
                            let respuesta = JSON.parse(response);
                            if (respuesta.estado === 'OK') {
                                Swal.fire({
                                    title: 'Correcto',
                                    text: respuesta.informacion,
                                    type: respuesta.tipo
                                })
                                    .then(resultado => {
                                        if (resultado.value) {
                                            //location.reload();
                                            $('#txtNombreEmpleado').val('');
                                            $('#tableRolEmployee').empty();
                                            listarempRoles(idRol);
                                        }
                                    })
                            } else {
                                Swal.fire({
                                    title: 'Error',
                                    text: respuesta.informacion,
                                    type: respuesta.tipo
                                })
                                    .then(resultado => {
                                        if (resultado.value) {
                                            //location.reload();
                                            $('#txtNombreEmpleado').val('');
                                            $('#tableRolEmployee').empty();
                                            listarempRoles(idRol);
                                        }
                                    })
                            }
                        }
                    });
                }
            });



        break;
        // GESTION DE CLASIFICACION DE BAJAS
        case 'gestionar-codigos':
        $('.seccionTitulo').html('Gestionar Clasificación de Bajas');
        var seccionClasificacion = $('.seccionClasificacion'),
            seccionMotivos = $('.seccionMotivos'),
            seccionExplicacion = $('.seccionExplicacion'),
            btnRegresarMOT = $('.btnRegresarMOT'),
            btnNuevoRegistro = $('.btn-nuevo-registro'),
            claveCOD = $('#claveCOD');

        btnRegresarMOT.click(function(){
            seccionClasificacion.removeClass('d-none');
            seccionMotivos.addClass('d-none');
            seccionExplicacion.addClass('d-none');
            $('#tableEXPBajas').empty();
            $('#tableMOTBajas').empty();
            claveCOD.val('');
        })

        let tablaExplicacionBajas = (bajaMOT) => {
            $.ajax({
                type: 'POST',
                url: backendURL,
                data: { action: 'regCLABAJ', param: 'explicacion', key: bajaMOT },
                success: function (response) {
                    let respuesta = JSON.parse(response);
                    let reg = respuesta.informacion;
                    for (var i in reg) {
                        var idCode = 'tdCode',
                            claREG = '',
                            claiREG = 'fas fa-toggle-on',
                            statusREG = reg[i].created_at.date.substr(0, 10);
                        if(reg[i].counter === 0){
                            idCode = 'trCode';
                        }
                        if(statusREG === '1900-01-01'){
                            claREG = 'alert alert-warning';
                            claiREG = 'fas fa-toggle-off';
                        }
                        $('#tableEXPBajas').append
                            (
                                "<tr class='"+claREG+"'><td class='" + idCode + "' data-codigob='" + reg[i].codigo + "' data-descripcionb='" + reg[i].descripcion + "'>" + reg[i].codigo + " </td>" +
                                "<td>" + reg[i].descripcion + "<span class='badge badge-pill badge-info ml-4'>" + reg[i].counter + "</td>" +
                                "<td>" + reg[i].created_at.date.substr(0, 10) + " </td>" +
                                "<td>" + reg[i].created_by + " </td>" +
                                "<td>" + reg[i].updated_at.date.substr(0, 10) + " </td>" +
                                "<td>" + reg[i].updated_by + " </td>"+
                                "<td><a class='btn btn-sm btn-outline-info changestatusCLAB ml-2' data-statusb='" + reg[i].created_at.date.substr(0, 10) + "' data-codigob='" + reg[i].codigo + "' role='button'><i class='"+ claiREG +"'></i></a></td></tr>");
                    }

                    $(".updateEXPB").click(function () {
                        $('#tableEXPBajas').empty();
                        let bajaMOT = $((this)).data('codigo');
                        tablaExplicacionBajas(bajaMOT);
                    });

                    $(".trCode").unbind().click(function () {
                        var codigo_baja_actualizar = $((this)).data('codigob'),
                            descripcion_baja_actualizar = $((this)).data('descripcionb');
                        actualizartablaBajas(codigo_baja_actualizar,descripcion_baja_actualizar);
                    });

                    $(".tdCode").unbind().click(function () {
                        Swal.fire('Registro ya asignado, no es posible eliminar y/o actualizar.')
                    });

                    $(".changestatusCLAB").unbind().click(function () {
                        var codigo_baja_actualizar = $((this)).data('codigob'),
                            status_baja_actualizar = $((this)).data('statusb');
                        if(status_baja_actualizar === '1900-01-01'){
                            status_baja_actualizar = 0;
                        } else {
                            status_baja_actualizar = 1;
                        }
                        cambiartablaBajas(codigo_baja_actualizar,status_baja_actualizar);
                    });

                }
            });
        }   
        
        btnNuevoRegistro.click(async function () {
            var nuevoTipo = $((this)).data('tipomov');
            const { value: nuevo_registro } = await Swal.fire({
                title: 'Nuevo registro',
                input: 'textarea',
                inputPlaceholder: 'Nuevo registro'
              })
              
              if (nuevo_registro) {
                // Swal.fire(`Nuevo registro: ${famCOD}`)
                $.ajax({
                    type: 'POST',
                    url: backendURL,
                    data: { action: 'nuevoCODBAJ', descripcion: nuevo_registro, key: nuevoTipo, relacionKEY: claveCOD.val(), nominaControl: empleado_activo },
                    success: function (response) {
                        let respuesta = JSON.parse(response);
                        // console.log(respuesta);
                        location.reload();
                    }
                });
              }
        });
    
        async function actualizartablaBajas (cba,dba) {
            const { value: actualizar_registro } = await Swal.fire({
                title: 'Actualizar registro',
                input: 'textarea',
                inputValue: dba,
                inputPlaceholder: 'Actualizar registro'
              })
              
              if (actualizar_registro) {
                // Swal.fire(`Registro actualizado: ${actualizar_registro}`)
                $.ajax({
                    type: 'POST',
                    url: backendURL,
                    data: { action: 'actualizarREGBAJ', descripcion: actualizar_registro, key: cba, nominaControl: empleado_activo },
                    success: function (response) {
                        let respuesta = JSON.parse(response);
                        console.log(respuesta);
                        location.reload();
                    }
                });
              }
        }

        async function cambiartablaBajas (cba,sba) {
            const { value: cambiar_registro } = await Swal.fire({
                title: 'Estado del registro',
                input: 'checkbox',
                inputValue: sba,
                inputPlaceholder:
                    'Cambiar estado del registro',
                confirmButtonText:
                    'Continuar<i class="fa fa-arrow-right"></i>',
                inputValidator: (result) => {
                    if(!result){
                        $.ajax({
                            type: 'POST',
                            url: backendURL,
                            data: { action: 'cambiarREGBAJ', mov: 0, key: cba, nominaControl: empleado_activo },
                            success: function (response) {
                                let respuesta = JSON.parse(response);
                                // console.log(respuesta);
                                location.reload();
                            }
                        });
                    } else {
                        $.ajax({
                            type: 'POST',
                            url: backendURL,
                            data: { action: 'cambiarREGBAJ', mov: 1, key: cba, nominaControl: empleado_activo },
                            success: function (response) {
                                let respuesta = JSON.parse(response);
                                // console.log(respuesta);
                                location.reload();
                            }
                        });
                    }
                }
                })
        }

        let tablaMotivosBaja = (bajaCLA) => {

            $.ajax({
                type: 'POST',
                url: backendURL,
                data: { action: 'regCLABAJ', param: 'motivo', key: bajaCLA },
                success: function (response) {
                    let respuesta = JSON.parse(response);
                    let reg = respuesta.informacion;
                    for (var i in reg) {
                        var idCode = 'tdCode',
                            claREG = '',
                            claiREG = 'fas fa-toggle-on',
                            statusREG = reg[i].created_at.date.substr(0, 10);
                        if(reg[i].counter === 0){
                            idCode = 'trCode';
                        }
                        if(statusREG === '1900-01-01'){
                            claREG = 'alert alert-warning';
                            claiREG = 'fas fa-toggle-off';
                        }
                        $('#tableMOTBajas').append
                            (
                                "<tr class='"+claREG+"'><td class='" + idCode + "' data-codigob='" + reg[i].codigo + "' data-descripcionb='" + reg[i].descripcion + "'>" + reg[i].codigo + " </td>" +
                                "<td>" + reg[i].descripcion + "<span class='badge badge-pill badge-info ml-4'>" + reg[i].counter + "</td>" +
                                "<td>" + reg[i].created_at.date.substr(0, 10) + " </td>" +
                                "<td>" + reg[i].created_by + " </td>" +
                                "<td>" + reg[i].updated_at.date.substr(0, 10) + " </td>" +
                                "<td>" + reg[i].updated_by + " </td>" +
                                "<td><a class='btn btn-sm btn-primary text-white updateMOTB' data-codigo='" + reg[i].codigo + "' role='button'>Editar <i class='fas fa-pen-square'></i></a>"+
                                "<a class='btn btn-sm btn-outline-info changestatusCLAB ml-2' data-statusb='" + reg[i].created_at.date.substr(0, 10) + "' data-codigob='" + reg[i].codigo + "' role='button'><i class='"+ claiREG +"'></i></a></td></tr>");
                    }

                    $(".updateMOTB").click(function () {
                        $('#tableMOTBajas').empty();
                        seccionMotivos.addClass('d-none');
                        seccionExplicacion.removeClass('d-none');
                        let bajaMOT = $((this)).data('codigo');
                        bajaMOT = bajaMOT.substr(6, 2);
                        tablaExplicacionBajas(bajaMOT);
                        claveCOD.val(bajaMOT);
                    });

                    $(".trCode").unbind().click(function () {
                        var codigo_baja_actualizar = $((this)).data('codigob'),
                            descripcion_baja_actualizar = $((this)).data('descripcionb');
                        actualizartablaBajas(codigo_baja_actualizar,descripcion_baja_actualizar);
                    });

                    $(".tdCode").unbind().click(function () {
                        Swal.fire('Registro ya asignado, no es posible eliminar y/o actualizar.')
                    });

                    $(".changestatusCLAB").unbind().click(function () {
                        var codigo_baja_actualizar = $((this)).data('codigob'),
                            status_baja_actualizar = $((this)).data('statusb');
                        if(status_baja_actualizar === '1900-01-01'){
                            status_baja_actualizar = 0;
                        } else {
                            status_baja_actualizar = 1;
                        }
                        cambiartablaBajas(codigo_baja_actualizar,status_baja_actualizar);
                    });

                }
            });
        }
        

        $.ajax({
            type: 'POST',
            url: backendURL,
            data: { action: 'regCLABAJ', param: 'clasificacion'},
            success: function (response) {
                let respuesta = JSON.parse(response);
                let reg = respuesta.informacion;
                console.log(respuesta);
                for (var i in reg) {
                    var idCode = 'tdCode',
                        claREG = '',
                        claiREG = 'fas fa-toggle-on',
                        statusREG = reg[i].created_at.date.substr(0, 10);
                        if(reg[i].counter === 0){
                            idCode = 'trCode';
                        }
                        if(statusREG === '1900-01-01'){
                            claREG = 'alert alert-warning';
                            claiREG = 'fas fa-toggle-off';
                        }
                    $('#tableCLABajas').append
                        (
                            "<tr class='"+claREG+"'><td class='" + idCode + "' data-codigob='" + reg[i].codigo + "' data-descripcionb='" + reg[i].descripcion + "'>" + reg[i].codigo + " </td>" +
                            "<td>" + reg[i].descripcion.toUpperCase() + "<span class='badge badge-pill badge-info ml-4'>" + reg[i].counter + "</span></td>" +
                            "<td>" + reg[i].created_at.date.substr(0, 10) + " </td>" +
                            "<td>" + reg[i].created_by + " </td>" +
                            "<td>" + reg[i].updated_at.date.substr(0, 10) + " </td>" +
                            "<td>" + reg[i].updated_by + " </td>" +
                            "<td><a class='btn btn-sm btn-primary text-white updateCLAB' data-codigo='" + reg[i].codigo + "' role='button'>Editar <i class='fas fa-pen-square'></i></a>"+
                            "<a class='btn btn-sm btn-outline-info changestatusCLAB ml-2' data-statusb='" + reg[i].created_at.date.substr(0, 10) + "' data-codigob='" + reg[i].codigo + "' role='button'><i class='"+ claiREG +"'></i></a></td></tr>");
                }

                $(".updateCLAB").click(function () {
                    $('#tableMOTBajas').empty();
                    seccionClasificacion.addClass('d-none');
                    seccionMotivos.removeClass('d-none');
                    let bajaCLA = $((this)).data('codigo');
                    bajaCLA = bajaCLA.substr(0, 3);
                    tablaMotivosBaja(bajaCLA);
                    claveCOD.val(bajaCLA);
                });

                $(".trCode").unbind().click(function () {
                    var codigo_baja_actualizar = $((this)).data('codigob'),
                        descripcion_baja_actualizar = $((this)).data('descripcionb');
                    actualizartablaBajas(codigo_baja_actualizar,descripcion_baja_actualizar);
                });

                $(".tdCode").unbind().click(function () {
                    Swal.fire('Registro ya asignado, no es posible eliminar y/o actualizar.')
                });

                $(".changestatusCLAB").unbind().click(function () {
                    var codigo_baja_actualizar = $((this)).data('codigob'),
                        status_baja_actualizar = $((this)).data('statusb');
                    if(status_baja_actualizar === '1900-01-01'){
                        status_baja_actualizar = 0;
                    } else {
                        status_baja_actualizar = 1;
                    }
                    cambiartablaBajas(codigo_baja_actualizar,status_baja_actualizar);
                });
                
            }
        });

        break;
        // GESTION DE CLASIFICACION DE BAJAS
        case 'gestionar-tabuladores':
        $('.seccionTitulo').html('Gestionar Tabuladores');
        var seccionTabuladores = $('.seccionTabuladores'),
            agregarTabulador = $('.agregarTabulador'),
            editarTabulador = $('.editarTabulador'),
            btnnvoTab = $('#btnnvoTab'),
            btnguardarTAB = $('.btnguardarTAB'),
            btnactualizarTAB = $('.btnactualizarTAB'),
            btnregresarTAB = $('.btnregresarTAB');

        btnregresarTAB.click(function(){
            seccionTabuladores.removeClass('d-none');
            agregarTabulador.addClass('d-none');
            editarTabulador.addClass('d-none');
        })

        btnguardarTAB.click(function(){
            seccionTabuladores.removeClass('d-none');
            agregarTabulador.addClass('d-none');
            editarTabulador.addClass('d-none');
        })

        btnactualizarTAB.click(function(){
            seccionTabuladores.removeClass('d-none');
            agregarTabulador.addClass('d-none');
            editarTabulador.addClass('d-none');
        })

        btnnvoTab.click(function(){
            seccionTabuladores.addClass('d-none');
            agregarTabulador.removeClass('d-none');
            editarTabulador.addClass('d-none');
        })

        let tablaTabuladores = () => {
            $.ajax({
                type: 'POST',
                url: backendURL,
                data: { action: 'tablaTabuladores' },
                success: function (response) {
                    let respuesta = JSON.parse(response);
                    let reg = respuesta.informacion;
                    for (var i in reg) {
                        $('#tableTabulador').append
                            (
                                "<tr><td class='trCode'>" + reg[i].id + " </td>" +
                                "<td>" + reg[i].categoria + "</td>" +
                                "<td>" + reg[i].sd + "</td>" +
                                "<td>" + reg[i].sdi + "</td>" +
                                "<td>" + reg[i].sueldo + "</td>" +
                                "<td>" + reg[i].p_asistencia + "</td>" +
                                "<td>" + reg[i].p_puntualidad + "</td>" +
                                "<td>" + reg[i].despensa + "</td>" +
                                "<td>" + reg[i].f_ahorro + "</td>" +
                                "<td>" + reg[i].percepciones + "</td>" +
                                "<td>" + reg[i].imss + "</td>" +
                                "<td>" + reg[i].ispt + "</td>" +
                                "<td>" + reg[i].sueldo_neto + "</td>" +
                                "<td>" + reg[i].created_at.date.substr(0, 10) + " </td>" +
                                "<td>" + reg[i].created_by + " </td>" +
                                "<td>" + reg[i].updated_at.date.substr(0, 10) + " </td>" +
                                "<td>" + reg[i].updated_by + " </td>" +
                                "<td><a class='btn btn-sm btn-info text-white updateTAB' data-id='" + reg[i].id + "' role='button'>Editar <i class='fas fa-pen-square'></i></a></td></tr>");
                    }

                    $(".updateTAB").click(function(){
                        seccionTabuladores.addClass('d-none');
                        agregarTabulador.addClass('d-none');
                        editarTabulador.removeClass('d-none');
                    })

                    // $(".updateEXPB").click(function () {
                    //     $('#tableEXPBajas').empty();
                    //     let bajaMOT = $((this)).data('codigo');
                    //     tablaExplicacionBajas(bajaMOT);
                    // });

                    // $(".trCode").unbind().click(function () {
                    //     var codigo_baja_actualizar = $((this)).data('codigob'),
                    //         descripcion_baja_actualizar = $((this)).data('descripcionb');
                    //     actualizartablaBajas(codigo_baja_actualizar,descripcion_baja_actualizar);
                    // });

                }
            });
        }   
        tablaTabuladores();
         
        // btnNuevoRegistro.click(async function () {
        //     const { value: nuevo_registro } = await Swal.fire({
        //         title: 'Nuevo registro',
        //         input: 'textarea',
        //         // inputValue: '',
        //         inputPlaceholder: 'Nuevo registro'
        //       })
              
        //       if (nuevo_registro) {
        //         Swal.fire(`Nuevo registro: ${nuevo_registro}`)
        //       }
        // });
    
        // async function actualizartablaBajas (cba,dba) {
        //     const { value: actualizar_registro } = await Swal.fire({
        //         title: 'Actualizar registro',
        //         input: 'textarea',
        //         inputValue: dba,
        //         inputPlaceholder: 'Actualizar registro'
        //       })
              
        //       if (actualizar_registro) {
        //         Swal.fire(`Registro actualizado: ${actualizar_registro}`)
        //       }
        // }

        // let tablaMotivosBaja = (bajaCLA) => {

        //     $.ajax({
        //         type: 'POST',
        //         url: backendURL,
        //         data: { action: 'claBajas', param: 'motivo', key: bajaCLA },
        //         success: function (response) {
        //             let respuesta = JSON.parse(response);
        //             let reg = respuesta.informacion;
        //             for (var i in reg) {
        //                 $('#tableMOTBajas').append
        //                     (
        //                         "<tr><td class='trCode' data-codigob='" + reg[i].codigo + "' data-descripcionb='" + reg[i].descripcion + "'>" + reg[i].codigo + " </td>" +
        //                         "<td>" + reg[i].descripcion + "</td>" +
        //                         "<td>" + reg[i].created_at.date.substr(0, 10) + " </td>" +
        //                         "<td>" + reg[i].created_by + " </td>" +
        //                         "<td>" + reg[i].updated_at.date.substr(0, 10) + " </td>" +
        //                         "<td>" + reg[i].updated_by + " </td>" +
        //                         "<td><a class='btn btn-sm btn-primary text-white updateMOTB' data-codigo='" + reg[i].codigo + "' role='button'>Editar <i class='fas fa-pen-square'></i></a></td></tr>");
        //             }

        //             $(".updateMOTB").click(function () {
        //                 $('#tableMOTBajas').empty();
        //                 seccionMotivos.addClass('d-none');
        //                 seccionExplicacion.removeClass('d-none');
        //                 let bajaMOT = $((this)).data('codigo');
        //                 bajaMOT = bajaMOT.substr(6, 2);
        //                 tablaExplicacionBajas(bajaMOT);
        //             });

        //             $(".trCode").unbind().click(function () {
        //                 var codigo_baja_actualizar = $((this)).data('codigob'),
        //                     descripcion_baja_actualizar = $((this)).data('descripcionb');
        //                 actualizartablaBajas(codigo_baja_actualizar,descripcion_baja_actualizar);
        //             });

        //         }
        //     });.
        // }
        

        // $.ajax({
        //     type: 'POST',
        //     url: backendURL,
        //     data: { action: 'claBajas', param: 'clasificacion' },
        //     success: function (response) {
        //         let respuesta = JSON.parse(response);
        //         let reg = respuesta.informacion;
        //         for (var i in reg) {
        //             $('#tableCLABajas').append
        //                 (
        //                     "<tr><td class='trCode' data-codigob='" + reg[i].codigo + "' data-descripcionb='" + reg[i].descripcion + "'>" + reg[i].codigo + " </td>" +
        //                     "<td>" + reg[i].descripcion + "</td>" +
        //                     "<td>" + reg[i].created_at.date.substr(0, 10) + " </td>" +
        //                     "<td>" + reg[i].created_by + " </td>" +
        //                     "<td>" + reg[i].updated_at.date.substr(0, 10) + " </td>" +
        //                     "<td>" + reg[i].updated_by + " </td>" +
        //                     "<td><a class='btn btn-sm btn-primary text-white updateCLAB' data-codigo='" + reg[i].codigo + "' role='button'>Editar <i class='fas fa-pen-square'></i></a></td></tr>");
        //         }

        //         $(".updateCLAB").click(function () {
        //             $('#tableMOTBajas').empty();
        //             seccionClasificacion.addClass('d-none');
        //             seccionMotivos.removeClass('d-none');
        //             let bajaCLA = $((this)).data('codigo');
        //             bajaCLA = bajaCLA.substr(0, 3);
        //             tablaMotivosBaja(bajaCLA);
        //         });

        //         $(".trCode").unbind().click(function () {
        //             var codigo_baja_actualizar = $((this)).data('codigob'),
        //                 descripcion_baja_actualizar = $((this)).data('descripcionb');
        //             actualizartablaBajas(codigo_baja_actualizar,descripcion_baja_actualizar);
        //         });
                
        //     }
        // });

        break;
         // ENCUESTA DE SALIDA
         case 'encuesta_salida':
            seccionExportar.removeClass('d-none');
            $('.seccionTitulo').html('Encuesta de salida');
            $.ajax({
                type: 'POST',
                url: backendURL,
                data: { action: 'encuestaSalida' },
                success: function (response) {
                    let respuesta = JSON.parse(response);
                    let reg = respuesta.informacion;
                    for (var i in reg) {
                        $('#sheetTable').append
                            (
                                "<tr><td>" + reg[i].numero_nomina + " </td>" +
                                "<td>" + reg[i].nombre_largo + "</td>" +
                                "<td>" + reg[i].Departamento + "</td>" +
                                "<td>" + reg[i].Puesto + "</td>" +
                                "<td>" + reg[i].status + "</td>" +
                                "<td>" + reg[i].fecha_baja + "</td>" +
                                "<td>" + reg[i].Jefe + "</td>" +
                                "<td>" + reg[i].telefono + "</td>" +
                                "<td>" + reg[i].respuesta_1 + "</td>" +
                                "<td>" + reg[i].sub_respuesta_1 + "</td>" +
                                "<td>" + reg[i].respuesta_2_1 + "</td>" +
                                "<td>" + reg[i].respuesta_2_2 + "</td>" +
                                "<td>" + reg[i].respuesta_2_3 + "</td>" +
                                "<td>" + reg[i].respuesta_2_4 + "</td>" +
                                "<td>" + reg[i].respuesta_2_5 + "</td>" +
                                "<td>" + reg[i].respuesta_2_6 + "</td>" +
                                "<td>" + reg[i].respuesta_2_7 + "</td>" +
                                "<td>" + reg[i].respuesta_2_8 + "</td>" +
                                "<td>" + reg[i].respuesta_2_9 + "</td>" +
                                "<td>" + reg[i].respuesta_2_10 + "</td>" +
                                "<td>" + reg[i].respuesta_2_11 + "</td>" +
                                "<td>" + reg[i].respuesta_3 + "</td>" +
                                "<td>" + reg[i].respuesta_4 + "</td>" +
                                "<td>" + reg[i].respuesta_5 + "</td>" +
                                "<td>" + reg[i].respuesta_6 + "</td>" +
                                "<td>" + reg[i].respuesta_7 + "</td>" +
                                "<td>" + reg[i].respuesta_7_1 + "</td>" +
                                "<td>" + reg[i].respuesta_8 + "</td>" +
                                "<td>" + reg[i].respuesta_8_1 + "</td>" +
                                "<td>" + reg[i].respuesta_9 + "</td>" +
                                "<td>" + reg[i].respuesta_10 + "</td>" +
                                "<td>" + reg[i].respuesta_10_1 + "</td>" +
                                "<td>" + reg[i].created_at.date.substr(0, 10) + " </td></tr>");
                    }

                }
            });
         break;
         case 'historial-empleados':
            $('.seccionTitulo').html('Historial de empleados');
            seccionExportar.removeClass('d-none');
            $.ajax({
                type: 'POST',
                url: backendURL,
                data: { action: 'historialEmpleado' },
                success: function (response) {
                    let respuesta = JSON.parse(response);
                    let reg = respuesta.informacion;
                    for (var i in reg) {
                        $('#dataTable').append
                            (
                                "<tr><td>" + reg[i].numero_nomina + " </td>" +
                                "<td>" + reg[i].tipo_movimiento + "</td>" +
                                "<td>" + reg[i].nombre_largo + "</td>" +
                                "<td>" + reg[i].fecha_alta.date.substr(0, 10) + "</td>" +
                                "<td>" + reg[i].fecha_baja.date.substr(0, 10) + "</td>" +
                                "<td>" + reg[i].status + "</td>" +
                                "<td>" + reg[i].Sucursal + "</td>" +
                                "<td>" + reg[i].Celula + "</td>" +
                                "<td>" + reg[i].Puesto + "</td>" +
                                "<td>" + reg[i].clasificacionBaja + "</td>" +
                                "<td>" + reg[i].motivonBaja + "</td>" +
                                "<td>" + reg[i].expnBaja + "</td>" +
                                "<td>" + reg[i].updated_at.date.substr(0, 10) + "</td>" +
                                "<td>" + reg[i].updated_by + "</td></tr>");
                    }

                }
            });
         break;
         case 'encuesta':
            $('.seccionTitulo').html('Encuesta de salida');
            var btnESalida = $('#btn-nomina-esalida'),
                btnguardarENC = $('.btnguardarENC'),
                contenido_encuesta = $('.contenido_encuesta');
            
            btnESalida.click(function () {
                var nomina_encuestado = $('#numero_nomina').val();
                
                $.ajax({
                type: 'POST',
                url: backendURL,
                data: { action: 'buscarEncuestado', nomina_encuestado: nomina_encuestado },
                success: function (response) {
                    let respuesta = JSON.parse(response);
                    // console.log(respuesta);
                    if(respuesta.informacion.length > 0){
                        $('#txtNombre').html(respuesta.informacion[0].nombre_largo);
                        $('#txtPuesto').html(respuesta.informacion[0].Puesto);
                        $('#txtCelula').html(respuesta.informacion[0].Departamento);
                        $('#txtJefe').html(respuesta.informacion[0].Jefe);
                        $('#txtEstado').html(respuesta.informacion[0].status);

                        $('#exampleRadios1').prop( "checked", false );
                        contenido_encuesta.removeClass('d-none');
                    } else {
                        contenido_encuesta.addClass('d-none');
                        $('#txtNombre').html('');
                        $('#txtPuesto').html('');
                        $('#txtCelula').html('');
                        $('#txtJefe').html('');
                        $('#txtEstado').html('');
                        Swal.fire({
                            icon: 'error',
                            title: 'Empleado no encontrado',
                            text: 'Favor de verificar el numero de nomina',
                            footer: '<p>Si necesita asistencia no dude en preguntar</p>'
                          })
                    }
                    
                }
        });
                
            });


            $('#exampleRadios1').click(function () {
                $('.opc_1_preg_1').removeClass('d-none');
                $('.opc_2_preg_1').addClass('d-none');
                $('.opc_3_preg_1').addClass('d-none');
                $('.opc_4_preg_1').addClass('d-none');
                $('.opc_5_preg_1').addClass('d-none');
                $('.opc_6_preg_1').addClass('d-none');
            });

            $('#exampleRadios2').click(function () {
                $('.opc_1_preg_1').addClass('d-none');
                $('.opc_2_preg_1').removeClass('d-none');
                $('.opc_3_preg_1').addClass('d-none');
                $('.opc_4_preg_1').addClass('d-none');
                $('.opc_5_preg_1').addClass('d-none');
                $('.opc_6_preg_1').addClass('d-none');
            });

            $('#exampleRadios3').click(function () {
                $('.opc_1_preg_1').addClass('d-none');
                $('.opc_2_preg_1').addClass('d-none');
                $('.opc_3_preg_1').removeClass('d-none');
                $('.opc_4_preg_1').addClass('d-none');
                $('.opc_5_preg_1').addClass('d-none');
                $('.opc_6_preg_1').addClass('d-none');
            });

            $('#exampleRadios4').click(function () {
                $('.opc_1_preg_1').addClass('d-none');
                $('.opc_2_preg_1').addClass('d-none');
                $('.opc_3_preg_1').addClass('d-none');
                $('.opc_4_preg_1').removeClass('d-none');
                $('.opc_5_preg_1').addClass('d-none');
                $('.opc_6_preg_1').addClass('d-none');
            });

            $('#exampleRadios5').click(function () {
                $('.opc_1_preg_1').addClass('d-none');
                $('.opc_2_preg_1').addClass('d-none');
                $('.opc_3_preg_1').addClass('d-none');
                $('.opc_4_preg_1').addClass('d-none');
                $('.opc_5_preg_1').removeClass('d-none');
                $('.opc_6_preg_1').addClass('d-none');
            });
            
            $('#exampleRadios6').click(function () {
                $('.opc_1_preg_1').addClass('d-none');
                $('.opc_2_preg_1').addClass('d-none');
                $('.opc_3_preg_1').addClass('d-none');
                $('.opc_4_preg_1').addClass('d-none');
                $('.opc_5_preg_1').addClass('d-none');
                $('.opc_6_preg_1').removeClass('d-none');
            });

            $('#p7opc1').click(function () {
                $('.opc_1_preg_7').removeClass('d-none');
            });

            $('#p7opc2').click(function () {
                $('.opc_1_preg_7').addClass('d-none');
            });

            btnguardarENC.click(function () {
                var nomina_encuestado = $('#numero_nomina').val(),
                    R1 = $('input[name=r_pregunta_1]:checked').val(),
                    SR1 = '',
                    R2_1 = $('#pregunta2_r1').val(),
                    R2_2 = $('#pregunta2_r2').val(),
                    R2_3 = $('#pregunta2_r3').val(),
                    R2_4 = $('#pregunta2_r4').val(),
                    R2_5 = $('#pregunta2_r5').val(),
                    R2_6 = $('#pregunta2_r6').val(),
                    R2_7 = $('#pregunta2_r7').val(),
                    R2_8 = $('#pregunta2_r8').val(),
                    R2_9 = $('#pregunta2_r9').val(),
                    R2_10 = $('#pregunta2_r10').val(),
                    R2_11 = $('#pregunta2_r11').val(),
                    R3 = $('#r_pregunta_3').val(),
                    R4 = $('#r_pregunta_4').val(),
                    R5 = $('input[name=r_pregunta_5]:checked').val(),
                    R6 = $('#r_pregunta_6').val(),
                    R7 = $('input[name=r_pregunta_7]:checked').val(),
                    SR7 = $('#sr_pregunta_7').val(),
                    R8 = $('input[name=r_pregunta_8]:checked').val(),
                    SR8 = $('#sr_pregunta_8').val(),
                    R9 = $('#r_pregunta_9').val(),
                    R10 = $('input[name=r_pregunta_10]:checked').val(),
                    SR10 = $('#sr_pregunta_10').val(),
                    enc_telefono = $('#r_telefono').val();

                if(R1 !== 'Otro'){
                    SR1 = $('input[name=sr_pregunta_1]:checked').val();
                } else {
                    SR1 = $('#sr_pregunta_1').val();
                }

                if(enc_telefono === ''){
                    Swal.fire({
                        icon: 'error',
                        title: 'Ingresar número de telfono',
                        text: 'Favor de ingresar número de telfono',
                        footer: '<p>Si necesita asistencia no dude en preguntar</p>'
                      })
                    $('#r_telefono').css("border", "1px solid red");
                    $('#r_telefono').focus();
                } else {

                    $.ajax({
                        type: 'POST',
                        url: backendURL,
                        data: { action: 'guardarEncuesta', 
                                R1: R1, 
                                SR1: SR1, 
                                R2_1: R2_1, 
                                R2_2: R2_2, 
                                R2_3: R2_3, 
                                R2_4: R2_4, 
                                R2_5: R2_5, 
                                R2_6: R2_6, 
                                R2_7: R2_7, 
                                R2_8: R2_8, 
                                R2_9: R2_9, 
                                R2_10: R2_10, 
                                R2_11: R2_11, 
                                R3: R3, 
                                R4: R4, 
                                R5: R5, 
                                R6: R6, 
                                R7: R7, 
                                SR7: SR7, 
                                R8: R8, 
                                SR8: SR8, 
                                R9: R9, 
                                R10: R10, 
                                SR10: SR10,
                                enc_telefono: enc_telefono,
                                nomina_encuestado: nomina_encuestado
                            },
                        success: function (response) {
                            let respuesta = JSON.parse(response);
                            Swal.fire({
                                icon: 'success',
                                title: 'Gracias por responder',
                                text: 'Encuesta realizada con exito',
                                footer: '<p>.</p>'
                              })
                            
                            setTimeout(function () {
                                location.reload();
                            }, 3500);
                            
                        }
                    });
                }


                
            });


            
        break;
        default:
            console.log('Seccion ' + seccionActual);
            cleanLocal();
            break;
    }

    function cleanLocal() {
        localStorage.clear();
    }

});

