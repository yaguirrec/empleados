$( document ).ready(function() {

    var meses = [],
        empleados = [],
        empleados_activos = [],
        empleados_inactivos = [];
    var Dmeses,Dempleados,Dempleados_activos,Dempleados_inactivos;

    function obtenerEmpleados(){
        var action = 'obtener-empleados-mes';
        var consulta_parametros = new FormData();
        consulta_parametros.append('action', action);
        var xmlhr = new XMLHttpRequest();
        xmlhr.open('POST', 'http://187.188.159.205:8090/web_serv/empService/controller.php', true);
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

    obtenerEmpleados();

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

    // Area Chart Example
    var ctx = document.getElementById("chartMensual");
    var myLineChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: Dmeses,
        datasets: [{
        label: "Empleados",
        lineTension: 0.3,
        backgroundColor: "rgba(78, 115, 223, 0.05)",
        borderColor: "rgba(78, 115, 223, 1)",
        pointRadius: 3,
        pointBackgroundColor: "rgba(78, 115, 223, 1)",
        pointBorderColor: "rgba(78, 115, 223, 1)",
        pointHoverRadius: 3,
        pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
        pointHoverBorderColor: "rgba(78, 115, 223, 1)",
        pointHitRadius: 10,
        pointBorderWidth: 2,
        data: Dempleados,
        }],
    },
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
        display: false
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

    function obtenerSucursales(){
        var action = 'obtener-datos-sucursales';
        var consulta_parametros = new FormData();
        consulta_parametros.append('action', action);
        var xmlhr = new XMLHttpRequest();
        xmlhr.open('POST', 'http://187.188.159.205:8090/web_serv/empService/controller.php', true);
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

    obtenerSucursales();

    function datosSucursales(params){
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
    var ctx = document.getElementById("chartSucursales");
    var myPieChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ["Altas", "Bajas"],
        datasets: [{
        data: Dempleados_activos.concat(Dempleados_inactivos),
        backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
        hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
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