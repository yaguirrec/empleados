    <div class="col-md-12">
        <h2>Baja de empleado</h2>
        <hr>
        <div class="row">
            <div class="col-sm"><p id="txtNomina"></p></div>
            <div class="col-sm"><p id="txtNombre"></p></div>
            <div class="col-sm"><p id="txtSucursal"></p></div>
            <div class="col-sm"><p id="txtAlta"></p></div>
        </div>

        <form>
            <div class="bg-gradient-secondary p-5 text-white text-center rounded-right">
                <h1>FORMULARIO DE BAJA</h1>
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <label for="txtFechaBaja">Fecha de baja</label>
                        <input type="date" class="form-control" id="txtFechaBaja" value="<?php echo date("Y-m-d"); ?>">
                    </div>
                    <div class="form-group col-md-5">
                        <label for="txtClasificacion">Clasificación de la baja</label>
                        <select class="form-control" id="txtClasificacion"></select>
                    </div>
                    <div class="form-group col-md-5">
                        <label for="txtMotivo">Motivo de la baja</label>
                        <select class="form-control" id="txtMotivo"></select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="txtExplicacion">Explicación de la baja</label>
                        <select class="form-control" id="txtExplicacion"></select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <div class="custom-control custom-checkbox mr-sm-2">
                            <input type="checkbox" class="custom-control-input text-danger" id="cbReingreso">
                            <label class="custom-control-label" for="cbReingreso">No permitir el reingreso del empleado?</label>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="txtComentario">Comentarios</label>
                        <textarea class="form-control" id="txtComentario" rows="3">Dado de baja en laborales.</textarea>
                    </div>
                </div>
                <hr>
                <button class="btn btn-primary btn-block" id="btnBajaEmpleado">DAR DE BAJA <i class="fas fa-user-slash"></i></button>
                <br>
                <a href="javascript:history.back();" class="btn btn-danger btn-block px-5">CANCELAR <i class="fas fa-times"></i></a>
            </div>
        </form>

        </div>

        