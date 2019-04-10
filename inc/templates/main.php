<div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    <div class="bg-dark" id="sidebar-wrapper">
      <div class="sidebar-heading">
        <div class="avatar text-center">
          <figure>
            <img src="<?php echo SERVERURL; ?>img/whiteLogo.png" width="150" alt="Logo MEXQ" class="responsive-img mb-2">
            <br>
            <img class="rounded-circle" width="150" src="https://pbs.twimg.com/profile_images/929030268043845633/ilS1ri2v.jpg" alt="Imagen admin">
          </figure>
          <div class="tittle d-none d-lg-block">
            <p class="text-muted">Bienvenido a EliceWeb</p>
            <p class="text-muted">Marshall Bruce Mathers III</p>
          </div>
          <br>
          <div class="btn-group" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-success"><i class="fas fa-user-circle"></i></button>
            <button type="button" class="btn btn-info"><i class="fas fa-cog"></i></button>
            <a role="button" href="../empleados/" class="btn btn-danger"><i class="fas fa-power-off"></i></a>
          </div>
        </div>
      </div>

      

      <div class="list-group list-group-flush">
      <nav class="text-center" id="sidebar">
          
          <div id="accordion" role="tablist" aria-multiselecttable="true">
            <div class="card-block">
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
            <div class="card-block">
              <div class="card-header" role="tab" id="first">
                <h5 class="mb-0">
                  <a href="#tab-first" data-toggle="collapse" data-parent="#accordion" aria-expanded="true" aria-controls="first">
                    Empleados
                  </a>
                </h5>
              </div>
            </div>
          </div>

          <div id="tab-first" class="collapse" role="tabpanel" aria-labelledby="first">
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

      <table class="table table-hover table-dark mt-5">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">First</th>
            <th scope="col">Last</th>
            <th scope="col">Handle</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">1</th>
            <td>Mark</td>
            <td>Otto</td>
            <td>@mdo</td>
          </tr>
          <tr>
            <th scope="row">2</th>
            <td>Jacob</td>
            <td>Thornton</td>
            <td>@fat</td>
          </tr>
          <tr>
            <th scope="row">3</th>
            <td colspan="2">Larry the Bird</td>
            <td>@twitter</td>
          </tr>
        </tbody>
      </table>
      </div>
    </div>
    <!-- /#page-content-wrapper -->

  </div>
  <!-- /#wrapper -->

<script>
  $("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
  });
</script>
