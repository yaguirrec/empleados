<div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    <div class="bg-dark" id="sidebar-wrapper">
      <div class="sidebar-heading">
        <div class="avatar text-center">
          <figure>
            <img src="img/whiteLogo.png" width="150" alt="Logo MEXQ" class="responsive-img mb-2">
            <br>
            <img class="rounded-circle" width="150" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR95Ahbudl_KiZlmMVMh_9yVp9sNO_O-oJWO9Kgw410e85xPB0B" alt="Imagen admin">
          </figure>
          <div class="tittle d-none d-lg-block">
            <p class="text-muted">Bienvenido a EliceWeb</p>
            <p class="text-muted"><?php echo $_SESSION['usuario_nombre'] ?></p>
          </div>
          <br>
          <div class="btn-group" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-success"><i class="fas fa-user-circle"></i></button>
            <button type="button" class="btn btn-info"><i class="fas fa-cog"></i></button>
            <a role="button" class="btn btn-danger btnSalir"><i class="fas fa-power-off"></i></a>
          </div>
        </div>
      </div>

      <div class="list-group list-group-flush">
      <nav class="text-center" id="sidebar">
          
          <div id="accordion" role="tablist" aria-multiselecttable="true">
            <div class="card-block">
              <div class="card-header" role="tab" id="#">
                <h5 class="mb-0">
                  <a href="index.php?request=tablero">
                    Tablero
                  </a>
                </h5>
              </div>
            </div>
          </div>

          <div id="accordion" role="tablist" aria-multiselecttable="true">
            <div class="card-block">
              <div class="card-header" role="tab" id="first">
                <h5 class="mb-0">
                  <a href="#tab-first" data-toggle="collapse" data-parent="#accordion" aria-expanded="true" aria-controls="first">
                    Ver Empleados
                  </a>
                </h5>
              </div>
            </div>
          </div>

          <div id="tab-first" class="collapse" role="tabpanel" aria-labelledby="first">
            <div class="card-block">
              <div class="list-group">
                <a href="index.php?request=empleado" class="list-group-item list-group-item-action">Activos</a>
                <a href="index.php?request=bajas" class="list-group-item list-group-item-action">Bajas</a>
                <a href="" class="list-group-item list-group-item-action">Actualizar</a>
                <a href="" class="list-group-item list-group-item-action">Baja</a>
              </div>
            </div>
          </div>

          <div id="accordion" role="tablist" aria-multiselecttable="true">
            <div class="card-block">
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

      </div>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">

      <?php include 'inc/templates/header.php'; ?>

      <div class="container-fluid">

      <!-- CONTENT LATERAL MENU -->
      