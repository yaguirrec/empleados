<head>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <button class="btn text-white" id="menu-toggle"><i class="fas fa-ellipsis-v"></i></button>
    <?php $var1 = $request[1]; ?>

    <!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
        <li class="nav-item active">
          <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Dropdown
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="#">Empleados</a>
            <a class="dropdown-item" href="#">Acciones</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">salir</a>
          </div>
        </li>
      </ul>
    </div> -->
  </nav>
</head>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Panel</a></li>
    <li class="breadcrumb-item text-capitalize active" aria-current="page" id="nombreSeccion"><?php echo $var1;?></li>
  </ol>
</nav>