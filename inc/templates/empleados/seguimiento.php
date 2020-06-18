<div class="card">
    <h3 class="card-title text-center mt-4">
        Seguimiento a Alta
    </h3>
    <div class="card-text p-4">
        <div class="row">
            <div class="col fOperaciones">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input mt-4" id="segComision">
                    <label class="custom-control-label" for="segComision"><strong>Comisión</strong></label>
                </div>
            </div>

            <div class="col fOperaciones">
                <label for="segFechaLlegada">Llegada a Ags*</label>
                <input type="date" class="form-control" id="segFechaLlegada" disabled="disabled">
            </div>

            <div class="col fOperaciones">
                <label for="segChecklist">Fecha checklist (Comisión)</label>
                <input type="date" class="form-control" id="segChecklist" disabled="disabled">
            </div>

            <div class="col fOperaciones">
                <label for="segSucursal">Sucursal</label>
                <select class="form-control" id="segSucursal" disabled="disabled">
                </select>
            </div>

            <div class="col fOperaciones">
                <label for="segPoliticas">Politicas*</label>
                <select class="form-control" id="segPoliticas" disabled="disabled">
                    <option value="PENDIENTE">Pendiente</option>
                    <option value="OK">OK</option>
                    <option value="N/A">N/A</option>
                    <option value="BAJA">BAJA</option>
                </select>
            </div>

            <div class="col fOperaciones">
                <label for="segReglamento">Reglamento*</label>
                <select class="form-control" id="segReglamento" disabled="disabled">
                    <option value="PENDIENTE">Pendiente</option>
                    <option value="OK">OK</option>
                    <option value="N/A">N/A</option>
                    <option value="BAJA">BAJA</option>
                </select>
            </div>

            <div class="col fOperaciones">
                <label for="segCarta">Carta responsiva*</label>
                <select class="form-control" id="segCarta" disabled="disabled">
                    <option value="PENDIENTE">Pendiente</option>
                    <option value="OK">OK</option>
                    <option value="N/A">N/A</option>
                    <option value="BAJA">BAJA</option>
                </select>
            </div>

            
            <div class="col fOperaciones">
                <label for="segDaltonismo">Daltonismo</label>
                <input type="text" class="form-control" id="segDaltonismo" placeholder="Daltonismo">
            </div>
            <div class="col fOperaciones">
                <label for="segAgudeza">Agudeza Visual</label>
                <input type="text" class="form-control" id="segAgudeza" placeholder="Agudeza Visual">
            </div>
        </div>
        <div class="row mt-1">
            <div class="col">
                <label for="segTarjeta">Numero de tarjeta</label>
                <input type="text" class="form-control" id="segTarjeta" placeholder="Numero de tarjeta">
            </div>
            <div class="col">
                <label for="segFechatarjeta">Entrega de tarjeta</label>
                <input type="date" class="form-control" id="segFechatarjeta" placeholder="Entrega de tarjeta">
            </div>
            <div class="col">
                <label for="segFechacontrato">Entrega de contrato</label>
                <input type="date" class="form-control" id="segFechacontrato" placeholder="Entrega de contrato">
            </div>

            <div class="col">
                <label for="segContrato">Contrato*</label>
                <select class="form-control" id="segContrato">
                    <option value="PENDIENTE">Pendiente</option>
                    <option value="OK">OK</option>
                    <option value="N/A">N/A</option>
                    <option value="BAJA">BAJA</option>
                </select>
            </div>

            <div class="col">
                <label for="segDGP">DGP*</label>
                <select class="form-control" id="segDGP">
                    <option value="PENDIENTE">Pendiente</option>
                    <option value="OK">OK</option>
                    <option value="N/A">N/A</option>
                    <option value="BAJA">BAJA</option>
                </select>
            </div>

            <div class="col fOperaciones">
                <label for="segJefe">Jefe directo*</label>
                <input type="text h6" class="form-control" id="segJefe" readonly>
            </div>

            <div class="col">
                <label for="segGuia">Guia</label>
                <input type="text" class="form-control" id="segGuia" placeholder="Guia">
            </div>
        </div>
        <div class="row mt-1">
            
            <div class="col">
                <label for="segDisciplica">5 basicos y codigo de disciplina*</label>
                <select class="form-control" id="segDisciplica">
                    <option value="PENDIENTE">Pendiente</option>
                    <option value="OK">OK</option>
                    <option value="N/A">N/A</option>
                    <option value="BAJA">BAJA</option>
                </select>
            </div>

            <div class="col">
                <label for="segEtica">Codigo de Etica*</label>
                <select class="form-control" id="segEtica">
                    <option value="PENDIENTE">Pendiente</option>
                    <option value="OK">OK</option>
                    <option value="N/A">N/A</option>
                    <option value="BAJA">BAJA</option>
                </select>
            </div>

            <div class="col fOperaciones">
                <label for="segFechaentregapersonal">Entrega de personal a planta</label>
                <input type="date" class="form-control" id="segFechaentregapersonal" placeholder="Entrega de personal">
            </div>

            <div class="col">
                <label for="segFechaentregachecklist">Checklist Laborales</label>
                <input type="date" class="form-control" id="segFechaentregachecklist">
            </div>

            <div class="col">
                <label for="segFechafincontrato">Fin de contrato</label>
                <input type="date" class="form-control" id="segFechafincontrato" placeholder="Fin de contrato" disabled="disabled">
            </div>

            <div class="col">
                <label id="lsegEntregaOp" for="segEntregaOp">Entrega a operaciones*</label>
                <select class="form-control" id="segEntregaOp">
                    <option value="PENDIENTE">Pendiente</option>
                    <option value="NO">No se entrego</option>
                    <option value="SI">Entregado</option>
                </select>
            </div>

            <div class="col d-none" id="segEntregaFechacol">
                <label id="lsegEntregaFecha" for="segEntregaFecha">Fecha Entrega Operaciones</label>
                <input type="date" class="form-control" id="segEntregaFecha">
            </div>

        </div>
        <div class="row">
            <label for="segComentario">Comentarios</label>
            <textarea class="form-control" id="segComentario" rows="3">Seguimiento de alta en laborales.</textarea>
        </div>
        <hr>
        <div class="row mt-4">
            <div class="col">
                <button class="btn btn-block btn-success" id="btnSalvarseguimiento" role="button">Guardar información</button>
            </div>
            <div class="col">
                <button class="btn btn-block btn-warning" id="btncerrarSeguimiento" role="button">Cancelar</button>
            </div>
            
        </div>
    </div>
</div>
