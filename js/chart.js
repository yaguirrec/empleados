$(document).ready(function() {
  // VALUE OF THE ACTUAL SECTION
  let searchParams = new URLSearchParams(window.location.search);
  let seccionActual = searchParams.get("request");
  let empleado_activo = document.querySelector('#empleado_activo').value;
  let nivel_usuario = document.querySelector('#nivel_usuario').value;
  let backendURL = `${serverurl}controller.php`;
  var meses = [],
    activosSUC = [],
    bajasSUC = [],
    dia = [],
    diaSUC = [],
    cantidadASUC = [],
    cantidadA = [],
    cantidadB = [],
    cantidadBSUC = [],
    empleados = [],
    empleadosB = [],
    empleados_activos = [],
    empleados_inactivos = [],
    totalSucursal = [],
    totalPlanta = [],
    totalAOPlanta = [],
    totalOPlanta = [],
    totalAdministrativos = [],
    totalAdministrativosOperativos = [],
    totalOperativos = [],
    totalEspeciales = [],
    nombrePlanta = [],
    nombreSucursal = [];
  var Dmeses,
    Dempleados,
    Dempleados_activos,
    Dempleados_inactivos,
    DactivosSUC,
    DbajasSUC,
    dDia,
    dDiaSUC,
    dCantidadA,
    dCantidadASUC,
    dCantidadB,
    dCantidadBSUC,
    DtotalSucursal,
    DtotalPlanta,
    DtotalAOPlanta,
    DtotalAPlanta,
    DtotalAdministrativos,
    DtotalEspeciales,
    DtotalAdministrativosOperativos,
    DtotalOperativos,
    DnombreSucursal;

  var bgColors = [
    "SteelBlue ",
    "LimeGreen",
    "SteelBlue",
    "LimeGreen",
    "SteelBlue ",
    "LimeGreen",
    "SteelBlue",
    "LimeGreen",
    "SteelBlue ",
    "LimeGreen",
    "SteelBlue",
    "LimeGreen",
    "SteelBlue ",
    "LimeGreen",
    "SteelBlue",
    "LimeGreen"
  ];
  var hoverbgColors = [
    "SkyBlue",
    "PaleGreen",
    "SkyBlue",
    "PaleGreen",
    "SkyBlue",
    "PaleGreen",
    "SkyBlue",
    "PaleGreen",
    "SkyBlue",
    "PaleGreen",
    "SkyBlue",
    "PaleGreen",
    "SkyBlue",
    "PaleGreen",
    "SkyBlue",
    "PaleGreen"
  ];

  window.chartColors = {
    red: "rgb(255, 99, 132)",
    orange: "rgb(255, 159, 64)",
    yellow: "rgb(255, 205, 86)",
    green: "rgb(75, 192, 192)",
    blue: "rgb(54, 162, 235)",
    purple: "rgb(153, 102, 255)",
    grey: "rgb(201, 203, 207)"
  };

  obtenerEmpleados();
  obtenerEmpleadosB();
  obtenerEmpleadosAO();
  altasDiarias();
  bajasDiarias();
  totalClasificacionSucursal();


  function obtenerEmpleados() {
    var action = "obtener-empleados-mes",
      props = "altas";
    var consulta_parametros = new FormData();
    consulta_parametros.append("action", action);
    consulta_parametros.append("props", props);
    var xmlhr = new XMLHttpRequest();
    xmlhr.open("POST", backendURL, true);
    xmlhr.onload = function() {
      if (this.status === 200) {
        var respuesta = JSON.parse(xmlhr.responseText);
        if (respuesta.estado === "OK") {
          var informacion = respuesta.informacion;
          obtenerDatos(informacion);
        } else if (respuesta.estado === "NOK") {
          var informacion = respuesta.informacion;
        }
      }
    };
    xmlhr.send(consulta_parametros);
  }

  function obtenerEmpleadosB() {
    var action = "obtener-empleados-mes",
      props = "bajas";
    var consulta_parametros = new FormData();
    consulta_parametros.append("action", action);
    consulta_parametros.append("props", props);
    var xmlhr = new XMLHttpRequest();
    xmlhr.open("POST", backendURL, true);
    xmlhr.onload = function() {
      if (this.status === 200) {
        var respuesta = JSON.parse(xmlhr.responseText);
        if (respuesta.estado === "OK") {
          var informacion = respuesta.informacion;
          obtenerDatosB(informacion);
        } else if (respuesta.estado === "NOK") {
          var informacion = respuesta.informacion;
        }
      }
    };
    xmlhr.send(consulta_parametros);
  }

  function obtenerDatosB(params) {
    for (var i = 0; i < params.length; i++) {
      empleadosB.push(params[i].contador);
    }
    localStorage.setItem("empleadosB", empleadosB);
  }

  DempleadosB = localStorage.getItem("empleadosB").split(",");

  function obtenerDatos(params) {
    for (var i = 0; i < params.length; i++) {
      meses.push(params[i].nombre_mes);
      empleados.push(params[i].contador);
    }
    localStorage.setItem("meses", meses);
    localStorage.setItem("empleados", empleados);
  }

  Dmeses = localStorage.getItem("meses").split(",");
  Dempleados = localStorage.getItem("empleados").split(",");

  var datosAltas = {
    label: "Altas del mes",
    data: Dempleados,
    lineTension: 0,
    fill: false,
    borderColor: "blue"
  };

  var datosBajas = {
    label: "Bajas del mes",
    data: DempleadosB,
    lineTension: 0,
    fill: false,
    borderColor: "red"
  };

  var datosEmpleados = {
    labels: Dmeses,
    datasets: [datosAltas, datosBajas]
  };

  // Area Chart Example
  var ctx = document.getElementById("chartMensual");
  var myLineChart = new Chart(ctx, {
    type: "line",
    data: datosEmpleados,
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
        xAxes: [
          {
            time: {
              unit: "date"
            },
            gridLines: {
              display: false,
              drawBorder: false
            },
            ticks: {
              maxTicksLimit: 7
            }
          }
        ],
        yAxes: [
          {
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
          }
        ]
      },
      legend: {
        display: true
      },
      tooltips: {
        backgroundColor: "rgb(255,255,255)",
        bodyFontColor: "#858796",
        titleMarginBottom: 10,
        titleFontColor: "#6e707e",
        titleFontSize: 14,
        borderColor: "#dddfeb",
        borderWidth: 1,
        xPadding: 15,
        yPadding: 15,
        displayColors: false,
        intersect: false,
        mode: "index",
        caretPadding: 10,
        callbacks: {
          label: function(tooltipItem, chart) {
            var datasetLabel =
              chart.datasets[tooltipItem.datasetIndex].label || "";
            return datasetLabel + ": " + tooltipItem.yLabel;
          }
        }
      }
    }
  });

  // DIARIAS

  function altasDiarias() {
    var action = "movimientos-diarios",
        props = "altasD";
    var consulta_parametros = new FormData();
    consulta_parametros.append("action", action);
    consulta_parametros.append("props", props);
    var xmlhr = new XMLHttpRequest();
    xmlhr.open("POST", backendURL, true);
    xmlhr.onload = function() {
      if (this.status === 200) {
        var respuesta = JSON.parse(xmlhr.responseText);
        if (respuesta.estado === "OK") {
          var informacion = respuesta.informacion;
          datosaltasDiarias(informacion);
        } else if (respuesta.estado === "NOK") {
          var informacion = respuesta.informacion;
        }
      }
    };
    xmlhr.send(consulta_parametros);
  }

  function datosaltasDiarias(params) {
    for (var i = 0; i < params.length; i++) {
      dia.push(params[i].fecha_alta.date.substr(0, 10));
      cantidadA.push(params[i].cantidad);
    }
    localStorage.setItem("dia", dia);
    localStorage.setItem("cantidadA", cantidadA);
  }

  dDia = localStorage.getItem("dia").split(",");
  dCantidadA = localStorage.getItem("cantidadA").split(",");

  var datosAltasDiarias = {
    label: "Altas del dia",
    data: dCantidadA,
    lineTension: 0,
    fill: false,
    borderColor: "blue"
  };

  function bajasDiarias() {
    var action = "movimientos-diarios",
        props = "bajasD";
    var consulta_parametros = new FormData();
    consulta_parametros.append("action", action);
    consulta_parametros.append("props", props);
    var xmlhr = new XMLHttpRequest();
    xmlhr.open("POST", backendURL, true);
    xmlhr.onload = function() {
      if (this.status === 200) {
        var respuesta = JSON.parse(xmlhr.responseText);
        if (respuesta.estado === "OK") {
          var informacion = respuesta.informacion;
          datosbajasDiarias(informacion);
        } else if (respuesta.estado === "NOK") {
          var informacion = respuesta.informacion;
        }
      }
    };
    xmlhr.send(consulta_parametros);
  }

  function datosbajasDiarias(params) {
    for (var i = 0; i < params.length; i++) {
    //   dia.push(params[i].fecha_alta.date.substr(0, 10));
      cantidadB.push(params[i].cantidad);
    }
    // localStorage.setItem("dia", dia);
    localStorage.setItem("cantidadB", cantidadB);
  }

