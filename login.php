<?php
session_start();
include 'inc/templates/header.php';
?>

<body class="bg-gradient-primary">

  <div class="container card-login">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!--  Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Ingreso al sitio!</h1>
                  </div>
                  <form class="user" id="loginForm">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" id="txtNomina" placeholder="Número de nomina" autofocus>
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" id="txtClave" placeholder="Clave de acceso">
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block text-white">
                      Ingresar
                    </button>
                    <input type="hidden" id="type" value="login">
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="http://187.189.66.23:8090/Mexqintra/RH/inicio/index.php">Olvidaste tu clave?</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>
</body>

<?php
include 'inc/templates/footer.php';
?>