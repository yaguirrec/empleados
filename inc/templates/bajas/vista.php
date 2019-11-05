<div class="row m-4">
    <div class="col-md-12">
        <h1 class="text-center">Envio de bajas</h1>
        <hr>
        <form class="text-center offset-5">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="txtFechaBajas">Fecha de Bajas</label>
                    <input type="date" class="form-control" id="txtFechaBajas" value="<?php echo date("Y-m-d");?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <button class="btn btn-primary btn-block" id="btnConsultaBajas" role="button"><i class="fas fa-search"></i> CONSULTAR</button>
                </div>
            </div>
        </form>
    </div>
    <br>
    <div class="col-md-12">
        <h2 class="text-center">Bajas de la fecha</h2>
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
                    <th width="3%"><i class="fas fa-check-square"></i></th>
                    <th scope="col">Nómina</th>
                    <th scope="col">NSS</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">S.D.I.</th>
                    <th scope="col">Sucursal</th>
                    <th scope="col">Planta</th>
                    <th scope="col">Baja</th>
                    <th scope="col">Reg Patronal</th>
                    <th scope="col">Nomina</th>
                    <th scope="col">Motivo Baja</th>
                    <th scope="col">Acuse Baja</th>
                    <th scope="col">Procesada Baja</th>
                </tr>
            </thead>
            <tbody id="dataTable">

            </tbody>
            </table>

            <div class="alert alert-danger d-none text-uppercase text-center h4" id="alertaM" role="alert">
                <p>No hay información disponible de la fecha seleccionada.</p>
            </div>

            <hr>

            <div class="col-md-2">
                <!-- <button type="button" class="btn btn-primary mr-1" id="btnFechaBaja"><i class="fas fa-file-import"></i> Cambiar Fecha de Baja</button> -->
            </div>

            <div class="d-none" id="seccionAcuseAltas">
                <div class="col-md-2 offset-5">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-info mr-1" id="radioAcuseBaja"><i class="fas fa-file-import"></i> Acuse de Bajas</button>
                        <button type="button" class="btn btn-success" id="radioProcesadasBaja"><i class="fas fa-file-export"></i> Procesadas de Bajas</button>
                    </div>
                </div>

                <br><br>
                <div class="col-md-10 offset-1">
                    <div class="col-md-5 d-none" id="divAcusesBaja">
                        <div class="form-group">
                            <label class="h3" for="txtAcuseBaja">Acuse de baja</label>
                            <input type="file" class="form-control-file" id="txtAcuseBaja">
                        </div>
                        <button class="btn btn-info" id="btnEnviarAcuseBaja" accept="application/pdf,application/vnd.ms-excel"><i class="fas fa-file-upload"></i> SUBIR ACUSE DE BAJA</button>
                    </div>
                    <div class="col-md-5 offset-8 d-none" id="divProcesadasBaja">
                        <div class="form-group">
                            <label class="h3" for="txtProcesadaBaja">Procesada de baja</label>
                            <input type="file" class="form-control-file" id="txtProcesadaBaja">
                        </div>
                        <button class="btn btn-success" id="btnEnviarProcesadaBaja" accept="application/pdf,application/vnd.ms-excel"><i class="fas fa-file-upload"></i> SUBIR PROCESADA DE BAJA</button>
                    </div>
                </div>
            </div>
        

           <div class="col-md-8 offset-2 d-none" id="seccionEnvioAltas">
                <button class="btn btn-success btn-block" id="btnEnviarBajas"><i class="fas fa-paper-plane"></i> ENVIAR BAJAS</button>
            </div>

    </div>
  </div>
</div>