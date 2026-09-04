<?php include 'env.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gafete de Contratista</title>
    <link
        rel="stylesheet"
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    >
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            padding: 0;
            background: #e9e9e9;
            font-family: Arial, sans-serif;
        }
        .contenedorGafete {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            /* gap: 10px; */
            padding: 20px;
        }
        .gafete {
            position: relative;
            width: 9cm;
            height: 16.5cm;
            overflow: hidden;
            background-repeat: no-repeat;
            background-size: 100% 100%;
            background-position: center;
            border: 1px solid #000;
            flex-shrink: 0;
        }
        #panelFrente {
            background-image: url("./img/gafeteC/gafete-frente.png");
        }
        #panelReverso {
            background-image: url("./img/gafeteC/gafete-reverso.png");
        }
        /* #panelEtiquetas {
            background-image: url("gafete-etiquetas.png");
            width: 4cm;
        } */
        .campo {
            position: absolute;
            font-size: 12px;
            font-weight: bold;
            color: #000;
            z-index: 10;
        }
        #empNombre {
            position: absolute;
            left: 2.1cm;
            top: 2.05cm;
            width: 3.5cm;
            height: auto;
            font-size: 12px;
            font-weight: bold;
            color: #000;
            z-index: 10;
        }

        #empNombre .renglon1 {
            display: block;
            margin-left: 0;
            white-space: nowrap;
        }

        #empNombre .renglon2 {
            display: block;
            margin-left: -1.9cm;
            white-space: nowrap;
        }
        #empIMSS {
            left: 0.8cm;
            top: 3.3cm;
            width: 6cm;
            height: 0.8cm;
            font-size: 14px;
        }
        #empClinica {
            left: 4.45cm;
            top: 3.3cm;
            width: 6cm;
            height: 0.8cm;
            font-size: 14px;
        }
        .fotoContratista {
            position: absolute;
            left: 5.68cm;
            top: 1.17cm;
            width: 3.22cm;
            height: 2.59cm;
            z-index: 20;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background: transparent;
        }
        .fotoContratista img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: none;
        }
        #empFirma {
            position: absolute;
            left: 1.35cm;
            top: 4.55cm;
            width: 2.7cm;
            height: 0.8cm;
            z-index: 15;
        }
        #empVigencia {
            position: absolute;
            left: 4.35cm;
            top: 4.55cm;
            width: 2.0cm;
            height: 0.65cm;
            z-index: 15;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: bold;
            color: #ff0000;
            text-align: center;
        }
        #empCompania {
            position: absolute;
            left: 4.95cm;
            top: 4.25cm;
            width: 4.65cm;
            height: 0.75cm;
            z-index: 15;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        #empCompania img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: none;
        }
        .noprint {
            text-align: center;
            margin-top: 10px;
        }
        @media print {
            body {
                margin: 0;
                padding: 0;
                background: #fff;
            }
            .noprint {
                display: none !important;
            }
            .contenedorGafete {
                gap: 0.1cm;
            }
            .gafete {
                position: relative;
                width: 9cm;
                height: 16.5cm;
                flex-shrink: 0;
                overflow: hidden;
                border: 1px solid #000;
                background-repeat: no-repeat;
                background-size: 100% 100%;
                background-position: center;
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }
            #panelEtiquetas {
                width: 3.8cm;
                height: 16.5cm;
                flex-shrink: 0;
            }
            /* .fotoContratista {
                left: 6.6cm;
                top: 1.4cm;
                width: 3.8cm;
                height: 2.9cm;
            } */
            @page {
                size: portrait;
                margin: 0.4cm;
            }
        }
    </style>
</head>
<body>
<div class="contenedorGafete">
    <div
        class="gafete"
        id="panelFrente"
    >
        <div
            class="campo"
            id="empNombre"
        ></div>
        <div
            class="campo"
            id="empIMSS"
        ></div>
        <div
            class="campo"
            id="empClinica"
        ></div>
        <div class="fotoContratista">
            <img
                id="empFoto"
                src=""
                alt="Foto del contratista"
            >
        </div>
        <div
            id="empFirma"
            class="campo"
        ></div>
        <div
            id="empVigencia"
            class="campo"
        ></div>
        <div id="empCompania">
            <img
                id="imgCompania"
                src=""
                alt="Compañía"
            >
        </div>
    </div>
    <div
        class="gafete"
        id="panelReverso"
    ></div>
    <!-- <div
        class="gafete"
        id="panelEtiquetas"
    ></div> -->
