<div class="card-body">
    <div class="card-header py-3">
        <h2 class="m-0 font-weight-bold text-secondary text-center text-uppercase seccionTitulo"></h2>
    </div>
    <div class="row encabezado_encuesta">
        <table class="table table-sm text-uppercase card-text px-5">
            <tbody>
                <tr>
                    <th width="20%">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Numero de nomina" id="numero_nomina">
                        <div class="input-group-append">
                            <button class="btn btn-outline-info" type="button" id="btn-nomina-esalida">Buscar</button>
                        </div>
                        </div>
                    </th>
                    <th>Nombre:</th>
                    <td><dd id="txtNombre"></dd></td>
                    <th>Puesto:</th>
                    <td><dd id="txtPuesto"></dd></td>
                </tr>
                <tr>
                    <th>Planta / Departamento:</th>
                    <td><dd id="txtCelula"></dd></td>
                    <th>Jefe Directo:</th>
                    <td><dd id="txtJefe"></dd></td>
                    <th>Estado:</th>
                    <td><dd id="txtEstado"></dd></td>
                </tr>
            </tbody>
        </table>
    </div>

    <hr>

    <div class="row mt-1 contenido_encuesta d-none">
        <br>
        <div>
            <h4 class="bg-primary text-white">1.-¿Cuál es el principal motivo de tu renuncia?</h6>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="r_pregunta_1" id="exampleRadios1" value="Sueldo y prestaciones">
                <label class="form-check-label" for="exampleRadios1">
                    1) Sueldo y prestaciones
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="r_pregunta_1" id="exampleRadios2" value="Desarrollo profesional">
                <label class="form-check-label" for="exampleRadios2">
                    2) Desarrollo profesional
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="r_pregunta_1" id="exampleRadios3" value="Problemas de Pago">
                <label class="form-check-label" for="exampleRadios3">
                    3) Problemas de Pago
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="r_pregunta_1" id="exampleRadios4" value="Trato de Jefe Directo">
                <label class="form-check-label" for="exampleRadios4">
                    4) Trato de Jefe Directo 
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="r_pregunta_1" id="exampleRadios5" value="Motivos Personales">
                <label class="form-check-label" for="exampleRadios5">
                    5) Motivos Personales
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="r_pregunta_1" id="exampleRadios6" value="Otro">
                <label class="form-check-label" for="exampleRadios6">
                    6) Otro
                </label>
            </div>
        </div>
        <br>
    </div>
    <br>
    <div class="row mx-4">
        <div class="opc_1_preg_1 d-none">
            <h5 class="bg-primary text-white">Sueldo y prestaciones:</h5>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="sr_pregunta_1" value="No me gusto el horario laboral">
                <label class="form-check-label">
                    1) No me gusto el horario laboral
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="sr_pregunta_1" value="La información del sueldo no fue clara en mi contratación">
                <label class="form-check-label">
                    2) La información del sueldo no fue clara en mi contratación
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="sr_pregunta_1" value="Mis gastos son mayores a mi sueldo">
                <label class="form-check-label">
                    3) Mis gastos son mayores a mi sueldo
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="sr_pregunta_1" value="Me ofrecieron un sueldo mayor en otro lugar">
                <label class="form-check-label">
                    4) Me ofrecieron un sueldo mayor en otro lugar
                </label>
            </div>
        </div>
        <div class="opc_2_preg_1 d-none">
            <h5 class="bg-primary text-white">Desarrollo profesional:</h5>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="sr_pregunta_1" value="Me senti estancado en mi puesto actual">
                <label class="form-check-label">
                    1) Me senti estancado en mi puesto actual
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="sr_pregunta_1" value="Tiempo de espera para ascender a un puesto">
                <label class="form-check-label">
                    2) Tiempo de espera para ascender a un puesto
                </label>
            </div>
        </div>
        <div class="opc_3_preg_1 d-none">
            <p>Problemas de Pago</p>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="sr_pregunta_1" value="Falta de pagos">
                <label class="form-check-label">
                    1) Falta de pagos
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="sr_pregunta_1" value="No se realizaron mis cambios de categoría">
                <label class="form-check-label">
                    2) No se realizaron mis cambios de categoría
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="sr_pregunta_1" value="No se solucionaron mis requerimientos en Tiempo y forma">
                <label class="form-check-label">
                    3) No se solucionaron mis requerimientos en Tiempo y forma 
                </label>
            </div>
        </div>
        <div class="opc_4_preg_1 d-none">
            <h5 class="bg-primary text-white">Trato de Jefe directo:</h5>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="sr_pregunta_1" value="Constantemente me cambian de planta">
                <label class="form-check-label">
                    1) Constantemente me cambian de planta
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="sr_pregunta_1" value="Falta de comunicación (no indicaba horarios, turno, días de descanso, ruta de transporte)">
                <label class="form-check-label">
                    2) Falta de comunicación (no indicaba horarios, turno, días de descanso, ruta de transporte)
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="sr_pregunta_1" value="Formas de expresión (Manera en que solicitaba las cosas, la forma en que se dirigia hacia mi, etc.)">
                <label class="form-check-label">
                    3) Formas de expresión (Manera en que solicitaba las cosas, la forma en que se dirigia hacia mi, etc.)
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="sr_pregunta_1" value="No me capacitaron">
                <label class="form-check-label">
                    4) No me capacitaron
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="sr_pregunta_1" value="No reconocen mi logros">
                <label class="form-check-label">
                    5) No reconocen mi logros
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="sr_pregunta_1" value="Preferencias en el área de trabajo">
                <label class="form-check-label">
                    6) Preferencias en el área de trabajo
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="sr_pregunta_1" value="Promesas de aumentos de sueldo no cumplidas">
                <label class="form-check-label">
                    7) Promesas de aumentos de sueldo no cumplidas
                </label>
            </div>
        </div>
        
        <div class="opc_5_preg_1 d-none">
            <h5 class="bg-primary text-white">Motivos Personales:</h5>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="sr_pregunta_1" value="Cambio de residencia">
                <label class="form-check-label">
                    1) Cambio de residencia
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="sr_pregunta_1" value="Cuidar a mis hijos">
                <label class="form-check-label">
                    2) Cuidar a mis hijos
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="sr_pregunta_1" value="Enfermedad de un familiar">
                <label class="form-check-label">
                    3) Enfermedad de un familiar
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="sr_pregunta_1" value="Ingreso a la estudiar">
                <label class="form-check-label">
                    4) Ingreso a la estudiar
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="sr_pregunta_1" value="Matrimonio">
                <label class="form-check-label">
                    5) Matrimonio
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="sr_pregunta_1" value="Muerte de un familiar">
                <label class="form-check-label">
                    6) Muerte de un familiar
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="sr_pregunta_1" value="Salud Personal">
                <label class="form-check-label">
                    7) Salud Personal
                </label>
            </div>
        </div>
        <div class="opc_6_preg_1 d-none">
            <h5 class="bg-primary text-white">Otro motivo:</h5>
            <input type="text" class="form-control" id="sr_pregunta_1" placeholder="Otro Motivo">
        </div>
    </div>
    <div class="row mt-1 contenido_encuesta d-none">
        <br>
        <h4 class="bg-primary text-white">2.-¿Cuál fue tu grado de satisfacción en MexQ  con las siguientes descripciones?</h4>
        <br><br>
        <table class="table table-striped">
            <thead class="alert-info">
                <tr>
                <th scope="col">Descripcion</th>
                <th scope="col">Grado de Satisfaccion</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <th scope="row">Sueldo y Prestaciones</th>
                <td>
                    <div class="form-group">
                        <select class="form-control" id="pregunta2_r1">
                        <option value="excelente">Excelente</option>
                        <option value="bueno">Bueno</option>
                        <option value="regular">Regular</option>
                        <option value="malo">Malo</option>
                        <option value="muy malo">Muy malo</option>
                        </select>
                    </div>
                </td>
                </tr>
                <tr>
                <th scope="row">Ambiente Laboral</th>
                <td>
                    <div class="form-group">
                        <select class="form-control" id="pregunta2_r2">
                        <option value="excelente">Excelente</option>
                        <option value="bueno">Bueno</option>
                        <option value="regular">Regular</option>
                        <option value="malo">Malo</option>
                        <option value="muy malo">Muy malo</option>
                        </select>
                    </div>
                </td>
                </tr>
                <tr>
                <th scope="row">Trato de Jefe directo</th>
                <td>
                    <div class="form-group">
                        <select class="form-control" id="pregunta2_r3">
                        <option value="excelente">Excelente</option>
                        <option value="bueno">Bueno</option>
                        <option value="regular">Regular</option>
                        <option value="malo">Malo</option>
                        <option value="muy malo">Muy malo</option>
                        </select>
                    </div>
                </td>
                </tr>
                <tr>
                <th scope="row">Tiempo de respuesta a requerimientos (dudas de pago, solicitud de cartas, etc.)</th>
                <td>
                    <div class="form-group">
                        <select class="form-control" id="pregunta2_r4">
                        <option value="excelente">Excelente</option>
                        <option value="bueno">Bueno</option>
                        <option value="regular">Regular</option>
                        <option value="malo">Malo</option>
                        <option value="muy malo">Muy malo</option>
                        </select>
                    </div>
                </td>
                </tr>
                <tr>
                <th scope="row">Equipo de protección Personal / Uniforme</th>
                <td>
                    <div class="form-group">
                        <select class="form-control" id="pregunta2_r5">
                        <option value="excelente">Excelente</option>
                        <option value="bueno">Bueno</option>
                        <option value="regular">Regular</option>
                        <option value="malo">Malo</option>
                        <option value="muy malo">Muy malo</option>
                        </select>
                    </div>
                </td>
                </tr>
                <tr>
                <th scope="row">Condiciones en área del trabajo</th>
                <td>
                    <div class="form-group">
                        <select class="form-control" id="pregunta2_r6">
                        <option value="excelente">Excelente</option>
                        <option value="bueno">Bueno</option>
                        <option value="regular">Regular</option>
                        <option value="malo">Malo</option>
                        <option value="muy malo">Muy malo</option>
                        </select>
                    </div>
                </td>
                </tr>
                <tr>
                <th scope="row">Trato del personal Administrativo</th>
                <td>
                    <div class="form-group">
                        <select class="form-control" id="pregunta2_r7">
                        <option value="excelente">Excelente</option>
                        <option value="bueno">Bueno</option>
                        <option value="regular">Regular</option>
                        <option value="malo">Malo</option>
                        <option value="muy malo">Muy malo</option>
                        </select>
                    </div>
                </td>
                </tr>
                <tr>
                <th scope="row">Plan de Desarrollo (Capacitación)</th>
                <td>
                    <div class="form-group">
                        <select class="form-control" id="pregunta2_r8">
                        <option value="excelente">Excelente</option>
                        <option value="bueno">Bueno</option>
                        <option value="regular">Regular</option>
                        <option value="malo">Malo</option>
                        <option value="muy malo">Muy malo</option>
                        </select>
                    </div>
                </td>
                </tr>
                <tr>
                <th scope="row">Programa MexQ Premia (Plan de puntos)</th>
                <td>
                    <div class="form-group">
                        <select class="form-control" id="pregunta2_r9">
                        <option value="excelente">Excelente</option>
                        <option value="bueno">Bueno</option>
                        <option value="regular">Regular</option>
                        <option value="malo">Malo</option>
                        <option value="muy malo">Muy malo</option>
                        <option value="na">NA</option>
                        </select>
                    </div>
                </td>
                </tr>
                <tr>
                <th scope="row">Servicio de Transporte</th>
                <td>
                    <div class="form-group">
                        <select class="form-control" id="pregunta2_r10">
                        <option value="excelente">Excelente</option>
                        <option value="bueno">Bueno</option>
                        <option value="regular">Regular</option>
                        <option value="malo">Malo</option>
                        <option value="muy malo">Muy malo</option>
                        <option value="na">NA</option>
                        </select>
                    </div>
                </td>
                </tr>
                <tr>
                <th scope="row">En general con MEXQ</th>
                <td>
                    <div class="form-group">
                        <select class="form-control" id="pregunta2_r11">
                        <option value="excelente">Excelente</option>
                        <option value="bueno">Bueno</option>
                        <option value="regular">Regular</option>
                        <option value="malo">Malo</option>
                        <option value="muy malo">Muy malo</option>
                        </select>
                    </div>
                </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="row mt-1 contenido_encuesta d-none">
        <br>
        <label for="r_pregunta_3"><h4 class="bg-primary text-white">3.-¿Qué fue lo que más te gustó de MEXQ?</h4></label>
        <input type="text" class="form-control" id="r_pregunta_3" placeholder="Su respuesta">
    </div>   
    <div class="row mt-1 contenido_encuesta d-none">
        <br>
        <label for="r_pregunta_4"><h4 class="bg-primary text-white">4.-¿Qué fue lo que menos te gustó de MEXQ?</h4></label>
        <input type="text" class="form-control" id="r_pregunta_4" placeholder="Su respuesta">
    </div>  
    <div class="row mt-1 contenido_encuesta d-none">
        <br>
        <h4 class="bg-primary text-white">5.-¿Cuál es el tiempo de trayecto de tu casa a tu lugar de trabajo?</h4>
    </div>
    <div class="row mt-1 contenido_encuesta d-none">
        <br>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="r_pregunta_5" value="30 - 60 min">
                <label class="form-check-label">
                    A) 30 - 60 min
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="r_pregunta_5" value="60 - 90 min">
                <label class="form-check-label">
                    B) 60 - 90 min
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="r_pregunta_5" value="90 - 120 min">
                <label class="form-check-label">
                    3) 90 - 120 min
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="r_pregunta_5" value="Más de 120 min">
                <label class="form-check-label">
                    4) Más de 120 min
                </label>
            </div>
    </div>  
    <div class="row mt-1 contenido_encuesta d-none">
        <label for="r_pregunta_6"><h4 class="bg-primary text-white">6.-¿Qué hubiéramos podido hacer para que te quedaras en MEXQ?</h4></label>
        <input type="text" class="form-control" id="r_pregunta_6" placeholder="Su respuesta">
    </div>
    <div class="mt-1 text-left contenido_encuesta d-none">
        <br>
        <h3 class="bg-success text-white">Las siguientes preguntas son OPCIONALES para su contestación</h3>
    </div>  
    <div class="row mt-1 contenido_encuesta d-none">
        <br>
        <label for="r_pregunta_7"><h4 class="bg-primary text-white">7.-¿Ya tienes otro trabajo?</h4></label>
    </div>
    <div class="row mt-1 contenido_encuesta d-none">
            <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" id="p7opc1" name="r_pregunta_7" value="SI">
                <label class="custom-control-label" for="p7opc1">Si</label>
            </div>
            <div class="custom-control custom-radio mb-3">
                <input type="radio" class="custom-control-input" id="p7opc2" name="r_pregunta_7" value="NO">
                <label class="custom-control-label" for="p7opc2">No</label>
            </div>
    </div>
    <div class="row mt-1 opc_1_preg_7 d-none">
    <form>
        <div class="form-group">
            <h5 class="bg-primary text-white">¿Donde?</h5>
            <input type="text" class="form-control" id="sr_pregunta_7" aria-describedby="emailHelp">
        </div>
        <div class="form-group">
            <br>
            <label for="r_pregunta_8"><h4 class="bg-primary text-white">8.-¿Tus horarios son mas flexibles?</h4></label>
            <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" id="p8opc1" name="r_pregunta_8" value="SI">
                <label class="custom-control-label" for="p8opc1">Si</label>
            </div>
            <div class="custom-control custom-radio mb-3">
                <input type="radio" class="custom-control-input" id="p8opc2" name="r_pregunta_8" value="NO">
                <label class="custom-control-label" for="p8opc2">No</label>
            </div>
            <label for="sr_pregunta_8"><h5 class="bg-primary text-white">¿Cuales son tus horarios?</h5></label>
            <input type="text" class="form-control" id="sr_pregunta_8">
            <br>
            <label for="r_pregunta_9">9.-¿Cuál sera tu sueldo?</label>
            <input type="text" class="form-control" id="r_pregunta_9">
            <br>
            <label for="r_pregunta_10"><h4 class="bg-primary text-white">10.-¿Tendrás otras Prestaciones?</h4></label>
            <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" id="p10opc1" name="r_pregunta_10" value="SI">
                <label class="custom-control-label" for="p10opc1">Si</label>
            </div>
            <div class="custom-control custom-radio mb-3">
                <input type="radio" class="custom-control-input" id="p10opc2" name="r_pregunta_10" value="NO">
                <label class="custom-control-label" for="p10opc2">No</label>
            </div>
            <label for="sr_pregunta_10"><h5 class="bg-primary text-white">¿Cómo cuales?</h5></label>
            <input type="text" class="form-control" id="sr_pregunta_10">
        </div>
        
    </form>
    
    </div>  
    <div class="row mt-1 contenido_encuesta d-none">
        <br>
        <label for="r_telefono"><h4 class="bg-primary text-white">Telefono de contacto:</h4></label>
        <input type="text" class="form-control" id="r_telefono" placeholder="Favor de poner un número de contacto">
    </div>  
    <br><br>
    <div class="row mt-1 contenido_encuesta d-none">
        <button class="btn btn-info btn-block btn-sm btnguardarENC">GUARDAR <i class="fas fa-save"></i></button>
        <!-- <button href="javascript:history.back();" class="btn btn-warning btn-block btn-sm">Regresar <i class="fas fa-undo-alt"></i></button> -->
    </div>
</div>