//GENERAL
$( document ).ready(function() {
    // $('#sidebarCollapse').on('click',function(){
    //     $('#sidebar').toggleClass('active');
    // });

    var seccionActual = $('#nombreSeccion').text();//VARIABLE DE DEPARTAMENTO DE TI
    console.log(seccionActual)

    /**EMPLEADOS */
    switch (seccionActual)
    {
        case 'empleado':
            console.log('Tabla de empleados');
            var action  = 'lista-empleados';
            var dataTable = new FormData();
            dataTable.append('action', action);
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
                    status = '',
                    estado = '';
                
                if(st === 'B'){
                    estado = "table-warning text-danger";
                    status = 'Activo';
                }
                var row = $("<tr class='" + estado + "'>");
                
                $("#dataTable").append(row); //this will append tr element to table... keep its reference for a while since we will add cels into it
                // NUMERO DE EQUIPO
                row.append($("<td class='text-muted trCode'>" + rowInfo.numero_nomina + " </td>"));
                // NOMINA DEL EMPLEADO
                row.append($("<td> " + rowInfo.nombre_largo + " </td>"));
                row.append($("<td> " + rowInfo.fecha_alta + " </td>"));
                row.append($("<td> " + rowInfo.nombre + " </td>"));
                // COLUMNA ACCION
                    row.append($("<td class='text-center'>"
                                + "<a tabindex='0' class='btn btn-sm btn-primary mx-1 btnEdit' data-code='"+rowInfo.id_correo+"' target='_blank' role='button' title='Editar registro'><i class='fas fa-pen-square'></i></a>"
                                + "<a tabindex='1' class='btn btn-sm btn-danger mx-1 btnDelete' role='button' title='Eliminar registro'><i class='fas fa-trash'></i></a>" 
                                + "</td>"));
        
                        
                $(".btnDelete").unbind().click(function() {
                    deleteComputer($(this));
                });
        
                $(".btnEdit").unbind().click(function() {
                    var deviceCode = $((this)).data('code'),
                        url = "index.php?request=editcomputer",
                        newTab = window.open(url, '_blank');
                    localStorage.setItem('deviceCode', deviceCode);//GUARADR CODIGO DEL EQUIPO EN LA MEMORIA LOCAL DEL NAVEGADOR
                    // $(location).attr('href',url);
                    newTab.focus();
                });
        
                $(".btnHelp").unbind().click(function() {
                    var deviceCode = $((this)).data('code'),
                        newTab = window.open('inc/templates/responsive.php?deviceCode='+deviceCode, '_blank');
                    newTab.focus();
                });
        
            }

            break;
        default:
            console.log('Tablero');
            break;
    }
});