</div>
<div class="noprint">
    <button
        class="btn btn-success btn-lg"
        onclick="window.print();"
    >
        IMPRIMIR
    </button>
</div>
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js">
</script>
<script
    src="https://cdn.jsdelivr.net/npm/sweetalert2@8">
</script>
<script>
    const serverurl = '<?php echo serverurl; ?>';
    $(document).ready(function () {
        let searchParams =
            new URLSearchParams(window.location.search);
        let check =
            searchParams.has('emp');
        if (check) {
            let param =
                searchParams.get('emp');
            $.ajax({
                type: 'POST',
                url: serverurl + 'controller.php',
                data: {
                    action: 'datos-gafete',
                    nomina: param
                }
            }).done(function (response) {
                console.log(
                    'RESPUESTA:',
                    response
                );
                try {
                    let respuesta =
                        JSON.parse(response);
                    console.log(
                        'JSON:',
                        respuesta
                    );
                    let informacionCantidad =
                        respuesta.informacion.length;
                    if (informacionCantidad > 0) {
                        let d =
                            respuesta.informacion[0];
                        let nombreCompleto = d.nombre_largo || '';
                        let palabras = nombreCompleto.trim().split(/\s+/);

                        let renglon1 = '';
                        let renglon2 = '';

                        for (let i = 0; i < palabras.length; i++) {

                            let prueba = renglon1
                                ? renglon1 + ' ' + palabras[i]
                                : palabras[i];

                            if (prueba.length <= 17) {
                                renglon1 = prueba;
                            } else {
                                renglon2 = palabras.slice(i).join(' ');
                                break;
                            }
                        }

                        $('#empNombre').html(
                            '<span class="renglon1">' +
                                renglon1 +
                            '</span>' +
                            (renglon2
                                ? '<span class="renglon2">' +
                                    renglon2 +
                                '</span>'
                                : '')
                        );

                        $('#empNombre').html(
                            '<span class="renglon1">' +
                                renglon1 +
                            '</span>' +
                            (renglon2
                                ? '<span class="renglon2">' +
                                    renglon2 +
                                '</span>'
                                : '')
                        );
                        $('#empIMSS').text(
                            $.trim(d.nss + d.dv)
                        );
                        let clinica = $.trim(d.clinica || '');

                        if (clinica.length === 1) {
                            clinica = '0' + clinica;
                        }

                        $('#empClinica').text(clinica);
                        $('#empVigencia').text(
                            d.vigencia || ''
                        );
                        $('#imgCompania')
                            .attr('src', './img/gafeteC/logo.png')
                            .show();
                        getImageUrl(
                            $.trim(d.numero_nomina)
                        )
                        .then(function (
                            urlImagenEmpleado
                        ) {
                            console.log(
                                'URL IMAGEN:',
                                urlImagenEmpleado
                            );
                            if (
                                urlImagenEmpleado
                            ) {
                                $('#empFoto')
                                    .attr(
                                        'src',
                                        urlImagenEmpleado
                                    )
                                    .show();
                            }
                        });
                    } else {
                        console.log(
                            'No hay información del empleado.'
                        );
                    }
                } catch (error) {
                    console.error(
                        'ERROR AL CONVERTIR JSON:',
                        error
                    );
                    console.error(
                        'RESPUESTA RECIBIDA:',
                        response
                    );
                }
            }).fail(function (
                xhr,
                status,
                error
            ) {
                console.error(
                    'ERROR AJAX:',
                    error
                );
                console.error(
                    'RESPUESTA:',
                    xhr.responseText
                );
            });
        }
    });
    async function getImageUrl(
        payroll_number
    ) {
        let url = '';
        await $.ajax({
            type: 'POST',
            url:
                'inc/model/employee-image-service.php',
            data: {
                payroll_number:
                    payroll_number
            },
            success: function (
                response
            ) {
                console.log(
                    'RESPUESTA FOTO:',
                    response
                );
                let data =
                    JSON.parse(response);
                url =
                    data.url;
            }
        });
        return url;
    }
</script>
</body>
</html>
