//GENERAL
$( document ).ready(function() {  

    // VALUE OF THE ACTUAL SECTION
    let searchParams = new URLSearchParams(window.location.search)
    let seccionActual = searchParams.get('request');
    let seccionBuscar = $( ".seccionBuscar" );
    let seccionEnvioAltas = $('.seccionEnvioAltas');
    let backendURL = 'http://187.188.159.205:8090/web_serv/empService/controller.php';
    let localBackend = 'inc/model/control.php';
    let url_final = 'http://mexq.mx/';
    let url_dev = 'http://localhost/';

    $('#searchBox').keyup(function(event) {
        event.preventDefault();
        var code = (event.keyCode ? event.keyCode : event.which);
        if(code==13)event.preventDefault();
        if(code==32||code==13||code==188||code==186){
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
            xmlhr.onload = function()
            {
            if (this.status === 200) {
                var respuesta = JSON.parse(xmlhr.responseText);
              if (respuesta.estado === 'OK') {
                var informacion = respuesta.informacion,
                    datos = respuesta.informacion.length;
                if(datos < 1){
                    $('#alertaM').removeClass('d-none');
                } else {
                    for(var i in informacion){
                        tablaEmpleados(informacion[i]);
                        $('#alertaM').addClass('d-none');
                        // $('#avisoR').hide();
                    }  
                } 

              } else if(respuesta.estado === 'NOK'){
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
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });

    //VACIAR TABLA DE DATOS
    let limpiarTabla = () => {
        $('#dataTable').empty();
    }

    /**EXPORTAR A EXCEL */
    $('.exportTable').click(function(){
        $(".table").table2excel({
            containerid: ".table", 
            datatype: 'table',
            name: "report",
            filename: "Reporte " + seccionActual, // Here, you can assign exported file name
            fileext: ".xls"
        }); 
    });  

    /***BUSQUEDAD DE TEXTO GENERICA */
    $(document).ready(function(){
        $(".searchBox").on("keyup", function() {
          var value = $(this).val().toLowerCase();
          $("#dataTable tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
          });
        });
      });
    
    
    /**CERRAR SESION */
    $('.btnSalir').click(function(){
        localStorage.removeItem('codigoEmpleado');
        cerrarSesion();
    });

    function cerrarSesion(){
        // console.log('Cerrar sesion');
        var action = 'salir';
        var cerrar_sesion = new FormData();
        cerrar_sesion.append('action', action);
        var xmlhr = new XMLHttpRequest();
        xmlhr.open( 'POST', 'inc/model/control.php', true );
        xmlhr.onload = function(){
            if (this.status === 200){
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
                            }).then(function(){ 
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

    $("#exportInfo").click(function(){
        var action  = 'json-empleados';
        var prop = (seccionActual === 'empleado' ? 'activos' : 'bajas');
        var encabezados = (seccionActual === 'empleado' ? ["NOMINA", "NOMBRE","PUESTO","FECHA ALTA","SUCURSAL","AREA","CELULA","ESTADO"] : ["NOMINA", "NOMBRE","PUESTO","FECHA ALTA","FECHA BAJA","SUCURSAL","AREA","CELULA","ESTADO"]);
        var titulo = (seccionActual === 'empleado' ? 'Empleados activos' : 'Empleados inactivos');
        $('.seccionTitulo').text(titulo);
        if(seccionActual === 'empleado'){
            $('.columna-baja').addClass('d-none');
        } else {
            $('.columna-baja').removeClass('d-none');
        }
        var dataTable = new FormData();
        dataTable.append('action', action);
        dataTable.append('prop', prop);
        var xmlhr = new XMLHttpRequest();
        xmlhr.open('POST', backendURL, true);
        xmlhr.onload = function(){
            if (this.status === 200) {
            var respuesta = JSON.parse(xmlhr.responseText);
            if (respuesta.estado === 'OK') {
                var informacion = respuesta.informacion;

                crearExcel(encabezados,informacion);
                    
            } else if(respuesta.status === 'error'){
                var informacion = respuesta.informacion;
            }
            }
            }
        xmlhr.send(dataTable);

        var createXLSLFormatObj = [];

        function crearExcel(encabezados, informacion){
            var xlsHeader = encabezados;
            var xlsRows = informacion;

            createXLSLFormatObj.push(xlsHeader);
            $.each(xlsRows, function(index, value) {
                var innerRowData = [];
                $("tbody").append('<tr><td>' + value.numero_nomina + '</td><td>' + value.Nombre + '</td><td>' + value.Puesto + '</td><td>' + '</td><td>' + value.fechaAlta + '</td><td>' + value.Sucursal + '</td><td>' + value.Celula + '</td><td>' + value.status + '</td></tr>');
                $.each(value, function(ind, val) {
                    innerRowData.push(val);
                });
                createXLSLFormatObj.push(innerRowData);
            });


            /* File Name */
            var filename = "reporte-empleados-"+prop+".xlsx";

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

    switch (seccionActual)
    {
        /**CARGAR TABLA EMPLEADOS */
        case 'empleado': case 'bajas':
            seccionBuscar.removeClass('d-none');
            var action  = 'lista-empleados';
            var prop = (seccionActual === 'empleado' ? 'activos' : 'bajas');
            var titulo = (seccionActual === 'empleado' ? 'Empleados activos' : 'Empleados inactivos');
            $('.seccionTitulo').text(titulo);
            if(seccionActual === 'empleado'){
                $('.columna-baja').addClass('d-none');
            } else {
                $('.columna-baja').removeClass('d-none');
            }
            var dataTable = new FormData();
            dataTable.append('action', action);
            dataTable.append('prop', prop);
            var xmlhr = new XMLHttpRequest();
            xmlhr.open('POST', backendURL, true);
            xmlhr.onload = function(){
                if (this.status === 200) {
                var respuesta = JSON.parse(xmlhr.responseText);
                if (respuesta.estado === 'OK') {
                    var informacion = respuesta.informacion;
                    for(var i in informacion){
                        tablaEmpleados(informacion[i]);
                    }     
                } else if(respuesta.status === 'error'){
                    var informacion = respuesta.informacion;
                }
                }
                }
            xmlhr.send(dataTable);

            function tablaEmpleados(rowInfo){
                var st = rowInfo.status,
                    status = 'Activo',
                    estado = '';
                
                $('#loadingIndicator').addClass('d-none');

                if(st === 'B'){
                    estado = "alert-secondary";
                    status = 'Baja';
                }
                if(st === 'R'){
                    estado = "text-secondary";
                    status = 'Re-ingreso';
                }
                var row = $("<tr class='" + estado + " text-secondary'>");
                
                $("#dataTable").append(row); //this will append tr element to table... keep its reference for a while since we will add cels into it id_empleado
                // NUMERO DE EQUIPO
                row.append($("<td class='trCode'>" + rowInfo.numero_nomina + " </td>"));
                // NOMINA DEL EMPLEADO
                row.append($("<td class='text-left'> " + rowInfo.Nombre + " </td>"));
                row.append($("<td class='text-left'> " + rowInfo.Puesto + " </td>"));
                row.append($("<td> " + rowInfo.fechaAlta + " </td>"));
                if(st === 'B'){
                    row.append($("<td> " + rowInfo.fechaBaja + " </td>"));
                }
                row.append($("<td> " + rowInfo.Sucursal + " </td>"));
                row.append($("<td> " + rowInfo.Celula + " </td>"));
                row.append($("<td> " + status + " </td>"));
                // COLUMNA ACCION
                row.append($("<td class='text-center'>"
                            + "<a class='btn btnConsulta text-white btn-facebook btn-circle btn-sm' data-id='"+rowInfo.numero_nomina+"' role='button' title='Ver información'><i class='fas fa-info'></i></a>"
                            + "</td>"));
        
                $(".btnConsulta").unbind().click(function() {
                    var employeeID = $((this)).data('id'),
                        url = "index.php?request=datos";
                        // newTab = window.open(url, '_blank');

                    //SAVE EMPLOYEE ID ON LOCAL STORAGE AS codigoEmpleado
                    localStorage.setItem('codigoEmpleado', employeeID);
                    console.log(employeeID);
                    
                    // OPEN ON CURRENT TAB
                    $(location).attr('href',url);

                    // OPEN ON NEW TAB
                    // newTab.focus();
                });        
            }
            break;
            case 'altas':
                let btnConsultarAltas = $('#btnConsultaAltas'),
                    btnEnviarAltas = $('#btnEnviarAltas');
                obtenerAltas();
                btnConsultarAltas.on('click',function(e){
                    e.preventDefault();
                    $('#dataTable').empty();
                    obtenerAltas();
                });
                function obtenerAltas(){
                    var action  = 'altas',
                        fecha = $('#txtFechaAltas').val();
                    var dataTable = new FormData();
                    dataTable.append('action', action);
                    dataTable.append('prop', fecha);
                    var xmlhr = new XMLHttpRequest();
                    xmlhr.open('POST', backendURL, true);
                    xmlhr.onload = function(){
                        if (this.status === 200) {
                        var respuesta = JSON.parse(xmlhr.responseText);
                        if (respuesta.estado === 'OK') {
                            var datos = respuesta.informacion.length;
                            var informacion = respuesta.informacion;
                            if(datos < 1)
                            {
                                $('#alertaM').removeClass('d-none');
                                seccionEnvioAltas.addClass('d-none');
                            } 
                            else 
                            {
                                $('#alertaM').addClass('d-none');
                                seccionEnvioAltas.removeClass('d-none');
                                for(var i in informacion){
                                    tablaAltas(informacion[i]);
                                }    
                            } 
                        } else if(respuesta.status === 'error'){
                            var informacion = respuesta.informacion;
                            $('#alertaM').removeClass('d-none');
                        }
                        }
                        }
                    xmlhr.send(dataTable);
        
                    function tablaAltas(rowInfo){
                        var row = $("<tr>");
                        
                        $("#dataTable").append(row); //this will append tr element to table... keep its reference for a while since we will add cels into it id_empleado
                        row.append($("<td class='trCode'>" + rowInfo.numero_nomina + " </td>"));
                        row.append($("<td class='text-left'> " + rowInfo.Nombre + " </td>"));
                        row.append($("<td class='text-left'> " + rowInfo.Puesto + " </td>"));
                        row.append($("<td> " + rowInfo.fechaAlta + " </td>"));
                        row.append($("<td> " + rowInfo.Sucursal + " </td>"));
                        row.append($("<td> " + rowInfo.Celula + " </td>"));
                    }
                }

            btnEnviarAltas.click(function(e){
                e.preventDefault();
                Swal.fire({
                    position: 'center',
                    type: 'success',
                    title: 'Informe de altas enviado a Nominas',
                    showConfirmButton: false,
                    timer: 1800
                  })
            });
            break;
        case 'datos':
            //GET VALUE FROM LS
            var codigoEmpleado = localStorage.getItem('codigoEmpleado'),
                emp_activo = document.querySelector('#emp_activo').value,
                sup_activo = document.querySelector('#sup_activo').value,
                action = 'mostrar-empleado';
            if (localStorage.getItem('codigoEmpleado') === null){
                codigoEmpleado = emp_activo;
            }
            //REMOVE VALUE FROM LS
            // localStorage.removeItem('codigoEmpleado');
            var dataEmp = new FormData();
            dataEmp.append('action', action);
            dataEmp.append('prop', codigoEmpleado);
            var xmlhr = new XMLHttpRequest();
            xmlhr.open('POST', backendURL, true);
            xmlhr.onload = function(){
                if (this.status === 200) {
                    var respuesta = JSON.parse(xmlhr.responseText);
                if (respuesta.estado === 'OK') {
                    var informacion = respuesta.informacion;
                    for(var i in informacion){
                        imprimirEmpleado(informacion[i]);
                    }     
                } else if(respuesta.status === 'error'){
                    var informacion = respuesta.informacion;
                }
                }
                }
            xmlhr.send(dataEmp);

            function imprimirEmpleado(rowInfo){
                var nomina = rowInfo.numero_nomina,
                    urlFoto = 'assets/files/' + nomina + '/' + nomina + '.jpg',
                    action = 'revisarImagen';
                $("#empImagen").attr('src',urlFoto);
                $('#txtNomina').text(rowInfo.numero_nomina);
                $('#txtNombre').text(rowInfo.nombre_largo); 
                $('#txtPuesto').text(rowInfo.Puesto);
                $('#txtSucursal').text(rowInfo.Sucursal);
                $('#txtDepartamento').text(rowInfo.Departamento);
                $('#txtCelula').text(rowInfo.Celula);
                

                $.ajax({
                    type: 'POST',
                    url: localBackend, 
                    data: { action: action, nomina : nomina },
                    success: function(response) {
                        var respuesta = JSON.parse(response);
                        if(respuesta.estado === 0)
                        {
                            $("#empImagen").attr('src','img/gafete/no-image.png'); 
                            $("#btnGafete").prop('disabled', true);
                            $("#lblImagen").hide();
                        }
                        else
                        {
                            $("#btnGafete").prop('disabled', false);
                            $("#lblImagen").show();
                        }
                    }
                });
            }

                    

            
            var archivoImagen = $("#txtFoto")[0].files.length;
            $("#txtFoto").on('click',function(){
                if(archivoImagen === 0){
                    $("#btnGafete").prop('disabled', false);
                } else {
                    $("#btnGafete").prop('disabled', true);
                }
            });

                        
            //GENERAR GAFETE
            $("#btnGafete").click(function(){
                var numero_nomina = $('#txtNomina').html(),
                    invoiceAttach = document.getElementById('txtFoto');
                    empFoto = invoiceAttach.files[0],
                    action = 'guardarFoto';


                var datosGafete = new FormData();
                    datosGafete.append('empNomina', numero_nomina);
                    datosGafete.append('empFoto', empFoto);
                    datosGafete.append('action', action);
                console.log(action + ' ' + numero_nomina);
                var xhr = new XMLHttpRequest();
                xhr.open('POST', backendURL , true);
                xhr.send(datosGafete);
                xhr.onload = function(){
                    if (this.status === 200) {
                        var respuesta = JSON.parse(xhr.responseText);
                        console.log(respuesta);
                        console.log('ok');
                    } else {
                        var respuesta = JSON.parse(xhr.responseText);
                        console.log(respuesta);
                        console.log('error');
                    }
                    }
                
                var url = backendURL + "empleados/gafete.php?emp=" + numero_nomina,
                newTab = window.open(url, '_blank');
                newTab.focus();
               
            });

            


            break;
        case 'main': 
            var action = 'highlights',
                totalEmpleados = $("#txtEmpleados"),
                totalEmpleadosA = $("#txtEmpleadosA"),
                totalEmpleadosO = $("#txtEmpleadosO"),
                totalEmpleadosN = $("#txtEmpleadosN"),
                totalSucursales = $("#txtSucursales");
            //REMOVE VALUE FROM LS
            // localStorage.removeItem('codigoEmpleado');
            var dataEmp = new FormData();
            dataEmp.append('action', action);
            var xmlhr = new XMLHttpRequest();
            xmlhr.open('POST', backendURL, true);
            xmlhr.onload = function(){
                if (this.status === 200) {
                var respuesta = JSON.parse(xmlhr.responseText);
                // console.log(respuesta);
                if (respuesta.estado === 'OK') {
                    var informacion = respuesta.informacion;
                    totalEmpleados.text(informacion[0].cifras);     
                    totalEmpleadosA.text(informacion[1].cifras);     
                    totalEmpleadosO.text(informacion[2].cifras);     
                    totalEmpleadosN.text(informacion[3].cifras);     
                    totalSucursales.text(informacion[4].cifras);     
                } else if(respuesta.status === 'error'){
                    var informacion = respuesta.informacion;
                }
                }
                }
            xmlhr.send(dataEmp);
            break;
        case 'direcciones':
            $('.toolsDH').removeClass('d-none');
            var action  = 'lista-direcciones';
            var prop = (seccionActual === 'empleado' ? 'activos' : 'bajas');
            var titulo = 'Direcciones del personal';
            $('.seccionTitulo').text(titulo);
            var dataTable = new FormData();
            dataTable.append('action', action);
            // dataTable.append('prop', prop);
            var xmlhr = new XMLHttpRequest();
            xmlhr.open('POST', backendURL, true);
            xmlhr.onload = function(){
                if (this.status === 200) {
                var respuesta = JSON.parse(xmlhr.responseText);
                if (respuesta.estado === 'OK') {
                    var informacion = respuesta.informacion;
                    for(var i in informacion){
                        tablaDirecciones(informacion[i]);
                    }     
                } else if(respuesta.status === 'error'){
                    var informacion = respuesta.informacion;
                }
                }
                }
            xmlhr.send(dataTable);
              
            function tablaDirecciones(rowInfo){
        
                var st = rowInfo.status,
                    status = 'Activo',
                    estado = '';

                $('#loadingIndicator').addClass('d-none');
                
                if(st === 'B'){
                    estado = "alert-secondary";
                    status = 'Baja';
                }
                if(st === 'R'){
                    estado = "text-secondary";
                    status = 'Re-ingreso';
                }
                var row = $("<tr class='" + estado + " text-secondary'>");
                
                $("#dataTable").append(row); //this will append tr element to table... keep its reference for a while since we will add cels into it id_empleado
                row.append($("<td class='trCode'>" + rowInfo.numero_nomina + " </td>"));
                row.append($("<td class='text-uppercase'> " + rowInfo.nombre_largo + " </td>"));
                row.append($("<td> " + rowInfo.fechaAlta + " </td>"));
                row.append($("<td> " + rowInfo.estado + " </td>"));
                row.append($("<td> " + rowInfo.poblacion + " </td>"));
                row.append($("<td> " + rowInfo.codigopostal + " </td>"));
                row.append($("<td> " + rowInfo.direccion + " </td>"));
                
            }

                
            break;
        // CUMPLEAÑOS / ANTIGUEDAD
        case 'fecha1': case 'fecha2':
            var titulo = (seccionActual === 'fecha1' ? 'Fechas de cumpleaños' : 'Antigüedad del personal');
            var columna = (seccionActual === 'fecha1' ? 'Fecha Nacimiento' : 'Fecha Alta');
            var columna2 = (seccionActual === 'fecha1' ? 'Edad' : 'Antigüedad');
            let btnObtener = $("#btnObtener");

            $('.seccionTitulo').text(titulo);
            $('#colType').text(columna);
            $('#colKind').text(columna2);

            btnObtener.on('click',function(){
                var mes = $("#txtMes").val();
                if(mes != '0'){
                    obtenerFechas(mes);
                    $('#dataTable').empty();
                }
            });

            function obtenerFechas(mes){
                var action  = 'fecha';
                var prop = (seccionActual === 'fecha1' ? 'cumple' : 'antig');
                var dataTable = new FormData();
                dataTable.append('action', action);
                dataTable.append('prop', prop);
                dataTable.append('mes', mes);
                var xmlhr = new XMLHttpRequest();
                xmlhr.open('POST', backendURL, true);
                xmlhr.onload = function(){
                    if (this.status === 200) {
                    var respuesta = JSON.parse(xmlhr.responseText);
                    if (respuesta.estado === 'OK') {
                        var informacion = respuesta.informacion;
                        // console.log(respuesta);
                        for(var i in informacion){
                            tablaFechas(informacion[i]);
                        }     
                    } else if(respuesta.status === 'error'){
                        var informacion = respuesta.informacion;
                    }
                    }
                    }
                xmlhr.send(dataTable);
            }
              
            function tablaFechas(rowInfo){
        
                $('#loadingIndicator').addClass('d-none');
                $('.toolsDH').removeClass('d-none');
                
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
        case 'alta-empleado':
            var botonValidar = $("#btnValidar"),
                vcurp = $(".validaCurp"),
                altaEmpleado = $(".altaEmpleado"),
                txtSucursal = $("#txtSucursal"),
                txtClasificacion = $("#txtClasificacion"),
                txtNomina = $("#txtNomina"),
                txtCelula = $("#txtCelula"),
                txtPuesto = $("#txtPuesto"),
                txtJefe = $("#txtJefe"),
                txtCURP = $("#txtCURP"),
                txtTipo = $('#txtTipo'),
                txtFraccionamiento = $("#txtFraccionamiento"),
                sucursal = '',
                clasificacion = '',
                ccurp = $("#campo-curp"),
                genero = '';

            ccurp.focusout(function(){
                textocurp = $("#campo-curp").val();
                //ASIGNAR FECHA NACIMIENTO DESDE CURP
                    
                
            });

            //EVITAR ACCION AL PRESIONAR LA TECLA ENTER
            ccurp.keypress(function(event){
                if(event.keyCode == 13) return false;
            });
            
            //VALIDAR SI LA CURP TIENE 18 CARACTERES HABILITA BOTON DE ENVIO
            ccurp.keyup(function(e){
                if(ccurp.val().length === 18){
                    textocurp = $("#campo-curp").val();
                    botonValidar.removeClass('d-none');
                } else if (ccurp.val().length < 18 || e.keyCode == 46) {
                    botonValidar.addClass('d-none');
                }
            });

            //VALIDAR CURP
            botonValidar.on("click", function(e){
                e.preventDefault();
                txtCURP.val(textocurp);
                let action = 'validaCURP',
                    curp = txtCURP.val();
                // console.log(`${action} ${curp}`);
                $.ajax({
                    type: 'POST',
                    url: backendURL, 
                    data: { action: action, curp : curp },
                    success: function(response) {
                        var respuesta = JSON.parse(response);
                        if(respuesta.informacion.length === 0){
                            vcurp.addClass('d-none');
                            camposClave();
                            obtenerNomina();
                            txtTipo.val('Alta');
                            altaEmpleado.removeClass('d-none'); 
                        }else{
                            txtTipo.val('Re-ingreso');
                            Swal.fire({
                                title: 'Aviso',
                                text: 'La persona ya existe en la Base de datos!',
                                type: 'info'
                            })
                            .then(resultado => {
                                    if(resultado.value) {
                                        location.reload();
                                    }
                                })
                        }
                    }
                });

            });

            //LLENAR CAMPOS CLAVE SI NO EXISTE EN LA BD
            let camposClave = () =>
            {
                genero = textocurp.charAt(10);
                $("#txtGenero").val(genero);
                var aNacimiento = textocurp.substr(4, 2),
                mNacimiento = textocurp.substr(6, 2),
                dNacimiento = textocurp.substr(8, 2);
                var now = new Date(aNacimiento,mNacimiento-1,dNacimiento);
                var nyear = now.getFullYear();
                
                var fNacimiento = nyear + '-' + mNacimiento + '-' + dNacimiento;

                $("#txtfechaNacimiento").val(fNacimiento);

                //ASIGNAR ENTIDAD DE NACIMIENTO DESDE CURP
                var url = 'inc/model/entidades.json',
                    entidad = textocurp.substr(11, 2);
                $.getJSON(url, function (data) {
                    var clave = '';
                    for(var e in data.entidades){
                        clave = data.entidades[e].clave;
                        if (clave === entidad){
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
                    success: function(response) {
                        var respuesta = JSON.parse(response);
                        if(respuesta.informacion.length === 1){
                            numeroNomina = respuesta.informacion[0].numeroNomina;
                            txtNomina.val(numeroNomina+1);
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
            xmlSUC.onload = function(){
                if (this.status === 200) {
                var respuesta = JSON.parse(xmlSUC.responseText);
                if (respuesta.estado === 'OK') {
                    var informacion = respuesta.informacion;
                    var s = '<option value="" selected>Seleccionar una Sucursal</option>'; 
                    for(var i in informacion){
                        s += '<option value="'+ informacion[i].id_sucursal +'">' + informacion[i].codigo.substr(0, 5) + ' - ' + informacion[i].nombre + '</option>';
                    }     
                    txtSucursal.html(s);
                } else if(respuesta.status === 'error'){
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
            xmlNOM.onload = function(){
                if (this.status === 200) {
                var respuesta = JSON.parse(xmlNOM.responseText);
                // console.log(respuesta);
                if (respuesta.estado === 'OK') {
                    var informacion = respuesta.informacion;
                    var s = '<option value="">Seleccionar nomina</option>'; 
                    for(var i in informacion){
                        s += '<option value="'+ informacion[i].code_value +'">' + informacion[i].code_value_desc + '</option>';
                    }     
                    txtNomina.html(s);
                } else if(respuesta.status === 'error'){
                    var informacion = respuesta.informacion;
                }
                }
                }
            xmlNOM.send(listaNOM);

            txtClasificacion.focusout(function(){
                clasificacion = $(this).val();
                llenarCelulas();
            });

            txtSucursal.focusout(function(){
                sucursal = $(this).val();
            });

            function llenarCelulas(){
                //LLENAR CELULAS
                var listaCEL = new FormData(),
                    action = 'buscarCelula';
                listaCEL.append('action', action);
                listaCEL.append('sucursal', sucursal);
                listaCEL.append('clasificacion', clasificacion);
                var xmlCEL = new XMLHttpRequest();
                xmlCEL.open('POST', backendURL, true);
                xmlCEL.onload = function(){
                    if (this.status === 200) {
                    var respuesta = JSON.parse(xmlCEL.responseText);
                    // console.log(respuesta);
                    if (respuesta.estado === 'OK') {
                        var informacion = respuesta.informacion;
                        var s = '<option value="">Seleccionar celula</option>'; 
                        for(var i in informacion){
                            s += '<option value="'+ informacion[i].id_celula +'">' + informacion[i].codigo + ' - ' + informacion[i].nombre + '</option>';
                        }     
                        txtCelula.html(s);
                    } else if(respuesta.status === 'error'){
                        var informacion = respuesta.informacion;
                    }
                    }
                    }
                    xmlCEL.send(listaCEL);
            }

            //LLENAR PUESTOS POR CELULA SELECCIONADA
            $('#txtCelula').focusout(function(){
                var listaP = new FormData(),
                    action = 'buscarP',
                    paramCel =  $('#txtCelula option:selected').val();
                listaP.append('action', action);
                listaP.append('param', paramCel);
                listaP.append('clasificacion', clasificacion);
                var xmlP = new XMLHttpRequest();
                xmlP.open('POST', backendURL, true);
                xmlP.onload = function(){
                if (this.status === 200) {
                var respuesta = JSON.parse(xmlP.responseText);
                if (respuesta.estado === 'OK') {
                    var informacion = respuesta.informacion;
                    var s = '<option value="-1">Seleccionar tipo de puesto</option>'; 
                    for(var i in informacion){
                        s += '<option value="'+ informacion[i].id_puesto +'">' + informacion[i].nombre + '</option>';
                    }     
                    txtPuesto.html(s);
                } else if(respuesta.status === 'error'){
                    var informacion = respuesta.informacion;
                }
                }
                }
                xmlP.send(listaP);
            });


            //LLENAR JEFE DIRECTO POR NIVEL DE PUESTO SELECCIONADO
            $('#txtPuesto').focusout(function(){
                var listaJefe = new FormData(),
                    action = 'buscarJefe',
                    paramPuesto =  $('#txtPuesto option:selected').val(),
                    paramCel =  $('#txtCelula option:selected').val();
                console.log(`${paramCel} ${paramPuesto}`);
                listaJefe.append('action', action);
                listaJefe.append('param', paramPuesto);
                listaJefe.append('param2', paramCel);
                var xmlJefe = new XMLHttpRequest();
                xmlJefe.open('POST', backendURL, true);
                xmlJefe.onload = function(){
                if (this.status === 200) {
                var respuesta = JSON.parse(xmlJefe.responseText);
                if (respuesta.estado === 'OK') {
                    var informacion = respuesta.informacion;
                    var s = '<option value="-1">Seleccionar jefe directo</option>'; 
                    for(var i in informacion){
                        s += '<option class="text-uppercase" value="'+ informacion[i].numero_nomina +'">' + informacion[i].numero_nomina + ' - ' + informacion[i].nombre_largo + '</option>';
                    }     
                    txtJefe.html(s);
                } else if(respuesta.status === 'error'){
                    var informacion = respuesta.informacion;
                }
                }
                }
                xmlJefe.send(listaJefe);
            });

            //CONTROL CODIGO POSTAL
            $("#txtCP").focusout(function(){
                var cp = $('#txtCP').val();
                if(cp.length === 5){
                    $.ajax({
                        type:"GET",
                        url: "https://api-codigos-postales.herokuapp.com/v2/codigo_postal/"+cp,
                        success: function(data){
                            $("#txtEdo").val(data.estado);
                            $("#txtMunicipio").val(data.municipio);
                            $("#txtLocalidad").val(data.municipio);
                            var colonias = data.colonias,
                                s = '';
                            for(var i in colonias){
                                s += '<option value="'+ colonias[i] +'">' + colonias[i] + '</option>';
                            }
                            txtFraccionamiento.html(s);
                        },
                        error: function(jqXHR, textStatus, errorThrown){
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
            });

            $("#txtPaterno").focusout(function(){
                var ap = $("#txtPaterno").val();
                $("#txtAPp").val(ap);
            });

            $("#txtMaterno").focusout(function(){
                var ap = $("#txtMaterno").val();
                $("#txtAPm").val(ap);
            });
            //VALIDAR NUMERO INFONAVIT
            $("#txtInfonavit").change(function(){
                var infonavit = $("#txtInfonavit").val();
                if(infonavit === 'NO'){
                    $("#txtNinfonavit").attr('disabled','disabled');
                    $("#txtNinfonavit").val('NA');
                } else {
                    $("#txtNinfonavit").removeAttr('disabled','disabled');
                    $("#txtNinfonavit").val('Retenido');
                }
            });

            //VALIDAR NUMERO FONACOT
            $("#txtFonacot").change(function(){
                var infonavit = $("#txtFonacot").val();
                if(infonavit === 'NO'){
                    $("#txtNfonacot").attr('disabled','disabled');
                    $("#txtNfonacot").val('NA');
                } else {
                    $("#txtNfonacot").removeAttr('disabled','disabled');
                    $("#txtNfonacot").val('Retenido');
                }
            });

            //VALIDAR NUMERO CUENTA BANCO
            $("#txtBanco").change(function(){
                var infonavit = $("#txtBanco").val();
                if(infonavit === 'NO'){
                    $("#txtCuenta").attr('disabled','disabled');
                    $("#txtCuenta").val('NA');
                } else {
                    $("#txtCuenta").removeAttr('disabled','disabled');
                    $("#txtCuenta").val('Retenido');
                }
            });

            // DESHABILITAR CAMPOS
            function lockFields(){
                if  ($("#txtGenerp").val().trim() === 0) $("#txtGenero").attr('disabled','disabled');

            }

            let btnGuardarEmpleado = $('#btnGuardarEmpleado');

            //BOTON GUARDAR EMPLEADO
            btnGuardarEmpleado.on('click',function(e){
                e.preventDefault();
                let nomina = $('#txtNomina').val(),
                    tipoNomina = $('#txtTipoNomina').val(),
                    tipo = $('#txtTipo').val(),
                    sucursal = $('#txtSucursal').val(),
                    clasificacion = $('#txtClasificacion').val(),
                    categoria = $('#txtCategoria').val(),
                    celula = $('#txtCelula').val(),
                    fechaAlta = $('#txtfechaAlta').val(),
                    registro = $('#txtRegistro').val(),
                    puesto = $('#txtPuesto').val(),
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
                    nPadre = $('#txtNombre').val(),
                    nMadre = $('#txtNombre').val(),
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

                if
                (
                    categoria.trim() === '' || celula.trim() === '' || 
                    registro.trim() === '' || puesto.trim() === '' ||
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
                )
                {
                    Swal.fire({
                        position: 'center',
                        type: 'warning',
                        title: 'Debe llenar todos los datos',
                        showConfirmButton: false,
                        timer: 1000
                      })
                }
                else
                {
                    var nombreLargo = `${aPaterno} ${aMaterno} ${nombre}`;
                    $.ajax({
                        type: 'POST',
                        url: backendURL, 
                        data: { action: 'guardarEmpleado',
                                nomina: nomina,
                                tipoNomina: tipoNomina,
                                tipo: tipo,
                                sucursal : sucursal,
                                clasificacion : clasificacion,
                                categoria : categoria,
                                celula : celula,
                                fechaAlta : fechaAlta,
                                registro : registro,
                                puesto : puesto,
                                nombre : nombre,
                                aPaterno : aPaterno,
                                aMaterno : aMaterno,
                                nombreLargo : nombreLargo,
                                curpini : curpini,
                                curpfin : curpfin,
                                rfcini : rfcini,
                                rfcfin: rfcfin,
                                nss : nss,
                                dv : dv,
                                fechaNacimiento : fechaNacimiento,
                                lNacimiento : lNacimiento,
                                genero : genero,
                                tIdentificacion : tIdentificacion,
                                id : id,
                                eCivil : eCivil,
                                escolaridad : escolaridad,
                                cEscolaridad : cEscolaridad,
                                nPadre : nPadre,
                                nMadre : nMadre,
                                calle : calle,
                                numE : numE,
                                numI : numI,
                                cp : cp,
                                edo : edo,
                                municipio : municipio,
                                localidad : localidad,
                                fraccionamiento : fraccionamiento,
                                domicilio: domicilio,
                                infonavit : infonavit,
                                nInfonavit : nInfonavit,
                                fonacot : fonacot,
                                nFonacot : nFonacot,
                                banco : banco,
                                cuenta : cuenta,
                                correo : correo,
                                telefono : telefono,
                                celular : celular,
                                contacto : contacto,
                                nContacto : nContacto
                             },
                        success: function(response) {
                            var respuesta = JSON.parse(response);
                            console.log(respuesta);
                            if(respuesta.estado === 'OK'){
                                Swal.fire({
                                    title: 'Correcto',
                                    text: 'Guardado exitoso!',
                                    type: 'success'
                                })
                                .then(resultado => {
                                        if(resultado.value) {
                                            location.reload();
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
                                        if(resultado.value) {
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
            let btnNuevo = $('#btnnPuesto'),
                panelNuevo = $('#nuevo-puesto'),
                btnCancelar = $('#btnCancelar'),
                form_nPuesto = $('#form_nPuesto'),
                btnGuardarPuesto = $('#btnGuardarPuesto'),
                btnEditarPuesto = $('#btnEditarPuesto'),
                txtPuestoL = $('#txttPuesto'),
                txtCelulaL = $('#txtnDepartamento');

            btnNuevo.on('click',function(){
                // limpiarCampos();
                panelNuevo.removeClass('d-none');
                btnGuardarPuesto.removeClass('d-none');
                btnNuevo.addClass('d-none');
                btnEditarPuesto.addClass('d-none');
                llenarTipoPuesto();
                llenarDepartamento();
            });

            btnCancelar.on('click',function(){
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
                    success: function(response) {
                        let respuesta = JSON.parse(response);
                        let puestoTipo = respuesta.informacion,
                            campo = '';
                        for(var i in puestoTipo){
                            campo += '<option value="'+ puestoTipo[i].id_puesto +'">' + puestoTipo[i].nivel + ' - ' + puestoTipo[i].nombre + '</option>';
                        }
                        txtPuestoL.html(campo);
                    }
                });
            }

            let llenarDepartamento = () => {
                let action = 'obtenerDepartamento';
                $.ajax({
                    type: 'POST',
                    url: backendURL, 
                    data: { action: action },
                    success: function(response) {
                        let respuesta = JSON.parse(response);
                        let departamento = respuesta.informacion,
                            campo = '';
                        for(var i in departamento){
                            campo += '<option value="'+ departamento[i].id_celula +'">' + departamento[i].nombre + '</option>';
                        }
                        txtCelulaL.html(campo);
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
                    success: function(response) {
                        let respuesta = JSON.parse(response);
                        let puesto = respuesta.informacion;
                        for(var i in puesto){
                            $('#dataTable').append
                            ("<tr><td class='trCode'>" + puesto[i].codigo + " </td>" +
                            "<td>" + puesto[i].nombre + " </td>" + 
                            "<td>" + puesto[i].descripcion + " </td>" +
                            "<td>" + puesto[i].id_nivel + " </td>" +
                            "<td>" + puesto[i].created_at.date + " </td>" +
                            "<td>" + puesto[i].updated_at.date + " </td>" +
                            "<td>" + puesto[i].updated_by + " </td>" +
                            "<td><a class='btn btn-primary btnEditarRegistro text-white btn-block'"+
                            "data-codigo='" +puesto[i].codigo + "'" +
                            "data-id_nivel='" +puesto[i].id_nivel + "'" +
                            "data-nombre='" + puesto[i].nombre + "'" +
                            "data-departamento='" + puesto[i].id_celula + "'" +
                            "data-descripcion='" + puesto[i].descripcion + "'" +
                            "role='button' title='Editar Registro'><i class='fas fa-edit'></i></a> </td></tr>");
                        }
                        $(".btnEditarRegistro").click(function() {
                            llenarTipoPuesto();
                            llenarDepartamento();
                            btnGuardarPuesto.addClass('d-none');
                            $("html, body").animate({scrollTop: 0}, 500);
                            let codigoPuesto = $((this)).data('codigo'),
                                id_nivel = $((this)).data('id_nivel'),
                                departamento = $((this)).data('departamento'),
                                descripcion = $((this)).data('descripcion'),
                                nombre = $((this)).data('nombre');
                            btnNuevo.addClass('d-none');
                            btnEditarPuesto.removeClass('d-none');
                            panelNuevo.removeClass('d-none');
                            setTimeout(function() {
                                $("#txttPuesto").val(id_nivel).attr('selected', true);
                             }, 150);
                            $('#txtnPuesto').val(nombre);
                            setTimeout(function() {
                                if(departamento === 0)
                                    $("#txtnDepartamento").val(5).attr('selected', true);
                                else
                                    $("#txtnDepartamento").val(departamento).attr('selected', true);
                             }, 150);
                             $('#txtdPuesto').val(descripcion);
                        });
                          
                    }
                });
            }     


            llenarTablaPuestos();

            btnGuardarPuesto.on('click',function(e){
                e.preventDefault();
                let puestoNivel = $('#txttPuesto').val(),
                    puestoNombre = $('#txtnPuesto').val(),
                    puestoDepartamento = $('#txtnDepartamento').val(),
                    puestoDescripcion = $('#txtdPuesto').val();

                    if(puestoNombre.trim() === '' || puestoDescripcion.trim() === '')
                    {
                        Swal.fire({
                            position: 'center',
                            type: 'warning',
                            title: 'Debe llenar todos los datos',
                            showConfirmButton: false,
                            timer: 1000
                        })
                    } else {
                        Swal.fire({
                            position: 'center',
                            type: 'success',
                            title: 'Bien',
                            showConfirmButton: false,
                            timer: 1000
                          })
                    }
            });
            
        break;
        default:
            console.log('Seccion ' + seccionActual); 
            cleanLocal();
            break;
    }

    function cleanLocal(){
        localStorage.clear();
    }
    
});

