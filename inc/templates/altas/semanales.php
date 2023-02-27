<div class="row mx-4">
    <div class="col-md-12">
        <h1 class="text-center">Altas semanales</h1>
    </div>
</div>
<div class="row mx-4">
    <div class="col-md-12">
        <form class="text-center">
            <div class="form-row">
                <div class="form-group col-md-3 offset-1">
                    <label for="txtfechaAlta">Fecha de Inicio</label>
                    <input type="date" class="form-control text-center" id="txtFechaINI" value="<?php echo date("Y-m-d", strtotime('-7 days'));?>">
                </div>
    
                <div class="form-group col-md-3 offset-1">
                    <label for="txtfechaAlta">Fecha de Final</label>
                    <input type="date" class="form-control text-center" id="txtFechaFIN" value="<?php echo date("Y-m-d");?>">
                </div>
                <div class="form-group col-md-2 offset-1">
                    <label for="" class="text-hide">......</label>
                    <button class="btn btn-info btn-block mt-1" id="btnMostrarAltas" role="button">Mostrar <i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>
    </div>
</div>
<hr>
<div class="row mx-4">
    <div class="col-md-12">
        <h2 class="text-center text-uppercasw" id="txtPeriodo">

        </h2>
    </div>
</div>
<div class="row mx-4">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-sm table-bordered table-hover bg-gray-200 text-center text-uppercase" cellspacing="4">
            
            <thead class="font-weight-bold">
                <tr>
                    <th scope="col">Clave Sucursal</th>
                    <th scope="col">Sucursal</th>
                    <th scope="col">Planta</th>
                    <th scope="col" class="d-none">Clave Socio</th>
                    <th scope="col">Fecha Alta</th>
                    <th scope="col" class="d-none">Tabulador</th>
                    <th scope="col" class="d-none">Puesto</th>
                    <th scope="col" class="d-none">Clasificacion</th>
                    <th scope="col" class="d-none">Nomina</th>
                    <th scope="col" class="d-none">Registro Patronal</th>
                    <th scope="col" class="d-none">Categoria</th>
                    <th scope="col" class="d-none">Salario Mensual</th>
                    <th scope="col" class="d-none">Lote</th>
                    <th scope="col" class="d-none">Estado</th>
                    <th scope="col">Numero Nomina</th>
                    <th scope="col">Apellido Paterno</th>
                    <th scope="col">Apellido Materno</th>
                    <th scope="col">Nombres</th>
                    <th scope="col">Fecha Nacimiento</th>
                    <th scope="col" class="d-none">Lugar Nacimiento</th>
                    <th scope="col" class="d-none">Sexo</th>
                    <th scope="col">Clasificacion reclutado</th>
                    <th scope="col">Reclutado</th>
                    <th scope="col">RFC</th>
                    <th scope="col">CURP</th>
                    <th scope="col" class="d-none">NSS</th>
                    <th scope="col" class="d-none">Identificacion</th>
                    <th scope="col" class="d-none">Estado civil</th>
                    <th scope="col" class="d-none text-capitalize">Escolaridad</th>
                    <th scope="col" class="d-none">Nombre Padre</th>
                    <th scope="col" class="d-none">Nombre Madre</th>
                    <th scope="col" class="d-none">Calle</th>
                    <th scope="col" class="d-none">Numero exterior</th>
                    <th scope="col" class="d-none">Numero interior</th>
                    <th scope="col" class="d-none">Fraccionamiento</th>
                    <th scope="col" class="d-none">CP</th>
                    <th scope="col" class="d-none">Localidad</th>
                    <th scope="col" class="d-none">Municipio</th>
                    <th scope="col" class="d-none">Estado</th>
                    <th scope="col" class="d-none">Cuenta bancaria</th>
                    <th scope="col" class="d-none">Numero cuenta bancaria</th>
                    <th scope="col" class="d-none">Infonavit</th>
                    <th scope="col" class="d-none">Numero Infonavit</th>
                    <th scope="col" class="d-none">Fonacot</th>
                    <th scope="col" class="d-none">Numero Fonacot</th>
                    <th scope="col" class="d-none">Correo</th>
                    <th scope="col" class="d-none">Celular</th>
                    <th scope="col" class="d-none">Telefono</th>
                </tr>
            </thead>
            <tbody id="dataTable">
            </tbody>
            </table>

           
            <div class="alert alert-danger d-none text-uppercase text-center h4" id="alertaM" role="alert">
                <p>No hay información disponible de la fecha seleccionada.</p>
            </div>
    </div>
  </div>
</div>