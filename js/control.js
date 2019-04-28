//GENERAL
$( document ).ready(function() {
    // $('#sidebarCollapse').on('click',function(){
    //     $('#sidebar').toggleClass('active');
    // });

    //BUSQUEDA DE INFORMACION
    $(document).ready(function(){
        $("#searchBox").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#dataTable tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });

    //TOGGLE BARSIDE
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
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


    // VALUE OF THE ACTUAL SECTION
    var seccionActual = $('#nombreSeccion').text();
    // console.log(seccionActual)

    switch (seccionActual)
    {
        /**CARGAR TABLA EMPLEADOS */
        case 'empleado': case 'bajas':
            console.log('Tabla de empleados');
            var action  = 'lista-empleados';
            var prop = (seccionActual === 'empleado' ? 'activos' : 'bajas');
            var dataTable = new FormData();
            dataTable.append('action', action);
            dataTable.append('prop', prop);
            var xmlhr = new XMLHttpRequest();
            xmlhr.open('POST', 'http://187.188.159.205:8090/web_serv/empService/controller.php', true);
            xmlhr.onload = function(){
                if (this.status === 200) {
                var respuesta = JSON.parse(xmlhr.responseText);
                console.log(respuesta);
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
                    estado = "table-warning text-danger";
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
                row.append($("<td> " + rowInfo.nombre + " </td>"));
                row.append($("<td> " + status + " </td>"));
                // COLUMNA ACCION
                    row.append($("<td class='text-center'>"
                                + "<a class='btn btn-sm btn-info btnConsulta' data-id='"+rowInfo.id_empleado+"' role='button' title='Ver información'><i class='fas fa-info-circle'></i></a>"
                                + "</td>"));
        
                        
                // $(".btnDelete").unbind().click(function() {
                //     deleteComputer($(this));
                // });
        
                $(".btnConsulta").unbind().click(function() {
                    var employeeID = $((this)).data('id'),
                        url = "index.php?request=datos";
                        // newTab = window.open(url, '_blank');

                    //SAVE EMPLOYEE ID ON LOCAL STORAGE AS codigoEmpleado
                    localStorage.setItem('codigoEmpleado', employeeID);
                    
                    // OPEN ON CURRENT TAB
                    $(location).attr('href',url);
                    
                    // OPEN ON NEW TAB
                    // newTab.focus();
                });
        
                // $(".btnHelp").unbind().click(function() {
                //     var deviceCode = $((this)).data('code'),
                //         newTab = window.open('inc/templates/responsive.php?deviceCode='+deviceCode, '_blank');
                //     newTab.focus();
                // });
        
            }
            break;
        case 'datos':
            //GET VALUE FROM LS
            var codigoEmpleado = localStorage.getItem('codigoEmpleado');
            //REMOVE VALUE FROM LS
            localStorage.removeItem('codigoEmpleado');
            console.log(codigoEmpleado);
        default:
            // console.log('Tablero');
            break;
    }
});