//  Dia = localStorage.getItem("dia").split(",");
  dCantidadB = localStorage.getItem("cantidadB").split(",");

  var datosBajasDiarias = {
    label: "Bajas del dia",
    data: dCantidadB,
    lineTension: 0,
    fill: false,
    borderColor: "red"
  };

  var datosAltasBajasDiarias = {
    labels: dDia,
    datasets: [datosAltasDiarias, datosBajasDiarias]
  };

  var ctxAB = document.getElementById("chartaltasbajasDiarias");
  var myLineChart = new Chart(ctxAB, {
    type: "line",
    data: datosAltasBajasDiarias,
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
        xAxes: [
          {
            time: {
              unit: "date"
            },
            gridLines: {
              display: false,
              drawBorder: false
            },
            ticks: {
              maxTicksLimit: 7
            }
          }
        ],
        yAxes: [
          {
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
          }
        ]
      },
      legend: {
        display: true
      },
      tooltips: {
        backgroundColor: "rgb(255,255,255)",
        bodyFontColor: "#858796",
        titleMarginBottom: 10,
        titleFontColor: "#6e707e",
        titleFontSize: 14,
        borderColor: "#dddfeb",
        borderWidth: 1,
        xPadding: 15,
        yPadding: 15,
        displayColors: false,
        intersect: false,
        mode: "index",
        caretPadding: 10,
        callbacks: {
          label: function(tooltipItem, chart) {
            var datasetLabel =
              chart.datasets[tooltipItem.datasetIndex].label || "";
            return datasetLabel + ": " + tooltipItem.yLabel;
          }
        }
      }
    }
  });

  //GRAFICO ACTIVOS POR SUCURSAL

  function totalClasificacionSucursal(){
    $.ajax({
      type: 'POST',
      url: backendURL,
      data: {
          action: 'consulta-sucursal'
      }
    }).done(function (response) {
        respuesta = JSON.parse(response);
        let estadoRespuesta = respuesta.estado;
        if (estadoRespuesta === 'OK') {
          var informacion = respuesta.informacion;
          datosaltasporSucursal(informacion);
        } else {
            Swal.fire({
                title: 'Error',
                text: 'Ocurrio un error al procesar los datos',
                type: 'error'
            })
        }
    });
  }

  function datosaltasporSucursal(params) {
    for (var i = 0; i < params.length; i++) {
      totalSucursal.push(params[i].totalSucursal);
      totalAdministrativos.push(params[i].totalAdministrativos);
      totalAdministrativosOperativos.push(params[i].totalAdministrativosOperativos);
      totalOperativos.push(params[i].totalOperativos);
      totalEspeciales.push(params[i].totalEspeciales);
      nombreSucursal.push(params[i].nombre);
    }
    localStorage.setItem("totalSucursal", totalSucursal);
    localStorage.setItem("totalAdministrativos", totalAdministrativos);
    localStorage.setItem("totalAdministrativosOperativos", totalAdministrativosOperativos);
    localStorage.setItem("totalOperativos", totalOperativos);
    localStorage.setItem("totalEspeciales", totalEspeciales);
    localStorage.setItem("nombreSucursal", nombreSucursal);
  }

  DtotalSucursal = localStorage.getItem("totalSucursal").split(",");
  DtotalAdministrativos = localStorage.getItem("totalAdministrativos").split(",");
  DtotalAdministrativosOperativos = localStorage.getItem("totalAdministrativosOperativos").split(",");
  DtotalOperativos = localStorage.getItem("totalOperativos").split(",");
  DtotalEspeciales = localStorage.getItem("totalEspeciales").split(",");
  DnombreSucursal = localStorage.getItem("nombreSucursal").split(",");

  var barChartData = {
    labels: DnombreSucursal,
    datasets: [{
      label: 'Administrativos',
      backgroundColor: window.chartColors.red,
      data: DtotalAdministrativos,
    }, {
      label: 'Administrativos Operativos',
      backgroundColor: window.chartColors.blue,
      data: DtotalAdministrativosOperativos,
    }, {
      label: 'Operativos',
      backgroundColor: window.chartColors.green,
      data: DtotalOperativos,
    },{
      label: 'Especiales',
      backgroundColor: window.chartColors.yellow,
      data: DtotalEspeciales,
    }]

  };
    var ctxx = document.getElementById('canvas');
    window.myBar = new Chart(ctxx, {
      type: 'bar',
      data: barChartData,
      options: {
        title: {
          display: true,
          text: 'Activos por Sucursal'
        },
        tooltips: {
          mode: 'index',
          intersect: false
        },
        responsive: true,
        scales: {
          xAxes: [{
            stacked: true,
          }],
          yAxes: [{
            stacked: true
          }]
        }
      }
    });

  //ACTIVOS POR SUCURSAL

  // DIARIAS

  //GRAFICA DE PIE
  (Chart.defaults.global.defaultFontFamily = "Nunito"),
    '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
  Chart.defaults.global.defaultFontColor = "#858796";

  function obtenerEmpleadosAO() {
    var action = "obtener-datos-empleados";
    var consulta_parametros = new FormData();
    consulta_parametros.append("action", action);
    var xmlhr = new XMLHttpRequest();
    xmlhr.open("POST", backendURL, true);
    xmlhr.onload = function() {
      if (this.status === 200) {
        var respuesta = JSON.parse(xmlhr.responseText);
        if (respuesta.estado === "OK") {
          var informacion = respuesta.informacion;
          datosEmpleadosAO(informacion);
        } else if (respuesta.estado === "NOK") {
          var informacion = respuesta.informacion;
        }
      }
    };
    xmlhr.send(consulta_parametros);
  }

  function datosEmpleadosAO(params) {
    for (var i = 0; i < params.length; i++) {
      empleados_activos.push(params[i].altas);
      empleados_inactivos.push(params[i].bajas);
    }
    localStorage.setItem("empleados_activos", empleados_activos);
    localStorage.setItem("empleados_inactivos", empleados_inactivos);
  }

  Dempleados_activos = localStorage.getItem("empleados_activos").split(",");
  Dempleados_inactivos = localStorage.getItem("empleados_inactivos").split(",");

  // Pie Chart Example
  var ctx = document.getElementById("chartEmpleados");
  var myPieChart = new Chart(ctx, {
    type: "doughnut",
    data: {
      labels: ["Altas", "Bajas"],
      datasets: [
        {
          data: Dempleados_activos.concat(Dempleados_inactivos),
          backgroundColor: ["	#0000CD", "#DC143C"],
          hoverBackgroundColor: ["#191970", "#B22222"],
          hoverBorderColor: "rgba(234, 236, 244, 1)"
        }
      ]
    },
    options: {
      maintainAspectRatio: false,
      tooltips: {
        backgroundColor: "rgb(255,255,255)",
        bodyFontColor: "#858796",
        borderColor: "#dddfeb",
        borderWidth: 1,
        xPadding: 15,
        yPadding: 15,
        displayColors: false,
        caretPadding: 10
      },
      legend: {
        display: true
      },
      cutoutPercentage: 80
    }
  });

  //POR SUCURSALES
  var ctxc = document.getElementById("chartSucursales");
  var myBarChart = new Chart(ctxc, {
    type: "bar",
    data: {
      labels: DnombreSucursal,
      datasets: [
        {
          data: DtotalSucursal,
          backgroundColor: bgColors,
          hoverBackgroundColor: hoverbgColors,
          hoverBorderColor: "rgba(234, 236, 244, 1)"
        }
      ]
    },
    options: {
      maintainAspectRatio: false,
      tooltips: {
        backgroundColor: "rgb(255,255,255)",
        bodyFontColor: "#858796",
        borderColor: "#dddfeb",
        borderWidth: 1,
        xPadding: 15,
        yPadding: 15,
        displayColors: false,
        caretPadding: 10
      },
      legend: {
        display: false
      },
      cutoutPercentage: 80
    }
  });

  // ACTUALIZACIONES RECIENTES
  function actualizarTarjeta(){
    $.ajax({
      type: 'POST',
      url: backendURL,
      data: {
          action: 'datos-recientes'
      }
    }).done(function (response) {
        respuesta = JSON.parse(response);
        let estadoRespuesta = respuesta.estado,
            row = 'Ultimas actualizaciones<hr>';
        if (estadoRespuesta === 'OK') {
          var informacion = respuesta.informacion;
          // console.log('informacion');
          for (var i in informacion) {
            row += '<p>' + informacion[i].actualizado + ' | ' + informacion[i].estadoEmpleado + ' ' + informacion[i].numero_nomina + ' ' + informacion[i].nombre_largo + ' ' + informacion[i].Puesto + ' ' + informacion[i].Sucursal + ' ' + informacion[i].Departamento + '</p>';
          }
          $('#datos-recientes').html(row);
        } else {
            Swal.fire({
                title: 'Error',
                text: 'Ocurrio un error al procesar los datos',
                type: 'error'
            })
        }
    });
  }

  actualizarTarjeta();

  var ntervaloTarjeta = setInterval(actualizarTarjeta, 10 * 2000);

  var div = $('#datos-recientes');
  setInterval(function(){
      var pos = div.scrollTop();
      div.scrollTop(pos + 2);
  }, 250)
  // ACTUALIZACIONES RECIENTES

  //PANEL COORDINADORAS
  //ACTIVOS POR SUCURSAL
    totalPlantaSucursal();
    altasDiariasSUC();
    bajasDiariasSUC();

    function totalPlantaSucursal(){
      $.ajax({
        type: 'POST',
        url: backendURL,
        data: {
            action: 'personalPlantaSUC', param: empleado_activo
        }
      }).done(function (response) {
          respuesta = JSON.parse(response);
          //console.log(respuesta);
          let estadoRespuesta = respuesta.estado;
          if (estadoRespuesta === 'OK') {
            var informacion = respuesta.informacion;
            datosaltasporPlanta(informacion);
          } else {
              Swal.fire({
                  title: 'Error',
                  text: 'Ocurrio un error al procesar los datos',
                  type: 'error'
              })
          }
      });
    }

    function datosaltasporPlanta(params) {
      for (var i = 0; i < params.length; i++) {
        totalPlanta.push(params[i].totalPlanta);
        totalAOPlanta.push(params[i].totalAdministrativosOperativos);
        totalOPlanta.push(params[i].totalOperativos);
        nombrePlanta.push(params[i].nombre);
      }
      localStorage.setItem("totalPlanta", totalPlanta);
      localStorage.setItem("totalAOPlanta", totalAOPlanta);
      localStorage.setItem("totalOPlanta", totalOPlanta);
      localStorage.setItem("nombrePlanta", nombrePlanta);
    }

    DtotalPlanta = localStorage.getItem("totalPlanta").split(",");
    DtotalAPlanta = localStorage.getItem("totalAOPlanta").split(",");
    DtotalAOPlanta = localStorage.getItem("totalOPlanta").split(",");
    DnombrePlanta = localStorage.getItem("nombrePlanta").split(",");

    var barChartData = {
      labels: DnombrePlanta,
      datasets: [{
        label: 'Total empleados',
        backgroundColor: window.chartColors.red,
        data: DtotalPlanta,
      }, {
        label: 'Administrativos Operativos',
        backgroundColor: window.chartColors.blue,
        data: DtotalAPlanta,
      }, {
        label: 'Operativos',
        backgroundColor: window.chartColors.green,
        data: DtotalAOPlanta,
      }]

    };
      var ctxx = document.getElementById('empleadosPlantaSUC');
      window.myBar = new Chart(ctxx, {
        type: 'bar',
        data: barChartData,
        options: {
          title: {
            display: true,
            text: 'Activos por Planta'
          },
          tooltips: {
            mode: 'index',
            intersect: false
          },
          responsive: true,
          scales: {
            xAxes: [{
              stacked: true,
            }],
            yAxes: [{
              stacked: true
            }]
          }
        }
      });

      // DIARIAS

    function altasDiariasSUC() {
      var action = "movimientos-diariosSUC",
          props = "altasD";
      var consulta_parametros = new FormData();
      consulta_parametros.append("action", action);
      consulta_parametros.append("props", props);
      consulta_parametros.append("param", empleado_activo);
      var xmlhr = new XMLHttpRequest();
      xmlhr.open("POST", backendURL, true);
      xmlhr.onload = function() {
        if (this.status === 200) {
          var respuesta = JSON.parse(xmlhr.responseText);
          if (respuesta.estado === "OK") {
            var informacion = respuesta.informacion;
            datosaltasDiariasSUC(informacion);
          } else if (respuesta.estado === "NOK") {
            var informacion = respuesta.informacion;
          }
        }
      };
      xmlhr.send(consulta_parametros);
    }

    function datosaltasDiariasSUC(params) {
      for (var i = 0; i < params.length; i++) {
        diaSUC.push(params[i].fecha_alta.date.substr(0, 10));
        cantidadASUC.push(params[i].cantidad);
      }
      localStorage.setItem("diaSUC", dia);
      localStorage.setItem("cantidadASUC", cantidadA);
    }

    dDiaSUC = localStorage.getItem("diaSUC").split(",");
    dCantidadASUC = localStorage.getItem("cantidadASUC").split(",");

    var datosAltasDiariasSUC = {
      label: "Altas del dia",
      data: dCantidadASUC,
      lineTension: 0,
      fill: false,
      borderColor: "blue"
    };

    function bajasDiariasSUC() {
      var action = "movimientos-diariosSUC",
          props = "bajasD";
          console.log(empleado_activo);
      var consulta_parametros = new FormData();
      consulta_parametros.append("action", action);
      consulta_parametros.append("props", props);
      consulta_parametros.append("param", empleado_activo);
      var xmlhr = new XMLHttpRequest();
      xmlhr.open("POST", backendURL, true);
      xmlhr.onload = function() {
        if (this.status === 200) {
          var respuesta = JSON.parse(xmlhr.responseText);
          if (respuesta.estado === "OK") {
            var informacion = respuesta.informacion;
            datosbajasDiariasSUC(informacion);
          } else if (respuesta.estado === "NOK") {
            var informacion = respuesta.informacion;
          }
        }
      };
      xmlhr.send(consulta_parametros);
    }

    function datosbajasDiariasSUC(params) {
      for (var i = 0; i < params.length; i++) {
      //   dia.push(params[i].fecha_alta.date.substr(0, 10));
        cantidadBSUC.push(params[i].cantidad);
      }
      // localStorage.setItem("dia", dia);
      localStorage.setItem("cantidadBSUC", cantidadBSUC);
    }

  //  Dia = localStorage.getItem("dia").split(",");
    dCantidadBSUC = localStorage.getItem("cantidadBSUC").split(",");

    var datosBajasDiariasSUC = {
      label: "Bajas del dia",
      data: dCantidadBSUC,
      lineTension: 0,
      fill: false,
      borderColor: "red"
    };

    var datosAltasBajasDiariasSUC = {
      labels: dDiaSUC,
      datasets: [datosAltasDiariasSUC, datosBajasDiariasSUC]
    };

    var ctxAB = document.getElementById("chartaltasbajasDiariasSUC");
    var myLineChart = new Chart(ctxAB, {
      type: "line",
      data: datosAltasBajasDiariasSUC,
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
          xAxes: [
            {
              time: {
                unit: "date"
              },
              gridLines: {
                display: false,
                drawBorder: false
              },
              ticks: {
                maxTicksLimit: 7
              }
            }
          ],
          yAxes: [
            {
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
            }
          ]
        },
        legend: {
          display: true
        },
        tooltips: {
          backgroundColor: "rgb(255,255,255)",
          bodyFontColor: "#858796",
          titleMarginBottom: 10,
          titleFontColor: "#6e707e",
          titleFontSize: 14,
          borderColor: "#dddfeb",
          borderWidth: 1,
          xPadding: 15,
          yPadding: 15,
          displayColors: false,
          intersect: false,
          mode: "index",
          caretPadding: 10,
          callbacks: {
            label: function(tooltipItem, chart) {
              var datasetLabel =
                chart.datasets[tooltipItem.datasetIndex].label || "";
              return datasetLabel + ": " + tooltipItem.yLabel;
            }
          }
        }
      }

    });

});

