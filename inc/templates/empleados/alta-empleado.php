<div class="validaCurp">
    <div class="row">
        <div class="col-md-10 offset-1">
            <h1>Validar CURP</h1>
            <hr>
            <form>
                <p>Ingresar CURP del empleado para validar existencia en el sistema.</p>
                <div class="form-group row">
                    <label for="campo-curp" class="col-sm-2 col-form-label">CURP</label>
                    <div class="col-md-10">
                    <input type="text" class="form-control" id="campo-curp" placeholder="CURP" maxlength="18" minlength="18" autofocus>
                    </div>
                </div>
                
                <div class="form-group row seccion-validar">
                    <div class="col-md-12">
                    <button type="submit" class="btn btn-primary btn-block" id="btnValidar">Verificar <i class="fas fa-check"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="altaEmpleado">
    <div class="row">
        <div class="col-md-10 offset-1">
            <h1>Nuevo empleado</h1>
            <hr>
            <?php include 'inc/templates/empleados/nuevo.php'; ?>
        </div>
    </div>
</div>

<!-- <div class="editarEmpleado">
    <div class="row">
        <div class="col-md-10 offset-1">
            <h1>Reingreso de empleado</h1>
        </div>
    </div>
</div> -->