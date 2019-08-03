<h2 class="text-center mb-1">Nuevo Puesto</h2>
<br>
<form action="" id="form_nPuesto">
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="txttPuesto">Tipo de puesto</label>
            <select class="form-control" id="txttPuesto">
                <option value="0" selected required>Selecciona un nivel</option>
                <option value="1">Director</option>
                <option value="2">Subdirector</option>
                <option value="3">Gerente</option>
                <option value="4">Jefe</option>
                <option value="5">Coordinador</option>
            </select>
        </div>
        <div class="form-group col-md-4">
            <label for="txtnPuesto">Nombre del puesto</label>
            <input type="text" class="form-control" id="txtnPuesto" placeholder="Nombre del puesto">
        </div>
        <div class="form-group col-md-4">
            <label for="txtnCelula">Departamento</label>
            <input type="text" class="form-control" id="txtnCelula" placeholder="Nombre del departamento">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="txtdPuesto">Descripción del puesto</label>
            <textarea class="form-control" id="txtdPuesto" aria-label="With textarea" placeholder="Comentarios adicionales" style="resize:none"></textarea>
        </div>
    </div>
</form>

<button class="btn btn-lg btn-block btn-info" id="btnGuardar"><i class="fas fa-save"></i> Guardar</button>
<button class="btn btn-lg btn-block btn-danger" id="btnCancelar"><i class="fas fa-times"></i> Cancelar</button>
