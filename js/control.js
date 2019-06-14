//GENERAL
$( document ).ready(function() {  

    // VALUE OF THE ACTUAL SECTION
    let searchParams = new URLSearchParams(window.location.search)
    let seccionActual = searchParams.get('request');

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
        xmlhr.open('POST', 'http://187.188.159.205:8090/web_serv/empService/controller.php', true);
            xmlhr.onload = function()
            {
            if (this.status === 200) {
              var respuesta = JSON.parse(xmlhr.responseText);
            //   console.log(respuesta);
              if (respuesta.estado === 'OK') {
                var informacion = respuesta.informacion,
                    datos = respuesta.informacion.length;
                // console.log(informacion.length);
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

    //CONTADOR
    $('.card').one('inview', function(event, visible) {
		if (visible == true) {
			$('.count').each(function() {
				$(this).prop('Counter', 0).animate({
					Counter: $(this).text()
				}, {
					duration: 5000,
					easing: 'swing',
					step: function(now) {
						$(this).text(Math.ceil(now));
					}
				});
			});
		}
	});


    /**CERRAR SESION */
    $('.btnSalir').click(function(){
        localStorage.removeItem('codigoEmpleado');
        cerrarSesion();
        // console.log('Salir');
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

    switch (seccionActual)
    {
        /**CARGAR TABLA EMPLEADOS */
        case 'empleado': case 'bajas':
            $( ".seccionBuscar" ).show();
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
            xmlhr.open('POST', 'http://187.188.159.205:8090/web_serv/empService/controller.php', true);
            xmlhr.onload = function(){
                if (this.status === 200) {
                var respuesta = JSON.parse(xmlhr.responseText);
                // console.log(respuesta);
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
                row.append($("<td class='d-none'>" + rowInfo.id_empleado + " </td>"));
                row.append($("<td class='trCode'>" + rowInfo.numero_nomina + " </td>"));
                // NOMINA DEL EMPLEADO
                row.append($("<td class='text-uppercase'> " + rowInfo.nombre_largo + " </td>"));
                row.append($("<td> " + rowInfo.fechaAlta + " </td>"));
                if(st === 'B'){
                    row.append($("<td> " + rowInfo.fechaBaja + " </td>"));
                }
                row.append($("<td> " + rowInfo.Sucursal + " </td>"));
                row.append($("<td> " + rowInfo.Celula + " </td>"));
                row.append($("<td> " + status + " </td>"));
                // COLUMNA ACCION
                row.append($("<td class='text-center'>"
                            + "<a class='btn btn-info btnConsulta text-white btn-sm' data-id='"+rowInfo.numero_nomina+"' role='button' title='Ver información'><i class='fas fa-info-circle'></i></a>"
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
        case 'datos':
            $( ".seccionBuscar" ).hide();
            console.log('Seccion empleado');
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
            xmlhr.open('POST', 'http://187.188.159.205:8090/web_serv/empService/controller.php', true);
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
                $('#txtNomina').text(rowInfo.numero_nomina);
                $('#txtNombre').text(rowInfo.nombre_largo); 
                $('#txtPuesto').text(rowInfo.Puesto);
                $('#txtSucursal').text(rowInfo.Sucursal);
                $('#txtDepartamento').text(rowInfo.Departamento);
                $('#txtCelula').text(rowInfo.Celula);
            }
            break;
        case 'main': 
            $( ".seccionBuscar" ).hide();
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
            xmlhr.open('POST', 'http://187.188.159.205:8090/web_serv/empService/controller.php', true);
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
            $( ".seccionBuscar" ).hide();
            var action  = 'lista-direcciones';
            var prop = (seccionActual === 'empleado' ? 'activos' : 'bajas');
            var titulo = 'Direcciones del personal';
            $('.seccionTitulo').text(titulo);
            var dataTable = new FormData();
            dataTable.append('action', action);
            // dataTable.append('prop', prop);
            var xmlhr = new XMLHttpRequest();
            xmlhr.open('POST', 'http://187.188.159.205:8090/web_serv/empService/controller.php', true);
            xmlhr.onload = function(){
                if (this.status === 200) {
                var respuesta = JSON.parse(xmlhr.responseText);
                // console.log(respuesta);
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
                row.append($("<td class='d-none'>" + rowInfo.id_empleado + " </td>"));
                row.append($("<td class='trCode'>" + rowInfo.numero_nomina + " </td>"));
                // NOMINA DEL EMPLEADO
                row.append($("<td class='text-uppercase'> " + rowInfo.nombre_largo + " </td>"));
                row.append($("<td> " + rowInfo.fechaAlta + " </td>"));
                row.append($("<td> " + rowInfo.estado + " </td>"));
                row.append($("<td> " + rowInfo.poblacion + " </td>"));
                row.append($("<td> " + rowInfo.codigopostal + " </td>"));
                row.append($("<td> " + rowInfo.direccion + " </td>"));
                // COLUMNA ACCION
                row.append($("<td class='text-center'>"
                            + "<a class='btn btn-info btnConsulta text-white btn-sm' data-id='"+rowInfo.numero_nomina+"' role='button' title='Ver información'><i class='fas fa-info-circle'></i></a>"
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
        case 'alta-empleado':
            $( ".seccionBuscar" ).hide();
            var botonValidar = $("#btnValidar"),
                vcurp = $(".validaCurp"),
                altaEmpleado = $(".altaEmpleado"),
                txtSucursal = $("#txtSucursal"),
                txtNomina = $("#txtNomina"),
                txtCelula = $("#txtCelula"),
                txtPuesto = $("#txtPuesto"),
                txtCURP = $("#txtCURP"),
                txtFraccionamiento = $("#txtFraccionamiento"),
                ccurp = $("#campo-curp"),
                entidad = '',
                genero = '';
            botonValidar.hide();
            altaEmpleado.hide();

            //VALIDAR SI LA CURP TIENE 18 CARACTERES HABILITA BOTON DE ENVIO
            ccurp.keyup(function(e){
                if(ccurp.val().length === 18){
                    textocurp = $("#campo-curp").val();
                    botonValidar.show();
                    txtCURP.val(textocurp);
                    genero = textocurp.charAt(10);

                    $("#txtGenero").val(genero);

                    
                    var url = 'inc/model/entidades.json',
                        entidad = textocurp.substr(11, 2);

                    $.getJSON(url, function (data) {
                        var clave = '';
                        for(var e in data.entidades){
                            clave = data.entidades[e].clave;
                            if (clave === entidad){
                                console.log(data.entidades[e].nombre);
                            }
                        }
                    });

                } else if (ccurp.val().length < 18 || e.keyCode == 46) {
                    botonValidar.hide();
                }
            });

            botonValidar.on("click", function(e){
                e.preventDefault();
                vcurp.hide();
                altaEmpleado.show();
            });

            //LLENAR SUCURSALES
            var listaSUC = new FormData(),
                action = 'buscarSucursal';
            listaSUC.append('action', action);
            var xmlSUC = new XMLHttpRequest();
            xmlSUC.open('POST', 'http://187.188.159.205:8090/web_serv/empService/controller.php', true);
            xmlSUC.onload = function(){
                if (this.status === 200) {
                var respuesta = JSON.parse(xmlSUC.responseText);
                if (respuesta.estado === 'OK') {
                    var informacion = respuesta.informacion;
                    var s = '<option value="-1" selected>Seleccionar una Sucursal</option>'; 
                    for(var i in informacion){
                        s += '<option value="'+ informacion[i].id_sucursal +'">' + informacion[i].nombre + '</option>';
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
            xmlNOM.open('POST', 'http://187.188.159.205:8090/web_serv/empService/controller.php', true);
            xmlNOM.onload = function(){
                if (this.status === 200) {
                var respuesta = JSON.parse(xmlNOM.responseText);
                // console.log(respuesta);
                if (respuesta.estado === 'OK') {
                    var informacion = respuesta.informacion;
                    var s = '<option value="-1">Seleccionar nomina</option>'; 
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

            //LLENAR CELULAS
            var listaCEL = new FormData(),
                action = 'buscarCelula';
            listaCEL.append('action', action);
            var xmlCEL = new XMLHttpRequest();
            xmlCEL.open('POST', 'http://187.188.159.205:8090/web_serv/empService/controller.php', true);
            xmlCEL.onload = function(){
                if (this.status === 200) {
                var respuesta = JSON.parse(xmlCEL.responseText);
                if (respuesta.estado === 'OK') {
                    var informacion = respuesta.informacion;
                    var s = '<option value="-1">Seleccionar celula</option>'; 
                    for(var i in informacion){
                        s += '<option value="'+ informacion[i].id_celula +'">' + informacion[i].nombre + '</option>';
                    }     
                    txtCelula.html(s);
                } else if(respuesta.status === 'error'){
                    var informacion = respuesta.informacion;
                }
                }
                }
                xmlCEL.send(listaCEL);

            //LLENAR PUESTOS
            var listaP = new FormData(),
            action = 'buscarP';
            listaP.append('action', action);
            var xmlP = new XMLHttpRequest();
            xmlP.open('POST', 'http://187.188.159.205:8090/web_serv/empService/controller.php', true);
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
                            var colonias = data.colonias,
                                s= '';
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
                    console.log("El CP debe ser de 5 digitos");
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

            break;
        default:
            $( ".seccionBuscar" ).hide();
            console.log('Seccion ' + seccionActual); 
            cleanLocal();
            break;
    }

    function cleanLocal(){
        localStorage.clear();
    }
    
});

