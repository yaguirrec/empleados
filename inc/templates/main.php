<section>
    <div class="row">
      <div class="col-md-2 bg-lateral menu">
        <div class="avatar text-center">
          <figure>
            <img class="rounded-circle" width="100" src="https://pbs.twimg.com/profile_images/929030268043845633/ilS1ri2v.jpg" alt="Imagen admin">
          </figure>
          <div class="tittle">
            <small>Bienvenido a eliceWeb</small><br>
            <span>Marshall Bruce Mathers III</span>
          </div>
          <br>
          <div class="btn-group" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-success"><i class="fas fa-user-circle"></i></button>
            <button type="button" class="btn btn-info"><i class="fas fa-cog"></i></button>
            <a role="button" href="../" class="btn btn-danger"><i class="fas fa-power-off"></i></a>
          </div>
        </div>
        <!-- FIN DEL AVATAR -->
        <nav class="text-center">
          <div id="accordion" role="tablist" aria-multiselecttable="true">
            <div class="card btn-block">
              <div class="card-header" role="tab" id="#">
                <h5 class="mb-0">
                  <a href="#" data-toggle="collapse" data-parent="#accordion" aria-expanded="true" aria-controls="#">
                    Tablero
                  </a>
                </h5>
              </div>
            </div>
          </div>

          <div id="accordion" role="tablist" aria-multiselecttable="true">
            <div class="card">
              <div class="card-header" role="tab" id="first">
                <h5 class="mb-0">
                  <a href="#tab-first" data-toggle="collapse" data-parent="#accordion" aria-expanded="true" aria-controls="first">
                    Empleados
                  </a>
                </h5>
              </div>
            </div>
          </div>

          <div id="tab-first" class="collapse show" role="tabpanel" aria-labelledby="first">
            <div class="card-block">
              <div class="list-group">
                <a href="" class="list-group-item list-group-item-action">Consultar</a>
                <a href="" class="list-group-item list-group-item-action">Nuevo</a>
                <a href="" class="list-group-item list-group-item-action">Actualizar</a>
                <a href="" class="list-group-item list-group-item-action">Baja</a>
              </div>
            </div>
          </div>

          <div id="accordion" role="tablist" aria-multiselecttable="true">
            <div class="card">
              <div class="card-header" role="tab" id="second">
                <h5 class="mb-0">
                  <a href="#tab-second" data-toggle="collapse" data-parent="#accordion" aria-expanded="true" aria-controls="second">
                    Procesos
                  </a>
                </h5>
              </div>
            </div>
          </div>

          <div id="tab-second" class="collapse" role="tabpanel" aria-labelledby="second">
            <div class="card-block">
              <div class="list-group">
                <a href="" class="list-group-item list-group-item-action">Consultar</a>
                <a href="" class="list-group-item list-group-item-action">Nuevo</a>
                <a href="" class="list-group-item list-group-item-action">Actualizar</a>
                <a href="" class="list-group-item list-group-item-action">Baja</a>
              </div>
            </div>
          </div>

        </nav>
        <!-- FIN NAV BAR -->
      </div>
      
      <div class="col-md-10 offset-md-2">
        <p class="text-center mt-1">
          <img src="<?php echo SERVERURL; ?>img/whiteLogo.png" width="300" alt="Logo MEXQ" class="responsive-img">
        </p>
        <?php include 'inc/templates/panel.php'; ?>
      </div>
    </div>
</section>