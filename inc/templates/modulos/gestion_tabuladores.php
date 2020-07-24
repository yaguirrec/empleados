<div class="card-body">
    <div class="card-header py-3">
        <h2 class="m-0 font-weight-bold text-secondary text-center text-uppercase seccionTitulo"></h2>
    </div>

    <div class="seccionTabuladores">
        <button class="btn btn-success btn-lg m-4 btn-nuevo-registro" id="btnnvoTab"><i class="fas fa-briefcase"></i> Nuevo tabulador</button>

        <div class="table-responsive tablaTabuladores">
            <table class="table table-sm table-bordered table-hover bg-gray-200 text-uppercase" cellspacing="4">
            
                <thead class="font-weight-bold">
                    <tr>
                    <th scope="col">ID</th>
                    <th scope="col">CODIGO</th>
                    <th scope="col">SD</th>
                    <th scope="col">SDI</th>
                    <th scope="col">SUELDO</th>
                    <th scope="col">P ASISTENCIA</th>
                    <th scope="col">P PUNTUALIDAD</th>
                    <th scope="col">DESPENSA</th>
                    <th scope="col">F AHORRO</th>
                    <th scope="col">PERCEPCION</th>
                    <th scope="col">IMSS</th>
                    <th scope="col">ISPT</th>
                    <th scope="col">SUELDO NETO</th>
                    <th scope="col">FECHA CREACION</th>
                    <th scope="col">CREADO POR</th>
                    <th scope="col">FECHA ACTUALIZADO</th>
                    <th scope="col">ACTUALIZADO</th>
                    <th scope="col">ACCION</th>
                    </tr>
                </thead>
                <tbody id="tableTabulador">
                </tbody>
            </table>

            <div class="alert alert-danger d-none text-uppercase text-center h4" id="alertaM" role="alert">
            No hay información disponible.
            </div>
        </div>
    </div>

    <!-- NUEVO TABULADOR -->
    <div class="agregarTabulador d-none mt-4">
        <div class="card-header py-3">
            <h2 class="m-0 font-weight-bold text-secondary text-center text-uppercase">Agregar Nuevo Tabulador</h2>
        </div>
        <div class="card">
            <h3 class="card-title text-center mt-4">
                Nuevo registro
            </h3>
        </div>
        <div class="card-text p-4">
            <div class="row">
                <div class="col">
                    <label for="categoriaTAB">Categoria</label>
                    <input type="text" class="form-control" id="categoriaTAB" placeholder="Categoria">
                </div>
                <div class="col">
                    <label for="sdTAB">SD</label>
                    <input type="number" step="000.00" class="form-control" id="sdTAB" placeholder="SD">
                </div>
                <div class="col">
                    <label for="sdiTAB">SDI</label>
                    <input type="number" step="000.00" class="form-control" id="sdiTAB" placeholder="SDI">
                </div>
                <div class="col">
                    <label for="sueldoTAB">Sueldo</label>
                    <input type="number" step="000.00" class="form-control" id="sueldoTAB" placeholder="Sueldo">
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="asistenciaTAB">Premio asistencia</label>
                    <input type="number" step="000.00" class="form-control" id="asistenciaTAB" placeholder="Premio asistencia">
                </div>
                <div class="col">
                    <label for="puntualidadTAB">Premio puntualidad</label>
                    <input type="number" step="000.00" class="form-control" id="puntualidadTAB" placeholder="Premio puntualidad">
                </div>
                <div class="col">
                    <label for="despensaTAB">Despensa</label>
                    <input type="number" step="000.00" class="form-control" id="despensaTAB" placeholder="Despensa">
                </div>
                <div class="col">
                    <label for="ahorroTAB">Fondo de ahorro</label>
                    <input type="number" step="000.00" class="form-control" id="ahorroTAB" placeholder="Fondo de ahorro">
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="percepcionesTAB">Percepciones</label>
                    <input type="number" step="000.00" class="form-control" id="percepcionesTAB" placeholder="Percepciones">
                </div>
                <div class="col">
                    <label for="imssTAB">IMSS</label>
                    <input type="number" step="000.00" class="form-control" id="imssTAB" placeholder="IMSS">
                </div>
                <div class="col">
                    <label for="isptTAB">ISPT</label>
                    <input type="number" step="000.00" class="form-control" id="isptTAB" placeholder="ISPT">
                </div>
                <div class="col">
                    <label for="sueldoTAB">Sueldo neto</label>
                    <input type="number" step="000.00" class="form-control" id="sueldoTAB" placeholder="Sueldo neto">
                </div>
            </div>
        </div>
        <div>
            <button class="btn btn-success btn-block btn-sm btnguardarTAB">Guardar</button>
            <button class="btn btn-warning btn-block btn-sm btnregresarTAB">Regresar</button>
        </div>
    </div>

    <!-- Formulario agregarTabulador -->
    <div class="editarTabulador d-none mt-4">
        <div class="card-header py-3">
            <h2 class="m-0 font-weight-bold text-secondary text-center text-uppercase">Editar Tabulador</h2>
        </div>
        <div class="card">
            <h3 class="card-title text-center mt-4">
                Editar registro
            </h3>
        </div>
        <div class="card-text p-4">
            <div class="row">
                <div class="col">
                    <label for="categoriaTAB">Categoria</label>
                    <input type="text" class="form-control" id="categoriaTAB" placeholder="Categoria">
                </div>
                <div class="col">
                    <label for="sdTAB">SD</label>
                    <input type="number" step="000.00" class="form-control" id="sdTAB" placeholder="SD">
                </div>
                <div class="col">
                    <label for="sdiTAB">SDI</label>
                    <input type="number" step="000.00" class="form-control" id="sdiTAB" placeholder="SDI">
                </div>
                <div class="col">
                    <label for="sueldoTAB">Sueldo</label>
                    <input type="number" step="000.00" class="form-control" id="sueldoTAB" placeholder="Sueldo">
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="asistenciaTAB">Premio asistencia</label>
                    <input type="number" step="000.00" class="form-control" id="asistenciaTAB" placeholder="Premio asistencia">
                </div>
                <div class="col">
                    <label for="puntualidadTAB">Premio puntualidad</label>
                    <input type="number" step="000.00" class="form-control" id="puntualidadTAB" placeholder="Premio puntualidad">
                </div>
                <div class="col">
                    <label for="despensaTAB">Despensa</label>
                    <input type="number" step="000.00" class="form-control" id="despensaTAB" placeholder="Despensa">
                </div>
                <div class="col">
                    <label for="ahorroTAB">Fondo de ahorro</label>
                    <input type="number" step="000.00" class="form-control" id="ahorroTAB" placeholder="Fondo de ahorro">
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="percepcionesTAB">Percepciones</label>
                    <input type="number" step="000.00" class="form-control" id="percepcionesTAB" placeholder="Percepciones">
                </div>
                <div class="col">
                    <label for="imssTAB">IMSS</label>
                    <input type="number" step="000.00" class="form-control" id="imssTAB" placeholder="IMSS">
                </div>
                <div class="col">
                    <label for="isptTAB">ISPT</label>
                    <input type="number" step="000.00" class="form-control" id="isptTAB" placeholder="ISPT">
                </div>
                <div class="col">
                    <label for="sueldoTAB">Sueldo neto</label>
                    <input type="number" step="000.00" class="form-control" id="sueldoTAB" placeholder="Sueldo neto">
                </div>
            </div>
        </div>
        <div>
            <button class="btn btn-secondary btn-block btn-sm btnactualizarTAB">Actualizar</button>
            <button class="btn btn-warning btn-block btn-sm btnregresarTAB">Regresar</button>
        </div>
    </div>

   

</div>