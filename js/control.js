//GENERAL
$( document ).ready(function() {

    // VALUE OF THE ACTUAL SECTION
    let searchParams = new URLSearchParams(window.location.search)
    let seccionActual = searchParams.get('request');
    console.log('Seccion ' + seccionActual);

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
                                location.reload();
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
            $('#seccionTitulo').text(titulo);
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
                var row = $("<tr class='" + estado + "'>");
                
                $("#dataTable").append(row); //this will append tr element to table... keep its reference for a while since we will add cels into it id_empleado
                // NUMERO DE EQUIPO
                row.append($("<td class='text-muted d-none'>" + rowInfo.id_empleado + " </td>"));
                row.append($("<td class='text-muted trCode'>" + rowInfo.numero_nomina + " </td>"));
                // NOMINA DEL EMPLEADO
                row.append($("<td class='text-uppercase'> " + rowInfo.nombre_largo + " </td>"));
                row.append($("<td> " + rowInfo.fechaAlta + " </td>"));
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
            console.log('secion empleado');
            //GET VALUE FROM LS
            var codigoEmpleado = localStorage.getItem('codigoEmpleado'),
                action = 'mostrar-empleado';
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
            odometerOptions = { auto: false }; // Disables auto-initialization
            var action = 'highlights',
                totalEmpleados = $("#txtEmpleados"),
                totalEmpleadosA = $("#txtEmpleadosA"),
                totalEmpleadosO = $("#txtEmpleadosO"),
                totalEmpleadosN = $("#txtEmpleadosN"),
                totalSucursales = $("#txtSucursales");
            //REMOVE VALUE FROM LS
            localStorage.removeItem('codigoEmpleado');
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
        default:
            $( ".seccionBuscar" ).hide();
            break;
    }
    
});

