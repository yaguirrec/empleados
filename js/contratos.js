(function (global) {
  'use strict';

  var CONFIG = {
    rutaPlantillas: 'inc/templates/contratos/',
    backendURL: function () { return (typeof serverurl !== 'undefined' ? serverurl : 'http://localhost/api-empleados/empService/') + 'controller.php'; },
    plantillas: {
      capacitacion: { archivo: 'contrato_capacitacion_inicial.docx', nombre: 'Contrato_Capacitacion_Inicial' },
      indeterminado: { archivo: 'contrato_tiempo_indeterminado.docx', nombre: 'Contrato_Tiempo_Indeterminado' },
      obra: { archivo: 'contrato_obra_determinada.docx', nombre: 'Contrato_Obra_Determinada' }
    },
  };

  var UNI = ['', 'uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve', 'diez',
    'once', 'doce', 'trece', 'catorce', 'quince', 'dieciséis', 'diecisiete', 'dieciocho', 'diecinueve', 'veinte',
    'veintiuno', 'veintidós', 'veintitrés', 'veinticuatro', 'veinticinco', 'veintiséis', 'veintisiete', 'veintiocho', 'veintinueve'];
  var DEC = ['', '', '', 'treinta', 'cuarenta', 'cincuenta', 'sesenta', 'setenta', 'ochenta', 'noventa'];
  var CEN = ['', 'ciento', 'doscientos', 'trescientos', 'cuatrocientos', 'quinientos', 'seiscientos', 'setecientos', 'ochocientos', 'novecientos'];

  function menorMil(n) {
    if (n === 0) return '';
    if (n === 100) return 'cien';
    var c = Math.floor(n / 100), r = n % 100, s = CEN[c];
    if (r) {
      var p = r < 30 ? UNI[r] : DEC[Math.floor(r / 10)] + (r % 10 ? ' y ' + UNI[r % 10] : '');
      s = (s ? s + ' ' : '') + p;
    }
    return s;
  }

  function apocopar(s) { 
    return s.replace(/veintiuno$/, 'veintiún').replace(/uno$/, 'un'); 
  }

  function enteroALetras(n) {
    if (n === 0) return 'cero';
    var millones = Math.floor(n / 1e6), miles = Math.floor((n % 1e6) / 1000), resto = n % 1000, out = [];
    if (millones) out.push(millones === 1 ? 'un millón' : apocopar(enteroALetras(millones)) + ' millones');
    if (miles) out.push(miles === 1 ? 'mil' : apocopar(menorMil(miles)) + ' mil');
    if (resto) out.push(menorMil(resto));
    return out.join(' ');
  }

  function pesosALetras(monto) {
    var cent = Math.round(monto * 100), ent = Math.floor(cent / 100), c = cent % 100;
    var de = (ent >= 1e6 && ent % 1e6 === 0) ? ' de' : '';
    return apocopar(enteroALetras(ent)) + de + (ent === 1 ? ' peso ' : ' pesos ') + ('0' + c).slice(-2) + '/100 moneda nacional';
  }

  function dinero(n) {
    return n.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
  }

  function formatearSalario(datos) {
    var mensual = parseFloat(datos.salario_mensual) || 0;
    datos.salario_mensual = mensual ? dinero(mensual) : '';
    datos.salario_mensual_letra = mensual ? pesosALetras(mensual) : '';
    return datos;
  }

  function nominaActual() {
    var el = document.getElementById('txtNomina');
    var n = el ? el.textContent.trim() : '';
    if (n) return n;
    try { return (localStorage.getItem('codigoEmpleado') || '').trim().substr(0, 5); } catch (e) { return ''; }
  }

  function obtenerDatosContrato(nomina) {
    var body = new URLSearchParams({ action: 'datos-contrato', numero_nomina: nomina });
    return fetch(CONFIG.backendURL(), { method: 'POST', body: body })
      .then(function (r) { return r.json(); })
      .then(function (resp) {
        if (resp.estado !== 'OK') throw new Error(resp.mensaje || 'No se pudieron obtener los datos del empleado.');
        return formatearSalario(resp.informacion);
      });
  }

  function renderDocx(plantilla, datos) {
    var doc = new global.docxtemplater(new global.PizZip(plantilla), {
      paragraphLoop: true,
      linebreaks: true,
      nullGetter: function () { return CONFIG.vacio; }
    });
    var limpio = {};
    Object.keys(datos).forEach(function (k) { limpio[k] = datos[k] || CONFIG.vacio; });
    doc.render(limpio);
    return doc;
  }

  function descargar(blob, nombreArchivo) {
    var a = document.createElement('a');
    a.href = URL.createObjectURL(blob);
    a.download = nombreArchivo.normalize('NFD').replace(/[̀-ͯ]/g, '').replace(/[^\w.\-]/g, '_');
    document.body.appendChild(a); a.click(); a.remove();
    setTimeout(function () { URL.revokeObjectURL(a.href); }, 2000);
  }

  function generarContrato(tipo, boton) {
    var cfg = CONFIG.plantillas[tipo];
    if (!cfg) return alertar('Tipo de contrato no válido: ' + tipo);
    if (!global.PizZip || !global.docxtemplater) return alertar('No se cargaron las librerías de Word (pizzip / docxtemplater).');

    var nomina = nominaActual();
    if (!nomina) return alertar('No se encontró el número de nómina del empleado.');

    var htmlOriginal = boton.innerHTML;
    boton.disabled = true;

    var datos;
    obtenerDatosContrato(nomina)
      .then(function (d) {
        datos = d;
        console.log('[contratos] datos-contrato:', datos);
        return fetch(CONFIG.rutaPlantillas + cfg.archivo + '?v=' + Date.now());
      })
      .then(function (r) {
        if (!r.ok) throw new Error('No se encontró la plantilla ' + cfg.archivo + ' (HTTP ' + r.status + ')');
        return r.arrayBuffer();
      })
      .then(function (buf) {
        var blob = renderDocx(buf, datos).getZip().generate({
          type: 'blob',
          mimeType: 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
          compression: 'DEFLATE'
        });
        var apellidos = datos.nombre.split(' ').slice(0, 2).join('_');
        descargar(blob, cfg.nombre + '_' + datos.nomina + '_' + apellidos + '.docx');
      })
      .catch(function (err) {
        console.error('[contratos]', err, err.properties || '');
        alertar('No se pudo generar el contrato: ' + err.message);
      })
      .then(function () { boton.disabled = false; boton.innerHTML = htmlOriginal; });
  }

  function alertar(msg) {
    if (global.Swal && global.Swal.fire) global.Swal.fire({ icon: 'error', title: 'Contratos', text: msg });
    else if (global.swal) global.swal('Contratos', msg, 'error');
    else global.alert(msg);
  }

  document.addEventListener('click', function (ev) {
    var btn = ev.target.closest && ev.target.closest('[data-contrato]');
    if (!btn) return;
    ev.preventDefault();
    generarContrato(btn.getAttribute('data-contrato'), btn);
  });

  global.Contratos = { CONFIG: CONFIG, generar: generarContrato, pesosALetras: pesosALetras, formatearSalario: formatearSalario };
})(window);