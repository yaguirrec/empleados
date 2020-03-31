<div class="card">
    <h3 class="card-title text-center mt-4">
        Seguimiento a Alta
    </h3>
    <div class="card-text p-4">
        <div class="row">
            <div class="col">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input mt-4" id="segComision">
                    <label class="custom-control-label" for="segComision"><strong>Comisión</strong></label>
                </div>
            </div>
            <div class="col">
                <label for="segSucursal">Sucursal</label>
                <select class="form-control" id="segSucursal" disabled="disabled">
                </select>
            </div>
            <div class="col">
                <label for="segDaltonismo">Daltonismo</label>
                <input type="text" class="form-control" id="segDaltonismo" placeholder="Daltonismo">
            </div>
            <div class="col">
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
                <label for="segGuia">Guia</label>
                <input type="text" class="form-control" id="segGuia" placeholder="Guia">
            </div>
        </div>
        <div class="row mt-1">
            <div class="col">
                <label for="segFechaentregapersonal">Entrega de personal</label>
                <input type="date" class="form-control" id="segFechaentregapersonal" placeholder="Entrega de personal">
            </div>
            <div class="col">
                <label for="segFechafincontrato">Fin de contrato</label>
                <input type="date" class="form-control" id="segFechafincontrato" placeholder="Fin de contrato" disabled="disabled">
            </div>
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
