<?php include 'env.php' ?>
<style>
/* This text is in Century Gothic */
@import url('https://www.fontify.me/wf/3afcc221e9439cbe0309799cece16dee');
body{
font-family: "Century Gothic", CenturyGothic, AppleGothic, sans-serif;}

@media print {
.noprint{display: none !important; }

 @page { margin: 0;size: portrait;}
}

</style>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<body>
    <div class="row mb-5">

    <div id='front'>
    <img src="img/gafete/G_QOBRO_01.png" style="margin-left:3.8px;width:5.9cm;height:9.2cm;position: absolute; z-index: 1;">
    
    <img  class='img-circle' style="height:3.8cm; width:3.8cm; border-radius: 94%; position: absolute;z-index: 2;top:2.2cm;left:.76cm;" id="empFoto" alt="Foto"> 
    <center>
    <p style="position: absolute; 
    text-align: center;
    font-weight: bold;
    left:0.15cm; 
    font-family: 'Century Gothic', CenturyGothic, AppleGothic, sans-serif;
    width: 5.4cm; 
    top:6.58cm;
    color: #16152a;
    font-size: 16px;
    z-index: 3;" 
    id="empNombre">

    <!-- Mi nombre -->
    </p>
    </center>
    <center>
    <p style="position: absolute; 
    text-align: center;
    left:0.15cm; 
    width: 5.4cm; 
    font-family: 'Century Gothic', CenturyGothic, AppleGothic, sans-serif;
    top: 7.8cm;
    z-index: 4; 
    font-size:14px;
    color:#FFFFFF;" id="empPuesto">
    <!-- Mi Puesto -->
    </p>
    </center>

    <center>
    <p style="position: absolute;
    left:0.15cm;  
    top:8.58cm; 
    z-index: 5;
    color:#FFFFFF;
    font-family: 'Century Gothic', CenturyGothic, AppleGothic, sans-serif;
    text-align: center;
    width: 5.4cm;
    font-size:12.5px;" id="empAlta">
    <!-- Ingreso : 20/02/2012     -->
    </p>
    </div>
    <div id="back">
    </center>
    <img  name="back" src="img/gafete/G_QOBRO_02.png" 
    style="margin-left: 15px;width:5.9cm;height:8.9cm;position: 
    absolute; z-index: 6;top:9.25cm;border-left: 
    dotted #000 1px;transform:rotate(180deg);
    -ms-transform:rotate(180deg); /* IE 9 */
    -webkit-transform:rotate(180deg); /* Opera, Chrome, and Safari */"> 


    <p  style="
    transform:rotate(180deg);
    -ms-transform:rotate(180deg); 
    /* IE 9 */
    -webkit-transform:rotate(180deg);
    position: absolute; 
    text-align: left;
    left: -2.55cm;
    width: 4cm; 
    top:12.30cm;
    font-size: 7.5px;
    font-family: 'Century Gothic', CenturyGothic, AppleGothic;
    z-index: 9;
    color:#919496 ;" id="empNumero">
    <!-- Numero nomina -->
    </p>


    <p style="
    position: absolute; 
    text-align: left;
    left: -1.40cm;
    width: 5cm;
    font-weight: bold;
    font-family: 'Century Gothic', CenturyGothic, AppleGothic, sans-serif;
    font-size: 7.5px;
    z-index: 7;
    top:12.30cm;
    color:#919496;
    transform:rotate(180deg);
    -ms-transform:rotate(180deg); /* IE 9 */
    -webkit-transform:rotate(180deg);" id="empNS">
    <!-- No.IMSS: ##### -->
    </p>

    <p style="position: absolute; 
    text-align: left;
    width: 5cm; 
    font-weight: bold;
    font-size: 7.5px;
    z-index: 7;
    left: .39cm; 
    font-family: 'Century Gothic', CenturyGothic, AppleGothic, sans-serif;
    top:12.30cm;
    color: #919496;
    transform:rotate(180deg);
    -ms-transform:rotate(180deg); /* IE 9 */
    -webkit-transform:rotate(180deg);" id="empEmergencia">
    <!-- TELEFONO EMERGENCIA -->
    </p>

    <center>
    <p  style="
    transform:rotate(180deg);
    -ms-transform:rotate(180deg); 
    /* IE 9 */
    -webkit-transform:rotate(180deg);
    position: absolute; 
    text-align: center;
    width: 3.6cm; 
    top:10.30cm;
    font-size: 8.7px;
    font-family: 'Century Gothic', CenturyGothic, AppleGothic;
    z-index: 9;
    left: 1.2cm;
    color:#919496;" id="empDireccion">
    <!-- Mi direccion -->
    </p>
    </center>

    <!-- <center>
    <img
    style="transform:rotate(180deg);
    -ms-transform:rotate(180deg); /* IE 9 */
    -webkit-transform:rotate(180deg);
    position: absolute;
    text-align: center;
    width: 4.5cm;
    font-family: 'Century Gothic', CenturyGothic, AppleGothic, sans-serif;
    height: .8cm; 
    top:10.35cm;
    z-index: 10;
    left: 0.7cm;" 
    alt='MEXQ' id="empNomina"/>
    <svg id="barcode"></svg>
    </center> -->

    </div>
    <br>
    </div class="seccionBotonImprimir noprint">
        <a class="btn btn-lg btn-success botonImprimir" id="btnPrint" style="position: absolute; width: 3.2cm;top:19.4cm;font-size:12px;z-index: 12;left: 1cm;">IMPRIMIR</a>
    </div>
</body>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/jsbarcode/3.6.0/barcodes/JsBarcode.code128.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script type="text/javascript">
    const serverurl = '<?php echo serverurl; ?>';
</script>
<script src="js/gafete.js"></script>
