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
                    <button class="btn btn-primary btn-block" id="btnConsultaAltas" role="button"><i class="fas fa-search"></i> CONSULTAR</button>
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
                    <th width="3%"><i class="fas fa-check-square"></i></th>
                    <th scope="col">Nómina</th>
                    <th scope="col">NSS</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">S.D.I.</th>
                    <th scope="col">Departamento</th>
                    <th scope="col">Planta</th>
                    <th scope="col">Alta</th>
                    <th scope="col">Reg Patronal</th>
                    <th scope="col">Nomina</th>
                    <th scope="col">Acuse</th>
                    <th scope="col">Procesada</th>
                </tr>
            </thead>
            <tbody id="dataTable">

            </tbody>
            </table>

            <div class="alert alert-danger d-none text-uppercase text-center h4" id="alertaM" role="alert">
                <p>No hay información disponible de la fecha seleccionada.</p>
            </div>
            <hr>

            <div class="col-md-2 offset-5">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-info mr-1" id="radioAcuse"><i class="fas fa-file-import"></i> Acuse de Altas</button>
                    <button type="button" class="btn btn-success" id="radioProcesada"><i class="fas fa-file-export"></i> Procesadas IMSS</button>
                </div>
            </div>

            <br><br>
            <div class="col-md-10 offset-1">
                <div class="col-md-5 d-none" id="divAcuses">
                    <div class="form-group">
                        <label class="h3" for="txtAcuse">Acuse de alta</label>
                        <input type="file" class="form-control-file" id="txtAcuse">
                    </div>
                    <button class="btn btn-info" id="btnEnviarAcuse" accept="application/pdf,application/vnd.ms-excel"><i class="fas fa-file-upload"></i> SUBIR ACUSE</button>
                </div>
                <div class="col-md-5 offset-8 d-none" id="divProcesadas">
                    <div class="form-group">
                        <label class="h3" for="txtProcesada">Procesada de altas</label>
                        <input type="file" class="form-control-file" id="txtProcesada">
                    </div>
                    <button class="btn btn-success" id="btnEnviarProcesada" accept="application/pdf,application/vnd.ms-excel"><i class="fas fa-file-upload"></i> SUBIR PROCESADA</button>
                </div>
            </div>
        

           <div class="col-md-8 offset-2 d-none" id="seccionEnvioAltas">
                <button class="btn btn-success btn-block" id="btnEnviarAltas"><i class="fas fa-paper-plane"></i> ENVIAR</button>
            </div>

    </div>
  </div>
</div>