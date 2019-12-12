<div class="row mx-2">
    <div class="col-md-12">
        <!-- SECCION TABLA ROLES -->
        <div class="lista-roles">
            <h1 class="header text-center">Listado de roles <i class="fas fa-user-tag"></i></h1>
            <div class="table-responsive">
                <table class="table table-sm table-bordered table-hover bg-gray-300 text-center text-uppercase" cellspacing="4">
                    <thead class="font-weight-bold">
                        <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Permiso</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Accion</th>
                        </tr>
                    </thead>
                    <tbody id="tableRoles">
                    </tbody>
                </table>
            </div>
        </div>

        <!-- SECCION ROL SELECCIONADO -->
        <div class="rol-selecionado d-none">
            <h1 class="header text-center">Rol <i class="fas fa-user-tag"></i></h1>
            <div class="row">
                <div class="col-sm d-none"><p id="txtidRol"></p></div>
                <div class="col-sm"><p id="txtRol"></p></div>
                <div class="col-sm"><p id="txtFechaRol"></p></div>
                <div class="col-sm"><p id="txtRolDescripcion"></p></div>
            </div>
            <div class="row">
                <!-- <div class="col-sm"><p id="txtRolDescripcion"></p></div> -->
            </div>
            <div class="row mb-3">
                <a class="btn btn-info btn-sm text-white" id="asignarRol" role="button">Asignar Rol <i class="fas fa-plus-circle"></i></a>
                <a class="btn btn-warning btn-sm text-white ml-4" id="cancelarRol" role="button">Regresar <i class="fas fa-arrow-circle-left"></i></a>
            </div>

            <div class="row empleadoRol d-none mb-4">
                <div class="col-md-4 offset-4">
                    <h1>Agregar empleado al rol</h1>
                    <!--<select class="form-control" id="txtDatosEmpleado"></select>-->
                    <input type="text" list="txtDatosEmpleado" place-holder="Ingresar empleado" id="txtNombreEmpleado" class="form-control">
                    <datalist id="txtDatosEmpleado"></datalist>
                    <button class="btn btn-success btn-block mt-2" id='btnAgregarEmpleadoRol'>Agregar <i class="fas fa-user-plus"></i></button>
                </div>
            </div>

            <div class="row">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-hover bg-gray-300 text-center text-uppercase" cellspacing="4">
                        <thead class="font-weight-bold">
                            <tr>
                            <th scope="col">Nomina</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Status</th>
                            <th scope="col">Sucursal</th>
                            <th scope="col">Departamento</th>
                            <th scope="col">Fecha asiganado</th>
                            <th scope="col">Asiganado por</th>
                            <th scope="col">Accion</th>
                            </tr>
                        </thead>
                        <tbody id="tableRolEmployee">
                        </tbody>
                    </table>
                </div>  
            </div>
        </div>

    </div>
</div>