<div class="row">
    <div class="col-md-12">
        <h1 class="text-center">Reingreso de empleado</h1>
        <h2 class="text-center" id="nominaEmpleado"></h2>
    </div>
</div>
<div class="row">
    <div class="col-md-10 offset-1">
        <form id="updateForm">
            <div class="bg-gradient-success p-5 text-white text-center rounded-right">
                <h1>DATOS DE LA EMPRESA</h1>
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <label for="txtNomina">Número de nomina</label>
                        <input type="text" class="form-control" id="txtNomina" placeholder="Nomina" readonly required>
                    </div>
                    <div class="form-group col-md-1">
                        <label for="txtTipo">Tipo</label>
                        <select class="form-control" id="txtTipo" disabled>
                            <option value="A">Alta</option>
                            <option value="R" selected>Reingreso</option>
                            <option value="B">Baja</option>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="txtLote">Número de Lote</label>
                        <input type="text" class="form-control" id="txtLote" placeholder="Lote" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtSucursal">Sucursal</label>
                        <select class="form-control" id="txtSucursal"></select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="txtClasificacion">Clasificación</label>
                        <select class="form-control" id="txtClasificacion">
                            <option value="" selected required>Selecciona una Clasificación</option>
                            <option value="A">Administrativo</option>
                            <option value="AO">Adm .Operativo</option>
                            <option value="O">Operativo</option>
                            <option value="E">Especial</option>
                            <option value="B">Becario</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <label for="txtSalarioDiario">Salario Diario</label>
                        <input type="text" class="form-control" id="txtSalarioDiario" placeholder="Salario Diario" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtSalarioMensual">Salario Mensual</label>
                        <input type="text" class="form-control" id="txtSalarioMensual" placeholder="Salario Mensual">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtTipoNomina">Nomina</label>
                        <select class="form-control" id="txtTipoNomina">
                            <option value="" selected required>Selecciona Nomina</option>
                            <option value="Q">QUIN</option>
                            <option value="S">SEM</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="txtCelula">Departamento</label>
                        <select class="form-control" id="txtCelula" required></select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="txtfechaAlta">Fecha Alta</label>
                        <input type="date" class="form-control" id="txtfechaAlta">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="txtRegistro">Registro</label>
                        <select class="form-control" id="txtRegistro" required>
                            <option value="SAC" selected>SAC</option>
                            <option value="CNO">CNO</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="txtPuesto">Puesto</label>
                        <select class="form-control" id="txtPuesto" required></select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <label for="txtTabClave">Clave Tabulador</label>
                        <input type="text" class="form-control" id="txtTabClave" minlength="3" maxlength="3">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="txtTabSucursal">Sucursal Tabulador</label>
                        <select class="form-control" id="txtTabSucursal"></select>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="txtTabNivel">Nivel Tabulador</label>
                        <select class="form-control" id="txtTabNivel">
                        <option value="" selected>Seleccione una opción</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                        <option value="E">E</option>
                        <option value="F">F</option>
                        </select>
                    </div>

                    <div class="form-group col-md-2">
                        <label for="txtReclutado">Reclutador por</label>
                        <select class="form-control text-uppercase" id="txtReclutado">
                        <option value="" selected>Seleccione una opción</option>
                        <option value="reclutador">Reclutador(a)</option>
                        <option value="recomendo">Recomendo</option>
                        <option value="outsourcing">Outsourcing</option>
                        <option value="lider_moral">Lider Moral</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <div class="form-group campoOutL  d-none">
                        <label for="txtout_lm">Nombre</label>
                        <input type="text" class="form-control" id="txtout_lm" placeholder="Ingrese Outsourcing / Lider moral...">
                        </div>
                        <div class="form-group campoRecluatdo d-none">
                        <label for="txtReclutador">Reclutado por</label>
                        <select class="form-control text-uppercase" id="txtReclutador">
                        </select>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="txtJefe">Jefe directo</label>
                        <select class="form-control text-uppercase" id="txtJefe">
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="txtComentario">Comentarios</label>
                        <textarea class="form-control" id="txtComentario" rows="3"></textarea>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-primary p-5 text-white text-center mt-5 rounded-right">
                <h1>DATOS PERSONALES</h1>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="txtNombre">Nombre(s)</label>
                        <input type="text" class="form-control text-uppercase" id="txtNombre" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="txtPaterno">Apellido Paterno</label>
                        <input type="text" class="form-control text-uppercase" id="txtPaterno" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="txtMaterno">Apellido Materno</label>
                        <input type="text" class="form-control text-uppercase" id="txtMaterno" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="txtCURP">CURP</label>
                        <input type="text" class="form-control" id="txtCURP">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="txtRFC">RFC</label>
                        <input type="text" class="form-control" id="txtRFC">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="txtNSS">NSS</label>
                        <input type="text" class="form-control" minlength="10" maxlength="10" id="txtNSS" required>
                    </div>
                    <div class="form-group col-md-1">
                        <label for="txtDV">DV</label>
                        <input type="text" class="form-control" maxlength="1" minlength="1" id="txtDV" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <label for="txtfechaNacimiento">Fecha Nacimiento</label>
                        <input type="date" class="form-control" id="txtfechaNacimiento">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="txtLnacimiento">Lugar de nacimiento</label>
                        <input type="text" class="form-control" id="txtLnacimiento">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="txtGenero">Genero</label>
                        <select class="form-control" id="txtGenero">
                            <option value="M" selected>Hombre</option>
                            <option value="F">Mujer</option>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="txtTI">Tipo Identificación</label>
                        <select class="form-control" id="txtTI">
                            <option value="IFE" selected>INE / IFE</option>
                            <option value="PASAPORTE">PASAPORTE</option>
                            <option value="CEDULA">CEDULA PROFESIONAL</option>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="txtID">Identificación</label>
                        <input type="text" class="form-control" id="txtID">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="txtCivil">Estado Civil</label>
                        <select class="form-control" id="txtCivil" required>
                            <option value="S" selected>Soltero(a)</option>
                            <option value="C">Casado(a)</option>
                            <option value="D">Divorciado(a)</option>
                            <option value="V">Viudo(a)</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="txtEscolaridad">Escolaridad</label>
                        <select class="form-control" id="txtEscolaridad">
                            <option value="primaria" selected>Primaria</option>
                            <option value="secundaria">Secundaria</option>
                            <option value="preparatoria">Preparatoria o Bachillerato</option>
                            <option value="b_tecnico">Bachillerato Técnico</option>
                            <option value="carrera_tecnica">Carrera Técnica</option>
                            <option value="tsu">Técnico Superior Universitario</option>
                            <option value="licenciatura">Licenciatura</option>
                            <option value="posgrado">Posgrado</option>
                            <option value="maestria">Maestria</option>
                            <option value="doctorado">Doctorado</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="txtStescolaridad">Constancia de escolar</label>
                        <select class="form-control" id="txtStescolaridad">
                            <option value="constancia" selected>Constancia</option>
                            <option value="boleta">Boleta</option>
                            <option value="certificado">Certificado</option>
                            <option value="titulo">Titulo</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="txtNombrePadre">Nombre padre</label>
                        <input type="text" class="form-control text-uppercase" id="txtNombrePadre" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="txtApePatPadre">Apellido Paterno Padre</label>
                        <input type="text" class="form-control text-uppercase" id="txtApePatPadre" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="txtApeMatPadre">Apellido Materno Padre</label>
                        <input type="text" class="form-control text-uppercase" id="txtApeMatPadre" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="txtNombreMadre">Nombre madre</label>
                        <input type="text" class="form-control text-uppercase" id="txtNombreMadre" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="txtApePatMadre">Apellido Paterno Madre</label>
                        <input type="text" class="form-control text-uppercase" id="txtApePatMadre" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="txtApeMatMadre">Apellido Materno Madre</label>
                        <input type="text" class="form-control text-uppercase" id="txtApeMatMadre" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="txtCalle">Calle</label>
                        <input type="text" class="form-control" id="txtCalle" required>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="txtNume">Numero exterior</label>
                        <input type="text" class="form-control" id="txtNume" required>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="txtNumi">Numero interior</label>
                        <input type="text" class="form-control" id="txtNumi">
                    </div>
                    <div class="form-group col-md-1">
                        <label for="txtCP">CP</label>
                        <input type="text" class="form-control" id="txtCP" required>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="txtEdo">Estado</label>
                        <input type="text" class="form-control" id="txtEdo">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="txtMunicipio">Municipio</label>
                        <input type="text" class="form-control" id="txtMunicipio">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="txtLocalidad">Localidad</label>
                        <input type="text" class="form-control" id="txtLocalidad">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="txtFraccionamiento">Colonia / Fraccionamiento</label>
                        <select class="form-control" id="txtFraccionamiento"></select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-1">
                        <label for="txtInfonavit">Infonavit</label>
                        <select class="form-control" id="txtInfonavit" required>
                            <option value="" selected>---</option>
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtNinfonavit">Número de infonavit</label>
                        <input type="text" class="form-control" id="txtNinfonavit" required>
                    </div>
                    <div class="form-group col-md-1">
                        <label for="txtFonacot">Fonacot</label>
                        <select class="form-control" id="txtFonacot" required>
                            <option value="" selected>---</option>
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtNfonacot">Número de fonacot</label>
                        <input type="text" class="form-control" id="txtNfonacot" required>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="txtBanco">Tarjeta</label>
                        <select class="form-control" id="txtBanco">
                        <option value="" selected>Tramitar tarjeta?</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="txtCuenta">Número de cuenta banco</label>
                        <input type="text" class="form-control" id="txtCuenta">
                    </div>
                </div>

            </div>

            <div class="bg-gradient-success p-5 text-white text-center rounded-right mt-5">
                <h2>Contacto</h2>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="txtCorreo">Correo electronico</label>
                        <input type="mail" class="form-control" id="txtCorreo" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="txtTelefono">Telefono</label>
                        <input type="text" class="form-control" id="txtTelefono" maxlength="10" minlength="10" placeholder="4499128686" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="txtCelular">Celular</label>
                        <input type="text" class="form-control" id="txtCelular" maxlength="10" minlength="10" placeholder="4499128686" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="txtContacto">Nombre contacto emergencia</label>
                        <input type="text" class="form-control" id="txtContacto" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="txtNcontacto">Número contacto de emergencia</label>
                        <input type="text" class="form-control" id="txtNcontacto" maxlength="10" minlength="10" placeholder="4499128686" required>
                    </div>
                </div>
            </div>

