<style>
/* This text is in Century Gothic */
.class { 
	font-family: Century Gothic,CenturyGothic,AppleGothic,sans-serif; 
}

@media print {
.noprint{display:none; }

 @page { margin: 0;size: portrait;}
}

</style>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<div class="row mb-5">

<div id='front'>
<img src="img/gafete/gafete.png" style="margin-left: 3.8px;width:5.9cm;height:9.2cm;position: absolute; z-index: 1;">

<img  class='img-circle' style="height:3.8cm; width:3.8cm; border-radius: 94%; position: absolute;z-index: 2;top:3.4cm;left:.76cm;" id="empFoto" alt="Foto"> 
<center>
<p style="position: absolute; 
text-align: center;
left:0.15cm; 
width: 5.4cm; 
top:7.5cm;
color:#052467;
font-size:9.5px;
z-index: 3;" id="empNombre">
<!-- Mi nombre -->
</p>
</center>
<center>
<p style="position: absolute; 
text-align: center;
left:0.15cm; 
width: 5.4cm; 
top:7.88cm;
font-weight: bold;
z-index: 4; 
font-size:9px;
color:#009743;" id="empPuesto">
 <!-- Mi Puesto -->
</p>
</center>

<center>
<p style="position: absolute;
left:0.15cm;  
top:8.58cm; 
z-index: 5;
color:#052467;
text-align: center;
width: 5.4cm;
font-size:8.5px;" id="empAlta">
<!-- Ingreso : 20/02/2012     -->
</p>
</div>
<div id="back">
</center>
 <img  name="back" src="img/gafete/reverso.png" 
 style="margin-left: 15px;width:5.9cm;height:8.9cm;position: 
 absolute; z-index: 6;top:9.4cm;border-left: 
 dotted #000 1px;transform:rotate(180deg);
-ms-transform:rotate(180deg); /* IE 9 */
-webkit-transform:rotate(180deg); /* Opera, Chrome, and Safari */"> 

<p style="
position: absolute; 
text-align: left;
left: 0.09cm;
width: 5cm;
font-weight: bold;
font-size: 7.6px;
z-index: 7;
top:17.2cm;
color:#052467;
transform:rotate(180deg);
-ms-transform:rotate(180deg); /* IE 9 */
-webkit-transform:rotate(180deg);" id="empNS">
<!-- No.IMSS: ##### -->
</p>

<p style="position: absolute; 
text-align: right;
width: 5cm; 
font-weight: bold;
font-size: 7.6px;
z-index: 7;
left: .70cm; 
top:17.2cm;
color:#052467;
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
top:11.9cm;
font-size: 9px;
z-index: 9;
left: 1.2cm;
color:#279b60;" id="empDireccion">
<!-- Mi direccion -->
</p>
</center>

<center>
<img
 style="transform:rotate(180deg);
-ms-transform:rotate(180deg); /* IE 9 */
-webkit-transform:rotate(180deg);
position: absolute;
text-align: center;
width: 4.5cm;
height: 1.5cm; 
top:10.3cm;z-index: 10;
left: 0.7cm;" 
 alt='MEXQ' id="empNomina"/>
 <svg id="barcode"></svg>
</center>
</div>
<br>
</div class="seccionBotonImprimir">
    <a class="btn btn-lg btn-success botonImprimir" id="btnPrint" style="position: absolute; width: 3.2cm;top:19.4cm;font-size:12px;z-index: 12;left: 1cm;">IMPRIMIR</a>
</div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/jsbarcode/3.6.0/barcodes/JsBarcode.code128.min.js"></script>

<script src="js/gafete.js"></script>
