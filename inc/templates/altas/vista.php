<div class="row m-4">
    <div class="col-md-12">
        <h1 class="text-center">Envio de altas</h1>
        <hr>
        <form class="text-center offset-5">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="txtfechaAlta">Fecha de Altas</label>
                    <input type="date" class="form-control" id="txtFechaAltas" value="<?php echo date("Y-m-d");?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <button class="btn btn-primary btn-block" id="btnConsultaAltas">CONSULTAR</button>
                </div>
            </div>
        </form>
    </div>
    <br>
    <div class="col-md-12">
        <h2 class="text-center">Altas de la fecha</h2>
        <br>
        <div class="col-md-10 offset-1">
            <h3 class="text-center">Reporte</h3>
        </div>
    </div>
</div>
<div class="row m-4">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-sm table-bordered table-hover bg-gray-200 text-center text-uppercase" cellspacing="4">
            
            <thead class="font-weight-bold">
                <tr>
                    <th scope="col">Nómina</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Puesto</th>
                    <th scope="col">Fecha Alta</th>
                    <th scope="col">Sucursal</th>
                    <th scope="col">Area</th>
                </tr>
            </thead>
            <tbody id="dataTable">
            </tbody>
            </table>

            <div class="col-md-8 offset-2 seccionEnvioAltas d-none">
                <button class="btn btn-success btn-block" id="btnEnviarAltas">ENVIAR</button>
            </div>

            <div class="alert alert-danger d-none text-uppercase text-center h4" id="alertaM" role="alert">
                <p>No hay información disponible de la fecha seleccionada.</p>
            </div>
    </div>
  </div>
</div>