<div class="bg-gradient-success p-5 text-white text-center rounded-right mt-5">
    <h2>Beneficiarios</h2>
    <h4 class="mt-3">Beneficiario 1</h4>
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="txtNombreB1">Nombre completo</label>
            <input type="text" class="form-control" id="txtNombreB1" name="txtNombreB1" required>
        </div>
        <div class="form-group col-md-4">
            <label for="txtTelefonoB1">Teléfono</label>
            <input type="text" class="form-control" id="txtTelefonoB1" name="txtTelefonoB1" maxlength="10" required>
        </div>
        <div class="form-group col-md-4">
            <label for="txtCalleB1">Calle</label>
            <input type="text" class="form-control" id="txtCalleB1" name="txtCalleB1" required>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="txtNumeroExteriorB1">Número exterior</label>
            <input type="text" class="form-control" id="txtNumeroExteriorB1" name="txtNumeroExteriorB1">
        </div>
        <div class="form-group col-md-4">
            <label for="txtNumeroInteriorB1">Número interior</label>
            <input type="text" class="form-control" id="txtNumeroInteriorB1" name="txtNumeroInteriorB1">
        </div>
        <div class="form-group col-md-4">
            <label for="txtCodigoPostalB1">CP</label>
            <input type="text" class="form-control" id="txtCodigoPostalB1" maxlength="5" name="txtCodigoPostalB1" required>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="txtEstadoB1">Estado</label>
            <input type="text" class="form-control" id="txtEstadoB1" name="txtEstadoB1">
        </div>
        <div class="form-group col-md-4">
            <label for="txtMunicipioB1">Municipio</label>
            <input type="text" class="form-control" id="txtMunicipioB1" name="txtMunicipioB1">
        </div>
        <div class="form-group col-md-4">
            <label for="txtLocalidadB1">Localidad</label>
            <input type="text" class="form-control" id="txtLocalidadB1" name="txtLocalidadB1">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-8">
            <label for="txtFraccionamientoB1">Colonia / Fraccionamiento</label>
            <select class="form-control" id="txtFraccionamientoB1" name="txtFraccionamientoB1"></select>
        </div>
    </div>

    <div id="beneficiario2Container">
        <h4 class="mt-4">Beneficiario 2</h4>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="txtNombreB2">Nombre completo</label>
                <input type="text" class="form-control" id="txtNombreB2" name="txtNombreB2" required>
            </div>
            <div class="form-group col-md-4">
                <label for="txtTelefonoB2">Teléfono</label>
                <input type="text" class="form-control" id="txtTelefonoB2" name="txtTelefonoB2" maxlength="10" required>
            </div>
            <div class="form-group col-md-4">
                <label for="txtCalleB2">Calle</label>
                <input type="text" class="form-control" id="txtCalleB2" name="txtCalleB2" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="txtNumeroExteriorB2">Número exterior</label>
                <input type="text" class="form-control" id="txtNumeroExteriorB2" name="txtNumeroExteriorB2">
            </div>
            <div class="form-group col-md-4">
                <label for="txtNumeroInteriorB2">Número interior</label>
                <input type="text" class="form-control" id="txtNumeroInteriorB2" name="txtNumeroInteriorB2">
            </div>
            <div class="form-group col-md-4">
                <label for="txtCodigoPostalB2">CP</label>
                <input type="text" class="form-control" id="txtCodigoPostalB2" maxlength="5" name="txtCodigoPostalB2" required>
            </div>
        </div>
    
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="txtEstadoB2">Estado</label>
                <input type="text" class="form-control" id="txtEstadoB2" name="txtEstadoB2">
            </div>
            <div class="form-group col-md-4">
                <label for="txtMunicipioB2">Municipio</label>
                <input type="text" class="form-control" id="txtMunicipioB2" name="txtMunicipioB2">
            </div>  
            <div class="form-group col-md-4">
                <label for="txtLocalidadB2">Localidad</label>
                <input type="text" class="form-control" id="txtLocalidadB2" name="txtLocalidadB2">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-8">
                <label for="txtFraccionamientoB2">Colonia / Fraccionamiento</label>
                <select class="form-control" id="txtFraccionamientoB2" name="txtFraccionamientoB2"></select>
            </div>
        </div>
    </div>
</div>
            <hr>
            <button type="submit" class="btn btn-primary btn-block" id="btnReingresarEmpleado">ENVIAR CAMBIOS <i class="far fa-save"></i></button>
            <br>
        </form>
    </div>
</div>