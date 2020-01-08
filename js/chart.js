$( document ).ready(function() {


    // VALUE OF THE ACTUAL SECTION
    let searchParams = new URLSearchParams(window.location.search)
    let seccionActual = searchParams.get('request');
    let backendURL = 'http://187.188.159.205:8090/web_serv/empService/controller.php';
    var meses = [],
        empleados = [],
        empleadosB = [],
        empleados_activos = [],
        empleados_inactivos = [],
        nombre_sucursal = [],
        cantidad_sucursal = [];
    var Dmeses,Dempleados,Dempleados_activos,Dempleados_inactivos,Dnombre_sucursal,Dcantidad_sucursal;
    var bgColors = ['SteelBlue ','LimeGreen','SteelBlue','LimeGreen','SteelBlue ','LimeGreen','SteelBlue','LimeGreen','SteelBlue ','LimeGreen','SteelBlue','LimeGreen','SteelBlue ','LimeGreen','SteelBlue','LimeGreen'];
    var hoverbgColors = ['SkyBlue','PaleGreen','SkyBlue','PaleGreen','SkyBlue','PaleGreen','SkyBlue','PaleGreen','SkyBlue','PaleGreen','SkyBlue','PaleGreen','SkyBlue','PaleGreen','SkyBlue','PaleGreen'];

        obtenerEmpleados();
        obtenerEmpleadosB();
        obtenerEmpleadosAO();
        obtenerSucursales();

        function obtenerEmpleados(){
            var action = 'obtener-empleados-mes',
                props = 'altas';
            var consulta_parametros = new FormData();
            consulta_parametros.append('action', action);
            consulta_parametros.append('props', props);
            var xmlhr = new XMLHttpRequest();
            xmlhr.open('POST', backendURL, true);
                xmlhr.onload = function()
                {
                if (this.status === 200) {
                var respuesta = JSON.parse(xmlhr.responseText);
                if (respuesta.estado === 'OK') {
                    var informacion = respuesta.informacion;
                    obtenerDatos(informacion);
                } else if(respuesta.estado === 'NOK'){
                    var informacion = respuesta.informacion;
                }
                }
                }
                xmlhr.send(consulta_parametros);
        }

        function obtenerEmpleadosB(){
            var action = 'obtener-empleados-mes',
                props = 'bajas';
            var consulta_parametros = new FormData();
            consulta_parametros.append('action', action);
            consulta_parametros.append('props', props);
            var xmlhr = new XMLHttpRequest();
            xmlhr.open('POST', backendURL, true);
                xmlhr.onload = function()
                {
                if (this.status === 200) {
                var respuesta = JSON.parse(xmlhr.responseText);
                if (respuesta.estado === 'OK') {
                    var informacion = respuesta.informacion;
                    obtenerDatosB(informacion);
                } else if(respuesta.estado === 'NOK'){
                    var informacion = respuesta.informacion;
                }
                }
                }
                xmlhr.send(consulta_parametros);
        }

        function obtenerDatosB(params){
            for (var i = 0; i < params.length; i++) {
                empleadosB.push(params[i].contador);
            }
            localStorage.setItem('empleadosB', empleadosB);
        }

        DempleadosB = localStorage.getItem('empleadosB').split(',');

        function obtenerDatos(params){
            for (var i = 0; i < params.length; i++) {
                meses.push(params[i].nombre_mes);
                empleados.push(params[i].contador);
            }
            localStorage.setItem('meses', meses);
            localStorage.setItem('empleados', empleados);
        }

        Dmeses = localStorage.getItem('meses').split(',');
        Dempleados = localStorage.getItem('empleados').split(',');

        var datosAltas = {
            label: "Altas del mes",
            data: Dempleados,
            lineTension: 0,
            fill: false,
            borderColor: 'blue'
          };

          var datosBajas = {
            label: "Bajas del mes",
            data: DempleadosB,
            lineTension: 0,
            fill: false,
          borderColor: 'red',
          };

          var datosEmpleados = {
            labels: Dmeses,
            datasets: [datosAltas, datosBajas]
          };

        // Area Chart Example
        var ctx = document.getElementById("chartMensual");
        var myLineChart = new Chart(ctx, {
        type: 'line',
        data: 
            datosEmpleados
        ,
        options: {
            maintainAspectRatio: false,
            layout: {
            padding: {
                left: 10,
                right: 25,
                top: 25,
                bottom: 0
            }
            },
            scales: {
            xAxes: [{
                time: {
                unit: 'date'
                },
                gridLines: {
                display: false,
                drawBorder: false
                },
                ticks: {
                maxTicksLimit: 7
                }
            }],
            yAxes: [{
                ticks: {
                maxTicksLimit: 5,
                padding: 10,
                // Include a dollar sign in the ticks
                callback: function(value, index, values) {
                    return value;
                }
                },
                gridLines: {
                color: "rgb(234, 236, 244)",
                zeroLineColor: "rgb(234, 236, 244)",
                drawBorder: false,
                borderDash: [2],
                zeroLineBorderDash: [2]
                }
            }],
            },
            legend: {
            display: true
            },
            tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            titleMarginBottom: 10,
            titleFontColor: '#6e707e',
            titleFontSize: 14,
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            intersect: false,
            mode: 'index',
            caretPadding: 10,
            callbacks: {
                label: function(tooltipItem, chart) {
                var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                return datasetLabel + ": " + tooltipItem.yLabel;
                }
            }
            }
        }
        });


        //GRAFICA DE PIE
        Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = '#858796';

        function obtenerEmpleadosAO(){
            var action = 'obtener-datos-empleados';
            var consulta_parametros = new FormData();
            consulta_parametros.append('action', action);
            var xmlhr = new XMLHttpRequest();
            xmlhr.open('POST', backendURL, true);
                xmlhr.onload = function()
                {
                if (this.status === 200) {
                var respuesta = JSON.parse(xmlhr.responseText);
                if (respuesta.estado === 'OK') {
                    var informacion = respuesta.informacion;
                    datosEmpleadosAO(informacion);
                } else if(respuesta.estado === 'NOK'){
                    var informacion = respuesta.informacion;
                }
                }
                }
                xmlhr.send(consulta_parametros);
        }

        function datosEmpleadosAO(params){
            for (var i = 0; i < params.length; i++) {
                empleados_activos.push(params[i].altas);
                empleados_inactivos.push(params[i].bajas);
            }
            localStorage.setItem('empleados_activos', empleados_activos);
            localStorage.setItem('empleados_inactivos', empleados_inactivos);
        }

        Dempleados_activos = localStorage.getItem('empleados_activos').split(',');
        Dempleados_inactivos = localStorage.getItem('empleados_inactivos').split(',');

        // Pie Chart Example
        var ctx = document.getElementById("chartEmpleados");
        var myPieChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ["Altas", "Bajas"],
            datasets: [{
            data: Dempleados_activos.concat(Dempleados_inactivos),
            backgroundColor: ['	#0000CD','#DC143C'],
            hoverBackgroundColor: ['#191970','#B22222'],
            hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
            },
            legend: {
            display: true
            },
            cutoutPercentage: 80,
        },
        });

        //POR SUCURSALES
        function obtenerSucursales(){
            var action = 'obtener-datos-sucursales';
            var consulta_parametros = new FormData();
            consulta_parametros.append('action', action);
            var xmlhr = new XMLHttpRequest();
            xmlhr.open('POST', backendURL, true);
                xmlhr.onload = function()
                {
                if (this.status === 200) {
                var respuesta = JSON.parse(xmlhr.responseText);
                if (respuesta.estado === 'OK') {
                    var informacion = respuesta.informacion;
                    datosSucursales(informacion);
                } else if(respuesta.estado === 'NOK'){
                    var informacion = respuesta.informacion;
                }
                }
                }
                xmlhr.send(consulta_parametros);
        }

        function datosSucursales(params){
            for (var i = 0; i < params.length; i++) {
                nombre_sucursal.push(params[i].sucursal);
                cantidad_sucursal.push(params[i].cantidad);
            }
            localStorage.setItem('nombre_sucursal', nombre_sucursal);
            localStorage.setItem('cantidad_sucursal', cantidad_sucursal);
        }

        Dnombre_sucursal = localStorage.getItem('nombre_sucursal').split(',').filter(function(e){ return e.replace(/(\r\n|\n|\r)/gm,"")});
        Dcantidad_sucursal = localStorage.getItem('cantidad_sucursal').split(',').filter(function(e){ return e.replace(/(\r\n|\n|\r)/gm,"")});
        
        var ctxc = document.getElementById("chartSucursales");
        var myBarChart = new Chart(ctxc, {
            type: 'bar',
            data: {
                    labels: Dnombre_sucursal,
                    datasets: [{
                    data: Dcantidad_sucursal,
                    backgroundColor: bgColors,
                    hoverBackgroundColor: hoverbgColors,
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                    }],
                },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
                },
                legend: {
                display: false
                },
                cutoutPercentage: 80,
            },
        });

});